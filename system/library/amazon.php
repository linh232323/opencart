<?php
class Amazon {
	private $token;
	private $enc1;
	private $enc2;
	private $url = 'http://uk-amazon.openbaypro.com/';
	private $registry;

	public function __construct($registry) {
		$this->registry = $registry;

		$this->token = $this->config->get('openbay_amazon_token');
		$this->enc1 = $this->config->get('openbay_amazon_enc_string1');
		$this->enc2 = $this->config->get('openbay_amazon_enc_string2');
	}

	public function __get($name) {
		return $this->registry->get($name);
	}

	public function call($method, $data = array(), $is_json = true) {
		if ($is_json) {
			$arg_string = json_encode($data);
		} else {
			$arg_string = $data;
		}

		$crypt = $this->encryptArgs($arg_string);

		$defaults = array(
			CURLOPT_POST            => 1,
			CURLOPT_HEADER          => 0,
			CURLOPT_URL             => $this->url . $method,
			CURLOPT_USERAGENT       => 'OpenBay Pro for Amazon/Opencart',
			CURLOPT_FRESH_CONNECT   => 1,
			CURLOPT_RETURNTRANSFER  => 1,
			CURLOPT_FORBID_REUSE    => 1,
			CURLOPT_TIMEOUT         => 30,
			CURLOPT_SSL_VERIFYPEER  => 0,
			CURLOPT_SSL_VERIFYHOST  => 0,
			CURLOPT_POSTFIELDS      => 'token=' . $this->token . '&data=' . rawurlencode($crypt) . '&opencart_version=' . VERSION,
		);
		$ch = curl_init();

		curl_setopt_array($ch, $defaults);

		$response = curl_exec($ch);

		curl_close($ch);

		return $response;
	}

	public function callNoResponse($method, $data = array(), $is_json = true) {
		if ($is_json) {
			$arg_string = json_encode($data);
		} else {
			$arg_string = $data;
		}

		$crypt = $this->encryptArgs($arg_string);

		$defaults = array(
			CURLOPT_POST => 1,
			CURLOPT_HEADER => 0,
			CURLOPT_URL => $this->url . $method,
			CURLOPT_USERAGENT => 'OpenBay Pro for Amazon/Opencart',
			CURLOPT_FRESH_CONNECT => 1,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_FORBID_REUSE => 1,
			CURLOPT_TIMEOUT => 2,
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_POSTFIELDS => 'token=' . $this->token . '&data=' . rawurlencode($crypt) . '&opencart_version=' . VERSION,
		);
		$ch = curl_init();

		curl_setopt_array($ch, $defaults);

		curl_exec($ch);

		curl_close($ch);
	}

	public function encryptArgs($data) {
		$token = $this->openbay->pbkdf2($this->enc1, $this->enc2, 1000, 32);
		$crypt = $this->openbay->encrypt($data, $token, true);

		return $crypt;
	}

	public function decryptArgs($crypt, $is_base_64 = true) {
		if ($is_base_64) {
			$crypt = base64_decode($crypt, true);
			if (!$crypt) {
				return false;
			}
		}

		$token = $this->openbay->pbkdf2($this->enc1, $this->enc2, 1000, 32);
		$data = $this->openbay->decrypt($crypt, $token);

		return $data;
	}

	public function getServer() {
		return $this->url;
	}

	public function addOrder($order_id) {
		if ($this->config->get('openbay_amazon_status') != 1) {
			return;
		}

		/* Is called from front-end? */
		if (!defined('HTTPS_CATALOG')) {
			$this->load->model('openbay/amazon_order');
			$amazon_order_id = $this->model_openbay_amazon_order->getAmazonOrderId($order_id);

			$this->load->library('log');
			$logger = new Log('amazon_stocks.log');
			$logger->write('addOrder() called with order id: ' . $order_id);

			//Stock levels update
			if ($this->openbay->addonLoad('openstock')) {
				$logger->write('openStock found installed.');

				$os_rooms = $this->osRooms($order_id);
				$logger->write(print_r($os_rooms, true));
				$quantity_data = array();
				foreach ($os_rooms as $os_room) {
					$amazon_sku_rows = $this->getLinkedSkus($os_room['pid'], $os_room['var']);
					foreach($amazon_sku_rows as $amazon_sku_row) {
						$quantity_data[$amazon_sku_row['amazon_sku']] = $os_room['qty_left'];
					}
				}
				if(!empty($quantity_data)) {
					$logger->write('Updating quantities with data: ' . print_r($quantity_data, true));
					$this->updateQuantities($quantity_data);
				} else {
					$logger->write('No quantity data need to be posted.');
				}
			} else {
				$ordered_rooms = $this->getOrderdRooms($order_id);
				$ordered_room_ids = array();
				foreach($ordered_rooms as $ordered_room) {
					$ordered_room_ids[] = $ordered_room['room_id'];
				}
				$this->putStockUpdateBulk($ordered_room_ids);
			}
			$logger->write('addOrder() exiting');
		}
	}

