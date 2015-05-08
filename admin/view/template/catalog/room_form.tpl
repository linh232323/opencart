<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-room" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-room" class="form-horizontal">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
                        <li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>
                        <li><a href="#tab-price" data-toggle="tab"><?php echo $tab_price; ?></a></li>
                        <li><a href="#tab-image" data-toggle="tab"><?php echo $tab_image; ?></a></li>
                        <li><a href="#tab-attribute" data-toggle="tab"><?php echo $tab_attribute; ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-general">
                            <ul class="nav nav-tabs" id="language">
                                <?php foreach ($languages as $language) { ?>
                                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                                <?php } ?>
                            </ul>
                            <div class="tab-content">
                                <?php foreach ($languages as $language) { ?>
                                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                                    <div class="form-group required">
                                        <label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_name; ?></label>
                                        <div class="col-sm-10">
                                            <input type="text" name="room_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($room_description[$language['language_id']]) ? $room_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
                                            <?php if (isset($error_name[$language['language_id']])) { ?>
                                            <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-description1<?php echo $language['language_id']; ?>"><?php echo $entry_room_deal; ?></label>
                                        <div class="col-sm-10">
                                            <textarea name="room_description[<?php echo $language['language_id']; ?>][room_deal]" placeholder="<?php echo $entry_room_deal; ?>" id="input-description1<?php echo $language['language_id']; ?>"><?php echo isset($room_description[$language['language_id']]) ? $room_description[$language['language_id']]['room_deal'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
                                        <div class="col-sm-10">
                                            <textarea name="room_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>"><?php echo isset($room_description[$language['language_id']]) ? $room_description[$language['language_id']]['description'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class="col-sm-2 control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
                                        <div class="col-sm-10">
                                            <input type="text" name="room_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($room_description[$language['language_id']]) ? $room_description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
                                            <?php if (isset($error_meta_title[$language['language_id']])) { ?>
                                            <div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
                                        <div class="col-sm-10">
                                            <textarea name="room_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($room_description[$language['language_id']]) ? $room_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
                                        <div class="col-sm-10">
                                            <textarea name="room_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($room_description[$language['language_id']]) ? $room_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-tag<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" title="<?php echo $help_tag; ?>"><?php echo $entry_tag; ?></span></label>
                                        <div class="col-sm-10">
                                            <input type="text" name="room_description[<?php echo $language['language_id']; ?>][tag]" value="<?php echo isset($room_description[$language['language_id']]) ? $room_description[$language['language_id']]['tag'] : ''; ?>" placeholder="<?php echo $entry_tag; ?>" id="input-tag<?php echo $language['language_id']; ?>" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-data">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-image"><?php echo $entry_image; ?></label>
                                <div class="col-sm-10">
                                    <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                                    <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
                                </div>
                            </div>            
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-model"><?php echo $entry_model; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="model" value="<?php echo $model; ?>" placeholder="<?php echo $entry_model; ?>" id="input-model" class="form-control" />
                                    <?php if ($error_model) { ?>
                                    <div class="text-danger"><?php echo $error_model; ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-hotel"><span data-toggle="tooltip" title="<?php echo $help_hotel; ?>"><?php echo $entry_hotel; ?></span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="hotel" value="" placeholder="<?php echo $entry_hotel; ?>" id="input-hotel" class="form-control" />
                                    <div id="room-hotel" class="well well-sm" style="height: 150px; overflow: auto;">
                                        <?php foreach ($room_hotels as $room_hotel) { ?>
                                        <div id="room-hotel<?php echo $room_hotel['hotel_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $room_hotel['name']; ?>
                                            <input type="hidden" name="room_hotel[]" value="<?php echo $room_hotel['hotel_id']; ?>" />
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>
                                <div class="col-sm-10">
                                    <div class="well well-sm" style="height: 150px; overflow: auto;">
                                        <div class="checkbox">
                                            <label>
                                                <?php if (in_array(0, $room_store)) { ?>
                                                <input type="checkbox" name="room_store[]" value="0" checked="checked" />
                                                <?php echo $text_default; ?>
                                                <?php } else { ?>
                                                <input type="checkbox" name="room_store[]" value="0" />
                                                <?php echo $text_default; ?>
                                                <?php } ?>
                                            </label>
                                        </div>
                                        <?php foreach ($stores as $store) { ?>
                                        <div class="checkbox">
                                            <label>
                                                <?php if (in_array($store['store_id'], $room_store)) { ?>
                                                <input type="checkbox" name="room_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                                                <?php echo $store['name']; ?>
                                                <?php } else { ?>
                                                <input type="checkbox" name="room_store[]" value="<?php echo $store['store_id']; ?>" />
                                                <?php echo $store['name']; ?>
                                                <?php } ?>
                                            </label>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-quantity"><?php echo $entry_quantity; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="quantity" value="<?php echo $quantity; ?>" placeholder="<?php echo $entry_quantity; ?>" id="input-quantity" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-minimum"><span data-toggle="tooltip" title="<?php echo $help_minimum; ?>"><?php echo $entry_minimum; ?></span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="minimum" value="<?php echo $minimum; ?>" placeholder="<?php echo $entry_minimum; ?>" id="input-minimum" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-maxadults"><span data-toggle="tooltip" title="<?php echo $help_maxadults; ?>"><?php echo $entry_maxadults; ?></span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="maxadults" value="<?php echo $maxadults; ?>" placeholder="<?php echo $entry_maxadults; ?>" id="input-maxadults" class="form-control" />
                                    <input type="hidden" name="author_id" value="<?php echo $author_id; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-stock-status"><span data-toggle="tooltip" title="<?php echo $help_stock_status; ?>"><?php echo $entry_stock_status; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="stock_status_id" id="input-stock-status" class="form-control">
                                        <?php foreach ($stock_statuses as $stock_status) { ?>
                                        <?php if ($stock_status['stock_status_id'] == $stock_status_id) { ?>
                                        <option value="<?php echo $stock_status['stock_status_id']; ?>" selected="selected"><?php echo $stock_status['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $stock_status['stock_status_id']; ?>"><?php echo $stock_status['name']; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo $entry_shipping; ?></label>
                                <div class="col-sm-10">
                                    <label class="radio-inline">
                                        <?php if ($shipping) { ?>
                                        <input type="radio" name="shipping" value="1" checked="checked" />
                                        <?php echo $text_yes; ?>
                                        <?php } else { ?>
                                        <input type="radio" name="shipping" value="1" />
                                        <?php echo $text_yes; ?>
                                        <?php } ?>
                                    </label>
                                    <label class="radio-inline">
                                        <?php if (!$shipping) { ?>
                                        <input type="radio" name="shipping" value="0" checked="checked" />
                                        <?php echo $text_no; ?>
                                        <?php } else { ?>
                                        <input type="radio" name="shipping" value="0" />
                                        <?php echo $text_no; ?>
                                        <?php } ?>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-keyword"><span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"><?php echo $entry_keyword; ?></span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="<?php echo $entry_keyword; ?>" id="input-keyword" class="form-control" />
                                    <?php if ($error_keyword) { ?>
                                    <div class="text-danger"><?php echo $error_keyword; ?></div>
                                    <?php } ?>               
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-date-available"><?php echo $entry_date_available; ?></label>
                                <div class="col-sm-3">
                                    <div class="input-group date">
                                        <input type="text" name="date_available" value="<?php echo $date_available; ?>" placeholder="<?php echo $entry_date_available; ?>" data-date-format="YYYY-MM-DD" id="input-date-available" class="form-control" />
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                                        </span></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                                <div class="col-sm-10">
                                    <select name="status" id="input-status" class="form-control">
                                        <?php if ($status) { ?>
                                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                        <option value="0"><?php echo $text_disabled; ?></option>
                                        <?php } else { ?>
                                        <option value="1"><?php echo $text_enabled; ?></option>
                                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-attribute">
                            <div class="table-responsive">
                                <table id="attribute" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td class="text-left"><?php echo $entry_attribute; ?></td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $attribute_row = 0; ?>
                                        <?php foreach ($room_attributes as $room_attribute) { ?>
                                        <tr id="attribute-row<?php echo $attribute_row; ?>">
                                            <td class="text-left" style="width: 80%;"><input type="text" name="room_attribute[<?php echo $attribute_row; ?>][name]" value="<?php echo $room_attribute['name']; ?>" placeholder="<?php echo $entry_attribute; ?>" class="form-control" />
                                                <input type="hidden" name="room_attribute[<?php echo $attribute_row; ?>][attribute_id]" value="<?php echo $room_attribute['attribute_id']; ?>" /></td>
                                           <?php foreach ($languages as $language) { ?>
                                                 <input type="hidden" name="room_attribute[<?php echo $attribute_row; ?>][room_attribute_description][<?php echo $language['language_id']; ?>][text]" />
                                                <?php } ?></td>
                                            <td class="text-left"><button type="button" onclick="$('#attribute-row<?php echo $attribute_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                        </tr>
                                        <?php $attribute_row++; ?>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="1"></td>
                                            <td class="text-left"><button type="button" onclick="addAttribute();" data-toggle="tooltip" title="<?php echo $button_attribute_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-price">
                            <div class="table-responsive">
                                <div class="col-sm-10">
                                    <?php if ($error_room_price_net) { ?>
                                    <div class="text-danger"><?php echo ($error_room_price_net) ?></div>
                                    <?php } ?> 
                                    <?php if ($error_room_extra_net) { ?>
                                    <div class="text-danger"><?php echo ($error_room_extra_net) ?></div>
                                    <?php } ?> 
                                    <?php if ($error_room_price_percent) { ?>
                                    <div class="text-danger"><?php echo ($error_room_price_percent) ?></div>
                                    <?php } ?> 
                                    <?php if ($error_room_extra_percent) { ?>
                                    <div class="text-danger"><?php echo ($error_room_extra_percent) ?></div>
                                    <?php } ?>
                                    <?php if ($error_room_price_discount) { ?>
                                    <div class="text-danger"><?php echo ($error_room_price_discount) ?></div>
                                    <?php } ?>
                                </div>
                                <table id="price" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td class="text-left"><?php echo $entry_price_net; ?></td>
                                            <td class="text-left col-md-1"><?php echo $entry_price_percent; ?></td>
                                            <td class="text-left"><?php echo $entry_price_gross; ?></td>
                                            <td class="text-left"><?php echo $entry_extra_net; ?></td>
                                            <td class="text-left col-md-1"><?php echo $entry_extra_percent; ?></td>
                                            <td class="text-left"><?php echo $entry_extra_gross; ?></td>
                                            <td class="text-left col-md-1"><?php echo $entry_discount; ?></td>
                                            <td class="text-left col-md-3"><?php echo $entry_date; ?></td>
                                            <td width="40px"></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $price_row = 0; ?>
                                        <?php foreach ($room_prices as $room_price) { ?>
                                        <tr id="price-row<?php echo $price_row; ?>">
                                            <td class="text-left"><input type="text" name="room_price[<?php echo $price_row; ?>][room_price_net]" value="<?php echo $room_price['room_price_net']; ?>" placeholder="<?php echo $entry_price_net; ?>" class="form-control" />
                                                <input type="hidden" name="room_price[<?php echo $price_row; ?>][price_id]" value="<?php echo $room_price['price_id']; ?>" /></td>
                                            <td class="text-left"><input type="text" name="room_price[<?php echo $price_row; ?>][room_price_percent]" value="<?php echo $room_price['room_price_percent']; ?>" placeholder="<?php echo $entry_price_percent; ?>" class="form-control" <?php if($author_id != 1) { echo 'id="disabledInput" disabled';} ?> /></td>
                                            <td class="text-left"><input type="text" placeholder="<?php echo $room_price['room_price_gross']; ?>" class="form-control" id="disabledInput" disabled/></td>
                                            <td class="text-left"><input type="text" name="room_price[<?php echo $price_row; ?>][room_extra_net]" value="<?php echo $room_price['room_extra_net']; ?>" placeholder="<?php echo $entry_extra_net; ?>" class="form-control" /></td>
                                            <td class="text-left"><input type="text" name="room_price[<?php echo $price_row; ?>][room_extra_percent]" value="<?php echo $room_price['room_extra_percent']; ?>" placeholder="<?php echo $entry_extra_percent; ?>" class="form-control" <?php if($author_id != 1) { echo 'id="disabledInput" disabled';} ?> /></td>
                                            <td class="text-left"><input type="text" placeholder="<?php echo $room_price['room_extra_gross']; ?>" class="form-control" id="disabledInput" disabled/></td>
                                            <td class="text-left"><input type="text" name="room_price[<?php echo $price_row; ?>][room_price_discount]" value="<?php echo $room_price['room_price_discount']; ?>" placeholder="<?php echo $entry_discount; ?>" class="form-control" /></td>
                                            <td class="text-left">
                                                <div class="input-group"><span class="input-group-addon">Date_form</span>
                                                    <input type="date" name="room_price[<?php echo $price_row; ?>][room_date][1][date]" rows="1" class="form-control" value="<?php echo isset($room_price['room_date']['1']['date']) ? $room_price['room_date']['1']['date'] : ''; ?>"/>
                                                </div>
                                                <div class="input-group"><span class="input-group-addon">Date_to  </span>
                                                    <input type="date" name="room_price[<?php echo $price_row; ?>][room_date][2][date]" rows="1" class="form-control" value="<?php echo isset($room_price['room_date']['2']['date']) ? $room_price['room_date']['2']['date'] : ''; ?>"/>  
                                                </div>
                                            </td>
                                            <td class="text-left"><button type="button" onclick="$('#price-row<?php echo $price_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                        </tr>
                                        <?php $price_row++; ?>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="8"></td>
                                            <td class="text-left"><button type="button" onclick="addPrice();" data-toggle="tooltip" title="<?php echo $button_price_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-option">
                            <div class="row">
                                <div class="col-sm-2">
                                    <ul class="nav nav-pills nav-stacked" id="option">
                                        <?php $option_row = 0; ?>
                                        <?php foreach ($room_options as $room_option) { ?>
                                        <li><a href="#tab-option<?php echo $option_row; ?>" data-toggle="tab"><i class="fa fa-minus-circle" onclick="$('a[href=\'#tab-option<?php echo $option_row; ?>\']').parent().remove();
                                                $('#tab-option<?php echo $option_row; ?>').remove();
                                                $('#option a:first').tab('show');"></i> <?php echo $room_option['name']; ?></a></li>
                                        <?php $option_row++; ?>
                                        <?php } ?>
                                        <li>
                                            <input type="text" name="option" value="" placeholder="<?php echo $entry_option; ?>" id="input-option" class="form-control" />
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-sm-10">
                                    <div class="tab-content">
                                        <?php $option_row = 0; ?>
                                        <?php $option_value_row = 0; ?>
                                        <?php foreach ($room_options as $room_option) { ?>
                                        <div class="tab-pane" id="tab-option<?php echo $option_row; ?>">
                                            <input type="hidden" name="room_option[<?php echo $option_row; ?>][room_option_id]" value="<?php echo $room_option['room_option_id']; ?>" />
                                            <input type="hidden" name="room_option[<?php echo $option_row; ?>][name]" value="<?php echo $room_option['name']; ?>" />
                                            <input type="hidden" name="room_option[<?php echo $option_row; ?>][option_id]" value="<?php echo $room_option['option_id']; ?>" />
                                            <input type="hidden" name="room_option[<?php echo $option_row; ?>][type]" value="<?php echo $room_option['type']; ?>" />
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="input-required<?php echo $option_row; ?>"><?php echo $entry_required; ?></label>
                                                <div class="col-sm-10">
                                                    <select name="room_option[<?php echo $option_row; ?>][required]" id="input-required<?php echo $option_row; ?>" class="form-control">
                                                        <?php if ($room_option['required']) { ?>
                                                        <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                                        <option value="0"><?php echo $text_no; ?></option>
                                                        <?php } else { ?>
                                                        <option value="1"><?php echo $text_yes; ?></option>
                                                        <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php if ($room_option['type'] == 'text') { ?>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="room_option[<?php echo $option_row; ?>][value]" value="<?php echo $room_option['value']; ?>" placeholder="<?php echo $entry_option_value; ?>" id="input-value<?php echo $option_row; ?>" class="form-control" />
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php if ($room_option['type'] == 'textarea') { ?>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
                                                <div class="col-sm-10">
                                                    <textarea name="room_option[<?php echo $option_row; ?>][value]" rows="5" placeholder="<?php echo $entry_option_value; ?>" id="input-value<?php echo $option_row; ?>" class="form-control"><?php echo $room_option['value']; ?></textarea>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php if ($room_option['type'] == 'file') { ?>
                                            <div class="form-group" style="display: none;">
                                                <label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="room_option[<?php echo $option_row; ?>][value]" value="<?php echo $room_option['value']; ?>" placeholder="<?php echo $entry_option_value; ?>" id="input-value<?php echo $option_row; ?>" class="form-control" />
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php if ($room_option['type'] == 'date') { ?>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
                                                <div class="col-sm-3">
                                                    <div class="input-group date">
                                                        <input type="text" name="room_option[<?php echo $option_row; ?>][value]" value="<?php echo $room_option['value']; ?>" placeholder="<?php echo $entry_option_value; ?>" data-date-format="YYYY-MM-DD" id="input-value<?php echo $option_row; ?>" class="form-control" />
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                                                        </span></div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php if ($room_option['type'] == 'time') { ?>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
                                                <div class="col-sm-10">
                                                    <div class="input-group time">
                                                        <input type="text" name="room_option[<?php echo $option_row; ?>][value]" value="<?php echo $room_option['value']; ?>" placeholder="<?php echo $entry_option_value; ?>" data-date-format="HH:mm" id="input-value<?php echo $option_row; ?>" class="form-control" />
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                                        </span></div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php if ($room_option['type'] == 'datetime') { ?>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>"><?php echo $entry_option_value; ?></label>
                                                <div class="col-sm-10">
                                                    <div class="input-group datetime">
                                                        <input type="text" name="room_option[<?php echo $option_row; ?>][value]" value="<?php echo $room_option['value']; ?>" placeholder="<?php echo $entry_option_value; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-value<?php echo $option_row; ?>" class="form-control" />
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                                        </span></div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php if ($room_option['type'] == 'select' || $room_option['type'] == 'radio' || $room_option['type'] == 'checkbox' || $room_option['type'] == 'image') { ?>
                                            <div class="table-responsive">
                                                <table id="option-value<?php echo $option_row; ?>" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <td class="text-left"><?php echo $entry_option_value; ?></td>
                                                            <td class="text-right"><?php echo $entry_quantity; ?></td>
                                                            <td class="text-left"><?php echo $entry_subtract; ?></td>
                                                            <td class="text-right"><?php echo $entry_price; ?></td>
                                                            <td class="text-right"><?php echo $entry_option_points; ?></td>
                                                            <td class="text-right"><?php echo $entry_weight; ?></td>
                                                            <td></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($room_option['room_option_value'] as $room_option_value) { ?>
                                                        <tr id="option-value-row<?php echo $option_value_row; ?>">
                                                            <td class="text-left"><select name="room_option[<?php echo $option_row; ?>][room_option_value][<?php echo $option_value_row; ?>][option_value_id]" class="form-control">
                                                                    <?php if (isset($option_values[$room_option['option_id']])) { ?>
                                                                    <?php foreach ($option_values[$room_option['option_id']] as $option_value) { ?>
                                                                    <?php if ($option_value['option_value_id'] == $room_option_value['option_value_id']) { ?>
                                                                    <option value="<?php echo $option_value['option_value_id']; ?>" selected="selected"><?php echo $option_value['name']; ?></option>
                                                                    <?php } else { ?>
                                                                    <option value="<?php echo $option_value['option_value_id']; ?>"><?php echo $option_value['name']; ?></option>
                                                                    <?php } ?>
                                                                    <?php } ?>
                                                                    <?php } ?>
                                                                </select>
                                                                <input type="hidden" name="room_option[<?php echo $option_row; ?>][room_option_value][<?php echo $option_value_row; ?>][room_option_value_id]" value="<?php echo $room_option_value['room_option_value_id']; ?>" /></td>
                                                            <td class="text-right"><input type="text" name="room_option[<?php echo $option_row; ?>][room_option_value][<?php echo $option_value_row; ?>][quantity]" value="<?php echo $room_option_value['quantity']; ?>" placeholder="<?php echo $entry_quantity; ?>" class="form-control" /></td>
                                                            <td class="text-left"><select name="room_option[<?php echo $option_row; ?>][room_option_value][<?php echo $option_value_row; ?>][subtract]" class="form-control">
                                                                    <?php if ($room_option_value['subtract']) { ?>
                                                                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                                                    <option value="0"><?php echo $text_no; ?></option>
                                                                    <?php } else { ?>
                                                                    <option value="1"><?php echo $text_yes; ?></option>
                                                                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                                                    <?php } ?>
                                                                </select></td>
                                                            <td class="text-right"><select name="room_option[<?php echo $option_row; ?>][room_option_value][<?php echo $option_value_row; ?>][price_prefix]" class="form-control">
                                                                    <?php if ($room_option_value['price_prefix'] == '+') { ?>
                                                                    <option value="+" selected="selected">+</option>
                                                                    <?php } else { ?>
                                                                    <option value="+">+</option>
                                                                    <?php } ?>
                                                                    <?php if ($room_option_value['price_prefix'] == '-') { ?>
                                                                    <option value="-" selected="selected">-</option>
                                                                    <?php } else { ?>
                                                                    <option value="-">-</option>
                                                                    <?php } ?>
                                                                </select>
                                                                <input type="text" name="room_option[<?php echo $option_row; ?>][room_option_value][<?php echo $option_value_row; ?>][date]" value="<?php echo $room_option_value['price']; ?>" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>
                                                            <td class="text-right"><select name="room_option[<?php echo $option_row; ?>][room_option_value][<?php echo $option_value_row; ?>][points_prefix]" class="form-control">
                                                                    <?php if ($room_option_value['points_prefix'] == '+') { ?>
                                                                    <option value="+" selected="selected">+</option>
                                                                    <?php } else { ?>
                                                                    <option value="+">+</option>
                                                                    <?php } ?>
                                                                    <?php if ($room_option_value['points_prefix'] == '-') { ?>
                                                                    <option value="-" selected="selected">-</option>
                                                                    <?php } else { ?>
                                                                    <option value="-">-</option>
                                                                    <?php } ?>
                                                                </select>
                                                                <input type="text" name="room_option[<?php echo $option_row; ?>][room_option_value][<?php echo $option_value_row; ?>][points]" value="<?php echo $room_option_value['points']; ?>" placeholder="<?php echo $entry_points; ?>" class="form-control" /></td>
                                                            <td class="text-right"><select name="room_option[<?php echo $option_row; ?>][room_option_value][<?php echo $option_value_row; ?>][weight_prefix]" class="form-control">
                                                                    <?php if ($room_option_value['weight_prefix'] == '+') { ?>
                                                                    <option value="+" selected="selected">+</option>
                                                                    <?php } else { ?>
                                                                    <option value="+">+</option>
                                                                    <?php } ?>
                                                                    <?php if ($room_option_value['weight_prefix'] == '-') { ?>
                                                                    <option value="-" selected="selected">-</option>
                                                                    <?php } else { ?>
                                                                    <option value="-">-</option>
                                                                    <?php } ?>
                                                                </select>
                                                                <input type="text" name="room_option[<?php echo $option_row; ?>][room_option_value][<?php echo $option_value_row; ?>][weight]" value="<?php echo $room_option_value['weight']; ?>" placeholder="<?php echo $entry_weight; ?>" class="form-control" /></td>
                                                            <td class="text-left"><button type="button" onclick="$(this).tooltip('destroy');
                                                                    $('#option-value-row<?php echo $option_value_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                                        </tr>
                                                        <?php $option_value_row++; ?>
                                                        <?php } ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="6"></td>
                                                            <td class="text-left"><button type="button" onclick="addOptionValue('<?php echo $option_row; ?>');" data-toggle="tooltip" title="<?php echo $button_option_value_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            <select id="option-values<?php echo $option_row; ?>" style="display: none;">
                                                <?php if (isset($option_values[$room_option['option_id']])) { ?>
                                                <?php foreach ($option_values[$room_option['option_id']] as $option_value) { ?>
                                                <option value="<?php echo $option_value['option_value_id']; ?>"><?php echo $option_value['name']; ?></option>
                                                <?php } ?>
                                                <?php } ?>
                                            </select>
                                            <?php } ?>
                                        </div>
                                        <?php $option_row++; ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-recurring">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td class="text-left"><?php echo $entry_recurring; ?></td>
                                            <td class="text-left"><?php echo $entry_customer_group; ?></td>
                                            <td class="text-left"></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $recurring_row = 0; ?>
                                        <?php foreach ($room_recurrings as $room_recurring) { ?>

                                        <tr id="recurring-row<?php echo $recurring_row; ?>">
                                            <td class="text-left"><select name="room_recurrings[<?php echo $recurring_row; ?>][recurring_id]" class="form-control">
                                                    <?php foreach ($recurrings as $recurring) { ?>
                                                    <?php if ($recurring['recurring_id'] == $room_recurring['recurring_id']) { ?>
                                                    <option value="<?php echo $recurring['recurring_id']; ?>" selected="selected"><?php echo $recurring['name']; ?></option>
                                                    <?php } else { ?>
                                                    <option value="<?php echo $recurring['recurring_id']; ?>"><?php echo $recurring['name']; ?></option>
                                                    <?php } ?>
                                                    <?php } ?>
                                                </select></td>
                                            <td class="text-left"><select name="room_recurrings[<?php echo $recurring_row; ?>][customer_group_id]" class="form-control">
                                                    <?php foreach ($customer_groups as $customer_group) { ?>
                                                    <?php if ($customer_group['customer_group_id'] == $room_recurring['customer_group_id']) { ?>
                                                    <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                                                    <?php } else { ?>
                                                    <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                                                    <?php } ?>
                                                    <?php } ?>
                                                </select></td>
                                            <td class="text-left"><button type="button" onclick="$('#recurring-row<?php echo $recurring_row; ?>').remove()" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                        </tr>
                                        <?php $recurring_row++; ?>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td class="text-left"><button type="button" onclick="addRecurring()" data-toggle="tooltip" title="<?php echo $button_recurring_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-discount">
                            <div class="table-responsive">
                                <table id="discount" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td class="text-left"><?php echo $entry_customer_group; ?></td>
                                            <td class="text-right"><?php echo $entry_quantity; ?></td>
                                            <td class="text-right"><?php echo $entry_priority; ?></td>
                                            <td class="text-right"><?php echo $entry_price; ?></td>
                                            <td class="text-left"><?php echo $entry_date_start; ?></td>
                                            <td class="text-left"><?php echo $entry_date_end; ?></td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $discount_row = 0; ?>
                                        <?php foreach ($room_discounts as $room_discount) { ?>
                                        <tr id="discount-row<?php echo $discount_row; ?>">
                                            <td class="text-left"><select name="room_discount[<?php echo $discount_row; ?>][customer_group_id]" class="form-control">
                                                    <?php foreach ($customer_groups as $customer_group) { ?>
                                                    <?php if ($customer_group['customer_group_id'] == $room_discount['customer_group_id']) { ?>
                                                    <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                                                    <?php } else { ?>
                                                    <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                                                    <?php } ?>
                                                    <?php } ?>
                                                </select></td>
                                            <td class="text-right"><input type="text" name="room_discount[<?php echo $discount_row; ?>][quantity]" value="<?php echo $room_discount['quantity']; ?>" placeholder="<?php echo $entry_quantity; ?>" class="form-control" /></td>
                                            <td class="text-right"><input type="text" name="room_discount[<?php echo $discount_row; ?>][priority]" value="<?php echo $room_discount['priority']; ?>" placeholder="<?php echo $entry_priority; ?>" class="form-control" /></td>
                                            <td class="text-right"><input type="text" name="room_discount[<?php echo $discount_row; ?>][price]" value="<?php echo $room_discount['price']; ?>" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>
                                            <td class="text-left" style="width: 20%;"><div class="input-group date">
                                                    <input type="text" name="room_discount[<?php echo $discount_row; ?>][date_start]" value="<?php echo $room_discount['date_start']; ?>" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" class="form-control" />
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                                                    </span></div></td>
                                            <td class="text-left" style="width: 20%;"><div class="input-group date">
                                                    <input type="text" name="room_discount[<?php echo $discount_row; ?>][date_end]" value="<?php echo $room_discount['date_end']; ?>" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" class="form-control" />
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                                                    </span></div></td>
                                            <td class="text-left"><button type="button" onclick="$('#discount-row<?php echo $discount_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                        </tr>
                                        <?php $discount_row++; ?>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6"></td>
                                            <td class="text-left"><button type="button" onclick="addDiscount();" data-toggle="tooltip" title="<?php echo $button_discount_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-special">
                            <div class="table-responsive">
                                <table id="special" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td class="text-left"><?php echo $entry_customer_group; ?></td>
                                            <td class="text-right"><?php echo $entry_priority; ?></td>
                                            <td class="text-right"><?php echo $entry_price; ?></td>
                                            <td class="text-left"><?php echo $entry_date_start; ?></td>
                                            <td class="text-left"><?php echo $entry_date_end; ?></td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $special_row = 0; ?>
                                        <?php foreach ($room_specials as $room_special) { ?>
                                        <tr id="special-row<?php echo $special_row; ?>">
                                            <td class="text-left"><select name="room_special[<?php echo $special_row; ?>][customer_group_id]" class="form-control">
                                                    <?php foreach ($customer_groups as $customer_group) { ?>
                                                    <?php if ($customer_group['customer_group_id'] == $room_special['customer_group_id']) { ?>
                                                    <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                                                    <?php } else { ?>
                                                    <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                                                    <?php } ?>
                                                    <?php } ?>
                                                </select></td>
                                            <td class="text-right"><input type="text" name="room_special[<?php echo $special_row; ?>][priority]" value="<?php echo $room_special['priority']; ?>" placeholder="<?php echo $entry_quantity; ?>" class="form-control" /></td>
                                            <td class="text-right"><input type="text" name="room_special[<?php echo $special_row; ?>][price]" value="<?php echo $room_special['price']; ?>" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>
                                            <td class="text-left" style="width: 20%;"><div class="input-group date">
                                                    <input type="text" name="room_special[<?php echo $special_row; ?>][date_start]" value="<?php echo $room_special['date_start']; ?>" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" class="form-control" />
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                                                    </span></div></td>
                                            <td class="text-left" style="width: 20%;"><div class="input-group date">
                                                    <input type="text" name="room_special[<?php echo $special_row; ?>][date_end]" value="<?php echo $room_special['date_end']; ?>" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" class="form-control" />
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                                                    </span></div></td>
                                            <td class="text-left"><button type="button" onclick="$('#special-row<?php echo $special_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                        </tr>
                                        <?php $special_row++; ?>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5"></td>
                                            <td class="text-left"><button type="button" onclick="addSpecial();" data-toggle="tooltip" title="<?php echo $button_special_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-image">
                            <div class="table-responsive">
                                <table id="images" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td class="text-left"><?php echo $entry_image; ?></td>
                                            <td class="text-right"><?php echo $entry_sort_order; ?></td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $image_row = 0; ?>
                                        <?php foreach ($room_images as $room_image) { ?>
                                        <tr id="image-row<?php echo $image_row; ?>">
                                            <td class="text-left"><a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $room_image['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="room_image[<?php echo $image_row; ?>][image]" value="<?php echo $room_image['image']; ?>" id="input-image<?php echo $image_row; ?>" /></td>
                                            <td class="text-right"><input type="text" name="room_image[<?php echo $image_row; ?>][sort_order]" value="<?php echo $room_image['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>
                                            <td class="text-left"><button type="button" onclick="$('#image-row<?php echo $image_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                        </tr>
                                        <?php $image_row++; ?>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="<?php echo $button_image_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-reward">
                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="input-points"><span data-toggle="tooltip" title="<?php echo $help_points; ?>"><?php echo $entry_points; ?></span></label>
                                <div class="col-lg-10">
                                    <input type="text" name="points" value="<?php echo $points; ?>" placeholder="<?php echo $entry_points; ?>" id="input-points" class="form-control" />
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td class="text-left"><?php echo $entry_customer_group; ?></td>
                                            <td class="text-right"><?php echo $entry_reward; ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($customer_groups as $customer_group) { ?>
                                        <tr>
                                            <td class="text-left"><?php echo $customer_group['name']; ?></td>
                                            <td class="text-right"><input type="text" name="room_reward[<?php echo $customer_group['customer_group_id']; ?>][points]" value="<?php echo isset($room_reward[$customer_group['customer_group_id']]) ? $room_reward[$customer_group['customer_group_id']]['points'] : ''; ?>" class="form-control" /></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-design">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td class="text-left"><?php echo $entry_store; ?></td>
                                            <td class="text-left"><?php echo $entry_layout; ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-left"><?php echo $text_default; ?></td>
                                            <td class="text-left"><select name="room_layout[0]" class="form-control">
                                                    <option value=""></option>
                                                    <?php foreach ($layouts as $layout) { ?>
                                                    <?php if (isset($room_layout[0]) && $room_layout[0] == $layout['layout_id']) { ?>
                                                    <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                                                    <?php } else { ?>
                                                    <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                                                    <?php } ?>
                                                    <?php } ?>
                                                </select></td>
                                        </tr>
                                        <?php foreach ($stores as $store) { ?>
                                        <tr>
                                            <td class="text-left"><?php echo $store['name']; ?></td>
                                            <td class="text-left"><select name="room_layout[<?php echo $store['store_id']; ?>]" class="form-control">
                                                    <option value=""></option>
                                                    <?php foreach ($layouts as $layout) { ?>
                                                    <?php if (isset($room_layout[$store['store_id']]) && $room_layout[$store['store_id']] == $layout['layout_id']) { ?>
                                                    <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                                                    <?php } else { ?>
                                                    <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                                                    <?php } ?>
                                                    <?php } ?>
                                                </select></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
                $('#input-description<?php echo $language['language_id']; ?>').summernote({height: 300});
                $('#input-description1<?php echo $language['language_id']; ?>').summernote({height: 200});
<?php } ?>
//--></script> 
    <script type="text/javascript"><!--
  // Manufacturer
                $('input[name=\'manufacturer\']').autocomplete({
            'source': function (request, response) {
                $.ajax({
                    url: 'index.php?route=catalog/manufacturer/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request),
                    dataType: 'json',
                    success: function (json) {
                        json.unshift({
                            manufacturer_id: 0,
                            name: '<?php echo $text_none; ?>'
                        });

                        response($.map(json, function (item) {
                            return {
                                label: item['name'],
                                value: item['manufacturer_id']
                            }
                        }));
                    }
                });
            },
            'select': function (item) {
                $('input[name=\'manufacturer\']').val(item['label']);
                $('input[name=\'manufacturer_id\']').val(item['value']);
            }
        });

  // Category
        $('input[name=\'hotel\']').autocomplete({
            'source': function (request, response) {
                $.ajax({
                    url: 'index.php?route=catalog/hotel/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request),
                    dataType: 'json',
                    success: function (json) {
                        response($.map(json, function (item) {
                            return {
                                label: item['name'],
                                value: item['hotel_id']
                            }
                        }));
                    }
                });
            },
            'select': function (item) {
                $('input[name=\'hotel\']').val('');

                $('#room-hotel' + item['value']).remove();

                $('#room-hotel').append('<div id="room-hotel' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="room_hotel[]" value="' + item['value'] + '" /></div>');
            }
        });

        $('#room-hotel').delegate('.fa-minus-circle', 'click', function () {
            $(this).parent().remove();
        });

  // Filter
        $('input[name=\'filter\']').autocomplete({
            'source': function (request, response) {
                $.ajax({
                    url: 'index.php?route=catalog/filter/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request),
                    dataType: 'json',
                    success: function (json) {
                        response($.map(json, function (item) {
                            return {
                                label: item['name'],
                                value: item['filter_id']
                            }
                        }));
                    }
                });
            },
            'select': function (item) {
                $('input[name=\'filter\']').val('');

                $('#room-filter' + item['value']).remove();

                $('#room-filter').append('<div id="room-filter' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="room_filter[]" value="' + item['value'] + '" /></div>');
            }
        });

        $('#room-filter').delegate('.fa-minus-circle', 'click', function () {
            $(this).parent().remove();
        });

  // Downloads
        $('input[name=\'download\']').autocomplete({
            'source': function (request, response) {
                $.ajax({
                    url: 'index.php?route=catalog/download/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request),
                    dataType: 'json',
                    success: function (json) {
                        response($.map(json, function (item) {
                            return {
                                label: item['name'],
                                value: item['download_id']
                            }
                        }));
                    }
                });
            },
            'select': function (item) {
                $('input[name=\'download\']').val('');

                $('#room-download' + item['value']).remove();

                $('#room-download').append('<div id="room-download' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="room_download[]" value="' + item['value'] + '" /></div>');
            }
        });

        $('#room-download').delegate('.fa-minus-circle', 'click', function () {
            $(this).parent().remove();
        });

  // Related
        $('input[name=\'related\']').autocomplete({
            'source': function (request, response) {
                $.ajax({
                    url: 'index.php?route=catalog/room/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request),
                    dataType: 'json',
                    success: function (json) {
                        response($.map(json, function (item) {
                            return {
                                label: item['name'],
                                value: item['room_id']
                            }
                        }));
                    }
                });
            },
            'select': function (item) {
                $('input[name=\'related\']').val('');

                $('#room-related' + item['value']).remove();

                $('#room-related').append('<div id="room-related' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="room_related[]" value="' + item['value'] + '" /></div>');
            }
        });

        $('#room-related').delegate('.fa-minus-circle', 'click', function () {
            $(this).parent().remove();
        });
  //--></script> 
    <script type="text/javascript"><!--
  var attribute_row = <?php echo $attribute_row; ?> ;
                function addAttribute() {
                    html = '<tr id="attribute-row' + attribute_row + '">';
                    html += '  <td class="text-left" style="width: 80%;"><input type="text" name="room_attribute[' + attribute_row + '][name]" value="" placeholder="<?php echo $entry_attribute; ?>" class="form-control" /><input type="hidden" name="room_attribute[' + attribute_row + '][attribute_id]" value="" /></td>';
                            <?php foreach ($languages as $language) { ?>
                            html += '<input type="hidden" name="room_attribute[' + attribute_row + '][room_attribute_description][<?php echo $language['language_id']; ?>][text]"/>';
                            <?php } ?>
                    html += '  <td class="text-left"><button type="button" onclick="$(\'#attribute-row' + attribute_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
                    html += '</tr>';

                    $('#attribute tbody').append(html);

                    attributeautocomplete(attribute_row);

                    attribute_row++;
                }

        function attributeautocomplete(attribute_row) {
            $('input[name=\'room_attribute[' + attribute_row + '][name]\']').autocomplete({
                'source': function (request, response) {
                    $.ajax({
                        url: 'index.php?route=catalog/attribute_room/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request),
                        dataType: 'json',
                        success: function (json) {
                            response($.map(json, function (item) {
                                return {
                                    hotel: item.attribute_group,
                                    label: item.name,
                                    value: item.attribute_id
                                }
                            }));
                        }
                    });
                },
                'select': function (item) {
                    $('input[name=\'room_attribute[' + attribute_row + '][name]\']').val(item['label']);
                    $('input[name=\'room_attribute[' + attribute_row + '][attribute_id]\']').val(item['value']);
                }
            });
        }

        $('#attribute tbody tr').each(function (index, element) {
            attributeautocomplete(index);
        });
  //--></script> 
    <script type="text/javascript"><!--
var price_row = <?php echo $price_row; ?>;

function addPrice() {
    html  = '<tr id="price-row' + price_row + '">';
	html += '  <td class="text-left" ><input type="text" name="room_price[' + price_row + '][room_price_net]" value="" placeholder="<?php echo $entry_price_net; ?>" class="form-control" /><input type="hidden" name="room_price[' + price_row + '][price_id]" value="" /></td>';
	html += '  <td class="text-left" ><input type="text" name="room_price[' + price_row + '][room_price_percent]" value="" placeholder="<?php echo $entry_price_percent; ?>" class="form-control" <?php if($author_id != 1) { echo 'id="disabledInput" disabled';} ?>/></td>';
	html += '  <td class="text-left" ><input type="text" name="room_price[' + price_row + '][room_price_gross]" value="" placeholder="<?php echo $entry_price_gross; ?>" class="form-control" id="disabledInput" disabled/></td>';
	html += '  <td class="text-left" ><input type="text" name="room_price[' + price_row + '][room_extra_net]" value="" placeholder="<?php echo $entry_extra_net; ?>" class="form-control" /></td>';
	html += '  <td class="text-left" ><input type="text" name="room_price[' + price_row + '][room_extra_percent]" value="" placeholder="<?php echo $entry_extra_percent; ?>" class="form-control" <?php if($author_id != 1) { echo 'id="disabledInput" disabled';} ?>/></td>';
	html += '  <td class="text-left" ><input type="text" name="room_price[' + price_row + '][room_extra_gross]" value="" placeholder="<?php echo $entry_extra_gross; ?>" class="form-control" id="disabledInput" disabled/></td>';
	html += '  <td class="text-left" ><input type="text" name="room_price[' + price_row + '][room_price_discount]" value="" placeholder="<?php echo $entry_discount; ?>" class="form-control" /></td>';
	html += '  <td class="text-left">';
	html += '<div class="input-group"><span class="input-group-addon">Date_form</span><input type="date" name="room_price[' + price_row + '][room_date][1][date]" rows="1" placeholder="dd/mm/yyyy" class="form-control"/></div>';
	html += '<div class="input-group"><span class="input-group-addon">&nbsp;&nbsp;Date_to&nbsp;&nbsp;&nbsp;</span><input type="date" name="room_price[' + price_row + '][room_date][2][date]" rows="1" placeholder="dd/mm/yyyy" class="form-control"/></div>';
	html += '  </td>';
	html += '  <td class="text-left"><button type="button" onclick="$(\'#price-row' + price_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
    html += '</tr>';
	
	$('#price tbody').append(html);
	
	priceautocomplete(price_row);
	
	price_row++;
}

function priceautocomplete(price_row) {
	$('input[name=\'room_price[' + price_row + '][name]\']').autocomplete({
		'source': function(request, response) {
			$.ajax({
				url: 'index.php?route=catalog/price/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
				dataType: 'json',			
				success: function(json) {
					response($.map(json, function(item) {
						return {
							hotel: item.price_group,
							label: item.name,
							value: item.price_id
						}
					}));
				}
			});
		},
		'select': function(item) {
			$('input[name=\'room_price[' + price_row + '][name]\']').val(item['label']);
			$('input[name=\'room_price[' + price_row + '][price_id]\']').val(item['value']);
		}
	});
}

$('#price tbody tr').each(function(index, element) {
	priceautocomplete(index);
});
//--></script> 
    <script type="text/javascript"><!--
  var image_row = <?php echo $image_row; ?> ;
                function addImage() {
                    html = '<tr id="image-row' + image_row + '">';
                    html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /><input type="hidden" name="room_image[' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
                    html += '  <td class="text-right"><input type="text" name="room_image[' + image_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
                    html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
                    html += '</tr>';

                    $('#images tbody').append(html);

                    image_row++;
                }
  //--></script> 
    <script type="text/javascript"><!--
  $('.date').datetimepicker({
            pickTime: false
        });

        $('.time').datetimepicker({
            pickDate: false
        });

        $('.datetime').datetimepicker({
            pickDate: true,
            pickTime: true
        });
  //--></script> 
    <script type="text/javascript"><!--
  $('#language a:first').tab('show');
        $('#option a:first').tab('show');
  //--></script></div>
<?php echo $footer; ?> 