<?php
class ModelOpenbayAmazonusroom extends Model {
	public function setStatus($insertion_id, $status_string) {
		$this->db->query("UPDATE `" . DB_PREFIX . "amazonus_room` SET `status` = '" . $status_string . "' WHERE `insertion_id` = '" . $this->db->escape($insertion_id) . "'");
	}

	public function getroomRows($insertion_id) {
		return $this->db->query("SELECT * FROM `" . DB_PREFIX . "amazonus_room` WHERE `insertion_id` = '" . $this->db->escape($insertion_id) . "'")->rows;
	}

	public function getroom($insertion_id) {
		return $this->db->query("SELECT * FROM `" . DB_PREFIX . "amazonus_room` WHERE `insertion_id` = '" . $this->db->escape($insertion_id) . "'")->row;
	}

	public function linkItems(array $data) {
		foreach ($data as $amazonus_sku => $room_id) {
			$var_row = $this->db->query("SELECT `var` FROM `" . DB_PREFIX . "amazonus_room` WHERE `sku` = '" . $amazonus_sku . "' AND `room_id` = '" . (int)$room_id . "'")->row;
			$var = isset($var_row['var']) ? $var_row['var'] : '';
			$this->linkroom($amazonus_sku, $room_id, $var);
		}
	}

	public function insertError($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "amazonus_room_error` SET `sku` = '" . $this->db->escape($data['sku']) . "', `error_code` = '" . (int)$data['error_code'] . "', `message` = '" . $this->db->escape($data['message']) . "', `insertion_id` = '" . $this->db->escape($data['insertion_id']) . "'");

		$this->db->query("UPDATE `" . DB_PREFIX . "amazonus_room` SET `status` = 'error' WHERE `sku` = '" . $this->db->escape($data['sku']) . "' AND `insertion_id` = '" . $this->db->escape($data['insertion_id']) . "'");
	}

	public function deleteErrors($insertion_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "amazonus_room_error` WHERE `insertion_id` = '" . $this->db->escape($insertion_id) . "'");
	}

	public function setSubmitError($insertion_id, $message) {
		$sku_rows = $this->db->query("SELECT `sku` FROM `" . DB_PREFIX . "amazonus_room` WHERE `insertion_id` = '" . $this->db->escape($insertion_id) . "'")->rows;

		foreach ($sku_rows as $sku_row) {
			$data = array(
				'sku' => $sku_row['sku'],
				'error_code' => '0',
				'message' => $message,
				'insertion_id' => $insertion_id
			);
			$this->insertError($data);
		}
	}

	public function linkroom($amazonus_sku, $room_id, $var = '') {
		$count = $this->db->query("SELECT COUNT(*) as 'count' FROM `" . DB_PREFIX . "amazonus_room_link` WHERE `room_id` = '" . (int)$room_id . "' AND `amazonus_sku` = '" . $this->db->escape($amazonus_sku) . "' AND `var` = '" . $this->db->escape($var) . "' LIMIT 1")->row;
		if ($count['count'] == 0) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "amazonus_room_link` SET `room_id` = '" . (int)$room_id . "', `amazonus_sku` = '" . $this->db->escape($amazonus_sku) . "', `var` = '" . $this->db->escape($var) . "'");
		}
	}

	public function getroomQuantity($room_id, $var = '') {
		$this->load->library('amazonus');

		$result = null;

		if ($var !== '' && $this->openbay->addonLoad('openstock')) {
			$this->load->model('tool/image');
			$this->load->model('openstock/openstock');
			$option_stocks = $this->model_openstock_openstock->getroomOptionStocks($room_id);

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
			$room_info = $this->model_catalog_room->getroom($room_id);

			if (isset($room_info['quantity'])) {
				$result = $room_info['quantity'];
			}
		}
		return $result;
	}

	public function updateSearch($results) {
		foreach ($results as $result) {
			$results_found = count($result['results']);

			$data = json_encode($result['results']);

			$this->db->query("UPDATE " . DB_PREFIX . "amazonus_room_search SET matches = " . (int)$results_found . ", `data` = '" . $this->db->escape($data) . "', `status` = 'finished' WHERE room_id = " . (int)$result['room_id'] . " LIMIT 1");
		}
	}

	public function addListingReport($data) {
		$sql = "INSERT INTO " . DB_PREFIX . "amazonus_listing_report (sku, quantity, asin, price) VALUES ";

		$sql_values = array();

		foreach ($data as $room) {
			$sql_values[] = " ('" . $this->db->escape($room['sku']) . "', " . (int)$room['quantity'] . ", '" . $this->db->escape($room['asin']) . "', " . (double)$room['price'] . ") ";
		}

		$sql .= implode(',', $sql_values);

		$this->db->query($sql);
	}

	public function removeListingReportLock($marketplace) {
		$this->config->set('openbay_amazonus_processing_listing_reports', false);

		$this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = '0', serialized = 0 WHERE `key` = 'openbay_amazonus_processing_listing_reports'");
	}
}