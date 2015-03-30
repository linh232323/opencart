<?php echo $header; print "</pre>";
print_r  ($pagination);?>

<div class="container">
    <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
    </ul>
    <div class="row"><?php echo $column_left; ?>
        <?php if ($column_left && $column_right) { ?>
        <?php $class = 'col-sm-6'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
        <?php $class = 'col-sm-9'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-12'; ?>
        <?php } ?>
        <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
            <div class="row">
                <?php if ($column_left && $column_right) { ?>
                <?php $class = 'col-sm-6'; ?>
                <?php } elseif ($column_left || $column_right) { ?>
                <?php $class = 'col-sm-6'; ?>
                <?php } else { ?>
                <?php $class = 'col-sm-8'; ?>
                <?php } ?>
                <div class="<?php echo $class; ?>">
                    <?php if ($images || $thumb) { ?>
                    <?php if ($images) { ?>
                    <div id="sync1" class="owl-carousel">
                        <?php if ($thumb) { ?><div class="item"><img src="<?php echo $thumb; ?>"/></div><?php } ?><?php foreach ($images as $image) { ?><div class="item"><img src="<?php echo $image['image']; ?>"/></div><?php } ?>
                    </div>
                    <div id="sync2" class="owl-carousel">
                        <?php if ($thumb) { ?><div class="item"><img src="<?php echo $thumbc; ?>"/></div><?php } ?><?php foreach ($images as $image) { ?><div class="item"><img src="<?php echo $image['thumb']; ?>"/></div><?php } ?>
                    </div>
                    <?php } ?>
                    <?php } ?>
                    <?php if ($products) { ?>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="btn-group hidden-xs">
                                <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_list; ?>"><i class="fa fa-th-list"></i></button>
                                <!-- <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_grid; ?>"><i class="fa fa-th"></i></button> -->
                            </div>
                        </div>
                        <div class="col-md-2 text-right">
                            <label class="control-label" for="input-sort"><?php echo $text_sort; ?></label>
                        </div>
                        <div class="col-md-3 text-right">
                            <select id="input-sort" class="form-control" onchange="location = this.value;">
                                <?php foreach ($sorts as $sorts) { ?>
                                <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
                                <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-1 text-right">
                            <label class="control-label" for="input-limit"><?php echo $text_limit; ?></label>
                        </div>
                        <div class="col-md-2 text-right">
                            <select id="input-limit" class="form-control" onchange="location = this.value;">
                                <?php foreach ($limits as $limits) { ?>
                                <?php if ($limits['value'] == $limit) { ?>
                                <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="product-layout product-list col-xs-12">
                            <table class="table table-bordered table-hover table-striped">
                                <th class = "col-xs-3 text-center"><?php echo $text_room;?></th>
                                <th class = "col-xs-1 text-center"><?php echo $text_max_adults;?></th>
                                <th class = " text-center"><?php echo $text_rate;?></th>
                                <th class = "col-xs-2"></th>
                            </table>
                            <?php foreach ($products as $product) { ?>
                            <div class="product-thumb">
                                <table  class="table table-bordered table-hover table-striped">
                                    <tr>
                                        <td class="col-xs-3">
                                            <strong><a href="<?php echo $product['href'];?>"><?php echo $product['name'];?></a></strong>
                                            <a href="<?php echo $product['href'];?>"><img src="<?php echo $product['thumb'];?>" alt="<?php echo $product['name'];?>" title="<?php echo $product['name'];?>" class="img-responsive"></a>
                                            <p><?php echo $product['description'];?></p>
                                        </td>
                                        <td class="col-xs-1 text-center">
                                            <?php if ($product['maxadults'] == 1){ ?>
                                            <i class="glyphicon glyphicon-user"></i> 
                                            <?php } else { if ($product['maxadults'] == 2) { ?>
                                            <i class="glyphicon glyphicon-user"></i> <i class="glyphicon glyphicon-user"></i> 
                                            <?php } else { ?>
                                            <i class="glyphicon glyphicon-user"></i> <i class="glyphicon glyphicon-user"></i> <i class="glyphicon glyphicon-user"></i> 
                                            <?php } ?>
                                            <?php } ?>
                                        </td>
                                        <td class = "text-center">
                                            <strong class="text-primary"><?php echo $product['price'];?></strong>
                                        </td>
                                        <td class="col-xs-2">
                                            <a href="<?php echo $product['href'];?>"><button type="button" class="btn btn-primary btn-lg btn-block"><i class="fa fa-shopping-cart"></i> <?php echo $text_book; ?></button></a>
                                            <?php if ($product['quantity'] == 1){ ?>
                                            <strong class="text-danger">Our last room !!!</strong>
                                            <?php } else { if ($product['quantity'] <= 5) { ?>
                                            <strong class="text-warning">Our last <?php echo $proparent[$i]['quantity'];?> room </strong>
                                            <?php } else { ?>
                                            <strong class="text-success">Available</strong>
                                            <?php } ?>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
                        <div class="col-sm-6 text-right"><?php echo $results; ?></div>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-description" data-toggle="tab"><?php echo $tab_description; ?></a></li>
                        <?php if ($attribute_groups) { ?>
                        <li><a href="#tab-specification" data-toggle="tab"><?php echo $tab_attribute; ?></a></li>
                        <?php } ?>
                        <?php if ($pareview_status) { ?>
                        <li><a href="#tab-pareview" data-toggle="tab"><?php echo $tab_pareview; ?></a></li>
                        <?php } ?>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-description"><?php echo $description; ?></div>
                        <?php if ($attribute_groups) { ?>
                        <div class="tab-pane" id="tab-specification">
                            <table class="table table-bordered">
                                <?php foreach ($attribute_groups as $attribute_group) { ?>
                                <thead>
                                    <tr>
                                        <td colspan="2"><strong><?php echo $attribute_group['name']; ?></strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
                                    <tr>
                                        <td><?php echo $attribute['name']; ?></td>
                                        <td><?php echo $attribute['text']; ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <?php } ?>
                            </table>
                        </div>
                        <?php } ?>
                        <?php if ($pareview_status) { ?>
                        <div class="tab-pane" id="tab-pareview">
                            <form class="form-horizontal">
                                <div id="pareview"></div>
                                <h2><?php echo $text_write; ?></h2>
                                <?php if ($pareview_guest) { ?>
                                <div class="form-group required">
                                    <div class="col-sm-12">
                                        <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                                        <input type="text" name="name" value="" id="input-name" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group required">
                                    <div class="col-sm-12">
                                        <label class="control-label" for="input-pareview"><?php echo $entry_pareview; ?></label>
                                        <textarea name="text" rows="5" id="input-pareview" class="form-control"></textarea>
                                        <div class="help-block"><?php echo $text_note; ?></div>
                                    </div>
                                </div>
                                <div class="form-group required">
                                    <div class="col-sm-12">
                                        <label class="control-label"><?php echo $entry_rating; ?></label>
                                        &nbsp;&nbsp;&nbsp; <?php echo $entry_bad; ?>&nbsp;
                                        <input type="radio" name="rating" value="1" />
                                        &nbsp;
                                        <input type="radio" name="rating" value="2" />
                                        &nbsp;
                                        <input type="radio" name="rating" value="3" />
                                        &nbsp;
                                        <input type="radio" name="rating" value="4" />
                                        &nbsp;
                                        <input type="radio" name="rating" value="5" />
                                        &nbsp;<?php echo $entry_good; ?></div>
                                </div>
                                <div class="form-group required">
                                    <div class="col-sm-12">
                                        <label class="control-label" for="input-captcha"><?php echo $entry_captcha; ?></label>
                                        <input type="text" name="captcha" value="" id="input-captcha" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12"> <img src="index.php?route=tool/captcha" alt="" id="captcha" /> </div>
                                </div>
                                <div class="buttons">
                                    <div class="pull-right">
                                        <button type="button" id="button-pareview" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><?php echo $button_continue; ?></button>
                                    </div>
                                </div>
                                <?php } else { ?>
                                <?php echo $text_login; ?>
                                <?php } ?>
                            </form>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <?php if ($column_left && $column_right) { ?>
                <?php $class = 'col-sm-6'; ?>
                <?php } elseif ($column_left || $column_right) { ?>
                <?php $class = 'col-sm-6'; ?>
                <?php } else { ?>
                <?php $class = 'col-sm-4'; ?>
                <?php } ?>
                <div class="<?php echo $class; ?>">
                    <div class="btn-group">
                        <button type="button" data-toggle="tooltip" class="btn btn-default" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $proparent_id; ?>');"><i class="fa fa-heart"></i></button>
                        <button type="button" data-toggle="tooltip" class="btn btn-default" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $proparent_id; ?>');"><i class="fa fa-exchange"></i></button>
                    </div>
                    <h1><?php echo $heading_title; ?></h1>
                    <ul class="list-unstyled">
                        <?php if ($manufacturer) { ?>
                        <li><?php echo $text_manufacturer; ?> <a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a></li>
                        <?php } ?>
                        <li><?php echo $text_model; ?> <?php echo $model; ?></li>
                        <?php if ($reward) { ?>
                        <li><?php echo $text_reward; ?> <?php echo $reward; ?></li>
                        <?php } ?>
                        <li><?php echo $text_stock; ?> <?php echo $stock; ?></li>
                    </ul>
                    <?php if ($price) { ?>
                    <ul class="list-unstyled">
                        <?php if (!$special) { ?>
                        <li>
                            <h2><?php echo $price; ?></h2>
                        </li>
                        <?php } else { ?>
                        <li><span style="text-decoration: line-through;"><?php echo $price; ?></span></li>
                        <li>
                            <h2><?php echo $special; ?></h2>
                        </li>
                        <?php } ?>
                        <?php if ($tax) { ?>
                        <li><?php echo $text_tax; ?> <?php echo $tax; ?></li>
                        <?php } ?>
                        <?php if ($points) { ?>
                        <li><?php echo $text_points; ?> <?php echo $points; ?></li>
                        <?php } ?>
                        <?php if ($discounts) { ?>
                        <li>
                            <hr>
                        </li>
                        <?php foreach ($discounts as $discount) { ?>
                        <li><?php echo $discount['quantity']; ?><?php echo $text_discount; ?><?php echo $discount['price']; ?></li>
                        <?php } ?>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                    <div id="proparent">
                        <?php if ($options) { ?>
                        <hr>
                        <h3><?php echo $text_option; ?></h3>
                        <?php foreach ($options as $option) { ?>
                        <?php if ($option['type'] == 'select') { ?>
                        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                            <label class="control-label" for="input-option<?php echo $option['proparent_option_id']; ?>"><?php echo $option['name']; ?></label>
                            <select name="option[<?php echo $option['proparent_option_id']; ?>]" id="input-option<?php echo $option['proparent_option_id']; ?>" class="form-control">
                                <option value=""><?php echo $text_select; ?></option>
                                <?php foreach ($option['proparent_option_value'] as $option_value) { ?>
                                <option value="<?php echo $option_value['proparent_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                                    <?php if ($option_value['price']) { ?>
                                    (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                                    <?php } ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php } ?>
                        <?php if ($option['type'] == 'radio') { ?>
                        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                            <label class="control-label"><?php echo $option['name']; ?></label>
                            <div id="input-option<?php echo $option['proparent_option_id']; ?>">
                                <?php foreach ($option['proparent_option_value'] as $option_value) { ?>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="option[<?php echo $option['proparent_option_id']; ?>]" value="<?php echo $option_value['proparent_option_value_id']; ?>" />
                                        <?php echo $option_value['name']; ?>
                                        <?php if ($option_value['price']) { ?>
                                        (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                                        <?php } ?>
                                    </label>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if ($option['type'] == 'checkbox') { ?>
                        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                            <label class="control-label"><?php echo $option['name']; ?></label>
                            <div id="input-option<?php echo $option['proparent_option_id']; ?>">
                                <?php foreach ($option['proparent_option_value'] as $option_value) { ?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="option[<?php echo $option['proparent_option_id']; ?>][]" value="<?php echo $option_value['proparent_option_value_id']; ?>" />
                                        <?php echo $option_value['name']; ?>
                                        <?php if ($option_value['price']) { ?>
                                        (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                                        <?php } ?>
                                    </label>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if ($option['type'] == 'image') { ?>
                        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                            <label class="control-label"><?php echo $option['name']; ?></label>
                            <div id="input-option<?php echo $option['proparent_option_id']; ?>">
                                <?php foreach ($option['proparent_option_value'] as $option_value) { ?>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="option[<?php echo $option['proparent_option_id']; ?>]" value="<?php echo $option_value['proparent_option_value_id']; ?>" />
                                        <img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" /> <?php echo $option_value['name']; ?>
                                        <?php if ($option_value['price']) { ?>
                                        (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                                        <?php } ?>
                                    </label>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if ($option['type'] == 'text') { ?>
                        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                            <label class="control-label" for="input-option<?php echo $option['proparent_option_id']; ?>"><?php echo $option['name']; ?></label>
                            <input type="text" name="option[<?php echo $option['proparent_option_id']; ?>]" value="<?php echo $option['value']; ?>" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['proparent_option_id']; ?>" class="form-control" />
                        </div>
                        <?php } ?>
                        <?php if ($option['type'] == 'textarea') { ?>
                        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                            <label class="control-label" for="input-option<?php echo $option['proparent_option_id']; ?>"><?php echo $option['name']; ?></label>
                            <textarea name="option[<?php echo $option['proparent_option_id']; ?>]" rows="5" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['proparent_option_id']; ?>" class="form-control"><?php echo $option['value']; ?></textarea>
                        </div>
                        <?php } ?>
                        <?php if ($option['type'] == 'file') { ?>
                        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                            <label class="control-label"><?php echo $option['name']; ?></label>
                            <button type="button" id="button-upload<?php echo $option['proparent_option_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default btn-block"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
                            <input type="hidden" name="option[<?php echo $option['proparent_option_id']; ?>]" value="" id="input-option<?php echo $option['proparent_option_id']; ?>" />
                        </div>
                        <?php } ?>
                        <?php if ($option['type'] == 'date') { ?>
                        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                            <label class="control-label" for="input-option<?php echo $option['proparent_option_id']; ?>"><?php echo $option['name']; ?></label>
                            <div class="input-group date">
                                <input type="text" name="option[<?php echo $option['proparent_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD" id="input-option<?php echo $option['proparent_option_id']; ?>" class="form-control" />
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                                </span></div>
                        </div>
                        <?php } ?>
                        <?php if ($option['type'] == 'datetime') { ?>
                        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                            <label class="control-label" for="input-option<?php echo $option['proparent_option_id']; ?>"><?php echo $option['name']; ?></label>
                            <div class="input-group datetime">
                                <input type="text" name="option[<?php echo $option['proparent_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-option<?php echo $option['proparent_option_id']; ?>" class="form-control" />
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                </span></div>
                        </div>
                        <?php } ?>
                        <?php if ($option['type'] == 'time') { ?>
                        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                            <label class="control-label" for="input-option<?php echo $option['proparent_option_id']; ?>"><?php echo $option['name']; ?></label>
                            <div class="input-group time">
                                <input type="text" name="option[<?php echo $option['proparent_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="HH:mm" id="input-option<?php echo $option['proparent_option_id']; ?>" class="form-control" />
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                </span></div>
                        </div>
                        <?php } ?>
                        <?php } ?>
                        <?php } ?>
                        <?php if ($recurrings) { ?>
                        <hr>
                        <h3><?php echo $text_payment_recurring ?></h3>
                        <div class="form-group required">
                            <select name="recurring_id" class="form-control">
                                <option value=""><?php echo $text_select; ?></option>
                                <?php foreach ($recurrings as $recurring) { ?>
                                <option value="<?php echo $recurring['recurring_id'] ?>"><?php echo $recurring['name'] ?></option>
                                <?php } ?>
                            </select>
                            <div class="help-block" id="recurring-description"></div>
                        </div>
                        <?php } ?>
                        <div class="form-group">
                            <label class="control-label" for="input-quantity"><?php echo $entry_qty; ?></label>
                            <input type="text" name="quantity" value="<?php echo $minimum; ?>" size="2" id="input-quantity" class="form-control" />
                            <input type="hidden" name="proparent_id" value="<?php echo $proparent_id; ?>" />
                            <br />
                            <button type="button" id="button-cart" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary btn-lg btn-block"><?php echo $button_cart; ?></button>
                        </div>
                        <?php if ($minimum > 1) { ?>
                        <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_minimum; ?></div>
                        <?php } ?>
                    </div>
                    <?php if ($pareview_status) { ?>
                    <div class="rating">
                        <p>
                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <?php if ($rating < $i) { ?>
                            <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                            <?php } else { ?>
                            <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                            <?php } ?>
                            <?php } ?>
                            <a href="" onclick="$('a[href=\'#tab-pareview\']').trigger('click'); return false;"><?php echo $pareviews; ?></a> / <a href="" onclick="$('a[href=\'#tab-pareview\']').trigger('click'); return false;"><?php echo $text_write; ?></a></p>
                        <hr>
                        <!-- AddThis Button BEGIN -->
                        <div class="addthis_toolbox addthis_default_style"><a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> <a class="addthis_button_tweet"></a> <a class="addthis_button_pinterest_pinit"></a> <a class="addthis_counter addthis_pill_style"></a></div>
                        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-515eeaf54693130e"></script> 
                        <!-- AddThis Button END --> 
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php if ($proparents) { ?>
            <h3><?php echo $text_related; ?></h3>
            <div class="row">
                <?php $i = 0; ?>
                <?php foreach ($proparents as $proparent) { ?>
                <?php if ($column_left && $column_right) { ?>
                <?php $class = 'col-lg-6 col-md-6 col-sm-12 col-xs-12'; ?>
                <?php } elseif ($column_left || $column_right) { ?>
                <?php $class = 'col-lg-4 col-md-4 col-sm-6 col-xs-12'; ?>
                <?php } else { ?>
                <?php $class = 'col-lg-3 col-md-3 col-sm-6 col-xs-12'; ?>
                <?php } ?>
                <div class="<?php echo $class; ?>">
                    <div class="proparent-thumb transition">
                        <div class="image"><a href="<?php echo $proparent['href']; ?>"><img src="<?php echo $proparent['thumb']; ?>" alt="<?php echo $proparent['name']; ?>" title="<?php echo $proparent['name']; ?>" class="img-responsive" /></a></div>
                        <div class="caption">
                            <h4><a href="<?php echo $proparent['href']; ?>"><?php echo $proparent['name']; ?></a></h4>
                            <p><?php echo $proparent['description']; ?></p>
                            <?php if ($proparent['rating']) { ?>
                            <div class="rating">
                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                <?php if ($proparent['rating'] < $i) { ?>
                                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                                <?php } else { ?>
                                <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                                <?php } ?>
                                <?php } ?>
                            </div>
                            <?php } ?>
                            <?php if ($proparent['price']) { ?>
                            <p class="price">
                                <?php if (!$proparent['special']) { ?>
                                <?php echo $proparent['price']; ?>
                                <?php } else { ?>
                                <span class="price-new"><?php echo $proparent['special']; ?></span> <span class="price-old"><?php echo $proparent['price']; ?></span>
                                <?php } ?>
                                <?php if ($proparent['tax']) { ?>
                                <span class="price-tax"><?php echo $text_tax; ?> <?php echo $proparent['tax']; ?></span>
                                <?php } ?>
                            </p>
                            <?php } ?>
                        </div>
                        <div class="button-group">
                            <button type="button" onclick="cart.add('<?php echo $proparent['proparent_id']; ?>');"><span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span> <i class="fa fa-shopping-cart"></i></button>
                            <button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $proparent['proparent_id']; ?>');"><i class="fa fa-heart"></i></button>
                            <button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $proparent['proparent_id']; ?>');"><i class="fa fa-exchange"></i></button>
                        </div>
                    </div>
                </div>
                <?php if (($column_left && $column_right) && ($i % 2 == 0)) { ?>
                <div class="clearfix visible-md visible-sm"></div>
                <?php } elseif (($column_left || $column_right) && ($i % 3 == 0)) { ?>
                <div class="clearfix visible-md"></div>
                <?php } elseif ($i % 4 == 0) { ?>
                <div class="clearfix visible-md"></div>
                <?php } ?>
                <?php $i++; ?>
                <?php } ?>
            </div>
            <?php } ?>
            <?php if ($tags) { ?>
            <p><?php echo $text_tags; ?>
                <?php for ($i = 0; $i < count($tags); $i++) { ?>
                <?php if ($i < (count($tags) - 1)) { ?>
                <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>,
                <?php } else { ?>
                <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
                <?php } ?>
                <?php } ?>
            </p>
            <?php } ?>
            <?php echo $content_bottom; ?></div>
        <?php echo $column_right; ?></div>
</div>
<script type="text/javascript"><!--
$('select[name=\'recurring_id\'], input[name="quantity"]').change(function(){
    $.ajax({
    url: 'index.php?route=product/proparent/getRecurringDescription',
            type: 'post',
            data: $('input[name=\'proparent_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
            dataType: 'json',
            beforeSend: function() {
            $('#recurring-description').html('');
            },
            success: function(json) {
            $('.alert, .text-danger').remove();
                    if (json['success']) {
            $('#recurring-description').html(json['success']);
            }
            }
    });
    });
//--></script> 
<script type="text/javascript"><!--
$('#button-cart').on('click', function() {
    $.ajax({
    url: 'index.php?route=checkout/cart/add',
            type: 'post',
            data: $('#proparent input[type=\'text\'], #proparent input[type=\'hidden\'], #proparent input[type=\'radio\']:checked, #proparent input[type=\'checkbox\']:checked, #proparent select, #proparent textarea'),
            dataType: 'json',
            beforeSend: function() {
            $('#button-cart').button('loading');
            },
            complete: function() {
            $('#button-cart').button('reset');
            },
            success: function(json) {
            $('.alert, .text-danger').remove();
                    $('.form-group').removeClass('has-error');
                    if (json['error']) {
            if (json['error']['option']) {
            for (i in json['error']['option']) {
            var element = $('#input-option' + i.replace('_', '-'));
                    if (element.parent().hasClass('input-group')) {
            element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
            } else {
            element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
            }
            }
            }

            if (json['error']['recurring']) {
            $('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
            }

            // Highlight any found errors
            $('.text-danger').parent().addClass('has-error');
            }

            if (json['success']) {
            $('.breadcrumb').after('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                    $('#cart-total').html(json['total']);
                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                    $('#cart > ul').load('index.php?route=common/cart/info ul li');
            }
            }
    });
    });
//--></script> 
<script type="text/javascript"><!--
$('.date').datetimepicker({
    pickTime: false
    });
            $('.datetime').datetimepicker({
    pickDate: true,
            pickTime: true
    });
            $('.time').datetimepicker({
    pickDate: false
    });
            $('button[id^=\'button-upload\']').on('click', function() {
    var node = this;
            $('#form-upload').remove();
            $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');
            $('#form-upload input[name=\'file\']').trigger('click');
            timer = setInterval(function() {
            if ($('#form-upload input[name=\'file\']').val() != '') {
            clearInterval(timer);
                    $.ajax({
                    url: 'index.php?route=tool/upload',
                            type: 'post',
                            dataType: 'json',
                            data: new FormData($('#form-upload')[0]),
                            cache: false,
                            contentType: false,
                            processData: false,
                            beforeSend: function() {
                            $(node).button('loading');
                            },
                            complete: function() {
                            $(node).button('reset');
                            },
                            success: function(json) {
                            $('.text-danger').remove();
                                    if (json['error']) {
                            $(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
                            }

                            if (json['success']) {
                            alert(json['success']);
                                    $(node).parent().find('input').attr('value', json['code']);
                            }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                    });
            }
            }, 500);
    });
//--></script> 
<script type="text/javascript"><!--
$('#pareview').delegate('.pagination a', 'click', function(e) {
    e.preventDefault();
            $('#pareview').fadeOut('slow');
            $('#pareview').load(this.href);
            $('#pareview').fadeIn('slow');
    });
            $('#pareview').load('index.php?route=product/proparent/pareview&proparent_id=<?php echo $proparent_id; ?>');
            $('#button-pareview').on('click', function() {
    $.ajax({
    url: 'index.php?route=product/proparent/write&proparent_id=<?php echo $proparent_id; ?>',
            type: 'post',
            dataType: 'json',
            data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
            beforeSend: function() {
            $('#button-pareview').button('loading');
            },
            complete: function() {
            $('#button-pareview').button('reset');
                    $('#captcha').attr('src', 'index.php?route=tool/captcha#' + new Date().getTime());
                    $('input[name=\'captcha\']').val('');
            },
            success: function(json) {
            $('.alert-success, .alert-danger').remove();
                    if (json['error']) {
            $('#pareview').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
            }

            if (json['success']) {
            $('#pareview').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');
                    $('input[name=\'name\']').val('');
                    $('textarea[name=\'text\']').val('');
                    $('input[name=\'rating\']:checked').prop('checked', false);
                    $('input[name=\'captcha\']').val('');
            }
            }
    });
    });
            $(document).ready(function() {
    $('.thumbnails').magnificPopup({
    type:'image',
            delegate: 'a',
            gallery: {
            enabled:true
            }
    });
    });
//--></script> 
<script type="text/javascript"><!--
$(document).ready(function() {

    var sync1 = $("#sync1");
            var sync2 = $("#sync2");
            sync1.owlCarousel({
            singleItem : true,
                    slideSpeed : 1000,
                    navigation: true,
                    pagination:false,
                    afterAction : syncPosition,
                    responsiveRefreshRate : 200,
            });
            sync2.owlCarousel({
            items : 5,
                    itemsDesktop      : [1199, 10],
                    itemsDesktopSmall     : [979, 10],
                    itemsTablet       : [768, 8],
                    itemsMobile       : [479, 4],
                    pagination:false,
                    responsiveRefreshRate : 100,
                    afterInit : function(el){
                    el.find(".owl-item").eq(0).addClass("synced");
                    }
            });
            function syncPosition(el){
            var current = this.currentItem;
                    $("#sync2")
                    .find(".owl-item")
                    .removeClass("synced")
                    .eq(current)
                    .addClass("synced")
                    if ($("#sync2").data("owlCarousel") !== undefined){
            center(current)
            }
            }

    $("#sync2").on("click", ".owl-item", function(e){
    e.preventDefault();
            var number = $(this).data("owlItem");
            sync1.trigger("owl.goTo", number);
    });
            function center(number){
            var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
                    var num = number;
                    var found = false;
                    for (var i in sync2visible){
            if (num === sync2visible[i]){
            var found = true;
            }
            }

            if (found === false){
            if (num > sync2visible[sync2visible.length - 1]){
            sync2.trigger("owl.goTo", num - sync2visible.length + 2)
            } else{
            if (num - 1 === - 1){
            num = 0;
            }
            sync2.trigger("owl.goTo", num);
            }
            } else if (num === sync2visible[sync2visible.length - 1]){
            sync2.trigger("owl.goTo", sync2visible[1])
            } else if (num === sync2visible[0]){
            sync2.trigger("owl.goTo", num - 1)
            }

            }

    });
//--></script> 
<?php echo $footer; ?>
