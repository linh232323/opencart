<?php
class ControllerCommonSearchHome extends Controller {
	public function index() {
		$this->load->language('common/search_home');

		$data['text_search'] = $this->language->get('text_search');

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