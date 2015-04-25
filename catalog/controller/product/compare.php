<?php
class ControllerRoomCompare extends Controller {
	public function index() {
		$this->load->language('room/compare');

		$this->load->model('catalog/room');

		$this->load->model('tool/image');

		if (!isset($this->session->data['compare'])) {
			$this->session->data['compare'] = array();
		}

		if (isset($this->request->get['remove'])) {
			$key = array_search($this->request->get['remove'], $this->session->data['compare']);

			if ($key !== false) {
				unset($this->session->data['compare'][$key]);
			}

			$this->session->data['success'] = $this->language->get('text_remove');

			$this->response->redirect($this->url->link('room/compare'));
		}

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('room/compare')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_room'] = $this->language->get('text_room');
		$data['text_name'] = $this->language->get('text_name');
		$data['text_image'] = $this->language->get('text_image');
		$data['text_price'] = $this->language->get('text_price');
		$data['text_model'] = $this->language->get('text_model');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_availability'] = $this->language->get('text_availability');
		$data['text_rating'] = $this->language->get('text_rating');
		$data['text_summary'] = $this->language->get('text_summary');
		$data['text_weight'] = $this->language->get('text_weight');
		$data['text_dimension'] = $this->language->get('text_dimension');
		$data['text_empty'] = $this->language->get('text_empty');

		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_remove'] = $this->language->get('button_remove');

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['review_status'] = $this->config->get('config_review_status');

		$data['rooms'] = array();

		$data['attribute_groups'] = array();

		foreach ($this->session->data['compare'] as $key => $room_id) {
			$room_info = $this->model_catalog_room->getRoom($room_id);

			if ($room_info) {
				if ($room_info['image']) {
					$image = $this->model_tool_image->resize($room_info['image'], $this->config->get('config_image_compare_width'), $this->config->get('config_image_compare_height'));
				} else {
					$image = false;
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($room_info['price'], $room_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}

				if ((float)$room_info['special']) {
					$special = $this->currency->format($this->tax->calculate($room_info['special'], $room_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}

				if ($room_info['quantity'] <= 0) {
					$availability = $room_info['stock_status'];
				} elseif ($this->config->get('config_stock_display')) {
					$availability = $room_info['quantity'];
				} else {
					$availability = $this->language->get('text_instock');
				}

				$attribute_data = array();

				$attribute_groups = $this->model_catalog_room->getRoomAttributes($room_id);

				foreach ($attribute_groups as $attribute_group) {
					foreach ($attribute_group['attribute'] as $attribute) {
						$attribute_data[$attribute['attribute_id']] = $attribute['text'];
					}
				}

				$data['rooms'][$room_id] = array(
					'room_id'   => $room_info['room_id'],
					'name'         => $room_info['name'],
					'thumb'        => $image,
					'price'        => $price,
					'special'      => $special,
					'description'  => utf8_substr(strip_tags(html_entity_decode($room_info['description'], ENT_QUOTES, 'UTF-8')), 0, 200) . '..',
					'model'        => $room_info['model'],
					'manufacturer' => $room_info['manufacturer'],
					'availability' => $availability,
					'rating'       => (int)$room_info['rating'],
					'reviews'      => sprintf($this->language->get('text_reviews'), (int)$room_info['reviews']),
					'weight'       => $this->weight->format($room_info['weight'], $room_info['weight_class_id']),
					'length'       => $this->length->format($room_info['length'], $room_info['length_class_id']),
					'width'        => $this->length->format($room_info['width'], $room_info['length_class_id']),
					'height'       => $this->length->format($room_info['height'], $room_info['length_class_id']),
					'attribute'    => $attribute_data,
					'href'         => $this->url->link('product/room', 'room_id=' . $room_id),
					'remove'       => $this->url->link('room/compare', 'remove=' . $room_id)
				);

				foreach ($attribute_groups as $attribute_group) {
					$data['attribute_groups'][$attribute_group['attribute_group_id']]['name'] = $attribute_group['name'];

					foreach ($attribute_group['attribute'] as $attribute) {
						$data['attribute_groups'][$attribute_group['attribute_group_id']]['attribute'][$attribute['attribute_id']]['name'] = $attribute['name'];
					}
				}
			} else {
				unset($this->session->data['compare'][$key]);
			}
		}

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/room/compare.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/room/compare.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/room/compare.tpl', $data));
		}
	}

	public function add() {
		$this->load->language('room/compare');

		$json = array();

		if (!isset($this->session->data['compare'])) {
			$this->session->data['compare'] = array();
		}

		if (isset($this->request->post['room_id'])) {
			$room_id = $this->request->post['room_id'];
		} else {
			$room_id = 0;
		}

		$this->load->model('catalog/room');

		$room_info = $this->model_catalog_room->getRoom($room_id);

		if ($room_info) {
			if (!in_array($this->request->post['room_id'], $this->session->data['compare'])) {
				if (count($this->session->data['compare']) >= 4) {
					array_shift($this->session->data['compare']);
				}

				$this->session->data['compare'][] = $this->request->post['room_id'];
			}

			$json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/room', 'room_id=' . $this->request->post['room_id']), $room_info['name'], $this->url->link('room/compare'));

			$json['total'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function remove() {

	}
}