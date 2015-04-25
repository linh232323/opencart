<?php
class ModelCatalogReview extends Model {
	public function addReview($room_id, $data) {
		$this->event->trigger('pre.review.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "review SET author = '" . $this->db->escape($data['name']) . "', customer_id = '" . (int)$this->customer->getId() . "', room_id = '" . (int)$room_id . "', text = '" . $this->db->escape($data['text']) . "', rating = '" . (int)$data['rating'] . "', date_added = NOW()");

		$review_id = $this->db->getLastId();

		if ($this->config->get('config_review_mail')) {
			$this->load->language('mail/review');
			$this->load->model('catalog/room');
			$room_info = $this->model_catalog_room->getRoom($room_id);

			$subject = sprintf($this->language->get('text_subject'), $this->config->get('config_name'));

			$message  = $this->language->get('text_waiting') . "\n";
			$message .= sprintf($this->language->get('text_room'), $this->db->escape(strip_tags($room_info['name']))) . "\n";
			$message .= sprintf($this->language->get('text_reviewer'), $this->db->escape(strip_tags($data['name']))) . "\n";
			$message .= sprintf($this->language->get('text_rating'), $this->db->escape(strip_tags($data['rating']))) . "\n";
			$message .= $this->language->get('text_review') . "\n";
			$message .= $this->db->escape(strip_tags($data['text'])) . "\n\n";

			$mail = new Mail($this->config->get('config_mail'));
			$mail->setTo(array($this->config->get('config_email')));
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender($this->config->get('config_name'));
			$mail->setSubject($subject);
			$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
			$mail->send();

			// Send to additional alert emails
			$emails = explode(',', $this->config->get('config_mail_alert'));

			foreach ($emails as $email) {
				if ($email && preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $email)) {
					$mail->setTo($email);
					$mail->send();
				}
			}
		}

		$this->event->trigger('post.review.add', $review_id);
	}
        
	public function addHotelreview($hotel_id, $data) {
		$this->event->trigger('pre.hotelreview.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "hotelreview SET author = '" . $this->db->escape($data['name']) . "', customer_id = '" . (int)$this->customer->getId() . "', hotel_id = '" . (int)$hotel_id . "', text = '" . $this->db->escape($data['text']) . "', rating = '" . (int)$data['rating'] . "', date_added = NOW()");

		$hotelreview_id = $this->db->getLastId();

		if ($this->config->get('config_hotelreview_mail')) {
			$this->load->language('mail/review');
			$this->load->model('catalog/hotel');
			$hotel_info = $this->model_catalog_hotel->gethotel($hotel_id);

			$subject = sprintf($this->language->get('text_subject'), $this->config->get('config_name'));

			$message  = $this->language->get('text_waiting') . "\n";
			$message .= sprintf($this->language->get('text_hotel'), $this->db->escape(strip_tags($hotel_info['name']))) . "\n";
			$message .= sprintf($this->language->get('text_reviewer'), $this->db->escape(strip_tags($data['name']))) . "\n";
			$message .= sprintf($this->language->get('text_rating'), $this->db->escape(strip_tags($data['rating']))) . "\n";
			$message .= $this->language->get('text_hotelreview') . "\n";
			$message .= $this->db->escape(strip_tags($data['text'])) . "\n\n";

			$mail = new Mail($this->config->get('config_mail'));
			$mail->setTo(array($this->config->get('config_email')));
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender($this->config->get('config_name'));
			$mail->setSubject($subject);
			$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
			$mail->send();

			// Send to additional alert emails
			$emails = explode(',', $this->config->get('config_mail_alert'));

			foreach ($emails as $email) {
				if ($email && preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $email)) {
					$mail->setTo($email);
					$mail->send();
				}
			}
		}

		$this->event->trigger('post.hotelreview.add', $hotelreview_id);
	}

	public function getReviewsByRoomId($room_id, $start = 0, $limit = 20) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 20;
		}

		$query = $this->db->query("SELECT r.review_id, r.author, r.rating, r.text, p.room_id, pd.name, p.price, p.image, r.date_added FROM " . DB_PREFIX . "review r LEFT JOIN " . DB_PREFIX . "room p ON (r.room_id = p.room_id) LEFT JOIN " . DB_PREFIX . "room_description pd ON (p.room_id = pd.room_id) WHERE p.room_id = '" . (int)$room_id . "' AND p.date_available <= NOW() AND p.status = '1' AND r.status = '1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY r.date_added DESC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}
        
	public function getReviewsByhotelId($hotel_id, $start = 0, $limit = 20) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 20;
		}

		$query = $this->db->query("SELECT r.hotelreview_id, r.author, r.rating, r.text, p.hotel_id, pd.name, p.price, p.image, r.date_added FROM " . DB_PREFIX . "hotelreview r LEFT JOIN " . DB_PREFIX . "hotel p ON (r.hotel_id = p.hotel_id) LEFT JOIN " . DB_PREFIX . "hotel_description pd ON (p.hotel_id = pd.hotel_id) WHERE p.hotel_id = '" . (int)$hotel_id . "' AND p.date_available <= NOW() AND p.status = '1' AND r.status = '1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY r.date_added DESC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getTotalReviewsByRoomId($room_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r LEFT JOIN " . DB_PREFIX . "room p ON (r.room_id = p.room_id) LEFT JOIN " . DB_PREFIX . "room_description pd ON (p.room_id = pd.room_id) WHERE p.room_id = '" . (int)$room_id . "' AND p.date_available <= NOW() AND p.status = '1' AND r.status = '1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row['total'];
	}
        
	public function getTotalReviewsByhotelId($hotel_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "hotelreview r LEFT JOIN " . DB_PREFIX . "hotel p ON (r.hotel_id = p.hotel_id) LEFT JOIN " . DB_PREFIX . "hotel_description pd ON (p.hotel_id = pd.hotel_id) WHERE p.hotel_id = '" . (int)$hotel_id . "' AND p.date_available <= NOW() AND p.status = '1' AND r.status = '1' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row['total'];
	}
}