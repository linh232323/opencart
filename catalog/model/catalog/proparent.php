<?php
class ModelCatalogProparent extends Model {
	public function updateViewed($proparent_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "proparent SET viewed = (viewed + 1) WHERE proparent_id = '" . (int)$proparent_id . "'");
	}

	public function getProparent($proparent_id) {
		$query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, (SELECT price FROM " . DB_PREFIX . "proparent_discount pd2 WHERE pd2.proparent_id = p.proparent_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "proparent_special ps WHERE ps.proparent_id = p.proparent_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, (SELECT points FROM " . DB_PREFIX . "proparent_reward pr WHERE pr.proparent_id = p.proparent_id AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "') AS reward, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "') AS stock_status, (SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS weight_class, (SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS length_class, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "pareview r1 WHERE r1.proparent_id = p.proparent_id AND r1.status = '1' GROUP BY r1.proparent_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "pareview r2 WHERE r2.proparent_id = p.proparent_id AND r2.status = '1' GROUP BY r2.proparent_id) AS reviews, p.sort_order FROM " . DB_PREFIX . "proparent p LEFT JOIN " . DB_PREFIX . "proparent_description pd ON (p.proparent_id = pd.proparent_id) LEFT JOIN " . DB_PREFIX . "proparent_to_store p2s ON (p.proparent_id = p2s.proparent_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.proparent_id = '" . (int)$proparent_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return array(
				'proparent_id'     => $query->row['proparent_id'],
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
				'pareviews'        => $query->row['reviews'] ? $query->row['reviews'] : 0,
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

	public function getProparents($data = array()) {
		$sql = "SELECT p.proparent_id, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "pareview r1 WHERE r1.proparent_id = p.proparent_id AND r1.status = '1' GROUP BY r1.proparent_id) AS rating, (SELECT price FROM " . DB_PREFIX . "proparent_discount pd2 WHERE pd2.proparent_id = p.proparent_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "proparent_special ps WHERE ps.proparent_id = p.proparent_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "proparent_to_category p2c ON (cp.category_id = p2c.category_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "proparent_to_category p2c";
			}

			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "proparent_filter pf ON (p2c.proparent_id = pf.proparent_id) LEFT JOIN " . DB_PREFIX . "proparent p ON (pf.proparent_id = p.proparent_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "proparent p ON (p2c.proparent_id = p.proparent_id)";
			}
		} else {
			$sql .= " FROM " . DB_PREFIX . "proparent p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "proparent_description pd ON (p.proparent_id = pd.proparent_id) LEFT JOIN " . DB_PREFIX . "proparent_to_store p2s ON (p.proparent_id = p2s.proparent_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

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

		$sql .= " GROUP BY p.proparent_id";

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

		$proparent_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$proparent_data[$result['proparent_id']] = $this->getProparent($result['proparent_id']);
		}

		return $proparent_data;
	}

	public function getProparentSpecials($data = array()) {
		$sql = "SELECT DISTINCT ps.proparent_id, (SELECT AVG(rating) FROM " . DB_PREFIX . "pareview r1 WHERE r1.proparent_id = ps.proparent_id AND r1.status = '1' GROUP BY r1.proparent_id) AS rating FROM " . DB_PREFIX . "proparent_special ps LEFT JOIN " . DB_PREFIX . "proparent p ON (ps.proparent_id = p.proparent_id) LEFT JOIN " . DB_PREFIX . "proparent_description pd ON (p.proparent_id = pd.proparent_id) LEFT JOIN " . DB_PREFIX . "proparent_to_store p2s ON (p.proparent_id = p2s.proparent_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) GROUP BY ps.proparent_id";

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

		$proparent_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$proparent_data[$result['proparent_id']] = $this->getProparent($result['proparent_id']);
		}

		return $proparent_data;
	}

	public function getLatestProparents($limit) {
		$proparent_data = $this->cache->get('proparent.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

		if (!$proparent_data) {
			$query = $this->db->query("SELECT p.proparent_id FROM " . DB_PREFIX . "proparent p LEFT JOIN " . DB_PREFIX . "proparent_to_store p2s ON (p.proparent_id = p2s.proparent_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.date_added DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$proparent_data[$result['proparent_id']] = $this->getProparent($result['proparent_id']);
			}

			$this->cache->set('proparent.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $proparent_data);
		}

		return $proparent_data;
	}

	public function getPopularProparents($limit) {
		$proparent_data = array();

		$query = $this->db->query("SELECT p.proparent_id FROM " . DB_PREFIX . "proparent p LEFT JOIN " . DB_PREFIX . "proparent_to_store p2s ON (p.proparent_id = p2s.proparent_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.viewed DESC, p.date_added DESC LIMIT " . (int)$limit);

		foreach ($query->rows as $result) {
			$proparent_data[$result['proparent_id']] = $this->getProparent($result['proparent_id']);
		}

		return $proparent_data;
	}

	public function getBestSellerProparents($limit) {
		$proparent_data = $this->cache->get('proparent.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

		if (!$proparent_data) {
			$proparent_data = array();

			$query = $this->db->query("SELECT op.proparent_id, SUM(op.quantity) AS total FROM " . DB_PREFIX . "order_proparent op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "proparent` p ON (op.proparent_id = p.proparent_id) LEFT JOIN " . DB_PREFIX . "proparent_to_store p2s ON (p.proparent_id = p2s.proparent_id) WHERE o.order_status_id > '0' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY op.proparent_id ORDER BY total DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$proparent_data[$result['proparent_id']] = $this->getProparent($result['proparent_id']);
			}

			$this->cache->set('proparent.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $proparent_data);
		}

		return $proparent_data;
	}

	public function getProparentAttributes($proparent_id) {
		$proparent_attribute_group_data = array();

		$proparent_attribute_group_query = $this->db->query("SELECT ag.attribute_group_id, agd.name FROM " . DB_PREFIX . "proparent_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_group ag ON (a.attribute_group_id = ag.attribute_group_id) LEFT JOIN " . DB_PREFIX . "attribute_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id) WHERE pa.proparent_id = '" . (int)$proparent_id . "' AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY ag.attribute_group_id ORDER BY ag.sort_order, agd.name");

		foreach ($proparent_attribute_group_query->rows as $proparent_attribute_group) {
			$proparent_attribute_data = array();

			$proparent_attribute_query = $this->db->query("SELECT a.attribute_id, ad.name, pa.text FROM " . DB_PREFIX . "proparent_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.proparent_id = '" . (int)$proparent_id . "' AND a.attribute_group_id = '" . (int)$proparent_attribute_group['attribute_group_id'] . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY a.sort_order, ad.name");

			foreach ($proparent_attribute_query->rows as $proparent_attribute) {
				$proparent_attribute_data[] = array(
					'attribute_id' => $proparent_attribute['attribute_id'],
					'name'         => $proparent_attribute['name'],
					'text'         => $proparent_attribute['text']
				);
			}

			$proparent_attribute_group_data[] = array(
				'attribute_group_id' => $proparent_attribute_group['attribute_group_id'],
				'name'               => $proparent_attribute_group['name'],
				'attribute'          => $proparent_attribute_data
			);
		}

		return $proparent_attribute_group_data;
	}

	public function getProparentOptions($proparent_id) {
		$proparent_option_data = array();

		$proparent_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "proparent_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.proparent_id = '" . (int)$proparent_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.sort_order");

		foreach ($proparent_option_query->rows as $proparent_option) {
			$proparent_option_value_data = array();

			$proparent_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "proparent_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.proparent_id = '" . (int)$proparent_id . "' AND pov.proparent_option_id = '" . (int)$proparent_option['proparent_option_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order");

			foreach ($proparent_option_value_query->rows as $proparent_option_value) {
				$proparent_option_value_data[] = array(
					'proparent_option_value_id' => $proparent_option_value['proparent_option_value_id'],
					'option_value_id'         => $proparent_option_value['option_value_id'],
					'name'                    => $proparent_option_value['name'],
					'image'                   => $proparent_option_value['image'],
					'quantity'                => $proparent_option_value['quantity'],
					'subtract'                => $proparent_option_value['subtract'],
					'price'                   => $proparent_option_value['price'],
					'price_prefix'            => $proparent_option_value['price_prefix'],
					'weight'                  => $proparent_option_value['weight'],
					'weight_prefix'           => $proparent_option_value['weight_prefix']
				);
			}

			$proparent_option_data[] = array(
				'proparent_option_id'    => $proparent_option['proparent_option_id'],
				'proparent_option_value' => $proparent_option_value_data,
				'option_id'            => $proparent_option['option_id'],
				'name'                 => $proparent_option['name'],
				'type'                 => $proparent_option['type'],
				'value'                => $proparent_option['value'],
				'required'             => $proparent_option['required']
			);
		}

		return $proparent_option_data;
	}

	public function getProparentDiscounts($proparent_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "proparent_discount WHERE proparent_id = '" . (int)$proparent_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity > 1 AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity ASC, priority ASC, price ASC");

		return $query->rows;
	}

	public function getProparentImages($proparent_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "proparent_image WHERE proparent_id = '" . (int)$proparent_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getProparentRelated($proparent_id) {
		$proparent_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "proparent_related pr LEFT JOIN " . DB_PREFIX . "proparent p ON (pr.related_id = p.proparent_id) LEFT JOIN " . DB_PREFIX . "proparent_to_store p2s ON (p.proparent_id = p2s.proparent_id) WHERE pr.proparent_id = '" . (int)$proparent_id . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		foreach ($query->rows as $result) {
			$proparent_data[$result['related_id']] = $this->getProparent($result['related_id']);
		}

		return $proparent_data;
	}

	public function getProparentLayoutId($proparent_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "proparent_to_layout WHERE proparent_id = '" . (int)$proparent_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}

	public function getCategories($proparent_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "proparent_to_category WHERE proparent_id = '" . (int)$proparent_id . "'");

		return $query->rows;
	}

	public function getTotalProparents($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.proparent_id) AS total";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "proparent_to_category p2c ON (cp.category_id = p2c.category_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "proparent_to_category p2c";
			}

			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "proparent_filter pf ON (p2c.proparent_id = pf.proparent_id) LEFT JOIN " . DB_PREFIX . "proparent p ON (pf.proparent_id = p.proparent_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "proparent p ON (p2c.proparent_id = p.proparent_id)";
			}
		} else {
			$sql .= " FROM " . DB_PREFIX . "proparent p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "proparent_description pd ON (p.proparent_id = pd.proparent_id) LEFT JOIN " . DB_PREFIX . "proparent_to_store p2s ON (p.proparent_id = p2s.proparent_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

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

	public function getProfiles($proparent_id) {
		return $this->db->query("SELECT `pd`.* FROM `" . DB_PREFIX . "proparent_recurring` `pp` JOIN `" . DB_PREFIX . "recurring_description` `pd` ON `pd`.`language_id` = " . (int)$this->config->get('config_language_id') . " AND `pd`.`recurring_id` = `pp`.`recurring_id` JOIN `" . DB_PREFIX . "recurring` `p` ON `p`.`recurring_id` = `pd`.`recurring_id` WHERE `proparent_id` = " . (int)$proparent_id . " AND `status` = 1 AND `customer_group_id` = " . (int)$this->config->get('config_customer_group_id') . " ORDER BY `sort_order` ASC")->rows;
	}

	public function getProfile($proparent_id, $recurring_id) {
		return $this->db->query("SELECT * FROM `" . DB_PREFIX . "recurring` `p` JOIN `" . DB_PREFIX . "proparent_recurring` `pp` ON `pp`.`recurring_id` = `p`.`recurring_id` AND `pp`.`proparent_id` = " . (int)$proparent_id . " WHERE `pp`.`recurring_id` = " . (int)$recurring_id . " AND `status` = 1 AND `pp`.`customer_group_id` = " . (int)$this->config->get('config_customer_group_id'))->row;
	}

	public function getTotalProparentSpecials() {
		$query = $this->db->query("SELECT COUNT(DISTINCT ps.proparent_id) AS total FROM " . DB_PREFIX . "proparent_special ps LEFT JOIN " . DB_PREFIX . "proparent p ON (ps.proparent_id = p.proparent_id) LEFT JOIN " . DB_PREFIX . "proparent_to_store p2s ON (p.proparent_id = p2s.proparent_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))");

		if (isset($query->row['total'])) {
			return $query->row['total'];
		} else {
			return 0;
		}
	}
}
