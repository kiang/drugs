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
    public $belongsTo = array(
        'Vendor' => array(
            'className' => 'Vendor',
            'foreignKey' => 'vendor_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );
    var $hasMany = array(
        'Drug' => array(
            'foreignKey' => 'license_id',
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
        'Note' => array(
            'foreignKey' => 'license_id',
            'dependent' => true,
            'className' => 'Note',
        ),
        'Image' => array(
            'conditions' => array(
                'Image.model' => 'License',
                'Image.group' => 'Image',
            ),
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
        'Article' => array(
            'joinTable' => 'articles_links',
            'conditions' => array('model' => 'License'),
            'foreignKey' => 'foreign_id',
            'associationForeignKey' => 'article_id',
            'className' => 'Article',
        ),
    );

}
