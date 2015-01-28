<?php

App::uses('AppController', 'Controller');

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
    
    public function beforeFilter() {
        parent::beforeFilter();
        if (isset($this->Auth)) {
            $this->Auth->allow('index', 'view');
        }
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Point->recursive = 0;
        $this->set('points', $this->Paginator->paginate());
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
        $options = array('conditions' => array('Point.' . $this->Point->primaryKey => $id));
        $this->set('point', $this->Point->find('first', $options));
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
