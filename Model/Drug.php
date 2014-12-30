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
    public $displayField = 'name';


    //The Associations below have been created with all possible keys, those that are not needed can be removed

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
    public $hasAndBelongsToMany = array(
        'Category' => array(
            'className' => 'Category',
            'joinTable' => 'categories_drugs',
            'foreignKey' => 'drug_id',
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