	public function roomUpdateListen($room_id, $data) {
		$logger = new Log('amazon_stocks.log');
		$logger->write('roomUpdateListen called for room id: ' . $room_id);

		if ($this->openbay->addonLoad('openstock') && (isset($data['has_option']) && $data['has_option'] == 1)) {
			$logger->write('openStock found installed and room has options.');
			$quantity_data = array();
			foreach($data['room_option_stock'] as $opt_stock) {
				$amazon_sku_rows = $this->getLinkedSkus($room_id, $opt_stock['var']);
				foreach($amazon_sku_rows as $amazon_sku_row) {
					$quantity_data[$amazon_sku_row['amazon_sku']] = $opt_stock['stock'];
				}
			}
			if(!empty($quantity_data)) {
				$logger->write('Updating quantities with data: ' . print_r($quantity_data, true));
				$this->updateQuantities($quantity_data);
			} else {
				$logger->write('No quantity data need to be posted.');
			}

		} else {
			$this->putStockUpdateBulk(array($room_id));
		}
		$logger->write('roomUpdateListen() exiting');
	}

	public function bulkUpdateOrders($orders) {
		// Is the module enabled and called from admin?
		if ($this->config->get('openbay_amazon_status') != 1 || !defined('HTTPS_CATALOG')) {
			return;
		}
		$this->load->model('openbay/amazon');

		$log = new Log('amazon.log');
		$log->write('Called bulkUpdateOrders method');

		$request = array(
			'orders' => array(),
		);

		foreach ($orders as $order) {
			$amazon_order = $this->getOrder($order['order_id']);
			$amazon_order_rooms = $this->model_openbay_amazon->getAmazonOrderedRooms($order['order_id']);

			$rooms = array();

			foreach ($amazon_order_rooms as $amazon_order_room) {
				$rooms[] = array(
					'amazon_order_item_id' => $amazon_order_room['amazon_order_item_id'],
					'quantity' => $amazon_order_room['quantity'],
				);
			}

			$order_info = array(
				'amazon_order_id' => $amazon_order['amazon_order_id'],
				'status' => $order['status'],
				'rooms' => $rooms,
			);

			if ($order['status'] == 'shipped' && !empty($order['carrier'])) {
				if ($order['carrier_from_list']) {
					$order_info['carrier_id'] = $order['carrier'];
				} else {
					$order_info['carrier_name'] = $order['carrier'];
				}

				$order_info['tracking'] = $order['tracking'];
			}

			$request['orders'][] = $order_info;
		}

		$log->write('order/bulkUpdate call: ' . print_r($request, 1));

		$response = $this->call('order/bulkUpdate', $request);

		$log->write('order/bulkUpdate response: ' . $response);
	}

	public function updateOrder($order_id, $order_status_string, $courier_id = '', $courier_from_list = true, $tracking_no = '') {

		if ($this->config->get('openbay_amazon_status') != 1) {
			return;
		}

		/* Is called from admin? */
		if (!defined('HTTPS_CATALOG')) {
			return;
		}

		$amazon_order = $this->getOrder($order_id);

		if(!$amazon_order) {
			return;
		}

		$amazon_order_id = $amazon_order['amazon_order_id'];

		$log = new Log('amazon.log');
		$log->write("Order's $amazon_order_id status changed to $order_status_string");

		$this->load->model('openbay/amazon');
		$amazon_order_rooms = $this->model_openbay_amazon->getAmazonOrderedRooms($order_id);

		$request_node = new SimpleXMLElement('<Request/>');

		$request_node->addChild('AmazonOrderId', $amazon_order_id);
		$request_node->addChild('Status', $order_status_string);

		if(!empty($courier_id)) {
			if($courier_from_list) {
				$request_node->addChild('CourierId', $courier_id);
			} else {
				$request_node->addChild('CourierOther', $courier_id);
			}
			$request_node->addChild('TrackingNo', $tracking_no);
		}

		$order_items_node = $request_node->addChild('OrderItems');

		foreach ($amazon_order_rooms as $room) {
			$new_order_item = $order_items_node->addChild('OrderItem');
			$new_order_item->addChild('ItemId', htmlspecialchars($room['amazon_order_item_id']));
			$new_order_item->addChild('Quantity', (int)$room['quantity']);
		}

		$doc = new DOMDocument('1.0');
		$doc->preserveWhiteSpace = false;
		$doc->loadXML($request_node->asXML());
		$doc->formatOutput = true;

		$this->model_openbay_amazon->updateAmazonOrderTracking($order_id, $courier_id, $courier_from_list, !empty($courier_id) ? $tracking_no : '');
		$log->write('Request: ' . $doc->saveXML());
		$response = $this->call('order/update2', $doc->saveXML(), false);
		$log->write("Response for Order's status update: $response");
	}

