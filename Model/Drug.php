<?php

App::uses('AppModel', 'Model');

/**
 * Drug Model
 *
 * @property Active $Active
 * @property Linked $Linked
 */
class Drug extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';


    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Active' => array(
            'className' => 'Drug',
            'foreignKey' => 'active_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Linked' => array(
            'className' => 'Drug',
            'foreignKey' => 'linked_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    var $hasMany = array(
        'Price' => array(
            'foreignKey' => 'drug_id',
            'dependent' => true,
            'className' => 'Price',
        ),
        'Link' => array(
            'foreignKey' => 'drug_id',
            'dependent' => true,
            'className' => 'Link',
        ),
        'Attachment' => array(
            'conditions' => array('Attachment.model' => 'Drug'),
            'foreignKey' => 'foreign_key',
            'dependent' => true,
            'className' => 'Media.Attachment',
        ),
    );

}
