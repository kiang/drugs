<?php

App::uses('AppController', 'Controller');

/**
 * Notes Controller
 *
 * @property Note $Note
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class NotesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    public $paginate = array();

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->Note->recursive = 0;
        $this->paginate['Note'] = array(
            'order' => array('Note.modified' => 'DESC'),
        );
        $this->set('notes', $this->Paginator->paginate());
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Note->create();
            if ($this->Note->save($this->request->data)) {
                $this->Session->setFlash(__('The note has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The note could not be saved. Please, try again.'));
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
        if (!$this->Note->exists($id)) {
            throw new NotFoundException(__('Invalid note'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Note->save($this->request->data)) {
                $this->Session->setFlash(__('The note has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The note could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Note.' . $this->Note->primaryKey => $id));
            $this->request->data = $this->Note->find('first', $options);
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
        $this->Note->id = $id;
        if (!$this->Note->exists()) {
            throw new NotFoundException(__('Invalid note'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Note->delete()) {
            $this->Session->setFlash(__('The note has been deleted.'));
        } else {
            $this->Session->setFlash(__('The note could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}