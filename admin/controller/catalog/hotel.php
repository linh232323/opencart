<?php
class ControllerCatalogHotel extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/hotel');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/hotel');

		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/hotel');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/hotel');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_hotel->addHotel($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/hotel', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/hotel');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/hotel');
                
                $this->load->model('user/user');
                 
                $user_info = $this->model_user_user->getUser($this->user->getId());
                
                $user_id = $user_info['user_group_id'];
               
		$room = $this->model_catalog_hotel->getHotel($this->request->get['hotel_id']);
                
                if(isset($room['author_id'])){
                    if($room['author_id'] == $user_id || $user_id == 1){
                        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
                                $this->model_catalog_hotel->editHotel($this->request->get['hotel_id'], $this->request->post);

                                $this->session->data['success'] = $this->language->get('text_success');

                                $url = '';

                                if (isset($this->request->get['filter_name'])) {
                                        $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
                                }

                                if (isset($this->request->get['filter_model'])) {
                                        $url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
                                }

                                if (isset($this->request->get['filter_status'])) {
                                        $url .= '&filter_status=' . $this->request->get['filter_status'];
                                }

                                if (isset($this->request->get['sort'])) {
                                        $url .= '&sort=' . $this->request->get['sort'];
                                }

                                if (isset($this->request->get['order'])) {
                                        $url .= '&order=' . $this->request->get['order'];
                                }

                                if (isset($this->request->get['page'])) {
                                        $url .= '&page=' . $this->request->get['page'];
                                }

                                $this->response->redirect($this->url->link('catalog/hotel', 'token=' . $this->session->data['token'] . $url, 'SSL'));
                        }

                        $this->getForm();
                    }
                }
	}

	public function delete() {
		$this->load->language('catalog/hotel');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/hotel');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $hotel_id) {
				$this->model_catalog_hotel->deleteHotel($hotel_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/hotel', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	public function copy() {
		$this->load->language('catalog/hotel');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/hotel');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $hotel_id) {
				$this->model_catalog_hotel->copyHotel($hotel_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/hotel', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
            
                $this->load->model('user/user');

		$user_info = $this->model_user_user->getUser($this->user->getId());
                
                $user_id = $user_info['user_group_id'];
                
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_model'])) {
			$filter_model = $this->request->get['filter_model'];
		} else {
			$filter_model = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'pd.name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/hotel', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['add'] = $this->url->link('catalog/hotel/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['copy'] = $this->url->link('catalog/hotel/copy', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('catalog/hotel/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['hotels'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name,
			'filter_model'	  => $filter_model,
			'filter_status'   => $filter_status,
			'filter_user_id'  => $user_id,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);

		$this->load->model('tool/image');

		$hotel_total = $this->model_catalog_hotel->getTotalHotels($filter_data);

		$results = $this->model_catalog_hotel->getHotels($filter_data);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}

			$data['hotels'][] = array(
				'hotel_id' => $result['hotel_id'],
				'image'      => $image,
				'name'       => $result['name'],
				'model'      => $result['model'],
				'status'     => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'       => $this->url->link('catalog/hotel/edit', 'token=' . $this->session->data['token'] . '&hotel_id=' . $result['hotel_id'] . $url, 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_list'] = $this->language->get('text_list');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_image'] = $this->language->get('column_image');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_model'] = $this->language->get('entry_model');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_copy'] = $this->language->get('button_copy');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');

		$data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('catalog/hotel', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, 'SSL');
		$data['sort_model'] = $this->url->link('catalog/hotel', 'token=' . $this->session->data['token'] . '&sort=p.model' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('catalog/hotel', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, 'SSL');
		$data['sort_order'] = $this->url->link('catalog/hotel', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $hotel_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/hotel', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($hotel_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($hotel_total - $this->config->get('config_limit_admin'))) ? $hotel_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $hotel_total, ceil($hotel_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;
		$data['filter_model'] = $filter_model;
		$data['filter_status'] = $filter_status;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/hotel_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_form'] = !isset($this->request->get['hotel_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_plus'] = $this->language->get('text_plus');
		$data['text_minus'] = $this->language->get('text_minus');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_option'] = $this->language->get('text_option');
		$data['text_option_value'] = $this->language->get('text_option_value');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_percent'] = $this->language->get('text_percent');
		$data['text_amount'] = $this->language->get('text_amount');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_wifi'] = $this->language->get('entry_wifi');
		$data['entry_address'] = $this->language->get('entry_address');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_short_description'] = $this->language->get('entry_short_description');
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_keyword'] = $this->language->get('entry_keyword');
		$data['entry_model'] = $this->language->get('entry_model');
		$data['entry_star'] = $this->language->get('entry_star');
		$data['entry_date_available'] = $this->language->get('entry_date_available');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
		$data['entry_download'] = $this->language->get('entry_download');
		$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_filter'] = $this->language->get('entry_filter');
		$data['entry_related'] = $this->language->get('entry_related');
		$data['entry_attribute'] = $this->language->get('entry_attribute');
		$data['entry_text'] = $this->language->get('entry_text');
		$data['entry_option'] = $this->language->get('entry_option');
		$data['entry_option_value'] = $this->language->get('entry_option_value');
		$data['entry_required'] = $this->language->get('entry_required');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end'] = $this->language->get('entry_date_end');
		$data['entry_priority'] = $this->language->get('entry_priority');
		$data['entry_tag'] = $this->language->get('entry_tag');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_reward'] = $this->language->get('entry_reward');
		$data['entry_layout'] = $this->language->get('entry_layout');
		$data['entry_recurring'] = $this->language->get('entry_recurring');
		$data['entry_maps_api'] = $this->language->get('entry_maps_api');

		$data['help_keyword'] = $this->language->get('help_keyword');
		$data['help_manufacturer'] = $this->language->get('help_manufacturer');
		$data['help_category'] = $this->language->get('help_category');
		$data['help_tag'] = $this->language->get('help_tag');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_attribute_add'] = $this->language->get('button_attribute_add');
		$data['button_image_add'] = $this->language->get('button_image_add');
		$data['button_remove'] = $this->language->get('button_remove');
                
		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_data'] = $this->language->get('tab_data');
		$data['tab_attribute'] = $this->language->get('tab_attribute');
		$data['tab_image'] = $this->language->get('tab_image');
		$data['tab_maps'] = $this->language->get('tab_maps');
                
                $this->load->model('user/user');

		$user_info = $this->model_user_user->getUser($this->user->getId());
                
                $user_id = $user_info['user_group_id'];
                
                $data['author_id'] = $user_id;
                
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
                
		if (isset($this->error['address'])) {
			$data['error_address'] = $this->error['address'];
		} else {
			$data['error_address'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		if (isset($this->error['meta_title'])) {
			$data['error_meta_title'] = $this->error['meta_title'];
		} else {
			$data['error_meta_title'] = array();
		}

		if (isset($this->error['model'])) {
			$data['error_model'] = $this->error['model'];
		} else {
			$data['error_model'] = '';
		}

		if (isset($this->error['date_available'])) {
			$data['error_date_available'] = $this->error['date_available'];
		} else {
			$data['error_date_available'] = '';
		}
		
		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}
		
		if (isset($this->error['maps_api'])) {
			$data['error_maps_api'] = $this->error['maps_api'];
		} else {
			$data['error_maps_api'] = '';
		}
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/hotel', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (!isset($this->request->get['hotel_id'])) {
			$data['action'] = $this->url->link('catalog/hotel/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('catalog/hotel/edit', 'token=' . $this->session->data['token'] . '&hotel_id=' . $this->request->get['hotel_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('catalog/hotel', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['hotel_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$hotel_info = $this->model_catalog_hotel->getHotel($this->request->get['hotel_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['hotel_description'])) {
			$data['hotel_description'] = $this->request->post['hotel_description'];
		} elseif (isset($this->request->get['hotel_id'])) {
			$data['hotel_description'] = $this->model_catalog_hotel->getHotelDescriptions($this->request->get['hotel_id']);
		} else {
			$data['hotel_description'] = array();
		}
                
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($hotel_info)) {
			$data['image'] = $hotel_info['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($hotel_info) && is_file(DIR_IMAGE . $hotel_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($hotel_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		if (isset($this->request->post['model'])) {
			$data['model'] = $this->request->post['model'];
		} elseif (!empty($hotel_info)) {
			$data['model'] = $hotel_info['model'];
		} else {
			$data['model'] = '';
		}
                
		if (isset($this->request->post['address'])) {
			$data['address'] = $this->request->post['address'];
		} elseif (!empty($hotel_info)) {
			$data['address'] = $hotel_info['address'];
		} else {
			$data['address'] = '';
		}
                
		if (isset($this->request->post['wifi'])) {
			$data['wifi'] = $this->request->post['wifi'];
		} elseif (!empty($hotel_info)) {
			$data['wifi'] = $hotel_info['wifi'];
		} else {
			$data['wifi'] = 0;
		}
		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['hotel_store'])) {
			$data['hotel_store'] = $this->request->post['hotel_store'];
		} elseif (isset($this->request->get['hotel_id'])) {
			$data['hotel_store'] = $this->model_catalog_hotel->getHotelStores($this->request->get['hotel_id']);
		} else {
			$data['hotel_store'] = array(0);
		}

		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($hotel_info)) {
			$data['keyword'] = $hotel_info['keyword'];
		} else {
			$data['keyword'] = '';
		}
                
		if (isset($this->request->post['star'])) {
			$data['star'] = $this->request->post['star'];
		} elseif (!empty($hotel_info)) {
			$data['star'] = $hotel_info['star'];
		} else {
			$data['star'] = 0;
		}
                
		if (isset($this->request->post['date_available'])) {
			$data['date_available'] = $this->request->post['date_available'];
		} elseif (!empty($hotel_info)) {
			$data['date_available'] = ($hotel_info['date_available'] != '0000-00-00') ? $hotel_info['date_available'] : '';
		} else {
			$data['date_available'] = date('Y-m-d');
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($hotel_info)) {
			$data['sort_order'] = $hotel_info['sort_order'];
		} else {
			$data['sort_order'] = 1;
		}


		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($hotel_info)) {
			$data['status'] = $hotel_info['status'];
		} else {
			$data['status'] = true;
		}
                
		$this->load->model('catalog/manufacturer');

		if (isset($this->request->post['manufacturer_id'])) {
			$data['manufacturer_id'] = $this->request->post['manufacturer_id'];
		} elseif (!empty($hotel_info)) {
			$data['manufacturer_id'] = $hotel_info['manufacturer_id'];
		} else {
			$data['manufacturer_id'] = 0;
		}

		if (isset($this->request->post['manufacturer'])) {
			$data['manufacturer'] = $this->request->post['manufacturer'];
		} elseif (!empty($hotel_info)) {
			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($hotel_info['manufacturer_id']);

			if ($manufacturer_info) {
				$data['manufacturer'] = $manufacturer_info['name'];
			} else {
				$data['manufacturer'] = '';
			}
		} else {
			$data['manufacturer'] = '';
		}

		// Categories
		$this->load->model('catalog/category');

		if (isset($this->request->post['hotel_category'])) {
			$categories = $this->request->post['hotel_category'];
		} elseif (isset($this->request->get['hotel_id'])) {
			$categories = $this->model_catalog_hotel->getHotelCategories($this->request->get['hotel_id']);
		} else {
			$categories = array();
		}

		$data['hotel_categories'] = array();

		foreach ($categories as $category_id) {
			$category_info = $this->model_catalog_category->getCategory($category_id);

			if ($category_info) {
				$data['hotel_categories'][] = array(
					'category_id' => $category_info['category_id'],
					'name' => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
				);
			}
		}

		// Filters
		$this->load->model('catalog/filter');

		if (isset($this->request->post['hotel_filter'])) {
			$filters = $this->request->post['hotel_filter'];
		} elseif (isset($this->request->get['hotel_id'])) {
			$filters = $this->model_catalog_hotel->getHotelFilters($this->request->get['hotel_id']);
		} else {
			$filters = array();
		}

		$data['hotel_filters'] = array();

		foreach ($filters as $filter_id) {
			$filter_info = $this->model_catalog_filter->getFilter($filter_id);

			if ($filter_info) {
				$data['hotel_filters'][] = array(
					'filter_id' => $filter_info['filter_id'],
					'name'      => $filter_info['group'] . ' &gt; ' . $filter_info['name']
				);
			}
		}

		// Attributes
		$this->load->model('catalog/attribute');

		if (isset($this->request->post['hotel_attribute'])) {
			$hotel_attributes = $this->request->post['hotel_attribute'];
		} elseif (isset($this->request->get['hotel_id'])) {
			$hotel_attributes = $this->model_catalog_hotel->getHotelAttributes($this->request->get['hotel_id']);
		} else {
			$hotel_attributes =  $this->model_catalog_attribute->getAttributes();
		}
		$data['hotel_attributes'] = array();

		foreach ($hotel_attributes as $hotel_attribute) {
			$attribute_info = $this->model_catalog_attribute->getAttribute($hotel_attribute['attribute_id']);
                        if(!isset($hotel_attribute['hotel_attribute_description'])){
                            $hotel_attribute_description = "";
                        }else{
                            $hotel_attribute_description = $hotel_attribute['hotel_attribute_description'];
                        }
			if ($attribute_info) {
				$data['hotel_attributes'][] = array(
					'attribute_id'                  => $hotel_attribute['attribute_id'],
					'name'                          => $attribute_info['name'],
					'hotel_attribute_description' => $hotel_attribute_description
				);
			}
		}
                
                // Google Maps
                

		if (isset($this->request->post['maps_apil'])) {
			$data['maps_apil'] = $this->request->post['maps_apil'];
		} elseif (!empty($hotel_info)) {
			$data['maps_apil'] = $hotel_info['maps_apil'];
		} else {
			$data['maps_apil'] = '';
		}

		if (isset($this->request->post['maps_apir'])) {
			$data['maps_apir'] = $this->request->post['maps_apir'];
		} elseif (!empty($hotel_info)) {
			$data['maps_apir'] = $hotel_info['maps_apir'];
		} else {
			$data['maps_apir'] = '';
		}
                
		// Options
		$this->load->model('catalog/option');

		if (isset($this->request->post['hotel_option'])) {
			$hotel_options = $this->request->post['hotel_option'];
		} elseif (isset($this->request->get['hotel_id'])) {
			$hotel_options = $this->model_catalog_hotel->getHotelOptions($this->request->get['hotel_id']);
		} else {
			$hotel_options = array();
		}

		$data['hotel_options'] = array();

		foreach ($hotel_options as $hotel_option) {
			$hotel_option_value_data = array();

			if (isset($hotel_option['hotel_option_value'])) {
				foreach ($hotel_option['hotel_option_value'] as $hotel_option_value) {
					$hotel_option_value_data[] = array(
						'hotel_option_value_id' => $hotel_option_value['hotel_option_value_id'],
						'option_value_id'         => $hotel_option_value['option_value_id'],
						'quantity'                => $hotel_option_value['quantity'],
						'subtract'                => $hotel_option_value['subtract'],
						'price'                   => $hotel_option_value['price'],
						'price_prefix'            => $hotel_option_value['price_prefix'],
						'points'                  => $hotel_option_value['points'],
						'points_prefix'           => $hotel_option_value['points_prefix'],
						'weight'                  => $hotel_option_value['weight'],
						'weight_prefix'           => $hotel_option_value['weight_prefix']
					);
				}
			}

			$data['hotel_options'][] = array(
				'hotel_option_id'    => $hotel_option['hotel_option_id'],
				'hotel_option_value' => $hotel_option_value_data,
				'option_id'            => $hotel_option['option_id'],
				'name'                 => $hotel_option['name'],
				'type'                 => $hotel_option['type'],
				'value'                => isset($hotel_option['value']) ? $hotel_option['value'] : '',
				'required'             => $hotel_option['required']
			);
		}

		$data['option_values'] = array();

		foreach ($data['hotel_options'] as $hotel_option) {
			if ($hotel_option['type'] == 'select' || $hotel_option['type'] == 'radio' || $hotel_option['type'] == 'checkbox' || $hotel_option['type'] == 'image') {
				if (!isset($data['option_values'][$hotel_option['option_id']])) {
					$data['option_values'][$hotel_option['option_id']] = $this->model_catalog_option->getOptionValues($hotel_option['option_id']);
				}
			}
		}

		$this->load->model('sale/customer_group');

		$data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();

		if (isset($this->request->post['hotel_discount'])) {
			$hotel_discounts = $this->request->post['hotel_discount'];
		} elseif (isset($this->request->get['hotel_id'])) {
			$hotel_discounts = $this->model_catalog_hotel->getHotelDiscounts($this->request->get['hotel_id']);
		} else {
			$hotel_discounts = array();
		}

		$data['hotel_discounts'] = array();

		foreach ($hotel_discounts as $hotel_discount) {
			$data['hotel_discounts'][] = array(
				'customer_group_id' => $hotel_discount['customer_group_id'],
				'quantity'          => $hotel_discount['quantity'],
				'priority'          => $hotel_discount['priority'],
				'price'             => $hotel_discount['price'],
				'date_start'        => ($hotel_discount['date_start'] != '0000-00-00') ? $hotel_discount['date_start'] : '',
				'date_end'          => ($hotel_discount['date_end'] != '0000-00-00') ? $hotel_discount['date_end'] : ''
			);
		}

		if (isset($this->request->post['hotel_special'])) {
			$hotel_specials = $this->request->post['hotel_special'];
		} elseif (isset($this->request->get['hotel_id'])) {
			$hotel_specials = $this->model_catalog_hotel->getHotelSpecials($this->request->get['hotel_id']);
		} else {
			$hotel_specials = array();
		}

		$data['hotel_specials'] = array();

		foreach ($hotel_specials as $hotel_special) {
			$data['hotel_specials'][] = array(
				'customer_group_id' => $hotel_special['customer_group_id'],
				'priority'          => $hotel_special['priority'],
				'price'             => $hotel_special['price'],
				'date_start'        => ($hotel_special['date_start'] != '0000-00-00') ? $hotel_special['date_start'] : '',
				'date_end'          => ($hotel_special['date_end'] != '0000-00-00') ? $hotel_special['date_end'] :  ''
			);
		}

		// Images
		if (isset($this->request->post['hotel_image'])) {
			$hotel_images = $this->request->post['hotel_image'];
		} elseif (isset($this->request->get['hotel_id'])) {
			$hotel_images = $this->model_catalog_hotel->getHotelImages($this->request->get['hotel_id']);
		} else {
			$hotel_images = array();
		}

		$data['hotel_images'] = array();

		foreach ($hotel_images as $hotel_image) {
			if (is_file(DIR_IMAGE . $hotel_image['image'])) {
				$image = $hotel_image['image'];
				$thumb = $hotel_image['image'];
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}

			$data['hotel_images'][] = array(
				'image'      => $image,
				'thumb'      => $this->model_tool_image->resize($thumb, 100, 100),
				'sort_order' => $hotel_image['sort_order']
			);
		}

		// Downloads
		$this->load->model('catalog/download');

		if (isset($this->request->post['hotel_download'])) {
			$hotel_downloads = $this->request->post['hotel_download'];
		} elseif (isset($this->request->get['hotel_id'])) {
			$hotel_downloads = $this->model_catalog_hotel->getHotelDownloads($this->request->get['hotel_id']);
		} else {
			$hotel_downloads = array();
		}

		$data['hotel_downloads'] = array();

		foreach ($hotel_downloads as $download_id) {
			$download_info = $this->model_catalog_download->getDownload($download_id);

			if ($download_info) {
				$data['hotel_downloads'][] = array(
					'download_id' => $download_info['download_id'],
					'name'        => $download_info['name']
				);
			}
		}

		if (isset($this->request->post['hotel_related'])) {
			$hotels = $this->request->post['hotel_related'];
		} elseif (isset($this->request->get['hotel_id'])) {
			$hotels = $this->model_catalog_hotel->getHotelRelated($this->request->get['hotel_id']);
		} else {
			$hotels = array();
		}

		$data['hotel_relateds'] = array();

		foreach ($hotels as $hotel_id) {
			$related_info = $this->model_catalog_hotel->getHotel($hotel_id);

			if ($related_info) {
				$data['hotel_relateds'][] = array(
					'hotel_id' => $related_info['hotel_id'],
					'name'       => $related_info['name']
				);
			}
		}

		if (isset($this->request->post['points'])) {
			$data['points'] = $this->request->post['points'];
		} elseif (!empty($hotel_info)) {
			$data['points'] = $hotel_info['points'];
		} else {
			$data['points'] = '';
		}

		if (isset($this->request->post['hotel_reward'])) {
			$data['hotel_reward'] = $this->request->post['hotel_reward'];
		} elseif (isset($this->request->get['hotel_id'])) {
			$data['hotel_reward'] = $this->model_catalog_hotel->getHotelRewards($this->request->get['hotel_id']);
		} else {
			$data['hotel_reward'] = array();
		}

		if (isset($this->request->post['hotel_layout'])) {
			$data['hotel_layout'] = $this->request->post['hotel_layout'];
		} elseif (isset($this->request->get['hotel_id'])) {
			$data['hotel_layout'] = $this->model_catalog_hotel->getHotelLayouts($this->request->get['hotel_id']);
		} else {
			$data['hotel_layout'] = array();
		}

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/hotel_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/hotel')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['hotel_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}

			if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
			}
		}
                
		if ((!is_numeric($this->request->post['maps_apil'])) || (!is_numeric($this->request->post['maps_apir']))) {
			$this->error['maps_api'] = $this->language->get('error_maps_api');
		}
		
		if ((utf8_strlen($this->request->post['model']) < 1) || (utf8_strlen($this->request->post['model']) > 64)) {
			$this->error['model'] = $this->language->get('error_model');
		}
		
		if (utf8_strlen($this->request->post['keyword']) > 0) {
			$this->load->model('catalog/url_alias');

			$url_alias_info = $this->model_catalog_url_alias->getUrlAlias($this->request->post['keyword']);

			if ($url_alias_info && isset($this->request->get['hotel_id']) && $url_alias_info['query'] != 'hotel_id=' . $this->request->get['hotel_id']) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}

			if ($url_alias_info && !isset($this->request->get['hotel_id'])) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/hotel')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateCopy() {
		if (!$this->user->hasPermission('modify', 'catalog/hotel')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function autocomplete() {
              
                $this->load->model('user/user');
                 
                $user_info = $this->model_user_user->getUser($this->user->getId());
                
                $user_id = $user_info['user_group_id'];
               
		$json = array();

		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model'])) {
			$this->load->model('catalog/hotel');
			$this->load->model('catalog/option');

			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['filter_model'])) {
				$filter_model = $this->request->get['filter_model'];
			} else {
				$filter_model = '';
			}

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 5;
			}

			$filter_data = array(
				'filter_name'  => $filter_name,
				'filter_model' => $filter_model,
				'filter_user_id' => $user_id,
				'start'        => 0,
				'limit'        => $limit
			);

			$results = $this->model_catalog_hotel->getHotels($filter_data);

			foreach ($results as $result) {
				$option_data = array();

				$hotel_options = $this->model_catalog_hotel->getHotelOptions($result['hotel_id']);

				foreach ($hotel_options as $hotel_option) {
					$option_info = $this->model_catalog_option->getOption($hotel_option['option_id']);

					if ($option_info) {
						$hotel_option_value_data = array();

						foreach ($hotel_option['hotel_option_value'] as $hotel_option_value) {
							$option_value_info = $this->model_catalog_option->getOptionValue($hotel_option_value['option_value_id']);

							if ($option_value_info) {
								$hotel_option_value_data[] = array(
									'hotel_option_value_id' => $hotel_option_value['hotel_option_value_id'],
									'option_value_id'         => $hotel_option_value['option_value_id'],
									'name'                    => $option_value_info['name'],
									'price'                   => (float)$hotel_option_value['price'] ? $this->currency->format($hotel_option_value['price'], $this->config->get('config_currency')) : false,
									'price_prefix'            => $hotel_option_value['price_prefix']
								);
							}
						}

						$option_data[] = array(
							'hotel_option_id'    => $hotel_option['hotel_option_id'],
							'hotel_option_value' => $hotel_option_value_data,
							'option_id'            => $hotel_option['option_id'],
							'name'                 => $option_info['name'],
							'type'                 => $option_info['type'],
							'value'                => $hotel_option['value'],
							'required'             => $hotel_option['required']
						);
					}
				}

				$json[] = array(
					'hotel_id' => $result['hotel_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'model'      => $result['model'],
					'option'     => $option_data,
					'price'      => $result['price']
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}