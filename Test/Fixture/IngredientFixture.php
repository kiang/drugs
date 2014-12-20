<?php
/**
 * IngredientFixture
 *
 */
class IngredientFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'binary', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'drug_id' => array('type' => 'binary', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index'),
		'remark' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 128, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 128, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'),
		'dosage_text' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'),
		'dosage' => array('type' => 'decimal', 'null' => false, 'default' => null, 'length' => '20,8', 'unsigned' => false),
		'unit' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'drug_id' => array('column' => 'drug_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_unicode_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '5495ad57-2394-4e04-aee4-20d7d38a10d1',
			'drug_id' => 'Lorem ipsum dolor sit amet',
			'remark' => 'Lorem ipsum dolor sit amet',
			'name' => 'Lorem ipsum dolor sit amet',
			'dosage_text' => 'Lorem ipsum dolor sit amet',
			'dosage' => '',
			'unit' => 'Lorem ipsum dolor sit amet'
		),
	);

}
