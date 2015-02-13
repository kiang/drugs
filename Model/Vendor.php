<?php

App::uses('AppModel', 'Model');

/**
 * Vendor Model
 *
 */
class Vendor extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    var $hasMany = array(
        'Drug' => array(
            'foreignKey' => 'vendor_id',
            'dependent' => false,
            'className' => 'Drug',
        ),
        'License' => array(
            'foreignKey' => 'vendor_id',
            'dependent' => false,
            'className' => 'License',
        ),
    );

}
