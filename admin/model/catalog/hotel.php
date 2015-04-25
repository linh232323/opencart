<?php
class ModelCatalogHotel extends Model {
	public function addHotel($data) {
		$this->event->trigger('pre.admin.hotel.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "hotel SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', ean = '" . $this->db->escape($data['ean']) . "', jan = '" . $this->db->escape($data['jan']) . "', isbn = '" . $this->db->escape($data['isbn']) . "', mpn = '" . $this->db->escape($data['mpn']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', author_id = '" . (int)$data['author_id'] . "', maps_apil = '" . $data['maps_apil'] . "', maps_apir = '" . $data['maps_apir'] . "', minimum = '" . (int)$data['minimum'] . "', subtract = '" . (int)$data['subtract'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', star = '" . (int)$data['star'] . "', wifi = '" . (int)$data['wifi'] . "', price = '" . (float)$data['price'] . "', points = '" . (int)$data['points'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . $this->db->escape($data['tax_class_id']) . "', sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW()");

		$hotel_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "hotel SET image = '" . $this->db->escape($data['image']) . "' WHERE hotel_id = '" . (int)$hotel_id . "'");
		}

		foreach ($data['hotel_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_description SET hotel_id = '" . (int)$hotel_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', address = '" . $this->db->escape($value['address']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) .  "', short_description = '" . $this->db->escape($value['short_description']) . "'");
		}
                
