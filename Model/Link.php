<?php

App::uses('AppModel', 'Model');

/**
 * Link Model
 *
 * @property Drug $Drug
 */
class Link extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'title';


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
