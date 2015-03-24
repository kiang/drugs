<?php
class GeomapHelper extends AppHelper {
	/**
	 * Helpers
	 *
	 * @var array
	 */
	public $helpers = array('Html', 'Javascript');

	/**
	 * Service information
	 *
	 * @var array
	 */
	protected $services = array(
		'google' => array(
			'url' => 'http://www.google.com/jsapi?key=${key}'
		),
		'yahoo' => array(
			'url' => 'http://api.maps.yahoo.com/ajaxymap?v=3.8&appid=${key}'
		)
	);

	/**
     * Tells if JS resource was included
	 *
	 * @var bool
	 */
	private $included = false;

	/**
	 * Get map HTML + JS code
	 *
	 * @param array $center If specified, center map in this location
	 * @param array $markers Add these markers (each marker is array('point' => (x, y), 'title' => '', 'content' => ''))
	 * @param array $parameters Parameters (service, key, id, width, height, zoom, div)
	 * @return string HTML + JS code
	 */
	public function map($center = null, $markers = array(), $parameters = array()) {
		$parameters = array_merge(array(
			'service' => Configure::read('Geocode.service'),
			'key' => Configure::read('Geocode.key'),
			'id' => null,
			'width' => 500,
			'height' => 300,
			'zoom' => 10,
			'div' => array('class'=>'map'),
			'type' => 'street',
			'layout' => Configure::read('Geocode.layout'),
			'layouts' => array(
				'default' => array(
					'pan',
					'scale',
					'types',
					'zoom'
				),
				'simple' => false
			)
		), $parameters);

		if (empty($parameters['layout'])) {
			$parameters['layout'] = 'default';
		}

		if (empty($parameters['service'])) {
			$parameters['service'] = 'google';
		}
		$service = strtolower($parameters['service']);
		if (!isset($this->services[$service])) {
			return false;
		}

		if (!$this->included) {
			$this->included = true;
			$this->Javascript->link(str_replace('${key}', $parameters['key'], $this->services[$service]['url']), false);
		}

		$out = '';

		if (empty($parameters['id'])) {
			$parameters['id'] = 'map_' . Security::hash(uniqid(time(), true));
		}

		if ($parameters['div'] !== false) {
			$out .= $this->Html->div(
				!empty($parameters['div']['class']) ? $parameters['div']['class'] : null,
				'<!-- ' . $service . ' map -->',
				array_merge($parameters['div'], array('id'=>$parameters['id']))
			);
		}

		if (!empty($markers)) {
			foreach($markers as $i => $marker) {
				if (is_array($marker) && count($marker) == 2 && isset($marker[0]) && isset($marker[1]) && is_numeric($marker[0]) && is_numeric($marker[1])) {
					$marker = array('point' => $marker);
				}
				$marker = array_merge(array(
					'point' => null,
					'title' => null,
					'content' => null,
					'icon' => null,
					'shadow' => null
				), $marker);

				if (empty($marker['point'])) {
					unset($markers[$i]);
					continue;
				}

				foreach(array('title', 'content') as $parameter) {
					if (!empty($marker[$parameter])) {
						$marker[$parameter] = str_replace(
							array('"', "\n"),
							array('\\"', '\\n'),
							$marker[$parameter]
						);
					}
				}

				$markers[$i] = $marker;
			}
			$markers = array_values($markers);
		}

		if (empty($center)) {
			$center = !empty($markers) ? $markers[0]['point'] : array(0, 0);
		}

		if (!empty($parameters['layout'])) {
			if (!is_array($parameters['layout'])) {
				if (!array_key_exists($parameters['layout'], $parameters['layouts'])) {
					$parameters['layout'] = 'default';
				}
				$parameters['layout'] = $parameters['layouts'][$parameters['layout']];
			}
		}

		$out .= $this->{'_'.$service}($parameters['id'], $center, $markers, $parameters);
		return $out;
	}

