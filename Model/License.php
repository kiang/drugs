<?php

App::uses('AppModel', 'Model');

/**
 * License Model
 *
 */
class License extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'id';
    //The Associations below have been created with all possible keys, those that are not needed can be removed

    var $hasMany = array(
        'Price' => array(
            'foreignKey' => 'license_id',
            'dependent' => true,
            'className' => 'Price',
        ),
        'Link' => array(
            'foreignKey' => 'license_id',
            'dependent' => true,
            'className' => 'Link',
        ),
        'Ingredient' => array(
            'foreignKey' => 'license_id',
            'dependent' => true,
            'className' => 'Ingredient',
        ),
        'Attachment' => array(
            'conditions' => array('Attachment.model' => 'License'),
            'foreignKey' => 'foreign_key',
            'dependent' => true,
            'className' => 'Media.Attachment',
        ),
    );
    public $hasAndBelongsToMany = array(
        'Category' => array(
            'className' => 'Category',
            'joinTable' => 'categories_licenses',
            'foreignKey' => 'license_id',
            'associationForeignKey' => 'category_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        )
    );

}
