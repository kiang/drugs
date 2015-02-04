<?php

App::uses('AppController', 'Controller');

/**
 * @property Article Article
 */
class ArticlesController extends AppController {

    public $name = 'Articles';
    public $paginate = array();

    public function beforeFilter() {
        parent::beforeFilter();
        if (isset($this->Auth)) {
            $this->Auth->allow('index', 'view');
        }
    }

    public function admin_index() {
        $this->paginate['Article']['order'] = array(
            'Article.date_published' => 'DESC',
            'Article.created' => 'DESC',
        );
        $articles = $this->paginate($this->Article);
        $this->set('articles', $articles);
    }

    public function admin_add() {
        if (!empty($this->request->data)) {
            $this->request->data['ArticlesLink'] = array();
            if (!empty($this->request->data['Drug'])) {
                $licenses = $this->Article->License->Drug->find('list', array(
                    'fields' => array('Drug.license_uuid', 'Drug.license_uuid'),
                    'conditions' => array(
                        'Drug.id' => $this->request->data['Drug'],
                    ),
                ));
                foreach ($licenses AS $licenseId) {
                    $this->request->data['ArticlesLink'][] = array(
                        'model' => 'License',
                        'foreign_id' => $licenseId,
                    );
                }
                unset($this->request->data['Drug']);
            }
            if (!empty($this->request->data['Ingredient'])) {
                foreach ($this->request->data['Ingredient'] AS $ingredientId) {
                    $this->request->data['ArticlesLink'][] = array(
                        'model' => 'Ingredient',
                        'foreign_id' => $ingredientId,
                    );
                }
                unset($this->request->data['Ingredient']);
            }
            if (!empty($this->request->data['Point'])) {
                foreach ($this->request->data['Point'] AS $pointId) {
                    $this->request->data['ArticlesLink'][] = array(
                        'model' => 'Point',
                        'foreign_id' => $pointId,
                    );
                }
                unset($this->request->data['Point']);
            }
            $this->Article->create();
            if ($this->Article->saveAll($this->request->data)) {
                $this->Session->setFlash('資料已經儲存');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('資料儲存時發生錯誤，請重試');
            }
        }
    }

