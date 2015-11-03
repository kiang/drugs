<?php

App::uses('AppModel', 'Model');

/**
 * Drug Model
 *
 */
class Note extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'created';
    public $belongsTo = array(
        'License' => array(
            'className' => 'License',
            'foreignKey' => 'license_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Member' => array(
            'className' => 'Member',
            'foreignKey' => 'member_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

}
