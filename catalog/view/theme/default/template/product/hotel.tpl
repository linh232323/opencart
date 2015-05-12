<?php echo $header;?>
<div class="container">
    <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
    </ul>
    <div class="content">
        <div class="row">
            <div id="content" class="col-lg-12"><?php echo $content_top; ?>
                <div class="row">
                    <div class="col-lg-3 col-xs-12">
                        <div class="control-group">
                            <div class = "header-box-hightlight">
                                <strong><i class="glyphicon glyphicon-search text-primary"></i> <?php echo $text_search;?></strong>
                            </div>
                            <div class = "content-box-hightlight">
                                <table>
                                    <tr>
                                        <td width="30px"><i class="glyphicon glyphicon-home text-primary"></i></td><td><?php echo substr($heading_title,0,18)."..."; ?></td>
                                    </tr>
                                    <tr>
                                        <td><i class="glyphicon glyphicon-calendar text-primary"></i></td><td><?php echo $text_labeldate_in; ?> <?php echo $_SESSION['check_in']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><i class="glyphicon glyphicon-calendar text-primary"></i></td><td><?php echo $text_labeldate_out; ?> <?php echo $_SESSION['check_out']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><i class="glyphicon glyphicon-user text-primary"></i><i class="glyphicon glyphicon-user text-warning"></i></td><td><?php echo $text_label_guest; ?> <?php echo $_SESSION['adults']; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <br/>
                        <div class="control-group">
                            <form method="POST" action="index.php?route=product/hotel<?php echo '&hotel_id='.$_GET['hotel_id'].'&search='.$_GET['search']?>">
                                <div class="header-box-hightlight">
                                    <h4 class="title"><strong> <?php echo $text_search; ?></strong></h4>
                                </div>
                                <div class="content-box-hightlight">
                                    <div id="form-search" class="form-group">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <label class="control-label" for="input-search"><?php echo $entry_search; ?></label>
                                                <input type="text" name="search" value="<?php echo $heading_title; ?>" placeholder="<?php echo $text_keyword; ?>" id="input-search" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 date" id="check_in1">
                                                <label class="control-label" for="input-option"><?php echo $text_labeldate_in; ?></label>
                                                <div class=" input-group">
                                                    <input type="text" name="check_in" value= "<?php echo $_SESSION['check_in']; ?>" readonly="readonly" data-date-format="ddd MMM DD YYYY" class="form-control input_check_in"/>
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button" id="date"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-5" id="night1">
                                                <label class="control-label" for="input-option"><?php echo $text_label_night; ?></label>
                                                <div class="">
                                                    <select name="night" class="form-control">
                                                        <?php for ($i=1;$i<=30;$i++) { ?>
                                                        <option value="<?php echo $i; ?>" <?php if ($_SESSION['night'] == $i){ echo "selected";}?> ><?php echo $i; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-7 date1" id="check_out1">
                                                <label class="control-label" for="input-option"><?php echo $text_labeldate_out; ?></label>
                                                <div class="input-group">
                                                    <input type="text" name="check_out" value="<?php echo $_SESSION['check_out']; ?>" data-date-format="ddd MMM DD YYYY" readonly="readonly" class="form-control input_check_out" />
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button" id="date"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 form-group" id="guest">
                                                <label class="control-label" for="input-option217"><?php echo $text_label_guest; ?></label>
                                                <select name="guestsl" id = "adults" class="form-control">
                                                    <option value="1" <?php if ($_SESSION['guestsl'] == 1){ echo "selected";}?>><?php echo $text_1adult?></option>
                                                    <option value="2"<?php if ($_SESSION['guestsl'] == 2){ echo "selected";}?>><?php echo $text_2adults?></option>
                                                    <option value="" <?php if ($_SESSION['guestsl'] == ""){ echo "selected";}?>><?php echo $text_more?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row" id="hide">
                                            <div class="col-xs-12 form-group">
                                                <span class="col-xs-3">
                                                    <label class="control-label"><?php echo $text_label_room; ?></label>
                                                    <select name="room" class="form-control ">
                                                        <?php for ($i=1;$i<10;$i++) { ?>
                                                        <option value="<?php echo $i; ?>" <?php if ($_SESSION['room'] == $i){ echo "selected";}?>><?php echo $i; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </span>
                                                <span class="col-xs-3">
                                                    <label class="control-label"><?php echo $text_label_adults; ?></label>
                                                    <select name="adults"class="form-control ">
                                                        <?php for ($i=1;$i<22;$i++) { ?>
                                                        <option value="<?php echo $i; ?>" <?php if ($_SESSION['adults'] == $i){ echo "selected";}?>> <?php echo $i; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </span>
                                                <span class="col-xs-5">
                                                    <label class="control-label"><?php echo $text_label_children; ?></label>
                                                    <select name="children"class="form-control ">
                                                        <?php for ($i=0;$i<4;$i++) { ?>
                                                        <option value="<?php echo $i; ?>" <?php if ($_SESSION['children'] == $i){ echo "selected";}?>><?php echo $i; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <button type="submit"id="button-search" class="btn btn-primary btn-block" ><strong><?php echo $button_search; ?></strong></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-8 col-xs-12">
                        <div class="row">
                            <h1 class="col-lg-8 col-xs-12">
                                <?php echo $heading_title; ?>
                                <span class="rating">
                                    <?php for ($i = 1; $i <= 5; $i++) { ?>
                                    <?php if ($star < $i) { ?>
                                    <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                                    <?php } else { ?>
                                    <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                                    <?php } ?>
                                    <?php } ?>
                                </span>
                            </h1>
                            <h1 class ="col-lg-4 pull-right text-right text-primary">
                                <?php if ($hotelreview_status) { ?>
                                <?php
                                switch ($rating) {
                                case "10":
                                $text_rating = $text_rate_superb;
                                break;
                                case "9":
                                $text_rating = $text_rate_superb;
                                break;
                                case "8":
                                $text_rating = $text_rate_fantastic;
                                break;
                                case "7":
                                $text_rating = $text_rate_verygood;
                                break;
                                case "6":
                                $text_rating = $text_rate_good;
                                break;
                                case "0":
                                $text_rating = '';
                                $rating = '';
                                break;
                                default:
                                $text_rating = $text_rate_bad;
                                }
                                ?>
                                <?php echo $text_rating.' '.$rating; ?>
                                <?php } ?>
                            </h1>

                        </div>
                        <div class="pull-right text-primary text-right">
                            <div class="row">
                                <?php echo $hotelreviews; ?>
                            </div>
                        </div>
                        <div class="row">
                            <p class="col-lg-8"><em><?php echo $address ?><a onclick="toggleContent()"> <strong>(Show on Map)</strong></a></em></p>
                        </div>
                        <div class="search-panel-wrapper col-lg-12" id="maps" style="position: absolute; z-index: 900;">
                            <span id="map" class="col-lg-12" style="height: 600px; z-index: 1000;"></span>
                        </div>
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
                        <div class="row">
                            <div id="change_date" class="form-group col-sm-12">
                                <div class="form-group">
                                    <div class="row">
                                        <h5 class="col-lg-8">
                                            <?php echo $text_labeldate_in; ?> <?php echo $_SESSION['check_in']; ?> - <?php echo $text_labeldate_out; ?> <?php echo $_SESSION['check_out']; ?>
                                        </h5>
                                        <span class="col-lg-3 pull-right">
                                            <button id="search-change" class="btn btn-default"><?php echo $text_change_date; ?></button>
                                        </span>
                                    </div>
                                    <div class="row col-lg-12" id="change" style="display: none;">
                                        <form method="POST" action="index.php?route=product/hotel<?php echo '&hotel_id='.$_GET['hotel_id'].'&search='.$_GET['search']?>">
                                            <div class="col-lg-3 date2" id="check_in">
                                                <label class="control-label" for="input-option"><?php echo $text_labeldate_in; ?></label>
                                                <div class=" input-group">
                                                    <input type="text" name="check_in" value= "<?php echo $_SESSION['check_in']; ?>" readonly="readonly" data-date-format="ddd MMM DD YYYY" class="form-control input_check_in"/>
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button" id="date"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-2" id="night">
                                                <label class="control-label" for="input-option"><?php echo $text_label_night; ?></label>
                                                <div class="" >
                                                    <select name="night" class="form-control">
                                                        <?php for ($i=1;$i<=30;$i++) { ?>
                                                        <option value="<?php echo $i; ?>" <?php if ($_SESSION['night'] == $i){ echo "selected";}?> ><?php echo $i; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 date3" id="check_out">
                                                <label class="control-label" for="input-option"><?php echo $text_labeldate_out; ?></label>
                                                <div class="input-group">
                                                    <input type="text" name="check_out" value="<?php echo $_SESSION['check_out']; ?>" data-date-format="ddd MMM DD YYYY" readonly="readonly" class="form-control input_check_out" />
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button" id="date"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 pull-right">
                                                <button type="submit" id="button-change" class="btn btn-primary btn-block"><strong><?php echo $button_check_rate; ?></strong></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (isset($rooms)) { ?>
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
                            <div class="col-md-2 text-right">
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
                            <div class="room-layout room-list col-lg-12" id="room-layout">
                                <table class="table table-bordered table-striped table-header">
                                    <th class = "col-lg-5 col-xs-5 text-center"><?php echo $text_room;?></th>
                                    <th class = "col-lg-2 col-xs-2 text-center"><?php echo $text_max_adults;?></th>
                                    <th class = "col-lg-2 col-xs-2 text-center"><?php echo $text_rate;?></th>
                                    <th class = "col-lg-3 col-xs-3"></th>
                                </table>
                                <?php foreach ($rooms as $room) { ?>
                                <div class="room-thumb">
                                    <table  class="table table-bordered table-hover">
                                        <tr>
                                            <td class="col-lg-5 col-xs-5">
                                                <strong><a href="<?php echo $room['href'];?>"><?php echo $room['name'];?></a></strong>
                                                <a href="<?php echo $room['href'];?>"><img src="<?php echo $room['thumb'];?>" alt="<?php echo $room['name'];?>" title="<?php echo $room['name'];?>" class="img-responsive"></a>
                                                <p><a href="<?php echo $room['href'];?>"><?php echo $text_info;?></a></p>
                                            </td>
                                            <td class="col-lg-2 col-xs-2 text-center control-label">
                                                <?php if ($room['maxadults'] == 1){ ?>
                                                <i class="glyphicon glyphicon-user"></i> 
                                                <?php } else { if ($room['maxadults'] == 2) { ?>
                                                <i class="glyphicon glyphicon-user"></i> <i class="glyphicon glyphicon-user"></i> 
                                                <?php } else { ?>
                                                <i class="glyphicon glyphicon-user"></i> <i class="glyphicon glyphicon-user"></i> <i class="glyphicon glyphicon-plus"></i> 
                                                <?php } ?>
                                                <?php } ?>
                                            </td>
                                            <td class = "col-lg-2 col-xs-2 text-center">
                                                <strong class="text-primary">
                                                    <?php if (isset($room_prices)) { ?>
                                                    <?php foreach ($room_prices as $room_price) { ?>
                                                    <?php if ($room['room_id'] == $room_price['room_id']) { ?>
                                                    <?php if (!empty($room_price['room_price_value'])){ $price_cost = $room_price['room_price_value'];} ?>
                                                    <?php } else { ?>
                                                    <?php $cost = ''; ?>
                                                    <?php } ?>
                                                    <?php } ?>
                                                    <?php if(isset($price_cost)) { echo $price_cost;}else{ echo $cost;} ?>
                                                    <?php $price_cost = ''; ?>
                                                    <?php } ?>
                                                </strong>
                                            </td>
                                            <td class="col-lg-3 col-xs-3">
                                                <div class="center-block">
                                                    <a href="<?php echo $room['href'];?>"><button type="button" class="btn btn-primary btn-block btn-blue center-block"><i class="fa fa-shopping-cart"></i> <strong><?php echo $text_book; ?></strong></button></a>
                                                </div>
                                                <p class = "text-center" >
                                                    <?php if ($room['quantity'] == 1){ ?>
                                                    <strong class="text-danger"><?php echo $text_ourlastroom; ?></strong>
                                                    <?php } else { if ($room['quantity'] <= 5) { ?>
                                                    <strong class="text-warning"><?php echo $text_ourlast; ?> <?php echo $room['quantity'];?> <?php echo $text_rooms; ?> </strong>
                                                    <?php } else { ?>
                                                    <strong class="text-success"><?php echo $text_available; ?></strong>
                                                    <?php } ?>
                                                    <?php } ?>
                                                </p>
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
                        <?php echo $description; ?>
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab-description" data-toggle="tab"><?php echo $tab_short_description; ?></a></li>
                            <?php if ($attribute_groups) { ?>
                            <li><a href="#tab-specification" data-toggle="tab"><?php echo $tab_attribute; ?></a></li>
                            <?php } ?>
                            <?php if ($hotelreview_status) { ?>
                            <li><a href="#tab-hotelreview" data-toggle="tab"><?php echo $tab_hotelreview; ?></a></li>
                            <?php } ?>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-description"><?php echo $short_description; ?></div>
                            <?php if ($attribute_groups) { ?>

                            <div class="tab-pane" id="tab-specification">
                                <div class = "header-box-hightlight">
                                    <strong><?php echo $text_features;?> <?php echo $heading_title; ?></strong>
                                </div>
                                <div class = "content-box-hightlight">
                                    <table class="table">
                                        <tbody>
                                            <?php foreach ($attribute_groups as $attribute_group) { ?>
                                            <tr>
                                                <td><strong><?php echo $attribute_group['name']; ?></strong></td>
                                                <td class="pull-left col-sm-12"><?php foreach ($attribute_group['attribute'] as $attribute) { ?><div class="col-md-4"><strong><i class = "glyphicon glyphicon-ok text-success" ></i></strong> <?php echo $attribute['name']; ?></div><?php } ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if ($hotelreview_status) { ?>
                            <div class="tab-pane" id="tab-hotelreview">
                                <form class="form-horizontal">
                                    <div id="hotelreview"></div>
                                    <h2><?php echo $text_write; ?></h2>
                                    <?php if ($hotelreview_guest) { ?>
                                    <div class="form-group required">
                                        <div class="col-sm-12">
                                            <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                                            <input type="text" name="name" value="" id="input-name" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <div class="col-sm-12">
                                            <label class="control-label" for="input-hotelreview"><?php echo $entry_hotelreview; ?></label>
                                            <textarea name="text" rows="5" id="input-hotelreview" class="form-control"></textarea>
                                            <div class="help-block"><?php echo $text_note; ?></div>
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <div class="col-sm-12">
                                            <label class="control-label"><?php echo $entry_rating; ?></label>
                                            &nbsp;&nbsp;&nbsp; <?php echo $entry_bad; ?>&nbsp;
                                            <?php for($i=1;$i<=10;$i++) { ?>
                                            <input type="radio" name="rating" value="<?php echo $i; ?>" />&nbsp;<?php echo $i; ?>&nbsp;
                                            <?php } ?>
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
                                            <button type="button" id="button-hotelreview" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><?php echo $button_continue; ?></button>
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
                </div>
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
</div>
<script type="text/javascript">
            $('select[name=\'recurring_id\'], input[name="quantity"]').change(function () {
    $.ajax({
    url: 'index.php?route=product/hotel/getRecurringDescription',
            type: 'post',
            data: $('input[name=\'hotel_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
            dataType: 'json',
            beforeSend: function () {
            $('#recurring-description').html('');
            },
            success: function (json) {
            $('.alert, .text-danger').remove();
                    if (json['success']) {
            $('#recurring-description').html(json['success']);
            }
            }
    });
    });</script> 
<script type="text/javascript">
            $('#button-cart').on('click', function () {
    $.ajax({
    url: 'index.php?route=checkout/cart/add',
            type: 'post',
            data: $('#hotel input[type=\'text\'], #hotel input[type=\'hidden\'], #hotel input[type=\'radio\']:checked, #hotel input[type=\'checkbox\']:checked, #hotel select, #hotel textarea'),
            dataType: 'json',
            beforeSend: function () {
            $('#button-cart').button('loading');
            },
            complete: function () {
            $('#button-cart').button('reset');
            },
            success: function (json) {
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
                    $('html, body').animate({scrollTop: 0}, 'slow');
                    $('#cart > ul').load('index.php?route=common/cart/info ul li');
            }
            }
    });
    });</script> 
<script type="text/javascript">
            $('#hotelreview').delegate('.pagination a', 'click', function (e) {
    e.preventDefault();
            $('#hotelreview').fadeOut('slow');
            $('#hotelreview').load(this.href);
            $('#hotelreview').fadeIn('slow');
    });
            $('#hotelreview').load('index.php?route=product/hotel/hotelreview&hotel_id=<?php echo $hotel_id; ?>');
            $('#button-hotelreview').on('click', function () {
    $.ajax({
    url: 'index.php?route=product/hotel/write&hotel_id=<?php echo $hotel_id; ?>',
            type: 'post',
            dataType: 'json',
            data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
            beforeSend: function () {
            $('#button-hotelreview').button('loading');
            },
            complete: function () {
            $('#button-hotelreview').button('reset');
                    $('#captcha').attr('src', 'index.php?route=tool/captcha#' + new Date().getTime());
                    $('input[name=\'captcha\']').val('');
            },
            success: function (json) {
            $('.alert-success, .alert-danger').remove();
                    if (json['error']) {
            $('#hotelreview').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
            }

            if (json['success']) {
            $('#hotelreview').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');
                    $('input[name=\'name\']').val('');
                    $('textarea[name=\'text\']').val('');
                    $('input[name=\'rating\']:checked').prop('checked', false);
                    $('input[name=\'captcha\']').val('');
            }
            }
    });
    });
            $(document).ready(function () {
    $('.thumbnails').magnificPopup({
    type: 'image',
            delegate: 'a',
            gallery: {
            enabled: true
            }
    });
    });</script> 
<script type="text/javascript">
            $(document).ready(function () {

    var sync1 = $("#sync1");
            var sync2 = $("#sync2");
            sync1.owlCarousel({
            singleItem: true,
                    slideSpeed: 1000,
                    navigation: true,
                    pagination: false,
                    afterAction: syncPosition,
                    responsiveRefreshRate: 200,
            });
            sync2.owlCarousel({
            items: 7,
                    itemsDesktop: [1199, 10],
                    itemsDesktopSmall: [979, 10],
                    itemsTablet: [768, 8],
                    itemsMobile: [479, 4],
                    pagination: false,
                    responsiveRefreshRate: 100,
                    afterInit: function (el) {
                    el.find(".owl-item").eq(0).addClass("synced");
                    }
            });
            function syncPosition(el) {
            var current = this.currentItem;
                    $("#sync2")
                    .find(".owl-item")
                    .removeClass("synced")
                    .eq(current)
                    .addClass("synced")
                    if ($("#sync2").data("owlCarousel") !== undefined) {
            center(current)
            }
            }

    $("#sync2").on("click", ".owl-item", function (e) {
    e.preventDefault();
            var number = $(this).data("owlItem");
            sync1.trigger("owl.goTo", number);
    });
            function center(number) {
            var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
                    var num = number;
                    var found = false;
                    for (var i in sync2visible) {
            if (num === sync2visible[i]) {
            var found = true;
            }
            }

            if (found === false) {
            if (num > sync2visible[sync2visible.length - 1]) {
            sync2.trigger("owl.goTo", num - sync2visible.length + 2)
            } else {
            if (num - 1 === - 1) {
            num = 0;
            }
            sync2.trigger("owl.goTo", num);
            }
            } else if (num === sync2visible[sync2visible.length - 1]) {
            sync2.trigger("owl.goTo", sync2visible[1])
            } else if (num === sync2visible[0]) {
            sync2.trigger("owl.goTo", num - 1)
            }

            }

    });</script>
<script type="text/javascript">
            $(function () {
            var now = new Date();
                    var max = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 29);
                    $('.date').datetimepicker({
            pickTime: false, minDate: moment()
            });
                    $('.date1').datetimepicker({
            pickTime: false, minDate: moment(), maxDate: max
            });
                    $(".date").on("dp.change", function (e) {
            var datepick = (e.date);
                    var date = new Date(datepick);
                    var outpick = new Date(date.getFullYear(), date.getMonth(), date.getDate() + 1);
                    $('.date1').data("DateTimePicker").setMinDate(outpick);
                    var checkin = (e.date);
                    var datein = new Date(checkin);
                    var out = new Date(datein.getFullYear(), datein.getMonth(), datein.getDate() + 30);
                    $('.date1').data("DateTimePicker").setMaxDate(out);
            });
            });</script> 
<script type="text/javascript">
            $(function () {
            var now = new Date();
                    var max = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 29);
                    $('.date2').datetimepicker({
            pickTime: false, minDate: moment()
            });
                    $('.date3').datetimepicker({
            pickTime: false, minDate: moment(), maxDate: max
            });
                    $(".date2").on("dp.change", function (e) {
            var datepick = (e.date);
                    var date = new Date(datepick);
                    var outpick = new Date(date.getFullYear(), date.getMonth(), date.getDate() + 1);
                    $('.date3').data("DateTimePicker").setMinDate(outpick);
                    var checkin = (e.date);
                    var datein = new Date(checkin);
                    var out = new Date(datein.getFullYear(), datein.getMonth(), datein.getDate() + 30);
                    $('.date3').data("DateTimePicker").setMaxDate(out);
            });
            });</script> 
<script type="text/javascript">
            var locations = [
                    ['<?php echo $heading_title; ?>', <?php echo $maps_apil; ?> , <?php echo $maps_apir; ?> ],
            ];
            var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
                    center: new google.maps.LatLng( <?php echo $maps_apil; ?> , <?php echo $maps_apir; ?> ),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            var infowindow = new google.maps.InfoWindow();
            var marker, i;
            for (i = 0; i < locations.length; i++) {
    marker = new google.maps.Marker({
    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map
    });
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
            infowindow.setContent(locations[i][0]);
                    infowindow.open(map, marker);
            }
            })(marker, i));
    }
</script>
<script type="text/javascript">
    $("#maps").animate({ left: "-200%" }, 0);
            function toggleContent() {
            // Get the DOM reference
            var contentId = document.getElementById("maps");
                    // Toggle 
                    contentId.style.left == "-200%" ? $("#maps").animate({ left: "0px" }, 1200) :
                    $("#maps").animate({ left: "-200%" }, 1200);
            }
</script>
<script type="text/javascript">
    $(document).ready(function(){
    $("#search-change").click(function(){
    $("#change").toggle();
    });
    });
</script>
<?php echo $footer; ?>
