<?php

class Member extends AppModel {

    public $name = 'Member';
    public $actsAs = array('Acl' => array('requester'));
    public $belongsTo = array(
        'Group' => array(
            'foreignKey' => 'group_id',
            'className' => 'Group',
        ),
    );

    public function parentNode() {
        if (!$this->id && empty($this->data)) {
            return null;
        }
        $data = $this->data;
        if (empty($this->data)) {
            $data = $this->read();
        }
        if (!$data['Member']['group_id']) {
            return null;
        } else {
            return array('Group' => array('id' => $data['Member']['group_id']));
        }
    }

    public function beforeSave($options = array()) {
        if (isset($this->data['Member']['password'])) {
            $this->data['Member']['password'] = trim($this->data['Member']['password']);
            if (!empty($this->data['Member']['password'])) {
                $this->data['Member']['password'] = Security::hash(Configure::read('Security.salt') . $this->data['Member']['password']);
            } else {
                unset($this->data['Member']['password']);
            }
        }

        return true;
    }

}
