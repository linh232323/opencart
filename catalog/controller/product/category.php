<?php

class ControllerProductCategory extends Controller {

    public function index() {
        $this->load->language('product/category');
        
        $this->load->language('product/search');

        $this->load->model('catalog/category');

        $this->load->model('catalog/hotel');

        $this->load->model('catalog/room');
        
        $this->load->model('catalog/tour');

        $this->load->model('tool/image');
        
        $this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
        $this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');
        $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
        $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
        $this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');
       
        
        if (empty($this->session->data['check_in'])){
             $this->session->data['check_in'] = date('Y-m-d');
        }
        
        if (empty($this->session->data['check_out'])){
           $date2=date('d')+2;
           $this->session->data['check_out'] = date('Y').'-'.date('m').'-'.$date2;
        }
        
        if (empty($this->session->data['night'])){
                $this->session->data['night'] = 1;
        }
        
        if (empty($this->session->data['adults'])){
             $this->session->data['adults'] = 1;
        }
        
        if (empty($this->session->data['guestsl'])){
                $this->session->data['guestsl']= "";
        }
        
        if (empty($this->session->data['children'])){
                  $this->session->data['children'] = 0;
        }
        
        if (empty($this->session->data['room'])){
                  $this->session->data['room'] = 1;
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

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        if (isset($this->request->get['path'])) {
            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }
            
            
        
            $path = '';

            $parts = explode('_', (string) $this->request->get['path']);

            $category_id = (int) array_pop($parts);

            foreach ($parts as $path_id) {
                if (!$path) {
                    $path = (int) $path_id;
                } else {
                    $path .= '_' . (int) $path_id;
                }

                $category_info = $this->model_catalog_category->getCategory($path_id);

                if ($category_info) {
                    $data['breadcrumbs'][] = array(
                        'text' => $category_info['name'],
                        'href' => $this->url->link('product/category', 'path=' . $path . $url)
                    );
                }
            }
        } else {
            $category_id = 0;
        }

        $category_info = $this->model_catalog_category->getCategory($category_id);

        if ($category_info) {
            $this->document->setTitle($category_info['meta_title']);
            $this->document->setDescription($category_info['meta_description']);
            $this->document->setKeywords($category_info['meta_keyword']);
            $this->document->addLink($this->url->link('product/category', 'path=' . $this->request->get['path']), 'canonical');

            $data['heading_title'] = $category_info['name'];

            $data['text_refine'] = $this->language->get('text_refine');
            $data['text_empty'] = $this->language->get('text_empty');
            $data['text_search'] = $this->language->get('text_search');
            $data['text_keyword'] = $this->language->get('text_keyword');
            $data['text_quantity'] = $this->language->get('text_quantity');
            $data['text_manufacturer'] = $this->language->get('text_manufacturer');
            $data['text_model'] = $this->language->get('text_model');
            $data['text_price'] = $this->language->get('text_price');
            $data['text_tax'] = $this->language->get('text_tax');
            $data['text_points'] = $this->language->get('text_points');
            $data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
            $data['text_sort'] = $this->language->get('text_sort');
            $data['text_limit'] = $this->language->get('text_limit');
            $data['text_readmore'] = $this->language->get('text_readmore');
            $data['text_book'] = $this->language->get('text_book');
            $data['text_ourlast'] = $this->language->get('text_ourlast');
            $data['text_ourlastroom'] = $this->language->get('text_ourlastroom');
            $data['text_rooms'] = $this->language->get('text_rooms');
            $data['text_available'] = $this->language->get('text_available');
            $data['text_freewifi'] = $this->language->get('text_freewifi');
            $data['text_nowifi'] = $this->language->get('text_nowifi');
            $data['text_rate_superb'] = $this->language->get('text_rate_superb');
            $data['text_rate_fantastic'] = $this->language->get('text_rate_fantastic');
            $data['text_rate_verygood'] = $this->language->get('text_rate_verygood');
            $data['text_rate_good'] = $this->language->get('text_rate_good');
            $data['text_rate_bad'] = $this->language->get('text_rate_bad');
            $data['text_hotelreviews'] = $this->language->get('text_hotelreviews');
            $data['text_labeldate_in'] = $this->language->get('text_labeldate_in');
            $data['text_labeldate_out'] = $this->language->get('text_labeldate_out');
            $data['text_label_night'] = $this->language->get('text_label_night');
            $data['text_label_guest'] = $this->language->get('text_label_guest');
            $data['text_1adult'] = $this->language->get('text_1adult');
            $data['text_2adults'] = $this->language->get('text_2adults');
            $data['text_more'] = $this->language->get('text_more');
            $data['text_label_room'] = $this->language->get('text_label_room');
            $data['text_label_adults'] = $this->language->get('text_label_adults');
            $data['text_label_children'] = $this->language->get('text_label_children');
            $data['text_stock'] = $this->language->get('text_stock');
 
            $data['entry_search'] = $this->language->get('entry_search');
        
            $data['button_cart'] = $this->language->get('button_cart');
            $data['button_wishlist'] = $this->language->get('button_wishlist');
            $data['button_compare'] = $this->language->get('button_compare');
            $data['button_continue'] = $this->language->get('button_continue');
            $data['button_list'] = $this->language->get('button_list');
            $data['button_grid'] = $this->language->get('button_grid');
            $data['button_search'] = $this->language->get('button_search');

            // Set the last category breadcrumb
            $data['breadcrumbs'][] = array(
                'text' => $category_info['name'],
                'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'])
            );

