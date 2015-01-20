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
        'Drug' => array(
            'foreignKey' => 'license_uuid',
            'dependent' => true,
            'className' => 'Drug',
        ),
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
        'IngredientsLicense' => array(
            'foreignKey' => 'license_id',
            'dependent' => true,
            'className' => 'IngredientsLicense',
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
        ),
        'Ingredient' => array(
            'className' => 'Ingredient',
            'joinTable' => 'ingredients_licenses',
            'foreignKey' => 'license_id',
            'associationForeignKey' => 'ingredient_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        ),
    );

}