	public function getCategoryTemplates() {
		$result = $this->call("roomv2/RequestTemplateList");
		if(isset($result)) {
			return (array)json_decode($result);
		} else {
			return array();
		}
	}

	public function registerInsertion($data) {
		$result = $this->call("roomv2/RegisterInsertionRequest", $data);
		if(isset($result)) {
			return (array)json_decode($result);
		} else {
			return array();
		}
	}

	public function insertRoom($data) {
		$result = $this->call("roomv2/InsertRoomRequest", $data);
		if(isset($result)) {
			return (array)json_decode($result);
		} else {
			return array();
		}
	}

	public function updateQuantities($data) {
		$result = $this->call("room/UpdateQuantityRequest", $data);
		if(isset($result)) {
			return (array)json_decode($result);
		} else {
			return array();
		}
	}

	public function getStockUpdatesStatus($data) {
		$result = $this->call("status/StockUpdates", $data);
		if(isset($result)) {
			return $result;
		} else {
			return false;
		}
	}

	public function putStockUpdateBulk($room_id_array, $end_inactive = false){
		$this->load->library('log');
		$logger = new Log('amazon_stocks.log');
		$logger->write('Updating stock using putStockUpdateBulk()');
		$quantity_data = array();
		foreach($room_id_array as $room_id) {
			$amazon_rows = $this->getLinkedSkus($room_id);
			foreach($amazon_rows as $amazon_row) {
				$room_row = $this->db->query("SELECT `quantity`, `status` FROM `" . DB_PREFIX . "room` WHERE `room_id` = '" . (int)$room_id . "'")->row;

				if(!empty($room_row)) {
					if($end_inactive && $room_row['status'] == '0') {
						$quantity_data[$amazon_row['amazon_sku']] = 0;
					} else {
						$quantity_data[$amazon_row['amazon_sku']] = $room_row['quantity'];
					}
				}
			}
		}
		if(!empty($quantity_data)) {
			$logger->write('Quantity data to be sent:' . print_r($quantity_data, true));
			$response = $this->updateQuantities($quantity_data);
			$logger->write('Submit to API. Response: ' . print_r($response, true));
		} else {
			$logger->write('No quantity data need to be posted.');
		}
	}

	public function getLinkedSkus($room_id, $var='') {
		return $this->db->query("SELECT `amazon_sku` FROM `" . DB_PREFIX . "amazon_room_link` WHERE `room_id` = '" . (int)$room_id . "' AND `var` = '" . $this->db->escape($var) . "'")->rows;
	}

	public function getOrderdRooms($order_id) {
		return $this->db->query("SELECT `op`.`room_id`, `p`.`quantity` as `quantity_left` FROM `" . DB_PREFIX . "order_room` as `op` LEFT JOIN `" . DB_PREFIX . "room` as `p` ON `p`.`room_id` = `op`.`room_id` WHERE `op`.`order_id` = '" . (int)$order_id . "'")->rows;
	}

	public function osRooms($order_id){
		$order_room_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_room` WHERE `order_id` = '" . (int)$order_id . "'");

		$pass_array = array();
		foreach ($order_room_query->rows as $order_room) {
			$room_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "room` WHERE `room_id` = '" . (int)$order_room['room_id'] . "' LIMIT 1");

			if (!empty($room_query->row)) {
				if (isset($room_query->row['has_option']) && ($room_query->row['has_option'] == 1)) {
					$room_option_query = $this->db->query("
						SELECT `oo`.`room_option_value_id`
						FROM `" . DB_PREFIX . "order_option` `oo`
							LEFT JOIN `" . DB_PREFIX . "room_option_value` `pov` ON (`pov`.`room_option_value_id` = `oo`.`room_option_value_id`)
							LEFT JOIN `" . DB_PREFIX . "option` `o` ON (`o`.`option_id` = `pov`.`option_id`)
						WHERE `oo`.`order_room_id` = '" . (int)$order_room['order_room_id'] . "'
						AND `oo`.`order_id` = '" . (int)$order_id . "'
						AND ((`o`.`type` = 'radio') OR (`o`.`type` = 'select') OR (`o`.`type` = 'image'))
						ORDER BY `oo`.`order_option_id`
						ASC");

					if ($room_option_query->num_rows != 0) {
						$p_options = array();
						foreach ($room_option_query->rows as $p_option_row) {
							$p_options[] = $p_option_row['room_option_value_id'];
						}

						$var = implode(':', $p_options);
						$quantity_left_row = $this->db->query("SELECT `stock` FROM `" . DB_PREFIX . "room_option_relation` WHERE `room_id` = '" . (int)$order_room['room_id'] . "' AND `var` = '" . $this->db->escape($var) . "'")->row;

						if(empty($quantity_left_row)) {
							$quantity_left_row['stock'] = 0;
						}

						$pass_array[] = array('pid' => $order_room['room_id'], 'qty_left' => $quantity_left_row['stock'], 'var' => $var);
					}
				} else {
					$pass_array[] = array('pid' => $order_room['room_id'], 'qty_left' => $room_query->row['quantity'], 'var' => '');
				}
			}
		}

		return $pass_array;
	}

