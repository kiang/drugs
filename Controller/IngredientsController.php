<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class IngredientsController extends AppController {

    public $name = 'Ingredients';
    public $uses = array('Ingredient');
    public $paginate = array();
    public $helpers = array();

    public function beforeFilter() {
        parent::beforeFilter();
        if (isset($this->Auth)) {
            $this->Auth->allow('index', 'view');
        }
    }

    public function beforeRender() {
        $path = "/api/{$this->request->params['controller']}/{$this->request->params['action']}";
        if (!empty($this->request->params['pass'][0])) {
            $path .= '/' . $this->request->params['pass'][0];
        }
        if (!empty($this->request->params['named'])) {
            foreach ($this->request->params['named'] AS $k => $v) {
                if ($k !== 'page') {
                    $path .= "/{$k}:{$v}";
                }
            }
        }
        if (!empty($this->request->params['paging']['Ingredient']['page'])) {
            $path .= '/page:' . $this->request->params['paging']['Ingredient']['page'];
        } elseif (!empty($this->request->params['paging']['License']['page'])) {
            $path .= '/page:' . $this->request->params['paging']['License']['page'];
        }
        $this->set('apiRoute', $path);
    }

    public function index($name = null) {
        $scope = array();
        if (!empty($name)) {
            $name = Sanitize::clean($name);
            $keywords = explode(' ', $name);
            $keywordCount = 0;
            foreach ($keywords AS $keyword) {
                if (++$keywordCount < 5) {
                    $scope[]['OR'] = array(
                        'Ingredient.name LIKE' => "%{$keyword}%",
                    );
                }
            }
        }
        $this->paginate['Ingredient'] = array(
            'limit' => 20,
            'order' => array(
                'Ingredient.count_daily' => 'DESC',
                'Ingredient.count_all' => 'DESC',
                'Ingredient.count_licenses' => 'DESC',
            ),
        );
        $this->set('url', array($name));
        $title = '';
        if (!empty($name)) {
            $title = "{$name} 相關";
        }
        $this->set('title_for_layout', $title . '藥品成份一覽 @ ');
        $this->set('items', $this->paginate($this->Ingredient, $scope));
        $this->set('ingredientKeyword', $name);
    }

    public function view($id = null) {
        if (!empty($id)) {
            $ingredient = $this->Ingredient->find('first', array(
                'conditions' => array('id' => $id),
                'contain' => array(
                    'Article' => array(
                        'fields' => array('id', 'title', 'date_published', 'url'),
                        'order' => array('date_published' => 'DESC'),
                        'limit' => 10,
                    ),
                ),
            ));
        }
        if (!empty($ingredient)) {
            $this->Ingredient->counterIncrement($id);

            $this->set('ingredient', $ingredient);
            $this->paginate['License'] = array(
                'fields' => array(
                    'License.*', 'Drug.id'
                ),
                'limit' => 20,
                'joins' => array(
                    array(
                        'table' => 'ingredients_licenses',
                        'alias' => 'IngredientsLicense',
                        'type' => 'INNER',
                        'conditions' => array(
                            'License.id = IngredientsLicense.license_id',
                        ),
                    ),
                    array(
                        'table' => 'drugs',
                        'alias' => 'Drug',
                        'type' => 'INNER',
                        'conditions' => array(
                            'License.id = Drug.license_id',
                        ),
                    ),
                ),
                'group' => array('IngredientsLicense.license_id'),
            );
            $this->set('title_for_layout', "含有 {$ingredient['Ingredient']['name']} 成份的藥物 @ ");
            $this->set('items', $this->paginate($this->Ingredient->License, array('IngredientsLicense.ingredient_id' => $id)));
            $this->set('url', array($id));
        } else {
            $this->redirect(array('action' => 'index'));
        }
    }

}
