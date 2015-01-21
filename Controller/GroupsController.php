<?php

/**
 * @property Group Group
 */
class GroupsController extends AppController {

    public $name = 'Groups';
    public $paginate = array();

    public function admin_index($parentId = 0) {
        $this->paginate['Group'] = array(
            'contain' => array(),
        );
        $this->set('parentId', $parentId);
        $upperLevelId = 0;
        if ($parentId > 0) {
            $upperLevelId = $this->Group->field('parent_id', array('Group.id' => $parentId));
        }
        $this->set('upperLevelId', $upperLevelId);
        if (!$groups = $this->paginate($this->Group, array('parent_id' => $parentId))) {
            if (isset($this->params['named']['page']) && $this->params['named']['page'] > 1) {
                $this->Session->setFlash(__('The page doesn\'t exists', true));
                $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(__('It doesn\'t have sub groups. You could try to add one through the following form.', true));
                $this->redirect(array('action' => 'add', $parentId));
            }
        } else {
            $this->set('groups', $groups);
        }
    }

    public function admin_add($parentId = 0) {
        if (!empty($this->request->data)) {
            $this->Group->create();
            $this->request->data['Group']['parent_id'] = $parentId;
            if ($this->Group->save($this->request->data)) {
                $this->Acl->Aro->saveField('alias', 'Group' . $this->Group->getInsertID());
                $this->Session->setFlash('資料已經儲存');
                $this->redirect(array('action' => 'index', $parentId));
            } else {
                $this->Session->setFlash('資料儲存時發生錯誤，請重試');
            }
        }
        $this->set('parentId', $parentId);
    }

    public function admin_edit($id = null) {
        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash(__('Please select a group first!', true));
            $this->redirect($this->referer());
        }
        if (!empty($this->request->data)) {
            if ($this->Group->save($this->request->data)) {
                $this->Session->setFlash('資料已經儲存');
                $this->redirect(array('action' => 'index', $this->Group->field('parent_id')));
            } else {
                $this->Session->setFlash('資料儲存時發生錯誤，請重試');
            }
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->Group->read(null, $id);
        }
    }

    public function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Please select a group first!', true));
            $this->redirect($this->referer());
        }
        $parentId = $this->Group->field('parent_id', array('Group.parent_id' => $id));
        if ($this->Group->delete($id)) {
            $this->Session->setFlash(__('The group has been removed', true));
            $this->redirect(array('action' => 'index', $parentId));
        }
    }

    public function admin_acos($groupId = 0) {
        if (empty($groupId) || !$aroGroup = $this->Group->find('first', array(
            'fields' => array('Group.id'),
            'conditions' => array(
                'Group.id' => $groupId,
            ),
                ))) {
            $this->Session->setFlash(__('Please select a group first!', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $count = 0;
            foreach ($this->data AS $key => $val) {
                if (strstr($key, '___')) {
                    $key = str_replace('___', '/', $key);
                    if ($val == '+') {
                        $this->Acl->allow($aroGroup, $key);
                        ++$count;
                    } elseif ($val == '-') {
                        $this->Acl->deny($aroGroup, $key);
                        ++$count;
                    }
                }
            }
            if ($count > 0) {
                $this->Session->setFlash(sprintf(__('%d items updated successfully!', true), $count));
            }
        }
        $this->set('groupId', $groupId);
        /*
         * Find the root node of ACOS
         */
        $aco = & $this->Acl->Aco;
        $acoRoot = $aco->node('app');
        if (!empty($acoRoot)) {
            $acos = $this->Acl->Aco->find('all', array(
                'conditions' => array('Aco.parent_id' => $acoRoot[0]['Aco']['id']),
            ));
            foreach ($acos AS $key => $controllerAco) {
                $actionAcos = $this->Acl->Aco->find('all', array(
                    'conditions' => array(
                        'Aco.parent_id' => $controllerAco['Aco']['id'],
                    ),
                ));
                if (!empty($actionAcos)) {
                    foreach ($actionAcos AS $actionAco) {
                        if (($actionAco['Aco']['rght'] - $actionAco['Aco']['lft']) != 1) {
                            /*
                             * Controller in plugins
                             */
                            $pluginAcos = $this->Acl->Aco->find('all', array(
                                'conditions' => array(
                                    'Aco.parent_id' => $actionAco['Aco']['id'],
                                ),
                            ));
                            foreach ($pluginAcos AS $pluginAco) {
                                $pluginAco['Aco']['permitted'] = $this->Acl->check(
                                        $aroGroup, $controllerAco['Aco']['alias']
                                        . '/' . $actionAco['Aco']['alias']
                                        . '/' . $pluginAco['Aco']['alias']
                                );
                                $pluginAco['Aco']['alias'] = $actionAco['Aco']['alias']
                                        . '/' . $pluginAco['Aco']['alias'];
                                $acos[$key]['Aco']['Aco'][] = $pluginAco['Aco'];
                            }
                        } else {
                            $actionAco['Aco']['permitted'] = $this->Acl->check(
                                    $aroGroup, $controllerAco['Aco']['alias']
                                    . '/' . $actionAco['Aco']['alias']
                            );
                            $acos[$key]['Aco']['Aco'][] = $actionAco['Aco'];
                        }
                    }
                }
            }
            $this->set('acos', $acos);
        } else {
            /**
             *  Can't find the root node, forward to members/setup method
             */
            $this->redirect('/members/setup');
        }
    }

}
