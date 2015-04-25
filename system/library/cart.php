<?php
class Cart {
	private $config;
	private $db;
	private $data = array();

	public function __construct($registry) {
		$this->config = $registry->get('config');
		$this->customer = $registry->get('customer');
		$this->session = $registry->get('session');
		$this->db = $registry->get('db');
		$this->tax = $registry->get('tax');
		$this->weight = $registry->get('weight');

		if (!isset($this->session->data['cart']) || !is_array($this->session->data['cart'])) {
			$this->session->data['cart'] = array();
		}
	}

	public function getRooms() {
		if (!$this->data) {
			foreach ($this->session->data['cart'] as $key => $quantity) {
				$room = unserialize(base64_decode($key));

				$room_id = $room['room_id'];

				$stock = true;

				// Options
				if (!empty($room['option'])) {
					$options = $room['option'];
				} else {
					$options = array();
				}

				// Profile
				if (!empty($room['recurring_id'])) {
					$recurring_id = $room['recurring_id'];
				} else {
					$recurring_id = 0;
				}

				$room_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "room p LEFT JOIN " . DB_PREFIX . "room_description pd ON (p.room_id = pd.room_id) WHERE p.room_id = '" . (int)$room_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'");

				if ($room_query->num_rows) {
					$option_price = 0;
					$option_points = 0;
					$option_weight = 0;

					$option_data = array();
                                        
                                        if(!isset($options['price'])){
                                            $options['price'] = '';
                                        }
                                        
                                        if(!isset($options['night'])){
                                            $options['night'] = '';
                                        }
                                        
                                        
                                        if(!isset($options['check_in'])){
                                            $options['check_in'] = '';
                                        }
                                        
                                        
                                        if(!isset($options['check_out'])){
                                            $options['check_out'] = '';
                                        }
                                        
					$price = $options['price'];
                                        
                                        $night = $options['night'];
                                        
					// Room Discounts
					$discount_quantity = 0;

					foreach ($this->session->data['cart'] as $key_2 => $quantity_2) {
						$room_2 = (array)unserialize(base64_decode($key_2));

						if ($room_2['room_id'] == $room_id) {
							$discount_quantity += $quantity_2;
						}
					}

					$room_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "room_discount WHERE room_id = '" . (int)$room_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int)$discount_quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");

					if ($room_discount_query->num_rows) {
						$price = $room_discount_query->row['price'];
					}

					// Room Specials
					$room_special_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "room_special WHERE room_id = '" . (int)$room_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");

					if ($room_special_query->num_rows) {
						$price = $room_special_query->row['price'];
					}

					// Reward Points
					$room_reward_query = $this->db->query("SELECT points FROM " . DB_PREFIX . "room_reward WHERE room_id = '" . (int)$room_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");

					if ($room_reward_query->num_rows) {
						$reward = $room_reward_query->row['points'];
					} else {
						$reward = 0;
					}

					// Downloads
					$download_data = array();

					$download_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "room_to_download p2d LEFT JOIN " . DB_PREFIX . "download d ON (p2d.download_id = d.download_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE p2d.room_id = '" . (int)$room_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

					foreach ($download_query->rows as $download) {
						$download_data[] = array(
							'download_id' => $download['download_id'],
							'name'        => $download['name'],
							'filename'    => $download['filename'],
							'mask'        => $download['mask']
						);
					}

					// Stock
					if (!$room_query->row['quantity'] || ($room_query->row['quantity'] < $quantity)) {
						$stock = false;
					}

					$recurring_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "recurring` `p` JOIN `" . DB_PREFIX . "room_recurring` `pp` ON `pp`.`recurring_id` = `p`.`recurring_id` AND `pp`.`room_id` = " . (int)$room_query->row['room_id'] . " JOIN `" . DB_PREFIX . "recurring_description` `pd` ON `pd`.`recurring_id` = `p`.`recurring_id` AND `pd`.`language_id` = " . (int)$this->config->get('config_language_id') . " WHERE `pp`.`recurring_id` = " . (int)$recurring_id . " AND `status` = 1 AND `pp`.`customer_group_id` = " . (int)$this->config->get('config_customer_group_id'));

					if ($recurring_query->num_rows) {
						$recurring = array(
							'recurring_id'    => $recurring_id,
							'name'            => $recurring_query->row['name'],
							'frequency'       => $recurring_query->row['frequency'],
							'price'           => $recurring_query->row['price'],
							'cycle'           => $recurring_query->row['cycle'],
							'duration'        => $recurring_query->row['duration'],
							'trial'           => $recurring_query->row['trial_status'],
							'trial_frequency' => $recurring_query->row['trial_frequency'],
							'trial_price'     => $recurring_query->row['trial_price'],
							'trial_cycle'     => $recurring_query->row['trial_cycle'],
							'trial_duration'  => $recurring_query->row['trial_duration']
						);
					} else {
						$recurring = false;
					}

					$this->data[$key] = array(
						'key'             => $key,
						'room_id'      => $room_query->row['room_id'],
						'name'            => $room_query->row['name'],
						'model'           => $room_query->row['model'],
						'shipping'        => $room_query->row['shipping'],
						'image'           => $room_query->row['image'],
						'option'          => $option_data,
						'download'        => $download_data,
						'quantity'        => $quantity,
						'minimum'         => $room_query->row['minimum'],
						'subtract'        => $room_query->row['subtract'],
						'stock'           => $stock,
						'price'           => ($price + $option_price),
						'total'           => ($price + $option_price) * $quantity * $night,
						'reward'          => $reward * $quantity,
						'points'          => ($room_query->row['points'] ? ($room_query->row['points'] + $option_points) * $quantity : 0),
						'tax_class_id'    => $room_query->row['tax_class_id'],
						'weight'          => ($room_query->row['weight'] + $option_weight) * $quantity,
						'weight_class_id' => $room_query->row['weight_class_id'],
						'length'          => $room_query->row['length'],
						'width'           => $room_query->row['width'],
						'height'          => $room_query->row['height'],
						'length_class_id' => $room_query->row['length_class_id'],
						'recurring'       => $recurring,
						'check_in'        => $options['check_in'],
						'night'           => $options['night'],
						'check_out'       => $options['check_out']
					);
				} else {
					$this->remove($key);
				}
			}
		}

