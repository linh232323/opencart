<?php
class ModelCatalogHotel extends Model {
	public function updateViewed($hotel_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "hotel SET viewed = (viewed + 1) WHERE hotel_id = '" . (int)$hotel_id . "'");
	}

	public function getHotel($hotel_id) {
		$query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, (SELECT price FROM " . DB_PREFIX . "hotel_discount pd2 WHERE pd2.hotel_id = p.hotel_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "hotel_special ps WHERE ps.hotel_id = p.hotel_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, (SELECT points FROM " . DB_PREFIX . "hotel_reward pr WHERE pr.hotel_id = p.hotel_id AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "') AS reward, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "') AS stock_status, (SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS weight_class, (SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS length_class, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "hotelreview r1 WHERE r1.hotel_id = p.hotel_id AND r1.status = '1' GROUP BY r1.hotel_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "hotelreview r2 WHERE r2.hotel_id = p.hotel_id AND r2.status = '1' GROUP BY r2.hotel_id) AS reviews, p.sort_order FROM " . DB_PREFIX . "hotel p LEFT JOIN " . DB_PREFIX . "hotel_description pd ON (p.hotel_id = pd.hotel_id) LEFT JOIN " . DB_PREFIX . "hotel_to_store p2s ON (p.hotel_id = p2s.hotel_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.hotel_id = '" . (int)$hotel_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return array(
				'hotel_id'     => $query->row['hotel_id'],
				'name'             => $query->row['name'],
				'description'      => $query->row['description'],
				'address'          => $query->row['address'],
				'short_description'=> $query->row['short_description'],
				'meta_title'       => $query->row['meta_title'],
				'meta_description' => $query->row['meta_description'],
				'meta_keyword'     => $query->row['meta_keyword'],
				'star'             => $query->row['star'],
				'wifi'             => $query->row['wifi'],
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
				'hotelreviews'        => $query->row['reviews'] ? $query->row['reviews'] : 0,
				'minimum'          => $query->row['minimum'],
				'sort_order'       => $query->row['sort_order'],
				'status'           => $query->row['status'],
				'date_added'       => $query->row['date_added'],
				'date_modified'    => $query->row['date_modified'],
				'viewed'           => $query->row['viewed'],
				'maps_apil'         => $query->row['maps_apil'],
				'maps_apir'         => $query->row['maps_apir']
			);
		} else {
			return false;
		}
	}

	public function getHotels($data = array()) {
		$sql = "SELECT p.hotel_id, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "hotelreview r1 WHERE r1.hotel_id = p.hotel_id AND r1.status = '1' GROUP BY r1.hotel_id) AS rating, (SELECT price FROM " . DB_PREFIX . "hotel_discount pd2 WHERE pd2.hotel_id = p.hotel_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "hotel_special ps WHERE ps.hotel_id = p.hotel_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "hotel_to_category p2c ON (cp.category_id = p2c.category_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "hotel_to_category p2c";
			}

			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "hotel_filter pf ON (p2c.hotel_id = pf.hotel_id) LEFT JOIN " . DB_PREFIX . "hotel p ON (pf.hotel_id = p.hotel_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "hotel p ON (p2c.hotel_id = p.hotel_id)";
			}
		} else {
			$sql .= " FROM " . DB_PREFIX . "hotel p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "hotel_description pd ON (p.hotel_id = pd.hotel_id) LEFT JOIN " . DB_PREFIX . "hotel_to_store p2s ON (p.hotel_id = p2s.hotel_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
			} else {
				$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
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

		$sql .= " GROUP BY p.hotel_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'p.star',
			'p.quantity',
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

		$hotel_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$hotel_data[$result['hotel_id']] = $this->getHotel($result['hotel_id']);
		}

		return $hotel_data;
	}

	public function getHotelSpecials($data = array()) {
		$sql = "SELECT DISTINCT ps.hotel_id, (SELECT AVG(rating) FROM " . DB_PREFIX . "hotelreview r1 WHERE r1.hotel_id = ps.hotel_id AND r1.status = '1' GROUP BY r1.hotel_id) AS rating FROM " . DB_PREFIX . "hotel_special ps LEFT JOIN " . DB_PREFIX . "hotel p ON (ps.hotel_id = p.hotel_id) LEFT JOIN " . DB_PREFIX . "hotel_description pd ON (p.hotel_id = pd.hotel_id) LEFT JOIN " . DB_PREFIX . "hotel_to_store p2s ON (p.hotel_id = p2s.hotel_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) GROUP BY ps.hotel_id";

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

		$hotel_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$hotel_data[$result['hotel_id']] = $this->getHotel($result['hotel_id']);
		}

		return $hotel_data;
	}

	public function getLatestHotels($limit) {
		$hotel_data = $this->cache->get('hotel.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

		if (!$hotel_data) {
			$query = $this->db->query("SELECT p.hotel_id FROM " . DB_PREFIX . "hotel p LEFT JOIN " . DB_PREFIX . "hotel_to_store p2s ON (p.hotel_id = p2s.hotel_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.date_added DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$hotel_data[$result['hotel_id']] = $this->getHotel($result['hotel_id']);
			}

			$this->cache->set('hotel.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $hotel_data);
		}

		return $hotel_data;
	}

	public function getPopularHotels($limit) {
		$hotel_data = array();

		$query = $this->db->query("SELECT p.hotel_id FROM " . DB_PREFIX . "hotel p LEFT JOIN " . DB_PREFIX . "hotel_to_store p2s ON (p.hotel_id = p2s.hotel_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.viewed DESC, p.date_added DESC LIMIT " . (int)$limit);

		foreach ($query->rows as $result) {
			$hotel_data[$result['hotel_id']] = $this->getHotel($result['hotel_id']);
		}

		return $hotel_data;
	}

	public function getBestSellerHotels($limit) {
		$hotel_data = $this->cache->get('hotel.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

		if (!$hotel_data) {
			$hotel_data = array();

			$query = $this->db->query("SELECT op.hotel_id, SUM(op.quantity) AS total FROM " . DB_PREFIX . "order_hotel op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "hotel` p ON (op.hotel_id = p.hotel_id) LEFT JOIN " . DB_PREFIX . "hotel_to_store p2s ON (p.hotel_id = p2s.hotel_id) WHERE o.order_status_id > '0' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY op.hotel_id ORDER BY total DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$hotel_data[$result['hotel_id']] = $this->getHotel($result['hotel_id']);
			}

			$this->cache->set('hotel.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $hotel_data);
		}

		return $hotel_data;
	}

	public function getHotelAttributes($hotel_id) {
		$hotel_attribute_group_data = array();

		$hotel_attribute_group_query = $this->db->query("SELECT ag.attribute_group_id, agd.name FROM " . DB_PREFIX . "hotel_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_group ag ON (a.attribute_group_id = ag.attribute_group_id) LEFT JOIN " . DB_PREFIX . "attribute_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id) WHERE pa.hotel_id = '" . (int)$hotel_id . "' AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY ag.attribute_group_id ORDER BY ag.sort_order, agd.name");

		foreach ($hotel_attribute_group_query->rows as $hotel_attribute_group) {
			$hotel_attribute_data = array();

			$hotel_attribute_query = $this->db->query("SELECT a.attribute_id, ad.name, pa.text FROM " . DB_PREFIX . "hotel_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.hotel_id = '" . (int)$hotel_id . "' AND a.attribute_group_id = '" . (int)$hotel_attribute_group['attribute_group_id'] . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY a.sort_order, ad.name");

			foreach ($hotel_attribute_query->rows as $hotel_attribute) {
				$hotel_attribute_data[] = array(
					'attribute_id' => $hotel_attribute['attribute_id'],
					'name'         => $hotel_attribute['name'],
					'text'         => $hotel_attribute['text']
				);
			}

			$hotel_attribute_group_data[] = array(
				'attribute_group_id' => $hotel_attribute_group['attribute_group_id'],
				'name'               => $hotel_attribute_group['name'],
				'attribute'          => $hotel_attribute_data
			);
		}

		return $hotel_attribute_group_data;
	}

	public function getHotelOptions($hotel_id) {
		$hotel_option_data = array();

		$hotel_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "hotel_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.hotel_id = '" . (int)$hotel_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.sort_order");

		foreach ($hotel_option_query->rows as $hotel_option) {
			$hotel_option_value_data = array();

			$hotel_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "hotel_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.hotel_id = '" . (int)$hotel_id . "' AND pov.hotel_option_id = '" . (int)$hotel_option['hotel_option_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order");

			foreach ($hotel_option_value_query->rows as $hotel_option_value) {
				$hotel_option_value_data[] = array(
					'hotel_option_value_id' => $hotel_option_value['hotel_option_value_id'],
					'option_value_id'         => $hotel_option_value['option_value_id'],
					'name'                    => $hotel_option_value['name'],
					'image'                   => $hotel_option_value['image'],
					'quantity'                => $hotel_option_value['quantity'],
					'subtract'                => $hotel_option_value['subtract'],
					'price'                   => $hotel_option_value['price'],
					'price_prefix'            => $hotel_option_value['price_prefix'],
					'weight'                  => $hotel_option_value['weight'],
					'weight_prefix'           => $hotel_option_value['weight_prefix']
				);
			}

			$hotel_option_data[] = array(
				'hotel_option_id'    => $hotel_option['hotel_option_id'],
				'hotel_option_value' => $hotel_option_value_data,
				'option_id'            => $hotel_option['option_id'],
				'name'                 => $hotel_option['name'],
				'type'                 => $hotel_option['type'],
				'value'                => $hotel_option['value'],
				'required'             => $hotel_option['required']
			);
		}

		return $hotel_option_data;
	}

	public function getHotelDiscounts($hotel_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "hotel_discount WHERE hotel_id = '" . (int)$hotel_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity > 1 AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity ASC, priority ASC, price ASC");

		return $query->rows;
	}

	public function getHotelImages($hotel_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "hotel_image WHERE hotel_id = '" . (int)$hotel_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getHotelRelated($hotel_id) {
		$hotel_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "hotel_related pr LEFT JOIN " . DB_PREFIX . "hotel p ON (pr.related_id = p.hotel_id) LEFT JOIN " . DB_PREFIX . "hotel_to_store p2s ON (p.hotel_id = p2s.hotel_id) WHERE pr.hotel_id = '" . (int)$hotel_id . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		foreach ($query->rows as $result) {
			$hotel_data[$result['related_id']] = $this->getHotel($result['related_id']);
		}

		return $hotel_data;
	}

	public function getHotelLayoutId($hotel_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "hotel_to_layout WHERE hotel_id = '" . (int)$hotel_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}

	public function getCategories($hotel_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "hotel_to_category WHERE hotel_id = '" . (int)$hotel_id . "'");

		return $query->rows;
	}

	public function getTotalHotels($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.hotel_id) AS total";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "hotel_to_category p2c ON (cp.category_id = p2c.category_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "hotel_to_category p2c";
			}

			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "hotel_filter pf ON (p2c.hotel_id = pf.hotel_id) LEFT JOIN " . DB_PREFIX . "hotel p ON (pf.hotel_id = p.hotel_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "hotel p ON (p2c.hotel_id = p.hotel_id)";
			}
		} else {
			$sql .= " FROM " . DB_PREFIX . "hotel p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "hotel_description pd ON (p.hotel_id = pd.hotel_id) LEFT JOIN " . DB_PREFIX . "hotel_to_store p2s ON (p.hotel_id = p2s.hotel_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
			} else {
				$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
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

	public function getProfiles($hotel_id) {
		return $this->db->query("SELECT `pd`.* FROM `" . DB_PREFIX . "hotel_recurring` `pp` JOIN `" . DB_PREFIX . "recurring_description` `pd` ON `pd`.`language_id` = " . (int)$this->config->get('config_language_id') . " AND `pd`.`recurring_id` = `pp`.`recurring_id` JOIN `" . DB_PREFIX . "recurring` `p` ON `p`.`recurring_id` = `pd`.`recurring_id` WHERE `hotel_id` = " . (int)$hotel_id . " AND `status` = 1 AND `customer_group_id` = " . (int)$this->config->get('config_customer_group_id') . " ORDER BY `sort_order` ASC")->rows;
	}

	public function getProfile($hotel_id, $recurring_id) {
		return $this->db->query("SELECT * FROM `" . DB_PREFIX . "recurring` `p` JOIN `" . DB_PREFIX . "hotel_recurring` `pp` ON `pp`.`recurring_id` = `p`.`recurring_id` AND `pp`.`hotel_id` = " . (int)$hotel_id . " WHERE `pp`.`recurring_id` = " . (int)$recurring_id . " AND `status` = 1 AND `pp`.`customer_group_id` = " . (int)$this->config->get('config_customer_group_id'))->row;
	}

	public function getTotalHotelSpecials() {
		$query = $this->db->query("SELECT COUNT(DISTINCT ps.hotel_id) AS total FROM " . DB_PREFIX . "hotel_special ps LEFT JOIN " . DB_PREFIX . "hotel p ON (ps.hotel_id = p.hotel_id) LEFT JOIN " . DB_PREFIX . "hotel_to_store p2s ON (p.hotel_id = p2s.hotel_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))");

		if (isset($query->row['total'])) {
			return $query->row['total'];
		} else {
			return 0;
		}
	}
}
