<?php echo $header; ?>
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
        <div class="col-sm-3">
      <h1><?php echo $heading_title; ?></h1>
      <label class="control-label" for="input-search"><?php echo $entry_search; ?></label>
      <div class="form-group">
        <div class="row col-sm-12">
          <input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $text_keyword; ?>" id="input-search" class="form-control" />
        </div>
        <div class="row col-sm-12">
          <select name="category_id" class="form-control">
            <option value="0"><?php echo $text_category; ?></option>
            <?php foreach ($categories as $category_1) { ?>
            <?php if ($category_1['category_id'] == $category_id) { ?>
            <option value="<?php echo $category_1['category_id']; ?>" selected="selected"><?php echo $category_1['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $category_1['category_id']; ?>"><?php echo $category_1['name']; ?></option>
            <?php } ?>
            <?php foreach ($category_1['children'] as $category_2) { ?>
            <?php if ($category_2['category_id'] == $category_id) { ?>
            <option value="<?php echo $category_2['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $category_2['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
            <?php } ?>
            <?php foreach ($category_2['children'] as $category_3) { ?>
            <?php if ($category_3['category_id'] == $category_id) { ?>
            <option value="<?php echo $category_3['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $category_3['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
            <?php } ?>
            <?php } ?>
            <?php } ?>
            <?php } ?>
          </select>
        </div>
        <div class="row col-sm-12">
          <label class="checkbox-inline">
            <?php if ($sub_category) { ?>
            <input type="checkbox" name="sub_category" value="1" checked="checked" />
            <?php } else { ?>
            <input type="checkbox" name="sub_category" value="1" />
            <?php } ?>
            <?php echo $text_sub_category; ?></label>
        </div>
      </div>
      <p>
        <label class="checkbox-inline">
          <?php if ($description) { ?>
          <input type="checkbox" name="description" value="1" id="description" checked="checked" />
          <?php } else { ?>
          <input type="checkbox" name="description" value="1" id="description" />
          <?php } ?>
          <?php echo $entry_description; ?></label>
      </p>
      <input type="button" value="<?php echo $button_search; ?>" id="button-search" class="btn btn-primary" />
    </div>
      <div class="row col-sm-9">
      <h2><?php echo $text_search; ?></h2>
      <?php if ($proparents) { ?>
      <div class="row">
        <div class="col-sm-2 hidden-xs">
          <div class="btn-group">
            <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_list; ?>"><i class="fa fa-th-list"></i></button>
            <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_grid; ?>"><i class="fa fa-th"></i></button>
          </div>
        </div>
        <div class="col-sm-3 text-right">
          <label class="control-label" for="input-sort"><?php echo $text_sort; ?></label>
        </div>
        <div class="col-sm-3 text-right">
          <select id="input-sort" class="form-control col-sm-3" onchange="location = this.value;">
            <?php foreach ($sorts as $sorts) { ?>
            <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
            <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
            <?php } ?>
            <?php } ?>
          </select>
        </div>
        <div class="col-sm-2 text-right">
          <label class="control-label" for="input-limit"><?php echo $text_limit; ?></label>
        </div>
        <div class="col-sm-2 text-right">
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
      <br />
      <div class="row">
                <?php foreach ($proparents as $proparent) { ?>
                <div class="product-layout product-list col-xs-12">
                    <div class="product-thumb">
                        <div class="image"><a href="<?php echo $proparent['hrefp']; ?>"><img src="<?php echo $proparent['thumbp']; ?>" alt="<?php echo $proparent['namep']; ?>" title="<?php echo $proparent['namep']; ?>" class="img-responsive" /></a></div>
                        <div>
                            <div class="caption">
                                <h4><a href="<?php echo $proparent['hrefp']; ?>"><?php echo $proparent['namep']; ?></a><span class="rating">
                                    <?php for ($i = 1; $i <= 5; $i++) { ?>
                                    <?php if ($proparent['ratingp'] < $i) { ?>
                                    <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                                    <?php } else { ?>
                                    <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                                    <?php } ?>
                                    <?php } ?>
                                </span></h4>
                                <p><?php echo $proparent['descriptionp']; ?></p>
                                <?php if ($proparent['ratingp']) { ?>
                                
                                <?php } ?>
                                <!--
                                <?php if ($proparent['pricep']) { ?>
                                <p class="price">
                                    <?php if (!$proparent['specialp']) { ?>
                                    <?php echo $proparent['pricep']; ?>
                                    <?php } else { ?>
                                    <span class="price-new"><?php echo $proparent['specialp']; ?></span> <span class="price-old"><?php echo $proparent['pricep']; ?></span>
                                    <?php } ?>
                                    <?php if ($proparent['taxp']) { ?>
                                    <span class="price-tax"><?php echo $text_tax; ?> <?php echo $proparent['taxp']; ?></span>
                                    <?php } ?>
                                </p>
                                <?php } ?>
                                -->
                            </div>
                            <div class = "col-xs-12" >
                                <?php if ($proparent[0]) { ?>
                                <div class="table table-responsive table-hover table-striped">
                                    <?php  for($i=0; $i < $proparent['product_total'];$i++) { ?>
                                    <div class="list-group">
                                            <a href="<?php echo $proparent[$i]['href'];?>" class="col-xs-12">
                                                <span class="col-xs-2 text-primary"><?php echo $proparent[$i]['name'];?></span>
                                                <span class="col-xs-4 text-info"><strong><?php echo $proparent[$i]['description'];?></strong></span>
                                                <?php if ($proparent[$i]['quantity'] == 1){ ?>
                                                <span class="col-xs-3 text-danger"><strong>Our last room !!!</strong></span>
                                                <?php } else { if ($proparent[$i]['quantity'] <= 5) { ?>
                                                <span class="col-xs-3 text-warning"><strong>Our last <?php echo $proparent[$i]['quantity'];?> room </strong></span>
                                                <?php } else { ?>
                                                <span class="col-xs-3 text-success"><strong>Available</strong></span>
                                                <?php } ?>
                                                <?php } ?>
                                                <span class="col-xs-3 text-right"><strong><?php echo $proparent[$i]['price'];?></strong></span>
                                            </a> 
                                    </div>
                                    <?php ; } ?>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="col-xs-4 pull-right">
                                <a href="<?php echo $proparent['hrefp']; ?>" ><button type="button" class = "btn btn-primary btn-lg btn-block "><i class="fa fa-shopping-cart"></i> Book </button></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
      <div class="row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><?php echo $results; ?></div>
      </div>
      <?php } else { ?>
      <p><?php echo $text_empty; ?></p>
      <?php } ?>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<script type="text/javascript"><!--
$('#button-search').bind('click', function() {
	url = 'index.php?route=product/search';
	
	var search = $('#content input[name=\'search\']').prop('value');
	
	if (search) {
		url += '&search=' + encodeURIComponent(search);
	}

	var category_id = $('#content select[name=\'category_id\']').prop('value');
	
	if (category_id > 0) {
		url += '&category_id=' + encodeURIComponent(category_id);
	}
	
	var sub_category = $('#content input[name=\'sub_category\']:checked').prop('value');
	
	if (sub_category) {
		url += '&sub_category=true';
	}
		
	var filter_description = $('#content input[name=\'description\']:checked').prop('value');
	
	if (filter_description) {
		url += '&description=true';
	}

	location = url;
});

$('#content input[name=\'search\']').bind('keydown', function(e) {
	if (e.keyCode == 13) {
		$('#button-search').trigger('click');
	}
});

$('select[name=\'category_id\']').on('change', function() {
	if (this.value == '0') {
		$('input[name=\'sub_category\']').prop('disabled', true);
	} else {
		$('input[name=\'sub_category\']').prop('disabled', false);
	}
});

$('select[name=\'category_id\']').trigger('change');
--></script> 
<?php echo $footer; ?> 