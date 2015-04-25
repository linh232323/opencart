<?php
class ModelOpenbayEtsyRoom extends Model{
	public function getStatus($room_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "etsy_listing` WHERE `room_id` = '" . (int)$room_id . "' AND `status` = 1 LIMIT 1");

		if ($query->num_rows == 0) {
			return 0;
		} else {
			return 1;
		}
	}

	public function totalLinked() {
		$sql = "SELECT COUNT(DISTINCT p.room_id) AS total
				FROM `" . DB_PREFIX . "etsy_listing` `el`
				LEFT JOIN `" . DB_PREFIX . "room` `p` ON (`el`.`room_id` = `p`.`room_id`)
				LEFT JOIN `" . DB_PREFIX . "room_description` `pd` ON (`p`.`room_id` = `pd`.`room_id`)
				WHERE `el`.`status` = '1'
				AND `pd`.`language_id` = '" . (int)$this->config->get('config_language_id') . "'";

		$query = $this->db->query($sql);

		return (int)$query->row['total'];
	}

	public function addLink($room_id, $etsy_item_id, $status_id = 0) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "etsy_listing` SET `room_id` = '" . (int)$room_id . "', `etsy_item_id` = '" . $this->db->escape($etsy_item_id) . "', `status` = '" . (int)$status_id . "', `created`  = now()");
	}

	public function loadLinked($limit = 100, $page = 1) {
		$this->load->model('tool/image');

		$start = $limit * ($page - 1);

		$sql = "
		SELECT
			`el`.`etsy_listing_id`,
			`el`.`etsy_item_id`,
			`el`.`status`,
			`p`.`room_id`,
			`p`.`sku`,
			`p`.`model`,
			`p`.`quantity`,
			`pd`.`name`
		FROM `" . DB_PREFIX . "etsy_listing` `el`
		LEFT JOIN `" . DB_PREFIX . "room` `p` ON (`el`.`room_id` = `p`.`room_id`)
		LEFT JOIN `" . DB_PREFIX . "room_description` `pd` ON (`p`.`room_id` = `pd`.`room_id`)
		WHERE `el`.`status` = '1'
		AND `pd`.`language_id` = '" . (int)$this->config->get('config_language_id') . "'";

		$sql .= " LIMIT " . (int)$start . "," . (int)$limit;

		$qry = $this->db->query($sql);

		$data = array();
		if ($qry->num_rows) {
			foreach($qry->rows as $row) {
				$data[] = array(
					'etsy_listing_id'	=> $row['etsy_listing_id'],
					'room_id'    	=> $row['room_id'],
					'sku'           	=> $row['sku'],
					'model'         	=> $row['model'],
					'quantity'      	=> $row['quantity'],
					'name'          	=> $row['name'],
					'status'        	=> $row['status'],
					'etsy_item_id'  	=> $row['etsy_item_id'],
					'link_edit'     	=> $this->url->link('catalog/room/update', 'token=' . $this->session->data['token'] . '&room_id=' . $row['room_id'], 'SSL'),
					'link_etsy'     	=> 'http://www.etsy.com/listing/' . $row['etsy_item_id'],
				);
			}
		}

		return $data;
	}
}