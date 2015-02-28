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
                'order' => array('License.submitted' => 'DESC'),
                'joins' => array(
                    array(
                        'table' => 'categories_licenses',
                        'alias' => 'CategoriesLicense',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Drug.license_id = CategoriesLicense.license_id',
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
            'order' => array('License.submitted' => 'DESC'),
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
                        'Drug.license_id LIKE' => "%{$keyword}%",
                        'Drug.manufacturer LIKE' => "%{$keyword}%",
                        'License.name LIKE' => "%{$keyword}%",
                        'License.name_english LIKE' => "%{$keyword}%",
                        'License.vendor LIKE' => "%{$keyword}%",
                        'License.ingredient LIKE' => "%{$keyword}%",
                        'License.nhi_id LIKE' => "%{$keyword}%",
                    );
                }
            }
        }
        $this->paginate['Drug'] = array(
            'limit' => 20,
            'contain' => array('License'),
            'order' => array('License.submitted' => 'DESC'),
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

    public function auto() {
        $this->jsonData = array();
        if (!empty($_GET['term'])) {
            $keyword = trim(Sanitize::clean($_GET['term']));
            $items = $this->Drug->find('all', array(
                'contain' => array('License'),
                'fields' => array('Drug.id', 'Drug.license_id',
                    'License.license_id', 'License.name', 'License.name_english'),
                'conditions' => array(
                    'OR' => array(
                        'License.name LIKE' => "%{$keyword}%",
                        'License.name_english LIKE' => "%{$keyword}%",
                        'License.license_id LIKE' => "%{$keyword}%",
                    ),
                ),
                'limit' => 20,
            ));
            foreach ($items AS $item) {
                $this->jsonData[] = array(
                    'label' => "[{$item['License']['license_id']}]{$item['License']['name']}({$item['License']['name_english']})",
                    'value' => $item['Drug']['id'],
                    'license_id' => $item['Drug']['license_id'],
                    'name' => $item['License']['name'],
                    'name_english' => $item['License']['name_english'],
                );
            }
        }
    }

}
