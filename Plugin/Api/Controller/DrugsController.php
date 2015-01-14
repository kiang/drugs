<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class DrugsController extends ApiAppController {

    var $uses = array('Drug');
    public $paginate = array();

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
                'contain' => array('License'),
            );
            $items = $this->paginate($this->Drug, $scope);
            foreach ($items AS $k => $v) {
                if (!empty($v['License']['image'])) {
                    $items[$k]['License']['image'] = Router::url('/' . $v['License']['image'], true);
                }
            }
            $this->jsonData = array(
                'meta' => array(
                    'paging' => $this->request->params['paging'],
                    'path' => $this->Drug->License->Category->getPath($categoryId),
                    'children' => $this->Drug->License->Category->find('all', array(
                        'conditions' => array('Category.parent_id' => $categoryId),
                    )),
                ),
                'data' => $items,
            );
        }
    }

    public function outward($term = null) {
        $scope = array();
        if (!empty($term)) {
            $term = Sanitize::clean($term);
            $term = str_replace('色', '', $term);
            $keywords = explode(' ', $term);
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
        $items = $this->paginate($this->Drug, $scope);
        foreach ($items AS $k => $v) {
            if (!empty($v['License']['image'])) {
                $items[$k]['License']['image'] = Router::url('/' . $v['License']['image'], true);
            }
        }

        $this->jsonData = array(
            'meta' => array(
                'paging' => $this->request->params['paging'],
            ),
            'data' => $items,
        );
    }

    public function index($term = '') {
        $scope = array();
        if (!empty($term)) {
            $term = Sanitize::clean($term);
            $keywords = explode(' ', $term);
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
        $items = $this->paginate($this->Drug, $scope);
        foreach ($items AS $k => $v) {
            if (!empty($v['License']['image'])) {
                $items[$k]['License']['image'] = Router::url('/' . $v['License']['image'], true);
            }
        }

        $this->jsonData = array(
            'meta' => array(
                'paging' => $this->request->params['paging'],
            ),
            'data' => $items,
        );
    }

    public function view($id = '') {
        if (!empty($id)) {
            $this->jsonData = $this->Drug->find('first', array(
                'conditions' => array(
                    'Drug.id' => $id,
                ),
                'contain' => array(
                    'License' => array(
                        'Category',
                        'Price',
                        'Link',
                        'Ingredient',
                    ),
                ),
            ));
            if (!empty($this->jsonData['License']['image'])) {
                $this->jsonData['License']['image'] = Router::url('/' . $this->jsonData['License']['image'], true);
            }
        }
    }

}
