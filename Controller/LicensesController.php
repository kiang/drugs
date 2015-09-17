<?php

App::uses('AppController', 'Controller');

/**
 * Licenses Controller
 *
 * @property License $License
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class LicensesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->License->recursive = 0;
        $this->set('licenses', $this->Paginator->paginate());
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        if (!$this->License->exists($id)) {
            throw new NotFoundException(__('Invalid license'));
        }
        $options = array('conditions' => array('License.' . $this->License->primaryKey => $id));
        $this->set('license', $this->License->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->License->create();
            if ($this->License->save($this->request->data)) {
                $this->Session->setFlash(__('The license has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The license could not be saved. Please, try again.'));
            }
        }
        $vendors = $this->License->Vendor->find('list');
        $categories = $this->License->Category->find('list');
        $ingredients = $this->License->Ingredient->find('list');
        $articles = $this->License->Article->find('list');
        $this->set(compact('vendors', 'categories', 'ingredients', 'articles'));
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        if (!$this->License->exists($id)) {
            throw new NotFoundException(__('Invalid license'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->License->save($this->request->data)) {
                $this->Session->setFlash(__('The license has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The license could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('License.' . $this->License->primaryKey => $id));
            $this->request->data = $this->License->find('first', $options);
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
        $this->License->id = $id;
        if (!$this->License->exists()) {
            throw new NotFoundException(__('Invalid license'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->License->delete()) {
            $this->Session->setFlash(__('The license has been deleted.'));
        } else {
            $this->Session->setFlash(__('The license could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}