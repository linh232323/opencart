<?php
class ModelCatalogRoom extends Model {
	public function addRoom($data) {
		$this->event->trigger('pre.admin.room.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "room SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', ean = '" . $this->db->escape($data['ean']) . "', jan = '" . $this->db->escape($data['jan']) . "', isbn = '" . $this->db->escape($data['isbn']) . "', mpn = '" . $this->db->escape($data['mpn']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', maxadults = '" . (int)$data['maxadults'] . "', author_id = '" . (int)$data['author_id'] . "', minimum = '" . (int)$data['minimum'] . "', subtract = '" . (int)$data['subtract'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', points = '" . (int)$data['points'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . $this->db->escape($data['tax_class_id']) . "', sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW()");

		$room_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "room SET image = '" . $this->db->escape($data['image']) . "' WHERE room_id = '" . (int)$room_id . "'");
		}

		foreach ($data['room_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "room_description SET room_id = '" . (int)$room_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		if (isset($data['room_store'])) {
			foreach ($data['room_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "room_to_store SET room_id = '" . (int)$room_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['room_attribute'])) {
			foreach ($data['room_attribute'] as $room_attribute) {
				if ($room_attribute['attribute_id']) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "room_attribute WHERE room_id = '" . (int)$room_id . "' AND attribute_id = '" . (int)$room_attribute['attribute_id'] . "'");

					foreach ($room_attribute['room_attribute_description'] as $language_id => $room_attribute_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "room_attribute SET room_id = '" . (int)$room_id . "', attribute_id = '" . (int)$room_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($room_attribute_description['text']) . "'");
					}
				}
			}
		}
                
		if (isset($data['room_price'])) {
			foreach ($data['room_price'] as $room_price) {
				  
                                $room_price_gross = $this->db->escape($room_price['room_price_net']) + (($this->db->escape($room_price['room_price_net'])/100) * $this->db->escape($room_price['room_price_percent']));
                
                                $room_extra_gross = $this->db->escape($room_price['room_extra_net']) + (($this->db->escape($room_price['room_extra_net'])/100) * $this->db->escape($room_price['room_extra_percent']));

				$this->db->query("DELETE FROM " . DB_PREFIX . "room_price WHERE room_id = '" . (int)$room_id . "' AND price_id = '" . (int)$room_price['price_id'] . "'");

				$this->db->query("INSERT INTO " . DB_PREFIX . "room_price SET room_id = '" . (int)$room_id . "', price_id = '" . (int)$room_price['price_id'] . "', date_form = '" . $room_price['room_date']['1']['date'] . "', date_to = '" . $room_price['room_date']['2']['date'] . "', price_net = '" .  $this->db->escape($room_price['room_price_net']) . "', price_percent = '" .  $this->db->escape($room_price['room_price_percent']) . "', price_gross = '" .  $room_price_gross . "', extra_net = '" .  $this->db->escape($room_price['room_extra_net']) . "', extra_percent = '" .  $this->db->escape($room_price['room_extra_percent']) . "', extra_gross = '" .  $room_extra_gross . "', discount = '" .  $this->db->escape($room_price['room_price_discount']) . "'");
				
			}
		}

