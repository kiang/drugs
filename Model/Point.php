<?php

App::uses('AppModel', 'Model');

/**
 * Point Model
 *
 */
class Point extends AppModel {

    public $hasAndBelongsToMany = array(
        'Article' => array(
            'joinTable' => 'articles_links',
            'conditions' => array('model' => 'Point'),
            'foreignKey' => 'foreign_id',
            'associationForeignKey' => 'article_id',
            'className' => 'Article',
        ),
    );

}
