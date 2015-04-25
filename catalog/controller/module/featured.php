<?php
class ControllerModuleFeatured extends Controller {
	public function index($setting) {
		$this->load->language('module/featured');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_tax'] = $this->language->get('text_tax');
		$data['text_hotel'] = $this->language->get('text_hotel');

		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');

		$this->load->model('catalog/category');
                
		$this->load->model('catalog/proparent');

		$this->load->model('tool/image');

		$data['categorys'] = array();

		if (!$setting['limit']) {
			$setting['limit'] = 4;
		}

		$categorys = array_slice($setting['category'], 0, (int)$setting['limit']);
                
		foreach ($categorys as $category_id) {
			$category_info = $this->model_catalog_category->getCategory($category_id);
                        
                        $filter_data = array(
						'filter_category_id'  => $category_id,
						'filter_sub_category' => true
					);
                        $child = $this->model_catalog_proparent->getTotalProparents($filter_data);
			if ($category_info) {
				if ($category_info['image']) {
					$image = $this->model_tool_image->resizetoWidth($category_info['image'], $setting['width']);
				} else {
					$image = $this->model_tool_image->resizetoWidth('placeholder.png', $setting['width']);
				}
                                $data['maxheight'] = $setting['height']."px";
				$data['categorys'][] = array(
					'category_id' => $category_info['category_id'],
					'thumb'       => $image,
					'name'        => $category_info['name'],
					'child'       => $child,
					'href'        => $this->url->link('product/category', 'path=' . $category_info['category_id'])
				);
			}
		}

		if ($data['categorys']) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/featured.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/featured.tpl', $data);
			} else {
				return $this->load->view('default/template/module/featured.tpl', $data);
			}
		}
	}
}