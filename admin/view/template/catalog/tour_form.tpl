<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-tour" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-tour" class="form-horizontal">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
                        <li><a href="#tab-detail" data-toggle="tab"><?php echo $tab_detail; ?></a></li>
                        <li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>
                        <li><a href="#tab-price" data-toggle="tab"><?php echo $tab_price; ?></a></li>
                        <li><a href="#tab-image" data-toggle="tab"><?php echo $tab_image; ?></a></li>
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
                                            <input type="text" name="tour_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($tour_description[$language['language_id']]) ? $tour_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
                                            <?php if (isset($error_name[$language['language_id']])) { ?>
                                            <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
                                        <div class="col-sm-10">
                                            <textarea name="tour_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>"><?php echo isset($tour_description[$language['language_id']]) ? $tour_description[$language['language_id']]['description'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            <label class="col-sm-2 control-label" for="input-info<?php echo $language['language_id']; ?>"><?php echo $entry_detail; ?></label>
                                            <div class="col-sm-10">
                                                <textarea name="tour_description[<?php echo $language['language_id']; ?>][info]" placeholder="<?php echo $entry_info; ?>" id="input-info<?php echo $language['language_id']; ?>"><?php echo isset($tour_description[$language['language_id']]) ? $tour_description[$language['language_id']]['info'] : ''; ?></textarea>
                                            </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class="col-sm-2 control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
                                        <div class="col-sm-10">
                                            <input type="text" name="tour_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($tour_description[$language['language_id']]) ? $tour_description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
                                            <?php if (isset($error_meta_title[$language['language_id']])) { ?>
                                            <div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
                                        <div class="col-sm-10">
                                            <textarea name="tour_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($tour_description[$language['language_id']]) ? $tour_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
                                        <div class="col-sm-10">
                                            <textarea name="tour_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($tour_description[$language['language_id']]) ? $tour_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-tag<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" title="<?php echo $help_tag; ?>"><?php echo $entry_tag; ?></span></label>
                                        <div class="col-sm-10">
                                            <input type="text" name="tour_description[<?php echo $language['language_id']; ?>][tag]" value="<?php echo isset($tour_description[$language['language_id']]) ? $tour_description[$language['language_id']]['tag'] : ''; ?>" placeholder="<?php echo $entry_tag; ?>" id="input-tag<?php echo $language['language_id']; ?>" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-detail">
                            <div class="table-responsive">
                                <table id="schedule" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td class="text-left"><?php echo $entry_transporter; ?></td>
                                            <?php foreach ($languages as $language) { ?>
                                            <td class="text-left"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $entry_schedule; ?> </td>
                                            <?php } ?>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $schedule_row = 0; ?>
                                        <?php foreach ($tour_schedules as $tour_schedule) { ?>
                                        <tr id="schedule-row<?php echo $schedule_row; ?>">
                                            <td class="text-left" style="width: 20%;"><select name="tour_schedule[<?php echo $schedule_row;?>][transporter]" class="form-control" >
                                                       <option value="1">Train</option>
                                                       <option value="2">Fly</option>
                                                       <option value="3">Bus</option>
                                                        </select></td>
                                                <input type="hidden" name="tour_schedule[<?php echo $schedule_row; ?>][schedule_id]" value="<?php echo $tour_schedule['schedule_id']; ?>" /></td>
                                           <?php foreach ($languages as $language) { ?>
                                           <td style="width: 35%;"><textarea name="tour_schedule[<?php echo $schedule_row; ?>][schedule_description][<?php echo $language['language_id']; ?>][schedule]" placeholder="<?php echo $entry_schedule; ?>" id="input-schedule<?php echo $language['language_id']; ?>" cols="50" rows="15"><?php echo isset($tour_schedules[$schedule_row]['schedule_description'][$language['language_id']]) ? $tour_schedules[$schedule_row]['schedule_description'][$language['language_id']]['schedule'] : ''; ?></textarea></td>
                                                <?php } ?>
                                            <td class="text-left"><button type="button" onclick="$('#schedule-row<?php echo $schedule_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                        </tr>
                                        <?php $schedule_row++; ?>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td class="text-left"><button type="button" onclick="addSchedule();" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary" id="detail"><i class="fa fa-plus-circle"></i></button></td>
                                        </tr>
                                    </tfoot>
                                </table>
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
                                <label class="col-sm-2 control-label" for="input-category"><span data-toggle="tooltip" title="<?php echo $help_category; ?>"><?php echo $entry_category; ?></span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="category" value="" placeholder="<?php echo $entry_category; ?>" id="input-category" class="form-control" />
                                    <div id="tour-category" class="well well-sm" style="height: 150px; overflow: auto;">
                                        <?php foreach ($tour_categories as $tour_category) { ?>
                                        <div id="tour-category<?php echo $tour_category['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $tour_category['name']; ?>
                                            <input type="hidden" name="tour_category[]" value="<?php echo $tour_category['category_id']; ?>" />
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
                                                <?php if (in_array(0, $tour_store)) { ?>
                                                <input type="checkbox" name="tour_store[]" value="0" checked="checked" />
                                                <?php echo $text_default; ?>
                                                <?php } else { ?>
                                                <input type="checkbox" name="tour_store[]" value="0" />
                                                <?php echo $text_default; ?>
                                                <?php } ?>
                                            </label>
                                        </div>
                                        <?php foreach ($stores as $store) { ?>
                                        <div class="checkbox">
                                            <label>
                                                <?php if (in_array($store['store_id'], $tour_store)) { ?>
                                                <input type="checkbox" name="tour_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                                                <?php echo $store['name']; ?>
                                                <?php } else { ?>
                                                <input type="checkbox" name="tour_store[]" value="<?php echo $store['store_id']; ?>" />
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
                                    <input type="hidden" name="author_id" value="<?php echo $author_id;?>"/>
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
                        </div>
                        <div class="tab-pane" id="tab-info">
                            <?php foreach ($languages as $language) { ?>
                            <div class="tab-pane" id="language2<?php echo $language['language_id']; ?>">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-info<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
                                    <div class="col-sm-10">
                                        <textarea name="tour_description[<?php echo $language['language_id']; ?>][info]" placeholder="<?php echo $entry_info; ?>" id="input-info<?php echo $language['language_id']; ?>"><?php echo isset($tour_description[$language['language_id']]) ? $tour_description[$language['language_id']]['info'] : ''; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="tab-pane" id="tab-price">
                            <div class="table-responsive">
                                <div class="col-sm-10">
                                    <?php if ($error_tour_adult_net) { ?>
                                    <div class="text-danger"><?php echo ($error_tour_adult_net) ?></div>
                                    <?php } ?> 
                                    <?php if ($error_tour_child_net) { ?>
                                    <div class="text-danger"><?php echo ($error_tour_child_net) ?></div>
                                    <?php } ?> 
                                    <?php if ($error_tour_baby_net) { ?>
                                    <div class="text-danger"><?php echo ($error_tour_baby_net) ?></div>
                                    <?php } ?> 
                                    <?php if ($error_tour_adult_percent) { ?>
                                    <div class="text-danger"><?php echo ($error_tour_adult_percent) ?></div>
                                    <?php } ?> 
                                    <?php if ($error_tour_child_percent) { ?>
                                    <div class="text-danger"><?php echo ($error_tour_child_percent) ?></div>
                                    <?php } ?>
                                    <?php if ($error_tour_baby_percent) { ?>
                                    <div class="text-danger"><?php echo ($error_tour_baby_percent) ?></div>
                                    <?php } ?>
                                    <?php if ($error_tour_price_discount) { ?>
                                    <div class="text-danger"><?php echo ($error_tour_price_discount) ?></div>
                                    <?php } ?>
                                </div>
                                <table id="price" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td class="text-left"><?php echo $entry_adult_net; ?></td>
                                            <td class="text-left col-md-1"><?php echo $entry_adult_percent; ?></td>
                                            <td class="text-left"><?php echo $entry_child_net; ?></td>
                                            <td class="text-left col-md-1"><?php echo $entry_child_percent; ?></td>
                                            <td class="text-left"><?php echo $entry_baby_net; ?></td>
                                            <td class="text-left col-md-1"><?php echo $entry_baby_percent; ?></td>
                                            <td class="text-left col-md-1"><?php echo $entry_discount; ?></td>
                                            <td class="text-left col-md-3"><?php echo $entry_date; ?></td>
                                            <td width="40px"></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $price_row = 0; ?>
                                        <?php foreach ($tour_prices as $tour_price) { ?>
                                        <tr class="price-row<?php echo $price_row; ?>">
                                            <td class="text-left"><input type="text" name="tour_price[<?php echo $price_row; ?>][tour_adult_net]" value="<?php echo $tour_price['tour_adult_net']; ?>" placeholder="<?php echo $entry_adult_net; ?>" class="form-control" />
                                                <input type="hidden" name="tour_price[<?php echo $price_row; ?>][price_id]" value="<?php echo $tour_price['price_id']; ?>" /></td>
                                            <td class="text-left"><input type="text" name="tour_price[<?php echo $price_row; ?>][tour_adult_percent]" value="<?php echo $tour_price['tour_adult_percent']; ?>" placeholder="<?php echo $entry_adult_percent; ?>" class="form-control" <?php if($author_id != 1) { echo 'id="disabledInput" disabled';} ?> /></td>
                                            <td class="text-left"><input type="text" name="tour_price[<?php echo $price_row; ?>][tour_child_net]" value="<?php echo $tour_price['tour_child_net']; ?>" placeholder="<?php echo $entry_child_net; ?>" class="form-control" /></td>
                                            <td class="text-left"><input type="text" name="tour_price[<?php echo $price_row; ?>][tour_child_percent]" value="<?php echo $tour_price['tour_child_percent']; ?>" placeholder="<?php echo $entry_child_percent; ?>" class="form-control" <?php if($author_id != 1) { echo 'id="disabledInput" disabled';} ?> /></td>
                                            <td class="text-left"><input type="text" name="tour_price[<?php echo $price_row; ?>][tour_baby_net]" value="<?php echo $tour_price['tour_baby_net']; ?>" placeholder="<?php echo $entry_baby_net; ?>" class="form-control" /></td>
                                            <td class="text-left"><input type="text" name="tour_price[<?php echo $price_row; ?>][tour_baby_percent]" value="<?php echo $tour_price['tour_baby_percent']; ?>" placeholder="<?php echo $entry_baby_percent; ?>" class="form-control" <?php if($author_id != 1) { echo 'id="disabledInput" disabled';} ?> /></td>
                                            <td class="text-left"><input type="text" name="tour_price[<?php echo $price_row; ?>][tour_price_discount]" value="<?php echo $tour_price['tour_price_discount']; ?>" placeholder="<?php echo $entry_discount; ?>" class="form-control" /></td>
                                            <td class="text-left">
                                                <div class="input-group"><span class="input-group-addon">Date_form</span>
                                                    <input type="date" name="tour_price[<?php echo $price_row; ?>][tour_date][1][date]" rows="1" class="form-control" value="<?php echo isset($tour_price['tour_date']['1']['date']) ? $tour_price['tour_date']['1']['date'] : ''; ?>"/>
                                                </div>
                                                <div class="input-group"><span class="input-group-addon">Date_to  </span>
                                                    <input type="date" name="tour_price[<?php echo $price_row; ?>][tour_date][2][date]" rows="1" class="form-control" value="<?php echo isset($tour_price['tour_date']['2']['date']) ? $tour_price['tour_date']['2']['date'] : ''; ?>"/>  
                                                </div>
                                            </td>
                                            <td class="text-left"><button type="button" onclick="$('.price-row<?php echo $price_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                        </tr>
                                        <tr class="price-row<?php echo $price_row; ?>">
                                            <td class="text-left"><?php echo $entry_adult_gross; ?></td>
                                            <td class="text-left"><input type="text" placeholder="<?php echo $tour_price['tour_adult_gross']; ?>" class="form-control" id="disabledInput" disabled/></td>
                                            <td class="text-left"><?php echo $entry_child_gross; ?></td>
                                            <td class="text-left"><input type="text" placeholder="<?php echo $tour_price['tour_child_gross']; ?>" class="form-control" id="disabledInput" disabled/></td>
                                            <td class="text-left"><?php echo $entry_baby_gross; ?></td>
                                            <td class="text-left"><input type="text" placeholder="<?php echo $tour_price['tour_baby_gross']; ?>" class="form-control" id="disabledInput" disabled/></td>
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
                                        <?php foreach ($tour_images as $tour_image) { ?>
                                        <tr id="image-row<?php echo $image_row; ?>">
                                            <td class="text-left"><a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $tour_image['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="tour_image[<?php echo $image_row; ?>][image]" value="<?php echo $tour_image['image']; ?>" id="input-image<?php echo $image_row; ?>" /></td>
                                            <td class="text-right"><input type="text" name="tour_image[<?php echo $image_row; ?>][sort_order]" value="<?php echo $tour_image['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>
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
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
<?php foreach ($languages as $language) { ?>
$('#input-description<?php echo $language['language_id']; ?>').summernote({height: 300});
<?php } ?>
<?php foreach ($languages as $language) { ?>
$('#input-info<?php echo $language['language_id']; ?>').summernote({height: 300});
<?php } ?>

</script>  
    <script type="text/javascript">
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
        $('input[name=\'category\']').autocomplete({
            'source': function (request, response) {
                $.ajax({
                    url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request),
                    dataType: 'json',
                    success: function (json) {
                        response($.map(json, function (item) {
                            return {
                                label: item['name'],
                                value: item['category_id']
                            }
                        }));
                    }
                });
            },
            'select': function (item) {
                $('input[name=\'category\']').val('');

                $('#tour-category' + item['value']).remove();

                $('#tour-category').append('<div id="tour-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="tour_category[]" value="' + item['value'] + '" /></div>');
            }
        });

        $('#tour-category').delegate('.fa-minus-circle', 'click', function () {
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

                $('#tour-filter' + item['value']).remove();

                $('#tour-filter').append('<div id="tour-filter' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="tour_filter[]" value="' + item['value'] + '" /></div>');
            }
        });

        $('#tour-filter').delegate('.fa-minus-circle', 'click', function () {
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

                $('#tour-download' + item['value']).remove();

                $('#tour-download').append('<div id="tour-download' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="tour_download[]" value="' + item['value'] + '" /></div>');
            }
        });

        $('#tour-download').delegate('.fa-minus-circle', 'click', function () {
            $(this).parent().remove();
        });

  // Related
        $('input[name=\'related\']').autocomplete({
            'source': function (request, response) {
                $.ajax({
                    url: 'index.php?route=catalog/tour/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request),
                    dataType: 'json',
                    success: function (json) {
                        response($.map(json, function (item) {
                            return {
                                label: item['name'],
                                value: item['tour_id']
                            }
                        }));
                    }
                });
            },
            'select': function (item) {
                $('input[name=\'related\']').val('');

                $('#tour-related' + item['value']).remove();

                $('#tour-related').append('<div id="tour-related' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="tour_related[]" value="' + item['value'] + '" /></div>');
            }
        });

        $('#tour-related').delegate('.fa-minus-circle', 'click', function () {
            $(this).parent().remove();
        });
</script> 
    <script type="text/javascript">
var schedule_row = <?php echo $schedule_row; ?>;
function addSchedule() {
    html  = '<tr class="schedule-row' + schedule_row + '">';
	html += '  <td class="text-left" ><input type="hidden" name="tour_schedule[' + schedule_row + '][schedule_id]" value="" /><select name="tour_schedule[' + schedule_row + '][transporter]" value="" class="form-control" >';
	html += '  <option value="1">Bus<option>';
	html += '  <option value="2">Traino<ption>';
	html += '  <option value="3">Plane<option></td>';
	<?php foreach ($languages as $language) { ?>
        html += '  <td class="text-left" ><textarea name="tour_schedule[' + schedule_row + '][schedule_description][<?php echo $language['language_id']; ?>][schedule]" placeholder="<?php echo $entry_detail; ?>" class="input-wyswyg" id="input-schedule<?php echo $language['language_id']; ?>-' + schedule_row + '" cols="50" rows="15"><?php echo isset($tour_schedule[' + schedule_row + ']['schedule_description'][$language['language_id']]) ? $tour_schedule[' + schedule_row + ']['schedule_description'][$language['language_id']]['schedule'] : ''; ?></textarea></td>'
        <?php } ?>
	html += '  <td class="text-left"><button type="button" onclick="$(\'.schedule-row' + schedule_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
        html += '</tr>';
	$('#schedule tbody').append(html);
        <?php foreach ($languages as $language) { ?>
        $('.input-wyswyg').each(function (index, item){
            $(item).summernote({height: 300});
        });
        <?php } ?>
	schedule_row++;
}

</script> 
    <script type="text/javascript">
var price_row = <?php echo $price_row; ?>;
function addPrice() {
    html  = '<tr class="price-row' + price_row + '">';
	html += '  <td class="text-left" ><input type="text" name="tour_price[' + price_row + '][tour_adult_net]" value="" placeholder="<?php echo $entry_adult_net; ?>" class="form-control" /><input type="hidden" name="tour_price[' + price_row + '][price_id]" value="" /></td>';
	html += '  <td class="text-left" ><input type="text" name="tour_price[' + price_row + '][tour_adult_percent]" value="" placeholder="<?php echo $entry_adult_percent; ?>" class="form-control" <?php if($author_id != 1) { echo 'id="disabledInput" disabled';} ?>/></td>';
	html += '  <td class="text-left" ><input type="text" name="tour_price[' + price_row + '][tour_child_net]" value="" placeholder="<?php echo $entry_child_net; ?>" class="form-control" /></td>';
	html += '  <td class="text-left" ><input type="text" name="tour_price[' + price_row + '][tour_child_percent]" value="" placeholder="<?php echo $entry_child_percent; ?>" class="form-control" <?php if($author_id != 1) { echo 'id="disabledInput" disabled';} ?>/></td>';
	html += '  <td class="text-left" ><input type="text" name="tour_price[' + price_row + '][tour_baby_net]" value="" placeholder="<?php echo $entry_baby_net; ?>" class="form-control" /></td>';
	html += '  <td class="text-left" ><input type="text" name="tour_price[' + price_row + '][tour_baby_percent]" value="" placeholder="<?php echo $entry_baby_percent; ?>" class="form-control" <?php if($author_id != 1) { echo 'id="disabledInput" disabled';} ?>/></td>';
	html += '  <td class="text-left" ><input type="text" name="tour_price[' + price_row + '][tour_price_discount]" value="" placeholder="<?php echo $entry_discount; ?>" class="form-control" /></td>';
	html += '  <td class="text-left">';
	html += '<div class="input-group"><span class="input-group-addon">Date_form</span><input type="date" name="tour_price[' + price_row + '][tour_date][1][date]" rows="1" placeholder="dd/mm/yyyy" class="form-control"/></div>';
	html += '<div class="input-group"><span class="input-group-addon">&nbsp;&nbsp;Date_to&nbsp;&nbsp;&nbsp;</span><input type="date" name="tour_price[' + price_row + '][tour_date][2][date]" rows="1" placeholder="dd/mm/yyyy" class="form-control"/></div>';
	html += '  </td>';
	html += '  <td class="text-left"><button type="button" onclick="$(\'.price-row' + price_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
    html += '</tr>';
    html += '<tr  class="price-row' + price_row + '">';
        html += '  <td class="text-left"><?php echo $entry_adult_gross; ?></td>';
        html += '  <td class="text-left"><input type="text" name="tour_price[' + price_row + '][tour_adult_gross]" value="" placeholder="<?php echo $entry_adult_gross; ?>" class="form-control" id="disabledInput" disabled/></td>';
        html += '  <td class="text-left"><?php echo $entry_child_gross; ?></td>';
	html += '  <td class="text-left"><input type="text" name="tour_price[' + price_row + '][tour_child_gross]" value="" placeholder="<?php echo $entry_child_gross; ?>" class="form-control" id="disabledInput" disabled/></td>';
        html += '  <td class="text-left"><?php echo $entry_baby_gross; ?></td>';
	html += '  <td class="text-left"><input type="text" name="tour_price[' + price_row + '][tour_baby_gross]" value="" placeholder="<?php echo $entry_baby_gross; ?>" class="form-control" id="disabledInput" disabled/></td>';
        html += '  <td colspan="3"></td>';
    html += '</tr>';
	
	$('#price tbody').append(html);
	
	priceautocomplete(price_row);
	
	price_row++;
}

function priceautocomplete(price_row) {
	$('input[name=\'tour_price[' + price_row + '][name]\']').autocomplete({
		'source': function(request, response) {
			$.ajax({
				url: 'index.php?route=catalog/price/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
				dataType: 'json',			
				success: function(json) {
					response($.map(json, function(item) {
						return {
							tour: item.price_group,
							label: item.name,
							value: item.price_id
						}
					}));
				}
			});
		},
		'select': function(item) {
			$('input[name=\'tour_price[' + price_row + '][name]\']').val(item['label']);
			$('input[name=\'tour_price[' + price_row + '][price_id]\']').val(item['value']);
		}
	});
}

$('#price tbody tr').each(function(index, element) {
	priceautocomplete(index);
});
</script> 
    <script type="text/javascript">
  var image_row = <?php echo $image_row; ?> ;
                function addImage() {
                    html = '<tr id="image-row' + image_row + '">';
                    html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /><input type="hidden" name="tour_image[' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
                    html += '  <td class="text-right"><input type="text" name="tour_image[' + image_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
                    html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
                    html += '</tr>';

                    $('#images tbody').append(html);

                    image_row++;
                }
</script> 
    <script type="text/javascript">

        $('.time').datetimepicker({
            pickDate: false
        });

        $('.datetime').datetimepicker({
            pickDate: true,
            pickTime: true
        });
</script> 
    <script type="text/javascript">
  $('#language a:first').tab('show');
        $('#option a:first').tab('show');
  $('#language1 a:first').tab('show');
        $('#option1 a:first').tab('show');
  $('#language2 a:first').tab('show');
        $('#option2 a:first').tab('show');
</script></div>
<?php echo $footer; ?> 