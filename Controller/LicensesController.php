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
    public $helpers = array('Media.Media');

    public function beforeFilter() {
        parent::beforeFilter();
        if (isset($this->Auth)) {
            $this->Auth->allow('view');
        }
    }

    public function view($id = null) {
        if (!empty($id)) {
            $drugId = $this->License->Drug->field('id', array(
                'Drug.license_id' => $id,
            ));
        }
        if (!empty($drugId)) {
            return $this->redirect(array('admin' => false, 'controller' => 'drugs', 'action' => 'view', $drugId));
        } else {
            return $this->redirect('/');
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
        if (!$this->License->exists($id)) {
            throw new NotFoundException(__('Invalid license'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $this->request->data['License'] = array(
                'id' => $id,
            );
            if (isset($this->request->data['Image'])) {
                foreach ($this->request->data['Image'] AS $k => $v) {
                    if ($v['file']['error'] !== 0) {
                        unset($this->request->data['Image'][$k]);
                    } else {
                        $this->request->data['Image'][$k]['member_id'] = $this->loginMember['id'];
                    }
                }
            }
            if (!empty($this->request->data['ImageDelete'])) {
                foreach ($this->request->data['ImageDelete'] AS $imageId => $check) {
                    if ($check == 1) {
                        $imageId = $this->License->Image->field('id', array(
                            'id' => $imageId,
                            'member_id' => $this->loginMember['id'],
                        ));
                        if (!empty($imageId)) {
                            $this->License->Image->delete($imageId);
                        }
                    }
                }
            }
            $note = array(
                'license_id' => $id,
                'member_id' => $this->loginMember['id'],
            );
            $noteId = $this->License->Note->field('id', $note);
            if (empty($noteId)) {
                $this->License->Note->create();
            } else {
                $this->License->Note->id = $noteId;
            }
            if (!empty($this->request->data['Note'])) {
                $note = array_merge($note, $this->request->data['Note']);
                unset($this->request->data['Note']);
            }
            $this->License->Note->save(array('Note' => $note));
            if ($this->License->saveAll($this->request->data)) {
                $this->Session->setFlash(__('The license has been saved.'));
                return $this->redirect(array('admin' => false, 'action' => 'view', $id));
            } else {
                pr($this->License->validationErrors);
                $this->Session->setFlash(__('The license could not be saved. Please, try again.'));
            }
        } else {
            $options = array(
                'conditions' => array('License.' . $this->License->primaryKey => $id),
                'contain' => array(
                    'Image' => array(
                        'conditions' => array('Image.member_id' => $this->loginMember['id']),
                    ),
                    'Note' => array(
                        'conditions' => array('Note.member_id' => $this->loginMember['id']),
                    ),
                ),
            );
            $this->request->data = $this->License->find('first', $options);
            if (isset($this->request->data['Note'][0])) {
                $this->request->data['Note'] = $this->request->data['Note'][0];
            }
        }
    }

}
