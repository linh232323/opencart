<?php
class ModelCatalogProParent extends Model {
	public function addProparent($data) {
		$this->event->trigger('pre.admin.proparent.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "proparent SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', ean = '" . $this->db->escape($data['ean']) . "', jan = '" . $this->db->escape($data['jan']) . "', isbn = '" . $this->db->escape($data['isbn']) . "', mpn = '" . $this->db->escape($data['mpn']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', minimum = '" . (int)$data['minimum'] . "', subtract = '" . (int)$data['subtract'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', points = '" . (int)$data['points'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . $this->db->escape($data['tax_class_id']) . "', sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW()");

		$proparent_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "proparent SET image = '" . $this->db->escape($data['image']) . "' WHERE proparent_id = '" . (int)$proparent_id . "'");
		}

		foreach ($data['proparent_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_description SET proparent_id = '" . (int)$proparent_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		if (isset($data['proparent_store'])) {
			foreach ($data['proparent_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_to_store SET proparent_id = '" . (int)$proparent_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['proparent_attribute'])) {
			foreach ($data['proparent_attribute'] as $proparent_attribute) {
				if ($proparent_attribute['attribute_id']) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_attribute WHERE proparent_id = '" . (int)$proparent_id . "' AND attribute_id = '" . (int)$proparent_attribute['attribute_id'] . "'");

					foreach ($proparent_attribute['proparent_attribute_description'] as $language_id => $proparent_attribute_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_attribute SET proparent_id = '" . (int)$proparent_id . "', attribute_id = '" . (int)$proparent_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($proparent_attribute_description['text']) . "'");
					}
				}
			}
		}

		if (isset($data['proparent_option'])) {
			foreach ($data['proparent_option'] as $proparent_option) {
				if ($proparent_option['type'] == 'select' || $proparent_option['type'] == 'radio' || $proparent_option['type'] == 'checkbox' || $proparent_option['type'] == 'image') {
					if (isset($proparent_option['proparent_option_value'])) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_option SET proparent_id = '" . (int)$proparent_id . "', option_id = '" . (int)$proparent_option['option_id'] . "', required = '" . (int)$proparent_option['required'] . "'");

						$proparent_option_id = $this->db->getLastId();

						foreach ($proparent_option['proparent_option_value'] as $proparent_option_value) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_option_value SET proparent_option_id = '" . (int)$proparent_option_id . "', proparent_id = '" . (int)$proparent_id . "', option_id = '" . (int)$proparent_option['option_id'] . "', option_value_id = '" . (int)$proparent_option_value['option_value_id'] . "', quantity = '" . (int)$proparent_option_value['quantity'] . "', subtract = '" . (int)$proparent_option_value['subtract'] . "', price = '" . (float)$proparent_option_value['price'] . "', price_prefix = '" . $this->db->escape($proparent_option_value['price_prefix']) . "', points = '" . (int)$proparent_option_value['points'] . "', points_prefix = '" . $this->db->escape($proparent_option_value['points_prefix']) . "', weight = '" . (float)$proparent_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($proparent_option_value['weight_prefix']) . "'");
						}
					}
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_option SET proparent_id = '" . (int)$proparent_id . "', option_id = '" . (int)$proparent_option['option_id'] . "', value = '" . $this->db->escape($proparent_option['value']) . "', required = '" . (int)$proparent_option['required'] . "'");
				}
			}
		}

