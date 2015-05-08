<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-hotel" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-hotel" class="form-horizontal">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
                        <li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>
                        <li><a href="#tab-attribute" data-toggle="tab"><?php echo $tab_attribute; ?></a></li>
                        <li><a href="#tab-maps" data-toggle="tab"><?php echo $tab_maps; ?></a></li>
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
                                            <input type="text" name="hotel_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($hotel_description[$language['language_id']]) ? $hotel_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
                                            <?php if (isset($error_name[$language['language_id']])) { ?>
                                            <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-address<?php echo $language['language_id']; ?>"><?php echo $entry_address; ?></label>
                                        <div class="col-sm-10">
                                            <input type="text" name="hotel_description[<?php echo $language['language_id']; ?>][address]" placeholder="<?php echo $entry_address; ?>" id="input-address<?php echo $language['language_id']; ?>" value="<?php echo isset($hotel_description[$language['language_id']]) ? $hotel_description[$language['language_id']]['address'] : ''; ?>" class = "form-control"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
                                        <div class="col-sm-10">
                                            <textarea name="hotel_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>"><?php echo isset($hotel_description[$language['language_id']]) ? $hotel_description[$language['language_id']]['description'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-short-description<?php echo $language['language_id']; ?>"><?php echo $entry_short_description; ?></label>
                                        <div class="col-sm-10">
                                            <textarea name="hotel_description[<?php echo $language['language_id']; ?>][short_description]" placeholder="<?php echo $entry_short_description; ?>" id="input-short-description<?php echo $language['language_id']; ?>"><?php echo isset($hotel_description[$language['language_id']]) ? $hotel_description[$language['language_id']]['short_description'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class="col-sm-2 control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
                                        <div class="col-sm-10">
                                            <input type="text" name="hotel_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($hotel_description[$language['language_id']]) ? $hotel_description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
                                            <?php if (isset($error_meta_title[$language['language_id']])) { ?>
                                            <div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
                                        <div class="col-sm-10">
                                            <textarea name="hotel_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($hotel_description[$language['language_id']]) ? $hotel_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
                                        <div class="col-sm-10">
                                            <textarea name="hotel_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($hotel_description[$language['language_id']]) ? $hotel_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-tag<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" title="<?php echo $help_tag; ?>"><?php echo $entry_tag; ?></span></label>
                                        <div class="col-sm-10">
                                            <input type="text" name="hotel_description[<?php echo $language['language_id']; ?>][tag]" value="<?php echo isset($hotel_description[$language['language_id']]) ? $hotel_description[$language['language_id']]['tag'] : ''; ?>" placeholder="<?php echo $entry_tag; ?>" id="input-tag<?php echo $language['language_id']; ?>" class="form-control" />
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
                                    <input type="hidden" name="author_id" value="<?php echo $author_id; ?>" />
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
                                    <div id="hotel-category" class="well well-sm" style="height: 150px; overflow: auto;">
                                        <?php foreach ($hotel_categories as $hotel_category) { ?>
                                        <div id="hotel-category<?php echo $hotel_category['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $hotel_category['name']; ?>
                                            <input type="hidden" name="hotel_category[]" value="<?php echo $hotel_category['category_id']; ?>" />
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
                                                <?php if (in_array(0, $hotel_store)) { ?>
                                                <input type="checkbox" name="hotel_store[]" value="0" checked="checked" />
                                                <?php echo $text_default; ?>
                                                <?php } else { ?>
                                                <input type="checkbox" name="hotel_store[]" value="0" />
                                                <?php echo $text_default; ?>
                                                <?php } ?>
                                            </label>
                                        </div>
                                        <?php foreach ($stores as $store) { ?>
                                        <div class="checkbox">
                                            <label>
                                                <?php if (in_array($store['store_id'], $hotel_store)) { ?>
                                                <input type="checkbox" name="hotel_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                                                <?php echo $store['name']; ?>
                                                <?php } else { ?>
                                                <input type="checkbox" name="hotel_store[]" value="<?php echo $store['store_id']; ?>" />
                                                <?php echo $store['name']; ?>
                                                <?php } ?>
                                            </label>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo $entry_star; ?></label>
                                <div class="col-sm-10">
                                    <label class="radio-inline">
                                        <?php if ($star == 0) { ?>
                                        <input type="radio" name="star" value="0" checked="checked" /> 0
                                        <?php } else { ?>
                                        <input type="radio" name="star" value="0" /> 0
                                        <?php } ?>
                                    </label>
                                    <label class="radio-inline">
                                        <?php if ($star == 1) { ?>
                                        <input type="radio" name="star" value="1" checked="checked" /> 1<span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                                        <?php } else { ?>
                                        <input type="radio" name="star" value="1" /> 1<span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                                        <?php } ?>
                                    </label>
                                    <label class="radio-inline">
                                        <?php if ($star == 2) { ?>
                                        <input type="radio" name="star" value="2" checked="checked" /> 2<span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span><span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                                        <?php } else { ?>
                                        <input type="radio" name="star" value="2" /> 2<span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span><span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                                        <?php } ?>
                                    </label>
                                    <label class="radio-inline">
                                        <?php if ($star == 3) { ?>
                                        <input type="radio" name="star" value="3" checked="checked" /> 3<span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span><span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span><span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                                        <?php } else { ?>
                                        <input type="radio" name="star" value="3" /> 3<span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span><span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span><span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                                        <?php } ?>
                                    </label>
                                    <label class="radio-inline">
                                        <?php if ($star == 4) { ?>
                                        <input type="radio" name="star" value="4" checked="checked" /> 4<span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span><span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span><span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span><span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                                        <?php } else { ?>
                                        <input type="radio" name="star" value="4" /> 4<span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span><span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span><span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span><span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                                        <?php } ?>
                                    </label>
                                    <label class="radio-inline">
                                        <?php if ($star == 5) { ?>
                                        <input type="radio" name="star" value="5" checked="checked" /> 5<span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span><span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span><span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span><span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span><span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                                        <?php } else { ?>
                                        <input type="radio" name="star" value="5" /> 5<span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span><span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span><span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span><span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span><span class="rating fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                                        <?php } ?>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo $entry_wifi; ?></label>
                                <div class="col-sm-10">
                                    <label class="radio-inline">
                                        <?php if ($wifi) { ?>
                                        <input type="radio" name="wifi" value="1" checked="checked" />
                                        <?php echo $text_yes; ?>
                                        <?php } else { ?>
                                        <input type="radio" name="wifi" value="1" />
                                        <?php echo $text_yes; ?>
                                        <?php } ?>
                                    </label>
                                    <label class="radio-inline">
                                        <?php if (!$wifi) { ?>
                                        <input type="radio" name="wifi" value="0" checked="checked" />
                                        <?php echo $text_no; ?>
                                        <?php } else { ?>
                                        <input type="radio" name="wifi" value="0" />
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
                                        <?php foreach ($hotel_attributes as $hotel_attribute) { ?>
                                        <tr id="attribute-row<?php echo $attribute_row; ?>">
                                            <td class="text-left"><input type="text" name="hotel_attribute[<?php echo $attribute_row; ?>][name]" value="<?php echo $hotel_attribute['name']; ?>" placeholder="<?php echo $entry_attribute; ?>" class="form-control" />
                                                <input type="hidden" name="hotel_attribute[<?php echo $attribute_row; ?>][attribute_id]" value="<?php echo $hotel_attribute['attribute_id']; ?>" /></td>
                                           <?php foreach ($languages as $language) { ?>
                                             <input type="hidden" name="hotel_attribute[<?php echo $attribute_row; ?>][hotel_attribute_description][<?php echo $language['language_id']; ?>][text]" />
                                                <?php } ?>
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
                        <div class="tab-pane" id="tab-maps">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <?php if ($error_maps_api) { ?>
                                    <div class="text-danger"><?php echo $error_maps_api; ?></div>
                                    <?php } ?> 
                                    <label class="col-sm-2 control-label" for="input-maps-title"><?php echo $entry_maps_api; ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" name="maps_apil" value="<?php echo $maps_apil; ?>" placeholder="<?php echo $entry_maps_api; ?>" id="input-maps-apil" class="form-control" />
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="maps_apir" value="<?php echo $maps_apir; ?>" placeholder="<?php echo $entry_maps_api; ?>" id="input-maps-apir" class="form-control" />
                                    </div>
                                </div>
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
                                        <?php foreach ($hotel_images as $hotel_image) { ?>
                                        <tr id="image-row<?php echo $image_row; ?>">
                                            <td class="text-left"><a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $hotel_image['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="hotel_image[<?php echo $image_row; ?>][image]" value="<?php echo $hotel_image['image']; ?>" id="input-image<?php echo $image_row; ?>" /></td>
                                            <td class="text-right"><input type="text" name="hotel_image[<?php echo $image_row; ?>][sort_order]" value="<?php echo $hotel_image['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>
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
    <script type="text/javascript"><!--
  <?php foreach ($languages as $language) { ?>
                $('#input-description<?php echo $language['language_id']; ?>').summernote({height: 300});
                <?php } ?>
  //--></script> 
    <script type="text/javascript"><!--
  <?php foreach ($languages as $language) { ?>
                $('#input-short-description<?php echo $language['language_id']; ?>').summernote({height: 300});
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

                $('#hotel-category' + item['value']).remove();

                $('#hotel-category').append('<div id="hotel-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="hotel_category[]" value="' + item['value'] + '" /></div>');
            }
        });

        $('#hotel-category').delegate('.fa-minus-circle', 'click', function () {
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

                $('#hotel-filter' + item['value']).remove();

                $('#hotel-filter').append('<div id="hotel-filter' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="hotel_filter[]" value="' + item['value'] + '" /></div>');
            }
        });

        $('#hotel-filter').delegate('.fa-minus-circle', 'click', function () {
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

                $('#hotel-download' + item['value']).remove();

                $('#hotel-download').append('<div id="hotel-download' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="hotel_download[]" value="' + item['value'] + '" /></div>');
            }
        });

        $('#hotel-download').delegate('.fa-minus-circle', 'click', function () {
            $(this).parent().remove();
        });

  // Related
        $('input[name=\'related\']').autocomplete({
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
                $('input[name=\'related\']').val('');

                $('#hotel-related' + item['value']).remove();

                $('#hotel-related').append('<div id="hotel-related' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="hotel_related[]" value="' + item['value'] + '" /></div>');
            }
        });

        $('#hotel-related').delegate('.fa-minus-circle', 'click', function () {
            $(this).parent().remove();
        });
  //--></script> 
    <script type="text/javascript"><!--
  var attribute_row = <?php echo $attribute_row; ?> ;
                function addAttribute() {
                    html = '<tr id="attribute-row' + attribute_row + '">';
                    html += '  <td class="text-left" style="width: 20%;"><input type="text" name="hotel_attribute[' + attribute_row + '][name]" value="" placeholder="<?php echo $entry_attribute; ?>" class="form-control" /><input type="hidden" name="hotel_attribute[' + attribute_row + '][attribute_id]" value="" /></td>';
                            <?php foreach ($languages as $language) { ?>
                            html += '<input type ="hidden" name="hotel_attribute[' + attribute_row + '][hotel_attribute_description][<?php echo $language['language_id']; ?>][text]" />';
                            <?php } ?>
                    html += '  <td class="text-left"><button type="button" onclick="$(\'#attribute-row' + attribute_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
                    html += '</tr>';

                    $('#attribute tbody').append(html);

                    attributeautocomplete(attribute_row);

                    attribute_row++;
                }

        function attributeautocomplete(attribute_row) {
            $('input[name=\'hotel_attribute[' + attribute_row + '][name]\']').autocomplete({
                'source': function (request, response) {
                    $.ajax({
                        url: 'index.php?route=catalog/attribute/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request),
                        dataType: 'json',
                        success: function (json) {
                            response($.map(json, function (item) {
                                return {
                                    category: item.attribute_group,
                                    label: item.name,
                                    value: item.attribute_id
                                }
                            }));
                        }
                    });
                },
                'select': function (item) {
                    $('input[name=\'hotel_attribute[' + attribute_row + '][name]\']').val(item['label']);
                    $('input[name=\'hotel_attribute[' + attribute_row + '][attribute_id]\']').val(item['value']);
                }
            });
        }

        $('#attribute tbody tr').each(function (index, element) {
            attributeautocomplete(index);
        });
  //--></script> 
    <script type="text/javascript"><!--
  var image_row = <?php echo $image_row; ?> ;
                function addImage() {
                    html = '<tr id="image-row' + image_row + '">';
                    html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /><input type="hidden" name="hotel_image[' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
                    html += '  <td class="text-right"><input type="text" name="hotel_image[' + image_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
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