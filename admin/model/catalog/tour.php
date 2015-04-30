<?php
class ModelCatalogTour extends Model {
	public function addTour($data) {
		$this->event->trigger('pre.admin.tour.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "tour SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', ean = '" . $this->db->escape($data['ean']) . "', jan = '" . $this->db->escape($data['jan']) . "', isbn = '" . $this->db->escape($data['isbn']) . "', mpn = '" . $this->db->escape($data['mpn']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', author_id = '" . (int)$data['author_id'] . "', minimum = '" . (int)$data['minimum'] . "', subtract = '" . (int)$data['subtract'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', points = '" . (int)$data['points'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . $this->db->escape($data['tax_class_id']) . "', sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW()");

		$tour_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "tour SET image = '" . $this->db->escape($data['image']) . "' WHERE tour_id = '" . (int)$tour_id . "'");
		}

		foreach ($data['tour_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "tour_description SET tour_id = '" . (int)$tour_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) ."', info = '" . $this->db->escape($value['info']) . "', detail = '" . $this->db->escape($value['detail']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		if (isset($data['tour_store'])) {
			foreach ($data['tour_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "tour_to_store SET tour_id = '" . (int)$tour_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['tour_attribute'])) {
			foreach ($data['tour_attribute'] as $tour_attribute) {
				if ($tour_attribute['attribute_id']) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "tour_attribute WHERE tour_id = '" . (int)$tour_id . "' AND attribute_id = '" . (int)$tour_attribute['attribute_id'] . "'");

					foreach ($tour_attribute['tour_attribute_description'] as $language_id => $tour_attribute_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "tour_attribute SET tour_id = '" . (int)$tour_id . "', attribute_id = '" . (int)$tour_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($tour_attribute_description['text']) . "'");
					}
				}
			}
		}
                
		if (isset($data['tour_price'])) {
			foreach ($data['tour_price'] as $tour_price) {
				  
                                $tour_price_gross = $this->db->escape($tour_price['tour_price_net']) + (($this->db->escape($tour_price['tour_price_net'])/100) * $this->db->escape($tour_price['tour_price_percent']));
                
                                $tour_extra_gross = $this->db->escape($tour_price['tour_extra_net']) + (($this->db->escape($tour_price['tour_extra_net'])/100) * $this->db->escape($tour_price['tour_extra_percent']));

				$this->db->query("DELETE FROM " . DB_PREFIX . "tour_price WHERE tour_id = '" . (int)$tour_id . "' AND price_id = '" . (int)$tour_price['price_id'] . "'");

				$this->db->query("INSERT INTO " . DB_PREFIX . "tour_price SET tour_id = '" . (int)$tour_id . "', price_id = '" . (int)$tour_price['price_id'] . "', date_form = '" . $tour_price['tour_date']['1']['date'] . "', date_to = '" . $tour_price['tour_date']['2']['date'] . "', price_net = '" .  $this->db->escape($tour_price['tour_price_net']) . "', price_percent = '" .  $this->db->escape($tour_price['tour_price_percent']) . "', price_gross = '" .  $tour_price_gross . "', extra_net = '" .  $this->db->escape($tour_price['tour_extra_net']) . "', extra_percent = '" .  $this->db->escape($tour_price['tour_extra_percent']) . "', extra_gross = '" .  $tour_extra_gross . "', discount = '" .  $this->db->escape($tour_price['tour_price_discount']) . "'");
				
			}
		}

