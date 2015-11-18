<?php

App::uses('AppController', 'Controller');

/**
 * Attachments Controller
 *
 * @property Attachment $Attachment
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class AttachmentsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    public $paginate = array();
    public $uses = array('Media.Attachment');
    public $helpers = array('Olc', 'Media.Media');

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->Attachment->recursive = 0;
        $this->paginate['Attachment'] = array(
            'order' => array('Attachment.modified' => 'DESC'),
        );
        $this->set('attachments', $this->Paginator->paginate());
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Attachment->create();
            if ($this->Attachment->save($this->request->data)) {
                $this->Session->setFlash(__('The attachment has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The attachment could not be saved. Please, try again.'));
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
        if (!$this->Attachment->exists($id)) {
            throw new NotFoundException(__('Invalid attachment'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Attachment->save($this->request->data)) {
                $this->Session->setFlash(__('The attachment has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The attachment could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Attachment.' . $this->Attachment->primaryKey => $id));
            $this->request->data = $this->Attachment->find('first', $options);
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
        $this->Attachment->id = $id;
        if (!$this->Attachment->exists()) {
            throw new NotFoundException(__('Invalid attachment'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Attachment->delete()) {
            $this->Session->setFlash(__('The attachment has been deleted.'));
        } else {
            $this->Session->setFlash(__('The attachment could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function admin_rotate($id = null, $angle = null) {
        if (!empty($id)) {
            $img = $this->Attachment->find('first', array(
                'conditions' => array(
                    'Attachment.id' => $id,
                ),
            ));
        }
        if (!empty($img)) {
            $images = array(
                $img['Attachment']['file'],
            );
            foreach (glob(MEDIA_FILTER . '*/' . substr($img['Attachment']['path'], 0, strrpos($img['Attachment']['path'], '.')) . '.*') AS $s) {
                $images[] = $s;
            }
            $color = new \ImagickPixel('white');
            foreach ($images AS $image) {
                $imagick = new \Imagick($image);
                $imagick->rotateimage($color, $angle);
                $imagick->writeImage($image);
            }
        } else {
            throw new NotFoundException(__('Invalid attachment'));
        }
        return $this->redirect(array('action' => 'edit', $id));
    }

}
