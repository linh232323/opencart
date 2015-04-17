<?php

class ControllerProductCategory extends Controller {

    public function index() {
        $this->load->language('product/category');
        
        $this->load->language('proparent/category');
        
        $this->load->language('proparent/product');

        $this->load->model('catalog/category');

        $this->load->model('catalog/proparent');

        $this->load->model('catalog/product');

        $this->load->model('tool/image');
        
        
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
            $data['text_pareviews'] = $this->language->get('text_pareviews');
            $data['text_labeldate_in'] = $this->language->get('text_labeldate_in');
            $data['text_labeldate_out'] = $this->language->get('text_labeldate_out');
            $data['text_labelguest'] = $this->language->get('text_labelguest');
 
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
                $data['thumb'] = $this->model_tool_image->resize($category_info['image'], 860, 540);
            } else {
                $data['thumb'] = $this->model_tool_image->resize('placeholder.png', 860, 540);
            }

            $data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
            $data['compare'] = $this->url->link('product/compare');

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
            
            
            
            $data['categories'] = array();

            $results = $this->model_catalog_category->getCategories($category_id);

            foreach ($results as $result) {
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
                }

                $filter_data = array(
                    'filter_category_id' => $result['category_id'],
                    'filter_sub_category' => true
                );

                $data['categories'][] = array(
                    'name' => $result['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_proparent->getTotalProparents($filter_data) . ')' : ''),
                    'image' => $image,
                    'wifi' => $result['wifi'],
                    'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
                    'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '_' . $result['category_id'] . $url)
                );
            }

            $data['proparents'] = array();

            $filter_data = array(
                'filter_category_id' => $category_id,
                'filter_filter' => $filter,
                'sort' => $sort,
                'order' => $order,
                'start' => ($page - 1) * $limit,
                'limit' => $limit,
                'filter_sub_category' => true
            );

            $proparent_total = $this->model_catalog_proparent->getTotalProparents($filter_data);

            $results = $this->model_catalog_proparent->getProparents($filter_data);

            $i = 0;
            
            foreach ($results as $result) {
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
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
                    'filter_proparent_id' => $result['proparent_id'],
                    'sort' => $sort,
                    'order' => $order,
                    'start' => ($page - 1) * $limit,
                    'limit' => $limit
                );
                
                $product_total = $this->model_catalog_product->getTotalProducts($filter_dataa);

                $products = $this->model_catalog_product->getProducts($filter_dataa);
                
                if ($products== null){
                    continue;
                }
                
                $data['proparents'][$i] = array(
                    'proparent_id' => $result['proparent_id'],
                    'thumbp' => $image,
                    'namep' => $result['name'],
                    'wifi' => $result['wifi'],
                    'star' => $result['star'],
                    'descriptionp' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
                    'price' => $price,
                    'special' => $special,
                    'tax' => $tax,
                    'ratingp' => $result['rating'],
                    'pareviews' => sprintf($this->language->get('text_pareviews'), (int) $result['pareviews']),
                    'product_total' => $product_total,
                    'hrefp' => $this->url->link('product/proparent', 'proparent_id=' . $result['proparent_id'] . $url)
                );
                
                $product_total = 0 ;
                
                foreach ($products as $product) {
                    
                    if ($this->session->data['adults'] >= $product['maxadults']){
                        continue;
                    }

                    if ($product['image']) {
                        $image = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
                    } else {
                        $image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
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

                    if ($this->config->get('config_review_status')) {
                        $rating = (int) $product['rating'];
                    } else {
                        $rating = false;
                    }
                    
                    $product_prices = $this->model_catalog_product->getProductPrices($product['product_id']);  
                    
                    $had_price = FALSE;
                    
                    foreach ($product_prices as $value) {
                        if ((strtotime($this->session->data['date'])>=strtotime($value['product_date']['1']['date']))&&(strtotime($this->session->data['date'])<=strtotime($value['product_date']['2']['date']))){
                            $price_cost = $this->currency->format($this->tax->calculate($value['product_price_gross'], $product['tax_class_id'], $this->config->get('config_tax')));
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
                    
                    $data['proparents'][$i][] = array(
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
                        'href' => $this->url->link('product/product',  '&product_id=' . $product['product_id'] . $url)
                    );
                    $product_total++;
                }
                $data['proparents'][$i]['product_total'] = $product_total;
                if($product_total == 0){
                    unset($data['proparents'][$i]);
                }else{
                    ++$i;
                }
            }

            $url = '';

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
                'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC' . $url)
            );

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
            
            
            $proparent_total = count($data['proparents']);
            $pagination = new Pagination();
            $pagination->total = $proparent_total;
            $pagination->page = $page;
            $pagination->limit = $limit;
            $pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&page={page}');

            $data['pagination'] = $pagination->render();

            $data['results'] = sprintf($this->language->get('text_pagination'), ($proparent_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($proparent_total - $limit)) ? $proparent_total : ((($page - 1) * $limit) + $limit), $proparent_total, ceil($proparent_total / $limit));

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
