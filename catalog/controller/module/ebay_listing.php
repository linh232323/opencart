<?php
class ControllerModuleEbayListing extends Controller {
	public function index() {
		if ($this->config->get('ebay_status') == 1) {
			$this->language->load('module/ebay');
			
			$this->load->model('tool/image');
			$this->load->model('openbay/ebay_room');

			$data['heading_title'] = $this->language->get('heading_title');

			$data['rooms'] = array();

			$rooms = $this->cache->get('ebay_listing.' . md5(serialize($rooms)));

			if (!$rooms) {
				$rooms = $this->model_openbay_ebay_room->getDisplayrooms();
				
				$this->cache->set('ebay_listing.' . md5(serialize($rooms)), $rooms);
			}

			foreach($rooms['rooms'] as $room) {
				if (isset($room['pictures'][0])) {
					$image = $this->model_openbay_ebay_room->resize($room['pictures'][0], $this->config->get('ebay_listing_width'), $this->config->get('ebay_listing_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('ebay_listing_width'), $this->config->get('ebay_listing_height'));
				}

				$data['rooms'][] = array(
					'thumb' => $image, 
					'name'  => base64_decode($room['Title']), 
					'price' => $this->currency->format($room['priceGross']), 
					'href' => (string)$room['link']
				);
			}

			$data['tracking_pixel'] = $rooms['tracking_pixel'];

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/ebay.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/ebay.tpl', $data);
			} else {
				return $this->load->view('default/template/module/ebay.tpl', $data);
			}
		}
	}
}