		if (isset($data['proparent_discount'])) {
			foreach ($data['proparent_discount'] as $proparent_discount) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_discount SET proparent_id = '" . (int)$proparent_id . "', customer_group_id = '" . (int)$proparent_discount['customer_group_id'] . "', quantity = '" . (int)$proparent_discount['quantity'] . "', priority = '" . (int)$proparent_discount['priority'] . "', price = '" . (float)$proparent_discount['price'] . "', date_start = '" . $this->db->escape($proparent_discount['date_start']) . "', date_end = '" . $this->db->escape($proparent_discount['date_end']) . "'");
			}
		}

		if (isset($data['proparent_special'])) {
			foreach ($data['proparent_special'] as $proparent_special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_special SET proparent_id = '" . (int)$proparent_id . "', customer_group_id = '" . (int)$proparent_special['customer_group_id'] . "', priority = '" . (int)$proparent_special['priority'] . "', price = '" . (float)$proparent_special['price'] . "', date_start = '" . $this->db->escape($proparent_special['date_start']) . "', date_end = '" . $this->db->escape($proparent_special['date_end']) . "'");
			}
		}

		if (isset($data['proparent_image'])) {
			foreach ($data['proparent_image'] as $proparent_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_image SET proparent_id = '" . (int)$proparent_id . "', image = '" . $this->db->escape($proparent_image['image']) . "', sort_order = '" . (int)$proparent_image['sort_order'] . "'");
			}
		}

		if (isset($data['proparent_download'])) {
			foreach ($data['proparent_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_to_download SET proparent_id = '" . (int)$proparent_id . "', download_id = '" . (int)$download_id . "'");
			}
		}

		if (isset($data['proparent_category'])) {
			foreach ($data['proparent_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_to_category SET proparent_id = '" . (int)$proparent_id . "', category_id = '" . (int)$category_id . "'");
			}
		}

		if (isset($data['proparent_filter'])) {
			foreach ($data['proparent_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_filter SET proparent_id = '" . (int)$proparent_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['proparent_related'])) {
			foreach ($data['proparent_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_related WHERE proparent_id = '" . (int)$proparent_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_related SET proparent_id = '" . (int)$proparent_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_related WHERE proparent_id = '" . (int)$related_id . "' AND related_id = '" . (int)$proparent_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_related SET proparent_id = '" . (int)$related_id . "', related_id = '" . (int)$proparent_id . "'");
			}
		}

		if (isset($data['proparent_reward'])) {
			foreach ($data['proparent_reward'] as $customer_group_id => $proparent_reward) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_reward SET proparent_id = '" . (int)$proparent_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$proparent_reward['points'] . "'");
			}
		}

		if (isset($data['proparent_layout'])) {
			foreach ($data['proparent_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_to_layout SET proparent_id = '" . (int)$proparent_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'proparent_id=" . (int)$proparent_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		if (isset($data['proparent_recurrings'])) {
			foreach ($data['proparent_recurrings'] as $recurring) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "proparent_recurring` SET `proparent_id` = " . (int)$proparent_id . ", customer_group_id = " . (int)$recurring['customer_group_id'] . ", `recurring_id` = " . (int)$recurring['recurring_id']);
			}
		}

		$this->cache->delete('proparent');

		$this->event->trigger('post.admin.proparent.add', $proparent_id);

		return $proparent_id;
	}

	public function editProparent($proparent_id, $data) {
		$this->event->trigger('pre.admin.proparent.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "proparent SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', ean = '" . $this->db->escape($data['ean']) . "', jan = '" . $this->db->escape($data['jan']) . "', isbn = '" . $this->db->escape($data['isbn']) . "', mpn = '" . $this->db->escape($data['mpn']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', minimum = '" . (int)$data['minimum'] . "', subtract = '" . (int)$data['subtract'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', points = '" . (int)$data['points'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . $this->db->escape($data['tax_class_id']) . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE proparent_id = '" . (int)$proparent_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "proparent SET image = '" . $this->db->escape($data['image']) . "' WHERE proparent_id = '" . (int)$proparent_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_description WHERE proparent_id = '" . (int)$proparent_id . "'");

		foreach ($data['proparent_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_description SET proparent_id = '" . (int)$proparent_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_to_store WHERE proparent_id = '" . (int)$proparent_id . "'");

		if (isset($data['proparent_store'])) {
			foreach ($data['proparent_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_to_store SET proparent_id = '" . (int)$proparent_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_attribute WHERE proparent_id = '" . (int)$proparent_id . "'");

		if (!empty($data['proparent_attribute'])) {
			foreach ($data['proparent_attribute'] as $proparent_attribute) {
				if ($proparent_attribute['attribute_id']) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_attribute WHERE proparent_id = '" . (int)$proparent_id . "' AND attribute_id = '" . (int)$proparent_attribute['attribute_id'] . "'");

					foreach ($proparent_attribute['proparent_attribute_description'] as $language_id => $proparent_attribute_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_attribute SET proparent_id = '" . (int)$proparent_id . "', attribute_id = '" . (int)$proparent_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($proparent_attribute_description['text']) . "'");
					}
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_option WHERE proparent_id = '" . (int)$proparent_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_option_value WHERE proparent_id = '" . (int)$proparent_id . "'");

		if (isset($data['proparent_option'])) {
			foreach ($data['proparent_option'] as $proparent_option) {
				if ($proparent_option['type'] == 'select' || $proparent_option['type'] == 'radio' || $proparent_option['type'] == 'checkbox' || $proparent_option['type'] == 'image') {
					if (isset($proparent_option['proparent_option_value'])) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_option SET proparent_option_id = '" . (int)$proparent_option['proparent_option_id'] . "', proparent_id = '" . (int)$proparent_id . "', option_id = '" . (int)$proparent_option['option_id'] . "', required = '" . (int)$proparent_option['required'] . "'");

						$proparent_option_id = $this->db->getLastId();

						foreach ($proparent_option['proparent_option_value'] as $proparent_option_value) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_option_value SET proparent_option_value_id = '" . (int)$proparent_option_value['proparent_option_value_id'] . "', proparent_option_id = '" . (int)$proparent_option_id . "', proparent_id = '" . (int)$proparent_id . "', option_id = '" . (int)$proparent_option['option_id'] . "', option_value_id = '" . (int)$proparent_option_value['option_value_id'] . "', quantity = '" . (int)$proparent_option_value['quantity'] . "', subtract = '" . (int)$proparent_option_value['subtract'] . "', price = '" . (float)$proparent_option_value['price'] . "', price_prefix = '" . $this->db->escape($proparent_option_value['price_prefix']) . "', points = '" . (int)$proparent_option_value['points'] . "', points_prefix = '" . $this->db->escape($proparent_option_value['points_prefix']) . "', weight = '" . (float)$proparent_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($proparent_option_value['weight_prefix']) . "'");
						}
					}
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_option SET proparent_option_id = '" . (int)$proparent_option['proparent_option_id'] . "', proparent_id = '" . (int)$proparent_id . "', option_id = '" . (int)$proparent_option['option_id'] . "', value = '" . $this->db->escape($proparent_option['value']) . "', required = '" . (int)$proparent_option['required'] . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_discount WHERE proparent_id = '" . (int)$proparent_id . "'");

		if (isset($data['proparent_discount'])) {
			foreach ($data['proparent_discount'] as $proparent_discount) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_discount SET proparent_id = '" . (int)$proparent_id . "', customer_group_id = '" . (int)$proparent_discount['customer_group_id'] . "', quantity = '" . (int)$proparent_discount['quantity'] . "', priority = '" . (int)$proparent_discount['priority'] . "', price = '" . (float)$proparent_discount['price'] . "', date_start = '" . $this->db->escape($proparent_discount['date_start']) . "', date_end = '" . $this->db->escape($proparent_discount['date_end']) . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_special WHERE proparent_id = '" . (int)$proparent_id . "'");

		if (isset($data['proparent_special'])) {
			foreach ($data['proparent_special'] as $proparent_special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_special SET proparent_id = '" . (int)$proparent_id . "', customer_group_id = '" . (int)$proparent_special['customer_group_id'] . "', priority = '" . (int)$proparent_special['priority'] . "', price = '" . (float)$proparent_special['price'] . "', date_start = '" . $this->db->escape($proparent_special['date_start']) . "', date_end = '" . $this->db->escape($proparent_special['date_end']) . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_image WHERE proparent_id = '" . (int)$proparent_id . "'");

		if (isset($data['proparent_image'])) {
			foreach ($data['proparent_image'] as $proparent_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_image SET proparent_id = '" . (int)$proparent_id . "', image = '" . $this->db->escape($proparent_image['image']) . "', sort_order = '" . (int)$proparent_image['sort_order'] . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_to_download WHERE proparent_id = '" . (int)$proparent_id . "'");

		if (isset($data['proparent_download'])) {
			foreach ($data['proparent_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_to_download SET proparent_id = '" . (int)$proparent_id . "', download_id = '" . (int)$download_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_to_category WHERE proparent_id = '" . (int)$proparent_id . "'");

		if (isset($data['proparent_category'])) {
			foreach ($data['proparent_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_to_category SET proparent_id = '" . (int)$proparent_id . "', category_id = '" . (int)$category_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_filter WHERE proparent_id = '" . (int)$proparent_id . "'");

		if (isset($data['proparent_filter'])) {
			foreach ($data['proparent_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_filter SET proparent_id = '" . (int)$proparent_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_related WHERE proparent_id = '" . (int)$proparent_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_related WHERE related_id = '" . (int)$proparent_id . "'");

		if (isset($data['proparent_related'])) {
			foreach ($data['proparent_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_related WHERE proparent_id = '" . (int)$proparent_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_related SET proparent_id = '" . (int)$proparent_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_related WHERE proparent_id = '" . (int)$related_id . "' AND related_id = '" . (int)$proparent_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_related SET proparent_id = '" . (int)$related_id . "', related_id = '" . (int)$proparent_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_reward WHERE proparent_id = '" . (int)$proparent_id . "'");

		if (isset($data['proparent_reward'])) {
			foreach ($data['proparent_reward'] as $customer_group_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_reward SET proparent_id = '" . (int)$proparent_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$value['points'] . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_to_layout WHERE proparent_id = '" . (int)$proparent_id . "'");

		if (isset($data['proparent_layout'])) {
			foreach ($data['proparent_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "proparent_to_layout SET proparent_id = '" . (int)$proparent_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'proparent_id=" . (int)$proparent_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'proparent_id=" . (int)$proparent_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->db->query("DELETE FROM `" . DB_PREFIX . "proparent_recurring` WHERE proparent_id = " . (int)$proparent_id);

		if (isset($data['proparent_recurrings'])) {
			foreach ($data['proparent_recurrings'] as $recurring) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "proparent_recurring` SET `proparent_id` = " . (int)$proparent_id . ", customer_group_id = " . (int)$recurring['customer_group_id'] . ", `recurring_id` = " . (int)$recurring['recurring_id']);
			}
		}

		$this->cache->delete('proparent');

		$this->event->trigger('post.admin.proparent.edit', $proparent_id);
	}

	public function copyProparent($proparent_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "proparent p LEFT JOIN " . DB_PREFIX . "proparent_description pd ON (p.proparent_id = pd.proparent_id) WHERE p.proparent_id = '" . (int)$proparent_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		if ($query->num_rows) {
			$data = array();

			$data = $query->row;

			$data['sku'] = '';
			$data['upc'] = '';
			$data['viewed'] = '0';
			$data['keyword'] = '';
			$data['status'] = '0';

			$data = array_merge($data, array('proparent_attribute' => $this->getProparentAttributes($proparent_id)));
			$data = array_merge($data, array('proparent_description' => $this->getProparentDescriptions($proparent_id)));
			$data = array_merge($data, array('proparent_discount' => $this->getProparentDiscounts($proparent_id)));
			$data = array_merge($data, array('proparent_filter' => $this->getProparentFilters($proparent_id)));
			$data = array_merge($data, array('proparent_image' => $this->getProparentImages($proparent_id)));
			$data = array_merge($data, array('proparent_option' => $this->getProparentOptions($proparent_id)));
			$data = array_merge($data, array('proparent_related' => $this->getProparentRelated($proparent_id)));
			$data = array_merge($data, array('proparent_reward' => $this->getProparentRewards($proparent_id)));
			$data = array_merge($data, array('proparent_special' => $this->getProparentSpecials($proparent_id)));
			$data = array_merge($data, array('proparent_category' => $this->getProparentCategories($proparent_id)));
			$data = array_merge($data, array('proparent_download' => $this->getProparentDownloads($proparent_id)));
			$data = array_merge($data, array('proparent_layout' => $this->getProparentLayouts($proparent_id)));
			$data = array_merge($data, array('proparent_store' => $this->getProparentStores($proparent_id)));
			$data = array_merge($data, array('proparent_recurrings' => $this->getRecurrings($proparent_id)));

			$this->addProparent($data);
		}
	}

	public function deleteProparent($proparent_id) {
		$this->event->trigger('pre.admin.proparent.delete', $proparent_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent WHERE proparent_id = '" . (int)$proparent_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_attribute WHERE proparent_id = '" . (int)$proparent_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_description WHERE proparent_id = '" . (int)$proparent_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_discount WHERE proparent_id = '" . (int)$proparent_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_filter WHERE proparent_id = '" . (int)$proparent_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_image WHERE proparent_id = '" . (int)$proparent_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_option WHERE proparent_id = '" . (int)$proparent_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_option_value WHERE proparent_id = '" . (int)$proparent_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_related WHERE proparent_id = '" . (int)$proparent_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_related WHERE related_id = '" . (int)$proparent_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_reward WHERE proparent_id = '" . (int)$proparent_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_special WHERE proparent_id = '" . (int)$proparent_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_to_category WHERE proparent_id = '" . (int)$proparent_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_to_download WHERE proparent_id = '" . (int)$proparent_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_to_layout WHERE proparent_id = '" . (int)$proparent_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_to_store WHERE proparent_id = '" . (int)$proparent_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE proparent_id = '" . (int)$proparent_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "proparent_recurring WHERE proparent_id = " . (int)$proparent_id);
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'proparent_id=" . (int)$proparent_id . "'");

		$this->cache->delete('proparent');

		$this->event->trigger('post.admin.proparent.delete', $proparent_id);
	}

	public function getProparent($proparent_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'proparent_id=" . (int)$proparent_id . "') AS keyword FROM " . DB_PREFIX . "proparent p LEFT JOIN " . DB_PREFIX . "proparent_description pd ON (p.proparent_id = pd.proparent_id) WHERE p.proparent_id = '" . (int)$proparent_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getProparents($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "proparent p LEFT JOIN " . DB_PREFIX . "proparent_description pd ON (p.proparent_id = pd.proparent_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

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
                
                
		if (isset($data['filter_user_id']) && !is_null($data['filter_user_id'])) {
			$sql .= " AND p.author_id = '" . (int)$data['filter_user_id'] . "'";
		}
		
		$sql .= " GROUP BY p.proparent_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'p.price',
			'p.quantity',
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

	public function getProparentsByCategoryId($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "proparent p LEFT JOIN " . DB_PREFIX . "proparent_description pd ON (p.proparent_id = pd.proparent_id) LEFT JOIN " . DB_PREFIX . "proparent_to_category p2c ON (p.proparent_id = p2c.proparent_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.category_id = '" . (int)$category_id . "' ORDER BY pd.name ASC");

		return $query->rows;
	}

	public function getProparentDescriptions($proparent_id) {
		$proparent_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "proparent_description WHERE proparent_id = '" . (int)$proparent_id . "'");

		foreach ($query->rows as $result) {
			$proparent_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'tag'              => $result['tag']
			);
		}

		return $proparent_description_data;
	}

	public function getProparentCategories($proparent_id) {
		$proparent_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "proparent_to_category WHERE proparent_id = '" . (int)$proparent_id . "'");

		foreach ($query->rows as $result) {
			$proparent_category_data[] = $result['category_id'];
		}

		return $proparent_category_data;
	}

	public function getProparentFilters($proparent_id) {
		$proparent_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "proparent_filter WHERE proparent_id = '" . (int)$proparent_id . "'");

		foreach ($query->rows as $result) {
			$proparent_filter_data[] = $result['filter_id'];
		}

		return $proparent_filter_data;
	}

	public function getProparentAttributes($proparent_id) {
		$proparent_attribute_data = array();

		$proparent_attribute_query = $this->db->query("SELECT attribute_id FROM " . DB_PREFIX . "proparent_attribute WHERE proparent_id = '" . (int)$proparent_id . "' GROUP BY attribute_id");

		foreach ($proparent_attribute_query->rows as $proparent_attribute) {
			$proparent_attribute_description_data = array();

			$proparent_attribute_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "proparent_attribute WHERE proparent_id = '" . (int)$proparent_id . "' AND attribute_id = '" . (int)$proparent_attribute['attribute_id'] . "'");

			foreach ($proparent_attribute_description_query->rows as $proparent_attribute_description) {
				$proparent_attribute_description_data[$proparent_attribute_description['language_id']] = array('text' => $proparent_attribute_description['text']);
			}

			$proparent_attribute_data[] = array(
				'attribute_id'                  => $proparent_attribute['attribute_id'],
				'proparent_attribute_description' => $proparent_attribute_description_data
			);
		}

		return $proparent_attribute_data;
	}

	public function getProparentOptions($proparent_id) {
		$proparent_option_data = array();

		$proparent_option_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "proparent_option` po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN `" . DB_PREFIX . "option_description` od ON (o.option_id = od.option_id) WHERE po.proparent_id = '" . (int)$proparent_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		foreach ($proparent_option_query->rows as $proparent_option) {
			$proparent_option_value_data = array();

			$proparent_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "proparent_option_value WHERE proparent_option_id = '" . (int)$proparent_option['proparent_option_id'] . "'");

			foreach ($proparent_option_value_query->rows as $proparent_option_value) {
				$proparent_option_value_data[] = array(
					'proparent_option_value_id' => $proparent_option_value['proparent_option_value_id'],
					'option_value_id'         => $proparent_option_value['option_value_id'],
					'quantity'                => $proparent_option_value['quantity'],
					'subtract'                => $proparent_option_value['subtract'],
					'price'                   => $proparent_option_value['price'],
					'price_prefix'            => $proparent_option_value['price_prefix'],
					'points'                  => $proparent_option_value['points'],
					'points_prefix'           => $proparent_option_value['points_prefix'],
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

	public function getProparentImages($proparent_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "proparent_image WHERE proparent_id = '" . (int)$proparent_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getProparentDiscounts($proparent_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "proparent_discount WHERE proparent_id = '" . (int)$proparent_id . "' ORDER BY quantity, priority, price");

		return $query->rows;
	}

	public function getProparentSpecials($proparent_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "proparent_special WHERE proparent_id = '" . (int)$proparent_id . "' ORDER BY priority, price");

		return $query->rows;
	}

	public function getProparentRewards($proparent_id) {
		$proparent_reward_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "proparent_reward WHERE proparent_id = '" . (int)$proparent_id . "'");

		foreach ($query->rows as $result) {
			$proparent_reward_data[$result['customer_group_id']] = array('points' => $result['points']);
		}

		return $proparent_reward_data;
	}

	public function getProparentDownloads($proparent_id) {
		$proparent_download_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "proparent_to_download WHERE proparent_id = '" . (int)$proparent_id . "'");

		foreach ($query->rows as $result) {
			$proparent_download_data[] = $result['download_id'];
		}

		return $proparent_download_data;
	}

	public function getProparentStores($proparent_id) {
		$proparent_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "proparent_to_store WHERE proparent_id = '" . (int)$proparent_id . "'");

		foreach ($query->rows as $result) {
			$proparent_store_data[] = $result['store_id'];
		}

		return $proparent_store_data;
	}

	public function getProparentLayouts($proparent_id) {
		$proparent_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "proparent_to_layout WHERE proparent_id = '" . (int)$proparent_id . "'");

		foreach ($query->rows as $result) {
			$proparent_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $proparent_layout_data;
	}

	public function getProparentRelated($proparent_id) {
		$proparent_related_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "proparent_related WHERE proparent_id = '" . (int)$proparent_id . "'");

		foreach ($query->rows as $result) {
			$proparent_related_data[] = $result['related_id'];
		}

		return $proparent_related_data;
	}

	public function getRecurrings($proparent_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "proparent_recurring` WHERE proparent_id = '" . (int)$proparent_id . "'");

		return $query->rows;
	}

	public function getTotalProparents($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.proparent_id) AS total FROM " . DB_PREFIX . "proparent p LEFT JOIN " . DB_PREFIX . "proparent_description pd ON (p.proparent_id = pd.proparent_id)";

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

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalProparentsByTaxClassId($tax_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "proparent WHERE tax_class_id = '" . (int)$tax_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalProparentsByStockStatusId($stock_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "proparent WHERE stock_status_id = '" . (int)$stock_status_id . "'");

		return $query->row['total'];
	}

	public function getTotalProparentsByWeightClassId($weight_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "proparent WHERE weight_class_id = '" . (int)$weight_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalProparentsByLengthClassId($length_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "proparent WHERE length_class_id = '" . (int)$length_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalProparentsByDownloadId($download_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "proparent_to_download WHERE download_id = '" . (int)$download_id . "'");

		return $query->row['total'];
	}

	public function getTotalProparentsByManufacturerId($manufacturer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "proparent WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		return $query->row['total'];
	}

	public function getTotalProparentsByAttributeId($attribute_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "proparent_attribute WHERE attribute_id = '" . (int)$attribute_id . "'");

		return $query->row['total'];
	}

	public function getTotalProparentsByOptionId($option_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "proparent_option WHERE option_id = '" . (int)$option_id . "'");

		return $query->row['total'];
	}

	public function getTotalProparentsByProfileId($recurring_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "proparent_recurring WHERE recurring_id = '" . (int)$recurring_id . "'");

		return $query->row['total'];
	}

	public function getTotalProparentsByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "proparent_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
}