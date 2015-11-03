<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class DrugsController extends AppController {

    public $name = 'Drugs';
    public $paginate = array();
    public $helpers = array('Olc', 'Media.Media');

    public function beforeFilter() {
        parent::beforeFilter();
        if (isset($this->Auth)) {
            $this->Auth->allow('index', 'view', 'outward', 'category');
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
            $cPage = isset($this->request->params['named']['page']) ? $this->request->params['named']['page'] : '1';
            $cacheKey = "DrugsCategory{$name}{$cPage}";
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
        if (!empty($result['category'])) {
            $this->Drug->License->Category->counterIncrement($categoryId);

            $this->set('url', array($categoryId));
            $this->set('category', $result['category']);
            $this->set('parents', $result['parents']);
            $this->set('children', $result['children']);
            $this->set('items', $result['items']);
            $this->set('title_for_layout', implode(' > ', Set::extract('{n}.Category.name', $result['parents'])) . ' 藥品一覽 @ ');
        } else {
            $this->Session->setFlash('請依據網頁指示操作');
            $this->redirect(array('action' => 'index'));
        }
    }

    public function outward($name = null) {
        $cPage = isset($this->request->params['named']['page']) ? $this->request->params['named']['page'] : '1';
        $cacheKey = "DrugsOutward{$name}{$cPage}";
        $result = Cache::read($cacheKey, 'long');
        if (!$result) {
            $result = $scope = array();
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
            } else {
                $scope[] = 'License.image != \'\'';
                $scope[] = 'License.image IS NOT NULL';
            }
            $this->paginate['Drug'] = array(
                'limit' => 20,
                'contain' => array('License'),
                'order' => array(
                    'License.count_daily' => 'DESC',
                    'License.count_all' => 'DESC',
                    'License.submitted' => 'DESC',
                ),
                'group' => array('Drug.license_id'),
            );

            $result['items'] = $this->paginate($this->Drug, $scope);
            $result['paging'] = $this->request->params['paging'];
            Cache::write($cacheKey, $result, 'long');
        } else {
            $this->request->params['paging'] = $result['paging'];
        }

        $this->set('url', array($name));
        $title = '';
        if (!empty($name)) {
            $title = "{$name} 相關";
        }
        $this->set('title_for_layout', $title . '藥品一覽 @ ');
        $this->set('items', $result['items']);
        $this->set('keyword', $name);
    }

    function index($name = null) {
        $cPage = isset($this->request->params['named']['page']) ? $this->request->params['named']['page'] : '1';
        $cacheKey = "DrugsIndex{$name}{$cPage}";
        $result = Cache::read($cacheKey, 'long');
        if (!$result) {
            $result = $scope = array();
            if (!empty($name)) {
                $name = Sanitize::clean($name);
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
            $this->paginate['Drug'] = array(
                'limit' => 20,
                'contain' => array(
                    'License',
                    'Vendor' => array(
                        'fields' => array('name', 'country'),
                    ),
                ),
                'order' => array(
                    'License.count_daily' => 'DESC',
                    'License.count_all' => 'DESC',
                    'License.submitted' => 'DESC',
                ),
                'group' => array('Drug.license_id'),
            );
            $result['items'] = $this->paginate($this->Drug, $scope);
            $result['paging'] = $this->request->params['paging'];
            Cache::write($cacheKey, $result, 'long');
        } else {
            $this->request->params['paging'] = $result['paging'];
        }

        $this->set('url', array($name));
        $title = '';
        if (!empty($name)) {
            $title = "{$name} 相關";
        }
        $this->set('title_for_layout', $title . '藥品一覽 @ ');
        $this->set('items', $result['items']);
        $this->set('keyword', $name);
    }

    function view($id = null) {
        if (!empty($id)) {
            $cacheKey = "DrugsView{$id}";
            $result = Cache::read($cacheKey, 'long');
            $result = false;
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
                            'Image', 'Note',
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
            } else {
                $this->data = $result['data'];
                $categoryNames = $result['categoryNames'];
                $ingredients = $result['ingredients'];
                $ingredientKeys = $result['ingredientKeys'];
                $drugs = $result['drugs'];
                $articleIds = $result['articleIds'];
                $articles = $result['articles'];
                $prices = $result['prices'];
                $links = $result['links'];
            }
            if (!empty($this->data['License']['image'])) {
                $this->set('ogImage', $this->data['License']['image']);
            }
            $this->Drug->License->counterIncrement($this->data['Drug']['license_id']);
        }

        if (!empty($this->data)) {
            $this->set('title_for_layout', "{$this->data['License']['name']} {{$this->data['License']['name_english']}} @ ");
            $this->set('desc_for_layout', "{$this->data['License']['name']} {$this->data['License']['name_english']} / {$this->data['License']['disease']} / ");
            $this->set('prices', $prices);
            $this->set('links', $links);
            $this->set('ingredients', $ingredients);
            $this->set('ingredientKeys', $ingredientKeys);
            $this->set('articles', $articles);
            $this->set('articleIds', $articleIds);
            $this->set('drugs', $drugs);
            $this->set('categoryNames', $categoryNames);
            $this->set('editCheck', $this->Acl->check(array('Member' => array('id' => $this->loginMember['id'])), 'Licenses/admin_edit'));
        } else {
            $this->Session->setFlash(__('Please do following links in the page', true));
            $this->redirect(array('action' => 'index'));
        }
    }

}
