<?php
class ControllerCommonSearchHome extends Controller {
	public function index() {
		$this->load->language('common/search_home');

		$data['text_search'] = $this->language->get('text_search');
		$data['text_labelname'] = $this->language->get('text_labelname');
		$data['text_labeldate_in'] = $this->language->get('text_labeldate_in');
		$data['text_labeldate_out'] = $this->language->get('text_labeldate_out');
		$data['text_labelnight'] = $this->language->get('text_labelnight');
		$data['text_labelguest'] = $this->language->get('text_labelguest');
		$data['text_labeladults'] = $this->language->get('text_labeladults');
		$data['text_labelroom'] = $this->language->get('text_labelroom');
		$data['text_labelchildren'] = $this->language->get('text_labelchildren');
		$data['text_1adult'] = $this->language->get('text_1adult');
		$data['text_2adults'] = $this->language->get('text_2adults');
		$data['text_more'] = $this->language->get('text_more');

		if (isset($this->request->get['search'])) {
			$data['search'] = $this->request->get['search'];
		} else {
			$data['search'] = '';
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/search_home.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/search_home.tpl', $data);
		} else {
			return $this->load->view('default/template/common/search_home.tpl', $data);
		}
	}
}