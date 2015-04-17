<?php

class ControllerProductProparent extends Controller {

    private $error = array();

    public function index() {
        $this->load->language('proparent/product');

        $this->load->language('product/category');

        $this->load->language('proparent/category');
        
        $this->load->language('proparent/search');
        
        if (isset($this->request->post['date-in'])){
            $this->session->data['date']=$this->request->post['date-in'];
        }else{
             if (empty($this->session->data['date'])){
                  $this->session->data['date'] = date('Y-m-d');
             }
        }
        
        if (isset($this->request->post['date-out'])){
            $this->session->data['date-out']=$this->request->post['date-out'];
        }else{
             if (empty($this->session->data['date-out'])){
                $date2=date('d')+2;
                $this->session->data['date-out'] = date('Y').'-'.date('m').'-'.$date2;
             }
        }
        
        if (isset($this->request->post['adults'])){
            $this->session->data['adults']=$this->request->post['adults'];
        }else{
             if (empty($this->session->data['adults'])){
                  $this->session->data['adults'] = 1;
             }
        }
        
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $this->load->model('catalog/category');

        if (isset($this->request->get['path'])) {
            $path = '';

            $parts = explode('_', (string) $this->request->get['path']);

            $category_id = (int) array_pop($parts);

            foreach ($parts as $path_id) {
                if (!$path) {
                    $path = $path_id;
                } else {
                    $path .= '_' . $path_id;
                }

                $category_info = $this->model_catalog_category->getCategory($path_id);

                if ($category_info) {
                    $data['breadcrumbs'][] = array(
                        'text' => $category_info['name'],
                        'href' => $this->url->link('product/category', 'path=' . $path)
                    );
                }
            }

            // Set the last category breadcrumb
            $category_info = $this->model_catalog_category->getCategory($category_id);

            if ($category_info) {
                $url = '';
                if (isset($this->request->get['search'])) {
                    $url .= '&search=' . $this->request->get['search'];
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

                if (isset($this->request->get['limit'])) {
                    $url .= '&limit=' . $this->request->get['limit'];
                }
                
                
                        
                $data['breadcrumbs'][] = array(
                    'text' => $category_info['name'],
                    'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url)
                );
            }
        }

        $this->load->model('catalog/manufacturer');

        if (isset($this->request->get['manufacturer_id'])) {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_brand'),
                'href' => $this->url->link('product/manufacturer')
            );

            $url = '';
            
            if (isset($this->request->get['search'])) {
                $url .= '&search=' . $this->request->get['search'];
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

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }
            
            
        
            $manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($this->request->get['manufacturer_id']);

            if ($manufacturer_info) {
                $data['breadcrumbs'][] = array(
                    'text' => $manufacturer_info['name'],
                    'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url)
                );
            }
        }

        if (isset($this->request->get['search']) || isset($this->request->get['tag'])) {
            $url = '';

            if (isset($this->request->get['search'])) {
                $url .= '&search=' . $this->request->get['search'];
            }

            if (isset($this->request->get['tag'])) {
                $url .= '&tag=' . $this->request->get['tag'];
            }

            if (isset($this->request->get['description'])) {
                $url .= '&description=' . $this->request->get['description'];
            }
            
            if (isset($this->request->get['star'])) {
                $url .= '&star=' . $this->request->get['star'];
            }
            
            if (isset($this->request->get['address'])) {
                $url .= '&address=' . $this->request->get['address'];
            }

            if (isset($this->request->get['category_id'])) {
                $url .= '&category_id=' . $this->request->get['category_id'];
            }

            if (isset($this->request->get['sub_category'])) {
                $url .= '&sub_category=' . $this->request->get['sub_category'];
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

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }
            
            if (isset($this->request->get['path'])) {
                $url .= '&path=' . $this->request->get['path'];
            }else{
                $part = "";
            }
            
            
        
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_search'),
                'href' => $this->url->link('product/search', $url)
            );
        }

        if (isset($this->request->get['proparent_id'])) {
            $proparent_id = (int) $this->request->get['proparent_id'];
        } else {
            $proparent_id = 0;
        }

        $this->load->model('catalog/proparent');

        $proparent_info = $this->model_catalog_proparent->getProparent($proparent_id);
        
