<?php
class ModelOpenbayAmazonus extends Model {
	public function install() {
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "amazonus_order` (
			  `order_id` int(11) NOT NULL ,
			  `amazonus_order_id` char(19) NOT NULL ,
			  `courier_id` varchar(255) NOT NULL ,
			  `courier_other` tinyint(1) NOT NULL,
			  `tracking_no` varchar(255) NOT NULL ,
			  PRIMARY KEY (`order_id`, `amazonus_order_id`)
		) DEFAULT COLLATE=utf8_general_ci;");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "amazonus_order_room` (
				`order_room_id` int(11) NOT NULL ,
				`amazonus_order_item_id` varchar(255) NOT NULL,
				PRIMARY KEY(`order_room_id`, `amazonus_order_item_id`)
		);");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "amazonus_room_unshipped` (
				`order_id` int(11) NOT NULL,
				`room_id` int(11) NOT NULL,
				`quantity` int(11) NOT NULL DEFAULT '0',
				PRIMARY KEY (`order_id`,`room_id`)
			) DEFAULT COLLATE=utf8_general_ci;;");

		$this->db->query("
		CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "amazonus_room` (
		  `version` int(11) NOT NULL DEFAULT 2,
		  `room_id`  int(11) NOT NULL ,
		  `category`  varchar(255) NOT NULL ,
		  `sku`  varchar(255) NOT NULL ,
		  `insertion_id` varchar(255) NOT NULL ,
		  `data`  text NOT NULL ,
		  `status` enum('saved','uploaded','ok','error') NOT NULL ,
		  `price`  decimal(15,4) NOT NULL COMMENT 'Price on Amazonus' ,
		  `var` char(100) NOT NULL DEFAULT '',
		  `marketplaces` text NOT NULL ,
		  `messages` text NOT NULL,
		  PRIMARY KEY (`room_id`, `var`)
		);");

		$this->db->query("
		CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "amazonus_room_error` (
		  `error_id` int(11) NOT NULL AUTO_INCREMENT,
		  `sku` varchar(255) NOT NULL ,
		  `insertion_id` varchar(255) NOT NULL ,
		  `error_code` int(11) NOT NULL ,
		  `message` text NOT NULL ,
		  PRIMARY KEY (`error_id`)
		);");

		$this->db->query("
		CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "amazonus_room_link` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `amazonus_sku` varchar(255) NOT NULL,
		  `var` char(100) NOT NULL DEFAULT '',
		  `room_id` int(11) NOT NULL,
		  PRIMARY KEY (`id`)
		) DEFAULT COLLATE=utf8_general_ci;");

		$this->db->query("
		CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "amazonus_room_search` (
			`room_id` int(11) NOT NULL,
			`status` enum('searching','finished') NOT NULL,
			`matches` int(11) DEFAULT NULL,
			`data` text,
			PRIMARY KEY (`room_id`)
		) DEFAULT COLLATE=utf8_general_ci;");

