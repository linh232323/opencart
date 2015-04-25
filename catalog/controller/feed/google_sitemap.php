<?php
class ControllerFeedGoogleSitemap extends Controller {
	public function index() {
		if ($this->config->get('google_sitemap_status')) {
			$output  = '<?xml version="1.0" encoding="UTF-8"?>';
			$output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';

			$this->load->model('catalog/room');
			$this->load->model('tool/image');

			$rooms = $this->model_catalog_room->getrooms();

			foreach ($rooms as $room) {
				if ($room['image']) {
					$output .= '<url>';
					$output .= '<loc>' . $this->url->link('product/room', 'room_id=' . $room['room_id']) . '</loc>';
					$output .= '<changefreq>weekly</changefreq>';
					$output .= '<priority>1.0</priority>';
					$output .= '<image:image>';
					$output .= '<image:loc>' . $this->model_tool_image->resize($room['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')) . '</image:loc>';
					$output .= '<image:caption>' . $room['name'] . '</image:caption>';
					$output .= '<image:title>' . $room['name'] . '</image:title>';
					$output .= '</image:image>';
					$output .= '</url>';
				}
			}

			$this->load->model('catalog/category');

			$output .= $this->getCategories(0);

			$this->load->model('catalog/manufacturer');

			$manufacturers = $this->model_catalog_manufacturer->getManufacturers();

			foreach ($manufacturers as $manufacturer) {
				$output .= '<url>';
				$output .= '<loc>' . $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $manufacturer['manufacturer_id']) . '</loc>';
				$output .= '<changefreq>weekly</changefreq>';
				$output .= '<priority>0.7</priority>';
				$output .= '</url>';

				$rooms = $this->model_catalog_room->getrooms(array('filter_manufacturer_id' => $manufacturer['manufacturer_id']));

				foreach ($rooms as $room) {
					$output .= '<url>';
					$output .= '<loc>' . $this->url->link('product/room', 'manufacturer_id=' . $manufacturer['manufacturer_id'] . '&amp;room_id=' . $room['room_id']) . '</loc>';
					$output .= '<changefreq>weekly</changefreq>';
					$output .= '<priority>1.0</priority>';
					$output .= '</url>';
				}
			}

			$this->load->model('catalog/information');

			$informations = $this->model_catalog_information->getInformations();

			foreach ($informations as $information) {
				$output .= '<url>';
				$output .= '<loc>' . $this->url->link('information/information', 'information_id=' . $information['information_id']) . '</loc>';
				$output .= '<changefreq>weekly</changefreq>';
				$output .= '<priority>0.5</priority>';
				$output .= '</url>';
			}

			$output .= '</urlset>';

			$this->response->addHeader('Content-Type: application/xml');
			$this->response->setOutput($output);
		}
	}

	protected function getCategories($parent_id, $current_path = '') {
		$output = '';

		$results = $this->model_catalog_category->getCategories($parent_id);

		foreach ($results as $result) {
			if (!$current_path) {
				$new_path = $result['category_id'];
			} else {
				$new_path = $current_path . '_' . $result['category_id'];
			}

			$output .= '<url>';
			$output .= '<loc>' . $this->url->link('product/category', 'path=' . $new_path) . '</loc>';
			$output .= '<changefreq>weekly</changefreq>';
			$output .= '<priority>0.7</priority>';
			$output .= '</url>';

			$rooms = $this->model_catalog_room->getrooms(array('filter_category_id' => $result['category_id']));

			foreach ($rooms as $room) {
				$output .= '<url>';
				$output .= '<loc>' . $this->url->link('product/room', 'path=' . $new_path . '&amp;room_id=' . $room['room_id']) . '</loc>';
				$output .= '<changefreq>weekly</changefreq>';
				$output .= '<priority>1.0</priority>';
				$output .= '</url>';
			}

			$output .= $this->getCategories($result['category_id'], $new_path);
		}

		return $output;
	}
}
