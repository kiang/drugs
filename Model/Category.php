<?php

App::uses('AppModel', 'Model');

/**
 * Category Model
 *
 * @property Drug $Drug
 */
class Category extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';
    public $actsAs = array('Tree');


    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'Drug' => array(
            'className' => 'Drug',
            'joinTable' => 'categories_licenses',
            'foreignKey' => 'category_id',
            'associationForeignKey' => 'license_id',
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