            if ($category_info['image']) {
                $data['thumb'] = $this->model_tool_image->resizetoWidth($category_info['image'], $this->config->get('config_image_popup_width'));
            } else {
                $data['thumb'] = $this->model_tool_image->resizetoWidth('placeholder.png', $this->config->get('config_image_popup_width'));
            }

            $data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
            $data['compare'] = $this->url->link('room/compare');

            $url = '';

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }
            
            $url = '';
            
            $data['sorts'] = array();
            
            $data['sorts'][] = array(
                'text' => $this->language->get('text_default'),
                'value' => 'p.sort_order-ASC',
                'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC' . $url)
            );

            $data['categories'] = array();

            $results = $this->model_catalog_category->getCategories($category_id);

            foreach ($results as $result) {
                if ($result['image']) {
                    $image = $this->model_tool_image->resizetoWidth($result['image'], $this->config->get('config_image_product_width'));
                } else {
                    $image = $this->model_tool_image->resizetoWidth('placeholder.png', $this->config->get('config_image_product_width'));
                }

                $filter_data = array(
                    'filter_category_id' => $result['category_id'],
                    'filter_sub_category' => true
                );

                $data['categories'][] = array(
                    'name' => $result['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_hotel->getTotalhotels($filter_data) . ')' : ''),
                    'image' => $image,
                    'wifi' => $result['wifi'],
                    'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
                    'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '_' . $result['category_id'] . $url)
                );
            }

            $data['hotels'] = array();

            $filter_data = array(
                'filter_category_id' => $category_id,
                'filter_filter' => $filter,
                'sort' => $sort,
                'order' => $order,
                'start' => ($page - 1) * $limit,
                'limit' => $limit,
                'filter_sub_category' => true
            );

            $hotel_total = $this->model_catalog_hotel->getTotalhotels($filter_data);

            $results = $this->model_catalog_hotel->getHotels($filter_data);

            $i = 0;
            if ($results){
                
                $data['sorts'][] = array(
                    'text' => $this->language->get('text_star_asc'),
                    'value' => 'p.star-ASC',
                    'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.star&order=ASC' . $url)
                );

                $data['sorts'][] = array(
                    'text' => $this->language->get('text_star_desc'),
                    'value' => 'p.star-DESC',
                    'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.star&order=DESC' . $url)
                );

            }
            foreach ($results as $result) {
                
                if ($result['image']) {
                    $image = $this->model_tool_image->resizetoWidth($result['image'], $this->config->get('config_image_product_width'));
                } else {
                    $image = $this->model_tool_image->resizetoWidth('placeholder.png', $this->config->get('config_image_product_width'));
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

                if ($this->config->get('config_review_status')) {
                    $rating = (int) $result['rating'];
                } else {
                    $rating = false;
                }

                
                
                $filter_dataa = array(
                    'filter_hotel_id' => $result['hotel_id'],
                    'sort' => $sort,
                    'order' => $order,
                    'start' => ($page - 1) * $limit,
                    'limit' => $limit
                );
                
                $room_total = $this->model_catalog_room->getTotalRooms($filter_dataa);

                $rooms = $this->model_catalog_room->getRooms($filter_dataa);
                
                
                $data['hotels'][$i] = array(
                    'hotel_id' => $result['hotel_id'],
                    'thumbp' => $image,
                    'namep' => $result['name'],
                    'wifi' => $result['wifi'],
                    'star' => $result['star'],
                    'descriptionp' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
                    'price' => $price,
                    'special' => $special,
                    'tax' => $tax,
                    'ratingp' => $result['rating'],
                    'hotelreviews' => sprintf($this->language->get('text_hotelreviews'), (int) $result['hotelreviews']),
                    'room_total' => $room_total,
                    'hrefp' => $this->url->link('product/hotel','path=' . $this->request->get['path'] . '&hotel_id=' . $result['hotel_id'] . $url)
                );
                
                $room_total = 0 ;
                
                foreach ($rooms as $room) {
                    
                    if ($this->session->data['adults'] > $room['maxadults']){
                        continue;
                    }

                    if ($room['image']) {
                        $image = $this->model_tool_image->resizetoWidth($room['image'], $this->config->get('config_image_product_width'));
                    } else {
                        $image = $this->model_tool_image->resizetoWidth('placeholder.png', $this->config->get('config_image_product_width'));
                    }

                    if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                        $price = $this->currency->format($this->tax->calculate($room['price'], $room['tax_class_id'], $this->config->get('config_tax')));
                    } else {
                        $price = false;
                    }

                    if ((float) $room['special']) {
                        $special = $this->currency->format($this->tax->calculate($room['special'], $room['tax_class_id'], $this->config->get('config_tax')));
                    } else {
                        $special = false;
                    }

                    if ($this->config->get('config_tax')) {
                        $tax = $this->currency->format((float) $room['special'] ? $room['special'] : $room['price']);
                    } else {
                        $tax = false;
                    }

                    if ($this->config->get('config_review_status')) {
                        $rating = (int) $room['rating'];
                    } else {
                        $rating = false;
                    }
                    
                    $room_prices = $this->model_catalog_room->getRoomPrices($room['room_id']);  
                    
                    $had_price = FALSE;
                    
                    foreach ($room_prices as $value) {
                        if ((strtotime($this->session->data['check_in'])>=strtotime($value['room_date']['1']['date']))&&(strtotime($this->session->data['check_in'])<=strtotime($value['room_date']['2']['date']))){
                            $price_cost = $this->currency->format($this->tax->calculate($value['room_price_gross'], $room['tax_class_id'], $this->config->get('config_tax')));
                            $had_price = TRUE;
                        }else{
                            $price_cost='';
                        }
                        $data['room_prices'][] =array(
                         'room_price_value'   => $price_cost,
                         'room_date'          => $value['room_date'],
                         'room_id'            => $value['room_id']
                        ); 
                    }
                    
                    $date_in = date_create($this->session->data['check_in']);
                    $check_in = date_format($date_in, 'Ymd');
                    $date_out = date_create($this->session->data['check_out']);
                    $check_out = date_format($date_out, 'Ymd');
                    
                    $stock= $this->model_catalog_room->getStock($room['room_id'],$check_in,$check_out);

                    if (($room['quantity'] - $stock)  <= 0 || $had_price == FALSE){
                        continue;
                    }

                    $data['hotels'][$i][] = array(
                        'room_id' => $room['room_id'],
                        'thumb' => $image,
                        'name' => $room['name'],
                        'description' => utf8_substr(strip_tags(html_entity_decode($room['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
                        'room_deal' => utf8_substr(strip_tags(html_entity_decode($room['room_deal'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
                        'price' => $price,
                        'quantity' => $room['quantity'] - $stock,
                        'maxadults' => $room['maxadults'],
                        'special' => $special,
                        'tax' => $tax,
                        'rating' => $room['rating'],
                        'href' => $this->url->link('product/room',  '&room_id=' . $room['room_id'] . $url)
                    );
                    $room_total++;
                }
                $i++;
            }

            $results = $this->model_catalog_tour->getTours($filter_data);
            
            $total_tours = $this->model_catalog_tour->getTotalTours($filter_data);
            
            $data['tours'] = array();
            
            foreach ($results as $result) {
                if ($result['image']) {
                    $image = $this->model_tool_image->resizetoWidth($result['image'], $this->config->get('config_image_product_width'));
                } else {
                    $image = $this->model_tool_image->resizetoWidth('placeholder.png', $this->config->get('config_image_product_width'));
                }
                $tour_prices = $this->model_catalog_tour->getTourPrices($result['tour_id']);  
                    
                $had_price = FALSE;

                foreach ($tour_prices as $value) {
                    if ((strtotime($this->session->data['check_in'])>=strtotime($value['tour_date']['1']['date']))&&(strtotime($this->session->data['check_in'])<=strtotime($value['tour_date']['2']['date']))){
                        $price_cost = $this->currency->format($this->tax->calculate($value['tour_adult_gross'], $result['tax_class_id'], $this->config->get('config_tax')));
                        $had_price = TRUE;
                    }else{
                        $price_cost='';
                    }
                    $data['tour_prices'][] =array(
                     'tour_price_value'   => $price_cost,
                     'tour_date'          => $value['tour_date'],
                     'tour_id'            => $value['tour_id']
                    ); 
                }

                $date_in = date_create($this->session->data['check_in']);
                $check_in = date_format($date_in, 'Ymd');
                $date_out = date_create($this->session->data['check_out']);
                $check_out = date_format($date_out, 'Ymd');

                if ($had_price == FALSE){
                    continue;
                }
                
                $data['tours'][] = array(
                    'tour_id' => $result['tour_id'],
                    'thumb' => $image,
                    'name' => $result['name'],
                    'quantity' => $result['quantity'],
                    'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
                    'rating' => $result['rating'],
                    'tour_reviews' => sprintf($this->language->get('text_tour_reviews'), (int) $result['tour_reviews']),
                    'href' => $this->url->link('product/tour','path=' . $this->request->get['path'] . '&tour_id=' . $result['tour_id'] . $url)
                );
                
            }


            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }
            
            $data['sorts'][] = array(
                'text' => $this->language->get('text_name_asc'),
                'value' => 'pd.name-ASC',
                'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=ASC' . $url)
            );

            $data['sorts'][] = array(
                'text' => $this->language->get('text_name_desc'),
                'value' => 'pd.name-DESC',
                'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=DESC' . $url)
            );
            
            if ($this->config->get('config_review_status')) {
                $data['sorts'][] = array(
                    'text' => $this->language->get('text_rating_desc'),
                    'value' => 'rating-DESC',
                    'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=DESC' . $url)
                );

                $data['sorts'][] = array(
                    'text' => $this->language->get('text_rating_asc'),
                    'value' => 'rating-ASC',
                    'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=ASC' . $url)
                );
            }
            $url = '';

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
                    'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&limit=' . $value)
                );
            }

            $url = '';

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }
            if( count($data['hotels'])!=0){
                $total =  count($data['hotels']);
            }else{
                $total = $total_tours;
            }
            $pagination = new Pagination();
            $pagination->total = $total;
            $pagination->page = $page;
            $pagination->limit = $limit;
            $pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&page={page}');

            $data['pagination'] = $pagination->render();

            $data['results'] = sprintf($this->language->get('text_pagination'), ($total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($total - $limit)) ? $total : ((($page - 1) * $limit) + $limit), $total, ceil($total / $limit));

            $data['sort'] = $sort;
            $data['order'] = $order;
            $data['limit'] = $limit;

            $data['continue'] = $this->url->link('common/home');

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/category.tpl')) {
                $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/category.tpl', $data));
            } else {
                $this->response->setOutput($this->load->view('default/template/product/category.tpl', $data));
            }
        } else {
            $url = '';

            if (isset($this->request->get['path'])) {
                $url .= '&path=' . $this->request->get['path'];
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

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }
            
            
            
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_error'),
                'href' => $this->url->link('product/category', $url)
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

}