		if (isset($data['tour_option'])) {
			foreach ($data['tour_option'] as $tour_option) {
				if ($tour_option['type'] == 'select' || $tour_option['type'] == 'radio' || $tour_option['type'] == 'checkbox' || $tour_option['type'] == 'image') {
					if (isset($tour_option['tour_option_value'])) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "tour_option SET tour_id = '" . (int)$tour_id . "', option_id = '" . (int)$tour_option['option_id'] . "', required = '" . (int)$tour_option['required'] . "'");

						$tour_option_id = $this->db->getLastId();

						foreach ($tour_option['tour_option_value'] as $tour_option_value) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "tour_option_value SET tour_option_id = '" . (int)$tour_option_id . "', tour_id = '" . (int)$tour_id . "', option_id = '" . (int)$tour_option['option_id'] . "', option_value_id = '" . (int)$tour_option_value['option_value_id'] . "', quantity = '" . (int)$tour_option_value['quantity'] . "', subtract = '" . (int)$tour_option_value['subtract'] . "', price = '" . (float)$tour_option_value['price'] . "', price_prefix = '" . $this->db->escape($tour_option_value['price_prefix']) . "', points = '" . (int)$tour_option_value['points'] . "', points_prefix = '" . $this->db->escape($tour_option_value['points_prefix']) . "', weight = '" . (float)$tour_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($tour_option_value['weight_prefix']) . "'");
						}
					}
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "tour_option SET tour_id = '" . (int)$tour_id . "', option_id = '" . (int)$tour_option['option_id'] . "', value = '" . $this->db->escape($tour_option['value']) . "', required = '" . (int)$tour_option['required'] . "'");
				}
			}
		}

		if (isset($data['tour_discount'])) {
			foreach ($data['tour_discount'] as $tour_discount) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "tour_discount SET tour_id = '" . (int)$tour_id . "', customer_group_id = '" . (int)$tour_discount['customer_group_id'] . "', quantity = '" . (int)$tour_discount['quantity'] . "', priority = '" . (int)$tour_discount['priority'] . "', price = '" . (float)$tour_discount['price'] . "', date_start = '" . $this->db->escape($tour_discount['date_start']) . "', date_end = '" . $this->db->escape($tour_discount['date_end']) . "'");
			}
		}

		if (isset($data['tour_special'])) {
			foreach ($data['tour_special'] as $tour_special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "tour_special SET tour_id = '" . (int)$tour_id . "', customer_group_id = '" . (int)$tour_special['customer_group_id'] . "', priority = '" . (int)$tour_special['priority'] . "', price = '" . (float)$tour_special['price'] . "', date_start = '" . $this->db->escape($tour_special['date_start']) . "', date_end = '" . $this->db->escape($tour_special['date_end']) . "'");
			}
		}

		if (isset($data['tour_image'])) {
			foreach ($data['tour_image'] as $tour_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "tour_image SET tour_id = '" . (int)$tour_id . "', image = '" . $this->db->escape($tour_image['image']) . "', sort_order = '" . (int)$tour_image['sort_order'] . "'");
			}
		}

		if (isset($data['tour_download'])) {
			foreach ($data['tour_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "tour_to_download SET tour_id = '" . (int)$tour_id . "', download_id = '" . (int)$download_id . "'");
			}
		}

		if (isset($data['tour_hotel'])) {
			foreach ($data['tour_hotel'] as $hotel_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "tour_to_hotel SET tour_id = '" . (int)$tour_id . "', hotel_id = '" . (int)$hotel_id . "'");
			}
		}

		if (isset($data['tour_filter'])) {
			foreach ($data['tour_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "tour_filter SET tour_id = '" . (int)$tour_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['tour_related'])) {
			foreach ($data['tour_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "tour_related WHERE tour_id = '" . (int)$tour_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "tour_related SET tour_id = '" . (int)$tour_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "tour_related WHERE tour_id = '" . (int)$related_id . "' AND related_id = '" . (int)$tour_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "tour_related SET tour_id = '" . (int)$related_id . "', related_id = '" . (int)$tour_id . "'");
			}
		}

		if (isset($data['tour_reward'])) {
			foreach ($data['tour_reward'] as $customer_group_id => $tour_reward) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "tour_reward SET tour_id = '" . (int)$tour_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$tour_reward['points'] . "'");
			}
		}

		if (isset($data['tour_layout'])) {
			foreach ($data['tour_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "tour_to_layout SET tour_id = '" . (int)$tour_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'tour_id=" . (int)$tour_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		if (isset($data['tour_recurrings'])) {
			foreach ($data['tour_recurrings'] as $recurring) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "tour_recurring` SET `tour_id` = " . (int)$tour_id . ", customer_group_id = " . (int)$recurring['customer_group_id'] . ", `recurring_id` = " . (int)$recurring['recurring_id']);
			}
		}

		$this->cache->delete('tour');

		$this->event->trigger('post.admin.tour.add', $tour_id);

		return $tour_id;
	}

	public function editTour($tour_id, $data) {
		$this->event->trigger('pre.admin.tour.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "tour SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', ean = '" . $this->db->escape($data['ean']) . "', jan = '" . $this->db->escape($data['jan']) . "', isbn = '" . $this->db->escape($data['isbn']) . "', mpn = '" . $this->db->escape($data['mpn']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', minimum = '" . (int)$data['minimum'] . "', subtract = '" . (int)$data['subtract'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', points = '" . (int)$data['points'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . $this->db->escape($data['tax_class_id']) . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE tour_id = '" . (int)$tour_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "tour SET image = '" . $this->db->escape($data['image']) . "' WHERE tour_id = '" . (int)$tour_id ."'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_description WHERE tour_id = '" . (int)$tour_id . "'");

		foreach ($data['tour_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "tour_description SET tour_id = '" . (int)$tour_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', info = '" . $this->db->escape($value['info']) . "', detail = '" . $this->db->escape($value['detail']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_to_store WHERE tour_id = '" . (int)$tour_id . "'");

		if (isset($data['tour_store'])) {
			foreach ($data['tour_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "tour_to_store SET tour_id = '" . (int)$tour_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_attribute WHERE tour_id = '" . (int)$tour_id . "'");

		if (!empty($data['tour_attribute'])) {
			foreach ($data['tour_attribute'] as $tour_attribute) {
				if ($tour_attribute['attribute_id']) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "tour_attribute WHERE tour_id = '" . (int)$tour_id . "' AND attribute_id = '" . (int)$tour_attribute['attribute_id'] . "'");

					foreach ($tour_attribute['tour_attribute_description'] as $language_id => $tour_attribute_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "tour_attribute SET tour_id = '" . (int)$tour_id . "', attribute_id = '" . (int)$tour_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($tour_attribute_description['text']) . "'");
					}
				}
			}
		}
                
		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_price WHERE tour_id = '" . (int)$tour_id . "'");

		if (!empty($data['tour_price'])) {
			foreach ($data['tour_price'] as $tour_price) {
					
                                $tour_price_gross = $this->db->escape($tour_price['tour_price_net']) + (($this->db->escape($tour_price['tour_price_net'])/100) * $this->db->escape($tour_price['tour_price_percent']));
                
                                $tour_extra_gross = $this->db->escape($tour_price['tour_extra_net']) + (($this->db->escape($tour_price['tour_extra_net'])/100) * $this->db->escape($tour_price['tour_extra_percent']));

				$this->db->query("DELETE FROM " . DB_PREFIX . "tour_price WHERE tour_id = '" . (int)$tour_id . "' AND price_id = '" . (int)$tour_price['price_id'] . "'");

				$this->db->query("INSERT INTO " . DB_PREFIX . "tour_price SET tour_id = '" . (int)$tour_id . "', price_id = '" . (int)$tour_price['price_id'] . "', date_form = '" . $tour_price['tour_date']['1']['date'] . "', date_to = '" . $tour_price['tour_date']['2']['date'] . "', price_net = '" .  $this->db->escape($tour_price['tour_price_net']) . "', price_percent = '" .  $this->db->escape($tour_price['tour_price_percent']) . "', price_gross = '" .  $tour_price_gross . "', extra_net = '" .  $this->db->escape($tour_price['tour_extra_net']) . "', extra_percent = '" .  $this->db->escape($tour_price['tour_extra_percent']) . "', extra_gross = '" .  $tour_extra_gross . "', discount = '" .  $this->db->escape($tour_price['tour_price_discount']) . "'");
				
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_option WHERE tour_id = '" . (int)$tour_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_option_value WHERE tour_id = '" . (int)$tour_id . "'");

		if (isset($data['tour_option'])) {
			foreach ($data['tour_option'] as $tour_option) {
				if ($tour_option['type'] == 'select' || $tour_option['type'] == 'radio' || $tour_option['type'] == 'checkbox' || $tour_option['type'] == 'image') {
					if (isset($tour_option['tour_option_value'])) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "tour_option SET tour_option_id = '" . (int)$tour_option['tour_option_id'] . "', tour_id = '" . (int)$tour_id . "', option_id = '" . (int)$tour_option['option_id'] . "', required = '" . (int)$tour_option['required'] . "'");

						$tour_option_id = $this->db->getLastId();

						foreach ($tour_option['tour_option_value'] as $tour_option_value) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "tour_option_value SET tour_option_value_id = '" . (int)$tour_option_value['tour_option_value_id'] . "', tour_option_id = '" . (int)$tour_option_id . "', tour_id = '" . (int)$tour_id . "', option_id = '" . (int)$tour_option['option_id'] . "', option_value_id = '" . (int)$tour_option_value['option_value_id'] . "', quantity = '" . (int)$tour_option_value['quantity'] . "', subtract = '" . (int)$tour_option_value['subtract'] . "', price = '" . (float)$tour_option_value['price'] . "', price_prefix = '" . $this->db->escape($tour_option_value['price_prefix']) . "', points = '" . (int)$tour_option_value['points'] . "', points_prefix = '" . $this->db->escape($tour_option_value['points_prefix']) . "', weight = '" . (float)$tour_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($tour_option_value['weight_prefix']) . "'");
						}
					}
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "tour_option SET tour_option_id = '" . (int)$tour_option['tour_option_id'] . "', tour_id = '" . (int)$tour_id . "', option_id = '" . (int)$tour_option['option_id'] . "', value = '" . $this->db->escape($tour_option['value']) . "', required = '" . (int)$tour_option['required'] . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_discount WHERE tour_id = '" . (int)$tour_id . "'");

		if (isset($data['tour_discount'])) {
			foreach ($data['tour_discount'] as $tour_discount) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "tour_discount SET tour_id = '" . (int)$tour_id . "', customer_group_id = '" . (int)$tour_discount['customer_group_id'] . "', quantity = '" . (int)$tour_discount['quantity'] . "', priority = '" . (int)$tour_discount['priority'] . "', price = '" . (float)$tour_discount['price'] . "', date_start = '" . $this->db->escape($tour_discount['date_start']) . "', date_end = '" . $this->db->escape($tour_discount['date_end']) . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_special WHERE tour_id = '" . (int)$tour_id . "'");

		if (isset($data['tour_special'])) {
			foreach ($data['tour_special'] as $tour_special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "tour_special SET tour_id = '" . (int)$tour_id . "', customer_group_id = '" . (int)$tour_special['customer_group_id'] . "', priority = '" . (int)$tour_special['priority'] . "', price = '" . (float)$tour_special['price'] . "', date_start = '" . $this->db->escape($tour_special['date_start']) . "', date_end = '" . $this->db->escape($tour_special['date_end']) . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_image WHERE tour_id = '" . (int)$tour_id . "'");

		if (isset($data['tour_image'])) {
			foreach ($data['tour_image'] as $tour_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "tour_image SET tour_id = '" . (int)$tour_id . "', image = '" . $this->db->escape($tour_image['image']) . "', sort_order = '" . (int)$tour_image['sort_order'] . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_to_download WHERE tour_id = '" . (int)$tour_id . "'");

		if (isset($data['tour_download'])) {
			foreach ($data['tour_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "tour_to_download SET tour_id = '" . (int)$tour_id . "', download_id = '" . (int)$download_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_to_hotel WHERE tour_id = '" . (int)$tour_id . "'");

		if (isset($data['tour_hotel'])) {
			foreach ($data['tour_hotel'] as $hotel_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "tour_to_hotel SET tour_id = '" . (int)$tour_id . "', hotel_id = '" . (int)$hotel_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_filter WHERE tour_id = '" . (int)$tour_id . "'");

		if (isset($data['tour_filter'])) {
			foreach ($data['tour_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "tour_filter SET tour_id = '" . (int)$tour_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_related WHERE tour_id = '" . (int)$tour_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_related WHERE related_id = '" . (int)$tour_id . "'");

		if (isset($data['tour_related'])) {
			foreach ($data['tour_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "tour_related WHERE tour_id = '" . (int)$tour_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "tour_related SET tour_id = '" . (int)$tour_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "tour_related WHERE tour_id = '" . (int)$related_id . "' AND related_id = '" . (int)$tour_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "tour_related SET tour_id = '" . (int)$related_id . "', related_id = '" . (int)$tour_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_reward WHERE tour_id = '" . (int)$tour_id . "'");

		if (isset($data['tour_reward'])) {
			foreach ($data['tour_reward'] as $customer_group_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "tour_reward SET tour_id = '" . (int)$tour_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$value['points'] . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_to_layout WHERE tour_id = '" . (int)$tour_id . "'");

		if (isset($data['tour_layout'])) {
			foreach ($data['tour_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "tour_to_layout SET tour_id = '" . (int)$tour_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'tour_id=" . (int)$tour_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'tour_id=" . (int)$tour_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->db->query("DELETE FROM `" . DB_PREFIX . "tour_recurring` WHERE tour_id = " . (int)$tour_id);

		if (isset($data['tour_recurrings'])) {
			foreach ($data['tour_recurrings'] as $recurring) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "tour_recurring` SET `tour_id` = " . (int)$tour_id . ", customer_group_id = " . (int)$recurring['customer_group_id'] . ", `recurring_id` = " . (int)$recurring['recurring_id']);
			}
		}

		$this->cache->delete('tour');

		$this->event->trigger('post.admin.tour.edit', $tour_id);
	}

	public function copyTour($tour_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "tour p LEFT JOIN " . DB_PREFIX . "tour_description pd ON (p.tour_id = pd.tour_id) WHERE p.tour_id = '" . (int)$tour_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		if ($query->num_rows) {
			$data = array();

			$data = $query->row;

			$data['sku'] = '';
			$data['upc'] = '';
			$data['viewed'] = '0';
			$data['keyword'] = '';
			$data['status'] = '0';

			$data = array_merge($data, array('tour_attribute' => $this->getTourAttributes($tour_id)));
			$data = array_merge($data, array('tour_price' => $this->getTourPrices($tour_id)));
			$data = array_merge($data, array('tour_description' => $this->getTourDescriptions($tour_id)));
			$data = array_merge($data, array('tour_discount' => $this->getTourDiscounts($tour_id)));
			$data = array_merge($data, array('tour_filter' => $this->getTourFilters($tour_id)));
			$data = array_merge($data, array('tour_image' => $this->getTourImages($tour_id)));
			$data = array_merge($data, array('tour_option' => $this->getTourOptions($tour_id)));
			$data = array_merge($data, array('tour_related' => $this->getTourRelated($tour_id)));
			$data = array_merge($data, array('tour_reward' => $this->getTourRewards($tour_id)));
			$data = array_merge($data, array('tour_special' => $this->getTourSpecials($tour_id)));
			$data = array_merge($data, array('tour_hotel' => $this->getProductHotels($tour_id)));
			$data = array_merge($data, array('tour_download' => $this->getTourDownloads($tour_id)));
			$data = array_merge($data, array('tour_layout' => $this->getTourLayouts($tour_id)));
			$data = array_merge($data, array('tour_store' => $this->getTourStores($tour_id)));
			$data = array_merge($data, array('tour_recurrings' => $this->getRecurrings($tour_id)));

			$this->addTour($data);
		}
	}

	public function deleteTour($tour_id) {
		$this->event->trigger('pre.admin.tour.delete', $tour_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "tour WHERE tour_id = '" . (int)$tour_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_attribute WHERE tour_id = '" . (int)$tour_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_price WHERE tour_id = '" . (int)$tour_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_description WHERE tour_id = '" . (int)$tour_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_discount WHERE tour_id = '" . (int)$tour_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_filter WHERE tour_id = '" . (int)$tour_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_image WHERE tour_id = '" . (int)$tour_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_option WHERE tour_id = '" . (int)$tour_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_option_value WHERE tour_id = '" . (int)$tour_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_related WHERE tour_id = '" . (int)$tour_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_related WHERE related_id = '" . (int)$tour_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_reward WHERE tour_id = '" . (int)$tour_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_special WHERE tour_id = '" . (int)$tour_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_to_hotel WHERE tour_id = '" . (int)$tour_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_to_download WHERE tour_id = '" . (int)$tour_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_to_layout WHERE tour_id = '" . (int)$tour_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_to_store WHERE tour_id = '" . (int)$tour_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE tour_id = '" . (int)$tour_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "tour_recurring WHERE tour_id = " . (int)$tour_id);
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'tour_id=" . (int)$tour_id . "'");

		$this->cache->delete('tour');

		$this->event->trigger('post.admin.tour.delete', $tour_id);
	}

	public function getTour($tour_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'tour_id=" . (int)$tour_id . "') AS keyword FROM " . DB_PREFIX . "tour p LEFT JOIN " . DB_PREFIX . "tour_description pd ON (p.tour_id = pd.tour_id) WHERE p.tour_id = '" . (int)$tour_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getTours($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "tour p LEFT JOIN " . DB_PREFIX . "tour_description pd ON (p.tour_id = pd.tour_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

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
		
		if (isset($data['filter_user_id']) && !is_null($data['filter_user_id']) && $data['filter_user_id'] != 1) {
			$sql .= " AND p.author_id = '" . (int)$data['filter_user_id'] . "'";
		}
		
		$sql .= " GROUP BY p.tour_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'p.price',
			'p.quantity',
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

	public function getToursByCategoryId($hotel_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tour p LEFT JOIN " . DB_PREFIX . "tour_description pd ON (p.tour_id = pd.tour_id) LEFT JOIN " . DB_PREFIX . "tour_to_hotel p2c ON (p.tour_id = p2c.tour_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.hotel_id = '" . (int)$hotel_id . "' ORDER BY pd.name ASC");

		return $query->rows;
	}

	public function getTourDescriptions($tour_id) {
		$tour_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tour_description WHERE tour_id = '" . (int)$tour_id . "'");

		foreach ($query->rows as $result) {
			$tour_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'tag'              => $result['tag']
			);
		}

		return $tour_description_data;
	}

	public function getProductHotels($tour_id) {
		$tour_hotel_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tour_to_hotel WHERE tour_id = '" . (int)$tour_id . "'");

		foreach ($query->rows as $result) {
			$tour_hotel_data[] = $result['hotel_id'];
		}

		return $tour_hotel_data;
	}

	public function getTourFilters($tour_id) {
		$tour_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tour_filter WHERE tour_id = '" . (int)$tour_id . "'");

		foreach ($query->rows as $result) {
			$tour_filter_data[] = $result['filter_id'];
		}

		return $tour_filter_data;
	}

	public function getTourAttributes($tour_id) {
		$tour_attribute_data = array();

		$tour_attribute_query = $this->db->query("SELECT attribute_id FROM " . DB_PREFIX . "tour_attribute WHERE tour_id = '" . (int)$tour_id . "' GROUP BY attribute_id");

		foreach ($tour_attribute_query->rows as $tour_attribute) {
			$tour_attribute_description_data = array();

			$tour_attribute_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tour_attribute WHERE tour_id = '" . (int)$tour_id . "' AND attribute_id = '" . (int)$tour_attribute['attribute_id'] . "'");

			foreach ($tour_attribute_description_query->rows as $tour_attribute_description) {
				$tour_attribute_description_data[$tour_attribute_description['language_id']] = array('text' => $tour_attribute_description['text']);
			}

			$tour_attribute_data[] = array(
				'attribute_id'                  => $tour_attribute['attribute_id'],
				'tour_attribute_description' => $tour_attribute_description_data
			);
		}

		return $tour_attribute_data;
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
				'tour_price_net'         => $tour_date['price_net'],
				'tour_price_percent'     => $tour_date['price_percent'],
				'tour_price_gross'       => $tour_date['price_gross'],
				'tour_price_discount'    => $tour_date['discount'],
				'tour_extra_net'         => $tour_date['extra_net'],
				'tour_extra_percent'     => $tour_date['extra_percent'],
				'tour_extra_gross'       => $tour_date['extra_gross'],
				'tour_date'              => $tour_date_data
			);
		}

		return $tour_price_data;
	}

	public function getTourOptions($tour_id) {
		$tour_option_data = array();

		$tour_option_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "tour_option` po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN `" . DB_PREFIX . "option_description` od ON (o.option_id = od.option_id) WHERE po.tour_id = '" . (int)$tour_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		foreach ($tour_option_query->rows as $tour_option) {
			$tour_option_value_data = array();

			$tour_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tour_option_value WHERE tour_option_id = '" . (int)$tour_option['tour_option_id'] . "'");

			foreach ($tour_option_value_query->rows as $tour_option_value) {
				$tour_option_value_data[] = array(
					'tour_option_value_id' => $tour_option_value['tour_option_value_id'],
					'option_value_id'         => $tour_option_value['option_value_id'],
					'quantity'                => $tour_option_value['quantity'],
					'subtract'                => $tour_option_value['subtract'],
					'price'                   => $tour_option_value['price'],
					'price_prefix'            => $tour_option_value['price_prefix'],
					'points'                  => $tour_option_value['points'],
					'points_prefix'           => $tour_option_value['points_prefix'],
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

	public function getTourImages($tour_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tour_image WHERE tour_id = '" . (int)$tour_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getTourDiscounts($tour_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tour_discount WHERE tour_id = '" . (int)$tour_id . "' ORDER BY quantity, priority, price");

		return $query->rows;
	}

	public function getTourSpecials($tour_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tour_special WHERE tour_id = '" . (int)$tour_id . "' ORDER BY priority, price");

		return $query->rows;
	}

	public function getTourRewards($tour_id) {
		$tour_reward_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tour_reward WHERE tour_id = '" . (int)$tour_id . "'");

		foreach ($query->rows as $result) {
			$tour_reward_data[$result['customer_group_id']] = array('points' => $result['points']);
		}

		return $tour_reward_data;
	}

	public function getTourDownloads($tour_id) {
		$tour_download_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tour_to_download WHERE tour_id = '" . (int)$tour_id . "'");

		foreach ($query->rows as $result) {
			$tour_download_data[] = $result['download_id'];
		}

		return $tour_download_data;
	}

	public function getTourStores($tour_id) {
		$tour_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tour_to_store WHERE tour_id = '" . (int)$tour_id . "'");

		foreach ($query->rows as $result) {
			$tour_store_data[] = $result['store_id'];
		}

		return $tour_store_data;
	}

	public function getTourLayouts($tour_id) {
		$tour_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tour_to_layout WHERE tour_id = '" . (int)$tour_id . "'");

		foreach ($query->rows as $result) {
			$tour_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $tour_layout_data;
	}

	public function getTourRelated($tour_id) {
		$tour_related_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tour_related WHERE tour_id = '" . (int)$tour_id . "'");

		foreach ($query->rows as $result) {
			$tour_related_data[] = $result['related_id'];
		}

		return $tour_related_data;
	}

	public function getRecurrings($tour_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "tour_recurring` WHERE tour_id = '" . (int)$tour_id . "'");

		return $query->rows;
	}

	public function getTotalTours($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.tour_id) AS total FROM " . DB_PREFIX . "tour p LEFT JOIN " . DB_PREFIX . "tour_description pd ON (p.tour_id = pd.tour_id)";

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

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		if (isset($data['filter_user_id']) && !is_null($data['filter_user_id']) && $data['filter_user_id'] != 1) {
			$sql .= " AND p.author_id = '" . (int)$data['filter_user_id'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalToursByTaxClassId($tax_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "tour WHERE tax_class_id = '" . (int)$tax_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalToursByStockStatusId($stock_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "tour WHERE stock_status_id = '" . (int)$stock_status_id . "'");

		return $query->row['total'];
	}

	public function getTotalToursByWeightClassId($weight_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "tour WHERE weight_class_id = '" . (int)$weight_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalToursByLengthClassId($length_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "tour WHERE length_class_id = '" . (int)$length_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalToursByDownloadId($download_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "tour_to_download WHERE download_id = '" . (int)$download_id . "'");

		return $query->row['total'];
	}

	public function getTotalToursByManufacturerId($manufacturer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "tour WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		return $query->row['total'];
	}

	public function getTotalToursByAttributeId($attribute_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "tour_attribute WHERE attribute_id = '" . (int)$attribute_id . "'");

		return $query->row['total'];
	}
        
	public function getTotalToursByPriceId($price_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "tour_price WHERE price_id = '" . (int)$price_id . "'");

		return $query->row['total'];
	}

	public function getTotalToursByOptionId($option_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "tour_option WHERE option_id = '" . (int)$option_id . "'");

		return $query->row['total'];
	}

	public function getTotalToursByProfileId($recurring_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "tour_recurring WHERE recurring_id = '" . (int)$recurring_id . "'");

		return $query->row['total'];
	}

	public function getTotalToursByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "tour_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
}