		if (isset($data['room_option'])) {
			foreach ($data['room_option'] as $room_option) {
				if ($room_option['type'] == 'select' || $room_option['type'] == 'radio' || $room_option['type'] == 'checkbox' || $room_option['type'] == 'image') {
					if (isset($room_option['room_option_value'])) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "room_option SET room_id = '" . (int)$room_id . "', option_id = '" . (int)$room_option['option_id'] . "', required = '" . (int)$room_option['required'] . "'");

						$room_option_id = $this->db->getLastId();

						foreach ($room_option['room_option_value'] as $room_option_value) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "room_option_value SET room_option_id = '" . (int)$room_option_id . "', room_id = '" . (int)$room_id . "', option_id = '" . (int)$room_option['option_id'] . "', option_value_id = '" . (int)$room_option_value['option_value_id'] . "', quantity = '" . (int)$room_option_value['quantity'] . "', maxadults = '" . (int)$room_option_value['maxadults'] . "', subtract = '" . (int)$room_option_value['subtract'] . "', price = '" . (float)$room_option_value['price'] . "', price_prefix = '" . $this->db->escape($room_option_value['price_prefix']) . "', points = '" . (int)$room_option_value['points'] . "', points_prefix = '" . $this->db->escape($room_option_value['points_prefix']) . "', weight = '" . (float)$room_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($room_option_value['weight_prefix']) . "'");
						}
					}
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "room_option SET room_id = '" . (int)$room_id . "', option_id = '" . (int)$room_option['option_id'] . "', value = '" . $this->db->escape($room_option['value']) . "', required = '" . (int)$room_option['required'] . "'");
				}
			}
		}

		if (isset($data['room_discount'])) {
			foreach ($data['room_discount'] as $room_discount) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "room_discount SET room_id = '" . (int)$room_id . "', customer_group_id = '" . (int)$room_discount['customer_group_id'] . "', quantity = '" . (int)$room_discount['quantity'] ."', maxadults = '" . (int)$room_discount['maxadults'] . "', priority = '" . (int)$room_discount['priority'] . "', price = '" . (float)$room_discount['price'] . "', date_start = '" . $this->db->escape($room_discount['date_start']) . "', date_end = '" . $this->db->escape($room_discount['date_end']) . "'");
			}
		}

		if (isset($data['room_special'])) {
			foreach ($data['room_special'] as $room_special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "room_special SET room_id = '" . (int)$room_id . "', customer_group_id = '" . (int)$room_special['customer_group_id'] . "', priority = '" . (int)$room_special['priority'] . "', price = '" . (float)$room_special['price'] . "', date_start = '" . $this->db->escape($room_special['date_start']) . "', date_end = '" . $this->db->escape($room_special['date_end']) . "'");
			}
		}

		if (isset($data['room_image'])) {
			foreach ($data['room_image'] as $room_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "room_image SET room_id = '" . (int)$room_id . "', image = '" . $this->db->escape($room_image['image']) . "', sort_order = '" . (int)$room_image['sort_order'] . "'");
			}
		}

		if (isset($data['room_download'])) {
			foreach ($data['room_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "room_to_download SET room_id = '" . (int)$room_id . "', download_id = '" . (int)$download_id . "'");
			}
		}

		if (isset($data['room_hotel'])) {
			foreach ($data['room_hotel'] as $hotel_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "room_to_hotel SET room_id = '" . (int)$room_id . "', hotel_id = '" . (int)$hotel_id . "'");
			}
		}

		if (isset($data['room_filter'])) {
			foreach ($data['room_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "room_filter SET room_id = '" . (int)$room_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['room_related'])) {
			foreach ($data['room_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "room_related WHERE room_id = '" . (int)$room_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "room_related SET room_id = '" . (int)$room_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "room_related WHERE room_id = '" . (int)$related_id . "' AND related_id = '" . (int)$room_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "room_related SET room_id = '" . (int)$related_id . "', related_id = '" . (int)$room_id . "'");
			}
		}

		if (isset($data['room_reward'])) {
			foreach ($data['room_reward'] as $customer_group_id => $room_reward) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "room_reward SET room_id = '" . (int)$room_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$room_reward['points'] . "'");
			}
		}

		if (isset($data['room_layout'])) {
			foreach ($data['room_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "room_to_layout SET room_id = '" . (int)$room_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'room_id=" . (int)$room_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		if (isset($data['room_recurrings'])) {
			foreach ($data['room_recurrings'] as $recurring) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "room_recurring` SET `room_id` = " . (int)$room_id . ", customer_group_id = " . (int)$recurring['customer_group_id'] . ", `recurring_id` = " . (int)$recurring['recurring_id']);
			}
		}

		$this->cache->delete('room');

		$this->event->trigger('post.admin.room.add', $room_id);

		return $room_id;
	}

	public function editRoom($room_id, $data) {
		$this->event->trigger('pre.admin.room.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "room SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', ean = '" . $this->db->escape($data['ean']) . "', jan = '" . $this->db->escape($data['jan']) . "', isbn = '" . $this->db->escape($data['isbn']) . "', mpn = '" . $this->db->escape($data['mpn']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', maxadults = '" . (int)$data['maxadults'] . "', minimum = '" . (int)$data['minimum'] . "', subtract = '" . (int)$data['subtract'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', points = '" . (int)$data['points'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . $this->db->escape($data['tax_class_id']) . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE room_id = '" . (int)$room_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "room SET image = '" . $this->db->escape($data['image']) . "' WHERE room_id = '" . (int)$room_id ."'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "room_description WHERE room_id = '" . (int)$room_id . "'");

		foreach ($data['room_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "room_description SET room_id = '" . (int)$room_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "room_to_store WHERE room_id = '" . (int)$room_id . "'");

		if (isset($data['room_store'])) {
			foreach ($data['room_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "room_to_store SET room_id = '" . (int)$room_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "room_attribute WHERE room_id = '" . (int)$room_id . "'");

		if (!empty($data['room_attribute'])) {
			foreach ($data['room_attribute'] as $room_attribute) {
				if ($room_attribute['attribute_id']) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "room_attribute WHERE room_id = '" . (int)$room_id . "' AND attribute_id = '" . (int)$room_attribute['attribute_id'] . "'");

					foreach ($room_attribute['room_attribute_description'] as $language_id => $room_attribute_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "room_attribute SET room_id = '" . (int)$room_id . "', attribute_id = '" . (int)$room_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($room_attribute_description['text']) . "'");
					}
				}
			}
		}
                
		$this->db->query("DELETE FROM " . DB_PREFIX . "room_price WHERE room_id = '" . (int)$room_id . "'");

		if (!empty($data['room_price'])) {
			foreach ($data['room_price'] as $room_price) {
					
                                $room_price_gross = $this->db->escape($room_price['room_price_net']) + (($this->db->escape($room_price['room_price_net'])/100) * $this->db->escape($room_price['room_price_percent']));
                
                                $room_extra_gross = $this->db->escape($room_price['room_extra_net']) + (($this->db->escape($room_price['room_extra_net'])/100) * $this->db->escape($room_price['room_extra_percent']));

				$this->db->query("DELETE FROM " . DB_PREFIX . "room_price WHERE room_id = '" . (int)$room_id . "' AND price_id = '" . (int)$room_price['price_id'] . "'");

				$this->db->query("INSERT INTO " . DB_PREFIX . "room_price SET room_id = '" . (int)$room_id . "', price_id = '" . (int)$room_price['price_id'] . "', date_form = '" . $room_price['room_date']['1']['date'] . "', date_to = '" . $room_price['room_date']['2']['date'] . "', price_net = '" .  $this->db->escape($room_price['room_price_net']) . "', price_percent = '" .  $this->db->escape($room_price['room_price_percent']) . "', price_gross = '" .  $room_price_gross . "', extra_net = '" .  $this->db->escape($room_price['room_extra_net']) . "', extra_percent = '" .  $this->db->escape($room_price['room_extra_percent']) . "', extra_gross = '" .  $room_extra_gross . "', discount = '" .  $this->db->escape($room_price['room_price_discount']) . "'");
				
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "room_option WHERE room_id = '" . (int)$room_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "room_option_value WHERE room_id = '" . (int)$room_id . "'");

		if (isset($data['room_option'])) {
			foreach ($data['room_option'] as $room_option) {
				if ($room_option['type'] == 'select' || $room_option['type'] == 'radio' || $room_option['type'] == 'checkbox' || $room_option['type'] == 'image') {
					if (isset($room_option['room_option_value'])) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "room_option SET room_option_id = '" . (int)$room_option['room_option_id'] . "', room_id = '" . (int)$room_id . "', option_id = '" . (int)$room_option['option_id'] . "', required = '" . (int)$room_option['required'] . "'");

						$room_option_id = $this->db->getLastId();

						foreach ($room_option['room_option_value'] as $room_option_value) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "room_option_value SET room_option_value_id = '" . (int)$room_option_value['room_option_value_id'] . "', room_option_id = '" . (int)$room_option_id . "', room_id = '" . (int)$room_id . "', option_id = '" . (int)$room_option['option_id'] . "', option_value_id = '" . (int)$room_option_value['option_value_id'] . "', quantity = '" . (int)$room_option_value['quantity'] . "', maxadults = '" . (int)$room_option_value['maxadults'] . "', subtract = '" . (int)$room_option_value['subtract'] . "', price = '" . (float)$room_option_value['price'] . "', price_prefix = '" . $this->db->escape($room_option_value['price_prefix']) . "', points = '" . (int)$room_option_value['points'] . "', points_prefix = '" . $this->db->escape($room_option_value['points_prefix']) . "', weight = '" . (float)$room_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($room_option_value['weight_prefix']) . "'");
						}
					}
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "room_option SET room_option_id = '" . (int)$room_option['room_option_id'] . "', room_id = '" . (int)$room_id . "', option_id = '" . (int)$room_option['option_id'] . "', value = '" . $this->db->escape($room_option['value']) . "', required = '" . (int)$room_option['required'] . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "room_discount WHERE room_id = '" . (int)$room_id . "'");

		if (isset($data['room_discount'])) {
			foreach ($data['room_discount'] as $room_discount) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "room_discount SET room_id = '" . (int)$room_id . "', customer_group_id = '" . (int)$room_discount['customer_group_id'] . "', quantity = '" . (int)$room_discount['quantity'] . "', maxadults = '" . (int)$room_discount['maxadults'] . "', priority = '" . (int)$room_discount['priority'] . "', price = '" . (float)$room_discount['price'] . "', date_start = '" . $this->db->escape($room_discount['date_start']) . "', date_end = '" . $this->db->escape($room_discount['date_end']) . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "room_special WHERE room_id = '" . (int)$room_id . "'");

		if (isset($data['room_special'])) {
			foreach ($data['room_special'] as $room_special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "room_special SET room_id = '" . (int)$room_id . "', customer_group_id = '" . (int)$room_special['customer_group_id'] . "', priority = '" . (int)$room_special['priority'] . "', price = '" . (float)$room_special['price'] . "', date_start = '" . $this->db->escape($room_special['date_start']) . "', date_end = '" . $this->db->escape($room_special['date_end']) . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "room_image WHERE room_id = '" . (int)$room_id . "'");

		if (isset($data['room_image'])) {
			foreach ($data['room_image'] as $room_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "room_image SET room_id = '" . (int)$room_id . "', image = '" . $this->db->escape($room_image['image']) . "', sort_order = '" . (int)$room_image['sort_order'] . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "room_to_download WHERE room_id = '" . (int)$room_id . "'");

		if (isset($data['room_download'])) {
			foreach ($data['room_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "room_to_download SET room_id = '" . (int)$room_id . "', download_id = '" . (int)$download_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "room_to_hotel WHERE room_id = '" . (int)$room_id . "'");

		if (isset($data['room_hotel'])) {
			foreach ($data['room_hotel'] as $hotel_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "room_to_hotel SET room_id = '" . (int)$room_id . "', hotel_id = '" . (int)$hotel_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "room_filter WHERE room_id = '" . (int)$room_id . "'");

		if (isset($data['room_filter'])) {
			foreach ($data['room_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "room_filter SET room_id = '" . (int)$room_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "room_related WHERE room_id = '" . (int)$room_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "room_related WHERE related_id = '" . (int)$room_id . "'");

		if (isset($data['room_related'])) {
			foreach ($data['room_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "room_related WHERE room_id = '" . (int)$room_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "room_related SET room_id = '" . (int)$room_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "room_related WHERE room_id = '" . (int)$related_id . "' AND related_id = '" . (int)$room_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "room_related SET room_id = '" . (int)$related_id . "', related_id = '" . (int)$room_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "room_reward WHERE room_id = '" . (int)$room_id . "'");

		if (isset($data['room_reward'])) {
			foreach ($data['room_reward'] as $customer_group_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "room_reward SET room_id = '" . (int)$room_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$value['points'] . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "room_to_layout WHERE room_id = '" . (int)$room_id . "'");

		if (isset($data['room_layout'])) {
			foreach ($data['room_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "room_to_layout SET room_id = '" . (int)$room_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'room_id=" . (int)$room_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'room_id=" . (int)$room_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->db->query("DELETE FROM `" . DB_PREFIX . "room_recurring` WHERE room_id = " . (int)$room_id);

		if (isset($data['room_recurrings'])) {
			foreach ($data['room_recurrings'] as $recurring) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "room_recurring` SET `room_id` = " . (int)$room_id . ", customer_group_id = " . (int)$recurring['customer_group_id'] . ", `recurring_id` = " . (int)$recurring['recurring_id']);
			}
		}

		$this->cache->delete('room');

		$this->event->trigger('post.admin.room.edit', $room_id);
	}

	public function copyRoom($room_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "room p LEFT JOIN " . DB_PREFIX . "room_description pd ON (p.room_id = pd.room_id) WHERE p.room_id = '" . (int)$room_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		if ($query->num_rows) {
			$data = array();

			$data = $query->row;

			$data['sku'] = '';
			$data['upc'] = '';
			$data['viewed'] = '0';
			$data['keyword'] = '';
			$data['status'] = '0';

			$data = array_merge($data, array('room_attribute' => $this->getRoomAttributes($room_id)));
			$data = array_merge($data, array('room_price' => $this->getRoomPrices($room_id)));
			$data = array_merge($data, array('room_description' => $this->getRoomDescriptions($room_id)));
			$data = array_merge($data, array('room_discount' => $this->getRoomDiscounts($room_id)));
			$data = array_merge($data, array('room_filter' => $this->getRoomFilters($room_id)));
			$data = array_merge($data, array('room_image' => $this->getRoomImages($room_id)));
			$data = array_merge($data, array('room_option' => $this->getRoomOptions($room_id)));
			$data = array_merge($data, array('room_related' => $this->getRoomRelated($room_id)));
			$data = array_merge($data, array('room_reward' => $this->getRoomRewards($room_id)));
			$data = array_merge($data, array('room_special' => $this->getRoomSpecials($room_id)));
			$data = array_merge($data, array('room_hotel' => $this->getProductHotels($room_id)));
			$data = array_merge($data, array('room_download' => $this->getRoomDownloads($room_id)));
			$data = array_merge($data, array('room_layout' => $this->getRoomLayouts($room_id)));
			$data = array_merge($data, array('room_store' => $this->getRoomStores($room_id)));
			$data = array_merge($data, array('room_recurrings' => $this->getRecurrings($room_id)));

			$this->addRoom($data);
		}
	}

	public function deleteRoom($room_id) {
		$this->event->trigger('pre.admin.room.delete', $room_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "room WHERE room_id = '" . (int)$room_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "room_attribute WHERE room_id = '" . (int)$room_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "room_price WHERE room_id = '" . (int)$room_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "room_description WHERE room_id = '" . (int)$room_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "room_discount WHERE room_id = '" . (int)$room_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "room_filter WHERE room_id = '" . (int)$room_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "room_image WHERE room_id = '" . (int)$room_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "room_option WHERE room_id = '" . (int)$room_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "room_option_value WHERE room_id = '" . (int)$room_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "room_related WHERE room_id = '" . (int)$room_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "room_related WHERE related_id = '" . (int)$room_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "room_reward WHERE room_id = '" . (int)$room_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "room_special WHERE room_id = '" . (int)$room_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "room_to_hotel WHERE room_id = '" . (int)$room_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "room_to_download WHERE room_id = '" . (int)$room_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "room_to_layout WHERE room_id = '" . (int)$room_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "room_to_store WHERE room_id = '" . (int)$room_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE room_id = '" . (int)$room_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "room_recurring WHERE room_id = " . (int)$room_id);
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'room_id=" . (int)$room_id . "'");

		$this->cache->delete('room');

		$this->event->trigger('post.admin.room.delete', $room_id);
	}

	public function getRoom($room_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'room_id=" . (int)$room_id . "') AS keyword FROM " . DB_PREFIX . "room p LEFT JOIN " . DB_PREFIX . "room_description pd ON (p.room_id = pd.room_id) WHERE p.room_id = '" . (int)$room_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getRooms($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "room p LEFT JOIN " . DB_PREFIX . "room_description pd ON (p.room_id = pd.room_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

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

		if (isset($data['filter_maxadults']) && !is_null($data['filter_maxadults'])) {
			$sql .= " AND p.maxadults = '" . (int)$data['filter_maxadults'] . "'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}
		
		if (isset($data['filter_user_id']) && !is_null($data['filter_user_id']) && $data['filter_user_id'] != 1) {
			$sql .= " AND p.author_id = '" . (int)$data['filter_user_id'] . "'";
		}
		
		$sql .= " GROUP BY p.room_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'p.price',
			'p.quantity',
			'p.maxadults',
			'p.status',
			'p.sort_order',
                        'p.author_id'
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

	public function getRoomsByCategoryId($hotel_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "room p LEFT JOIN " . DB_PREFIX . "room_description pd ON (p.room_id = pd.room_id) LEFT JOIN " . DB_PREFIX . "room_to_hotel p2c ON (p.room_id = p2c.room_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.hotel_id = '" . (int)$hotel_id . "' ORDER BY pd.name ASC");

		return $query->rows;
	}

	public function getRoomDescriptions($room_id) {
		$room_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "room_description WHERE room_id = '" . (int)$room_id . "'");

		foreach ($query->rows as $result) {
			$room_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'tag'              => $result['tag']
			);
		}

		return $room_description_data;
	}

	public function getProductHotels($room_id) {
		$room_hotel_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "room_to_hotel WHERE room_id = '" . (int)$room_id . "'");

		foreach ($query->rows as $result) {
			$room_hotel_data[] = $result['hotel_id'];
		}

		return $room_hotel_data;
	}

	public function getRoomFilters($room_id) {
		$room_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "room_filter WHERE room_id = '" . (int)$room_id . "'");

		foreach ($query->rows as $result) {
			$room_filter_data[] = $result['filter_id'];
		}

		return $room_filter_data;
	}

	public function getRoomAttributes($room_id) {
		$room_attribute_data = array();

		$room_attribute_query = $this->db->query("SELECT attribute_id FROM " . DB_PREFIX . "room_attribute WHERE room_id = '" . (int)$room_id . "' GROUP BY attribute_id");

		foreach ($room_attribute_query->rows as $room_attribute) {
			$room_attribute_description_data = array();

			$room_attribute_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "room_attribute WHERE room_id = '" . (int)$room_id . "' AND attribute_id = '" . (int)$room_attribute['attribute_id'] . "'");

			foreach ($room_attribute_description_query->rows as $room_attribute_description) {
				$room_attribute_description_data[$room_attribute_description['language_id']] = array('text' => $room_attribute_description['text']);
			}

			$room_attribute_data[] = array(
				'attribute_id'                  => $room_attribute['attribute_id'],
				'room_attribute_description' => $room_attribute_description_data
			);
		}

		return $room_attribute_data;
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

	public function getRoomOptions($room_id) {
		$room_option_data = array();

		$room_option_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "room_option` po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN `" . DB_PREFIX . "option_description` od ON (o.option_id = od.option_id) WHERE po.room_id = '" . (int)$room_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		foreach ($room_option_query->rows as $room_option) {
			$room_option_value_data = array();

			$room_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "room_option_value WHERE room_option_id = '" . (int)$room_option['room_option_id'] . "'");

			foreach ($room_option_value_query->rows as $room_option_value) {
				$room_option_value_data[] = array(
					'room_option_value_id' => $room_option_value['room_option_value_id'],
					'option_value_id'         => $room_option_value['option_value_id'],
					'quantity'                => $room_option_value['quantity'],
					'maxadults'               => $room_option_value['maxadults'],
					'subtract'                => $room_option_value['subtract'],
					'price'                   => $room_option_value['price'],
					'price_prefix'            => $room_option_value['price_prefix'],
					'points'                  => $room_option_value['points'],
					'points_prefix'           => $room_option_value['points_prefix'],
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

	public function getRoomImages($room_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "room_image WHERE room_id = '" . (int)$room_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getRoomDiscounts($room_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "room_discount WHERE room_id = '" . (int)$room_id . "' ORDER BY quantity, priority, price");

		return $query->rows;
	}

	public function getRoomSpecials($room_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "room_special WHERE room_id = '" . (int)$room_id . "' ORDER BY priority, price");

		return $query->rows;
	}

	public function getRoomRewards($room_id) {
		$room_reward_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "room_reward WHERE room_id = '" . (int)$room_id . "'");

		foreach ($query->rows as $result) {
			$room_reward_data[$result['customer_group_id']] = array('points' => $result['points']);
		}

		return $room_reward_data;
	}

	public function getRoomDownloads($room_id) {
		$room_download_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "room_to_download WHERE room_id = '" . (int)$room_id . "'");

		foreach ($query->rows as $result) {
			$room_download_data[] = $result['download_id'];
		}

		return $room_download_data;
	}

	public function getRoomStores($room_id) {
		$room_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "room_to_store WHERE room_id = '" . (int)$room_id . "'");

		foreach ($query->rows as $result) {
			$room_store_data[] = $result['store_id'];
		}

		return $room_store_data;
	}

	public function getRoomLayouts($room_id) {
		$room_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "room_to_layout WHERE room_id = '" . (int)$room_id . "'");

		foreach ($query->rows as $result) {
			$room_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $room_layout_data;
	}

	public function getRoomRelated($room_id) {
		$room_related_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "room_related WHERE room_id = '" . (int)$room_id . "'");

		foreach ($query->rows as $result) {
			$room_related_data[] = $result['related_id'];
		}

		return $room_related_data;
	}

	public function getRecurrings($room_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "room_recurring` WHERE room_id = '" . (int)$room_id . "'");

		return $query->rows;
	}

	public function getTotalRooms($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.room_id) AS total FROM " . DB_PREFIX . "room p LEFT JOIN " . DB_PREFIX . "room_description pd ON (p.room_id = pd.room_id)";

		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
              
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

		if (isset($data['filter_maxadults']) && !is_null($data['filter_maxadults'])) {
			$sql .= " AND p.maxadults = '" . (int)$data['filter_maxadults'] . "'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		if (isset($data['filter_user_id']) && !is_null($data['filter_user_id']) && $data['filter_user_id'] != 1) {
			$sql .= " AND p.author_id = '" . (int)$data['filter_user_id'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalRoomsByTaxClassId($tax_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "room WHERE tax_class_id = '" . (int)$tax_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalRoomsByStockStatusId($stock_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "room WHERE stock_status_id = '" . (int)$stock_status_id . "'");

		return $query->row['total'];
	}

	public function getTotalRoomsByWeightClassId($weight_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "room WHERE weight_class_id = '" . (int)$weight_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalRoomsByLengthClassId($length_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "room WHERE length_class_id = '" . (int)$length_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalRoomsByDownloadId($download_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "room_to_download WHERE download_id = '" . (int)$download_id . "'");

		return $query->row['total'];
	}

	public function getTotalRoomsByManufacturerId($manufacturer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "room WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		return $query->row['total'];
	}

	public function getTotalRoomsByAttributeId($attribute_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "room_attribute WHERE attribute_id = '" . (int)$attribute_id . "'");

		return $query->row['total'];
	}
        
	public function getTotalRoomsByPriceId($price_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "room_price WHERE price_id = '" . (int)$price_id . "'");

		return $query->row['total'];
	}

	public function getTotalRoomsByOptionId($option_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "room_option WHERE option_id = '" . (int)$option_id . "'");

		return $query->row['total'];
	}

	public function getTotalRoomsByProfileId($recurring_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "room_recurring WHERE recurring_id = '" . (int)$recurring_id . "'");

		return $query->row['total'];
	}

	public function getTotalRoomsByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "room_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
}