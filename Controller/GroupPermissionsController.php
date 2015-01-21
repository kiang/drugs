<?php

class GroupPermissionsController extends AppController {

    public $name = 'GroupPermissions';
    public $paginate = array();

    public function admin_index($parentId = 0) {
        $parentId = intval($parentId);
        $parent = array('GroupPermission' => array(
                'id' => 0
        ));
        if ($parentId > 0) {
            $parent = $this->GroupPermission->find('first', array(
                'conditions' => array('id' => $parentId),
                'fields' => array('id', 'name'),
            ));
        }
        $this->paginate['GroupPermission'] = array(
            'conditions' => array(
                'parent_id' => $parentId,
            ),
            'order' => array('parent_id ASC', 'order ASC'),
        );
        $this->set('groupPermissions', $this->paginate($this->GroupPermission));
        $this->set('parent', $parent);
    }

    public function admin_group($groupId = 0) {
        $groupId = intval($groupId);
        if ($groupId <= 0 || !$aro = $this->Acl->Aro->find('first', array(
            'fields' => array('lft', 'rght'),
            'conditions' => array(
                'model' => 'Group',
                'foreign_key' => $groupId
            ),
                ))) {
            $this->Session->setFlash(__('Invalid group', true));
            $this->redirect(array('controller' => 'groups', 'action' => 'index'));
        }
        $this->loadModel('Group');
        $group = $this->Group->find('first', array(
            'conditions' => array('id' => $groupId),
        ));

        $acos = $this->_getAcos('key');

        $nodes = $this->Acl->Aro->find('all', array(
            'fields' => array('Aro.id'),
            'conditions' => array(
                'Aro.lft <=' => $aro['Aro']['lft'],
                'Aro.rght >=' => $aro['Aro']['rght'],
            ),
            'order' => array('Aro.lft ASC'),
            'contain' => array(
                'Aco' => array(
                    'fields' => array('Aco.id'),
                ),
            ),
        ));

        foreach ($nodes AS $node) {
            $permissions = Set::combine($node, 'Aco.{n}.id', 'Aco.{n}.Permission._create');
            foreach ($acos AS $key => $acoId) {
                if (!isset($permissions[$acoId])) {
                    $acos[$key] = -1;
                } else {
                    $acos[$key] = $permissions[$acoId];
                }
            }
        }

        $groupPermissions = $this->GroupPermission->find('all', array(
            'order' => array('GroupPermission.parent_id ASC', 'GroupPermission.order ASC'),
        ));
        if (!empty($this->request->data['GroupPermission'])) {
            $keyStack = Set::combine($groupPermissions, '{n}.GroupPermission.id', '{n}.GroupPermission');
            $allowedStack = array();
            foreach ($keyStack AS $gpId => $gp) {
                if (!empty($this->request->data['GroupPermission'][$gpId])) {
                    $acoArray = explode(chr(10), $gp['acos']);
                    foreach ($acoArray AS $acoItem) {
                        $allowedStack[$acoItem] = 1;
                    }
                }
            }
            foreach ($acos AS $acoAlias => $isAllowed) {
                if (!isset($allowedStack[$acoAlias])) {
                    $this->Acl->deny($group, $acoAlias);
                } elseif ($allowedStack[$acoAlias] != $isAllowed) {
                    $this->Acl->allow($group, $acoAlias);
                }
            }
        }

        $items = array();
        foreach ($groupPermissions AS $groupPermission) {
            if ($groupPermission['GroupPermission']['parent_id'] == 0) {
                $items[$groupPermission['GroupPermission']['id']]['category'] = $groupPermission['GroupPermission'];
            } else {
                $groupAcos = explode(chr(10), $groupPermission['GroupPermission']['acos']);
                $groupPermission['GroupPermission']['acos'] = 1;
                foreach ($groupAcos AS $groupAco) {
                    if ($groupPermission['GroupPermission']['acos'] == 1 && (!isset($acos[$groupAco]) || $acos[$groupAco] == -1)) {
                        $groupPermission['GroupPermission']['acos'] = -1;
                    }
                }
                $items[$groupPermission['GroupPermission']['parent_id']]['items'][] = $groupPermission['GroupPermission'];
            }
        }
        $this->set('items', $items);
        $this->set('group', $group);
    }

    public function admin_add() {
        if (!empty($this->request->data)) {
            $this->GroupPermission->create();
            if ($this->GroupPermission->save($this->request->data)) {
                $this->Session->setFlash(__('The group permission has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The group permission could not be saved. Please, try again.', true));
            }
        }
        $this->set('parents', $this->GroupPermission->find('list', array(
                    'conditions' => array(
                        'parent_id' => 0
                    ),
        )));
        $this->set('acos', $this->_getAcos());
    }

    public function admin_edit($id = null) {
        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash(__('Invalid group permission', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->request->data)) {
            if ($this->GroupPermission->save($this->request->data)) {
                $this->Session->setFlash(__('The group permission has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The group permission could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->GroupPermission->read(null, $id);
        }
        $this->set('parents', $this->GroupPermission->find('list', array(
                    'conditions' => array(
                        'parent_id' => 0,
                        'id !=' => $id,
                    ),
        )));
        $this->set('acos', $this->_getAcos());
    }

    public function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for group permission', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->GroupPermission->delete($id)) {
            $this->Session->setFlash(__('Group permission deleted', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Group permission was not deleted', true));
        $this->redirect(array('action' => 'index'));
    }

    private function _getAcos($key = 'alias') {
        $aco = & $this->Acl->Aco;
        $results = $aco->find('all', array(
            'fields' => array(
                'id', 'alias', 'lft', 'rght'
            ),
            'order' => array('Aco.lft ASC'),
        ));
        $stack = $options = array();
        foreach ($results as $result) {
            while ($stack && ($stack[count($stack) - 1]['rght'] < $result['Aco']['rght'])) {
                array_pop($stack);
            }
            if (!empty($stack)) {
                $alias = '';
                foreach ($stack AS $acoNode) {
                    $alias .= '/' . $acoNode['alias'];
                }
                $alias = substr($alias, 1) . '/' . $result['Aco']['alias'];
            } else {
                $alias = $result['Aco']['alias'];
            }
            if ($result['Aco']['rght'] == $result['Aco']['lft'] + 1) {
                if ($key === 'alias') {
                    $options[$alias] = $alias;
                } else {
                    $options[$alias] = $result['Aco']['id'];
                }
            }
            $stack[] = $result['Aco'];
        }

        return $options;
    }

}
