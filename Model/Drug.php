<?php

App::uses('AppModel', 'Model');

/**
 * Drug Model
 *
 */
class Drug extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'license_id';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'License' => array(
            'className' => 'License',
            'foreignKey' => 'license_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Vendor' => array(
            'className' => 'Vendor',
            'foreignKey' => 'vendor_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
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
        'Ingredient' => array(
            'foreignKey' => 'drug_id',
            'dependent' => true,
            'className' => 'Ingredient',
        ),
        'Attachment' => array(
            'conditions' => array('Attachment.model' => 'Drug'),
            'foreignKey' => 'foreign_key',
            'dependent' => true,
            'className' => 'Media.Attachment',
        ),
    );

}
