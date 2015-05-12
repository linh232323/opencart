<?php
class ModelCatalogTour extends Model {
	public function updateViewed($tour_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "tour SET viewed = (viewed + 1) WHERE tour_id = '" . (int)$tour_id . "'");
	}

	public function getTour($tour_id) {
		$query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, (SELECT price FROM " . DB_PREFIX . "tour_discount pd2 WHERE pd2.tour_id = p.tour_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "tour_special ps WHERE ps.tour_id = p.tour_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, (SELECT points FROM " . DB_PREFIX . "tour_reward pr WHERE pr.tour_id = p.tour_id AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "') AS reward, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "') AS stock_status, (SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS weight_class, (SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS length_class, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "tour_review r1 WHERE r1.tour_id = p.tour_id AND r1.status = '1' GROUP BY r1.tour_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "tour_review r2 WHERE r2.tour_id = p.tour_id AND r2.status = '1' GROUP BY r2.tour_id) AS tour_reviews, p.sort_order FROM " . DB_PREFIX . "tour p LEFT JOIN " . DB_PREFIX . "tour_description pd ON (p.tour_id = pd.tour_id) LEFT JOIN " . DB_PREFIX . "tour_to_store p2s ON (p.tour_id = p2s.tour_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.tour_id = '" . (int)$tour_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return array(
				'tour_id'          => $query->row['tour_id'],
				'name'             => $query->row['name'],
				'description'      => $query->row['description'],
				'meta_title'       => $query->row['meta_title'],
				'meta_description' => $query->row['meta_description'],
				'meta_keyword'     => $query->row['meta_keyword'],
				'tag'              => $query->row['tag'],
				'model'            => $query->row['model'],
				'quantity'         => $query->row['quantity'],
				'image'            => $query->row['image'],
                            	'tax_class_id'     => $query->row['tax_class_id'],
				'rating'           => $query->row['rating'],
				'date_available'   => $query->row['date_available'],
				'tour_reviews'     => $query->row['tour_reviews'] ? $query->row['tour_reviews'] : 0,
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
        public function getStock($tour_id,$check_in,$check_out) {
            $stock = 0 ;
            $query = $this->db->query("SELECT op.quantity ,op.order_id ,o.order_status_id FROM " . DB_PREFIX . "order_tour op LEFT JOIN  " . DB_PREFIX . "order o ON op.order_id = o.order_id WHERE tour_id = " . $tour_id . " AND (((check_in <=" . $check_in . " ) AND ( check_out >= " . $check_in ." )) OR (( check_in <= " . $check_out . " ) AND ( check_out >= " . $check_out . " ))) ");
            foreach ($query->rows as $value) {
                if($value['order_status_id'] == 5){
                    $stock += $value['quantity'];
                }
            }
            return $stock;
        }
        
	public function getTours($data = array()) {
		$sql = "SELECT p.tour_id, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "tour_review r1 WHERE r1.tour_id = p.tour_id AND r1.status = '1' GROUP BY r1.tour_id) AS rating, (SELECT price FROM " . DB_PREFIX . "tour_discount pd2 WHERE pd2.tour_id = p.tour_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "tour_special ps WHERE ps.tour_id = p.tour_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "tour_to_category p2c ON (cp.category_id = p2c.category_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "tour_to_category p2c";
			}

			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "tour_filter pf ON (p2c.tour_id = pf.tour_id) LEFT JOIN " . DB_PREFIX . "tour p ON (pf.tour_id = p.tour_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "tour p ON (p2c.tour_id = p.tour_id)";
			}
		} else {
			$sql .= " FROM " . DB_PREFIX . "tour p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "tour_description pd ON (p.tour_id = pd.tour_id) LEFT JOIN " . DB_PREFIX . "tour_to_store p2s ON (p.tour_id = p2s.tour_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

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

		$sql .= " GROUP BY p.tour_id";

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

		$tour_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$tour_data[$result['tour_id']] = $this->getTour($result['tour_id']);
		}

		return $tour_data;
	}
        
        public function getTourPrices($tour_id) {
		$tour_price_data = array();

		$tour_price_query = $this->db->query("SELECT price_id FROM " . DB_PREFIX . "tour_price WHERE tour_id = '" . (int)$tour_id . "' GROUP BY price_id");

		foreach ($tour_price_query->rows as $tour_price) {
			$tour_date_data = array();

			$tour_date_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tour_price WHERE tour_id = '" . (int)$tour_id . "' AND price_id = '" . (int)$tour_price['price_id'] . "'");
                        
                        foreach ($tour_date_query->rows as $tour_date) {
                                $tour_date_data['1'] = array('date' => $tour_date['date_form']);
                                $tour_date_data['2'] = array('date' => $tour_date['date_to']);
                        }
			
			

			$tour_price_data[] = array(
				'price_id'                  => $tour_price['price_id'],
				'tour_id'                => $tour_date['tour_id'],
				'tour_adult_net'         => $tour_date['adult_net'],
				'tour_adult_percent'     => $tour_date['adult_percent'],
				'tour_adult_gross'       => $tour_date['adult_gross'],
				'tour_price_discount'    => $tour_date['discount'],
				'tour_child_net'         => $tour_date['child_net'],
				'tour_child_percent'     => $tour_date['child_percent'],
				'tour_child_gross'       => $tour_date['child_gross'],
				'tour_baby_net'         => $tour_date['baby_net'],
				'tour_baby_percent'     => $tour_date['baby_percent'],
				'tour_baby_gross'       => $tour_date['baby_gross'],
				'tour_date'              => $tour_date_data
			);
		}

		return $tour_price_data;
	}
        
        public function updatePrice($tour_id,$price) {
		$this->db->query("UPDATE " . DB_PREFIX . "tour SET price = $price WHERE tour_id = '" . (int)$tour_id . "'");
	}

	public function getTourSpecials($data = array()) {
		$sql = "SELECT DISTINCT ps.tour_id, (SELECT AVG(rating) FROM " . DB_PREFIX . "tour_review r1 WHERE r1.tour_id = ps.tour_id AND r1.status = '1' GROUP BY r1.tour_id) AS rating FROM " . DB_PREFIX . "tour_special ps LEFT JOIN " . DB_PREFIX . "tour p ON (ps.tour_id = p.tour_id) LEFT JOIN " . DB_PREFIX . "tour_description pd ON (p.tour_id = pd.tour_id) LEFT JOIN " . DB_PREFIX . "tour_to_store p2s ON (p.tour_id = p2s.tour_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) GROUP BY ps.tour_id";

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

		$tour_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$tour_data[$result['tour_id']] = $this->getTour($result['tour_id']);
		}

		return $tour_data;
	}

	public function getLatestTours($limit) {
		$tour_data = $this->cache->get('tour.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

		if (!$tour_data) {
			$query = $this->db->query("SELECT p.tour_id FROM " . DB_PREFIX . "tour p LEFT JOIN " . DB_PREFIX . "tour_to_store p2s ON (p.tour_id = p2s.tour_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.date_added DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$tour_data[$result['tour_id']] = $this->getTour($result['tour_id']);
			}

			$this->cache->set('tour.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $tour_data);
		}

		return $tour_data;
	}

	public function getPopularTours($limit) {
		$tour_data = array();

		$query = $this->db->query("SELECT p.tour_id FROM " . DB_PREFIX . "tour p LEFT JOIN " . DB_PREFIX . "tour_to_store p2s ON (p.tour_id = p2s.tour_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.viewed DESC, p.date_added DESC LIMIT " . (int)$limit);

		foreach ($query->rows as $result) {
			$tour_data[$result['tour_id']] = $this->getTour($result['tour_id']);
		}

		return $tour_data;
	}

	public function getBestSellerTours($limit) {
		$tour_data = $this->cache->get('tour.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

		if (!$tour_data) {
			$tour_data = array();

			$query = $this->db->query("SELECT op.tour_id, SUM(op.quantity) AS total FROM " . DB_PREFIX . "order_tour op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "tour` p ON (op.tour_id = p.tour_id) LEFT JOIN " . DB_PREFIX . "tour_to_store p2s ON (p.tour_id = p2s.tour_id) WHERE o.order_status_id > '0' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY op.tour_id ORDER BY total DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$tour_data[$result['tour_id']] = $this->getTour($result['tour_id']);
			}

			$this->cache->set('tour.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $tour_data);
		}

		return $tour_data;
	}

	public function getTourAttributes($tour_id) {
		$tour_attribute_group_data = array();

		$tour_attribute_group_query = $this->db->query("SELECT ag.attribute_group_id, agd.name FROM " . DB_PREFIX . "tour_attribute pa LEFT JOIN " . DB_PREFIX . "attribute_tour a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_tour_group ag ON (a.attribute_group_id = ag.attribute_group_id) LEFT JOIN " . DB_PREFIX . "attribute_tour_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id) WHERE pa.tour_id = '" . (int)$tour_id . "' AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY ag.attribute_group_id ORDER BY ag.sort_order, agd.name");

		foreach ($tour_attribute_group_query->rows as $tour_attribute_group) {
			$tour_attribute_data = array();

			$tour_attribute_query = $this->db->query("SELECT a.attribute_id, ad.name, pa.text FROM " . DB_PREFIX . "tour_attribute pa LEFT JOIN " . DB_PREFIX . "attribute_tour a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_tour_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.tour_id = '" . (int)$tour_id . "' AND a.attribute_group_id = '" . (int)$tour_attribute_group['attribute_group_id'] . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY a.sort_order, ad.name");

			foreach ($tour_attribute_query->rows as $tour_attribute) {
				$tour_attribute_data[] = array(
					'attribute_id' => $tour_attribute['attribute_id'],
					'name'         => $tour_attribute['name'],
					'text'         => $tour_attribute['text']
				);
			}

			$tour_attribute_group_data[] = array(
				'attribute_group_id' => $tour_attribute_group['attribute_group_id'],
				'name'               => $tour_attribute_group['name'],
				'attribute'          => $tour_attribute_data
			);
		}

		return $tour_attribute_group_data;
	}

	public function getTourOptions($tour_id) {
		$tour_option_data = array();

		$tour_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tour_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.tour_id = '" . (int)$tour_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.sort_order");

		foreach ($tour_option_query->rows as $tour_option) {
			$tour_option_value_data = array();

			$tour_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tour_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.tour_id = '" . (int)$tour_id . "' AND pov.tour_option_id = '" . (int)$tour_option['tour_option_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order");

			foreach ($tour_option_value_query->rows as $tour_option_value) {
				$tour_option_value_data[] = array(
					'tour_option_value_id' => $tour_option_value['tour_option_value_id'],
					'option_value_id'         => $tour_option_value['option_value_id'],
					'name'                    => $tour_option_value['name'],
					'image'                   => $tour_option_value['image'],
					'quantity'                => $tour_option_value['quantity'],
					'maxadults'               => $tour_option_value['maxadults'],
					'subtract'                => $tour_option_value['subtract'],
					'price'                   => $tour_option_value['price'],
					'price_prefix'            => $tour_option_value['price_prefix'],
					'weight'                  => $tour_option_value['weight'],
					'weight_prefix'           => $tour_option_value['weight_prefix']
				);
			}

			$tour_option_data[] = array(
				'tour_option_id'    => $tour_option['tour_option_id'],
				'tour_option_value' => $tour_option_value_data,
				'option_id'            => $tour_option['option_id'],
				'name'                 => $tour_option['name'],
				'type'                 => $tour_option['type'],
				'value'                => $tour_option['value'],
				'required'             => $tour_option['required']
			);
		}

		return $tour_option_data;
	}

	public function getTourDiscounts($tour_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tour_discount WHERE tour_id = '" . (int)$tour_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity > 1 AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity ASC, priority ASC, price ASC");

		return $query->rows;
	}

	public function getTourImages($tour_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tour_image WHERE tour_id = '" . (int)$tour_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getTourRelated($tour_id) {
		$tour_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tour_related pr LEFT JOIN " . DB_PREFIX . "tour p ON (pr.related_id = p.tour_id) LEFT JOIN " . DB_PREFIX . "tour_to_store p2s ON (p.tour_id = p2s.tour_id) WHERE pr.tour_id = '" . (int)$tour_id . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		foreach ($query->rows as $result) {
			$tour_data[$result['related_id']] = $this->getTour($result['related_id']);
		}

		return $tour_data;
	}

	public function getTourLayoutId($tour_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tour_to_layout WHERE tour_id = '" . (int)$tour_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}

	public function getCategories($tour_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tour_to_category WHERE tour_id = '" . (int)$tour_id . "'");

		return $query->rows;
	}

	public function getTotalTours($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.tour_id) AS total";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "tour_to_category p2c ON (cp.category_id = p2c.category_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "tour_to_category p2c";
			}

			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "tour_filter pf ON (p2c.tour_id = pf.tour_id) LEFT JOIN " . DB_PREFIX . "tour p ON (pf.tour_id = p.tour_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "tour p ON (p2c.tour_id = p.tour_id)";
			}
		} else {
			$sql .= " FROM " . DB_PREFIX . "tour p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "tour_description pd ON (p.tour_id = pd.tour_id) LEFT JOIN " . DB_PREFIX . "tour_to_store p2s ON (p.tour_id = p2s.tour_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

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

	public function getProfiles($tour_id) {
		return $this->db->query("SELECT `pd`.* FROM `" . DB_PREFIX . "tour_recurring` `pp` JOIN `" . DB_PREFIX . "recurring_description` `pd` ON `pd`.`language_id` = " . (int)$this->config->get('config_language_id') . " AND `pd`.`recurring_id` = `pp`.`recurring_id` JOIN `" . DB_PREFIX . "recurring` `p` ON `p`.`recurring_id` = `pd`.`recurring_id` WHERE `tour_id` = " . (int)$tour_id . " AND `status` = 1 AND `customer_group_id` = " . (int)$this->config->get('config_customer_group_id') . " ORDER BY `sort_order` ASC")->rows;
	}

	public function getProfile($tour_id, $recurring_id) {
		return $this->db->query("SELECT * FROM `" . DB_PREFIX . "recurring` `p` JOIN `" . DB_PREFIX . "tour_recurring` `pp` ON `pp`.`recurring_id` = `p`.`recurring_id` AND `pp`.`tour_id` = " . (int)$tour_id . " WHERE `pp`.`recurring_id` = " . (int)$recurring_id . " AND `status` = 1 AND `pp`.`customer_group_id` = " . (int)$this->config->get('config_customer_group_id'))->row;
	}

	public function getTotalTourSpecials() {
		$query = $this->db->query("SELECT COUNT(DISTINCT ps.tour_id) AS total FROM " . DB_PREFIX . "tour_special ps LEFT JOIN " . DB_PREFIX . "tour p ON (ps.tour_id = p.tour_id) LEFT JOIN " . DB_PREFIX . "tour_to_store p2s ON (p.tour_id = p2s.tour_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))");

		if (isset($query->row['total'])) {
			return $query->row['total'];
		} else {
			return 0;
		}
	}
        
}