		return $this->data;
	}

	public function getRecurringRooms() {
		$recurring_rooms = array();

		foreach ($this->getRooms() as $key => $value) {
			if ($value['recurring']) {
				$recurring_rooms[$key] = $value;
			}
		}

		return $recurring_rooms;
	}

	public function add($room_id, $qty = 1, $option = array(), $recurring_id = 0) {
		$this->data = array();

		$room['room_id'] = (int)$room_id;

		if ($option) {
			$room['option'] = $option;
		}

		if ($recurring_id) {
			$room['recurring_id'] = (int)$recurring_id;
		}

		$key = base64_encode(serialize($room));

		if ((int)$qty && ((int)$qty > 0)) {
			if (!isset($this->session->data['cart'][$key])) {
				$this->session->data['cart'][$key] = (int)$qty;
			} else {
				$this->session->data['cart'][$key] += (int)$qty;
			}
		}
	}

	public function update($key, $qty) {
		$this->data = array();

		if ((int)$qty && ((int)$qty > 0) && isset($this->session->data['cart'][$key])) {
			$this->session->data['cart'][$key] = (int)$qty;
		} else {
			$this->remove($key);
		}
	}

	public function remove($key) {
		$this->data = array();

		unset($this->session->data['cart'][$key]);
	}

	public function clear() {
		$this->data = array();

		$this->session->data['cart'] = array();
	}

	public function getWeight() {
		$weight = 0;

		foreach ($this->getRooms() as $room) {
			if ($room['shipping']) {
				$weight += $this->weight->convert($room['weight'], $room['weight_class_id'], $this->config->get('config_weight_class_id'));
			}
		}

		return $weight;
	}

	public function getSubTotal() {
		$total = 0;

		foreach ($this->getRooms() as $room) {
			$total += $room['total'];
		}

		return $total;
	}

	public function getTaxes() {
		$tax_data = array();

		foreach ($this->getRooms() as $room) {
			if ($room['tax_class_id']) {
				$tax_rates = $this->tax->getRates($room['price'], $room['tax_class_id']);

				foreach ($tax_rates as $tax_rate) {
					if (!isset($tax_data[$tax_rate['tax_rate_id']])) {
						$tax_data[$tax_rate['tax_rate_id']] = ($tax_rate['amount'] * $room['quantity']);
					} else {
						$tax_data[$tax_rate['tax_rate_id']] += ($tax_rate['amount'] * $room['quantity']);
					}
				}
			}
		}

		return $tax_data;
	}

	public function getTotal() {
		$total = 0;

		foreach ($this->getRooms() as $room) {
			$total += $this->tax->calculate($room['price'], $room['tax_class_id'], $this->config->get('config_tax')) * $room['quantity'];
		}

		return $total;
	}

	public function countRooms() {
		$room_total = 0;

		$rooms = $this->getRooms();

		foreach ($rooms as $room) {
			$room_total += $room['quantity'];
		}

		return $room_total;
	}

	public function hasRooms() {
		return count($this->session->data['cart']);
	}

	public function hasRecurringRooms() {
		return count($this->getRecurringRooms());
	}

	public function hasStock() {
		$stock = true;

		foreach ($this->getRooms() as $room) {
			if (!$room['stock']) {
				$stock = false;
			}
		}

		return $stock;
	}

	public function hasShipping() {
		$shipping = false;

		foreach ($this->getRooms() as $room) {
			if ($room['shipping']) {
				$shipping = true;

				break;
			}
		}

		return $shipping;
	}

	public function hasDownload() {
		$download = false;

		foreach ($this->getRooms() as $room) {
			if ($room['download']) {
				$download = true;

				break;
			}
		}

		return $download;
	}
}