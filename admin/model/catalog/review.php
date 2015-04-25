<?php
class ModelCatalogReview extends Model {
	public function addReview($data) {
		$this->event->trigger('pre.admin.review.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "review SET author = '" . $this->db->escape($data['author']) . "', room_id = '" . (int)$data['room_id'] . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "', status = '" . (int)$data['status'] . "', date_added = NOW()");

		$review_id = $this->db->getLastId();

		$this->cache->delete('room');

		$this->event->trigger('post.admin.review.add', $review_id);

		return $review_id;
	}

	public function editReview($review_id, $data) {
		$this->event->trigger('pre.admin.review.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "review SET author = '" . $this->db->escape($data['author']) . "', room_id = '" . (int)$data['room_id'] . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE review_id = '" . (int)$review_id . "'");

		$this->cache->delete('room');

		$this->event->trigger('post.admin.review.edit', $review_id);
	}

	public function deleteReview($review_id) {
		$this->event->trigger('pre.admin.review.delete', $review_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE review_id = '" . (int)$review_id . "'");

		$this->cache->delete('room');

		$this->event->trigger('post.admin.review.delete', $review_id);
	}

	public function getReview($review_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT pd.name FROM " . DB_PREFIX . "room_description pd WHERE pd.room_id = r.room_id AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS room FROM " . DB_PREFIX . "review r WHERE r.review_id = '" . (int)$review_id . "'");

		return $query->row;
	}

	public function getReviews($data = array()) {
		$sql = "SELECT r.review_id, pd.name, r.author, r.rating, r.status, r.date_added FROM " . DB_PREFIX . "review r LEFT JOIN " . DB_PREFIX . "room_description pd ON (r.room_id = pd.room_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_room'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_room']) . "%'";
		}

		if (!empty($data['filter_author'])) {
			$sql .= " AND r.author LIKE '" . $this->db->escape($data['filter_author']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND r.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(r.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$sort_data = array(
			'pd.name',
			'r.author',
			'r.rating',
			'r.status',
			'r.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY r.date_added";
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

	public function getTotalReviews($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r LEFT JOIN " . DB_PREFIX . "room_description pd ON (r.room_id = pd.room_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_room'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_room']) . "%'";
		}

		if (!empty($data['filter_author'])) {
			$sql .= " AND r.author LIKE '" . $this->db->escape($data['filter_author']) . "%'";
		}

		if (!empty($data['filter_status'])) {
			$sql .= " AND r.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(r.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalReviewsAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review WHERE status = '0'");

		return $query->row['total'];
	}
        
	public function addHotelreview($data) {
		$this->event->trigger('pre.admin.hotelreview.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "hotelreview SET author = '" . $this->db->escape($data['author']) . "', hotel_id = '" . (int)$data['hotel_id'] . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "', status = '" . (int)$data['status'] . "', date_added = NOW()");

		$hotelreview_id = $this->db->getLastId();

		$this->cache->delete('hotel');

		$this->event->trigger('post.admin.hotelreview.add', $hotelreview_id);

		return $hotelreview_id;
	}

	public function editHotelreview($hotelreview_id, $data) {
		$this->event->trigger('pre.admin.hotelreview.edit', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "hotelreview SET author = '" . $this->db->escape($data['author']) . "', hotel_id = '" . (int)$data['hotel_id'] . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE hotelreview_id = '" . (int)$hotelreview_id . "'");

		$this->cache->delete('hotel');

		$this->event->trigger('post.admin.hotelreview.edit', $hotelreview_id);
	}

	public function deleteHotelreview($hotelreview_id) {
		$this->event->trigger('pre.admin.hotelreview.delete', $hotelreview_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "hotelreview WHERE hotelreview_id = '" . (int)$hotelreview_id . "'");

		$this->cache->delete('hotel');

		$this->event->trigger('post.admin.hotelreview.delete', $hotelreview_id);
	}

	public function getHotelreview($hotelreview_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT pd.name FROM " . DB_PREFIX . "hotel_description pd WHERE pd.hotel_id = r.hotel_id AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS hotel FROM " . DB_PREFIX . "hotelreview r WHERE r.hotelreview_id = '" . (int)$hotelreview_id . "'");

		return $query->row;
	}

	public function getHotelreviews($data = array()) {
		$sql = "SELECT r.hotelreview_id, pd.name, r.author, r.rating, r.status, r.date_added FROM " . DB_PREFIX . "hotelreview r LEFT JOIN " . DB_PREFIX . "hotel_description pd ON (r.hotel_id = pd.hotel_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_hotel'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_hotel']) . "%'";
		}

		if (!empty($data['filter_author'])) {
			$sql .= " AND r.author LIKE '" . $this->db->escape($data['filter_author']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND r.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(r.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$sort_data = array(
			'pd.name',
			'r.author',
			'r.rating',
			'r.status',
			'r.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY r.date_added";
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

	public function getTotalHotelreviews($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "hotelreview r LEFT JOIN " . DB_PREFIX . "hotel_description pd ON (r.hotel_id = pd.hotel_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_hotel'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_']) . "%'";
		}

		if (!empty($data['filter_author'])) {
			$sql .= " AND r.author LIKE '" . $this->db->escape($data['filter_author']) . "%'";
		}

		if (!empty($data['filter_status'])) {
			$sql .= " AND r.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(r.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalHotelreviewsAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "hotelreview WHERE status = '0'");

		return $query->row['total'];
	}
}