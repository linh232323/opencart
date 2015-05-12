<?php
class ModelCatalogPrice extends Model {
	public function addPrice($data) {
		$this->event->trigger('pre.admin.price.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "price SET service_id = '" . (int)$data['service_id'] . "', service_type_id = '" . (int)$data['service_type_id'] . "'");

		$price_id = $this->db->getLastId();

		foreach ($data['price_date'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "price_description SET price_id = '" . (int)$price_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->event->trigger('post.admin.price.add', $price_id);

		return $price_id;
	}

	public function editPrice($price_id, $data) {
		$this->event->trigger('pre.admin.price.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "price SET price_group_id = '" . (int)$data['price_group_id'] . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE price_id = '" . (int)$price_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "price_description WHERE price_id = '" . (int)$price_id . "'");

		foreach ($data['price_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "price_description SET price_id = '" . (int)$price_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->event->trigger('post.admin.price.edit', $price_id);
	}

	public function deletePrice($price_id) {
		$this->event->trigger('pre.admin.price.delete', $price_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "price WHERE price_id = '" . (int)$price_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "price_description WHERE price_id = '" . (int)$price_id . "'");

		$this->event->trigger('post.admin.price.delete', $price_id);
	}

	public function getPrice($price_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "price a LEFT JOIN " . DB_PREFIX . "price_description ad ON (a.price_id = ad.price_id) WHERE a.price_id = '" . (int)$price_id . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getPrices($data = array()) {
		$sql = "SELECT *, (SELECT agd.name FROM " . DB_PREFIX . "price_group_description agd WHERE agd.price_group_id = a.price_group_id AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS price_group FROM " . DB_PREFIX . "price a LEFT JOIN " . DB_PREFIX . "price_description ad ON (a.price_id = ad.price_id) WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND ad.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_price_group_id'])) {
			$sql .= " AND a.price_group_id = '" . $this->db->escape($data['filter_price_group_id']) . "'";
		}

		$sort_data = array(
			'ad.name',
			'price_group',
			'a.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY price_group, ad.name";
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

	public function getPriceDescriptions($price_id) {
		$price_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "price_description WHERE price_id = '" . (int)$price_id . "'");

		foreach ($query->rows as $result) {
			$price_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $price_data;
	}

	public function getTotalPrices() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "price");

		return $query->row['total'];
	}

}