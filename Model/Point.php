<?php

App::uses('AppModel', 'Model');

/**
 * Point Model
 *
 */
class Point extends AppModel {

    var $actsAs = array(
        'Geocode.Geocodable',
    );
    public $hasAndBelongsToMany = array(
        'Article' => array(
            'joinTable' => 'articles_links',
            'conditions' => array('model' => 'Point'),
            'foreignKey' => 'foreign_id',
            'associationForeignKey' => 'article_id',
            'className' => 'Article',
        ),
    );
    
    public function find($conditions = null, $fields = array(), $order = null, $recursive = null) {
        $findMethods = array_merge($this->findMethods, array('near' => true));
        $findType = (is_string($conditions) && $conditions != 'count' && array_key_exists($conditions, $findMethods) ? $conditions : null);
        if (empty($findType) && is_string($conditions) && $conditions == 'count' && !empty($fields['type']) && array_key_exists($fields['type'], $findMethods)) {
            $findType = $fields['type'];
            unset($fields['type']);
        }

        if ($findType == 'near' && $this->Behaviors->enabled('Geocodable')) {
            $type = ($conditions == 'near' ? 'all' : $conditions);
            $query = $fields;
            if (!empty($query['address'])) {
                foreach (array('address', 'unit', 'distance') as $field) {
                    $$field = isset($query[$field]) ? $query[$field] : null;
                    unset($query[$field]);
                }
                return $this->near($type, $address, $distance, $unit, $query);
            }
        }
        return parent::find($conditions, $fields, $order, $recursive);
    }

}
