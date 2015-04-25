<?php
class ModelOpenbayAmazonListing extends Model {
	public function listingSuccessful($room_id, $marketplace) {
		$this->db->query("UPDATE `" . DB_PREFIX . "amazon_room` SET `status` = 'ok' WHERE room_id = " . (int)$room_id . " AND `marketplaces` = '" . $this->db->escape($marketplace) . "' AND `version` = 3
		");
	}

	public function listingFailed($room_id, $marketplace, $messages) {
		$this->db->query("UPDATE `" . DB_PREFIX . "amazon_room` SET `status` = 'error', `messages` = '" . $this->db->escape(json_encode($messages)) . "' WHERE room_id = " . (int)$room_id . " AND `marketplaces` = '" . $this->db->escape($marketplace) . "' AND `version` = 3");
	}
}