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


    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Drug' => array(
            'className' => 'Drug',
            'foreignKey' => 'drug_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

}
