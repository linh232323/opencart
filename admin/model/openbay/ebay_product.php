<?php
class ModelOpenbayEbayRoom extends Model {
	public function getTaxRate($class_id) {
		return $this->openbay->getTaxRate($class_id);
	}

	public function countImportImages() {
		$qry = $this->db->query("SELECT * FROM `" . DB_PREFIX . "ebay_image_import`");

		return $qry->num_rows;
	}

	public function getRoomOptions($room_id) {
		$room_option_data = array();

		$room_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "room_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.room_id = '" . (int)$room_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.sort_order");

		foreach ($room_option_query->rows as $room_option) {
			if ($room_option['type'] == 'select' || $room_option['type'] == 'radio' || $room_option['type'] == 'image') {
				$room_option_value_data = array();

				$room_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "room_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.room_option_id = '" . (int)$room_option['room_option_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order");

				foreach ($room_option_value_query->rows as $room_option_value) {
					$room_option_value_data[] = array(
						'room_option_value_id'   => $room_option_value['room_option_value_id'],
						'option_value_id'           => $room_option_value['option_value_id'],
						'name'                      => $room_option_value['name'],
						'image'                     => $room_option_value['image'],
						'image_thumb'               => (!empty($room_option_value['image'])) ? $this->model_tool_image->resize($room_option_value['image'], 100, 100) : '',
						'quantity'                  => $room_option_value['quantity'],
						'subtract'                  => $room_option_value['subtract'],
						'price'                     => $room_option_value['price'],
						'price_prefix'              => $room_option_value['price_prefix'],
						'points'                    => $room_option_value['points'],
						'points_prefix'             => $room_option_value['points_prefix'],
						'weight'                    => $room_option_value['weight'],
						'weight_prefix'             => $room_option_value['weight_prefix']
					);
				}

				$room_option_data[] = array(
					'room_option_id'     => $room_option['room_option_id'],
					'option_id'             => $room_option['option_id'],
					'name'                  => $room_option['name'],
					'type'                  => $room_option['type'],
					'room_option_value'  => $room_option_value_data,
					'required'              => $room_option['required']
				);
			}
		}

		return $room_option_data;
	}

	public function repairLinks() {
		//get distinct room id's where they are active
		$sql = $this->db->query("
			SELECT DISTINCT `room_id`
			FROM `" . DB_PREFIX . "ebay_listing`
			WHERE `status` = '1'");

		//loop over rooms and if count is more than 1, update all older entries to 0
		foreach($sql->rows as $row) {
			$sql2 = $this->db->query("SELECT * FROM `" . DB_PREFIX . "ebay_listing` WHERE `room_id` = '" . (int)$row['room_id'] . "' AND `status` = 1 ORDER BY `ebay_listing_id` DESC");

			if ($sql2->num_rows > 1) {
				$this->db->query("UPDATE `" . DB_PREFIX . "ebay_listing` SET `status` = 0  WHERE `room_id` = '" . (int)$row['room_id'] . "'");
				$this->db->query("UPDATE `" . DB_PREFIX . "ebay_listing` SET `status` = 1  WHERE `ebay_listing_id` = '" . (int)$sql2->row['ebay_listing_id'] . "'");
			}
		}
	}

	public function searchEbayCatalog($search, $category_id, $page = 1) {
		$response = $this->openbay->ebay->call('listing/searchCatalog/', array('page' => (int)$page, 'categoryId' => $category_id, 'search' => $search));

		return $response;
	}
}