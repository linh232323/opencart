<?php
class ControllerCommonSearchHotel extends Controller {
	public function index() {
		$this->load->language('common/search_hotel');

		$data['text_search'] = $this->language->get('text_search');
		$data['text_labelname'] = $this->language->get('text_labelname');
		$data['text_labeldate_in'] = $this->language->get('text_labeldate_in');
		$data['text_labeldate_out'] = $this->language->get('text_labeldate_out');
		$data['text_labelguest'] = $this->language->get('text_labelguest');

		if (isset($this->request->get['search'])) {
			$data['search'] = $this->request->get['search'];
		} else {
			$data['search'] = '';
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/search_hotel.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/search_hotel.tpl', $data);
		} else {
			return $this->load->view('default/template/common/search_hotel.tpl', $data);
		}
	}
}