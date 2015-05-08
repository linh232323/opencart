<?php
class ModelCatalogRoom extends Model {
	public function updateViewed($room_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "room SET viewed = (viewed + 1) WHERE room_id = '" . (int)$room_id . "'");
	}

	public function getRoom($room_id) {
		$query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, (SELECT price FROM " . DB_PREFIX . "room_discount pd2 WHERE pd2.room_id = p.room_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "room_special ps WHERE ps.room_id = p.room_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, (SELECT points FROM " . DB_PREFIX . "room_reward pr WHERE pr.room_id = p.room_id AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "') AS reward, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "') AS stock_status, (SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS weight_class, (SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS length_class, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.room_id = p.room_id AND r1.status = '1' GROUP BY r1.room_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.room_id = p.room_id AND r2.status = '1' GROUP BY r2.room_id) AS reviews, p.sort_order FROM " . DB_PREFIX . "room p LEFT JOIN " . DB_PREFIX . "room_description pd ON (p.room_id = pd.room_id) LEFT JOIN " . DB_PREFIX . "room_to_store p2s ON (p.room_id = p2s.room_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.room_id = '" . (int)$room_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return array(
				'room_id'          => $query->row['room_id'],
				'name'             => $query->row['name'],
				'description'      => $query->row['description'],
				'room_deal'        => $query->row['room_deal'],
				'meta_title'       => $query->row['meta_title'],
				'meta_description' => $query->row['meta_description'],
				'meta_keyword'     => $query->row['meta_keyword'],
				'tag'              => $query->row['tag'],
				'model'            => $query->row['model'],
				'sku'              => $query->row['sku'],
				'upc'              => $query->row['upc'],
				'ean'              => $query->row['ean'],
				'jan'              => $query->row['jan'],
				'isbn'             => $query->row['isbn'],
				'mpn'              => $query->row['mpn'],
				'location'         => $query->row['location'],
				'quantity'         => $query->row['quantity'],
				'maxadults'        => $query->row['maxadults'],
				'stock_status'     => $query->row['stock_status'],
				'image'            => $query->row['image'],
				'manufacturer_id'  => $query->row['manufacturer_id'],
				'manufacturer'     => $query->row['manufacturer'],
				'price'            => ($query->row['discount'] ? $query->row['discount'] : $query->row['price']),
				'special'          => $query->row['special'],
				'reward'           => $query->row['reward'],
				'points'           => $query->row['points'],
				'tax_class_id'     => $query->row['tax_class_id'],
				'date_available'   => $query->row['date_available'],
				'weight'           => $query->row['weight'],
				'weight_class_id'  => $query->row['weight_class_id'],
				'length'           => $query->row['length'],
				'width'            => $query->row['width'],
				'height'           => $query->row['height'],
				'length_class_id'  => $query->row['length_class_id'],
				'subtract'         => $query->row['subtract'],
				'rating'           => round($query->row['rating']),
				'reviews'          => $query->row['reviews'] ? $query->row['reviews'] : 0,
				'minimum'          => $query->row['minimum'],
				'sort_order'       => $query->row['sort_order'],
				'status'           => $query->row['status'],
				'date_added'       => $query->row['date_added'],
				'date_modified'    => $query->row['date_modified'],
				'viewed'           => $query->row['viewed']
			);
		} else {
			return false;
		}
	}
        public function getStock($room_id,$check_in,$check_out) {
            $stock = 0 ;
            $query = $this->db->query("SELECT op.quantity ,op.order_id ,o.order_status_id FROM " . DB_PREFIX . "order_room op LEFT JOIN  " . DB_PREFIX . "order o ON op.order_id = o.order_id WHERE room_id = " . $room_id . " AND (((check_in <=" . $check_in . " ) AND ( check_out >= " . $check_in ." )) OR (( check_in <= " . $check_out . " ) AND ( check_out >= " . $check_out . " ))) ");
            foreach ($query->rows as $value) {
                if($value['order_status_id'] == 5){
                    $stock += $value['quantity'];
                }
            }
            return $stock;
        }
        
	public function getRooms($data = array()) {
		$sql = "SELECT p.room_id, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.room_id = p.room_id AND r1.status = '1' GROUP BY r1.room_id) AS rating, (SELECT price FROM " . DB_PREFIX . "room_discount pd2 WHERE pd2.room_id = p.room_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "room_special ps WHERE ps.room_id = p.room_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";

		if (!empty($data['filter_hotel_id'])) {
			if (!empty($data['filter_sub_hotel'])) {
				$sql .= " FROM " . DB_PREFIX . "hotel_path cp LEFT JOIN " . DB_PREFIX . "room_to_hotel p2c ON (cp.hotel_id = p2c.hotel_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "room_to_hotel p2c";
			}

			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "room_filter pf ON (p2c.room_id = pf.room_id) LEFT JOIN " . DB_PREFIX . "room p ON (pf.room_id = p.room_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "room p ON (p2c.room_id = p.room_id)";
			}
		} else {
			$sql .= " FROM " . DB_PREFIX . "room p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "room_description pd ON (p.room_id = pd.room_id) LEFT JOIN " . DB_PREFIX . "room_to_store p2s ON (p.room_id = p2s.room_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if (!empty($data['filter_hotel_id'])) {
			if (!empty($data['filter_sub_hotel'])) {
				$sql .= " AND cp.path_id = '" . (int)$data['filter_hotel_id'] . "'";
			} else {
				$sql .= " AND p2c.hotel_id = '" . (int)$data['filter_hotel_id'] . "'";
			}

			if (!empty($data['filter_filter'])) {
				$implode = array();

				$filters = explode(',', $data['filter_filter']);

				foreach ($filters as $filter_id) {
					$implode[] = (int)$filter_id;
				}

				$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
			}
		}

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}

			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}

			if (!empty($data['filter_tag'])) {
				$sql .= "pd.tag LIKE '%" . $this->db->escape($data['filter_tag']) . "%'";
			}

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}

			$sql .= ")";
		}

		if (!empty($data['filter_manufacturer_id'])) {
			$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
		}

		$sql .= " GROUP BY p.room_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'p.quantity',
			'p.maxadults',
			'p.price',
			'rating',
			'p.sort_order',
			'p.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			} elseif ($data['sort'] == 'p.price') {
				$sql .= " ORDER BY (CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount ELSE p.price END)";
			} else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY p.sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(pd.name) DESC";
		} else {
			$sql .= " ASC, LCASE(pd.name) ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$room_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$room_data[$result['room_id']] = $this->getRoom($result['room_id']);
		}

		return $room_data;
	}
        
        public function getRoomPrices($room_id) {
		$room_price_data = array();

		$room_price_query = $this->db->query("SELECT price_id FROM " . DB_PREFIX . "room_price WHERE room_id = '" . (int)$room_id . "' GROUP BY price_id");

		foreach ($room_price_query->rows as $room_price) {
			$room_date_data = array();

			$room_date_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "room_price WHERE room_id = '" . (int)$room_id . "' AND price_id = '" . (int)$room_price['price_id'] . "'");
                        
                        foreach ($room_date_query->rows as $room_date) {
                                $room_date_data['1'] = array('date' => $room_date['date_form']);
                                $room_date_data['2'] = array('date' => $room_date['date_to']);
                        }
			
			

			$room_price_data[] = array(
				'price_id'                  => $room_price['price_id'],
				'room_id'                => $room_date['room_id'],
				'room_price_net'         => $room_date['price_net'],
				'room_price_percent'     => $room_date['price_percent'],
				'room_price_gross'       => $room_date['price_gross'],
				'room_price_discount'    => $room_date['discount'],
				'room_extra_net'         => $room_date['extra_net'],
				'room_extra_percent'     => $room_date['extra_percent'],
				'room_extra_gross'       => $room_date['extra_gross'],
				'room_date'              => $room_date_data
			);
		}

		return $room_price_data;
	}
        
        public function updatePrice($room_id,$price) {
		$this->db->query("UPDATE " . DB_PREFIX . "room SET price = $price WHERE room_id = '" . (int)$room_id . "'");
	}

	public function getRoomSpecials($data = array()) {
		$sql = "SELECT DISTINCT ps.room_id, (SELECT AVG(rating) FROM " . DB_PREFIX . "review r1 WHERE r1.room_id = ps.room_id AND r1.status = '1' GROUP BY r1.room_id) AS rating FROM " . DB_PREFIX . "room_special ps LEFT JOIN " . DB_PREFIX . "room p ON (ps.room_id = p.room_id) LEFT JOIN " . DB_PREFIX . "room_description pd ON (p.room_id = pd.room_id) LEFT JOIN " . DB_PREFIX . "room_to_store p2s ON (p.room_id = p2s.room_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) GROUP BY ps.room_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'ps.price',
			'rating',
			'p.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			} else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY p.sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(pd.name) DESC";
		} else {
			$sql .= " ASC, LCASE(pd.name) ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$room_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$room_data[$result['room_id']] = $this->getRoom($result['room_id']);
		}

		return $room_data;
	}

	public function getLatestRooms($limit) {
		$room_data = $this->cache->get('room.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

		if (!$room_data) {
			$query = $this->db->query("SELECT p.room_id FROM " . DB_PREFIX . "room p LEFT JOIN " . DB_PREFIX . "room_to_store p2s ON (p.room_id = p2s.room_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.date_added DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$room_data[$result['room_id']] = $this->getRoom($result['room_id']);
			}

			$this->cache->set('room.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $room_data);
		}

		return $room_data;
	}

	public function getPopularRooms($limit) {
		$room_data = array();

		$query = $this->db->query("SELECT p.room_id FROM " . DB_PREFIX . "room p LEFT JOIN " . DB_PREFIX . "room_to_store p2s ON (p.room_id = p2s.room_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.viewed DESC, p.date_added DESC LIMIT " . (int)$limit);

		foreach ($query->rows as $result) {
			$room_data[$result['room_id']] = $this->getRoom($result['room_id']);
		}

		return $room_data;
	}

	public function getBestSellerRooms($limit) {
		$room_data = $this->cache->get('room.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

		if (!$room_data) {
			$room_data = array();

			$query = $this->db->query("SELECT op.room_id, SUM(op.quantity) AS total FROM " . DB_PREFIX . "order_room op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "room` p ON (op.room_id = p.room_id) LEFT JOIN " . DB_PREFIX . "room_to_store p2s ON (p.room_id = p2s.room_id) WHERE o.order_status_id > '0' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY op.room_id ORDER BY total DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$room_data[$result['room_id']] = $this->getRoom($result['room_id']);
			}

			$this->cache->set('room.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $room_data);
		}

		return $room_data;
	}

	public function getRoomAttributes($room_id) {
		$room_attribute_group_data = array();

		$room_attribute_group_query = $this->db->query("SELECT ag.attribute_group_id, agd.name FROM " . DB_PREFIX . "room_attribute pa LEFT JOIN " . DB_PREFIX . "attribute_room a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_room_group ag ON (a.attribute_group_id = ag.attribute_group_id) LEFT JOIN " . DB_PREFIX . "attribute_room_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id) WHERE pa.room_id = '" . (int)$room_id . "' AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY ag.attribute_group_id ORDER BY ag.sort_order, agd.name");

		foreach ($room_attribute_group_query->rows as $room_attribute_group) {
			$room_attribute_data = array();

			$room_attribute_query = $this->db->query("SELECT a.attribute_id, ad.name, pa.text FROM " . DB_PREFIX . "room_attribute pa LEFT JOIN " . DB_PREFIX . "attribute_room a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_room_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.room_id = '" . (int)$room_id . "' AND a.attribute_group_id = '" . (int)$room_attribute_group['attribute_group_id'] . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY a.sort_order, ad.name");

			foreach ($room_attribute_query->rows as $room_attribute) {
				$room_attribute_data[] = array(
					'attribute_id' => $room_attribute['attribute_id'],
					'name'         => $room_attribute['name'],
					'text'         => $room_attribute['text']
				);
			}

			$room_attribute_group_data[] = array(
				'attribute_group_id' => $room_attribute_group['attribute_group_id'],
				'name'               => $room_attribute_group['name'],
				'attribute'          => $room_attribute_data
			);
		}

		return $room_attribute_group_data;
	}

	public function getRoomOptions($room_id) {
		$room_option_data = array();

		$room_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "room_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.room_id = '" . (int)$room_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.sort_order");

		foreach ($room_option_query->rows as $room_option) {
			$room_option_value_data = array();

			$room_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "room_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.room_id = '" . (int)$room_id . "' AND pov.room_option_id = '" . (int)$room_option['room_option_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order");

			foreach ($room_option_value_query->rows as $room_option_value) {
				$room_option_value_data[] = array(
					'room_option_value_id' => $room_option_value['room_option_value_id'],
					'option_value_id'         => $room_option_value['option_value_id'],
					'name'                    => $room_option_value['name'],
					'image'                   => $room_option_value['image'],
					'quantity'                => $room_option_value['quantity'],
					'maxadults'               => $room_option_value['maxadults'],
					'subtract'                => $room_option_value['subtract'],
					'price'                   => $room_option_value['price'],
					'price_prefix'            => $room_option_value['price_prefix'],
					'weight'                  => $room_option_value['weight'],
					'weight_prefix'           => $room_option_value['weight_prefix']
				);
			}

			$room_option_data[] = array(
				'room_option_id'    => $room_option['room_option_id'],
				'room_option_value' => $room_option_value_data,
				'option_id'            => $room_option['option_id'],
				'name'                 => $room_option['name'],
				'type'                 => $room_option['type'],
				'value'                => $room_option['value'],
				'required'             => $room_option['required']
			);
		}

		return $room_option_data;
	}

	public function getRoomDiscounts($room_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "room_discount WHERE room_id = '" . (int)$room_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity > 1 AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity ASC, priority ASC, price ASC");

		return $query->rows;
	}

	public function getRoomImages($room_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "room_image WHERE room_id = '" . (int)$room_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getRoomRelated($room_id) {
		$room_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "room_related pr LEFT JOIN " . DB_PREFIX . "room p ON (pr.related_id = p.room_id) LEFT JOIN " . DB_PREFIX . "room_to_store p2s ON (p.room_id = p2s.room_id) WHERE pr.room_id = '" . (int)$room_id . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		foreach ($query->rows as $result) {
			$room_data[$result['related_id']] = $this->getRoom($result['related_id']);
		}

		return $room_data;
	}

	public function getRoomLayoutId($room_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "room_to_layout WHERE room_id = '" . (int)$room_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}

	public function getCategories($room_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "room_to_hotel WHERE room_id = '" . (int)$room_id . "'");

		return $query->rows;
	}

	public function getTotalRooms($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.room_id) AS total";

		if (!empty($data['filter_hotel_id'])) {
			if (!empty($data['filter_sub_hotel'])) {
				$sql .= " FROM " . DB_PREFIX . "hotel_path cp LEFT JOIN " . DB_PREFIX . "room_to_hotel p2c ON (cp.hotel_id = p2c.hotel_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "room_to_hotel p2c";
			}

			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "room_filter pf ON (p2c.room_id = pf.room_id) LEFT JOIN " . DB_PREFIX . "room p ON (pf.room_id = p.room_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "room p ON (p2c.room_id = p.room_id)";
			}
		} else {
			$sql .= " FROM " . DB_PREFIX . "room p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "room_description pd ON (p.room_id = pd.room_id) LEFT JOIN " . DB_PREFIX . "room_to_store p2s ON (p.room_id = p2s.room_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if (!empty($data['filter_hotel_id'])) {
			if (!empty($data['filter_sub_hotel'])) {
				$sql .= " AND cp.path_id = '" . (int)$data['filter_hotel_id'] . "'";
			} else {
				$sql .= " AND p2c.hotel_id = '" . (int)$data['filter_hotel_id'] . "'";
			}

			if (!empty($data['filter_filter'])) {
				$implode = array();

				$filters = explode(',', $data['filter_filter']);

				foreach ($filters as $filter_id) {
					$implode[] = (int)$filter_id;
				}

				$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
			}
		}

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}

			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}

			if (!empty($data['filter_tag'])) {
				$sql .= "pd.tag LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_tag'])) . "%'";
			}

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}

			$sql .= ")";
		}

		if (!empty($data['filter_manufacturer_id'])) {
			$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getProfiles($room_id) {
		return $this->db->query("SELECT `pd`.* FROM `" . DB_PREFIX . "room_recurring` `pp` JOIN `" . DB_PREFIX . "recurring_description` `pd` ON `pd`.`language_id` = " . (int)$this->config->get('config_language_id') . " AND `pd`.`recurring_id` = `pp`.`recurring_id` JOIN `" . DB_PREFIX . "recurring` `p` ON `p`.`recurring_id` = `pd`.`recurring_id` WHERE `room_id` = " . (int)$room_id . " AND `status` = 1 AND `customer_group_id` = " . (int)$this->config->get('config_customer_group_id') . " ORDER BY `sort_order` ASC")->rows;
	}

	public function getProfile($room_id, $recurring_id) {
		return $this->db->query("SELECT * FROM `" . DB_PREFIX . "recurring` `p` JOIN `" . DB_PREFIX . "room_recurring` `pp` ON `pp`.`recurring_id` = `p`.`recurring_id` AND `pp`.`room_id` = " . (int)$room_id . " WHERE `pp`.`recurring_id` = " . (int)$recurring_id . " AND `status` = 1 AND `pp`.`customer_group_id` = " . (int)$this->config->get('config_customer_group_id'))->row;
	}

	public function getTotalRoomSpecials() {
		$query = $this->db->query("SELECT COUNT(DISTINCT ps.room_id) AS total FROM " . DB_PREFIX . "room_special ps LEFT JOIN " . DB_PREFIX . "room p ON (ps.room_id = p.room_id) LEFT JOIN " . DB_PREFIX . "room_to_store p2s ON (p.room_id = p2s.room_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))");

		if (isset($query->row['total'])) {
			return $query->row['total'];
		} else {
			return 0;
		}
	}
}
