<?php
class ControllerCatalogTour extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/tour');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tour');

		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/tour');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tour');
                
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_tour->addTour($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
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

			$this->response->redirect($this->url->link('catalog/tour', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/tour');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tour');
                
                $this->load->model('user/user');

		$user_info = $this->model_user_user->getUser($this->user->getId());
                
                $user_id = $user_info['user_group_id'];
               
		$tour = $this->model_catalog_tour->getTour($this->request->get['tour_id']);
                
                if($tour['author_id'] == $user_id || $user_id == 1){
                    if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
                            $this->model_catalog_tour->editTour($this->request->get['tour_id'], $this->request->post);

                            $this->session->data['success'] = $this->language->get('text_success');

                            $url = '';

                            if (isset($this->request->get['filter_name'])) {
                                    $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
                            }

                            if (isset($this->request->get['filter_model'])) {
                                    $url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
                            }

                            if (isset($this->request->get['filter_price'])) {
                                    $url .= '&filter_price=' . $this->request->get['filter_price'];
                            }

                            if (isset($this->request->get['filter_quantity'])) {
                                    $url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
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

                            $this->response->redirect($this->url->link('catalog/tour', 'token=' . $this->session->data['token'] . $url, 'SSL'));
                    }
                    $this->getForm();
                }else{
                   
                }
	}

	public function delete() {
		$this->load->language('catalog/tour');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tour');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $tour_id) {
				$this->model_catalog_tour->deleteTour($tour_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
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

			$this->response->redirect($this->url->link('catalog/tour', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	public function copy() {
		$this->load->language('catalog/tour');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tour');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $tour_id) {
				$this->model_catalog_tour->copyTour($tour_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
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

			$this->response->redirect($this->url->link('catalog/tour', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
		if (isset($this->request->get['filter_quantity'])) {
			$filter_quantity = $this->request->get['filter_quantity'];
		} else {
			$filter_quantity = null;
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

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
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
			'href' => $this->url->link('catalog/tour', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['add'] = $this->url->link('catalog/tour/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['copy'] = $this->url->link('catalog/tour/copy', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('catalog/tour/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['tours'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name,
			'filter_model'	  => $filter_model,
			'filter_quantity' => $filter_quantity,
			'filter_status'   => $filter_status,
                        'filter_user_id'  => $user_id,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);
     
		$this->load->model('tool/image');

		$tour_total = $this->model_catalog_tour->getTotalTours($filter_data);

		$results = $this->model_catalog_tour->getTours($filter_data);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}

			$data['tours'][] = array(
				'tour_id' => $result['tour_id'],
				'image'      => $image,
				'name'       => $result['name'],
				'model'      => $result['model'],
				'quantity'   => $result['quantity'],
				'status'     => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'       => $this->url->link('catalog/tour/edit', 'token=' . $this->session->data['token'] . '&tour_id=' . $result['tour_id'] . $url, 'SSL')
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
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_model'] = $this->language->get('entry_model');
		$data['entry_date'] = $this->language->get('entry_date');
		$data['entry_quantity'] = $this->language->get('entry_quantity');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_tag'] = $this->language->get('entry_tag');
		$data['entry_transporter'] = $this->language->get('entry_transporter');
		$data['entry_schedule'] = $this->language->get('entry_schedule');

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

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
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

		$data['sort_name'] = $this->url->link('catalog/tour', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, 'SSL');
		$data['sort_model'] = $this->url->link('catalog/tour', 'token=' . $this->session->data['token'] . '&sort=p.model' . $url, 'SSL');
		$data['sort_quantity'] = $this->url->link('catalog/tour', 'token=' . $this->session->data['token'] . '&sort=p.quantity' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('catalog/tour', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, 'SSL');
		$data['sort_order'] = $this->url->link('catalog/tour', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
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
		$pagination->total = $tour_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/tour', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($tour_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($tour_total - $this->config->get('config_limit_admin'))) ? $tour_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $tour_total, ceil($tour_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;
		$data['filter_model'] = $filter_model;
		$data['filter_quantity'] = $filter_quantity;
		$data['filter_status'] = $filter_status;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/tour_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_form'] = !isset($this->request->get['tour_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
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
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_detail'] = $this->language->get('entry_detail');
		$data['entry_info'] = $this->language->get('entry_info');
		$data['entry_tag'] = $this->language->get('entry_tag');
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_keyword'] = $this->language->get('entry_keyword');
		$data['entry_model'] = $this->language->get('entry_model');
		$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_shipping'] = $this->language->get('entry_shipping');
		$data['entry_date_available'] = $this->language->get('entry_date_available');
		$data['entry_quantity'] = $this->language->get('entry_quantity');
		$data['entry_price'] = $this->language->get('entry_price');
		$data['entry_date'] = $this->language->get('entry_date');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end'] = $this->language->get('entry_date_end');
		$data['entry_price'] = $this->language->get('entry_price');
		$data['entry_adult_net'] = $this->language->get('entry_adult_net');
		$data['entry_adult_percent'] = $this->language->get('entry_adult_percent');
		$data['entry_adult_gross'] = $this->language->get('entry_adult_gross');
		$data['entry_child_net'] = $this->language->get('entry_child_net');
		$data['entry_child_percent'] = $this->language->get('entry_child_percent');
		$data['entry_child_gross'] = $this->language->get('entry_child_gross');
		$data['entry_baby_net'] = $this->language->get('entry_baby_net');
		$data['entry_baby_percent'] = $this->language->get('entry_baby_percent');
		$data['entry_baby_gross'] = $this->language->get('entry_baby_gross');
		$data['entry_discount'] = $this->language->get('entry_discount');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_transporter'] = $this->language->get('entry_transporter');
		$data['entry_schedule'] = $this->language->get('entry_schedule');

		$data['help_keyword'] = $this->language->get('help_keyword');
		$data['help_manufacturer'] = $this->language->get('help_manufacturer');
		$data['help_tag'] = $this->language->get('help_tag');
		$data['help_category'] = $this->language->get('help_category');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_price_add'] = $this->language->get('button_price_add');
		$data['button_image_add'] = $this->language->get('button_image_add');
		$data['button_remove'] = $this->language->get('button_remove');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_data'] = $this->language->get('tab_data');
		$data['tab_price'] = $this->language->get('tab_price');
		$data['tab_image'] = $this->language->get('tab_image');
		$data['tab_detail'] = $this->language->get('tab_detail');
		$data['tab_info'] = $this->language->get('tab_info');

                $this->load->model('user/user');

		$user_info = $this->model_user_user->getUser($this->user->getId());
                
                $user_id = $user_info['user_group_id'];
                
                $data['author_id'] = $user_id;
                
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['tour_adult_net'])) {
			$data['error_tour_adult_net'] = $this->error['tour_adult_net'];
		} else {
			$data['error_tour_adult_net'] = array();
		}
                
		if (isset($this->error['tour_child_net'])) {
			$data['error_tour_child_net'] = $this->error['tour_child_net'];
		} else {
			$data['error_tour_child_net'] = array();
		}
                
		if (isset($this->error['tour_baby_net'])) {
			$data['error_tour_baby_net'] = $this->error['tour_baby_net'];
		} else {
			$data['error_tour_baby_net'] = array();
		}
                
		if (isset($this->error['tour_child_percent'])) {
			$data['error_tour_child_percent'] = $this->error['tour_child_percent'];
		} else {
			$data['error_tour_child_percent'] = array();
		}
                
		if (isset($this->error['tour_baby_percent'])) {
			$data['error_tour_baby_percent'] = $this->error['tour_baby_percent'];
		} else {
			$data['error_tour_baby_percent'] = array();
		}
                
		if (isset($this->error['tour_adult_percent'])) {
			$data['error_tour_adult_percent'] = $this->error['tour_adult_percent'];
		} else {
			$data['error_tour_adult_percent'] = array();
		}
                
		if (isset($this->error['tour_price_discount'])) {
			$data['error_tour_price_discount'] = $this->error['tour_price_discount'];
		} else {
			$data['error_tour_price_discount'] = array();
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
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
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
			'href' => $this->url->link('catalog/tour', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (!isset($this->request->get['tour_id'])) {
			$data['action'] = $this->url->link('catalog/tour/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('catalog/tour/edit', 'token=' . $this->session->data['token'] . '&tour_id=' . $this->request->get['tour_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('catalog/tour', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['tour_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$tour_info = $this->model_catalog_tour->getTour($this->request->get['tour_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['tour_description'])) {
			$data['tour_description'] = $this->request->post['tour_description'];
		} elseif (isset($this->request->get['tour_id'])) {
			$data['tour_description'] = $this->model_catalog_tour->getTourDescriptions($this->request->get['tour_id']);
		} else {
			$data['tour_description'] = array();
		}
                
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($tour_info)) {
			$data['image'] = $tour_info['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($tour_info) && is_file(DIR_IMAGE . $tour_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($tour_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		if (isset($this->request->post['model'])) {
			$data['model'] = $this->request->post['model'];
		} elseif (!empty($tour_info)) {
			$data['model'] = $tour_info['model'];
		} else {
			$data['model'] = '';
		}

		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['tour_store'])) {
			$data['tour_store'] = $this->request->post['tour_store'];
		} elseif (isset($this->request->get['tour_id'])) {
			$data['tour_store'] = $this->model_catalog_tour->getTourStores($this->request->get['tour_id']);
		} else {
			$data['tour_store'] = array(0);
		}

		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($tour_info)) {
			$data['keyword'] = $tour_info['keyword'];
		} else {
			$data['keyword'] = '';
		}

		if (isset($this->request->post['shipping'])) {
			$data['shipping'] = $this->request->post['shipping'];
		} elseif (!empty($tour_info)) {
			$data['shipping'] = $tour_info['shipping'];
		} else {
			$data['shipping'] = 1;
		}

		if (isset($this->request->post['date_available'])) {
			$data['date_available'] = $this->request->post['date_available'];
		} elseif (!empty($tour_info)) {
			$data['date_available'] = ($tour_info['date_available'] != '0000-00-00') ? $tour_info['date_available'] : '';
		} else {
			$data['date_available'] = date('Y-m-d');
		}

		if (isset($this->request->post['quantity'])) {
			$data['quantity'] = $this->request->post['quantity'];
		} elseif (!empty($tour_info)) {
			$data['quantity'] = $tour_info['quantity'];
		} else {
			$data['quantity'] = 1;
		}

		if (isset($this->request->post['minimum'])) {
			$data['minimum'] = $this->request->post['minimum'];
		} elseif (!empty($tour_info)) {
			$data['minimum'] = $tour_info['minimum'];
		} else {
			$data['minimum'] = 1;
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($tour_info)) {
			$data['sort_order'] = $tour_info['sort_order'];
		} else {
			$data['sort_order'] = 1;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($tour_info)) {
			$data['status'] = $tour_info['status'];
		} else {
			$data['status'] = true;
		}

		$this->load->model('catalog/manufacturer');

		if (isset($this->request->post['manufacturer_id'])) {
			$data['manufacturer_id'] = $this->request->post['manufacturer_id'];
		} elseif (!empty($tour_info)) {
			$data['manufacturer_id'] = $tour_info['manufacturer_id'];
		} else {
			$data['manufacturer_id'] = 0;
		}

		if (isset($this->request->post['manufacturer'])) {
			$data['manufacturer'] = $this->request->post['manufacturer'];
		} elseif (!empty($tour_info)) {
			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($tour_info['manufacturer_id']);

			if ($manufacturer_info) {
				$data['manufacturer'] = $manufacturer_info['name'];
			} else {
				$data['manufacturer'] = '';
			}
		} else {
			$data['manufacturer'] = '';
		}

		// Tour Parent
		$this->load->model('catalog/category');
                
		$this->load->model('catalog/tour');

		if (isset($this->request->post['tour_category'])) {
			$categories = $this->request->post['tour_category'];
		} elseif (isset($this->request->get['tour_id'])) {
			$categories = $this->model_catalog_tour->getProductCategories($this->request->get['tour_id']);
		} else {
			$categories = array();
		}

		$data['tour_categories'] = array();

		foreach ($categories as $category_id) {
			$category_info = $this->model_catalog_category->getCategory($category_id);
                        
			if ($category_info) {
				$data['tour_categories'][] = array(
					'category_id' => $category_info['category_id'],
					'name' => $category_info['name']
				);
			}
		}

		// Filters
		$this->load->model('catalog/filter');

		if (isset($this->request->post['tour_filter'])) {
			$filters = $this->request->post['tour_filter'];
		} elseif (isset($this->request->get['tour_id'])) {
			$filters = $this->model_catalog_tour->getTourFilters($this->request->get['tour_id']);
		} else {
			$filters = array();
		}

		$data['tour_filters'] = array();

		foreach ($filters as $filter_id) {
			$filter_info = $this->model_catalog_filter->getFilter($filter_id);

			if ($filter_info) {
				$data['tour_filters'][] = array(
					'filter_id' => $filter_info['filter_id'],
					'name'      => $filter_info['group'] . ' &gt; ' . $filter_info['name']
				);
			}
		}
               
                // Detail
		if (isset($this->request->post['tour_schedule'])) {
			$data['tour_schedules'] = $this->request->post['tour_schedule'];
		} elseif (isset($this->request->get['tour_id'])) {
			$data['tour_schedules'] = $this->model_catalog_tour->getTourSchedules($this->request->get['tour_id']);
		} else {
			$data['tour_schedules'] = array();
		}


		// Price
		$this->load->model('catalog/price');

		if (isset($this->request->post['tour_price'])) {
			$tour_prices = $this->request->post['tour_price'];
		} elseif (isset($this->request->get['tour_id'])) {
			$tour_prices = $this->model_catalog_tour->getTourPrices($this->request->get['tour_id']);
		} else {
			$tour_prices = array();
		}

		$data['tour_prices'] = array();
                
                foreach ($tour_prices as $tour_price) {
                    if(!isset($tour_price['tour_child_percent'])){
                        $tour_price['tour_child_percent'] = 0;
                    }
                    
                    $tour_child_gross = (int)$tour_price['tour_child_net'] + (((int)$tour_price['tour_child_net']/100) * (int)$tour_price['tour_child_percent']);
                    
                    if(!isset($tour_price['tour_baby_percent'])){
                        $tour_price['tour_baby_percent'] = 0;
                    }
                    
                    $tour_baby_gross = (int)$tour_price['tour_baby_net'] + (((int)$tour_price['tour_baby_net']/100) * (int)$tour_price['tour_baby_percent']);
                    
                    if(!isset($tour_price['tour_adult_percent'])){
                        $tour_price['tour_adult_percent'] =0;
                    }
                    
                    $tour_adult_gross = (int)$tour_price['tour_adult_net'] + (((int)$tour_price['tour_adult_net']/100) * (int)$tour_price['tour_adult_percent']);
                    
                    $data['tour_prices'][] = array(
                            'price_id'                   => $tour_price['price_id'],
                            'tour_date'               => $tour_price['tour_date'],
                            'tour_adult_net'          => $tour_price['tour_adult_net'],
                            'tour_adult_percent'      => $tour_price['tour_adult_percent'],
                            'tour_adult_gross'        => $tour_adult_gross,
                            'tour_child_net'          => $tour_price['tour_child_net'],
                            'tour_child_percent'      => $tour_price['tour_child_percent'],
                            'tour_child_gross'        => $tour_child_gross,
                            'tour_baby_net'          => $tour_price['tour_baby_net'],
                            'tour_baby_percent'      => $tour_price['tour_baby_percent'],
                            'tour_baby_gross'        => $tour_baby_gross,
                            'tour_price_discount'     => $tour_price['tour_price_discount']
                    );
		}

		// Images
		if (isset($this->request->post['tour_image'])) {
			$tour_images = $this->request->post['tour_image'];
		} elseif (isset($this->request->get['tour_id'])) {
			$tour_images = $this->model_catalog_tour->getTourImages($this->request->get['tour_id']);
		} else {
			$tour_images = array();
		}

		$data['tour_images'] = array();

		foreach ($tour_images as $tour_image) {
			if (is_file(DIR_IMAGE . $tour_image['image'])) {
				$image = $tour_image['image'];
				$thumb = $tour_image['image'];
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}

			$data['tour_images'][] = array(
				'image'      => $image,
				'thumb'      => $this->model_tool_image->resize($thumb, 100, 100),
				'sort_order' => $tour_image['sort_order']
			);
		}

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/tour_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/tour')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['tour_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}

			if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
			}
		}
                
                if (isset($this->request->post['tour_price'])){
                    foreach ($this->request->post['tour_price'] as $value) {
                            if (!empty($value['tour_adult_net'])){
                                if (!is_numeric($value['tour_adult_net'])) {
                                        $this->error['tour_adult_net'] = $this->language->get('error_tour_adult_net');
                                }
                            }

                            if(!empty($value['tour_adult_percent'])){
                                if (!is_numeric($value['tour_adult_percent'])) {
                                        $this->error['tour_adult_net'] = $this->language->get('error_tour_adult_percent');
                                }
                            }

                            if (!empty($value['tour_child_net'])){
                                if (!is_numeric($value['tour_child_net'])) {
                                        $this->error['tour_child_net'] = $this->language->get('error_tour_child_net');
                                }
                            }

                            if (!empty($value['tour_baby_net'])){
                                if (!is_numeric($value['tour_baby_net'])) {
                                        $this->error['tour_baby_net'] = $this->language->get('error_tour_baby_net');
                                }
                            }

                            if(!empty($value['tour_child_percent'])){
                                if (!is_numeric($value['tour_child_percent'])) {
                                        $this->error['tour_child_percent'] = $this->language->get('error_tour_child_percent');
                                }
                            }

                            if(!empty($value['tour_baby_percent'])){
                                if (!is_numeric($value['tour_baby_percent'])) {
                                        $this->error['tour_baby_percent'] = $this->language->get('error_tour_baby_percent');
                                }
                            }

                            if(!empty($value['tour_price_discount'])){
                                if (!is_numeric($value['tour_price_discount'])) {
                                        $this->error['tour_price_discount'] = $this->language->get('error_tour_price_discount');
                                }
                            }
                    }
                }
                
		if ((utf8_strlen($this->request->post['model']) < 1) || (utf8_strlen($this->request->post['model']) > 64)) {
			$this->error['model'] = $this->language->get('error_model');
		}
		
		if (utf8_strlen($this->request->post['keyword']) > 0) {
			$this->load->model('catalog/url_alias');

			$url_alias_info = $this->model_catalog_url_alias->getUrlAlias($this->request->post['keyword']);

			if ($url_alias_info && isset($this->request->get['tour_id']) && $url_alias_info['query'] != 'tour_id=' . $this->request->get['tour_id']) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}

			if ($url_alias_info && !isset($this->request->get['tour_id'])) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/tour')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateCopy() {
		if (!$this->user->hasPermission('modify', 'catalog/tour')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model'])) {
			$this->load->model('catalog/tour');
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
				'start'        => 0,
				'limit'        => $limit
			);

			$results = $this->model_catalog_tour->getTours($filter_data);

			foreach ($results as $result) {
				$option_data = array();

				$tour_options = $this->model_catalog_tour->getTourOptions($result['tour_id']);

				foreach ($tour_options as $tour_option) {
					$option_info = $this->model_catalog_option->getOption($tour_option['option_id']);

					if ($option_info) {
						$tour_option_value_data = array();

						foreach ($tour_option['tour_option_value'] as $tour_option_value) {
							$option_value_info = $this->model_catalog_option->getOptionValue($tour_option_value['option_value_id']);

							if ($option_value_info) {
								$tour_option_value_data[] = array(
									'tour_option_value_id' => $tour_option_value['tour_option_value_id'],
									'option_value_id'         => $tour_option_value['option_value_id'],
									'name'                    => $option_value_info['name'],
									'price'                   => (float)$tour_option_value['price'] ? $this->currency->format($tour_option_value['price'], $this->config->get('config_currency')) : false,
									'price_prefix'            => $tour_option_value['price_prefix']
								);
							}
						}

						$option_data[] = array(
							'tour_option_id'    => $tour_option['tour_option_id'],
							'tour_option_value' => $tour_option_value_data,
							'option_id'            => $tour_option['option_id'],
							'name'                 => $option_info['name'],
							'type'                 => $option_info['type'],
							'value'                => $tour_option['value'],
							'required'             => $tour_option['required']
						);
					}
				}

				$json[] = array(
					'tour_id' => $result['tour_id'],
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