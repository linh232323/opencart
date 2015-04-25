<?php
class ControllerCatalogProParent extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/proparent');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/proparent');

		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/proparent');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/proparent');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_proparent->addProparent($this->request->post);

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

			$this->response->redirect($this->url->link('catalog/proparent', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/proparent');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/proparent');
                
                $this->load->model('user/user');
                 
                $user_info = $this->model_user_user->getUser($this->user->getId());
                
                $user_id = $user_info['user_group_id'];
               
		$product = $this->model_catalog_proparent->getProparent($this->request->get['proparent_id']);
                
                if(isset($product['author_id'])){
                    if($product['author_id'] == $user_id || $user_id == 1){
                        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
                                $this->model_catalog_proparent->editProparent($this->request->get['proparent_id'], $this->request->post);

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

                                $this->response->redirect($this->url->link('catalog/proparent', 'token=' . $this->session->data['token'] . $url, 'SSL'));
                        }

                        $this->getForm();
                    }
                }
	}

	public function delete() {
		$this->load->language('catalog/proparent');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/proparent');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $proparent_id) {
				$this->model_catalog_proparent->deleteProparent($proparent_id);
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

			$this->response->redirect($this->url->link('catalog/proparent', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	public function copy() {
		$this->load->language('catalog/proparent');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/proparent');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $proparent_id) {
				$this->model_catalog_proparent->copyProparent($proparent_id);
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

			$this->response->redirect($this->url->link('catalog/proparent', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
			'href' => $this->url->link('catalog/proparent', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['add'] = $this->url->link('catalog/proparent/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['copy'] = $this->url->link('catalog/proparent/copy', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('catalog/proparent/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['proparents'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name,
			'filter_model'	  => $filter_model,
			'filter_price'	  => $filter_price,
			'filter_quantity' => $filter_quantity,
			'filter_status'   => $filter_status,
			'filter_user_id'  => $user_id,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);

		$this->load->model('tool/image');

		$proparent_total = $this->model_catalog_proparent->getTotalProparents($filter_data);

		$results = $this->model_catalog_proparent->getProparents($filter_data);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}

			$special = false;

			$proparent_specials = $this->model_catalog_proparent->getProparentSpecials($result['proparent_id']);

			foreach ($proparent_specials  as $proparent_special) {
				if (($proparent_special['date_start'] == '0000-00-00' || strtotime($proparent_special['date_start']) < time()) && ($proparent_special['date_end'] == '0000-00-00' || strtotime($proparent_special['date_end']) > time())) {
					$special = $proparent_special['price'];

					break;
				}
			}

			$data['proparents'][] = array(
				'proparent_id' => $result['proparent_id'],
				'image'      => $image,
				'name'       => $result['name'],
				'model'      => $result['model'],
				'price'      => $result['price'],
				'special'    => $special,
				'quantity'   => $result['quantity'],
				'status'     => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'       => $this->url->link('catalog/proparent/edit', 'token=' . $this->session->data['token'] . '&proparent_id=' . $result['proparent_id'] . $url, 'SSL')
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
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_model'] = $this->language->get('entry_model');
		$data['entry_price'] = $this->language->get('entry_price');
		$data['entry_quantity'] = $this->language->get('entry_quantity');
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

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
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

		$data['sort_name'] = $this->url->link('catalog/proparent', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, 'SSL');
		$data['sort_model'] = $this->url->link('catalog/proparent', 'token=' . $this->session->data['token'] . '&sort=p.model' . $url, 'SSL');
		$data['sort_price'] = $this->url->link('catalog/proparent', 'token=' . $this->session->data['token'] . '&sort=p.price' . $url, 'SSL');
		$data['sort_quantity'] = $this->url->link('catalog/proparent', 'token=' . $this->session->data['token'] . '&sort=p.quantity' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('catalog/proparent', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, 'SSL');
		$data['sort_order'] = $this->url->link('catalog/proparent', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, 'SSL');

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

		$pagination = new Pagination();
		$pagination->total = $proparent_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/proparent', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($proparent_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($proparent_total - $this->config->get('config_limit_admin'))) ? $proparent_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $proparent_total, ceil($proparent_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;
		$data['filter_model'] = $filter_model;
		$data['filter_price'] = $filter_price;
		$data['filter_quantity'] = $filter_quantity;
		$data['filter_status'] = $filter_status;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/proparent_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_form'] = !isset($this->request->get['proparent_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
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
		$data['entry_sku'] = $this->language->get('entry_sku');
		$data['entry_upc'] = $this->language->get('entry_upc');
		$data['entry_ean'] = $this->language->get('entry_ean');
		$data['entry_jan'] = $this->language->get('entry_jan');
		$data['entry_isbn'] = $this->language->get('entry_isbn');
		$data['entry_mpn'] = $this->language->get('entry_mpn');
		$data['entry_location'] = $this->language->get('entry_location');
		$data['entry_minimum'] = $this->language->get('entry_minimum');
		$data['entry_shipping'] = $this->language->get('entry_shipping');
		$data['entry_star'] = $this->language->get('entry_star');
		$data['entry_date_available'] = $this->language->get('entry_date_available');
		$data['entry_quantity'] = $this->language->get('entry_quantity');
		$data['entry_stock_status'] = $this->language->get('entry_stock_status');
		$data['entry_price'] = $this->language->get('entry_price');
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
		$data['help_sku'] = $this->language->get('help_sku');
		$data['help_upc'] = $this->language->get('help_upc');
		$data['help_ean'] = $this->language->get('help_ean');
		$data['help_jan'] = $this->language->get('help_jan');
		$data['help_isbn'] = $this->language->get('help_isbn');
		$data['help_mpn'] = $this->language->get('help_mpn');
		$data['help_minimum'] = $this->language->get('help_minimum');
		$data['help_manufacturer'] = $this->language->get('help_manufacturer');
		$data['help_stock_status'] = $this->language->get('help_stock_status');
		$data['help_points'] = $this->language->get('help_points');
		$data['help_category'] = $this->language->get('help_category');
		$data['help_filter'] = $this->language->get('help_filter');
		$data['help_download'] = $this->language->get('help_download');
		$data['help_related'] = $this->language->get('help_related');
		$data['help_tag'] = $this->language->get('help_tag');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_attribute_add'] = $this->language->get('button_attribute_add');
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
		$data['tab_option'] = $this->language->get('tab_option');
		$data['tab_recurring'] = $this->language->get('tab_recurring');
		$data['tab_discount'] = $this->language->get('tab_discount');
		$data['tab_special'] = $this->language->get('tab_special');
		$data['tab_image'] = $this->language->get('tab_image');
		$data['tab_links'] = $this->language->get('tab_links');
		$data['tab_reward'] = $this->language->get('tab_reward');
		$data['tab_design'] = $this->language->get('tab_design');
		$data['tab_openbay'] = $this->language->get('tab_openbay');
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
			'href' => $this->url->link('catalog/proparent', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (!isset($this->request->get['proparent_id'])) {
			$data['action'] = $this->url->link('catalog/proparent/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('catalog/proparent/edit', 'token=' . $this->session->data['token'] . '&proparent_id=' . $this->request->get['proparent_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('catalog/proparent', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['proparent_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$proparent_info = $this->model_catalog_proparent->getProparent($this->request->get['proparent_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['proparent_description'])) {
			$data['proparent_description'] = $this->request->post['proparent_description'];
		} elseif (isset($this->request->get['proparent_id'])) {
			$data['proparent_description'] = $this->model_catalog_proparent->getProparentDescriptions($this->request->get['proparent_id']);
		} else {
			$data['proparent_description'] = array();
		}
                
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($proparent_info)) {
			$data['image'] = $proparent_info['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($proparent_info) && is_file(DIR_IMAGE . $proparent_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($proparent_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		if (isset($this->request->post['model'])) {
			$data['model'] = $this->request->post['model'];
		} elseif (!empty($proparent_info)) {
			$data['model'] = $proparent_info['model'];
		} else {
			$data['model'] = '';
		}
                
		if (isset($this->request->post['address'])) {
			$data['address'] = $this->request->post['address'];
		} elseif (!empty($proparent_info)) {
			$data['address'] = $proparent_info['address'];
		} else {
			$data['address'] = '';
		}

		if (isset($this->request->post['sku'])) {
			$data['sku'] = $this->request->post['sku'];
		} elseif (!empty($proparent_info)) {
			$data['sku'] = $proparent_info['sku'];
		} else {
			$data['sku'] = '';
		}

		if (isset($this->request->post['upc'])) {
			$data['upc'] = $this->request->post['upc'];
		} elseif (!empty($proparent_info)) {
			$data['upc'] = $proparent_info['upc'];
		} else {
			$data['upc'] = '';
		}

		if (isset($this->request->post['ean'])) {
			$data['ean'] = $this->request->post['ean'];
		} elseif (!empty($proparent_info)) {
			$data['ean'] = $proparent_info['ean'];
		} else {
			$data['ean'] = '';
		}

		if (isset($this->request->post['jan'])) {
			$data['jan'] = $this->request->post['jan'];
		} elseif (!empty($proparent_info)) {
			$data['jan'] = $proparent_info['jan'];
		} else {
			$data['jan'] = '';
		}

		if (isset($this->request->post['isbn'])) {
			$data['isbn'] = $this->request->post['isbn'];
		} elseif (!empty($proparent_info)) {
			$data['isbn'] = $proparent_info['isbn'];
		} else {
			$data['isbn'] = '';
		}

		if (isset($this->request->post['mpn'])) {
			$data['mpn'] = $this->request->post['mpn'];
		} elseif (!empty($proparent_info)) {
			$data['mpn'] = $proparent_info['mpn'];
		} else {
			$data['mpn'] = '';
		}
                
		if (isset($this->request->post['wifi'])) {
			$data['wifi'] = $this->request->post['wifi'];
		} elseif (!empty($proparent_info)) {
			$data['wifi'] = $proparent_info['wifi'];
		} else {
			$data['wifi'] = 0;
		}

		if (isset($this->request->post['location'])) {
			$data['location'] = $this->request->post['location'];
		} elseif (!empty($proparent_info)) {
			$data['location'] = $proparent_info['location'];
		} else {
			$data['location'] = '';
		}

		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['proparent_store'])) {
			$data['proparent_store'] = $this->request->post['proparent_store'];
		} elseif (isset($this->request->get['proparent_id'])) {
			$data['proparent_store'] = $this->model_catalog_proparent->getProparentStores($this->request->get['proparent_id']);
		} else {
			$data['proparent_store'] = array(0);
		}

		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($proparent_info)) {
			$data['keyword'] = $proparent_info['keyword'];
		} else {
			$data['keyword'] = '';
		}

		if (isset($this->request->post['shipping'])) {
			$data['shipping'] = $this->request->post['shipping'];
		} elseif (!empty($proparent_info)) {
			$data['shipping'] = $proparent_info['shipping'];
		} else {
			$data['shipping'] = 1;
		}
                
		if (isset($this->request->post['star'])) {
			$data['star'] = $this->request->post['star'];
		} elseif (!empty($proparent_info)) {
			$data['star'] = $proparent_info['star'];
		} else {
			$data['star'] = 0;
		}

		if (isset($this->request->post['price'])) {
			$data['price'] = $this->request->post['price'];
		} elseif (!empty($proparent_info)) {
			$data['price'] = $proparent_info['price'];
		} else {
			$data['price'] = '';
		}

		$this->load->model('catalog/recurring');

		$data['recurrings'] = $this->model_catalog_recurring->getRecurrings();

		if (isset($this->request->post['proparent_recurrings'])) {
			$data['proparent_recurrings'] = $this->request->post['proparent_recurrings'];
		} elseif (!empty($proparent_info)) {
			$data['proparent_recurrings'] = $this->model_catalog_proparent->getRecurrings($proparent_info['proparent_id']);
		} else {
			$data['proparent_recurrings'] = array();
		}

		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['tax_class_id'])) {
			$data['tax_class_id'] = $this->request->post['tax_class_id'];
		} elseif (!empty($proparent_info)) {
			$data['tax_class_id'] = $proparent_info['tax_class_id'];
		} else {
			$data['tax_class_id'] = 0;
		}

		if (isset($this->request->post['date_available'])) {
			$data['date_available'] = $this->request->post['date_available'];
		} elseif (!empty($proparent_info)) {
			$data['date_available'] = ($proparent_info['date_available'] != '0000-00-00') ? $proparent_info['date_available'] : '';
		} else {
			$data['date_available'] = date('Y-m-d');
		}

		if (isset($this->request->post['quantity'])) {
			$data['quantity'] = $this->request->post['quantity'];
		} elseif (!empty($proparent_info)) {
			$data['quantity'] = $proparent_info['quantity'];
		} else {
			$data['quantity'] = 1;
		}

		if (isset($this->request->post['minimum'])) {
			$data['minimum'] = $this->request->post['minimum'];
		} elseif (!empty($proparent_info)) {
			$data['minimum'] = $proparent_info['minimum'];
		} else {
			$data['minimum'] = 1;
		}

		if (isset($this->request->post['subtract'])) {
			$data['subtract'] = $this->request->post['subtract'];
		} elseif (!empty($proparent_info)) {
			$data['subtract'] = $proparent_info['subtract'];
		} else {
			$data['subtract'] = 1;
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($proparent_info)) {
			$data['sort_order'] = $proparent_info['sort_order'];
		} else {
			$data['sort_order'] = 1;
		}

		$this->load->model('localisation/stock_status');

		$data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();

		if (isset($this->request->post['stock_status_id'])) {
			$data['stock_status_id'] = $this->request->post['stock_status_id'];
		} elseif (!empty($proparent_info)) {
			$data['stock_status_id'] = $proparent_info['stock_status_id'];
		} else {
			$data['stock_status_id'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($proparent_info)) {
			$data['status'] = $proparent_info['status'];
		} else {
			$data['status'] = true;
		}

		if (isset($this->request->post['weight'])) {
			$data['weight'] = $this->request->post['weight'];
		} elseif (!empty($proparent_info)) {
			$data['weight'] = $proparent_info['weight'];
		} else {
			$data['weight'] = '';
		}

		$this->load->model('localisation/weight_class');

		$data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

		if (isset($this->request->post['weight_class_id'])) {
			$data['weight_class_id'] = $this->request->post['weight_class_id'];
		} elseif (!empty($proparent_info)) {
			$data['weight_class_id'] = $proparent_info['weight_class_id'];
		} else {
			$data['weight_class_id'] = $this->config->get('config_weight_class_id');
		}

		if (isset($this->request->post['length'])) {
			$data['length'] = $this->request->post['length'];
		} elseif (!empty($proparent_info)) {
			$data['length'] = $proparent_info['length'];
		} else {
			$data['length'] = '';
		}

		if (isset($this->request->post['width'])) {
			$data['width'] = $this->request->post['width'];
		} elseif (!empty($proparent_info)) {
			$data['width'] = $proparent_info['width'];
		} else {
			$data['width'] = '';
		}

		if (isset($this->request->post['height'])) {
			$data['height'] = $this->request->post['height'];
		} elseif (!empty($proparent_info)) {
			$data['height'] = $proparent_info['height'];
		} else {
			$data['height'] = '';
		}

		$this->load->model('localisation/length_class');

		$data['length_classes'] = $this->model_localisation_length_class->getLengthClasses();

		if (isset($this->request->post['length_class_id'])) {
			$data['length_class_id'] = $this->request->post['length_class_id'];
		} elseif (!empty($proparent_info)) {
			$data['length_class_id'] = $proparent_info['length_class_id'];
		} else {
			$data['length_class_id'] = $this->config->get('config_length_class_id');
		}

		$this->load->model('catalog/manufacturer');

		if (isset($this->request->post['manufacturer_id'])) {
			$data['manufacturer_id'] = $this->request->post['manufacturer_id'];
		} elseif (!empty($proparent_info)) {
			$data['manufacturer_id'] = $proparent_info['manufacturer_id'];
		} else {
			$data['manufacturer_id'] = 0;
		}

		if (isset($this->request->post['manufacturer'])) {
			$data['manufacturer'] = $this->request->post['manufacturer'];
		} elseif (!empty($proparent_info)) {
			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($proparent_info['manufacturer_id']);

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

		if (isset($this->request->post['proparent_category'])) {
			$categories = $this->request->post['proparent_category'];
		} elseif (isset($this->request->get['proparent_id'])) {
			$categories = $this->model_catalog_proparent->getProparentCategories($this->request->get['proparent_id']);
		} else {
			$categories = array();
		}

		$data['proparent_categories'] = array();

		foreach ($categories as $category_id) {
			$category_info = $this->model_catalog_category->getCategory($category_id);

			if ($category_info) {
				$data['proparent_categories'][] = array(
					'category_id' => $category_info['category_id'],
					'name' => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
				);
			}
		}

		// Filters
		$this->load->model('catalog/filter');

		if (isset($this->request->post['proparent_filter'])) {
			$filters = $this->request->post['proparent_filter'];
		} elseif (isset($this->request->get['proparent_id'])) {
			$filters = $this->model_catalog_proparent->getProparentFilters($this->request->get['proparent_id']);
		} else {
			$filters = array();
		}

		$data['proparent_filters'] = array();

		foreach ($filters as $filter_id) {
			$filter_info = $this->model_catalog_filter->getFilter($filter_id);

			if ($filter_info) {
				$data['proparent_filters'][] = array(
					'filter_id' => $filter_info['filter_id'],
					'name'      => $filter_info['group'] . ' &gt; ' . $filter_info['name']
				);
			}
		}

		// Attributes
		$this->load->model('catalog/attribute');

		if (isset($this->request->post['proparent_attribute'])) {
			$proparent_attributes = $this->request->post['proparent_attribute'];
		} elseif (isset($this->request->get['proparent_id'])) {
			$proparent_attributes = $this->model_catalog_proparent->getProparentAttributes($this->request->get['proparent_id']);
		} else {
			$proparent_attributes =  $this->model_catalog_attribute->getAttributes();
		}
		$data['proparent_attributes'] = array();

		foreach ($proparent_attributes as $proparent_attribute) {
			$attribute_info = $this->model_catalog_attribute->getAttribute($proparent_attribute['attribute_id']);
                        if(!isset($proparent_attribute['proparent_attribute_description'])){
                            $proparent_attribute_description = "";
                        }else{
                            $proparent_attribute_description = $proparent_attribute['proparent_attribute_description'];
                        }
			if ($attribute_info) {
				$data['proparent_attributes'][] = array(
					'attribute_id'                  => $proparent_attribute['attribute_id'],
					'name'                          => $attribute_info['name'],
					'proparent_attribute_description' => $proparent_attribute_description
				);
			}
		}
                
                // Google Maps
                

		if (isset($this->request->post['maps_apil'])) {
			$data['maps_apil'] = $this->request->post['maps_apil'];
		} elseif (!empty($proparent_info)) {
			$data['maps_apil'] = $proparent_info['maps_apil'];
		} else {
			$data['maps_apil'] = '';
		}

		if (isset($this->request->post['maps_apir'])) {
			$data['maps_apir'] = $this->request->post['maps_apir'];
		} elseif (!empty($proparent_info)) {
			$data['maps_apir'] = $proparent_info['maps_apir'];
		} else {
			$data['maps_apir'] = '';
		}
                
		// Options
		$this->load->model('catalog/option');

		if (isset($this->request->post['proparent_option'])) {
			$proparent_options = $this->request->post['proparent_option'];
		} elseif (isset($this->request->get['proparent_id'])) {
			$proparent_options = $this->model_catalog_proparent->getProparentOptions($this->request->get['proparent_id']);
		} else {
			$proparent_options = array();
		}

		$data['proparent_options'] = array();

		foreach ($proparent_options as $proparent_option) {
			$proparent_option_value_data = array();

			if (isset($proparent_option['proparent_option_value'])) {
				foreach ($proparent_option['proparent_option_value'] as $proparent_option_value) {
					$proparent_option_value_data[] = array(
						'proparent_option_value_id' => $proparent_option_value['proparent_option_value_id'],
						'option_value_id'         => $proparent_option_value['option_value_id'],
						'quantity'                => $proparent_option_value['quantity'],
						'subtract'                => $proparent_option_value['subtract'],
						'price'                   => $proparent_option_value['price'],
						'price_prefix'            => $proparent_option_value['price_prefix'],
						'points'                  => $proparent_option_value['points'],
						'points_prefix'           => $proparent_option_value['points_prefix'],
						'weight'                  => $proparent_option_value['weight'],
						'weight_prefix'           => $proparent_option_value['weight_prefix']
					);
				}
			}

			$data['proparent_options'][] = array(
				'proparent_option_id'    => $proparent_option['proparent_option_id'],
				'proparent_option_value' => $proparent_option_value_data,
				'option_id'            => $proparent_option['option_id'],
				'name'                 => $proparent_option['name'],
				'type'                 => $proparent_option['type'],
				'value'                => isset($proparent_option['value']) ? $proparent_option['value'] : '',
				'required'             => $proparent_option['required']
			);
		}

		$data['option_values'] = array();

		foreach ($data['proparent_options'] as $proparent_option) {
			if ($proparent_option['type'] == 'select' || $proparent_option['type'] == 'radio' || $proparent_option['type'] == 'checkbox' || $proparent_option['type'] == 'image') {
				if (!isset($data['option_values'][$proparent_option['option_id']])) {
					$data['option_values'][$proparent_option['option_id']] = $this->model_catalog_option->getOptionValues($proparent_option['option_id']);
				}
			}
		}

		$this->load->model('sale/customer_group');

		$data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();

		if (isset($this->request->post['proparent_discount'])) {
			$proparent_discounts = $this->request->post['proparent_discount'];
		} elseif (isset($this->request->get['proparent_id'])) {
			$proparent_discounts = $this->model_catalog_proparent->getProparentDiscounts($this->request->get['proparent_id']);
		} else {
			$proparent_discounts = array();
		}

		$data['proparent_discounts'] = array();

		foreach ($proparent_discounts as $proparent_discount) {
			$data['proparent_discounts'][] = array(
				'customer_group_id' => $proparent_discount['customer_group_id'],
				'quantity'          => $proparent_discount['quantity'],
				'priority'          => $proparent_discount['priority'],
				'price'             => $proparent_discount['price'],
				'date_start'        => ($proparent_discount['date_start'] != '0000-00-00') ? $proparent_discount['date_start'] : '',
				'date_end'          => ($proparent_discount['date_end'] != '0000-00-00') ? $proparent_discount['date_end'] : ''
			);
		}

		if (isset($this->request->post['proparent_special'])) {
			$proparent_specials = $this->request->post['proparent_special'];
		} elseif (isset($this->request->get['proparent_id'])) {
			$proparent_specials = $this->model_catalog_proparent->getProparentSpecials($this->request->get['proparent_id']);
		} else {
			$proparent_specials = array();
		}

		$data['proparent_specials'] = array();

		foreach ($proparent_specials as $proparent_special) {
			$data['proparent_specials'][] = array(
				'customer_group_id' => $proparent_special['customer_group_id'],
				'priority'          => $proparent_special['priority'],
				'price'             => $proparent_special['price'],
				'date_start'        => ($proparent_special['date_start'] != '0000-00-00') ? $proparent_special['date_start'] : '',
				'date_end'          => ($proparent_special['date_end'] != '0000-00-00') ? $proparent_special['date_end'] :  ''
			);
		}

		// Images
		if (isset($this->request->post['proparent_image'])) {
			$proparent_images = $this->request->post['proparent_image'];
		} elseif (isset($this->request->get['proparent_id'])) {
			$proparent_images = $this->model_catalog_proparent->getProparentImages($this->request->get['proparent_id']);
		} else {
			$proparent_images = array();
		}

		$data['proparent_images'] = array();

		foreach ($proparent_images as $proparent_image) {
			if (is_file(DIR_IMAGE . $proparent_image['image'])) {
				$image = $proparent_image['image'];
				$thumb = $proparent_image['image'];
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}

			$data['proparent_images'][] = array(
				'image'      => $image,
				'thumb'      => $this->model_tool_image->resize($thumb, 100, 100),
				'sort_order' => $proparent_image['sort_order']
			);
		}

		// Downloads
		$this->load->model('catalog/download');

		if (isset($this->request->post['proparent_download'])) {
			$proparent_downloads = $this->request->post['proparent_download'];
		} elseif (isset($this->request->get['proparent_id'])) {
			$proparent_downloads = $this->model_catalog_proparent->getProparentDownloads($this->request->get['proparent_id']);
		} else {
			$proparent_downloads = array();
		}

		$data['proparent_downloads'] = array();

		foreach ($proparent_downloads as $download_id) {
			$download_info = $this->model_catalog_download->getDownload($download_id);

			if ($download_info) {
				$data['proparent_downloads'][] = array(
					'download_id' => $download_info['download_id'],
					'name'        => $download_info['name']
				);
			}
		}

		if (isset($this->request->post['proparent_related'])) {
			$proparents = $this->request->post['proparent_related'];
		} elseif (isset($this->request->get['proparent_id'])) {
			$proparents = $this->model_catalog_proparent->getProparentRelated($this->request->get['proparent_id']);
		} else {
			$proparents = array();
		}

		$data['proparent_relateds'] = array();

		foreach ($proparents as $proparent_id) {
			$related_info = $this->model_catalog_proparent->getProparent($proparent_id);

			if ($related_info) {
				$data['proparent_relateds'][] = array(
					'proparent_id' => $related_info['proparent_id'],
					'name'       => $related_info['name']
				);
			}
		}

		if (isset($this->request->post['points'])) {
			$data['points'] = $this->request->post['points'];
		} elseif (!empty($proparent_info)) {
			$data['points'] = $proparent_info['points'];
		} else {
			$data['points'] = '';
		}

		if (isset($this->request->post['proparent_reward'])) {
			$data['proparent_reward'] = $this->request->post['proparent_reward'];
		} elseif (isset($this->request->get['proparent_id'])) {
			$data['proparent_reward'] = $this->model_catalog_proparent->getProparentRewards($this->request->get['proparent_id']);
		} else {
			$data['proparent_reward'] = array();
		}

		if (isset($this->request->post['proparent_layout'])) {
			$data['proparent_layout'] = $this->request->post['proparent_layout'];
		} elseif (isset($this->request->get['proparent_id'])) {
			$data['proparent_layout'] = $this->model_catalog_proparent->getProparentLayouts($this->request->get['proparent_id']);
		} else {
			$data['proparent_layout'] = array();
		}

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/proparent_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/proparent')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['proparent_description'] as $language_id => $value) {
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

			if ($url_alias_info && isset($this->request->get['proparent_id']) && $url_alias_info['query'] != 'proparent_id=' . $this->request->get['proparent_id']) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}

			if ($url_alias_info && !isset($this->request->get['proparent_id'])) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/proparent')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateCopy() {
		if (!$this->user->hasPermission('modify', 'catalog/proparent')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model'])) {
			$this->load->model('catalog/proparent');
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

			$results = $this->model_catalog_proparent->getProparents($filter_data);

			foreach ($results as $result) {
				$option_data = array();

				$proparent_options = $this->model_catalog_proparent->getProparentOptions($result['proparent_id']);

				foreach ($proparent_options as $proparent_option) {
					$option_info = $this->model_catalog_option->getOption($proparent_option['option_id']);

					if ($option_info) {
						$proparent_option_value_data = array();

						foreach ($proparent_option['proparent_option_value'] as $proparent_option_value) {
							$option_value_info = $this->model_catalog_option->getOptionValue($proparent_option_value['option_value_id']);

							if ($option_value_info) {
								$proparent_option_value_data[] = array(
									'proparent_option_value_id' => $proparent_option_value['proparent_option_value_id'],
									'option_value_id'         => $proparent_option_value['option_value_id'],
									'name'                    => $option_value_info['name'],
									'price'                   => (float)$proparent_option_value['price'] ? $this->currency->format($proparent_option_value['price'], $this->config->get('config_currency')) : false,
									'price_prefix'            => $proparent_option_value['price_prefix']
								);
							}
						}

						$option_data[] = array(
							'proparent_option_id'    => $proparent_option['proparent_option_id'],
							'proparent_option_value' => $proparent_option_value_data,
							'option_id'            => $proparent_option['option_id'],
							'name'                 => $option_info['name'],
							'type'                 => $option_info['type'],
							'value'                => $proparent_option['value'],
							'required'             => $proparent_option['required']
						);
					}
				}

				$json[] = array(
					'proparent_id' => $result['proparent_id'],
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