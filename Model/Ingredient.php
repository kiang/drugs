<?php

App::uses('AppModel', 'Model');

/**
 * Ingredient Model
 *
 * @property Drug $Drug
 */
class Ingredient extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';


    var $hasMany = array(
        'IngredientsLicense' => array(
            'foreignKey' => 'ingredient_id',
            'dependent' => true,
            'className' => 'IngredientsLicense',
        ),
    );
    
    public $hasAndBelongsToMany = array(
        'License' => array(
            'className' => 'License',
            'joinTable' => 'ingredients_licenses',
            'foreignKey' => 'ingredient_id',
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
