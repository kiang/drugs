<?php

App::uses('AppModel', 'Model');

class IngredientsLicense extends AppModel {

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
        'License' => array(
            'className' => 'License',
            'foreignKey' => 'license_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Ingredient' => array(
            'className' => 'Ingredient',
            'foreignKey' => 'ingredient_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

}
