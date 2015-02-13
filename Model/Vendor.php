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
    
    public $hasAndBelongsToMany = array(
        'Article' => array(
            'joinTable' => 'articles_links',
            'conditions' => array('model' => 'Vendor'),
            'foreignKey' => 'foreign_id',
            'associationForeignKey' => 'article_id',
            'className' => 'Article',
        ),
    );

}
