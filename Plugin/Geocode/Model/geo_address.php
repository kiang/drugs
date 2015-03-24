<?php
class GeoAddress extends AppModel {
	/**
	 * Behaviors
	 *
	 * @var array
	 */
	public $actsAs = array('Geocodable');

	/**
	 * Overriden to implement 'near' find type, and support for 'count' with 'near'
	 *
	 * @param array $conditions SQL conditions array, or type of find operation (all / first / count / neighbors / list / threaded)
	 * @param mixed $fields Either a single string of a field name, or an array of field names, or options for matching
	 * @param string $order SQL ORDER BY conditions (e.g. "price DESC" or "name ASC")
	 * @param integer $recursive The number of levels deep to fetch associated records
	 * @return array Array of records
	 */
	public function find($conditions = null, $fields = array(), $order = null, $recursive = null) {
		$findMethods = array_merge($this->findMethods, array('near'=>true));
		$findType = (is_string($conditions) && $conditions != 'count' && array_key_exists($conditions, $findMethods) ? $conditions : null);
		if (empty($findType) && is_string($conditions) && $conditions == 'count' && !empty($fields['type']) && array_key_exists($fields['type'], $findMethods)) {
			$findType = $fields['type'];
			unset($fields['type']);
		}

		if ($findType == 'near' && $this->Behaviors->enabled('Geocodable')) {
			$type = ($conditions == 'near' ? 'all' : $conditions);
			$query = $fields;
			if (!empty($query['address'])) {
				foreach(array('address', 'unit', 'distance') as $field) {
					$$field = isset($query[$field]) ? $query[$field] : null;
					unset($query[$field]);
				}
				return $this->near($type, $address, $distance, $unit, $query);
			}
		}
		return parent::find($conditions, $fields, $order, $recursive);
	}
}
?>
