<?php
class ModelOpenbayAmazonusListing extends Model {
	private $tabs = array();

	public function search($search_string) {

		$search_params = array(
			'search_string' => $search_string,
		);

		$results = json_decode($this->openbay->amazonus->call('roomv3/search', $search_params), 1);

		$rooms = array();

		foreach ($results['Rooms'] as $result) {
			if ($result['price']['amount'] && $result['price']['currency']) {
				$price = $result['price']['amount'] . ' ' . $result['price']['currency'];
			} else {
				$price = '-';
			}

			$link = 'http://www.amazon.com/gp/room/' . $result['asin'] . '/';

			$rooms[] = array(
				'name' => $result['name'],
				'asin' => $result['asin'],
				'image' => $result['image'],
				'price' => $price,
				'link' => $link,
			);
		}

		return $rooms;
	}

	public function getRoomByAsin($asin) {
		$data = array(
			'asin' => $asin,
		);

		$results = json_decode($this->openbay->amazonus->call('roomv3/getRoom', $data), 1);

		return $results;
	}

	public function getBestPrice($asin, $condition) {
		$search_params = array(
			'asin' => $asin,
			'condition' => $condition,
		);

		$best_price = '';

		$result = json_decode($this->openbay->amazonus->call('roomv3/getPrice', $search_params), 1);

		if (isset($result['Price']['Amount']) && $result['Price']['Currency'] && $this->currency->has($result['Price']['Currency'])) {
			$best_price['amount'] = number_format($this->currency->convert($result['Price']['Amount'], $result['Price']['Currency'], $this->config->get('config_currency')), 2, '.', '');
			$best_price['shipping'] = number_format($this->currency->convert($result['Price']['Shipping'], $result['Price']['Currency'], $this->config->get('config_currency')), 2, '.', '');
			$best_price['currency'] = $result['Price']['Currency'];
		}

		return $best_price;
	}

	public function simpleListing($data) {
		$request = array(
			'asin' => $data['asin'],
			'sku' => $data['sku'],
			'quantity' => $data['quantity'],
			'price' => $data['price'],
			'sale' => array(
				'price' => $data['sale_price'],
				'from' => $data['sale_from'],
				'to' => $data['sale_to'],
			),
			'condition' => $data['condition'],
			'condition_note' => $data['condition_note'],
			'start_selling' => $data['start_selling'],
			'restock_date' => $data['restock_date'],
			'response_url' => HTTPS_CATALOG . 'index.php?route=openbay/amazonus/listing',
			'room_id' => $data['room_id'],
		);

		$response = $this->openbay->amazonus->call('roomv3/simpleListing', $request);
		$response = json_decode($response);
		if (empty($response)) {
			return array(
				'status' => 0,
				'message' => 'Problem connecting OpenBay: API'
			);
		}
		$response = (array)$response;

		if ($response['status'] === 1) {
			$this->db->query("
			REPLACE INTO `" . DB_PREFIX . "amazonus_room`
			SET `room_id` = " . (int)$data['room_id'] . ",
				`status` = 'uploaded',
				`version` = 3,
				`var` = ''
		");
		}

		return $response;
	}

	public function getBrowseNodes($request) {
		return $this->openbay->amazonus->call('roomv3/getBrowseNodes', $request);
	}

	public function deleteSearchResults($room_ids) {
		$imploded_ids = array();

		foreach ($room_ids as $room_id) {
			$imploded_ids[] = (int)$room_id;
		}

		$imploded_ids = implode(',', $imploded_ids);

		$this->db->query("
			DELETE FROM " . DB_PREFIX .  "amazonus_room_search
			WHERE room_id IN ($imploded_ids)
		");
	}

	public function doBulkListing($data) {
		$this->load->model('catalog/room');
		$request = array();

		foreach($data['rooms'] as $room_id => $asin) {
			$room = $this->model_catalog_room->getRoom($room_id);

			if ($room) {
				$price = $room['price'];

				if ($this->config->get('openbay_amazonus_listing_tax_added') && $this->config->get('openbay_amazonus_listing_tax_added') > 0) {
					$price += $price * ($this->config->get('openbay_amazonus_listing_tax_added') / 100);
				}

				$request[] = array(
					'asin' => $asin,
					'sku' => $room['sku'],
					'quantity' => $room['quantity'],
					'price' => number_format($price, 2, ' . ', ''),
					'sale' => array(),
					'condition' => (isset($data['condition']) ? $data['condition'] : ''),
					'condition_note' => (isset($data['condition_note']) ? $data['condition_note'] : ''),
					'start_selling' => (isset($data['start_selling']) ? $data['start_selling'] : ''),
					'restock_date' => '',
					'response_url' => HTTPS_CATALOG . 'index.php?route=openbay/amazonus/listing',
					'room_id' => $room['room_id'],
				);
			}
		}

		if ($request) {
			$response = $this->openbay->amazonus->call('roomv3/bulkListing', $request);

			$response = json_decode($response, 1);

			if ($response['status'] == 1) {
				foreach ($request as $room) {
					$this->db->query("
						REPLACE INTO `" . DB_PREFIX . "amazonus_room`
						SET `room_id` = " . (int)$room['room_id'] . ",
							`status` = 'uploaded',
							`var` = '',
							`version` = 3
					");
				}

				return true;
			}
		}

		return false;
	}

	public function doBulkSearch($search_data) {
		foreach ($search_data as $rooms) {
			foreach ($rooms as $room) {
				$this->db->query("
					REPLACE INTO " . DB_PREFIX . "amazonus_room_search (room_id, `status`)
					VALUES (" . (int)$room['room_id'] . ", 'searching')");
			}
		}

		$request_data = array(
			'search' => $search_data,
			'response_url' => HTTPS_CATALOG . 'index.php?route=openbay/amazonus/search'
		);

		$response = $this->openbay->amazonus->call('roomv3/bulkSearch', $request_data);
	}
}