	/**
	 * Google Map
	 *
	 * @param string $id Container ID
	 * @param array $center If specified, center map in this location
	 * @param array $markers Add these markers (each marker is array('point' => (x, y), 'title' => '', 'content' => ''))
	 * @param array $parameters Parameters (service, version, key, id, width, height, zoom, div)
	 * @return string HTML + JS code
	 */
	protected function _google($id, $center, $markers, $parameters) {
		$parameters = array_merge(array(
			'version' => 2
		), $parameters);

		if ($parameters['version'] >= 3) {
			$mapTypes = array(
				'street' => 'google.maps.MapTypeId.ROADMAP',
				'satellite' => 'google.maps.MapTypeId.SATELLITE',
				'hybrid' => 'google.maps.MapTypeId.HYBRID',
				'terrain' => 'google.maps.MapTypeId.TERRAIN'
			);
			$layouts = array(
				'elements' => array(
					'scale' => 'scaleControl',
					'types' => 'mapTypeControl',
					'zoom' => 'navigationControl',
					'pan' => 'navigationControl'
				)
			);
		} else {
			$mapTypes = array(
				'street' => 'google.maps.maptypes.normal',
				'satellite' => 'google.maps.maptypes.satellite',
				'hybrid' => 'google.maps.maptypes.hybrid',
				'terrain' => 'google.maps.maptypes.physical'
			);
			$layouts = array(
				'elements' => array(
					'scale' => 'google.maps.ScaleControl',
					'types' => 'google.maps.MapTypeControl',
					'zoom' => 'google.maps.LargeMapControl3D',
					'pan' => 'google.maps.LargeMapControl3D'
				)
			);
		}

		if (!empty($parameters['layout'])) {
			foreach($parameters['layout'] as $element => $enabled) {
				unset($parameters['layout'][$element]);
				if (is_numeric($element)) {
					$element = $enabled;
					$enabled = true;
				}
				$parameters['layout'][$element] = $enabled;
			}
		}

		$varName = 'm' . $id;
		$script = 'var ' . $varName . '_Callback = function() {';

		if ($parameters['version'] >= 3) {
			$script .= '
				var mapOptions = {
					mapTypeId: ' . $mapTypes[$parameters['type']] . ',
					disableDefaultUI: true
				};
			';

			if (!empty($parameters['width']) && !empty($parameters['height'])) {
				$script .= '
					mapOptions.size = new google.maps.Size(' . $parameters['width'] . ', ' . $parameters['height'] . ');
				';
			}

			if (!empty($center)) {
				list($latitude, $longitude) = $center;
				$script .= '
					mapOptions.center = new google.maps.LatLng(' . $latitude . ', ' .	$longitude . ');
				';
			}

			if (!empty($parameters['zoom'])) {
				$script .= '
					mapOptions.zoom = ' . $parameters['zoom'] . ';
				';
			}

			if (!empty($parameters['layout'])) {
				foreach($parameters['layout'] as $element => $enabled) {
					if (empty($layouts['elements'][$element])) {
						continue;
					} else if ($element == 'zoom' && !empty($parameters['layout']['pan'])) {
						continue;
					}

					$key = $layouts['elements'][$element];
					$value = !empty($enabled) ? 'true' : 'false';
					if ($element == 'zoom' && empty($parameters['layout']['pan'])) {
						$value = 'google.maps.NavigationControlStyle.SMALL';
					} elseif ($element == 'pan') {
						$value = 'google.maps.NavigationControlStyle.ZOOM_PAN';
					}

					if (!in_array($value, array('true', 'false'))) {
						$script .= '
							mapOptions.' . $key . ' = true;
							mapOptions.' . $key . 'Options = { style: ' . $value . ' };
						';
					} else {
						$script .= '
							mapOptions.' . $key . ' = ' . $value . ';
						';
					}
				}
			}

			$script .= $varName . ' = new google.maps.Map(document.getElementById("' . $id . '"), mapOptions);';

		} else {
			$script .= '
			if (!google.maps.BrowserIsCompatible()) {
				return false;
			}

			var mapOptions = {};
			';

			if (!empty($parameters['width']) && !empty($parameters['height'])) {
				$script .= '
					mapOptions.size = new google.maps.Size(' . $parameters['width'] . ', ' . $parameters['height'] . ');
				';
			}

			$script .= $varName . ' = new google.maps.Map2(document.getElementById("' . $id . '"), mapOptions);';

			if (!empty($center)) {
				list($latitude, $longitude) = $center;
				$script .= $varName . '.setCenter(
					new google.maps.LatLng(' . $latitude . ', ' . $longitude . ')' .
					(!empty($parameters['zoom']) ? ', ' . $parameters['zoom'] : '') . '
				);';
			}

			if (!empty($parameters['layout'])) {
				foreach($parameters['layout'] as $element => $enabled) {
					if (empty($layouts['elements'][$element])) {
						continue;
					} else if ($element == 'zoom' && !empty($parameters['layout']['pan'])) {
						continue;
					} else if (!$enabled) {
						continue;
					}

					$script .= $varName . '.addControl(new ' . $layouts['elements'][$element] . '());';
				}
			}
		}

