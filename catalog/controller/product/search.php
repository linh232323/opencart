<?php

class ControllerProductSearch extends Controller {

    public function index() {
        $this->load->language('product/search');
        
        $this->load->language('product/room');
        
        $this->load->language('product/category');
        
        $this->load->model('catalog/category');

        $this->load->model('catalog/room');

        $this->load->model('catalog/hotel');

        $this->load->model('tool/image');
        
        $this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
        $this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');
        $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
        $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
        $this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');
        $this->document->addScript('http://maps.google.com/maps/api/js?sensor=false');
        
        if (isset($this->request->post['search'])) {
            $data['title_search'] = $this->request->post['search'];
        } else {
            $data['title_search'] = '';
        }
        
        if (isset($this->request->post['search'])) {
            $search = $this->request->post['search'];
        } else {
            $search = '';
        }
        
        if (empty($this->request->post['check_in'])) {
            $this->session->data['check_in']=date('Y-m-d');
        }else{
            $this->session->data['check_in']=$this->request->post['check_in'];
        }
        
        if (empty($this->request->post['night'])) {
            $this->session->data['night']= 1 ;
        }else{
            $this->session->data['night']=$this->request->post['night'];
        }
        
        if (empty($this->request->post['check_out'])) {
            $date2=date('d')+2;
            $this->session->data['check_out'] = date('Y').'-'.date('m').'-'.$date2;
        }else{
            $this->session->data['check_out'] = $this->request->post['check_out'];
        }
        
        if (!empty($this->request->post['guestsl'])) {
           $this->session->data['guestsl'] = $this->request->post['guestsl'];
        }else{
            $this->session->data['guestsl'] = "";
        }
        
        if (empty($this->request->post['adults'])) {
            $this->session->data['adults'] = '1';
        }else{
            $this->session->data['adults'] = $this->request->post['adults'];
        }
        
        if (empty($this->request->post['room'])) {
            $this->session->data['room'] = '1';
        }else{
            $this->session->data['room'] = $this->request->post['room'];
        }
        
        if (empty($this->request->post['children'])) {
            $this->session->data['children'] = '0';
        }else{
            $this->session->data['children'] = $this->request->post['children'];
        }

        if (isset($this->request->get['tag'])) {
            $tag = $this->request->get['tag'];
        } elseif (isset($this->request->post['search'])) {
            $tag = $this->request->post['search'];
        } else {
            $tag = '';
        }

        if (isset($this->request->get['description'])) {
            $description = $this->request->get['description'];
        } else {
            $description = '';
        }

        if (isset($this->request->get['category_id'])) {
            $category_id = $this->request->get['category_id'];
        } else {
            $category_id = 0;
        }

        if (isset($this->request->get['sub_category'])) {
            $sub_category = $this->request->get['sub_category'];
        } else {
            $sub_category = '';
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

        if (isset($this->request->post['search'])) {
            $this->document->setTitle($this->language->get('heading_title') . ' - ' . $this->request->post['search']);
        } elseif (isset($this->request->get['tag'])) {
            $this->document->setTitle($this->language->get('heading_title') . ' - ' . $this->language->get('heading_tag') . $this->request->get['tag']);
        } else {
            $this->document->setTitle($this->language->get('heading_title'));
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $url = '';

        if (isset($this->request->post['search'])) {
            $url .= '&search=' . urlencode(html_entity_decode($this->request->post['search'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['tag'])) {
            $url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
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
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('product/search', $url)
        );
        
        
        if (isset($this->request->post['search'])) {
            $data['heading_title'] = $this->language->get('heading_title') . ' - ' . $this->request->post['search'];
        } else {
            $data['heading_title'] = $this->language->get('heading_title');
        }

        $data['title'] = $this->language->get('title');
        $data['text_empty'] = $this->language->get('text_empty');
        $data['text_search'] = $this->language->get('text_search');
        $data['text_keyword'] = $this->language->get('text_keyword');
        $data['text_category'] = $this->language->get('text_category');
        $data['text_sub_category'] = $this->language->get('text_sub_category');
        $data['text_quantity'] = $this->language->get('text_quantity');
        $data['text_manufacturer'] = $this->language->get('text_manufacturer');
        $data['text_model'] = $this->language->get('text_model');
        $data['text_price'] = $this->language->get('text_price');
        $data['text_tax'] = $this->language->get('text_tax');
        $data['text_points'] = $this->language->get('text_points');
        $data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
        $data['text_sort'] = $this->language->get('text_sort');
        $data['text_limit'] = $this->language->get('text_limit');
        $data['text_found'] = $this->language->get('text_found');
        $data['text_hotelin'] = $this->language->get('text_hotelin');
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
        $data['text_labeldate_in'] = $this->language->get('text_labeldate_in');
        $data['text_labeldate_out'] = $this->language->get('text_labeldate_out');
        $data['text_label_guest'] = $this->language->get('text_label_guest');
        $data['text_label_night'] = $this->language->get('text_label_night');
        $data['text_label_room'] = $this->language->get('text_label_room');
        $data['text_label_adults'] = $this->language->get('text_label_adults');
        $data['text_label_children'] = $this->language->get('text_label_children');
        $data['text_1adult'] = $this->language->get('text_1adult');
        $data['text_2adults'] = $this->language->get('text_2adults');
        $data['text_more'] = $this->language->get('text_more');

        $data['label_search'] = $this->language->get('label_search');
        
        $data['entry_description'] = $this->language->get('entry_description');

        $data['button_search'] = $this->language->get('button_search');
        $data['button_cart'] = $this->language->get('button_cart');
        $data['button_wishlist'] = $this->language->get('button_wishlist');
        $data['button_compare'] = $this->language->get('button_compare');
        $data['button_list'] = $this->language->get('button_list');
        $data['button_grid'] = $this->language->get('button_grid');

        $data['compare'] = $this->url->link('room/compare');

        $this->load->model('catalog/category');

        // 3 Level Category Search
        $data['categories'] = array();

        $categories_1 = $this->model_catalog_category->getCategories(0);

        foreach ($categories_1 as $category_1) {
            $level_2_data = array();

            $categories_2 = $this->model_catalog_category->getCategories($category_1['category_id']);

            foreach ($categories_2 as $category_2) {
                $level_3_data = array();

                $categories_3 = $this->model_catalog_category->getCategories($category_2['category_id']);

                foreach ($categories_3 as $category_3) {
                    $level_3_data[] = array(
                        'category_id' => $category_3['category_id'],
                        'name' => $category_3['name'],
                    );
                }

                $level_2_data[] = array(
                    'category_id' => $category_2['category_id'],
                    'name' => $category_2['name'],
                    'children' => $level_3_data
                );
            }

            $data['categories'][] = array(
                'category_id' => $category_1['category_id'],
                'name' => $category_1['name'],
                'children' => $level_2_data
            );
        }

        $data['hotels'] = array();

        if (isset($this->request->post['search']) || isset($this->request->get['tag'])) {
            $filter_data = array(
                'filter_name' => $search,
                'filter_tag' => $tag,
                'filter_description' => $description,
                'filter_category_id' => $category_id,
                'filter_sub_category' => $sub_category,
                'sort' => $sort,
                'order' => $order,
                'start' => ($page - 1) * $limit,
                'limit' => $limit
            );
            
            $hotel_total = $this->model_catalog_hotel->getTotalhotels($filter_data);
           
            $results = $this->model_catalog_hotel->getHotels($filter_data);

            $i = 0;

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
                
                if ($rooms== null){
                    continue;
                }
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
                    'hrefp' => $this->url->link('product/hotel', 'hotel_id=' . $result['hotel_id'] . $url)
                );
                $data['maps'][]= array(
                    'namep' => $result['name'],
                    'maps_apil' => $result['maps_apil'],
                    'maps_apir' => $result['maps_apir']
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
                $data['hotels'][$i]['room_total'] = $room_total;
                if($room_total == 0){
                    unset($data['hotels'][$i]);
                }else{
                    ++$i;
                }
            }
            
            $url = '';

            if (isset($this->request->post['search'])) {
                $url .= '&search=' . urlencode(html_entity_decode($this->request->post['search'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['tag'])) {
                $url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
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

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }
            
            $data['sorts'] = array();

            $data['sorts'][] = array(
                'text' => $this->language->get('text_default'),
                'value' => 'p.sort_order-ASC',
                'href' => $this->url->link('product/search', 'sort=p.sort_order&order=ASC' . $url)
            );

            $data['sorts'][] = array(
                'text' => $this->language->get('text_name_asc'),
                'value' => 'pd.name-ASC',
                'href' => $this->url->link('product/search', 'sort=pd.name&order=ASC' . $url)
            );

            $data['sorts'][] = array(
                'text' => $this->language->get('text_name_desc'),
                'value' => 'pd.name-DESC',
                'href' => $this->url->link('product/search', 'sort=pd.name&order=DESC' . $url)
            );
            
            if ($this->config->get('config_review_status')) {
                $data['sorts'][] = array(
                    'text' => $this->language->get('text_rating_desc'),
                    'value' => 'rating-DESC',
                    'href' => $this->url->link('product/search', 'sort=rating&order=DESC' . $url)
                );

                $data['sorts'][] = array(
                    'text' => $this->language->get('text_rating_asc'),
                    'value' => 'rating-ASC',
                    'href' => $this->url->link('product/search', 'sort=rating&order=ASC' . $url)
                );
            }
            $url = '';

            if (isset($this->request->post['search'])) {
                $url .= '&search=' . urlencode(html_entity_decode($this->request->post['search'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['tag'])) {
                $url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
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
             
            $data['limits'] = array();

            $limits = array_unique(array($this->config->get('config_product_limit'), 25, 50, 75, 100));

            sort($limits);

            foreach ($limits as $value) {
                $data['limits'][] = array(
                    'text' => $value,
                    'value' => $value,
                    'href' => $this->url->link('product/search', $url . '&limit=' . $value)
                );
            }

            $url = '';

            if (isset($this->request->post['search'])) {
                $url .= '&search=' . urlencode(html_entity_decode($this->request->post['search'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['tag'])) {
                $url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
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

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }
            
            $hotel_total = count($data['hotels']);
            $pagination = new Pagination();
            $pagination->total = $hotel_total;
            $pagination->page = $page;
            $pagination->limit = $limit;
            $pagination->url = $this->url->link('product/search', $url . '&page={page}');

            $data['pagination'] = $pagination->render();
            $data['total'] = $hotel_total;
            $data['results'] = sprintf($this->language->get('text_pagination'), ($hotel_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($hotel_total - $limit)) ? $hotel_total : ((($page - 1) * $limit) + $limit), $hotel_total, ceil($hotel_total / $limit));
        }

        $data['search'] = $search;
        $data['description'] = $description;
        $data['category_id'] = $category_id;
        $data['sub_category'] = $sub_category;

        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['limit'] = $limit;

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/search.tpl')) {
            $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/search.tpl', $data));
        } else {
            $this->response->setOutput($this->load->view('default/template/product/search.tpl', $data));
        }
    }

}