	public function validate(){
		if($this->config->get('openbay_amazon_status') != 0 &&
			$this->config->get('openbay_amazon_token') != '' &&
			$this->config->get('openbay_amazon_enc_string1') != '' &&
			$this->config->get('openbay_amazon_enc_string2') != ''){
			return true;
		}else{
			return false;
		}
	}

	public function deleteRoom($room_id){
		$this->db->query("DELETE FROM `" . DB_PREFIX . "amazon_room_link` WHERE `room_id` = '" . $this->db->escape($room_id) . "'");
	}

	public function orderDelete($order_id){
		/**
		 * @todo
		 */
	}

	public function getOrder($order_id) {
		$qry = $this->db->query("SELECT * FROM `" . DB_PREFIX . "amazon_order` WHERE `order_id` = '" . (int)$order_id . "' LIMIT 1");

		if($qry->num_rows > 0){
			return $qry->row;
		}else{
			return false;
		}
	}

	public function getCarriers() {
		return array(
			"Blue Package",
			"Canada Post",
			"City Link",
			"DHL",
			"DHL Global Mail",
			"Fastway",
			"FedEx",
			"FedEx SmartPost",
			"GLS",
			"GO!",
			"Hermes Logistik Gruppe",
			"Newgistics",
			"NipponExpress",
			"OSM",
			"OnTrac",
			"Parcelforce",
			"Royal Mail",
			"SagawaExpress",
			"Streamlite",
			"TNT",
			"Target",
			"UPS",
			"UPS Mail Innovations",
			"USPS",
			"YamatoTransport",
		);
	}

	public function parseCategoryTemplate($xml) {
		$simplexml = null;

		libxml_use_internal_errors(true);
		if(($simplexml = simplexml_load_string($xml)) == false) {
			return false;
		}

		$category = (string)$simplexml->filename;

		$tabs = array();
		foreach($simplexml->tabs->tab as $tab) {
			$attributes = $tab->attributes();
			$tabs[] = array(
				'id' => (string)$attributes['id'],
				'name' => (string)$tab->name,
			);
		}

		$fields = array();
		$field_types = array('required', 'desired', 'optional');
		foreach ($field_types as $type) {
			foreach ($simplexml->fields->$type->field as $field) {
				$attributes = $field->attributes();
				$fields[] = array(
					'name' => (string)$attributes['name'],
					'title' => (string)$field->title,
					'definition' => (string)$field->definition,
					'accepted' => (array)$field->accepted,
					'type' => (string)$type,
					'child' => false,
					'order' => (isset($attributes['order'])) ? (string)$attributes['order'] : '',
					'tab' => (string)$attributes['tab'],
				);
			}
			foreach ($simplexml->fields->$type->childfield as $field) {
				$attributes = $field->attributes();
				$fields[] = array(
					'name' => (string)$attributes['name'],
					'title' => (string)$field->title,
					'definition' => (string)$field->definition,
					'accepted' => (array)$field->accepted,
					'type' => (string)$type,
					'child' => true,
					'parent' => (array)$field->parent,
					'order' => (isset($attributes['order'])) ? (string)$attributes['order'] : '',
					'tab' => (string)$attributes['tab'],
				);
			}
		}

		foreach($fields as $index => $field) {
			$fields[$index]['unordered_index'] = $index;
		}

		usort($fields, array('Amazon','compareFields'));

		return array(
			'category' => $category,
			'fields' => $fields,
			'tabs' => $tabs,
		);
	}

	private static function compareFields($field1, $field2) {
		if($field1['order'] == $field2['order']) {
			return ($field1['unordered_index'] < $field2['unordered_index']) ? -1 : 1;
		} else if(!empty($field1['order']) && empty($field2['order'])) {
			return -1;
		} else if(!empty($field2['order']) && empty($field1['order'])) {
			return 1;
		} else {
			return ($field1['order'] < $field2['order']) ? -1 : 1;
		}
	}
}