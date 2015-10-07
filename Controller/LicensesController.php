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
                return $this->redirect(array('admin' => false, 'action' => 'view', $id));
            } else {
                $this->Session->setFlash(__('The license could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('License.' . $this->License->primaryKey => $id));
            $this->request->data = $this->License->find('first', $options);
        }
    }

}