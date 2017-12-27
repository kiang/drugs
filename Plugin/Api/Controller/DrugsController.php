<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class DrugsController extends ApiAppController {

    var $uses = array('Drug');
    public $paginate = array();

    public function category($categoryId = 0) {
        $categoryId = intval($categoryId);
        if ($categoryId > 0) {
            $cPage = isset($this->request->params['named']['page']) ? $this->request->params['named']['page'] : '1';
            $cacheKey = "DrugsCategory{$categoryId}{$cPage}";
            $result = Cache::read($cacheKey, 'long');
            if (!$result) {
                $result = $scope = array();
                $result['category'] = $this->Drug->License->Category->find('first', array(
                    'conditions' => array('Category.id' => $categoryId),
                ));
                if (!empty($result['category'])) {
                    $scope = array(
                        'Category.lft >=' => $result['category']['Category']['lft'],
                        'Category.rght <=' => $result['category']['Category']['rght'],
                    );

                    $this->paginate['License'] = array(
                        'fields' => array('name', 'name_english', 'license_id',
                            'ingredient', 'submitted', 'id'),
                        'limit' => 20,
                        'order' => array(
                            'License.count_daily' => 'DESC',
                            'License.count_all' => 'DESC',
                            'License.submitted' => 'DESC',
                        ),
                        'joins' => array(
                            array(
                                'table' => 'categories_licenses',
                                'alias' => 'CategoriesLicense',
                                'type' => 'INNER',
                                'conditions' => array(
                                    'License.id = CategoriesLicense.license_id',
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
                    );

                    $result['items'] = $this->paginate($this->Drug->License, $scope);
                    $result['paging'] = $this->request->params['paging'];

                    $drugIds = $this->Drug->find('list', array(
                        'fields' => array('license_id', 'id'),
                        'conditions' => array(
                            'license_id' => Set::extract('{n}.License.id', $result['items']),
                        ),
                    ));
                    foreach ($result['items'] AS $k => $v) {
                        $result['items'][$k]['Drug'] = array(
                            'id' => $drugIds[$v['License']['id']],
                        );
                    }
                    $result['parents'] = $this->Drug->License->Category->getPath($categoryId, array('id', 'name'));
                    $result['children'] = $this->Drug->License->Category->find('all', array(
                        'fields' => array('id', 'name'),
                        'conditions' => array('Category.parent_id' => $categoryId),
                    ));
                }

                Cache::write($cacheKey, $result, 'long');
            } else {
                $this->request->params['paging'] = $result['paging'];
            }
        }
        if (!empty($category)) {
            foreach ($result['items'] AS $k => $v) {
                if (!empty($v['License']['image'])) {
                    $result['items'][$k]['License']['image'] = Router::url('/' . $v['License']['image'], true);
                }
            }
            $this->jsonData = array(
                'meta' => array(
                    'paging' => $this->request->params['paging'],
                    'path' => $result['parents'],
                    'children' => $result['children'],
                ),
                'data' => $result['items'],
            );
        }
    }

    public function outward($term = null) {
        $cPage = isset($this->request->params['named']['page']) ? $this->request->params['named']['page'] : '1';
        $cacheKey = "DrugsOutward{$term}{$cPage}";
        $result = Cache::read($cacheKey, 'long');
        if (!$result) {
            $result = $scope = array();
            if (!empty($term)) {
                $name = Sanitize::clean($term);
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
            } else {
                $scope[] = 'License.image != \'\'';
                $scope[] = 'License.image IS NOT NULL';
            }
            $this->paginate['License'] = array(
                'limit' => 20,
                'fields' => array('id', 'name', 'name_english',
                            'license_id', 'disease', 'image'),
                'contain' => array(
                    'Drug' => array(
                        'fields' => array('id'),
                    ),
                ),
                'order' => array(
                    'License.submitted' => 'DESC',
                ),
            );

            $result['items'] = $this->paginate($this->Drug->License, $scope);
            $result['paging'] = $this->request->params['paging'];
            Cache::write($cacheKey, $result, 'long');
        } else {
            $this->request->params['paging'] = $result['paging'];
        }

        foreach ($result['items'] AS $k => $v) {
            if (!empty($v['License']['image'])) {
                $result['items'][$k]['License']['image'] = Router::url('/' . $v['License']['image'], true);
            }
        }
        $this->jsonData = array(
            'meta' => array(
                'paging' => $this->request->params['paging'],
            ),
            'data' => $result['items'],
        );
    }

    public function index($term = '') {
        $cPage = isset($this->request->params['named']['page']) ? $this->request->params['named']['page'] : '1';
        $cacheKey = "DrugsIndex{$term}{$cPage}";
        $result = Cache::read($cacheKey, 'long');
        if (!$result) {
            $result = $scope = array();
            if (!empty($term)) {
                $name = Sanitize::clean($term);
                $keywords = explode(' ', $name);
                $keywordCount = 0;
                foreach ($keywords AS $keyword) {
                    if (++$keywordCount < 5) {
                        $scope[]['OR'] = array(
                            'License.license_id LIKE' => "%{$keyword}%",
                            'Vendor.name LIKE' => "%{$keyword}%",
                            'License.name LIKE' => "%{$keyword}%",
                            'License.name_english LIKE' => "%{$keyword}%",
                            'License.ingredient LIKE' => "%{$keyword}%",
                            'License.nhi_id LIKE' => "%{$keyword}%",
                            'License.disease LIKE' => "%{$keyword}%",
                        );
                    }
                }
            }
            $this->paginate['License'] = array(
                'limit' => 20,
                'fields' => array('id', 'name', 'name_english',
                    'license_id', 'expired_date', 'image'),
                'contain' => array(
                    'Drug' => array(
                        'fields' => array('id'),
                    ),
                    'Vendor' => array(
                        'fields' => array('name', 'country'),
                    ),
                ),
                'order' => array(
                    'License.submitted' => 'DESC',
                ),
            );
            $result['items'] = $this->paginate($this->Drug->License, $scope);
            $result['paging'] = $this->request->params['paging'];
            Cache::write($cacheKey, $result, 'long');
        } else {
            $this->request->params['paging'] = $result['paging'];
        }
        foreach ($result['items'] AS $k => $v) {
            if (!empty($v['License']['image'])) {
                $result['items'][$k]['License']['image'] = Router::url('/' . $v['License']['image'], true);
            }
        }
        $this->jsonData = array(
            'meta' => array(
                'paging' => $this->request->params['paging'],
            ),
            'data' => $result['items'],
        );
    }

    public function view($id = '') {
        if (!empty($id)) {
            $cacheKey = "DrugsView{$id}";
            $result = Cache::read($cacheKey, 'long');
            if (!$result) {
                $result = array();
                $this->data = $result['data'] = $this->Drug->find('first', array(
                    'conditions' => array('Drug.id' => $id),
                    'contain' => array(
                        'License' => array(
                            'Vendor',
                            'Category' => array(
                                'fields' => array('code', 'name', 'name_chinese'),
                            ),
                        ),
                        'Vendor',
                    ),
                ));
                $categoryNames = array();
                foreach ($this->data['License']['Category'] AS $k => $category) {
                    $categoryNames[$category['CategoriesLicense']['category_id']] = $this->Drug->License->Category->getPath($category['CategoriesLicense']['category_id'], array('id', 'name'));
                }
                $result['categoryNames'] = $categoryNames;

                $ingredients = $result['ingredients'] = $this->Drug->License->IngredientsLicense->find('all', array(
                    'conditions' => array('IngredientsLicense.license_id' => $this->data['Drug']['license_id']),
                    'fields' => array('ingredient_id', 'remark', 'name', 'dosage', 'dosage_text', 'unit'),
                    'order' => array(
                        'IngredientsLicense.dosage' => 'DESC',
                    ),
                ));
                $ingredientKeys = $result['ingredientKeys'] = Set::combine($ingredients, '{n}.IngredientsLicense.name', '{n}.IngredientsLicense.ingredient_id');

                $drugs = $result['drugs'] = $this->Drug->find('all', array(
                    'fields' => array(
                        'id', 'manufacturer_description',
                    ),
                    'conditions' => array(
                        'Drug.license_id' => $this->data['Drug']['license_id'],
                    ),
                    'contain' => array('Vendor' => array(
                            'fields' => array('name', 'country'),
                        )),
                ));

                $vendorIds = Set::extract('{n}.Vendor.id', $drugs);
                $vendorIds[] = $this->data['Drug']['vendor_id'];
                $vendorIds[] = $this->data['License']['vendor_id'];
                $vendorIds = array_unique($vendorIds);
                $articleIds = $result['articleIds'] = $this->Drug->License->ArticlesLink->find('list', array(
                    'fields' => array('article_id', 'model'),
                    'conditions' => array(
                        'OR' => array(
                            array(
                                'model' => 'Ingredient',
                                'foreign_id' => $ingredientKeys,
                            ),
                            array(
                                'model' => 'License',
                                'foreign_id' => $this->data['Drug']['license_id'],
                            ),
                            array(
                                'model' => 'Vendor',
                                'foreign_id' => $vendorIds,
                            ),
                        ),
                    ),
                    'order' => array(
                        'FIELD(model, \'License\', \'Ingredient\', \'Vendor\')'
                    ),
                ));
                $articles = $result['articles'] = $this->Drug->License->Article->find('all', array(
                    'conditions' => array(
                        'Article.id' => array_keys($articleIds),
                    ),
                    'fields' => array('id', 'title', 'date_published', 'url'),
                    'order' => array('date_published' => 'DESC'),
                    'limit' => 10,
                ));

                $prices = $result['prices'] = $this->Drug->License->Price->find('all', array(
                    'conditions' => array('Price.license_id' => $this->data['Drug']['license_id']),
                    'order' => array(
                        'Price.nhi_id' => 'ASC',
                        'Price.date_end' => 'DESC',
                    ),
                ));
                $links = $result['links'] = $this->Drug->License->Link->find('all', array(
                    'conditions' => array('Link.license_id' => $this->data['Drug']['license_id']),
                    'fields' => array('url', 'title'),
                    'order' => array(
                        'Link.type' => 'ASC',
                        'Link.sort' => 'ASC',
                    ),
                ));

                Cache::write($cacheKey, $result, 'long');
            }
            if (!empty($result['data']['License']['image'])) {
                $result['data']['License']['image'] = Router::url('/' . $result['data']['License']['image'], true);
            }

            $this->jsonData = array(
                'data' => $result,
            );
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
