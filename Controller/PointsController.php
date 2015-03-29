<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Points Controller
 *
 * @property Point $Point
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class PointsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    public $paginate = array();

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
        if (!empty($this->request->params['paging']['Point']['page'])) {
            $path .= '/page:' . $this->request->params['paging']['Point']['page'];
        }
        $this->set('apiRoute', $path);
    }

    /**
     * index method
     *
     * @return void
     */
    public function index($name = '') {
        $scope = array();
        if (!empty($name)) {
            $name = Sanitize::clean($name);
            $keywords = explode(' ', $name);
            $keywordCount = 0;
            foreach ($keywords AS $keyword) {
                if (++$keywordCount < 5) {
                    $scope[]['OR'] = array(
                        'Point.name LIKE' => "%{$keyword}%",
                        'Point.category LIKE' => "%{$keyword}%",
                        'Point.city LIKE' => "%{$keyword}%",
                        'Point.town LIKE' => "%{$keyword}%",
                        'Point.phone LIKE' => "%{$keyword}%",
                        'Point.nhi_id' => $keyword,
                    );
                }
            }
        }
        $this->paginate['Point'] = array(
            'limit' => 20,
        );
        $this->set('url', array($name));
        $title = '';
        if (!empty($name)) {
            $title = "{$name} 相關";
        }
        $this->set('points', $this->paginate($this->Point, $scope));
        $this->set('title_for_layout', $title . '醫療院所一覽 @ ');
        $this->set('pointKeyword', $name);
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Point->exists($id)) {
            throw new NotFoundException(__('Invalid point'));
        }
        $point = $this->Point->find('first', array(
            'conditions' => array(
                'Point.' . $this->Point->primaryKey => $id
            ),
            'contain' => array(
                'Article' => array(
                    'fields' => array('id', 'title', 'date_published', 'url'),
                    'order' => array('date_published' => 'DESC'),
                    'limit' => 10,
                ),
            ),
        ));
        $items = $this->Point->find('near', array(
            'fields' => array(
                'id', 'name', 'phone', 'address'
            ),
            'limit' => 15,
            'distance' => 30,
            'unit' => 'k',
            'address' => array(
                $point['Point']['latitude'],
                $point['Point']['longitude'],
            ),
        ));
        $this->set('point', $point);
        $this->set('nearPoints', $items);
        $this->set('title_for_layout', "{$point['Point']['name']} @ ");
        $this->set('desc_for_layout', "名稱：{$point['Point']['name']} / 電話：{$point['Point']['phone']} / 住址：{$point['Point']['city']}{$point['Point']['town']}{$point['Point']['address']} / ");
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->Point->recursive = 0;
        $this->set('points', $this->Paginator->paginate());
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        if (!$this->Point->exists($id)) {
            throw new NotFoundException(__('Invalid point'));
        }
        $options = array('conditions' => array('Point.' . $this->Point->primaryKey => $id));
        $this->set('point', $this->Point->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Point->create();
            if ($this->Point->save($this->request->data)) {
                $this->Session->setFlash(__('The point has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The point could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        if (!$this->Point->exists($id)) {
            throw new NotFoundException(__('Invalid point'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Point->save($this->request->data)) {
                $this->Session->setFlash(__('The point has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The point could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Point.' . $this->Point->primaryKey => $id));
            $this->request->data = $this->Point->find('first', $options);
        }
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        $this->Point->id = $id;
        if (!$this->Point->exists()) {
            throw new NotFoundException(__('Invalid point'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Point->delete()) {
            $this->Session->setFlash(__('The point has been deleted.'));
        } else {
            $this->Session->setFlash(__('The point could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}
