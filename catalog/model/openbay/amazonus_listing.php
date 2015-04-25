<?php
class ModelOpenbayAmazonusListing extends Model {
	public function listingSuccessful($room_id) {
		$this->db->query("UPDATE `" . DB_PREFIX . "amazonus_room` SET `status` = 'ok' WHERE room_id = " . (int)$room_id . " AND `version` = 3");
	}

	public function listingFailed($room_id, $messages) {
		$this->db->query("UPDATE `" . DB_PREFIX . "amazonus_room` SET `status` = 'error', `messages` = '" . $this->db->escape(json_encode($messages)) . "' WHERE room_id = " . (int)$room_id . " AND `version` = 3");
	}
}