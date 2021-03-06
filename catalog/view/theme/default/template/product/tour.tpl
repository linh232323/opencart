<?php echo $header; ?>
<div class="container">
    <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
    </ul>
    <div class="row">
        <div id="content" class="col-sm-12">
            <div class="row">
                <div class="row">
                    <div class="col-sm-9  col-xs-12">
                        <h1><?php echo $heading_title; ?></h1>
                        <div class ='row thumb'>
                            <?php if ($images || $thumb) { ?>
                            <?php if ($images) { ?>
                            <div id="sync1" class="owl-carousel">
                                <?php foreach ($images as $image) { ?><div class="item"><img src="<?php echo $image['image']; ?>"/></div><?php } ?>
                            </div>
                            <div id="sync2" class="owl-carousel">
                                <?php foreach ($images as $image) { ?><div class="item"><img src="<?php echo $image['thumb']; ?>"/></div><?php } ?>
                            </div>
                            <?php } ?>
                            <?php } ?>
                        </div>
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab-description" data-toggle="tab"><?php echo $tab_description; ?></a></li>
                            <?php if ($review_status) { ?>
                            <li><a href="#tab-review" data-toggle="tab"><?php echo $tab_review; ?></a></li>
                            <?php } ?>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-description"><?php echo $description; ?></div>
                            <?php if ($review_status) { ?>
                            <div class="tab-pane" id="tab-review">
                                <form class="form-horizontal">
                                    <div id="review"></div>
                                    <h2><?php echo $text_write; ?></h2>
                                    <?php if ($review_guest) { ?>
                                    <div class="form-group required">
                                        <div class="col-sm-12">
                                            <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                                            <input type="text" name="name" value="" id="input-name" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <div class="col-sm-12">
                                            <label class="control-label" for="input-review"><?php echo $entry_review; ?></label>
                                            <textarea name="text" rows="5" id="input-review" class="form-control"></textarea>
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
                                            <button type="button" id="button-review" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><?php echo $button_continue; ?></button>
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
                    <div class="col-lg-3 col-xs-12">
                        <div class="control-group">
                            <div class = "header-box-hightlight">
                                <strong><i class="glyphicon glyphicon-search text-primary"></i> <?php echo $text_search;?></strong>
                            </div>
                            <div class = "content-box-hightlight">
                                <table>
                                    <tr>
                                        <td><i class="glyphicon glyphicon-home text-primary"></i></td><td><?php echo substr($heading_title,0,18)."..."; ?></td>
                                    </tr>
                                    <tr>
                                        <td><i class="glyphicon glyphicon-calendar text-primary"></i></td><td><?php echo $text_labeldate_in; ?> <?php echo $_SESSION['check_in']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><i class="glyphicon glyphicon-calendar text-primary"></i></td><td><?php echo $text_labeldate_out; ?> <?php echo $_SESSION['check_out']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><i class="glyphicon glyphicon-cloud text-primary"></i></td><td><?php echo $text_label_night; ?> <?php echo $night; ?></td>
                                    </tr>
                                    <tr>
                                        <td><i class="glyphicon glyphicon-user text-primary"></i><i class="glyphicon glyphicon-user text-warning"></i></td><td><?php echo $text_label_guest; ?> <?php echo $_SESSION['adults']; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <br/>
                        <ul class="list-unstyled">
                            <li>
                                <h2><?php if (isset($tour_prices)) { ?>
                                    <?php foreach ($tour_prices as $tour_price) { ?>
                                    <?php if (!empty($tour_price['tour_price_value'])){ ?> 
                                    <?php $price_cost = $tour_price['tour_price_value'];} ?>
                                    <?php } ?>
                                    <?php if(isset($price_cost)) { echo $price_cost;}else{ echo $tour_price['tour_price_null'];} ?>
                                    <?php $price_cost = ''; ?>
                                    <?php } ?>
                                </h2>
                            </li>
                        </ul>
                        <div id="tour">
                            <?php if ($options) { ?>
                            <hr>
                            <?php foreach ($options as $option) { ?>
                            <?php if ($option['type'] == 'select') { ?>
                            <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                <label class="control-label" for="input-option<?php echo $option['tour_option_id']; ?>"><?php echo $option['name']; ?></label>
                                <select name="option[<?php echo $option['tour_option_id']; ?>]" id="input-option<?php echo $option['tour_option_id']; ?>" class="form-control">
                                    <option value=""><?php echo $text_select; ?></option>
                                    <?php foreach ($option['tour_option_value'] as $option_value) { ?>
                                    <option value="<?php echo $option_value['tour_option_value_id']; ?>"><?php echo $option_value['name']; ?>
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
                                <div id="input-option<?php echo $option['tour_option_id']; ?>">
                                    <?php foreach ($option['tour_option_value'] as $option_value) { ?>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="option[<?php echo $option['tour_option_id']; ?>]" value="<?php echo $option_value['tour_option_value_id']; ?>" />
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
                                <div id="input-option<?php echo $option['tour_option_id']; ?>">
                                    <?php foreach ($option['tour_option_value'] as $option_value) { ?>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="option[<?php echo $option['tour_option_id']; ?>][]" value="<?php echo $option_value['tour_option_value_id']; ?>" />
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
                                <div id="input-option<?php echo $option['tour_option_id']; ?>">
                                    <?php foreach ($option['tour_option_value'] as $option_value) { ?>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="option[<?php echo $option['tour_option_id']; ?>]" value="<?php echo $option_value['tour_option_value_id']; ?>" />
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
                            <?php if ($option['option_id'] == 15) { ?>
                                <input type="hidden" name="option[<?php echo $option['tour_option_id']; ?>]" value="<?php echo $_SESSION['price']; ?>" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['tour_option_id']; ?>" class="form-control" disabled/>
                            <?php } ?>
                            <?php if ($option['option_id'] == 16) { ?>
                                <input type="hidden" name="option[<?php echo $option['tour_option_id']; ?>]" value="<?php echo $_SESSION['price']*$_SESSION['night']; ?>" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['tour_option_id']; ?>" class="form-control" />
                            <?php } ?>
                            <?php if ($option['type'] == 'textarea') { ?>
                            <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                <label class="control-label" for="input-option<?php echo $option['tour_option_id']; ?>"><?php echo $option['name']; ?></label>
                                <textarea name="option[<?php echo $option['tour_option_id']; ?>]" rows="5" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['tour_option_id']; ?>" class="form-control"><?php echo $option['value']; ?></textarea>
                            </div>
                            <?php } ?>
                            <?php if ($option['type'] == 'file') { ?>
                            <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                <label class="control-label"><?php echo $option['name']; ?></label>
                                <button type="button" id="button-upload<?php echo $option['tour_option_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default btn-block"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
                                <input type="hidden" name="option[<?php echo $option['tour_option_id']; ?>]" value="" id="input-option<?php echo $option['tour_option_id']; ?>" />
                            </div>
                            <?php } ?>
                            <?php if ($option['option_id'] == 13) { ?>
                                    <input type="hidden" name="option[<?php echo $option['tour_option_id']; ?>]" value="<?php echo $_SESSION['check_in']; ?>" data-date-format="YYYY-MM-DD" id="input-option<?php echo $option['tour_option_id']; ?>" class="form-control" />
                            <?php } ?>
                            <?php if ($option['option_id'] == 14) { ?>
                                    <input type="hidden" name="option[<?php echo $option['tour_option_id']; ?>]" value="<?php echo $_SESSION['check_out']; ?>" data-date-format="YYYY-MM-DD" id="input-option<?php echo $option['tour_option_id']; ?>" class="form-control" />
                            <?php } ?>
                            <?php if ($option['type'] == 'datetime') { ?>
                            <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                <label class="control-label" for="input-option<?php echo $option['tour_option_id']; ?>"><?php echo $option['name']; ?></label>
                                <div class="input-group datetime">
                                    <input type="text" name="option[<?php echo $option['tour_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-option<?php echo $option['tour_option_id']; ?>" class="form-control" />
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                    </span></div>
                            </div>
                            <?php } ?>
                            <?php if ($option['type'] == 'time') { ?>
                            <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                <label class="control-label" for="input-option<?php echo $option['tour_option_id']; ?>"><?php echo $option['name']; ?></label>
                                <div class="input-group time">
                                    <input type="text" name="option[<?php echo $option['tour_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="HH:mm" id="input-option<?php echo $option['tour_option_id']; ?>" class="form-control" />
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
                                <input type="text" name="quantity" value="<?php echo $_SESSION['seats']; ?>" size="2" id="input-quantity" class="form-control" />
                                <input type="hidden" name="tour_id" value="<?php echo $tour_id; ?>" />
                                <input type="hidden" name="option[price]" value="<?php echo $_SESSION['price']; ?>" />
                                <input type="hidden" name="option[check_in]" value="<?php echo $_SESSION['check_in']; ?>" />
                                <input type="hidden" name="option[check_out]" value="<?php echo $_SESSION['check_out']; ?>" />
                                <input type="hidden" name="option[night]" value="<?php echo $night;?>" />
                                <br />
                                <button type="button" id="button-cart" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary btn-lg btn-block"><?php echo $button_cart; ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($tours) { ?>
            <h3><?php echo $text_related; ?></h3>
            <div class="row">
                <?php $i = 0; ?>
                <?php foreach ($tours as $tour) { ?>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tour-thumb transition">
                        <div class="image"><a href="<?php echo $tour['href']; ?>"><img src="<?php echo $tour['thumb']; ?>" alt="<?php echo $tour['name']; ?>" title="<?php echo $tour['name']; ?>" class="img-responsive" /></a></div>
                        <div class="caption">
                            <h4><a href="<?php echo $tour['href']; ?>"><?php echo $tour['name']; ?></a></h4>
                            <p><?php echo $tour['description']; ?></p>
                            <?php if ($tour['rating']) { ?>
                            <div class="rating">
                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                <?php if ($tour['rating'] < $i) { ?>
                                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                                <?php } else { ?>
                                <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                                <?php } ?>
                                <?php } ?>
                            </div>
                            <?php } ?>
                            <?php if ($tour['price']) { ?>
                            <p class="price">
                                <?php if (!$tour['special']) { ?>
                                <?php echo $tour['price']; ?>
                                <?php } else { ?>
                                <span class="price-new"><?php echo $tour['special']; ?></span> <span class="price-old"><?php echo $tour['price']; ?></span>
                                <?php } ?>
                                <?php if ($tour['tax']) { ?>
                                <span class="price-tax"><?php echo $text_tax; ?> <?php echo $tour['tax']; ?></span>
                                <?php } ?>
                            </p>
                            <?php } ?>
                        </div>
                        <div class="button-group">
                            <button type="button" onclick="cart.add('<?php echo $tour['tour_id']; ?>');"><span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span> <i class="fa fa-shopping-cart"></i></button>
                            <button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $tour['tour_id']; ?>');"><i class="fa fa-heart"></i></button>
                            <button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $tour['tour_id']; ?>');"><i class="fa fa-exchange"></i></button>
                        </div>
                    </div>
                </div>
                <?php if (($i % 2 == 0)) { ?>
                <div class="clearfix visible-md visible-sm"></div>
                <?php } elseif (($i % 3 == 0)) { ?>
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
    </div>
</div>
<script type="text/javascript">
            $('select[name=\'recurring_id\'], input[name="quantity"]').change(function(){
    $.ajax({
    url: 'index.php?route=product/tour/getRecurringDescription',
            type: 'post',
            data: $('input[name=\'tour_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
            dataType: 'json',
            beforeSend: function() {
            $('#recurring-description').html('');
            },
            success: function(json) { $('.alert, .text-danger').remove();
			
                        if (json['success']) {
            $('#recurring-description').html(json['success']);
    }
    }
    });
            });</script> 
<script type="text/javascript">
            $('#button-cart').on('click', function() {
    $.ajax({
    url: 'index.php?route=checkout/cart/add',
            type: 'post',
            data: $('#tour input[type=\'text\'], #tour input[type=\'hidden\'], #tour input[type=\'radio\']:checked, #tour input[type=\'checkbox\']:checked, #tour select,#option input, #tour textarea'),
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
            window.location.assign("index.php?route=checkout/cart")
            }
    });
            });</script> 
<script type="text/javascript">
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
                                    $(node).parent().find('input').attr('value', json['code']); }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                    });
            }
            }, 500);
            });</script> 
<script type="text/javascript">
            $('#review').delegate('.pagination a', 'click', function(e) {
    e.preventDefault();
            $('#review').fadeOut('slow');
            $('#review').load(this.href);
            $('#review').fadeIn('slow');
            });
            $('#review').load('index.php?route=product/tour/review&tour_id=<?php echo $tour_id; ?>');
            $('#button-review').on('click', function() {
    $.ajax({
    url: 'index.php?route=product/tour/write&tour_id=<?php echo $tour_id; ?>',
            type: 'post',
            dataType: 'json',
            data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
            beforeSend: function() {
            $('#button-review').button('loading');
            },
            complete: function() {
            $('#button-review').button('reset');
                    $('#captcha').attr ('src', 'index.php?route=tool/captcha#' + new Date().getTime());
                    $('input[name=\'captcha\']').val('');
            },
            success: function(json) {
            $('.alert-success, .alert-danger').remove();
                    if (json['error']) {
            $('#review').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
            }

            if (json['success']) {
            $('#review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');
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
            });</script> 
<script type="text/javascript">
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
            items : 7,
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
</script>
<?php echo $footer; ?>
