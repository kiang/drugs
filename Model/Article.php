<?php

App::uses('AppModel', 'Model');

class Article extends AppModel {

    var $name = 'Article';
    var $validate = array(
        'title' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'This field is required',
            ),
        ),
        'date_published' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
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
        'Vendor' => array(
            'joinTable' => 'articles_links',
            'conditions' => array('model' => 'Vendor'),
            'foreignKey' => 'article_id',
            'associationForeignKey' => 'foreign_id',
            'className' => 'Vendor',
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
