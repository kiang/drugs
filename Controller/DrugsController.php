<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class DrugsController extends AppController {

    public $name = 'Drugs';
    public $paginate = array();
    public $helpers = array('Olc');

    public function beforeFilter() {
        parent::beforeFilter();
        if (isset($this->Auth)) {
            $this->Auth->allow('index', 'view', 'outward');
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
        if (!empty($this->request->params['paging']['Drug']['page'])) {
            $path .= '/page:' . $this->request->params['paging']['Drug']['page'];
        }
        $this->set('apiRoute', $path);
    }

    public function category($categoryId = 0) {
        $categoryId = intval($categoryId);
        if ($categoryId > 0) {
            $category = $this->Drug->License->Category->find('first', array(
                'conditions' => array('Category.id' => $categoryId),
            ));
        }
        if (!empty($category)) {
            $scope = array(
                'Category.lft >=' => $category['Category']['lft'],
                'Category.rght <=' => $category['Category']['rght'],
            );
            $this->paginate['Drug'] = array(
                'limit' => 20,
                'order' => array('Drug.submitted' => 'DESC'),
                'joins' => array(
                    array(
                        'table' => 'categories_licenses',
                        'alias' => 'CategoriesLicense',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Drug.license_uuid = CategoriesLicense.license_id',
                        ),
                    ),
                    array(
                        'table' => 'categories',
                        'alias' => 'Category',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Category.id = CategoriesLicense.category_id',
                        ),
                    ),
                ),
                'group' => array('Drug.id'),
            );
            $parents = $this->Drug->License->Category->getPath($categoryId, array('id', 'name'));
            $this->set('url', array($categoryId));
            $this->set('category', $category);
            $this->set('parents', $parents);
            $this->set('children', $this->Drug->License->Category->find('all', array(
                        'fields' => array('id', 'name'),
                        'conditions' => array('Category.parent_id' => $categoryId),
            )));
            $this->set('items', $this->paginate($this->Drug, $scope));
            $this->set('title_for_layout', implode(' > ', Set::extract('{n}.Category.name', $parents)) . ' 藥品一覽 @ ');
        } else {
            $this->Session->setFlash('請依據網頁指示操作');
            $this->redirect(array('action' => 'index'));
        }
    }

    public function outward($name = null) {
        $scope = array();
        if (!empty($name)) {
            $name = Sanitize::clean($name);
            $name = str_replace('色', '', $name);
            $keywords = explode(' ', $name);
            $keywordCount = 0;
            foreach ($keywords AS $keyword) {
                if (++$keywordCount < 5) {
                    $scope[]['OR'] = array(
                        'License.shape LIKE' => "%{$keyword}%",
                        'License.color LIKE' => "%{$keyword}%",
                        'License.odor LIKE' => "%{$keyword}%",
                        'License.abrasion LIKE' => "%{$keyword}%",
                        'License.note_1 LIKE' => "%{$keyword}%",
                        'License.note_2 LIKE' => "%{$keyword}%",
                    );
                }
            }
        }
        $this->paginate['Drug'] = array(
            'limit' => 20,
            'contain' => array('License'),
            'order' => array('Drug.submitted' => 'DESC'),
        );
        $this->set('url', array($name));
        $title = '';
        if (!empty($name)) {
            $title = "{$name} 相關";
        }
        $this->set('title_for_layout', $title . '藥品一覽 @ ');
        $this->set('items', $this->paginate($this->Drug, $scope));
        $this->set('keyword', $name);
    }

    function index($name = null) {
        $scope = array();
        if (!empty($name)) {
            $name = Sanitize::clean($name);
            $keywords = explode(' ', $name);
            $keywordCount = 0;
            foreach ($keywords AS $keyword) {
                if (++$keywordCount < 5) {
                    $scope[]['OR'] = array(
                        'Drug.name LIKE' => "%{$keyword}%",
                        'Drug.name_english LIKE' => "%{$keyword}%",
                        'Drug.license_id LIKE' => "%{$keyword}%",
                        'Drug.vendor LIKE' => "%{$keyword}%",
                        'Drug.manufacturer LIKE' => "%{$keyword}%",
                        'Drug.ingredient LIKE' => "%{$keyword}%",
                        'License.nhi_id LIKE' => "%{$keyword}%",
                    );
                }
            }
        }
        $this->paginate['Drug'] = array(
            'limit' => 20,
            'contain' => array('License'),
            'order' => array('Drug.submitted' => 'DESC'),
        );
        $this->set('url', array($name));
        $title = '';
        if (!empty($name)) {
            $title = "{$name} 相關";
        }
        $this->set('title_for_layout', $title . '藥品一覽 @ ');
        $this->set('items', $this->paginate($this->Drug, $scope));
        $this->set('keyword', $name);
    }

    function view($id = null) {
        if (!empty($id)) {
            $this->data = $this->Drug->find('first', array(
                'conditions' => array('Drug.id' => $id),
                'contain' => array(
                    'License' => array(
                        'Category' => array(
                            'fields' => array('code', 'name', 'name_chinese'),
                        ),
                    ),
                ),
            ));
        }
        if (empty($this->data)) {
            $this->Session->setFlash(__('Please do following links in the page', true));
            $this->redirect(array('action' => 'index'));
        } else {
            $categoryNames = array();
            foreach ($this->data['License']['Category'] AS $k => $category) {
                $categoryNames[$category['CategoriesLicense']['category_id']] = $this->Drug->License->Category->getPath($category['CategoriesLicense']['category_id'], array('id', 'name'));
            }
            $this->set('title_for_layout', "{$this->data['Drug']['name']} {{$this->data['Drug']['name_english']}} @ ");
            $this->set('desc_for_layout', "{$this->data['Drug']['name']} {$this->data['Drug']['name_english']} / {$this->data['Drug']['disease']} / ");
            $this->set('prices', $this->Drug->License->Price->find('all', array(
                        'conditions' => array('Price.license_id' => $this->data['Drug']['license_uuid']),
                        'order' => array(
                            'Price.nhi_id' => 'ASC',
                            'Price.date_end' => 'DESC',
                        ),
            )));
            $this->set('links', $this->Drug->License->Link->find('all', array(
                        'conditions' => array('Link.license_id' => $this->data['Drug']['license_uuid']),
                        'fields' => array('url', 'title'),
                        'order' => array(
                            'Link.type' => 'ASC',
                            'Link.sort' => 'ASC',
                        ),
            )));
            $this->set('ingredients', $this->Drug->License->Ingredient->find('all', array(
                        'conditions' => array('Ingredient.license_id' => $this->data['Drug']['license_uuid']),
                        'fields' => array('remark', 'name', 'dosage', 'dosage_text', 'unit'),
                        'order' => array(
                            'Ingredient.dosage' => 'DESC',
                        ),
            )));
            $this->set('drugs', $this->Drug->find('all', array(
                        'fields' => array(
                            'id', 'manufacturer', 'manufacturer_country', 'manufacturer_description'
                        ),
                        'conditions' => array(
                            'Drug.license_uuid' => $this->data['Drug']['license_uuid'],
                            'Drug.id !=' => $this->data['Drug']['id'],
                        ),
            )));
            $this->set('categoryNames', $categoryNames);
        }
    }

}