		if (!empty($markers)) {
			foreach($markers as $marker) {
				$markerOptions = array(
					'title' => null,
					'content' => null,
					'icon' => null,
					'shadow' => null
				);
				$markerOptions = array_filter(array_intersect_key($marker, $markerOptions));
				$content = (!empty($markerOptions['content']) ? $markerOptions['content'] : null);

				list($latitude, $longitude) = $marker['point'];

				if ($parameters['version'] >= 3) {
					$script .= '
						marker = new google.maps.Marker({
							map: ' . $varName . ',
							position: new google.maps.LatLng(' . $latitude . ', ' . $longitude . '),
							title: "' . (!empty($markerOptions['title']) ? $markerOptions['title'] : '') . '",
							clickable: ' . (!empty($content) ? 'true' : 'false') . ',
							icon: ' . (!empty($markerOptions['icon']) ? '"' . $markerOptions['icon'] . '"' : 'null') . ',
							shadow: ' . (!empty($markerOptions['shadow']) ? '"' . $markerOptions['shadow'] . '"' : 'null') . '
						});
					';

					if (!empty($content)) {
						$script .= '
							infoWindow = new google.maps.InfoWindow({
								content: "' . $content . '"
							});
							google.maps.event.addListener(marker, \'click\', function() {
								infoWindow.open(' . $varName . ', marker);
							});
						';

					}
				} else {
					$script .= 'markerOptions = {};';

					if (!empty($markerOptions['icon'])) {
						$script .= '
							markerIcon = new google.maps.Icon(google.maps.DEFAULT_ICON);
							markerIcon.image = "' . $markerOptions['icon'] . '";
							markerOptions.icon = markerIcon;
						';
					}

					$script .= 'marker = new google.maps.Marker(new google.maps.LatLng(' . $latitude . ', ' . $longitude . '), markerOptions);';
					$script .= $varName . '.addOverlay(marker);';

					if (!empty($content)) {
						$script .= 'google.maps.Event.addListener(marker, \'click\', function() {
							marker.openInfoWindowHtml("' . $content . '");
						});
						';
					}
				}
			}
		}

		$script .= '
			' . $varName . '.__version__ = ' . $parameters['version'] . ';
		}

		var ' . $varName . ' = null;
		google.load("maps", "' . $parameters['version'] . '", {
			other_params: "sensor=' . (!empty($parameters['sensor']) ? 'true' : 'false') . '",
			callback: ' . $varName . '_Callback
		});';

		return $this->Javascript->codeBlock($script);
	}

	/**
	 * Yahoo Map
	 *
	 * @param string $id Container ID
	 * @param array $center If specified, center map in this location
	 * @param array $markers Add these markers (each marker is array('point' => (x, y), 'title' => '', 'content' => ''))
	 * @param array $parameters Parameters (service, key, id, width, height, zoom, div)
	 * @return string HTML + JS code
	 */
	protected function _yahoo($id, $center, $markers, $parameters) {
		$varName = 'm' . $id;
		$mapTypes = array(
			'street' => 'YAHOO_MAP_REG',
			'satellite' => 'YAHOO_MAP_SAT',
			'hybrid' => 'YAHOO_MAP_HYB'
		);
		$layouts = array(
			'elements' => array(
				'pan' => '${var}.addPanControl()',
				'scale' => '${var}.addZoomScale()',
				'types' => '${var}.addTypeControl()',
				'zoom' => '${var}.addZoomLong()'
			)
		);

		$script = '
			var ' . $varName . ' = new YMap(document.getElementById("' . $id . '"));
		';

		$script .= $varName . '.setMapType(' . $mapTypes[$parameters['type']] . ');' . "\n";

		if (!empty($center)) {
			list($latitude, $longitude) = $center;
			$script .= $varName . '.drawZoomAndCenter(new YGeoPoint(' . $latitude . ', ' . $longitude . '));' . "\n";
		}

		if (!empty($parameters['width']) && !empty($parameters['height'])) {
			$script .= $varName . '.resizeTo(new YSize(' . $parameters['width'] . ', ' . $parameters['height'] . '));' . "\n";
		}

		if (!empty($parameters['zoom'])) {
			$script .= $varName . '.setZoomLevel(' . $parameters['zoom'] . ');' . "\n";
		}

		$script .= $varName . '.removeZoomScale();' . "\n";

		if (!empty($parameters['layout'])) {
			foreach($parameters['layout'] as $element => $enabled) {
				unset($parameters['layout'][$element]);
				if (is_numeric($element)) {
					$element = $enabled;
					$enabled = true;
				}
				$parameters['layout'][$element] = $enabled;
			}

			foreach($parameters['layout'] as $element => $enabled) {
				if ($enabled && !empty($layouts['elements'][$element])) {
					$script .= str_replace('${var}', $varName, $layouts['elements'][$element]) . ';' . "\n";
				}
			}
		}

		if (!empty($markers)) {
			foreach($markers as $marker) {
				list($latitude, $longitude) = $marker['point'];
				$script .= 'content = null' . "\n";
				if (!empty($marker['content'])) {
					$script .= 'content = "' . $marker['content'] . '";' . "\n";
				}
				$script .= '
					marker = new YMarker(new YGeoPoint(' . $latitude . ', ' . $longitude . '));
					YEvent.Capture(marker, EventsList.MouseClick, function(o) {
						marker.openSmartWindow(content);
					});
					' . $varName . '.addOverlay(marker);
				';
			}
		}

		return $this->Javascript->codeBlock($script);
	}
}
?>
