<?php
class ControllerCatalogRoom extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/room');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/room');

		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/room');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/room');
                
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_room->addRoom($this->request->post);

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
                        
			if (isset($this->request->get['filter_maxadults'])) {
				$url .= '&filter_maxadults=' . $this->request->get['filter_maxadults'];
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

			$this->response->redirect($this->url->link('catalog/room', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/room');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/room');
                
                $this->load->model('user/user');

		$user_info = $this->model_user_user->getUser($this->user->getId());
                
                $user_id = $user_info['user_group_id'];
               
		$room = $this->model_catalog_room->getRoom($this->request->get['room_id']);
                
                if($room['author_id'] == $user_id || $user_id == 1){
                    if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
                            $this->model_catalog_room->editRoom($this->request->get['room_id'], $this->request->post);

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

                            if (isset($this->request->get['filter_maxadults'])) {
                                    $url .= '&filter_maxadults=' . $this->request->get['filter_maxadults'];
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

                            $this->response->redirect($this->url->link('catalog/room', 'token=' . $this->session->data['token'] . $url, 'SSL'));
                    }

                    $this->getForm();
                }else{
                   
                }
	}

	public function delete() {
		$this->load->language('catalog/room');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/room');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $room_id) {
				$this->model_catalog_room->deleteRoom($room_id);
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
                        
			if (isset($this->request->get['filter_maxadults'])) {
				$url .= '&filter_maxadults=' . $this->request->get['filter_maxadults'];
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

			$this->response->redirect($this->url->link('catalog/room', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	public function copy() {
		$this->load->language('catalog/room');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/room');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $room_id) {
				$this->model_catalog_room->copyRoom($room_id);
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
                        
			if (isset($this->request->get['filter_maxadults'])) {
				$url .= '&filter_maxadults=' . $this->request->get['filter_maxadults'];
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

			$this->response->redirect($this->url->link('catalog/room', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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

		if (isset($this->request->get['filter_price'])) {
			$filter_price = $this->request->get['filter_price'];
		} else {
			$filter_price = null;
		}

		if (isset($this->request->get['filter_quantity'])) {
			$filter_quantity = $this->request->get['filter_quantity'];
		} else {
			$filter_quantity = null;
		}

		if (isset($this->request->get['filter_maxadults'])) {
			$filter_maxadults = $this->request->get['filter_maxadults'];
		} else {
			$filter_maxadults = null;
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

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_maxadults'])) {
			$url .= '&filter_maxadults=' . $this->request->get['filter_maxadults'];
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
			'href' => $this->url->link('catalog/room', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['add'] = $this->url->link('catalog/room/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['copy'] = $this->url->link('catalog/room/copy', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('catalog/room/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['rooms'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name,
			'filter_model'	  => $filter_model,
			'filter_price'	  => $filter_price,
			'filter_quantity' => $filter_quantity,
			'filter_maxadults'=> $filter_maxadults,
			'filter_status'   => $filter_status,
                        'filter_user_id'  => $user_id,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);
     
		$this->load->model('tool/image');

		$room_total = $this->model_catalog_room->getTotalRooms($filter_data);

		$results = $this->model_catalog_room->getRooms($filter_data);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}

			$special = false;

			$room_specials = $this->model_catalog_room->getRoomSpecials($result['room_id']);

			foreach ($room_specials  as $room_special) {
				if (($room_special['date_start'] == '0000-00-00' || strtotime($room_special['date_start']) < time()) && ($room_special['date_end'] == '0000-00-00' || strtotime($room_special['date_end']) > time())) {
					$special = $room_special['price'];

					break;
				}
			}

			$data['rooms'][] = array(
				'room_id' => $result['room_id'],
				'image'      => $image,
				'name'       => $result['name'],
				'model'      => $result['model'],
				'price'      => $result['price'],
				'special'    => $special,
				'quantity'   => $result['quantity'],
				'maxadults'   => $result['maxadults'],
				'status'     => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'       => $this->url->link('catalog/room/edit', 'token=' . $this->session->data['token'] . '&room_id=' . $result['room_id'] . $url, 'SSL')
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
		$data['column_price'] = $this->language->get('column_price');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_maxadults'] = $this->language->get('column_maxadults');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_model'] = $this->language->get('entry_model');
		$data['entry_date'] = $this->language->get('entry_date');
		$data['entry_quantity'] = $this->language->get('entry_quantity');
		$data['entry_maxadults'] = $this->language->get('entry_maxadults');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_price'] = $this->language->get('entry_price');

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

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_maxadults'])) {
			$url .= '&filter_maxadults=' . $this->request->get['filter_maxadults'];
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

		$data['sort_name'] = $this->url->link('catalog/room', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, 'SSL');
		$data['sort_model'] = $this->url->link('catalog/room', 'token=' . $this->session->data['token'] . '&sort=p.model' . $url, 'SSL');
		$data['sort_price'] = $this->url->link('catalog/room', 'token=' . $this->session->data['token'] . '&sort=p.price' . $url, 'SSL');
		$data['sort_quantity'] = $this->url->link('catalog/room', 'token=' . $this->session->data['token'] . '&sort=p.quantity' . $url, 'SSL');
		$data['sort_maxadults'] = $this->url->link('catalog/room', 'token=' . $this->session->data['token'] . '&sort=p.maxadults' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('catalog/room', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, 'SSL');
		$data['sort_order'] = $this->url->link('catalog/room', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, 'SSL');

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

		if (isset($this->request->get['filter_maxadults'])) {
			$url .= '&filter_maxadults=' . $this->request->get['filter_maxadults'];
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
		$pagination->total = $room_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/room', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($room_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($room_total - $this->config->get('config_limit_admin'))) ? $room_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $room_total, ceil($room_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;
		$data['filter_model'] = $filter_model;
		$data['filter_price'] = $filter_price;
		$data['filter_quantity'] = $filter_quantity;
		$data['filter_maxadults'] = $filter_maxadults;
		$data['filter_status'] = $filter_status;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/room_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_form'] = !isset($this->request->get['room_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
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
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_keyword'] = $this->language->get('entry_keyword');
		$data['entry_model'] = $this->language->get('entry_model');
		$data['entry_sku'] = $this->language->get('entry_sku');
		$data['entry_upc'] = $this->language->get('entry_upc');
		$data['entry_ean'] = $this->language->get('entry_ean');
		$data['entry_jan'] = $this->language->get('entry_jan');
		$data['entry_isbn'] = $this->language->get('entry_isbn');
		$data['entry_mpn'] = $this->language->get('entry_mpn');
		$data['entry_location'] = $this->language->get('entry_location');
		$data['entry_minimum'] = $this->language->get('entry_minimum');
		$data['entry_shipping'] = $this->language->get('entry_shipping');
		$data['entry_date_available'] = $this->language->get('entry_date_available');
		$data['entry_quantity'] = $this->language->get('entry_quantity');
		$data['entry_maxadults'] = $this->language->get('entry_maxadults');
		$data['entry_stock_status'] = $this->language->get('entry_stock_status');
		$data['entry_price'] = $this->language->get('entry_price');
		$data['entry_date'] = $this->language->get('entry_date');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_points'] = $this->language->get('entry_points');
		$data['entry_option_points'] = $this->language->get('entry_option_points');
		$data['entry_subtract'] = $this->language->get('entry_subtract');
		$data['entry_weight_class'] = $this->language->get('entry_weight_class');
		$data['entry_weight'] = $this->language->get('entry_weight');
		$data['entry_dimension'] = $this->language->get('entry_dimension');
		$data['entry_length_class'] = $this->language->get('entry_length_class');
		$data['entry_length'] = $this->language->get('entry_length');
		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_height'] = $this->language->get('entry_height');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
		$data['entry_download'] = $this->language->get('entry_download');
		$data['entry_hotel'] = $this->language->get('entry_hotel');
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
		$data['entry_price'] = $this->language->get('entry_price');
		$data['entry_price_net'] = $this->language->get('entry_price_net');
		$data['entry_price_percent'] = $this->language->get('entry_price_percent');
		$data['entry_price_gross'] = $this->language->get('entry_price_gross');
		$data['entry_extra_net'] = $this->language->get('entry_extra_net');
		$data['entry_extra_percent'] = $this->language->get('entry_extra_percent');
		$data['entry_extra_gross'] = $this->language->get('entry_extra_gross');
		$data['entry_discount'] = $this->language->get('entry_discount');

		$data['help_keyword'] = $this->language->get('help_keyword');
		$data['help_sku'] = $this->language->get('help_sku');
		$data['help_upc'] = $this->language->get('help_upc');
		$data['help_ean'] = $this->language->get('help_ean');
		$data['help_jan'] = $this->language->get('help_jan');
		$data['help_isbn'] = $this->language->get('help_isbn');
		$data['help_mpn'] = $this->language->get('help_mpn');
		$data['help_minimum'] = $this->language->get('help_minimum');
		$data['help_maxadults'] = $this->language->get('help_maxadults');
		$data['help_manufacturer'] = $this->language->get('help_manufacturer');
		$data['help_stock_status'] = $this->language->get('help_stock_status');
		$data['help_points'] = $this->language->get('help_points');
		$data['help_hotel'] = $this->language->get('help_hotel');
		$data['help_filter'] = $this->language->get('help_filter');
		$data['help_download'] = $this->language->get('help_download');
		$data['help_related'] = $this->language->get('help_related');
		$data['help_tag'] = $this->language->get('help_tag');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_attribute_add'] = $this->language->get('button_attribute_add');
		$data['button_price_add'] = $this->language->get('button_price_add');
		$data['button_option_add'] = $this->language->get('button_option_add');
		$data['button_option_value_add'] = $this->language->get('button_option_value_add');
		$data['button_discount_add'] = $this->language->get('button_discount_add');
		$data['button_special_add'] = $this->language->get('button_special_add');
		$data['button_image_add'] = $this->language->get('button_image_add');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_recurring_add'] = $this->language->get('button_recurring_add');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_data'] = $this->language->get('tab_data');
		$data['tab_attribute'] = $this->language->get('tab_attribute');
		$data['tab_price'] = $this->language->get('tab_price');
		$data['tab_option'] = $this->language->get('tab_option');
		$data['tab_recurring'] = $this->language->get('tab_recurring');
		$data['tab_discount'] = $this->language->get('tab_discount');
		$data['tab_special'] = $this->language->get('tab_special');
		$data['tab_image'] = $this->language->get('tab_image');
		$data['tab_links'] = $this->language->get('tab_links');
		$data['tab_reward'] = $this->language->get('tab_reward');
		$data['tab_design'] = $this->language->get('tab_design');
		$data['tab_openbay'] = $this->language->get('tab_openbay');

                $this->load->model('user/user');

		$user_info = $this->model_user_user->getUser($this->user->getId());
                
                $user_id = $user_info['user_group_id'];
                
                $data['author_id'] = $user_id;
                
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['room_price_net'])) {
			$data['error_room_price_net'] = $this->error['room_price_net'];
		} else {
			$data['error_room_price_net'] = array();
		}
                
		if (isset($this->error['room_extra_net'])) {
			$data['error_room_extra_net'] = $this->error['room_extra_net'];
		} else {
			$data['error_room_extra_net'] = array();
		}
                
		if (isset($this->error['room_extra_percent'])) {
			$data['error_room_extra_percent'] = $this->error['room_extra_percent'];
		} else {
			$data['error_room_extra_percent'] = array();
		}
                
		if (isset($this->error['room_price_percent'])) {
			$data['error_room_price_percent'] = $this->error['room_price_percent'];
		} else {
			$data['error_room_price_percent'] = array();
		}
                
		if (isset($this->error['room_price_discount'])) {
			$data['error_room_price_discount'] = $this->error['room_price_discount'];
		} else {
			$data['error_room_price_discount'] = array();
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

		if (isset($this->request->get['filter_maxadults'])) {
			$url .= '&filter_maxadults=' . $this->request->get['filter_maxadults'];
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
			'href' => $this->url->link('catalog/room', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (!isset($this->request->get['room_id'])) {
			$data['action'] = $this->url->link('catalog/room/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('catalog/room/edit', 'token=' . $this->session->data['token'] . '&room_id=' . $this->request->get['room_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('catalog/room', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['room_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$room_info = $this->model_catalog_room->getRoom($this->request->get['room_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['room_description'])) {
			$data['room_description'] = $this->request->post['room_description'];
		} elseif (isset($this->request->get['room_id'])) {
			$data['room_description'] = $this->model_catalog_room->getRoomDescriptions($this->request->get['room_id']);
		} else {
			$data['room_description'] = array();
		}

		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($room_info)) {
			$data['image'] = $room_info['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($room_info) && is_file(DIR_IMAGE . $room_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($room_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		if (isset($this->request->post['model'])) {
			$data['model'] = $this->request->post['model'];
		} elseif (!empty($room_info)) {
			$data['model'] = $room_info['model'];
		} else {
			$data['model'] = '';
		}

		if (isset($this->request->post['sku'])) {
			$data['sku'] = $this->request->post['sku'];
		} elseif (!empty($room_info)) {
			$data['sku'] = $room_info['sku'];
		} else {
			$data['sku'] = '';
		}

		if (isset($this->request->post['upc'])) {
			$data['upc'] = $this->request->post['upc'];
		} elseif (!empty($room_info)) {
			$data['upc'] = $room_info['upc'];
		} else {
			$data['upc'] = '';
		}

		if (isset($this->request->post['ean'])) {
			$data['ean'] = $this->request->post['ean'];
		} elseif (!empty($room_info)) {
			$data['ean'] = $room_info['ean'];
		} else {
			$data['ean'] = '';
		}

		if (isset($this->request->post['jan'])) {
			$data['jan'] = $this->request->post['jan'];
		} elseif (!empty($room_info)) {
			$data['jan'] = $room_info['jan'];
		} else {
			$data['jan'] = '';
		}

		if (isset($this->request->post['isbn'])) {
			$data['isbn'] = $this->request->post['isbn'];
		} elseif (!empty($room_info)) {
			$data['isbn'] = $room_info['isbn'];
		} else {
			$data['isbn'] = '';
		}

		if (isset($this->request->post['mpn'])) {
			$data['mpn'] = $this->request->post['mpn'];
		} elseif (!empty($room_info)) {
			$data['mpn'] = $room_info['mpn'];
		} else {
			$data['mpn'] = '';
		}

		if (isset($this->request->post['location'])) {
			$data['location'] = $this->request->post['location'];
		} elseif (!empty($room_info)) {
			$data['location'] = $room_info['location'];
		} else {
			$data['location'] = '';
		}

		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['room_store'])) {
			$data['room_store'] = $this->request->post['room_store'];
		} elseif (isset($this->request->get['room_id'])) {
			$data['room_store'] = $this->model_catalog_room->getRoomStores($this->request->get['room_id']);
		} else {
			$data['room_store'] = array(0);
		}

		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($room_info)) {
			$data['keyword'] = $room_info['keyword'];
		} else {
			$data['keyword'] = '';
		}

		if (isset($this->request->post['shipping'])) {
			$data['shipping'] = $this->request->post['shipping'];
		} elseif (!empty($room_info)) {
			$data['shipping'] = $room_info['shipping'];
		} else {
			$data['shipping'] = 1;
		}

		if (isset($this->request->post['price'])) {
			$data['price'] = $this->request->post['price'];
		} elseif (!empty($room_info)) {
			$data['price'] = $room_info['price'];
		} else {
			$data['price'] = '';
		}

		$this->load->model('catalog/recurring');

		$data['recurrings'] = $this->model_catalog_recurring->getRecurrings();

		if (isset($this->request->post['room_recurrings'])) {
			$data['room_recurrings'] = $this->request->post['room_recurrings'];
		} elseif (!empty($room_info)) {
			$data['room_recurrings'] = $this->model_catalog_room->getRecurrings($room_info['room_id']);
		} else {
			$data['room_recurrings'] = array();
		}

		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['tax_class_id'])) {
			$data['tax_class_id'] = $this->request->post['tax_class_id'];
		} elseif (!empty($room_info)) {
			$data['tax_class_id'] = $room_info['tax_class_id'];
		} else {
			$data['tax_class_id'] = 0;
		}

		if (isset($this->request->post['date_available'])) {
			$data['date_available'] = $this->request->post['date_available'];
		} elseif (!empty($room_info)) {
			$data['date_available'] = ($room_info['date_available'] != '0000-00-00') ? $room_info['date_available'] : '';
		} else {
			$data['date_available'] = date('Y-m-d');
		}

		if (isset($this->request->post['quantity'])) {
			$data['quantity'] = $this->request->post['quantity'];
		} elseif (!empty($room_info)) {
			$data['quantity'] = $room_info['quantity'];
		} else {
			$data['quantity'] = 1;
		}

		if (isset($this->request->post['maxadults'])) {
			$data['maxadults'] = $this->request->post['maxadults'];
		} elseif (!empty($room_info)) {
			$data['maxadults'] = $room_info['maxadults'];
		} else {
			$data['maxadults'] = 1;
		}

		if (isset($this->request->post['minimum'])) {
			$data['minimum'] = $this->request->post['minimum'];
		} elseif (!empty($room_info)) {
			$data['minimum'] = $room_info['minimum'];
		} else {
			$data['minimum'] = 1;
		}

		if (isset($this->request->post['subtract'])) {
			$data['subtract'] = $this->request->post['subtract'];
		} elseif (!empty($room_info)) {
			$data['subtract'] = $room_info['subtract'];
		} else {
			$data['subtract'] = 1;
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($room_info)) {
			$data['sort_order'] = $room_info['sort_order'];
		} else {
			$data['sort_order'] = 1;
		}

		$this->load->model('localisation/stock_status');

		$data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();

		if (isset($this->request->post['stock_status_id'])) {
			$data['stock_status_id'] = $this->request->post['stock_status_id'];
		} elseif (!empty($room_info)) {
			$data['stock_status_id'] = $room_info['stock_status_id'];
		} else {
			$data['stock_status_id'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($room_info)) {
			$data['status'] = $room_info['status'];
		} else {
			$data['status'] = true;
		}

		if (isset($this->request->post['weight'])) {
			$data['weight'] = $this->request->post['weight'];
		} elseif (!empty($room_info)) {
			$data['weight'] = $room_info['weight'];
		} else {
			$data['weight'] = '';
		}

		$this->load->model('localisation/weight_class');

		$data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

		if (isset($this->request->post['weight_class_id'])) {
			$data['weight_class_id'] = $this->request->post['weight_class_id'];
		} elseif (!empty($room_info)) {
			$data['weight_class_id'] = $room_info['weight_class_id'];
		} else {
			$data['weight_class_id'] = $this->config->get('config_weight_class_id');
		}

		if (isset($this->request->post['length'])) {
			$data['length'] = $this->request->post['length'];
		} elseif (!empty($room_info)) {
			$data['length'] = $room_info['length'];
		} else {
			$data['length'] = '';
		}

		if (isset($this->request->post['width'])) {
			$data['width'] = $this->request->post['width'];
		} elseif (!empty($room_info)) {
			$data['width'] = $room_info['width'];
		} else {
			$data['width'] = '';
		}

		if (isset($this->request->post['height'])) {
			$data['height'] = $this->request->post['height'];
		} elseif (!empty($room_info)) {
			$data['height'] = $room_info['height'];
		} else {
			$data['height'] = '';
		}

		$this->load->model('localisation/length_class');

		$data['length_classes'] = $this->model_localisation_length_class->getLengthClasses();

		if (isset($this->request->post['length_class_id'])) {
			$data['length_class_id'] = $this->request->post['length_class_id'];
		} elseif (!empty($room_info)) {
			$data['length_class_id'] = $room_info['length_class_id'];
		} else {
			$data['length_class_id'] = $this->config->get('config_length_class_id');
		}

		$this->load->model('catalog/manufacturer');

		if (isset($this->request->post['manufacturer_id'])) {
			$data['manufacturer_id'] = $this->request->post['manufacturer_id'];
		} elseif (!empty($room_info)) {
			$data['manufacturer_id'] = $room_info['manufacturer_id'];
		} else {
			$data['manufacturer_id'] = 0;
		}

		if (isset($this->request->post['manufacturer'])) {
			$data['manufacturer'] = $this->request->post['manufacturer'];
		} elseif (!empty($room_info)) {
			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($room_info['manufacturer_id']);

			if ($manufacturer_info) {
				$data['manufacturer'] = $manufacturer_info['name'];
			} else {
				$data['manufacturer'] = '';
			}
		} else {
			$data['manufacturer'] = '';
		}

		// Room Parent
		$this->load->model('catalog/hotel');

		if (isset($this->request->post['room_hotel'])) {
			$hotels = $this->request->post['room_hotel'];
		} elseif (isset($this->request->get['room_id'])) {
			$hotels = $this->model_catalog_room->getProductHotels($this->request->get['room_id']);
		} else {
			$hotels = array();
		}

		$data['room_hotels'] = array();

		foreach ($hotels as $hotel_id) {
			$hotel_info = $this->model_catalog_hotel->getHotel($hotel_id);
                        
			if ($hotel_info) {
				$data['room_hotels'][] = array(
					'hotel_id' => $hotel_info['hotel_id'],
					'name' => $hotel_info['name']
				);
			}
		}

		// Filters
		$this->load->model('catalog/filter');

		if (isset($this->request->post['room_filter'])) {
			$filters = $this->request->post['room_filter'];
		} elseif (isset($this->request->get['room_id'])) {
			$filters = $this->model_catalog_room->getRoomFilters($this->request->get['room_id']);
		} else {
			$filters = array();
		}

		$data['room_filters'] = array();

		foreach ($filters as $filter_id) {
			$filter_info = $this->model_catalog_filter->getFilter($filter_id);

			if ($filter_info) {
				$data['room_filters'][] = array(
					'filter_id' => $filter_info['filter_id'],
					'name'      => $filter_info['group'] . ' &gt; ' . $filter_info['name']
				);
			}
		}

		// Attributes
		$this->load->model('catalog/attribute');

		if (isset($this->request->post['room_attribute'])) {
			$room_attributes = $this->request->post['room_attribute'];
		} elseif (isset($this->request->get['room_id'])) {
			$room_attributes = $this->model_catalog_room->getRoomAttributes($this->request->get['room_id']);
		} else {
			$room_attributes = array();
		}

		$data['room_attributes'] = array();

		foreach ($room_attributes as $room_attribute) {
			$attribute_info = $this->model_catalog_attribute->getAttribute($room_attribute['attribute_id']);

			if ($attribute_info) {
				$data['room_attributes'][] = array(
					'attribute_id'                  => $room_attribute['attribute_id'],
					'name'                          => $attribute_info['name'],
					'room_attribute_description' => $room_attribute['room_attribute_description']
				);
			}
		}
                
		// Price
		$this->load->model('catalog/price');

		if (isset($this->request->post['room_price'])) {
			$room_prices = $this->request->post['room_price'];
		} elseif (isset($this->request->get['room_id'])) {
			$room_prices = $this->model_catalog_room->getRoomPrices($this->request->get['room_id']);
		} else {
			$room_prices = array();
		}

		$data['room_prices'] = array();
                
                foreach ($room_prices as $room_price) {
                    if(!isset($room_price['room_extra_percent'])){
                        $room_price['room_extra_percent'] = 0;
                    }
                    $room_extra_gross = (int)$room_price['room_extra_net'] + (((int)$room_price['room_extra_net']/100) * (int)$room_price['room_extra_percent']);
                    
                    if(!isset($room_price['room_price_percent'])){
                        $room_price['room_price_percent'] =0;
                    }
                    $room_price_gross = (int)$room_price['room_price_net'] + (((int)$room_price['room_price_net']/100) * (int)$room_price['room_price_percent']);
                    
			$data['room_prices'][] = array(
				'price_id'                   => $room_price['price_id'],
				'room_date'               => $room_price['room_date'],
				'room_price_net'          => $room_price['room_price_net'],
				'room_price_percent'      => $room_price['room_price_percent'],
				'room_price_gross'        => $room_price_gross,
				'room_extra_net'          => $room_price['room_extra_net'],
				'room_extra_percent'      => $room_price['room_extra_percent'],
				'room_extra_gross'        => $room_extra_gross,
				'room_price_discount'     => $room_price['room_price_discount']
			);
		}

		// Options
		$this->load->model('catalog/option');

		if (isset($this->request->post['room_option'])) {
			$room_options = $this->request->post['room_option'];
		} elseif (isset($this->request->get['room_id'])) {
			$room_options = $this->model_catalog_room->getRoomOptions($this->request->get['room_id']);
		} else {
			$room_options = array();
		}

		$data['room_options'] = array();

		foreach ($room_options as $room_option) {
			$room_option_value_data = array();

			if (isset($room_option['room_option_value'])) {
				foreach ($room_option['room_option_value'] as $room_option_value) {
					$room_option_value_data[] = array(
						'room_option_value_id' => $room_option_value['room_option_value_id'],
						'option_value_id'         => $room_option_value['option_value_id'],
						'quantity'                => $room_option_value['quantity'],
						'maxadults'               => $room_option_value['maxadults'],
						'subtract'                => $room_option_value['subtract'],
						'price'                   => $room_option_value['price'],
						'price_prefix'            => $room_option_value['price_prefix'],
						'points'                  => $room_option_value['points'],
						'points_prefix'           => $room_option_value['points_prefix'],
						'weight'                  => $room_option_value['weight'],
						'weight_prefix'           => $room_option_value['weight_prefix']
					);
				}
			}

			$data['room_options'][] = array(
				'room_option_id'    => $room_option['room_option_id'],
				'room_option_value' => $room_option_value_data,
				'option_id'            => $room_option['option_id'],
				'name'                 => $room_option['name'],
				'type'                 => $room_option['type'],
				'value'                => isset($room_option['value']) ? $room_option['value'] : '',
				'required'             => $room_option['required']
			);
		}

		$data['option_values'] = array();

		foreach ($data['room_options'] as $room_option) {
			if ($room_option['type'] == 'select' || $room_option['type'] == 'radio' || $room_option['type'] == 'checkbox' || $room_option['type'] == 'image') {
				if (!isset($data['option_values'][$room_option['option_id']])) {
					$data['option_values'][$room_option['option_id']] = $this->model_catalog_option->getOptionValues($room_option['option_id']);
				}
			}
		}

		$this->load->model('sale/customer_group');

		$data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();

		if (isset($this->request->post['room_discount'])) {
			$room_discounts = $this->request->post['room_discount'];
		} elseif (isset($this->request->get['room_id'])) {
			$room_discounts = $this->model_catalog_room->getRoomDiscounts($this->request->get['room_id']);
		} else {
			$room_discounts = array();
		}

		$data['room_discounts'] = array();

		foreach ($room_discounts as $room_discount) {
			$data['room_discounts'][] = array(
				'customer_group_id' => $room_discount['customer_group_id'],
				'quantity'          => $room_discount['quantity'],
				'maxadults'          => $room_discount['maxadults'],
				'priority'          => $room_discount['priority'],
				'price'             => $room_discount['price'],
				'date_start'        => ($room_discount['date_start'] != '0000-00-00') ? $room_discount['date_start'] : '',
				'date_end'          => ($room_discount['date_end'] != '0000-00-00') ? $room_discount['date_end'] : ''
			);
		}

		if (isset($this->request->post['room_special'])) {
			$room_specials = $this->request->post['room_special'];
		} elseif (isset($this->request->get['room_id'])) {
			$room_specials = $this->model_catalog_room->getRoomSpecials($this->request->get['room_id']);
		} else {
			$room_specials = array();
		}

		$data['room_specials'] = array();

		foreach ($room_specials as $room_special) {
			$data['room_specials'][] = array(
				'customer_group_id' => $room_special['customer_group_id'],
				'priority'          => $room_special['priority'],
				'price'             => $room_special['price'],
				'date_start'        => ($room_special['date_start'] != '0000-00-00') ? $room_special['date_start'] : '',
				'date_end'          => ($room_special['date_end'] != '0000-00-00') ? $room_special['date_end'] :  ''
			);
		}

		// Images
		if (isset($this->request->post['room_image'])) {
			$room_images = $this->request->post['room_image'];
		} elseif (isset($this->request->get['room_id'])) {
			$room_images = $this->model_catalog_room->getRoomImages($this->request->get['room_id']);
		} else {
			$room_images = array();
		}

		$data['room_images'] = array();

		foreach ($room_images as $room_image) {
			if (is_file(DIR_IMAGE . $room_image['image'])) {
				$image = $room_image['image'];
				$thumb = $room_image['image'];
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}

			$data['room_images'][] = array(
				'image'      => $image,
				'thumb'      => $this->model_tool_image->resize($thumb, 100, 100),
				'sort_order' => $room_image['sort_order']
			);
		}

		// Downloads
		$this->load->model('catalog/download');

		if (isset($this->request->post['room_download'])) {
			$room_downloads = $this->request->post['room_download'];
		} elseif (isset($this->request->get['room_id'])) {
			$room_downloads = $this->model_catalog_room->getRoomDownloads($this->request->get['room_id']);
		} else {
			$room_downloads = array();
		}

		$data['room_downloads'] = array();

		foreach ($room_downloads as $download_id) {
			$download_info = $this->model_catalog_download->getDownload($download_id);

			if ($download_info) {
				$data['room_downloads'][] = array(
					'download_id' => $download_info['download_id'],
					'name'        => $download_info['name']
				);
			}
		}

		if (isset($this->request->post['room_related'])) {
			$rooms = $this->request->post['room_related'];
		} elseif (isset($this->request->get['room_id'])) {
			$rooms = $this->model_catalog_room->getRoomRelated($this->request->get['room_id']);
		} else {
			$rooms = array();
		}

		$data['room_relateds'] = array();

		foreach ($rooms as $room_id) {
			$related_info = $this->model_catalog_room->getRoom($room_id);

			if ($related_info) {
				$data['room_relateds'][] = array(
					'room_id' => $related_info['room_id'],
					'name'       => $related_info['name']
				);
			}
		}

		if (isset($this->request->post['points'])) {
			$data['points'] = $this->request->post['points'];
		} elseif (!empty($room_info)) {
			$data['points'] = $room_info['points'];
		} else {
			$data['points'] = '';
		}

		if (isset($this->request->post['room_reward'])) {
			$data['room_reward'] = $this->request->post['room_reward'];
		} elseif (isset($this->request->get['room_id'])) {
			$data['room_reward'] = $this->model_catalog_room->getRoomRewards($this->request->get['room_id']);
		} else {
			$data['room_reward'] = array();
		}

		if (isset($this->request->post['room_layout'])) {
			$data['room_layout'] = $this->request->post['room_layout'];
		} elseif (isset($this->request->get['room_id'])) {
			$data['room_layout'] = $this->model_catalog_room->getRoomLayouts($this->request->get['room_id']);
		} else {
			$data['room_layout'] = array();
		}

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/room_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/room')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['room_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}

			if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
			}
		}
                
		foreach ($this->request->post['room_price'] as $value) {
			if (!is_numeric($value['room_price_net'])) {
				$this->error['room_price_net'] = $this->language->get('error_room_price_net');
			}
                        if(!empty($value['room_price_percent'])){
                            if (!is_numeric($value['room_price_percent'])) {
                                    $this->error['room_price_net'] = $this->language->get('error_room_price_percent');
                            }
                        }
			if (!is_numeric($value['room_extra_net'])) {
				$this->error['room_extra_net'] = $this->language->get('error_room_extra_net');
			}
                        if(!empty($value['room_extra_percent'])){
                            if (!is_numeric($value['room_extra_percent'])) {
                                    $this->error['room_extra_percent'] = $this->language->get('error_room_extra_percent');
                            }
                        }
                        if(!empty($value['room_price_discount'])){
                            if (!is_numeric($value['room_price_discount'])) {
                                    $this->error['room_price_discount'] = $this->language->get('error_room_price_discount');
                            }
                        }
		}

		if ((utf8_strlen($this->request->post['model']) < 1) || (utf8_strlen($this->request->post['model']) > 64)) {
			$this->error['model'] = $this->language->get('error_model');
		}
		
		if (utf8_strlen($this->request->post['keyword']) > 0) {
			$this->load->model('catalog/url_alias');

			$url_alias_info = $this->model_catalog_url_alias->getUrlAlias($this->request->post['keyword']);

			if ($url_alias_info && isset($this->request->get['room_id']) && $url_alias_info['query'] != 'room_id=' . $this->request->get['room_id']) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}

			if ($url_alias_info && !isset($this->request->get['room_id'])) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/room')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateCopy() {
		if (!$this->user->hasPermission('modify', 'catalog/room')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model'])) {
			$this->load->model('catalog/room');
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

			$results = $this->model_catalog_room->getRooms($filter_data);

			foreach ($results as $result) {
				$option_data = array();

				$room_options = $this->model_catalog_room->getRoomOptions($result['room_id']);

				foreach ($room_options as $room_option) {
					$option_info = $this->model_catalog_option->getOption($room_option['option_id']);

					if ($option_info) {
						$room_option_value_data = array();

						foreach ($room_option['room_option_value'] as $room_option_value) {
							$option_value_info = $this->model_catalog_option->getOptionValue($room_option_value['option_value_id']);

							if ($option_value_info) {
								$room_option_value_data[] = array(
									'room_option_value_id' => $room_option_value['room_option_value_id'],
									'option_value_id'         => $room_option_value['option_value_id'],
									'name'                    => $option_value_info['name'],
									'price'                   => (float)$room_option_value['price'] ? $this->currency->format($room_option_value['price'], $this->config->get('config_currency')) : false,
									'price_prefix'            => $room_option_value['price_prefix']
								);
							}
						}

						$option_data[] = array(
							'room_option_id'    => $room_option['room_option_id'],
							'room_option_value' => $room_option_value_data,
							'option_id'            => $room_option['option_id'],
							'name'                 => $option_info['name'],
							'type'                 => $option_info['type'],
							'value'                => $room_option['value'],
							'required'             => $room_option['required']
						);
					}
				}

				$json[] = array(
					'room_id' => $result['room_id'],
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