    public function admin_edit($id = null) {
        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash(__('Please select a article first!', true));
            $this->redirect($this->referer());
        }
        if (!empty($this->request->data)) {
            $this->request->data['ArticlesLink'] = array();
            if (!empty($this->request->data['Drug'])) {
                $licenses = $this->Article->License->Drug->find('list', array(
                    'fields' => array('Drug.license_uuid', 'Drug.license_uuid'),
                    'conditions' => array(
                        'Drug.id' => $this->request->data['Drug'],
                    ),
                ));
                foreach ($licenses AS $licenseId) {
                    $this->request->data['ArticlesLink'][] = array(
                        'model' => 'License',
                        'foreign_id' => $licenseId,
                    );
                }
                unset($this->request->data['Drug']);
            }
            if (!empty($this->request->data['Ingredient'])) {
                foreach ($this->request->data['Ingredient'] AS $ingredientId) {
                    $this->request->data['ArticlesLink'][] = array(
                        'model' => 'Ingredient',
                        'foreign_id' => $ingredientId,
                    );
                }
                unset($this->request->data['Ingredient']);
            }
            if (!empty($this->request->data['Point'])) {
                foreach ($this->request->data['Point'] AS $pointId) {
                    $this->request->data['ArticlesLink'][] = array(
                        'model' => 'Point',
                        'foreign_id' => $pointId,
                    );
                }
                unset($this->request->data['Point']);
            }
            $this->Article->ArticlesLink->deleteAll(array(
                'article_id' => $this->request->data['Article']['id']
            ));
            if ($this->Article->saveAll($this->request->data)) {
                $this->Session->setFlash('資料已經儲存');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('資料儲存時發生錯誤，請重試');
            }
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->Article->find('first', array(
                'conditions' => array('Article.id' => $id),
                'contain' => array('ArticlesLink'),
            ));
            foreach ($this->request->data['ArticlesLink'] AS $link) {
                if (!isset($this->request->data[$link['model']])) {
                    $this->request->data[$link['model']] = array();
                }
                $this->request->data[$link['model']][] = $link['foreign_id'];
            }
            if (!empty($this->request->data['License'])) {
                $this->request->data['Drug'] = $this->Article->License->Drug->find('list', array(
                    'conditions' => array(
                        'Drug.license_uuid' => $this->request->data['License'],
                    ),
                    'contain' => array('License'),
                    'fields' => array('Drug.id', 'License.name'),
                    'group' => array('Drug.license_uuid'),
                ));
            }
            if (!empty($this->request->data['Ingredient'])) {
                $this->request->data['Ingredient'] = $this->Article->Ingredient->find('list', array(
                    'conditions' => array('Ingredient.id' => $this->request->data['Ingredient']),
                    'fields' => array('Ingredient.id', 'Ingredient.name'),
                ));
            }
            if (!empty($this->request->data['Point'])) {
                $this->request->data['Point'] = $this->Article->Point->find('list', array(
                    'conditions' => array('Point.id' => $this->request->data['Point']),
                    'fields' => array('Point.id', 'Point.name'),
                ));
            }
        }
    }

    public function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Please select a article first!', true));
            $this->redirect($this->referer());
        }
        if ($this->Article->delete($id)) {
            $this->Session->setFlash(__('The article has been removed', true));
            $this->redirect(array('action' => 'index'));
        }
    }

    public function admin_links($articleId = '') {
        if (!empty($articleId)) {
            $article = $this->Article->find('first', array(
                'conditions' => array(
                    'Article.id' => $articleId,
                ),
                'contain' => array('Candidate'),
            ));
        }
        if (!empty($article)) {
            $this->set('article', $article);
        } else {
            $this->Session->setFlash(__('Please select a article first!', true));
            $this->redirect($this->referer());
        }
    }

    public function index() {
        $this->paginate['Article']['limit'] = 5;
        $this->paginate['Article']['order'] = array(
            'Article.date_published' => 'DESC',
            'Article.created' => 'DESC',
        );
        $this->paginate['Article']['contain'] = array('ArticlesLink');
        $articles = $this->paginate($this->Article);
        foreach ($articles AS $k => $article) {
            foreach ($article['ArticlesLink'] AS $link) {
                if (!isset($article[$link['model']])) {
                    $article[$link['model']] = array();
                }
                $article[$link['model']][] = $link['foreign_id'];
            }
            if (!empty($article['License'])) {
                $article['Drug'] = $this->Article->License->Drug->find('list', array(
                    'conditions' => array(
                        'Drug.license_uuid' => $article['License'],
                    ),
                    'contain' => array('License'),
                    'fields' => array('Drug.id', 'License.name'),
                    'group' => array('Drug.license_uuid'),
                ));
            }
            if (!empty($article['Ingredient'])) {
                $article['Ingredient'] = $this->Article->Ingredient->find('list', array(
                    'conditions' => array('Ingredient.id' => $article['Ingredient']),
                    'fields' => array('Ingredient.id', 'Ingredient.name'),
                ));
            }
            if (!empty($article['Point'])) {
                $article['Point'] = $this->Article->Point->find('list', array(
                    'conditions' => array('Point.id' => $article['Point']),
                    'fields' => array('Point.id', 'Point.name'),
                ));
            }
            $articles[$k] = $article;
        }
        $this->set('title_for_layout', '醫事新知 @ ');
        $this->set('articles', $articles);
    }

    public function view($articleId = '') {
        $article = $this->Article->find('first', array(
            'conditions' => array('Article.id' => $articleId),
            'contain' => array('ArticlesLink'),
        ));
        if (!empty($article)) {
            foreach ($article['ArticlesLink'] AS $link) {
                if (!isset($article[$link['model']])) {
                    $article[$link['model']] = array();
                }
                $article[$link['model']][] = $link['foreign_id'];
            }
            if (!empty($article['License'])) {
                $article['Drug'] = $this->Article->License->Drug->find('all', array(
                    'conditions' => array(
                        'Drug.license_uuid' => $article['License'],
                    ),
                    'contain' => array('License'),
                    'fields' => array('Drug.id', 'License.name', 'License.disease'),
                    'group' => array('Drug.license_uuid'),
                ));
            }
            if (!empty($article['Ingredient'])) {
                $article['Ingredient'] = $this->Article->Ingredient->find('all', array(
                    'conditions' => array('Ingredient.id' => $article['Ingredient']),
                    'fields' => array('Ingredient.id', 'Ingredient.name', 'Ingredient.count_licenses'),
                ));
            }
            if (!empty($article['Point'])) {
                $article['Point'] = $this->Article->Point->find('all', array(
                    'conditions' => array('Point.id' => $article['Point']),
                    'fields' => array('Point.id', 'Point.name', 'Point.phone', 'Point.city', 'Point.town', 'Point.address'),
                ));
            }
            $this->set('article', $article);
            $this->set('title_for_layout', $article['Article']['title'] . ' | 醫事新知 @ ');
        } else {
            $this->Session->setFlash('請依照網頁指示操作！');
            $this->redirect(array('action' => 'index'));
        }
    }

}