        if ($proparent_info) {
            $url = '';

            if (isset($this->request->get['path'])) {
                $part = $this->request->get['path'];
                $url .= '&path=' . $this->request->get['path'];
            }

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['manufacturer_id'])) {
                $url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
            }

            if (isset($this->request->get['search'])) {
                $url .= '&search=' . $this->request->get['search'];
            }

            if (isset($this->request->get['tag'])) {
                $url .= '&tag=' . $this->request->get['tag'];
            }

            if (isset($this->request->get['description'])) {
                $url .= '&description=' . $this->request->get['description'];
            }

            if (isset($this->request->get['star'])) {
                $url .= '&star=' . $this->request->get['star'];
            }
            
            if (isset($this->request->get['star'])) {
                $url .= '&address=' . $this->request->get['address'];
            }

            if (isset($this->request->get['category_id'])) {
                $url .= '&category_id=' . $this->request->get['category_id'];
            }

            if (isset($this->request->get['sub_category'])) {
                $url .= '&sub_category=' . $this->request->get['sub_category'];
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

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }
            
            
        
            $data['breadcrumbs'][] = array(
                'text' => $proparent_info['name'],
                'href' => $this->url->link('product/proparent', $url . '&proparent_id=' . $this->request->get['proparent_id'])
            );

            $this->document->setTitle($proparent_info['meta_title']);
            $this->document->setDescription($proparent_info['meta_description']);
            $this->document->setKeywords($proparent_info['meta_keyword']);
            $this->document->addLink($this->url->link('product/proparent', 'proparent_id=' . $this->request->get['proparent_id']), 'canonical');
            $this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
            $this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');
            $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
            $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
            $this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');
            $this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.carousel.css');
            $this->document->addScript('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js');
            $this->document->addScript('http://maps.google.com/maps/api/js?sensor=false');

            $data['heading_title'] = $proparent_info['name'];

            $data['text_select'] = $this->language->get('text_select');
            $data['text_manufacturer'] = $this->language->get('text_manufacturer');
            $data['text_model'] = $this->language->get('text_model');
            $data['text_reward'] = $this->language->get('text_reward');
            $data['text_points'] = $this->language->get('text_points');
            $data['text_stock'] = $this->language->get('text_stock');
            $data['text_discount'] = $this->language->get('text_discount');
            $data['text_tax'] = $this->language->get('text_tax');
            $data['text_option'] = $this->language->get('text_option');
            $data['text_minimum'] = sprintf($this->language->get('text_minimum'), $proparent_info['minimum']);
            $data['text_write'] = $this->language->get('text_write');
            $data['text_login'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'));
            $data['text_note'] = $this->language->get('text_note');
            $data['text_tags'] = $this->language->get('text_tags');
            $data['text_related'] = $this->language->get('text_related');
            $data['text_loading'] = $this->language->get('text_loading');
            $data['text_limit'] = $this->language->get('text_limit');
            $data['text_sort'] = $this->language->get('text_sort');
            $data['text_book'] = $this->language->get('text_book');
            $data['text_room'] = $this->language->get('text_room');
            $data['text_max_adults'] = $this->language->get('text_max_adults');
            $data['text_rate'] = $this->language->get('text_rate');
            $data['text_rate_superb'] = $this->language->get('text_rate_superb');
            $data['text_rate_fantastic'] = $this->language->get('text_rate_fantastic');
            $data['text_rate_verygood'] = $this->language->get('text_rate_verygood');
            $data['text_rate_good'] = $this->language->get('text_rate_good');
            $data['text_rate_bad'] = $this->language->get('text_rate_bad');
            $data['text_info'] = $this->language->get('text_info');
            $data['text_features'] = $this->language->get('text_features');
            $data['text_ourlast'] = $this->language->get('text_ourlast');
            $data['text_ourlastroom'] = $this->language->get('text_ourlastroom');
            $data['text_rooms'] = $this->language->get('text_rooms');
            $data['text_available'] = $this->language->get('text_available');
            $data['text_wifi'] = $this->language->get('text_wifi');
            $data['text_search'] = $this->language->get('text_search');
            $data['text_labeldate_in'] = $this->language->get('text_labeldate_in');
            $data['text_labelguest'] = $this->language->get('text_labelguest');
            $data['text_labeldate_out'] = $this->language->get('text_labeldate_out');
            $data['text_change_date'] = $this->language->get('text_change_date');
            
            $data['entry_qty'] = $this->language->get('entry_qty');
            $data['entry_name'] = $this->language->get('entry_name');
            $data['entry_pareview'] = $this->language->get('entry_pareview');
            $data['entry_rating'] = $this->language->get('entry_rating');
            $data['entry_good'] = $this->language->get('entry_good');
            $data['entry_bad'] = $this->language->get('entry_bad');
            $data['entry_captcha'] = $this->language->get('entry_captcha');
            $data['entry_search'] = $this->language->get('entry_search');

            $data['button_cart'] = $this->language->get('button_cart');
            $data['button_wishlist'] = $this->language->get('button_wishlist');
            $data['button_compare'] = $this->language->get('button_compare');
            $data['button_upload'] = $this->language->get('button_upload');
            $data['button_continue'] = $this->language->get('button_continue');
            $data['button_list'] = $this->language->get('button_list');
            $data['button_grid'] = $this->language->get('button_grid');
            $data['button_search'] = $this->language->get('button_search');

            $this->load->model('catalog/review');

            $data['tab_description'] = $this->language->get('tab_description');
            $data['tab_short_description'] = $this->language->get('tab_short_description');
            $data['tab_attribute'] = $this->language->get('tab_attribute');
            $data['tab_pareview'] = sprintf($this->language->get('tab_pareview'), $proparent_info['pareviews']);

            $data['proparent_id'] = (int) $this->request->get['proparent_id'];
            $data['manufacturer'] = $proparent_info['manufacturer'];
            $data['manufacturers'] = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $proparent_info['manufacturer_id']);
            $data['model'] = $proparent_info['model'];
            $data['reward'] = $proparent_info['reward'];
            $data['star'] = $proparent_info['star'];
            $data['address'] = $proparent_info['address'];
            $data['points'] = $proparent_info['points'];

            if ($proparent_info['quantity'] <= 0) {
                $data['stock'] = $proparent_info['stock_status'];
            } elseif ($this->config->get('config_stock_display')) {
                $data['stock'] = $proparent_info['quantity'];
            } else {
                $data['stock'] = $this->language->get('text_instock');
            }

            $this->load->model('tool/image');

            if ($proparent_info['image']) {
                $data['popup'] = $this->model_tool_image->resize($proparent_info['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
            } else {
                $data['popup'] = '';
            }

            if ($proparent_info['image']) {
                $data['thumb'] = $this->model_tool_image->resize($proparent_info['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_width'));
                $data['thumbc'] = $this->model_tool_image->resize($proparent_info['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_width'));
            } else {
                $data['thumb'] = "";
                $data['thumbc'] = "";
            }

            $data['images'] = array();

            $results = $this->model_catalog_proparent->getProparentImages($this->request->get['proparent_id']);

            foreach ($results as $result) {
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], 740,400);
                    $thumb = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_width'));
                    $popup = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png',  740,400);
                    $thumb = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_category_width'), $this->config->get('config_image_category_width'));
                    $popup = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
                }
                $data['images'][] = array(
                    'popup' => $popup,
                    'thumb' => $thumb,
                    'image' => $image
                );
            }

            if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                $data['price'] = $this->currency->format($this->tax->calculate($proparent_info['price'], $proparent_info['tax_class_id'], $this->config->get('config_tax')));
            } else {
                $data['price'] = false;
            }

            if ((float) $proparent_info['special']) {
                $data['special'] = $this->currency->format($this->tax->calculate($proparent_info['special'], $proparent_info['tax_class_id'], $this->config->get('config_tax')));
            } else {
                $data['special'] = false;
            }

            if ($this->config->get('config_tax')) {
                $data['tax'] = $this->currency->format((float) $proparent_info['special'] ? $proparent_info['special'] : $proparent_info['price']);
            } else {
                $data['tax'] = false;
            }

            $discounts = $this->model_catalog_proparent->getProparentDiscounts($this->request->get['proparent_id']);

            $data['discounts'] = array();

            foreach ($discounts as $discount) {
                $data['discounts'][] = array(
                    'quantity' => $discount['quantity'],
                    'price' => $this->currency->format($this->tax->calculate($discount['price'], $proparent_info['tax_class_id'], $this->config->get('config_tax')))
                );
            }

            $data['options'] = array();

            foreach ($this->model_catalog_proparent->getProparentOptions($this->request->get['proparent_id']) as $option) {
                $proparent_option_value_data = array();

                foreach ($option['proparent_option_value'] as $option_value) {
                    if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
                        if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float) $option_value['price']) {
                            $price = $this->currency->format($this->tax->calculate($option_value['price'], $proparent_info['tax_class_id'], $this->config->get('config_tax') ? 'P' : false));
                        } else {
                            $price = false;
                        }

                        $proparent_option_value_data[] = array(
                            'proparent_option_value_id' => $option_value['proparent_option_value_id'],
                            'option_value_id' => $option_value['option_value_id'],
                            'name' => $option_value['name'],
                            'image' => $this->model_tool_image->resize($option_value['image'], 50, 50),
                            'price' => $price,
                            'price_prefix' => $option_value['price_prefix']
                        );
                    }
                }

                $data['options'][] = array(
                    'proparent_option_id' => $option['proparent_option_id'],
                    'proparent_option_value' => $proparent_option_value_data,
                    'option_id' => $option['option_id'],
                    'name' => $option['name'],
                    'type' => $option['type'],
                    'value' => $option['value'],
                    'required' => $option['required']
                );
            }

            if ($proparent_info['minimum']) {
                $data['minimum'] = $proparent_info['minimum'];
            } else {
                $data['minimum'] = 1;
            }

            if ($proparent_info['maps_apir']) {
                $data['maps_apir'] = $proparent_info['maps_apir'];
            } else {
                $data['maps_apir'] = '';
            }
            
            if ($proparent_info['maps_apil']) {
                $data['maps_apil'] = $proparent_info['maps_apil'];
            } else {
                $data['maps_apil'] = '';
            }

            $data['pareview_status'] = $this->config->get('config_review_status');

            if ($this->config->get('config_review_guest') || $this->customer->isLogged()) {
                $data['pareview_guest'] = true;
            } else {
                $data['pareview_guest'] = false;
            }

            if ($this->customer->isLogged()) {
                $data['customer_name'] = $this->customer->getFirstName() . '&nbsp;' . $this->customer->getLastName();
            } else {
                $data['customer_name'] = '';
            }

            $data['pareviews'] = sprintf($this->language->get('text_pareviews'), (int) $proparent_info['pareviews']);
            $data['rating'] = (int) $proparent_info['rating'];
            $data['description'] = html_entity_decode($proparent_info['description'], ENT_QUOTES, 'UTF-8');
            $data['short_description'] = html_entity_decode($proparent_info['short_description'], ENT_QUOTES, 'UTF-8');
            $data['attribute_groups'] = $this->model_catalog_proparent->getProparentAttributes($this->request->get['proparent_id']);

            $data['proparents'] = array();

            $results = $this->model_catalog_proparent->getProparentRelated($this->request->get['proparent_id']);

             foreach ($results as $result) {
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));
                }

                if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                    $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
                } else {
                    $price = false;
                }

                if ((float) $result['special']) {
                    $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
                } else {
                    $special = false;
                }

                if ($this->config->get('config_tax')) {
                    $tax = $this->currency->format((float) $result['special'] ? $result['special'] : $result['price']);
                } else {
                    $tax = false;
                }

                if ($this->config->get('config_pareview_status')) {
                    $rating = (int) $result['rating'];
                } else {
                    $rating = false;
                }

                $data['proparents'][] = array(
                    'proparent_id' => $result['proparent_id'],
                    'thumb' => $image,
                    'name' => $result['name'],
                    'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_proparent_description_length')) . '..',
                    'short_description' => utf8_substr(strip_tags(html_entity_decode($result['short_description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_proparent_description_length')) . '..',
                    'price' => $price,
                    'wifi' => $wifi,
                    'special' => $special,
                    'tax' => $tax,
                    'rating' => $rating,
                    'href' => $this->url->link('product/proparent', 'proparent_id=' . $result['proparent_id'])
                );
            }

            $data['tags'] = array();

            if ($proparent_info['tag']) {
                $tags = explode(',', $proparent_info['tag']);

                foreach ($tags as $tag) {
                    $data['tags'][] = array(
                        'tag' => trim($tag),
                        'href' => $this->url->link('product/search', 'tag=' . trim($tag))
                    );
                }
            }

            $data['text_payment_recurring'] = $this->language->get('text_payment_recurring');
            $data['recurrings'] = $this->model_catalog_proparent->getProfiles($this->request->get['proparent_id']);

            $this->model_catalog_proparent->updateViewed($this->request->get['proparent_id']);

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');

            $filter_data = array(
                'filter_proparent_id' => $this->request->get['proparent_id'],
                'filter_sub_category' => true
            );
            // Sort //
            
            $url = '';
            
            if (isset($this->request->get['search'])) {
                $url .= '&search=' . $this->request->get['search'];
            }

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }
            
            
            
            $data['sorts'] = array();

            $data['sorts'][] = array(
                'text' => $this->language->get('text_default'),
                'value' => 'p.sort_order-ASC',
                'href' => $this->url->link('product/proparent', 'path=' . $part . '&sort=p.sort_order&order=ASC' . '&proparent_id=' . $this->request->get['proparent_id'] . $url)
            );

            $data['sorts'][] = array(
                'text' => $this->language->get('text_price_asc'),
                'value' => 'p.price-ASC',
                'href' => $this->url->link('product/proparent', 'path=' . $part . '&sort=p.price&order=ASC' . '&proparent_id=' . $this->request->get['proparent_id'] . $url)
            );
            
            $url = '';
            
            if (isset($this->request->get['search'])) {
                $url .= '&search=' . $this->request->get['search'];
            }

            
            
            $data['sorts'][] = array(
                'text' => $this->language->get('text_price_desc'),
                'value' => 'p.price-DESC',
                'href' => $this->url->link('product/proparent', 'path=' . $part . '&sort=p.price&order=DESC' . '&proparent_id=' . $this->request->get['proparent_id'] . $url)
            );

            $data['sorts'][] = array(
                'text' => $this->language->get('text_maxadults_asc'),
                'value' => 'p.maxadults-ASC',
                'href' => $this->url->link('product/proparent', 'path=' . $part . '&sort=p.maxadults&order=ASC' . '&proparent_id=' . $this->request->get['proparent_id'] . $url)
            );
            
            $url = '';
            
            if (isset($this->request->get['search'])) {
                $url .= '&search=' . $this->request->get['search'];
            }

            
            
            $data['sorts'][] = array(
                'text' => $this->language->get('text_maxadults_desc'),
                'value' => 'p.maxadults-DESC',
                'href' => $this->url->link('product/proparent', 'path=' . $part . '&sort=p.maxadults&order=DESC' . '&proparent_id=' . $this->request->get['proparent_id'] . $url)
            );

            // Limit //
            $url = '';
            
            if (isset($this->request->get['search'])) {
                $url .= '&search=' . $this->request->get['search'];
            }

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            
            
            
            $data['limits'] = array();

            $limits = array_unique(array($this->config->get('config_product_limit'), 25, 50, 75, 100));

            sort($limits);

            foreach ($limits as $value) {
                $data['limits'][] = array(
                    'text' => $value,
                    'value' => $value,
                    'href' => $this->url->link('product/proparent', 'path=' . $part . $url . '&limit=' . $value . '&proparent_id=' . $this->request->get['proparent_id'])
                );
            }

            // Pagination // 

            $url = '';
            
            if (isset($this->request->get['search'])) {
                $url .= '&search=' . $this->request->get['search'];
            }

            if (isset($this->request->get['filter'])) {
                $filter = $this->request->get['filter'];
            } else {
                $filter = '';
            }

            if (isset($this->request->get['sort'])) {
                $sort = $this->request->get['sort'];
            } else {
                $sort = 'p.sort_order';
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

            if (isset($this->request->get['limit'])) {
                $limit = $this->request->get['limit'];
            } else {
                $limit = $this->config->get('config_product_limit');
            }
            
            

            $filter_data = array(
                'filter_proparent_id' => $this->request->get['proparent_id'],
                'filter_sub_category' => true,
                'filter_filter' => $filter,
                'sort' => $sort,
                'order' => $order,
                'start' => ($page - 1) * $limit,
                'limit' => $limit,
            );

            $products = $this->model_catalog_product->getProducts($filter_data);

            foreach ($products as $product) {
                if ($product['image']) {
                    $image = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_width'));
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_category_width'), $this->config->get('config_image_category_width'));
                }

                if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                    $price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));
                } else {
                    $price = false;
                }

                if ((float) $product['special']) {
                    $special = $this->currency->format($this->tax->calculate($product['special'], $product['tax_class_id'], $this->config->get('config_tax')));
                } else {
                    $special = false;
                }

                if ($this->config->get('config_tax')) {
                    $tax = $this->currency->format((float) $product['special'] ? $product['special'] : $product['price']);
                } else {
                    $tax = false;
                }

                if ($this->config->get('config_pareview_status')) {
                    $rating = (int) $product['rating'];
                } else {
                    $rating = false;
                }

                $product_prices = $this->model_catalog_product->getProductPrices($product['product_id']);  
                
                $had_price = FALSE;

                foreach ($product_prices as $value) {
                    if ((strtotime($this->session->data['date'])>=strtotime($value['product_date']['1']['date']))&&(strtotime($this->session->data['date'])<=strtotime($value['product_date']['2']['date']))){
                         $price_cost = $this->currency->format($this->tax->calculate($value['product_price_gross'], $proparent_info['tax_class_id'], $this->config->get('config_tax')));
                         $had_price = TRUE;
                    }else{
                         $price_cost='';
                    }
                    $data['product_prices'][] =array(
                     'product_price_value'   => $price_cost,
                     'product_date'          => $value['product_date'],
                     'product_id'            => $value['product_id']
                    ); 
                }

                if ($this->session->data['adults'] > $product['maxadults'] || $had_price == FALSE){
                    continue;
                }

                $data['products'][] = array(
                    'product_id' => $product['product_id'],
                    'thumb' => $image,
                    'name' => $product['name'],
                    'description' => utf8_substr(strip_tags(html_entity_decode($product['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
                    'price' => $price,
                    'quantity' => $product['quantity'],
                    'maxadults' => $product['maxadults'],
                    'special' => $special,
                    'tax' => $tax,
                    'rating' => $product['rating'],
                    'href' => $this->url->link('product/product', 'path=' . $part . '&product_id=' . $product['product_id'] . $url)
                );
            }
            
            
            $product_total = count($data['products']);
            
            $pagination = new Pagination();
            $pagination->total = $product_total;
            $pagination->page = $page;
            $pagination->limit = $limit;
            $pagination->url = $this->url->link('product/category', 'path=' . $part . $url . '&page={page}');

            $data['pagination'] = $pagination->render();

            $data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

            $data['sort'] = $sort;
            $data['order'] = $order;
            $data['limit'] = $limit;


            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/proparent.tpl')) {
                $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/proparent.tpl', $data));
            } else {
                $this->response->setOutput($this->load->view('default/template/product/proparent.tpl', $data));
            }
        } else {
            $url = '';

            if (isset($this->request->get['path'])) {
                $url .= '&path=' . $this->request->get['path'];
            }

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['manufacturer_id'])) {
                $url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
            }

            if (isset($this->request->get['search'])) {
                $url .= '&search=' . $this->request->get['search'];
            }

            if (isset($this->request->get['tag'])) {
                $url .= '&tag=' . $this->request->get['tag'];
            }

            if (isset($this->request->get['description'])) {
                $url .= '&description=' . $this->request->get['description'];
            }

            if (isset($this->request->get['category_id'])) {
                $url .= '&category_id=' . $this->request->get['category_id'];
            }

            if (isset($this->request->get['sub_category'])) {
                $url .= '&sub_category=' . $this->request->get['sub_category'];
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

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }
            
            
            
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_error'),
                'href' => $this->url->link('product/proparent', $url . '&proparent_id=' . $proparent_id)
            );


            $this->document->setTitle($this->language->get('text_error'));

            $data['heading_title'] = $this->language->get('text_error');

            $data['text_error'] = $this->language->get('text_error');

            $data['button_continue'] = $this->language->get('button_continue');

            $data['continue'] = $this->url->link('common/home');

            $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
                $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
            } else {
                $this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
            }
        }
    }

    public function pareview() {
        $this->load->language('proparent/product');

        $this->load->model('catalog/review');

        $data['text_no_pareviews'] = $this->language->get('text_no_pareviews');

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $data['pareviews'] = array();

        $pareview_total = $this->model_catalog_review->getTotalReviewsByProparentId($this->request->get['proparent_id']);

        $results = $this->model_catalog_review->getReviewsByProparentId($this->request->get['proparent_id'], ($page - 1) * 5, 5);

        foreach ($results as $result) {
            $data['pareviews'][] = array(
                'author' => $result['author'],
                'text' => nl2br($result['text']),
                'rating' => (int) $result['rating'],
                'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
            );
        }
        $pagination = new Pagination();
        $pagination->total = $pareview_total;
        $pagination->page = $page;
        $pagination->limit = 5;
        $pagination->url = $this->url->link('product/proparent/pareview', 'proparent_id=' . $this->request->get['proparent_id'] . '&page={page}');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($pareview_total) ? (($page - 1) * 5) + 1 : 0, ((($page - 1) * 5) > ($pareview_total - 5)) ? $pareview_total : ((($page - 1) * 5) + 5), $pareview_total, ceil($pareview_total / 5));

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/pareview.tpl')) {
            $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/pareview.tpl', $data));
        } else {
            $this->response->setOutput($this->load->view('default/template/product/pareview.tpl', $data));
        }
    }

    public function getRecurringDescription() {
        $this->language->load('proparent/proparent');
        $this->load->model('catalog/proparent');

        if (isset($this->request->post['proparent_id'])) {
            $proparent_id = $this->request->post['proparent_id'];
        } else {
            $proparent_id = 0;
        }

        if (isset($this->request->post['recurring_id'])) {
            $recurring_id = $this->request->post['recurring_id'];
        } else {
            $recurring_id = 0;
        }

        if (isset($this->request->post['quantity'])) {
            $quantity = $this->request->post['quantity'];
        } else {
            $quantity = 1;
        }

        $proparent_info = $this->model_catalog_proparent->getProparent($proparent_id);
        $recurring_info = $this->model_catalog_proparent->getProfile($proparent_id, $recurring_id);
        
        $json = array();

        if ($proparent_info && $recurring_info) {
            if (!$json) {
                $frequencies = array(
                    'day' => $this->language->get('text_day'),
                    'week' => $this->language->get('text_week'),
                    'semi_month' => $this->language->get('text_semi_month'),
                    'month' => $this->language->get('text_month'),
                    'year' => $this->language->get('text_year'),
                );

                if ($recurring_info['trial_status'] == 1) {
                    $price = $this->currency->format($this->tax->calculate($recurring_info['trial_price'] * $quantity, $proparent_info['tax_class_id'], $this->config->get('config_tax')));
                    $trial_text = sprintf($this->language->get('text_trial_description'), $price, $recurring_info['trial_cycle'], $frequencies[$recurring_info['trial_frequency']], $recurring_info['trial_duration']) . ' ';
                } else {
                    $trial_text = '';
                }

                $price = $this->currency->format($this->tax->calculate($recurring_info['price'] * $quantity, $proparent_info['tax_class_id'], $this->config->get('config_tax')));

                if ($recurring_info['duration']) {
                    $text = $trial_text . sprintf($this->language->get('text_payment_description'), $price, $recurring_info['cycle'], $frequencies[$recurring_info['frequency']], $recurring_info['duration']);
                } else {
                    $text = $trial_text . sprintf($this->language->get('text_payment_cancel'), $price, $recurring_info['cycle'], $frequencies[$recurring_info['frequency']], $recurring_info['duration']);
                }

                $json['success'] = $text;
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function write() {
        $this->load->language('proparent/product');

        $json = array();

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 25)) {
                $json['error'] = $this->language->get('error_name');
            }

            if ((utf8_strlen($this->request->post['text']) < 25) || (utf8_strlen($this->request->post['text']) > 1000)) {
                $json['error'] = $this->language->get('error_text');
            }

            if (empty($this->request->post['rating']) || $this->request->post['rating'] < 0 || $this->request->post['rating'] > 10) {
                $json['error'] = $this->language->get('error_rating');
            }

            if (empty($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {
                $json['error'] = $this->language->get('error_captcha');
            }

            unset($this->session->data['captcha']);

            if (!isset($json['error'])) {
                $this->load->model('catalog/review');

                $this->model_catalog_review->addPareview($this->request->get['proparent_id'], $this->request->post);

                $json['success'] = $this->language->get('text_success');
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

}
