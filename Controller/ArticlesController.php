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
        $articles = $this->paginate($this->Article);
        $this->set('articles', $articles);
    }

    public function admin_add() {
        if (!empty($this->request->data)) {
            $this->Article->create();
            if ($this->Article->save($this->request->data)) {
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
            if ($this->Article->save($this->request->data)) {
                $this->Session->setFlash('資料已經儲存');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('資料儲存時發生錯誤，請重試');
            }
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->Article->read(null, $id);
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

    public function admin_link_add($articleId = '', $candidateId = '') {
        $linkId = $this->Article->CandidatesArticle->field('id', array(
            'Candidate_id' => $candidateId,
            'Article_id' => $articleId,
        ));
        if (empty($linkId)) {
            $this->Article->CandidatesArticle->create();
            $this->Article->CandidatesArticle->save(array('CandidatesArticle' => array(
                    'Candidate_id' => $candidateId,
                    'Article_id' => $articleId,
            )));
            $this->Article->updateAll(array('Article.count' => 'Article.count + 1'), array('Article.id' => $articleId));
        }
        echo 'ok';
        exit();
    }

    public function admin_link_delete($linkId = '') {
        $articleId = $this->Article->CandidatesArticle->field('Article_id', array('id' => $linkId));
        $this->Article->CandidatesArticle->delete($linkId);
        if (!empty($articleId)) {
            $this->Article->updateAll(array('Article.count' => 'Article.count - 1'), array('Article.id' => $articleId));
        }
        echo 'ok';
        exit();
    }

    public function index() {
        $this->paginate['Article']['limit'] = 100;
        $articles = $this->paginate($this->Article);
        $this->set('articles', $articles);
    }
    
    public function view() {
        $this->paginate['Article']['limit'] = 100;
        $articles = $this->paginate($this->Article);
        $this->set('articles', $articles);
    }

}
