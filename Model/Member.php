<?php

class Member extends AppModel {

    public $name = 'Member';
    public $displayField = 'username';
    public $actsAs = array('Acl' => array('requester'));
    public $belongsTo = array(
        'Group' => array(
            'foreignKey' => 'group_id',
            'className' => 'Group',
        ),
    );
    var $hasMany = array(
        'Note' => array(
            'foreignKey' => 'member_id',
            'dependent' => true,
            'className' => 'Note',
        ),
    );
    public $validate = array(
        'email' => array(
            'email' => array(
                'rule' => array('email'),
                'message' => '信箱格式有誤',
                'allowEmpty' => true,
                'on' => 'update', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'ext_url' => array(
            'ext_url' => array(
                'rule' => array('url'),
                'message' => '網址格式有誤',
                'allowEmpty' => true,
                'on' => 'update', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'ext_image' => array(
            'ext_image' => array(
                'rule' => array('url'),
                'message' => '網址格式有誤',
                'allowEmpty' => true,
                'on' => 'update', // Limit validation to 'create' or 'update' operations
            ),
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
                $this->data['Member']['password'] = $this->getPassword($this->data['Member']['password']);
            } else {
                unset($this->data['Member']['password']);
            }
        }
        if (isset($this->data['Member']['intro'])) {
            if (false !== stripos($this->data['Member']['intro'], 'onclick') || false !== stripos($this->data['Member']['intro'], 'onload')) {
                $this->validationErrors['intro'] = '介紹內容的標籤禁止使用 javascript';
                return false;
            }
        }

        return true;
    }

    public function getPassword($pass) {
        return Security::hash(Configure::read('Security.salt') . $pass);
    }

}
