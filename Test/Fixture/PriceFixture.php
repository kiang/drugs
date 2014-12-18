<?php
/**
 * PriceFixture
 *
 */
class PriceFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'binary', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'drug_id' => array('type' => 'binary', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index'),
		'nhi_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'),
		'nhi_dosage' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'),
		'nhi_unit' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'utf8mb4_unicode_ci', 'charset' => 'utf8mb4'),
		'date_begin' => array('type' => 'date', 'null' => false, 'default' => null),
		'date_end' => array('type' => 'date', 'null' => false, 'default' => null),
		'nhi_price' => array('type' => 'decimal', 'null' => false, 'default' => null, 'length' => '10,2', 'unsigned' => false),
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
			'id' => '5492fe18-0678-47a7-9d6d-4763d38a10d1',
			'drug_id' => 'Lorem ipsum dolor sit amet',
			'nhi_id' => 'Lorem ipsum dolor sit amet',
			'nhi_dosage' => 'Lorem ipsum dolor sit amet',
			'nhi_unit' => 'Lorem ipsum dolor sit amet',
			'date_begin' => '2014-12-19',
			'date_end' => '2014-12-19',
			'nhi_price' => ''
		),
	);

}
