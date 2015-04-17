<?php echo $header; ?>
<div class="container">
    <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
    </ul>
    <div class="row">
        <div id="content" class="col-sm-12"><?php echo $content_top; ?>
            <div class="col-sm-3">
                <div class="panel-wrapper">
                    <div class="box box-title">
                        <h4 class="title"><strong> <?php echo $title; ?></strong></h4>
                    </div>
                    <div id="form-search"  class="box box-content form-group">
                        <form method="POST" action="index.php?route=product/search">
                        <label class="control-label" for="input-search"><?php echo $entry_search; ?></label>
                            <div class="form-group col-sm-12">
                                <input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $text_keyword; ?>" id="input-search" class="form-control" />
                            </div>
                            <br/>
                            <div id="search_home" class="form-group col-sm-12">
                                <div class="form-group">
                                    <div class="">
                                        <label class="control-label" for="input-option219"><?php echo $text_labeldate_in; ?></label>
                                        <div class="col-xs-12 input-group date">
                                            <input type="text" name="date-in" id ="date-in" value="<?php echo $_SESSION['date']; ?>" data-date-format="YYYY-MM-DD" placeholder="<?php echo date('Y-m-d');?>" class="form-control" />
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button" id="date"><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
                                        <br />
                                        <label class="control-label" for="input-option219"><?php echo $text_labeldate_out; ?></label>
                                        <div class="col-xs-12 input-group date">
                                            <input type="text" name="date-out" value="<?php echo $_SESSION['date-out']; ?>" data-date-format="YYYY-MM-DD" placeholder="<?php echo date('Y-m-d');?>" class="form-control" />
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button" id="date"><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 form-group">
                                        <label class="control-label" for="input-option217"><?php echo $text_labelguest; ?></label>
                                                    <select name="adults" class="form-control ">
                                            <option value="">--- Please Select ---</option>
                                            <?php for($i=1;$i<=3;$i++) { ?>
                                            <option value="<?php echo $i; ?>" <?php if($i==$_SESSION['adults']) { echo 'selected'; } ?>><?php echo $i; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <button type="submit" id="button-search" class="btn btn-primary btn-block" ><strong><?php echo $button_search; ?></strong></button>
                    </form>
                    </div>
                </div>
            </div>
            <div id="search-result" class="row col-sm-9">
                <h3><?php echo $text_found; ?><strong class = "text-primary"><?php if(isset($total))echo $total; ?></strong><?php echo $text_hotelin; ?><strong class = "text-primary"><?php echo $title_search; ?></strong>. <?php if(isset($results))echo $results; ?></h3>
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
                    <div id = "product" class="product-layout product-list col-xs-12">
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
                                    <div class="pull-right text-right text-primary">
                                     <h4 class ="text-primary">
                                         <?php if ($proparent['ratingp']) { ?>
                                    <?php
                                        switch ($proparent['ratingp']) {
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
                                    <?php echo $text_rating.' '.$proparent['ratingp']; ?>
                                    <?php } ?>
                                </h4>
                                     <div>
                                         <?php echo $proparent['pareviews']; ?>
                                     </div>
                                 </div>
                                    <p><strong><?php if ($proparent['wifi'] == 1) { ?>
                                    <?php echo $text_freewifi; ?> <img src="catalog/view/theme/default/image/icon_aniwifi.gif"/>
                                    <?php } else { ?>
                                    <?php echo $text_nowifi; ?> <img src="catalog/view/theme/default/image/icon_nowifi.png"/>
                                    <?php } ?>
                                    </strong></p>
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
                                    <div class="col-xs-4 pull-bottom-right">
                                        <a href="<?php echo $proparent['hrefp']; ?>" ><button type="button" class = "btn btn-primary btn-block "><i class="fa fa-shopping-cart"></i><strong> <?php echo $text_book; ?> </strong></button></a>
                                </div>
                                </div>
                                <div class = "col-xs-12" >
                                    <?php if (isset($proparent[0])) { ?>
                                    <div class="table table-responsive table-hover table-striped">
                                        <?php  for($i=0; $i < $proparent['product_total'];$i++) { ?>
                                        <div class="list-group">
                                            <a href="<?php echo $proparent[$i]['href'];?>" class="col-xs-12">
                                                <span class="col-xs-2 text-primary"><?php echo $proparent[$i]['name'];?></span>
                                                <span class="col-xs-4 text-info"><strong><?php echo $proparent[$i]['description'];?></strong></span>
                                                <?php if ($proparent[$i]['quantity'] == 1){ ?>
                                                <span class="col-xs-3 text-danger"><strong><?php echo $text_ourlastroom; ?></strong></span>
                                                <?php } else { if ($proparent[$i]['quantity'] <= 5) { ?>
                                                <span class="col-xs-3 text-warning"><strong><?php echo $text_ourlast; ?> <?php echo $proparent[$i]['quantity'];?> <?php echo $text_rooms; ?> </strong></span>
                                                <?php } else { ?>
                                                <span class="col-xs-3 text-success"><strong><?php echo $text_available; ?></strong></span>
                                                <?php } ?>
                                                <?php } ?>
                                                <span class="col-xs-3 text-right">
                                                    <strong> 
                                                <?php if (isset($product_prices)) { ?>
                                                <?php foreach ($product_prices as $product_price) { ?>
                                                <?php if ($proparent[$i]['product_id'] == $product_price['product_id']) { ?>
                                                <?php if (!empty($product_price['product_price_value'])){ $price_cost = $product_price['product_price_value'];} ?>
                                                <?php } else { ?>
                                                <?php $cost = ''; ?>
                                                <?php } ?>
                                                <?php } ?>
                                                <?php if(isset($price_cost)) { echo $price_cost;}else{ echo $cost;} ?>
                                                <?php $price_cost = ''; ?>
                                                <?php } ?>
                                                    </strong>
                                                </span>
                                            </a> 
                                        </div>
                                        <?php ; } ?>
                                    </div>
                                    <?php } ?>
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
<script type="text/javascript">
    <!--
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
    -->
</script>
<?php echo $footer; ?> 