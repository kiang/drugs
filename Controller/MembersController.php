<?php

/**
 * @property Member Member
 *
 */
class MembersController extends AppController {

    public $name = 'Members';
    public $paginate = array();

    public function beforeFilter() {
        parent::beforeFilter();
        if (isset($this->Auth)) {
            $this->Auth->allow('login', 'logout', 'view', 'edit');
        }
    }

    public function view($memberId = 0) {
        $memberId = intval($memberId);
        if ($memberId > 0) {
            $member = $this->Member->find('first', array(
                'conditions' => array(
                    'Member.id' => $memberId,
                ),
                'contain' => array(
                    'Note' => array(
                        'fields' => array('Note.id', 'Note.license_id', 'Note.modified'),
                        'limit' => 10,
                        'order' => array(
                            'Note.modified' => 'DESC',
                        ),
                        'License' => array(
                            'fields' => array('license_id'),
                        ),
                    ),
                ),
            ));
        } elseif (!empty($this->loginMember['id'])) {
            $this->redirect('/members/view/' . $this->loginMember['id']);
        }
        if (empty($member)) {
            $this->redirect('/');
        } else {
            if (!empty($member['Member']['nickname'])) {
                $memberName = $member['Member']['nickname'];
            } else {
                $memberName = $member['Member']['username'];
            }

            $this->set('title_for_layout', $memberName . ' @ ');
            $this->set('member', $member);
        }
    }

    public function edit() {
        if (empty($this->loginMember['id'])) {
            $this->redirect('/');
        } else {
            $origMember = $this->Member->find('first', array(
                'conditions' => array(
                    'Member.id' => $this->loginMember['id'],
                ),
            ));
            if (!empty($this->request->data)) {
                $messages = array();
                if (!empty($this->request->data['Member']['orig_pass']) && !empty($this->request->data['Member']['new_pass'])) {
                    if ($this->Member->getPassword($this->request->data['Member']['orig_pass']) === $origMember['Member']['password'] && $this->request->data['Member']['new_pass'] === $this->request->data['Member']['retype_pass']) {
                        $this->request->data['Member']['password'] = $this->request->data['Member']['new_pass'];
                        $messages[] = '密碼更新成功';
                    } else {
                        $messages[] = '密碼更新失敗，請檢查輸入的資料是否正確';
                    }
                }
                if (!empty($this->request->data['Member']['intro'])) {
                    $this->request->data['Member']['intro'] = strip_tags($this->request->data['Member']['intro'], '<a><p><ul><ol><li><img>');
                }
                $this->request->data['Member']['group_id'] = $this->loginMember['group_id'];
                $this->Member->id = $this->loginMember['id'];
                if ($this->Member->save($this->request->data)) {
                    $messages[] = '個人資料更新成功';
                } else {
                    $messages[] = '個人資料更新失敗';
                }
                $this->Session->setFlash(implode('<br />', $messages));
            } else {
                $this->request->data = $origMember;
            }
        }
    }

    public function login() {
        if (!empty($this->request->data['Member']['username'])) {
            if ($this->Auth->login()) {
                return $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash(__('Username or password is wrong', true));
            }
        }
    }

    public function logout() {
        $this->Auth->logout();
        $this->redirect(array('action' => 'login'));
    }

    public function setup() {
        if ($this->Member->hasAny(array('user_status' => 'Y'))) {
            $this->Session->setFlash(__('There are members in database. If you want to reset, please remove them first.', true));
            $this->redirect('/members/login');
        } elseif (!empty($this->request->data)) {
            $this->loadModel('Group');
            $this->request->data['Group']['name'] = 'Admin';
            $this->request->data['Group']['parent_id'] = 0;
            $this->Group->create();
            if ($this->Group->save($this->request->data)) {
                $this->request->data['Member']['group_id'] = $this->Group->id;
                $this->request->data['Member']['user_status'] = 'Y';
                $this->Member->create();
                if ($this->Member->save($this->request->data)) {
                    $this->loadModel('Permissible.PermissibleAro');
                    $this->PermissibleAro->reset();
                    $this->loadModel('Permissible.PermissibleAco');
                    if ($this->PermissibleAco->reset()) {
                        $this->Acl->deny('everyone', 'app');
                        $this->Acl->allow('Group1', 'app');
                    }
                    $this->Session->setFlash(__('The administrator created, please login with the id/password you entered.', true));
                    $this->redirect('/members/login');
                } else {
                    $this->Session->setFlash(__('Administrator created failed.', true));
                }
            } else {
                $this->Session->setFlash(__('Administrator created failed.', true));
            }
        }
    }

    public function admin_index() {
        $scope = array();
        $keyword = '';
        if (isset($this->params['named']['keyword'])) {
            if (is_array($this->params['named']['keyword'])) {
                foreach ($this->params['named']['keyword'] AS $keyword) {
                    continue;
                }
            } else {
                $keyword = $this->params['named']['keyword'];
            }
            $this->Session->write('Members.index.keyword', $keyword);
        } else {
            $keyword = $this->Session->read('Members.index.keyword');
        }
        if (!empty($keyword)) {
            $scope['OR'] = array(
                'Member.username LIKE' => '%' . $keyword . '%',
                'Group.name LIKE' => '%' . $keyword . '%',
            );
        }
        $this->paginate['Member'] = array(
            'order' => array('Member.id DESC'),
            'contain' => array('Group'),
            'limit' => 40,
        );
        $this->set('members', $this->paginate($this->Member, $scope));
        $this->set('keyword', $keyword);
    }

    public function admin_add() {
        if (!empty($this->request->data)) {
            $this->Member->create();
            if ($this->Member->save($this->request->data)) {
                $this->Acl->Aro->saveField('alias', 'Member/' . $this->Member->getInsertID());
                $this->Session->setFlash('資料已經儲存');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('資料儲存時發生錯誤，請重試');
            }
        }
        $this->set('groups', $this->Member->Group->find('list'));
    }

    public function admin_edit($id = null) {
        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash('請依照網頁指示操作');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->request->data)) {
            $oldgroupid = $this->Member->field('group_id', array('Member.id' => $this->request->data['Member']['id']));
            if ($this->Member->save($this->request->data)) {
                if ($oldgroupid !== $this->request->data['Member']['group_id']) {
                    $aro = & $this->Acl->Aro;
                    $member = $aro->findByForeignKeyAndModel($this->request->data['Member']['id'], 'Member');
                    $group = $aro->findByForeignKeyAndModel($this->request->data['Member']['group_id'], 'Group');
                    $aro->id = $member['Aro']['id'];
                    $aro->save(array('parent_id' => $group['Aro']['id']));
                }
                $this->Session->setFlash('資料已經儲存');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('資料儲存時發生錯誤，請重試');
            }
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->Member->read(null, $id);
        }
        $this->set('groups', $this->Member->Group->find('list'));
    }

    public function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash('請依照網頁指示操作');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Member->delete($id)) {
            $this->Session->setFlash('資料已經刪除');
            $this->redirect(array('action' => 'index'));
        }
    }

    public function admin_acos() {
        $this->loadModel('Permissible.PermissibleAco');
        $this->PermissibleAco->refresh();
        $this->redirect($this->referer());
    }

}
