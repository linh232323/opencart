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
            <h2><?php echo $heading_title; ?></h2>
            <?php if ($thumb || $description) { ?>

            <?php if ($thumb) { ?>
            <div class="row">
                <div class="col-md-8 col-md-offset-2"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" class="img-thumbnail" /></div>
            </div>
            <?php } ?>
            <?php if ($description) { ?>
            <div class="row">
                <div class="col-sm-10"><?php echo $description; ?></div>
            </div>
            <?php } ?>

            <hr>
            <?php } ?>
            <?php if ($categories) { ?>
            <h3><?php echo $text_refine; ?></h3>
            <?php if (count($categories) <= 10) { ?>
            <div class="row">
                <?php foreach ($categories as $category) { ?>
                <div class="product-layout product-list col-xs-12">
                    <div class="product-thumb">
                        <div class="image">
                            <a href="<?php echo $category['image']; ?>"><img src = "<?php echo $category['image']; ?>"/></a>
                        </div>
                        <div>
                            <div class="caption">
                                <h4><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></h4>
                                <p><?php echo $category['description']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php } else { ?>
            <div class="row">
                <?php foreach (array_chunk($categories, ceil(count($categories) / 4)) as $categories) { ?>
                <div class="col-sm-3">
                    <ul>
                        <?php foreach ($categories as $category) { ?>
                        <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
            <?php } ?>
            <?php if ($proparents) { ?>
            <p><a href="<?php echo $compare; ?>" id="compare-total"><?php echo $text_compare; ?></a></p>
            <div class="row">
                <div class="col-md-4">
                    <div class="btn-group hidden-xs">
                        <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_list; ?>"><i class="fa fa-th-list"></i></button>
                        <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_grid; ?>"><i class="fa fa-th"></i></button>
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
            <br />
            <div class="row">
                <?php foreach ($proparents as $proparent) { ?>
                <div class="product-layout product-list col-xs-12">
                    <div class="product-thumb">
                        <div class="image"><a href="<?php echo $proparent['hrefp']; ?>"><img src="<?php echo $proparent['thumbp']; ?>" alt="<?php echo $proparent['namep']; ?>" title="<?php echo $proparent['namep']; ?>" class="img-responsive" /></a></div>
                        <div>
                            <div class="caption">
                                <h4><a href="<?php echo $proparent['hrefp']; ?>"><?php echo $proparent['namep']; ?></a></h4>
                                <p><?php echo $proparent['descriptionp']; ?></p>
                                <?php if ($proparent['ratingp']) { ?>
                                <div class="rating">
                                    <?php for ($i = 1; $i <= 5; $i++) { ?>
                                    <?php if ($proparent['ratingp'] < $i) { ?>
                                    <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                                    <?php } else { ?>
                                    <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                                    <?php } ?>
                                    <?php } ?>
                                </div>
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
                            <div class="col-xs-6 pull-right">
                                <a href="<?php echo $proparent['hrefp']; ?>" ><button type="button" class = "btn btn-primary btn-lg btn-block "><i class="fa fa-shopping-cart"></i> Book </button></a>
                            </div>
                            <div class = "col-xs-12" >
                                <?php if ($proparent[0]) { ?>
                                <table class="table table-responsive table-hover table-striped">
                                    <?php  for($i=0; $i < $proparent['product_total'];$i++) { ?>
                                    <tr>
                                        <td><a href="<?php echo $proparent[$i]['href'];?>" ><?php echo $proparent[$i]['name'];?></a></td>
                                        <td class = "col-xs-6"><?php echo $proparent[$i]['description'];?></td>
                                        <?php if ($proparent[$i]['quantity'] == 1){ ?>

                                        <td class="text-danger"><strong>Our last room !!!</strong></td>
                                        <?php } else { if ($proparent[$i]['quantity'] <= 5) { ?>
                                        <td class="text-warning"><strong>Our last <?php echo $proparent[$i]['quantity'];?> room </strong></td>
                                        <?php } else { ?>
                                        <td class="text-success"><strong>Available</strong></td>
                                        <?php } ?>
                                        <?php } ?>

                                        <td><strong><?php echo $proparent[$i]['price'];?></strong></td>
                                    </tr>
                                    <?php ; } ?>
                                </table>
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
            <?php } ?>
            <?php if (!$categories && !$proparents) { ?>
            <p><?php echo $text_empty; ?></p>
            <div class="buttons">
                <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
            </div>
            <?php } ?>
            <?php echo $content_bottom; ?></div>
        <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>