		if (isset($data['hotel_store'])) {
			foreach ($data['hotel_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_to_store SET hotel_id = '" . (int)$hotel_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['hotel_attribute'])) {
			foreach ($data['hotel_attribute'] as $hotel_attribute) {
				if ($hotel_attribute['attribute_id']) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_attribute WHERE hotel_id = '" . (int)$hotel_id . "' AND attribute_id = '" . (int)$hotel_attribute['attribute_id'] . "'");

					foreach ($hotel_attribute['hotel_attribute_description'] as $language_id => $hotel_attribute_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_attribute SET hotel_id = '" . (int)$hotel_id . "', attribute_id = '" . (int)$hotel_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($hotel_attribute_description['text']) . "'");
					}
				}
			}
		}

		if (isset($data['hotel_option'])) {
			foreach ($data['hotel_option'] as $hotel_option) {
				if ($hotel_option['type'] == 'select' || $hotel_option['type'] == 'radio' || $hotel_option['type'] == 'checkbox' || $hotel_option['type'] == 'image') {
					if (isset($hotel_option['hotel_option_value'])) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_option SET hotel_id = '" . (int)$hotel_id . "', option_id = '" . (int)$hotel_option['option_id'] . "', required = '" . (int)$hotel_option['required'] . "'");

						$hotel_option_id = $this->db->getLastId();

						foreach ($hotel_option['hotel_option_value'] as $hotel_option_value) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_option_value SET hotel_option_id = '" . (int)$hotel_option_id . "', hotel_id = '" . (int)$hotel_id . "', option_id = '" . (int)$hotel_option['option_id'] . "', option_value_id = '" . (int)$hotel_option_value['option_value_id'] . "', quantity = '" . (int)$hotel_option_value['quantity'] . "', subtract = '" . (int)$hotel_option_value['subtract'] . "', price = '" . (float)$hotel_option_value['price'] . "', price_prefix = '" . $this->db->escape($hotel_option_value['price_prefix']) . "', points = '" . (int)$hotel_option_value['points'] . "', points_prefix = '" . $this->db->escape($hotel_option_value['points_prefix']) . "', weight = '" . (float)$hotel_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($hotel_option_value['weight_prefix']) . "'");
						}
					}
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_option SET hotel_id = '" . (int)$hotel_id . "', option_id = '" . (int)$hotel_option['option_id'] . "', value = '" . $this->db->escape($hotel_option['value']) . "', required = '" . (int)$hotel_option['required'] . "'");
				}
			}
		}

		if (isset($data['hotel_discount'])) {
			foreach ($data['hotel_discount'] as $hotel_discount) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_discount SET hotel_id = '" . (int)$hotel_id . "', customer_group_id = '" . (int)$hotel_discount['customer_group_id'] . "', quantity = '" . (int)$hotel_discount['quantity'] . "', priority = '" . (int)$hotel_discount['priority'] . "', price = '" . (float)$hotel_discount['price'] . "', date_start = '" . $this->db->escape($hotel_discount['date_start']) . "', date_end = '" . $this->db->escape($hotel_discount['date_end']) . "'");
			}
		}

		if (isset($data['hotel_special'])) {
			foreach ($data['hotel_special'] as $hotel_special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_special SET hotel_id = '" . (int)$hotel_id . "', customer_group_id = '" . (int)$hotel_special['customer_group_id'] . "', priority = '" . (int)$hotel_special['priority'] . "', price = '" . (float)$hotel_special['price'] . "', date_start = '" . $this->db->escape($hotel_special['date_start']) . "', date_end = '" . $this->db->escape($hotel_special['date_end']) . "'");
			}
		}

		if (isset($data['hotel_image'])) {
			foreach ($data['hotel_image'] as $hotel_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_image SET hotel_id = '" . (int)$hotel_id . "', image = '" . $this->db->escape($hotel_image['image']) . "', sort_order = '" . (int)$hotel_image['sort_order'] . "'");
			}
		}

		if (isset($data['hotel_download'])) {
			foreach ($data['hotel_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_to_download SET hotel_id = '" . (int)$hotel_id . "', download_id = '" . (int)$download_id . "'");
			}
		}

		if (isset($data['hotel_category'])) {
			foreach ($data['hotel_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_to_category SET hotel_id = '" . (int)$hotel_id . "', category_id = '" . (int)$category_id . "'");
			}
		}

		if (isset($data['hotel_filter'])) {
			foreach ($data['hotel_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_filter SET hotel_id = '" . (int)$hotel_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['hotel_related'])) {
			foreach ($data['hotel_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_related WHERE hotel_id = '" . (int)$hotel_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_related SET hotel_id = '" . (int)$hotel_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_related WHERE hotel_id = '" . (int)$related_id . "' AND related_id = '" . (int)$hotel_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_related SET hotel_id = '" . (int)$related_id . "', related_id = '" . (int)$hotel_id . "'");
			}
		}

		if (isset($data['hotel_reward'])) {
			foreach ($data['hotel_reward'] as $customer_group_id => $hotel_reward) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_reward SET hotel_id = '" . (int)$hotel_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$hotel_reward['points'] . "'");
			}
		}

		if (isset($data['hotel_layout'])) {
			foreach ($data['hotel_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_to_layout SET hotel_id = '" . (int)$hotel_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'hotel_id=" . (int)$hotel_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		if (isset($data['hotel_recurrings'])) {
			foreach ($data['hotel_recurrings'] as $recurring) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "hotel_recurring` SET `hotel_id` = " . (int)$hotel_id . ", customer_group_id = " . (int)$recurring['customer_group_id'] . ", `recurring_id` = " . (int)$recurring['recurring_id']);
			}
		}

		$this->cache->delete('hotel');

		$this->event->trigger('post.admin.hotel.add', $hotel_id);

		return $hotel_id;
	}

	public function editHotel($hotel_id, $data) {
		$this->event->trigger('pre.admin.hotel.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "hotel SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', ean = '" . $this->db->escape($data['ean']) . "', jan = '" . $this->db->escape($data['jan']) . "', isbn = '" . $this->db->escape($data['isbn']) . "', mpn = '" . $this->db->escape($data['mpn']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', maps_apil = '" . $data['maps_apil'] . "', maps_apir = '" . $data['maps_apir'] . "', wifi = '" . (int)$data['wifi'] . "', minimum = '" . (int)$data['minimum'] . "', subtract = '" . (int)$data['subtract'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', star = '" . (int)$data['star'] . "', price = '" . (float)$data['price'] . "', points = '" . (int)$data['points'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . $this->db->escape($data['tax_class_id']) . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE hotel_id = '" . (int)$hotel_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "hotel SET image = '" . $this->db->escape($data['image']) . "' WHERE hotel_id = '" . (int)$hotel_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_description WHERE hotel_id = '" . (int)$hotel_id . "'");

		foreach ($data['hotel_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_description SET hotel_id = '" . (int)$hotel_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', address = '" . $this->db->escape($value['address']) . "', description = '" . $this->db->escape($value['description']) . "', short_description = '" . $this->db->escape($value['short_description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}
                
		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_to_store WHERE hotel_id = '" . (int)$hotel_id . "'");

		if (isset($data['hotel_store'])) {
			foreach ($data['hotel_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_to_store SET hotel_id = '" . (int)$hotel_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_attribute WHERE hotel_id = '" . (int)$hotel_id . "'");

		if (!empty($data['hotel_attribute'])) {
			foreach ($data['hotel_attribute'] as $hotel_attribute) {
				if ($hotel_attribute['attribute_id']) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_attribute WHERE hotel_id = '" . (int)$hotel_id . "' AND attribute_id = '" . (int)$hotel_attribute['attribute_id'] . "'");

					foreach ($hotel_attribute['hotel_attribute_description'] as $language_id => $hotel_attribute_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_attribute SET hotel_id = '" . (int)$hotel_id . "', attribute_id = '" . (int)$hotel_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($hotel_attribute_description['text']) . "'");
					}
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_option WHERE hotel_id = '" . (int)$hotel_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_option_value WHERE hotel_id = '" . (int)$hotel_id . "'");

		if (isset($data['hotel_option'])) {
			foreach ($data['hotel_option'] as $hotel_option) {
				if ($hotel_option['type'] == 'select' || $hotel_option['type'] == 'radio' || $hotel_option['type'] == 'checkbox' || $hotel_option['type'] == 'image') {
					if (isset($hotel_option['hotel_option_value'])) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_option SET hotel_option_id = '" . (int)$hotel_option['hotel_option_id'] . "', hotel_id = '" . (int)$hotel_id . "', option_id = '" . (int)$hotel_option['option_id'] . "', required = '" . (int)$hotel_option['required'] . "'");

						$hotel_option_id = $this->db->getLastId();

						foreach ($hotel_option['hotel_option_value'] as $hotel_option_value) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_option_value SET hotel_option_value_id = '" . (int)$hotel_option_value['hotel_option_value_id'] . "', hotel_option_id = '" . (int)$hotel_option_id . "', hotel_id = '" . (int)$hotel_id . "', option_id = '" . (int)$hotel_option['option_id'] . "', option_value_id = '" . (int)$hotel_option_value['option_value_id'] . "', quantity = '" . (int)$hotel_option_value['quantity'] . "', subtract = '" . (int)$hotel_option_value['subtract'] . "', price = '" . (float)$hotel_option_value['price'] . "', price_prefix = '" . $this->db->escape($hotel_option_value['price_prefix']) . "', points = '" . (int)$hotel_option_value['points'] . "', points_prefix = '" . $this->db->escape($hotel_option_value['points_prefix']) . "', weight = '" . (float)$hotel_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($hotel_option_value['weight_prefix']) . "'");
						}
					}
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_option SET hotel_option_id = '" . (int)$hotel_option['hotel_option_id'] . "', hotel_id = '" . (int)$hotel_id . "', option_id = '" . (int)$hotel_option['option_id'] . "', value = '" . $this->db->escape($hotel_option['value']) . "', required = '" . (int)$hotel_option['required'] . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_discount WHERE hotel_id = '" . (int)$hotel_id . "'");

		if (isset($data['hotel_discount'])) {
			foreach ($data['hotel_discount'] as $hotel_discount) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_discount SET hotel_id = '" . (int)$hotel_id . "', customer_group_id = '" . (int)$hotel_discount['customer_group_id'] . "', quantity = '" . (int)$hotel_discount['quantity'] . "', priority = '" . (int)$hotel_discount['priority'] . "', price = '" . (float)$hotel_discount['price'] . "', date_start = '" . $this->db->escape($hotel_discount['date_start']) . "', date_end = '" . $this->db->escape($hotel_discount['date_end']) . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_special WHERE hotel_id = '" . (int)$hotel_id . "'");

		if (isset($data['hotel_special'])) {
			foreach ($data['hotel_special'] as $hotel_special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_special SET hotel_id = '" . (int)$hotel_id . "', customer_group_id = '" . (int)$hotel_special['customer_group_id'] . "', priority = '" . (int)$hotel_special['priority'] . "', price = '" . (float)$hotel_special['price'] . "', date_start = '" . $this->db->escape($hotel_special['date_start']) . "', date_end = '" . $this->db->escape($hotel_special['date_end']) . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_image WHERE hotel_id = '" . (int)$hotel_id . "'");

		if (isset($data['hotel_image'])) {
			foreach ($data['hotel_image'] as $hotel_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_image SET hotel_id = '" . (int)$hotel_id . "', image = '" . $this->db->escape($hotel_image['image']) . "', sort_order = '" . (int)$hotel_image['sort_order'] . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_to_download WHERE hotel_id = '" . (int)$hotel_id . "'");

		if (isset($data['hotel_download'])) {
			foreach ($data['hotel_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_to_download SET hotel_id = '" . (int)$hotel_id . "', download_id = '" . (int)$download_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_to_category WHERE hotel_id = '" . (int)$hotel_id . "'");

		if (isset($data['hotel_category'])) {
			foreach ($data['hotel_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_to_category SET hotel_id = '" . (int)$hotel_id . "', category_id = '" . (int)$category_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_filter WHERE hotel_id = '" . (int)$hotel_id . "'");

		if (isset($data['hotel_filter'])) {
			foreach ($data['hotel_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_filter SET hotel_id = '" . (int)$hotel_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_related WHERE hotel_id = '" . (int)$hotel_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_related WHERE related_id = '" . (int)$hotel_id . "'");

		if (isset($data['hotel_related'])) {
			foreach ($data['hotel_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_related WHERE hotel_id = '" . (int)$hotel_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_related SET hotel_id = '" . (int)$hotel_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_related WHERE hotel_id = '" . (int)$related_id . "' AND related_id = '" . (int)$hotel_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_related SET hotel_id = '" . (int)$related_id . "', related_id = '" . (int)$hotel_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_reward WHERE hotel_id = '" . (int)$hotel_id . "'");

		if (isset($data['hotel_reward'])) {
			foreach ($data['hotel_reward'] as $customer_group_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_reward SET hotel_id = '" . (int)$hotel_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$value['points'] . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_to_layout WHERE hotel_id = '" . (int)$hotel_id . "'");

		if (isset($data['hotel_layout'])) {
			foreach ($data['hotel_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "hotel_to_layout SET hotel_id = '" . (int)$hotel_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'hotel_id=" . (int)$hotel_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'hotel_id=" . (int)$hotel_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->db->query("DELETE FROM `" . DB_PREFIX . "hotel_recurring` WHERE hotel_id = " . (int)$hotel_id);

		if (isset($data['hotel_recurrings'])) {
			foreach ($data['hotel_recurrings'] as $recurring) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "hotel_recurring` SET `hotel_id` = " . (int)$hotel_id . ", customer_group_id = " . (int)$recurring['customer_group_id'] . ", `recurring_id` = " . (int)$recurring['recurring_id']);
			}
		}

		$this->cache->delete('hotel');

		$this->event->trigger('post.admin.hotel.edit', $hotel_id);
	}

	public function copyHotel($hotel_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "hotel p LEFT JOIN " . DB_PREFIX . "hotel_description pd ON (p.hotel_id = pd.hotel_id) WHERE p.hotel_id = '" . (int)$hotel_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		if ($query->num_rows) {
			$data = array();

			$data = $query->row;

			$data['sku'] = '';
			$data['upc'] = '';
			$data['viewed'] = '0';
			$data['keyword'] = '';
			$data['status'] = '0';
			$data['star'] = '0';

			$data = array_merge($data, array('hotel_attribute' => $this->getHotelAttributes($hotel_id)));
			$data = array_merge($data, array('hotel_description' => $this->getHotelDescriptions($hotel_id)));
                        $data = array_merge($data, array('hotel_discount' => $this->getHotelDiscounts($hotel_id)));
			$data = array_merge($data, array('hotel_filter' => $this->getHotelFilters($hotel_id)));
			$data = array_merge($data, array('hotel_image' => $this->getHotelImages($hotel_id)));
			$data = array_merge($data, array('hotel_option' => $this->getHotelOptions($hotel_id)));
			$data = array_merge($data, array('hotel_related' => $this->getHotelRelated($hotel_id)));
			$data = array_merge($data, array('hotel_reward' => $this->getHotelRewards($hotel_id)));
			$data = array_merge($data, array('hotel_special' => $this->getHotelSpecials($hotel_id)));
			$data = array_merge($data, array('hotel_category' => $this->getHotelCategories($hotel_id)));
			$data = array_merge($data, array('hotel_download' => $this->getHotelDownloads($hotel_id)));
			$data = array_merge($data, array('hotel_layout' => $this->getHotelLayouts($hotel_id)));
			$data = array_merge($data, array('hotel_store' => $this->getHotelStores($hotel_id)));
			$data = array_merge($data, array('hotel_recurrings' => $this->getRecurrings($hotel_id)));

			$this->addHotel($data);
		}
	}

	public function deleteHotel($hotel_id) {
		$this->event->trigger('pre.admin.hotel.delete', $hotel_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel WHERE hotel_id = '" . (int)$hotel_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_attribute WHERE hotel_id = '" . (int)$hotel_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_description WHERE hotel_id = '" . (int)$hotel_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_discount WHERE hotel_id = '" . (int)$hotel_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_filter WHERE hotel_id = '" . (int)$hotel_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_image WHERE hotel_id = '" . (int)$hotel_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_option WHERE hotel_id = '" . (int)$hotel_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_option_value WHERE hotel_id = '" . (int)$hotel_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_related WHERE hotel_id = '" . (int)$hotel_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_related WHERE related_id = '" . (int)$hotel_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_reward WHERE hotel_id = '" . (int)$hotel_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_special WHERE hotel_id = '" . (int)$hotel_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_to_category WHERE hotel_id = '" . (int)$hotel_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_to_download WHERE hotel_id = '" . (int)$hotel_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_to_layout WHERE hotel_id = '" . (int)$hotel_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_to_store WHERE hotel_id = '" . (int)$hotel_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE hotel_id = '" . (int)$hotel_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "hotel_recurring WHERE hotel_id = " . (int)$hotel_id);
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'hotel_id=" . (int)$hotel_id . "'");

		$this->cache->delete('hotel');

		$this->event->trigger('post.admin.hotel.delete', $hotel_id);
	}

	public function getHotel($hotel_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'hotel_id=" . (int)$hotel_id . "') AS keyword FROM " . DB_PREFIX . "hotel p LEFT JOIN " . DB_PREFIX . "hotel_description pd ON (p.hotel_id = pd.hotel_id) WHERE p.hotel_id = '" . (int)$hotel_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getHotels($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "hotel p LEFT JOIN " . DB_PREFIX . "hotel_description pd ON (p.hotel_id = pd.hotel_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_model'])) {
			$sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
		}

		if (isset($data['filter_price']) && !is_null($data['filter_price'])) {
			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}

		if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
			$sql .= " AND p.quantity = '" . (int)$data['filter_quantity'] . "'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}
                
		if (isset($data['filter_star']) && !is_null($data['filter_star'])) {
			$sql .= " AND p.star = '" . (int)$data['filter_star'] . "'";
		}
                
		if (isset($data['filter_user_id']) && !is_null($data['filter_user_id']) && $data['filter_user_id'] != 1) {
			$sql .= " AND p.author_id = '" . (int)$data['filter_user_id'] . "'";
		}
		
		$sql .= " GROUP BY p.hotel_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'p.price',
			'p.quantity',
			'p.star',
			'p.status',
			'p.sort_order',
			'p.filter_user_id'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY pd.name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
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

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getHotelsByCategoryId($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "hotel p LEFT JOIN " . DB_PREFIX . "hotel_description pd ON (p.hotel_id = pd.hotel_id) LEFT JOIN " . DB_PREFIX . "hotel_to_category p2c ON (p.hotel_id = p2c.hotel_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.category_id = '" . (int)$category_id . "' ORDER BY pd.name ASC");

		return $query->rows;
	}

	public function getHotelDescriptions($hotel_id) {
		$hotel_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "hotel_description WHERE hotel_id = '" . (int)$hotel_id . "'");

		foreach ($query->rows as $result) {
			$hotel_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'address'          => $result['address'],
				'description'      => $result['description'],
				'short_description'=> $result['short_description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'tag'              => $result['tag']
			);
		}

		return $hotel_description_data;
	}
        
	public function getHotelCategories($hotel_id) {
		$hotel_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "hotel_to_category WHERE hotel_id = '" . (int)$hotel_id . "'");

		foreach ($query->rows as $result) {
			$hotel_category_data[] = $result['category_id'];
		}

		return $hotel_category_data;
	}

	public function getHotelFilters($hotel_id) {
		$hotel_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "hotel_filter WHERE hotel_id = '" . (int)$hotel_id . "'");

		foreach ($query->rows as $result) {
			$hotel_filter_data[] = $result['filter_id'];
		}

		return $hotel_filter_data;
	}

	public function getHotelAttributes($hotel_id) {
		$hotel_attribute_data = array();

		$hotel_attribute_query = $this->db->query("SELECT attribute_id FROM " . DB_PREFIX . "hotel_attribute WHERE hotel_id = '" . (int)$hotel_id . "' GROUP BY attribute_id");

		foreach ($hotel_attribute_query->rows as $hotel_attribute) {
			$hotel_attribute_description_data = array();

			$hotel_attribute_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "hotel_attribute WHERE hotel_id = '" . (int)$hotel_id . "' AND attribute_id = '" . (int)$hotel_attribute['attribute_id'] . "'");

			foreach ($hotel_attribute_description_query->rows as $hotel_attribute_description) {
				$hotel_attribute_description_data[$hotel_attribute_description['language_id']] = array('text' => $hotel_attribute_description['text']);
			}

			$hotel_attribute_data[] = array(
				'attribute_id'                  => $hotel_attribute['attribute_id'],
				'hotel_attribute_description' => $hotel_attribute_description_data
			);
		}

		return $hotel_attribute_data;
	}

	public function getHotelOptions($hotel_id) {
		$hotel_option_data = array();

		$hotel_option_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "hotel_option` po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN `" . DB_PREFIX . "option_description` od ON (o.option_id = od.option_id) WHERE po.hotel_id = '" . (int)$hotel_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		foreach ($hotel_option_query->rows as $hotel_option) {
			$hotel_option_value_data = array();

			$hotel_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "hotel_option_value WHERE hotel_option_id = '" . (int)$hotel_option['hotel_option_id'] . "'");

			foreach ($hotel_option_value_query->rows as $hotel_option_value) {
				$hotel_option_value_data[] = array(
					'hotel_option_value_id' => $hotel_option_value['hotel_option_value_id'],
					'option_value_id'         => $hotel_option_value['option_value_id'],
					'quantity'                => $hotel_option_value['quantity'],
					'subtract'                => $hotel_option_value['subtract'],
					'price'                   => $hotel_option_value['price'],
					'price_prefix'            => $hotel_option_value['price_prefix'],
					'points'                  => $hotel_option_value['points'],
					'points_prefix'           => $hotel_option_value['points_prefix'],
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

	public function getHotelImages($hotel_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "hotel_image WHERE hotel_id = '" . (int)$hotel_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getHotelDiscounts($hotel_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "hotel_discount WHERE hotel_id = '" . (int)$hotel_id . "' ORDER BY quantity, priority, price");

		return $query->rows;
	}

	public function getHotelSpecials($hotel_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "hotel_special WHERE hotel_id = '" . (int)$hotel_id . "' ORDER BY priority, price");

		return $query->rows;
	}

	public function getHotelRewards($hotel_id) {
		$hotel_reward_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "hotel_reward WHERE hotel_id = '" . (int)$hotel_id . "'");

		foreach ($query->rows as $result) {
			$hotel_reward_data[$result['customer_group_id']] = array('points' => $result['points']);
		}

		return $hotel_reward_data;
	}

	public function getHotelDownloads($hotel_id) {
		$hotel_download_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "hotel_to_download WHERE hotel_id = '" . (int)$hotel_id . "'");

		foreach ($query->rows as $result) {
			$hotel_download_data[] = $result['download_id'];
		}

		return $hotel_download_data;
	}

	public function getHotelStores($hotel_id) {
		$hotel_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "hotel_to_store WHERE hotel_id = '" . (int)$hotel_id . "'");

		foreach ($query->rows as $result) {
			$hotel_store_data[] = $result['store_id'];
		}

		return $hotel_store_data;
	}

	public function getHotelLayouts($hotel_id) {
		$hotel_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "hotel_to_layout WHERE hotel_id = '" . (int)$hotel_id . "'");

		foreach ($query->rows as $result) {
			$hotel_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $hotel_layout_data;
	}

	public function getHotelRelated($hotel_id) {
		$hotel_related_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "hotel_related WHERE hotel_id = '" . (int)$hotel_id . "'");

		foreach ($query->rows as $result) {
			$hotel_related_data[] = $result['related_id'];
		}

		return $hotel_related_data;
	}

	public function getRecurrings($hotel_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "hotel_recurring` WHERE hotel_id = '" . (int)$hotel_id . "'");

		return $query->rows;
	}

	public function getTotalHotels($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.hotel_id) AS total FROM " . DB_PREFIX . "hotel p LEFT JOIN " . DB_PREFIX . "hotel_description pd ON (p.hotel_id = pd.hotel_id)";

		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
                if (isset($data['filter_user_id']) && !is_null($data['filter_user_id']) && $data['filter_user_id'] != 1) {
			$sql .= " AND p.author_id = '" . (int)$data['filter_user_id'] . "'";
		}
                
		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_model'])) {
			$sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
		}

		if (isset($data['filter_price']) && !is_null($data['filter_price'])) {
			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}

		if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
			$sql .= " AND p.quantity = '" . (int)$data['filter_quantity'] . "'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalHotelsByTaxClassId($tax_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "hotel WHERE tax_class_id = '" . (int)$tax_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalHotelsByStockStatusId($stock_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "hotel WHERE stock_status_id = '" . (int)$stock_status_id . "'");

		return $query->row['total'];
	}

	public function getTotalHotelsByWeightClassId($weight_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "hotel WHERE weight_class_id = '" . (int)$weight_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalHotelsByLengthClassId($length_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "hotel WHERE length_class_id = '" . (int)$length_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalHotelsByDownloadId($download_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "hotel_to_download WHERE download_id = '" . (int)$download_id . "'");

		return $query->row['total'];
	}

	public function getTotalHotelsByManufacturerId($manufacturer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "hotel WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		return $query->row['total'];
	}

	public function getTotalHotelsByAttributeId($attribute_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "hotel_attribute WHERE attribute_id = '" . (int)$attribute_id . "'");

		return $query->row['total'];
	}

	public function getTotalHotelsByOptionId($option_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "hotel_option WHERE option_id = '" . (int)$option_id . "'");

		return $query->row['total'];
	}

	public function getTotalHotelsByProfileId($recurring_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "hotel_recurring WHERE recurring_id = '" . (int)$recurring_id . "'");

		return $query->row['total'];
	}

	public function getTotalHotelsByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "hotel_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
}