		$this->db->query("
			CREATE TABLE IF NOT EXISTS`" . DB_PREFIX . "amazonus_listing_report` (
				`sku` varchar(255) NOT NULL,
				`quantity` int(10) unsigned NOT NULL,
				`asin` varchar(255) NOT NULL,
				`price` decimal(10,4) NOT NULL,
				PRIMARY KEY (`sku`)
			) DEFAULT COLLATE=utf8_general_ci;
		");

		// register the event triggers
		$this->model_extension_event->addEvent('openbaypro_amazonus', 'post.order.add', 'openbay/amazonus/eventAddOrder');
	}

	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "amazonus_order`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "amazonus_order_room`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "amazonus_room2`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "amazonus_room`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "amazonus_room_link`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "amazonus_room_unshipped`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "amazonus_room_error`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "amazonus_process`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "amazonus_room_search`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "amazonus_listing_report`");

		$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE `code` = 'openbay_amazonus'");

		// remove the event triggers
		$this->model_extension_event->deleteEvent('openbaypro_amazonus');
	}

	public function patch($manual = true) {
		$this->load->model('setting/setting');

		$settings = $this->model_setting_setting->getSetting('openbay_amazonus');

		if ($settings) {
			$this->db->query("
				CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "amazonus_room_search` (
					`room_id` int(11) NOT NULL,
					`status` enum('searching','finished') NOT NULL,
					`matches` int(11) DEFAULT NULL,
					`data` text,
					PRIMARY KEY (`room_id`)
				) DEFAULT COLLATE=utf8_general_ci;");

			$this->db->query("
				CREATE TABLE IF NOT EXISTS`" . DB_PREFIX . "amazonus_listing_report` (
					`sku` varchar(255) NOT NULL,
					`quantity` int(10) unsigned NOT NULL,
					`asin` varchar(255) NOT NULL,
					`price` decimal(10,4) NOT NULL,
					PRIMARY KEY (`sku`)
				) DEFAULT COLLATE=utf8_general_ci;
			");
		}

		return true;
	}

	public function scheduleOrders($data) {
		$log = new Log('amazonus.log');

		$request_xml = '<Request>
  <ResponseURL>' . HTTPS_CATALOG . 'index.php?route=openbay/amazonus/order' . '</ResponseURL>
  <MarketplaceIDs>';

		foreach ($data['openbay_amazonus_orders_marketplace_ids'] as $marketplace_id) {
			$request_xml .= '    <MarketplaceID>' . $marketplace_id . '</MarketplaceID>';
		}

		$request_xml .= '
  </MarketplaceIDs>
</Request>';

		$response = $this->openbay->amazonus->call('order/scheduleOrders', $request_xml, false);

		libxml_use_internal_errors(true);
		$response_xml = simplexml_load_string($response);
		libxml_use_internal_errors(false);

		if ($response_xml && $response_xml->Status == '0') {
			$log->write('Scheduling orders call was successful');
			return true;
		}

		$log->write('Failed to schedule orders. Response: ' . $response);

		return false;
	}

	public function saveRoom($room_id, $data_array) {
		if (isset($data_array['fields']['item-price'])) {
			$price = $data_array['fields']['item-price'];
		} else if (isset($data_array['fields']['price'])) {
			$price = $data_array['fields']['price'];
		} else if (isset($data_array['fields']['StandardPrice'])) {
			$price = $data_array['fields']['StandardPrice'];
		}   else {
			$price = 0;
		}

		$category = (isset($data_array['category'])) ? $data_array['category'] : "";
		$sku = (isset($data_array['fields']['sku'])) ? $data_array['fields']['sku'] : "";
		if (isset($data_array['fields']['sku'])) {
			$sku = $data_array['fields']['sku'];
		} else if (isset($data_array['fields']['SKU'])) {
			$sku = $data_array['fields']['SKU'];
		}

		$var = isset($data_array['optionVar']) ? $data_array['optionVar'] : '';

		$marketplaces = isset($data_array['marketplace_ids']) ? serialize($data_array['marketplace_ids']) : serialize(array());

		$data_encoded = json_encode(array('fields' => $data_array['fields']));

		$this->db->query("
			REPLACE INTO `" . DB_PREFIX . "amazonus_room`
			SET `room_id` = '" . (int)$room_id . "',
				`sku` = '" . $this->db->escape($sku) . "',
				`category` = '" . $this->db->escape($category) . "',
				`data` = '" . $this->db->escape($data_encoded) . "',
				`status` = 'saved',
				`insertion_id` = '',
				`price` = '" . $price . "',
				`var` = '" . $this->db->escape($var) . "',
				`marketplaces` = '" . $this->db->escape($marketplaces) . "'");
	}

	public function deleteSaved($room_id, $var = '') {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "amazonus_room`
			WHERE `room_id` = '" . (int)$room_id . "' AND `var` = '" . $this->db->escape($var) . "'");
	}

	public function getSavedRooms() {
		return $this->db->query("
			SELECT `ap`.`status`, `ap`.`room_id`, `ap`.`sku` as `amazonus_sku`, `pd`.`name` as `room_name`, `p`.`model` as `room_model`, `p`.`sku` as `room_sku`, `ap`.`var` as `var`
			FROM `" . DB_PREFIX . "amazonus_room` as `ap`
			LEFT JOIN `" . DB_PREFIX . "room_description` as `pd`
			ON `ap`.`room_id` = `pd`.`room_id`
			LEFT JOIN `" . DB_PREFIX . "room` as `p`
			ON `ap`.`room_id` = `p`.`room_id`
			WHERE `ap`.`status` = 'saved'
			AND `pd`.`language_id` = '" . (int)$this->config->get('config_language_id') . "'")->rows;
	}

	public function getSavedRoomsData() {
		return $this->db->query("
			SELECT * FROM `" . DB_PREFIX . "amazonus_room`
			WHERE `status` = 'saved' AND `version` = 2")->rows;
	}

	public function getRoom($room_id, $var = '') {
		return $this->db->query("
			SELECT * FROM `" . DB_PREFIX . "amazonus_room`
			WHERE `room_id` = '" . (int)$room_id . "' AND `var` = '" . $this->db->escape($var) . "' AND `version` = 2")->row;
	}

	public function getProductCategory($room_id, $var = '') {
		$row = $this->db->query("
			SELECT `category` FROM `" . DB_PREFIX . "amazonus_room`
			WHERE `room_id` = '" . (int)$room_id . "' AND `var` = '" . $this->db->escape($var) . "' AND `version` = 2")->row;
		if (isset($row['category'])) {
			return $row['category'];
		} else {
			return "";
		}
	}

	public function setRoomUploaded($room_id, $insertion_id, $var = '') {
		$this->db->query(
			"UPDATE `" . DB_PREFIX . "amazonus_room`
			SET `status` = 'uploaded', `insertion_id` = '" . $this->db->escape($insertion_id) . "'
			WHERE `room_id` = '" . (int)$room_id . "' AND `var` = '" . $this->db->escape($var) . "' AND `version` = 2");
	}

	public function resetUploaded($insertion_id) {
		$this->db->query(
			"UPDATE `" . DB_PREFIX . "amazonus_room`
			SET `status` = 'saved', `insertion_id` = ''
			WHERE `insertion_id` = '" . $this->db->escape($insertion_id) . "' AND `version` = 2");
	}

	public function getRoomStatus($room_id) {

		$rows_uploaded = $this->db->query("
			SELECT COUNT(*) count
			FROM `" . DB_PREFIX . "amazonus_room`
			WHERE `room_id` = '" . (int)$room_id . "' AND status = 'uploaded'")->row;
		$rows_uploaded = $rows_uploaded['count'];

		$rows_ok = $this->db->query("
			SELECT COUNT(*) count
			FROM `" . DB_PREFIX . "amazonus_room`
			WHERE `room_id` = '" . (int)$room_id . "' AND status = 'ok'")->row;
		$rows_ok = $rows_ok['count'];

		$rows_error = $this->db->query("
			SELECT COUNT(*) count
			FROM `" . DB_PREFIX . "amazonus_room`
			WHERE `room_id` = '" . (int)$room_id . "' AND status = 'error'")->row;
		$rows_error = $rows_error['count'];

		$rows_saved = $this->db->query("
			SELECT COUNT(*) count
			FROM `" . DB_PREFIX . "amazonus_room`
			WHERE `room_id` = '" . (int)$room_id . "' AND status = 'saved'")->row;
		$rows_saved = $rows_saved['count'];

		$rows_total = $rows_uploaded + $rows_ok + $rows_error + $rows_saved;

		$links = $this->db->query("
			SELECT COUNT(*) as count
			FROM `" . DB_PREFIX . "amazonus_room_link`
			WHERE `room_id` = '" . (int)$room_id . "'")->row;
		$links = $links['count'];

		if ($rows_total === 0 && $links > 0) {
			return 'linked';
		} else if ($rows_total == 0) {
			return false;
		}

		if ($rows_uploaded > 0) {
			return 'processing';
		}

		if ($rows_uploaded == 0 && $rows_ok > 0 && $rows_error == 0) {
			return 'ok';
		}

		if ($rows_saved > 0) {
			return 'saved';
		}

		if ($rows_uploaded == 0 && $rows_error > 0 && $rows_ok == 0) {
			$quick = $this->db->query("SELECT * FROM `" . DB_PREFIX . "amazonus_room` WHERE `room_id` = " . (int)$room_id . " AND `version` = 3")->row;

			if ($quick) {
				return 'error_quick';
			} else {
				return 'error_advanced';
			}
		} else {
			return 'error_few';
		}

		return false;
	}

	public function getRoomErrors($room_id, $version = 2) {
		if ($version == 3) {
			$message_row = $this->db->query("
			SELECT `messages` FROM `" . DB_PREFIX . "amazonus_room`
			WHERE `room_id` = '" . (int)$room_id . "' AND `version` = 3")->row;

			return json_decode($message_row['messages']);
		}

		$result = array();

		$insertion_rows = $this->db->query("SELECT `sku`, `insertion_id` FROM `" . DB_PREFIX . "amazonus_room` WHERE `room_id` = '" . (int)$room_id . "' AND `version` = 2")->rows;

		if (!empty($insertion_rows)) {
			foreach($insertion_rows as $insertion_row) {
				$error_rows = $this->db->query("SELECT * FROM `" . DB_PREFIX . "amazonus_room_error` WHERE `sku` = '" . $this->db->escape($insertion_row['sku']) . "' AND `insertion_id` = '" . $this->db->escape($insertion_row['insertion_id']) . "'")->rows;

				foreach($error_rows as $error_row) {
					$result[] = $error_row;
				}
			}
		}
		return $result;
	}

	public function getRoomsWithErrors() {
		return $this->db->query("
			SELECT `room_id`, `sku` FROM `" . DB_PREFIX . "amazonus_room`
			WHERE `status` = 'error' AND `version` = 2")->rows;
	}

	public function deleteRoom($room_id) {
		$this->db->query(
			"DELETE FROM `" . DB_PREFIX . "amazonus_room`
			WHERE `room_id` = '" . (int)$room_id . "'");
	}

	public function linkRoom($amazonus_sku, $room_id, $var = '') {
		$count = $this->db->query("SELECT COUNT(*) as 'count' FROM `" . DB_PREFIX . "amazonus_room_link` WHERE `room_id` = '" . (int)$room_id . "' AND `amazonus_sku` = '" . $this->db->escape($amazonus_sku) . "' AND `var` = '" . $this->db->escape($var) . "' LIMIT 1")->row;
		if ($count['count'] == 0) {
			$this->db->query(
				"INSERT INTO `" . DB_PREFIX . "amazonus_room_link`
				SET `room_id` = '" . (int)$room_id . "', `amazonus_sku` = '" . $this->db->escape($amazonus_sku) . "', `var` = '" . $this->db->escape($var) . "'");
		}
	}

	public function removeRoomLink($amazonus_sku) {
		$this->db->query(
			"DELETE FROM `" . DB_PREFIX . "amazonus_room_link`
			WHERE `amazonus_sku` = '" . $this->db->escape($amazonus_sku) . "'");
	}

	public function removeAdvancedErrors($room_id) {
		$room_rows = $this->db->query("
			SELECT `insertion_id` FROM `" . DB_PREFIX . "amazonus_room`
			WHERE `room_id` = '" . (int)$room_id . "' AND `version` = 2")->rows;

		foreach ($room_rows as $room) {
			$this->db->query(
				"DELETE FROM `" . DB_PREFIX . "amazonus_room_error`
				WHERE `insertion_id` = '" . $this->db->escape($room['insertion_id']) . "'");
		}

		$this->db->query(
			"UPDATE `" . DB_PREFIX . "amazonus_room`
			SET `status` = 'saved', `insertion_id` = ''
			WHERE `room_id` = '" . (int)$room_id . "' AND `status` = 'error' AND `version` = 2");
	}

	public function getRoomLinks($room_id = 'all') {
		$query = "SELECT `apl`.`amazonus_sku`, `apl`.`room_id`, `pd`.`name` as `room_name`, `p`.`model`, `p`.`sku`, `apl`.`var`, '' as `combi`
			FROM `" . DB_PREFIX . "amazonus_room_link` as `apl`
			LEFT JOIN `" . DB_PREFIX . "room_description` as `pd`
			ON `apl`.`room_id` = `pd`.`room_id`
			LEFT JOIN `" . DB_PREFIX . "room` as `p`
			ON `apl`.`room_id` = `p`.`room_id`";
		if ($room_id != 'all') {
			$query .= " WHERE `apl`.`room_id` = '" . (int)$room_id . "' AND `pd`.`language_id` = '" . (int)$this->config->get('config_language_id') . "'";
		} else {
			$query .= "WHERE `pd`.`language_id` = '" . (int)$this->config->get('config_language_id') . "'";
		}

		$rows = $this->db->query($query)->rows;

		$this->load->library('amazonus');
		if ($this->openbay->addonLoad('openstock')) {
			$this->load->model('openstock/openstock');
			$this->load->model('tool/image');
			$rows_with_var = array();
			foreach($rows as $row) {
				$stock_opts = $this->model_openstock_openstock->getRoomOptionStocks($row['room_id']);
				foreach($stock_opts as $opt) {
					if ($opt['var'] == $row['var']) {
						$row['combi'] = $opt['combi'];
						$row['sku'] = $opt['sku'];
						break;
					}
				}
				$rows_with_var[] = $row;
			}
			return $rows_with_var;
		} else {
			return $rows;
		}
	}

	public function getUnlinkedRooms() {
		$this->load->library('amazonus');
		if ($this->openbay->addonLoad('openstock')) {

			$rows = $this->db->query("
				SELECT `p`.`room_id`, `p`.`model`, `p`.`sku`, `pd`.`name` as `room_name`, '' as `var`, '' as `combi`, `p`.`has_option`
				FROM `" . DB_PREFIX . "room` as `p`
				LEFT JOIN `" . DB_PREFIX . "room_description` as `pd`
				ON `p`.`room_id` = `pd`.`room_id`
				AND `pd`.`language_id` = '" . (int)$this->config->get('config_language_id') . "'")->rows;

			$result = array();
			$this->load->model('openstock/openstock');
			$this->load->model('tool/image');
			foreach($rows as $row) {
				if ($row['has_option'] == 1) {
					$stock_opts = $this->model_openstock_openstock->getRoomOptionStocks($row['room_id']);
					foreach($stock_opts as $opt) {
						if ($this->roomLinkExists($row['room_id'], $opt['var'])) {
							continue;
						}
						$row['var'] = $opt['var'];
						$row['combi'] = $opt['combi'];
						$row['sku'] = $opt['sku'];
						$result[] = $row;
					}
				} else {
					if (!$this->roomLinkExists($row['room_id'], $row['var'])) {
						$result[] = $row;
					}
				}
			}
		} else {
			$result = $this->db->query("
				SELECT `p`.`room_id`, `p`.`model`, `p`.`sku`, `pd`.`name` as `room_name`, '' as `var`, '' as `combi`
				FROM `" . DB_PREFIX . "room` as `p`
				LEFT JOIN `" . DB_PREFIX . "room_description` as `pd`
				ON `p`.`room_id` = `pd`.`room_id`
				LEFT JOIN `" . DB_PREFIX . "amazonus_room_link` as `apl`
				ON `apl`.`room_id` = `p`.`room_id`
				WHERE `apl`.`amazonus_sku` IS NULL
				AND `pd`.`language_id` = '" . (int)$this->config->get('config_language_id') . "'")->rows;
		}

		return $result;
	}

	private function roomLinkExists($room_id, $var) {
		$link = $this->db->query("SELECT * FROM `" . DB_PREFIX . "amazonus_room_link` WHERE `room_id` = " . (int)$room_id . " AND var = '" . $this->db->escape($var) . "'")->row;

		if (empty($link)) {
			return false;
		} else {
			return true;
		}
	}

	public function getOrderStatusString($order_id) {
		$row = $this->db->query("
			SELECT `s`.`key`
			FROM `" . DB_PREFIX . "order` `o`
			JOIN `" . DB_PREFIX . "setting` `s` ON `o`.`order_id` = " . (int)$order_id . " AND `s`.`value` = `o`.`order_status_id`
			WHERE `s`.`key` = 'openbay_amazonus_order_status_shipped' OR `s`.`key` = 'openbay_amazonus_order_status_canceled'
			LIMIT 1")->row;

		if (!isset($row['key']) || empty($row['key'])) {
			return null;
		}

		$key = $row['key'];

		switch ($key) {
			case 'openbay_amazonus_order_status_shipped':
				$order_status = 'shipped';
				break;
			case 'openbay_amazonus_order_status_canceled':
				$order_status = 'canceled';
				break;

			default:
				$order_status = null;
				break;
		}

		return $order_status;
	}

	public function updateAmazonusOrderTracking($order_id, $courier_id, $courier_from_list, $tracking_no) {
		$this->db->query("
			UPDATE `" . DB_PREFIX . "amazonus_order`
			SET `courier_id` = '" . $courier_id . "',
				`courier_other` = " . (int)!$courier_from_list . ",
				`tracking_no` = '" . $tracking_no . "'
			WHERE `order_id` = " . (int)$order_id . "");
	}

	public function getAmazonusOrderId($order_id) {
		$row = $this->db->query("
			SELECT `amazonus_order_id`
			FROM `" . DB_PREFIX . "amazonus_order`
			WHERE `order_id` = " . (int)$order_id . "
			LIMIT 1")->row;

		if (isset($row['amazonus_order_id']) && !empty($row['amazonus_order_id'])) {
			return $row['amazonus_order_id'];
		}

		return null;
	}

	public function getAmazonusOrderedRooms($order_id) {
		return $this->db->query("
			SELECT `aop`.`amazonus_order_item_id`, `op`.`quantity`
			FROM `" . DB_PREFIX . "amazonus_order_room` `aop`
			JOIN `" . DB_PREFIX . "order_room` `op` ON `op`.`order_room_id` = `aop`.`order_room_id`
				AND `op`.`order_id` = " . (int)$order_id)->rows;
	}

	public function getRoomQuantity($room_id, $var = '') {
		$this->load->library('amazonus');

		$result = null;

		if ($var !== '' && $this->openbay->addonLoad('openstock')) {
			$this->load->model('tool/image');
			$this->load->model('openstock/openstock');
			$option_stocks = $this->model_openstock_openstock->getRoomOptionStocks($room_id);

			$option = null;
			foreach ($option_stocks as $option_iterator) {
				if ($option_iterator['var'] === $var) {
					$option = $option_iterator;
					break;
				}
			}

			if ($option != null) {
				$result = $option['stock'];
			}
		} else {
			$this->load->model('catalog/room');
			$room_info = $this->model_catalog_room->getRoom($room_id);

			if (isset($room_info['quantity'])) {
				$result = $room_info['quantity'];
			}
		}
		return $result;
	}

	public function getRoomSearchTotal($data = array()) {
		$sql = "
			SELECT COUNT(*) AS room_total
			FROM " . DB_PREFIX . "room p
			LEFT JOIN " . DB_PREFIX . "amazonus_room_search aps ON p.room_id = aps.room_id
			LEFT JOIN " . DB_PREFIX . "amazonus_room_link apl ON p.room_id = apl.room_id
			LEFT JOIN " . DB_PREFIX . "amazonus_room ap ON p.room_id = ap.room_id
			WHERE apl.room_id IS NULL AND ap.room_id IS NULL ";

		if (!empty($data['status'])) {
			$sql .= " AND aps.status = '" . $this->db->escape($data['status']) . "'";
		}

		return $this->db->query($sql)->row['room_total'];
	}

	public function getRoomSearch($data = array()) {
		$sql = "
			SELECT p.room_id, aps.status, aps.data, aps.matches
			FROM " . DB_PREFIX . "room p
			LEFT JOIN " . DB_PREFIX . "amazonus_room_search aps ON p.room_id = aps.room_id
			LEFT JOIN " . DB_PREFIX . "amazonus_room_link apl ON p.room_id = apl.room_id
			LEFT JOIN " . DB_PREFIX . "amazonus_room ap ON p.room_id = ap.room_id
			WHERE apl.room_id IS NULL AND ap.room_id IS NULL ";

		if (!empty($data['status'])) {
			$sql .= " AND aps.status = '" . $this->db->escape($data['status']) . "'";
		}

		$sql .= " LIMIT " . (int)$data['start'] . ", " . (int)$data['limit'];

		$results = array();

		$rows = $this->db->query($sql)->rows;

		foreach ($rows as $row) {
			$results[] = array(
				'room_id' => $row['room_id'],
				'status' => $row['status'],
				'matches' => $row['matches'],
				'data' => json_decode($row['data'], 1),
			);
		}

		return $results;
	}

	public function updateAmazonSkusQuantities($skus) {
		$sku_array = array();

		foreach ($skus as $sku) {
			$sku_array[] = "'" . $this->db->escape($sku) . "'";
		}

		if ($this->openbay->addonLoad('openstock')) {
			$rows = $this->db->query("
				SELECT apl.amazon_sku, if (por.room_id IS NULL, p.quantity, por.stock) AS 'quantity'
				FROM " . DB_PREFIX . "amazonus_room_link apl
				JOIN " . DB_PREFIX . "room p ON apl.room_id = p.room_id
				LEFT JOIN " . DB_PREFIX . "room_option_relation por ON apl.room_id = por.room_id AND apl.var = por.var
				WHERE apl.amazon_sku IN (" . implode(',', $sku_array) . ")
			")->rows;
		} else {
			$rows = $this->db->query("
				SELECT apl.amazon_sku, p.quantity
				FROM " . DB_PREFIX . "amazonus_room_link apl
				JOIN " . DB_PREFIX . "room p ON apl.room_id = p.room_id
				WHERE apl.amazon_sku IN (" . implode(',', $sku_array) . ")
			")->rows;
		}

		$return = array();

		foreach ($rows as $row) {
			$return[$row['amazon_sku']] = $row['quantity'];
		}

		$this->amazonus->updateQuantities($return);
	}

	public function getTotalUnlinkedItemsFromReport() {
		if ($this->openbay->addonLoad('openstock')) {
			$result = $this->db->query("
				SELECT alr.sku AS 'amazon_sku', alr.quantity AS 'amazon_quantity', alr.asin, alr.price AS 'amazon_price', oc_sku.room_id, pd.name, oc_sku.sku, oc_sku.var, oc_sku.quantity,
				  (
					SELECT GROUP_CONCAT(ovd.name ORDER BY o.sort_order SEPARATOR ' > ')
					FROM " . DB_PREFIX . "room_option_value pov
					JOIN " . DB_PREFIX . "option_value_description ovd ON ovd.option_value_id = pov.option_value_id AND ovd.language_id = " . (int)$this->config->get('config_language_id') . "
					JOIN `" . DB_PREFIX . "option` o ON o.option_id = pov.option_id
					WHERE oc_sku.var LIKE CONCAT('%:', pov.room_option_value_id ,':%') OR oc_sku.var LIKE CONCAT(pov.room_option_value_id ,':%')
					  OR oc_sku.var LIKE CONCAT('%:', pov.room_option_value_id) OR oc_sku.var LIKE pov.room_option_value_id
				  ) AS 'combination'
				FROM " . DB_PREFIX . "amazonus_listing_report alr
				LEFT JOIN (
				  SELECT p.room_id, if (por.room_id IS NULL, p.sku, por.sku) AS 'sku', if (por.room_id IS NULL, NULL, por.var) AS 'var', if (por.room_id IS NULL, p.quantity, por.stock) AS 'quantity'
				  FROM " . DB_PREFIX . "room p
				  LEFT JOIN " . DB_PREFIX . "room_option_relation por USING(room_id)
				) AS oc_sku ON alr.sku = oc_sku.sku
				LEFT JOIN " . DB_PREFIX . "amazonus_room_link apl ON (oc_sku.var IS NULL AND oc_sku.room_id = apl.room_id) OR (oc_sku.var IS NOT NULL AND oc_sku.room_id = apl.room_id AND oc_sku.var = apl.var)
				LEFT JOIN " . DB_PREFIX . "room_description pd ON oc_sku.room_id = pd.room_id AND pd.language_id = " . (int)$this->config->get('config_language_id') . "
				WHERE apl.room_id IS NULL
			");
		} else {
			$result = $this->db->query("
				SELECT alr.sku AS 'amazon_sku', alr.quantity AS 'amazon_quantity', alr.asin, alr.price AS 'amazon_price', oc_sku.room_id, pd.name, oc_sku.sku, oc_sku.var, oc_sku.quantity, '' AS combination
				FROM " . DB_PREFIX . "amazonus_listing_report alr
				LEFT JOIN (
					SELECT p.room_id, p.sku, NULL AS 'var', p.quantity
					FROM " . DB_PREFIX . "room p
				) AS oc_sku ON alr.sku = oc_sku.sku
				LEFT JOIN " . DB_PREFIX . "amazonus_room_link apl ON (oc_sku.var IS NULL AND oc_sku.room_id = apl.room_id) OR (oc_sku.var IS NOT NULL AND oc_sku.room_id = apl.room_id AND oc_sku.var = apl.var)
				LEFT JOIN " . DB_PREFIX . "room_description pd ON oc_sku.room_id = pd.room_id AND pd.language_id = " . (int)$this->config->get('config_language_id') . "
				WHERE apl.room_id IS NULL
				ORDER BY alr.sku
			");
		}

		return (int)$result->num_rows;
	}

	public function getUnlinkedItemsFromReport($limit = 100, $page = 1) {
		$start = $limit * ($page - 1);

		$rooms = array();

		if ($this->openbay->addonLoad('openstock')) {
			$rows = $this->db->query("
				SELECT alr.sku AS 'amazon_sku', alr.quantity AS 'amazon_quantity', alr.asin, alr.price AS 'amazon_price', oc_sku.room_id, pd.name, oc_sku.sku, oc_sku.var, oc_sku.quantity,
				  (
					SELECT GROUP_CONCAT(ovd.name ORDER BY o.sort_order SEPARATOR ' > ')
					FROM " . DB_PREFIX . "room_option_value pov
					JOIN " . DB_PREFIX . "option_value_description ovd ON ovd.option_value_id = pov.option_value_id AND ovd.language_id = " . (int)$this->config->get('config_language_id') . "
					JOIN `" . DB_PREFIX . "option` o ON o.option_id = pov.option_id
					WHERE oc_sku.var LIKE CONCAT('%:', pov.room_option_value_id ,':%') OR oc_sku.var LIKE CONCAT(pov.room_option_value_id ,':%')
					  OR oc_sku.var LIKE CONCAT('%:', pov.room_option_value_id) OR oc_sku.var LIKE pov.room_option_value_id
				  ) AS 'combination'
				FROM " . DB_PREFIX . "amazonus_listing_report alr
				LEFT JOIN (
				  SELECT p.room_id, if (por.room_id IS NULL, p.sku, por.sku) AS 'sku', if (por.room_id IS NULL, NULL, por.var) AS 'var', if (por.room_id IS NULL, p.quantity, por.stock) AS 'quantity'
				  FROM " . DB_PREFIX . "room p
				  LEFT JOIN " . DB_PREFIX . "room_option_relation por USING(room_id)
				) AS oc_sku ON alr.sku = oc_sku.sku
				LEFT JOIN " . DB_PREFIX . "amazonus_room_link apl ON (oc_sku.var IS NULL AND oc_sku.room_id = apl.room_id) OR (oc_sku.var IS NOT NULL AND oc_sku.room_id = apl.room_id AND oc_sku.var = apl.var)
				LEFT JOIN " . DB_PREFIX . "room_description pd ON oc_sku.room_id = pd.room_id AND pd.language_id = " . (int)$this->config->get('config_language_id') . "
				WHERE apl.room_id IS NULL
				ORDER BY alr.sku
				LIMIT " . (int)$start . "," . (int)$limit)->rows;
		} else {
			$rows = $this->db->query("
				SELECT alr.sku AS 'amazon_sku', alr.quantity AS 'amazon_quantity', alr.asin, alr.price AS 'amazon_price', oc_sku.room_id, pd.name, oc_sku.sku, oc_sku.var, oc_sku.quantity, '' AS combination
				FROM " . DB_PREFIX . "amazonus_listing_report alr
				LEFT JOIN (
					SELECT p.room_id, p.sku, NULL AS 'var', p.quantity
					FROM " . DB_PREFIX . "room p
				) AS oc_sku ON alr.sku = oc_sku.sku
				LEFT JOIN " . DB_PREFIX . "amazonus_room_link apl ON (oc_sku.var IS NULL AND oc_sku.room_id = apl.room_id) OR (oc_sku.var IS NOT NULL AND oc_sku.room_id = apl.room_id AND oc_sku.var = apl.var)
				LEFT JOIN " . DB_PREFIX . "room_description pd ON oc_sku.room_id = pd.room_id AND pd.language_id = " . (int)$this->config->get('config_language_id') . "
				WHERE apl.room_id IS NULL
				ORDER BY alr.sku
				LIMIT " . (int)$start . "," . (int)$limit)->rows;
		}

		foreach ($rows as $row) {
			$rooms[] = array(
				'room_id' => $row['room_id'],
				'name' => $row['name'],
				'sku' => $row['sku'],
				'var' => $row['var'],
				'quantity' => $row['quantity'],
				'amazon_sku' => $row['amazon_sku'],
				'amazon_quantity' => $row['amazon_quantity'],
				'amazon_price' => number_format($row['amazon_price'], 2, ' . ', ''),
				'asin' => $row['asin'],
				'combination' => $row['combination'],
			);
		}

		return $rooms;
	}

	public function deleteListingReports() {
		$this->db->query("
			DELETE FROM " . DB_PREFIX . "amazonus_listing_report
		");
	}
}