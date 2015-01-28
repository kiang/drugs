<?php

App::uses('AppModel', 'Model');

class Article extends AppModel {

    var $name = 'Article';
    var $validate = array(
        'title' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'This field is required',
            ),
        ),
    );
    var $hasAndBelongsToMany = array(
        'License' => array(
            'joinTable' => 'articles_links',
            'conditions' => array('model' => 'License'),
            'foreignKey' => 'article_id',
            'associationForeignKey' => 'foreign_id',
            'className' => 'License',
        ),
        'Ingredient' => array(
            'joinTable' => 'articles_links',
            'conditions' => array('model' => 'Ingredient'),
            'foreignKey' => 'article_id',
            'associationForeignKey' => 'foreign_id',
            'className' => 'Ingredient',
        ),
        'Point' => array(
            'joinTable' => 'articles_links',
            'conditions' => array('model' => 'Point'),
            'foreignKey' => 'article_id',
            'associationForeignKey' => 'foreign_id',
            'className' => 'Point',
        ),
    );
    var $hasMany = array(
        'ArticlesLink' => array(
            'foreignKey' => 'article_id',
            'className' => 'ArticlesLink',
            'dependent' => true,
        ),
    );

}
