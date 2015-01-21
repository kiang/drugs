<?php

class GroupPermission extends AppModel {

    public $name = 'GroupPermission';
    public $displayField = 'name';
    public $validate = array(
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'This field is required',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    public function beforeSave($options = array()) {
        if (!empty($this->data['GroupPermission']['acos'])) {
            $acos = explode(chr(10), $this->data['GroupPermission']['acos']);
            foreach ($acos AS $key => $aco) {
                $acos[$key] = trim($aco);
                if (empty($acos[$key])) {
                    unset($acos[$key]);
                }
            }
            $this->data['GroupPermission']['acos'] = implode(chr(10), array_unique($acos));
        }

        return parent::beforeSave($options);
    }

}
