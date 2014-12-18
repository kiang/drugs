<?php
/**
 * DrugFixture
 *
 */
class DrugFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'binary', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'active_id' => array('type' => 'binary', 'null' => true, 'default' => null, 'length' => 36),
		'linked_id' => array('type' => 'binary', 'null' => true, 'default' => null, 'length' => 36),
		'license_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'collate' => 'utf8_unicode_ci', 'comment' => '許可證字號', 'charset' => 'utf8'),
		'cancel_status' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'utf8_unicode_ci', 'comment' => '註銷狀態', 'charset' => 'utf8'),
		'cancel_date' => array('type' => 'date', 'null' => true, 'default' => null, 'comment' => '註銷日期'),
		'cancel_reason' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '註銷理由', 'charset' => 'utf8'),
		'expired_date' => array('type' => 'date', 'null' => false, 'default' => null, 'comment' => '有效日期'),
		'license_date' => array('type' => 'date', 'null' => false, 'default' => null, 'comment' => '發證日期'),
		'license_type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'utf8_unicode_ci', 'comment' => '許可證種類', 'charset' => 'utf8'),
		'old_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'utf8_unicode_ci', 'comment' => '舊證字號', 'charset' => 'utf8'),
		'document_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'utf8_unicode_ci', 'comment' => '通關簽審文件編號', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '中文品名', 'charset' => 'utf8mb4'),
		'name_english' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'utf8_unicode_ci', 'comment' => '英文品名', 'charset' => 'utf8'),
		'disease' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '適應症', 'charset' => 'utf8mb4'),
		'formulation' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '劑型', 'charset' => 'utf8'),
		'package' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '包裝', 'charset' => 'utf8'),
		'type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'utf8_unicode_ci', 'comment' => '藥品類別', 'charset' => 'utf8'),
		'class' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'utf8_unicode_ci', 'comment' => '管制藥品分類級別', 'charset' => 'utf8'),
		'ingredient' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '主成分略述', 'charset' => 'utf8mb4'),
		'vendor' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '申請商名稱', 'charset' => 'utf8'),
		'vendor_address' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '申請商地址', 'charset' => 'utf8'),
		'vendor_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'utf8_unicode_ci', 'comment' => '申請商統一編號', 'charset' => 'utf8'),
		'manufacturer' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '製造商名稱', 'charset' => 'utf8'),
		'manufacturer_address' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '製造廠廠址', 'charset' => 'utf8'),
		'manufacturer_office' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '製造廠公司地址', 'charset' => 'utf8'),
		'manufacturer_country' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'utf8_unicode_ci', 'comment' => '製造廠國別', 'charset' => 'utf8'),
		'manufacturer_description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '製程', 'charset' => 'utf8mb4'),
		'submitted' => array('type' => 'date', 'null' => false, 'default' => null, 'comment' => '異動日期'),
		'usage' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '用法用量', 'charset' => 'utf8mb4'),
		'package_note' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '包裝', 'charset' => 'utf8mb4'),
		'barcode' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'utf8_unicode_ci', 'comment' => '國際條碼', 'charset' => 'utf8'),
		'md5' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '54928b72-e734-4ddd-be50-1a10d38a10d1',
			'active_id' => 'Lorem ipsum dolor sit amet',
			'linked_id' => 'Lorem ipsum dolor sit amet',
			'license_id' => 'Lorem ipsum dolor sit amet',
			'cancel_status' => 'Lorem ipsum dolor sit amet',
			'cancel_date' => '2014-12-18',
			'cancel_reason' => 'Lorem ipsum dolor sit amet',
			'expired_date' => '2014-12-18',
			'license_date' => '2014-12-18',
			'license_type' => 'Lorem ipsum dolor sit amet',
			'old_id' => 'Lorem ipsum dolor sit amet',
			'document_id' => 'Lorem ipsum dolor sit amet',
			'name' => 'Lorem ipsum dolor sit amet',
			'name_english' => 'Lorem ipsum dolor sit amet',
			'disease' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'formulation' => 'Lorem ipsum dolor sit amet',
			'package' => 'Lorem ipsum dolor sit amet',
			'type' => 'Lorem ipsum dolor sit amet',
			'class' => 'Lorem ipsum dolor sit amet',
			'ingredient' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'vendor' => 'Lorem ipsum dolor sit amet',
			'vendor_address' => 'Lorem ipsum dolor sit amet',
			'vendor_id' => 'Lorem ipsum dolor sit amet',
			'manufacturer' => 'Lorem ipsum dolor sit amet',
			'manufacturer_address' => 'Lorem ipsum dolor sit amet',
			'manufacturer_office' => 'Lorem ipsum dolor sit amet',
			'manufacturer_country' => 'Lorem ipsum dolor sit amet',
			'manufacturer_description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'submitted' => '2014-12-18',
			'usage' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'package_note' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'barcode' => 'Lorem ipsum dolor sit amet',
			'md5' => 'Lorem ipsum dolor sit amet'
		),
	);

}
