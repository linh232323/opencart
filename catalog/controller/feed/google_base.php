<?php
class ControllerFeedGoogleBase extends Controller {
	public function index() {
		if ($this->config->get('google_base_status')) {
			$output  = '<?xml version="1.0" encoding="UTF-8" ?>';
			$output .= '<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">';
			$output .= '<channel>';
			$output .= '<title>' . $this->config->get('config_name') . '</title>';
			$output .= '<description>' . $this->config->get('config_meta_description') . '</description>';
			$output .= '<link>' . HTTP_SERVER . '</link>';

			$this->load->model('catalog/category');

			$this->load->model('catalog/room');

			$this->load->model('tool/image');

			$rooms = $this->model_catalog_room->getrooms();

			foreach ($rooms as $room) {
				if ($room['description']) {
					$output .= '<item>';
					$output .= '<title>' . $room['name'] . '</title>';
					$output .= '<link>' . $this->url->link('product/room', 'room_id=' . $room['room_id']) . '</link>';
					$output .= '<description>' . $room['description'] . '</description>';
					$output .= '<g:brand>' . html_entity_decode($room['manufacturer'], ENT_QUOTES, 'UTF-8') . '</g:brand>';
					$output .= '<g:condition>new</g:condition>';
					$output .= '<g:id>' . $room['room_id'] . '</g:id>';

					if ($room['image']) {
						$output .= '<g:image_link>' . $this->model_tool_image->resize($room['image'], 500, 500) . '</g:image_link>';
					} else {
						$output .= '<g:image_link></g:image_link>';
					}

					$output .= '<g:model_number>' . $room['model'] . '</g:model_number>';

					if ($room['mpn']) {
						$output .= '<g:mpn>' . $room['mpn'] . '</g:mpn>' ;
					} else {
						$output .= '<g:identifier_exists>false</g:identifier_exists>';
					}

					if ($room['upc']) {
						$output .= '<g:upc>' . $room['upc'] . '</g:upc>';
					}

					if ($room['ean']) {
						$output .= '<g:ean>' . $room['ean'] . '</g:ean>';
					}

					$currencies = array(
						'USD',
						'EUR',
						'GBP'
					);

					if (in_array($this->currency->getCode(), $currencies)) {
						$currency_code = $this->currency->getCode();
						$currency_value = $this->currency->getValue();
					} else {
						$currency_code = 'USD';
						$currency_value = $this->currency->getValue('USD');
					}

					if ((float)$room['special']) {
						$output .= '<g:price>' .  $this->currency->format($this->tax->calculate($room['special'], $room['tax_class_id']), $currency_code, $currency_value, false) . '</g:price>';
					} else {
						$output .= '<g:price>' . $this->currency->format($this->tax->calculate($room['price'], $room['tax_class_id']), $currency_code, $currency_value, false) . '</g:price>';
					}

					$categories = $this->model_catalog_room->getCategories($room['room_id']);

					foreach ($categories as $category) {
						$path = $this->getPath($category['category_id']);

						if ($path) {
							$string = '';

							foreach (explode('_', $path) as $path_id) {
								$category_info = $this->model_catalog_category->getCategory($path_id);

								if ($category_info) {
									if (!$string) {
										$string = $category_info['name'];
									} else {
										$string .= ' &gt; ' . $category_info['name'];
									}
								}
							}

							$output .= '<g:room_type>' . $string . '</g:room_type>';
						}
					}

					$output .= '<g:quantity>' . $room['quantity'] . '</g:quantity>';
					$output .= '<g:weight>' . $this->weight->format($room['weight'], $room['weight_class_id']) . '</g:weight>';
					$output .= '<g:availability>' . ($room['quantity'] ? 'in stock' : 'out of stock') . '</g:availability>';
					$output .= '</item>';
				}
			}

			$output .= '</channel>';
			$output .= '</rss>';

			$this->response->addHeader('Content-Type: application/rss+xml');
			$this->response->setOutput($output);
		}
	}

	protected function getPath($parent_id, $current_path = '') {
		$category_info = $this->model_catalog_category->getCategory($parent_id);

		if ($category_info) {
			if (!$current_path) {
				$new_path = $category_info['category_id'];
			} else {
				$new_path = $category_info['category_id'] . '_' . $current_path;
			}

			$path = $this->getPath($category_info['parent_id'], $new_path);

			if ($path) {
				return $path;
			} else {
				return $new_path;
			}
		}
	}
}