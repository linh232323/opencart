<h3><?php echo $heading_title; ?></h3>
<div class="row">
  <?php foreach ($categorys as $category) { ?>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="category-thumb transition">
      <div class="image"><a href="<?php echo $category['href']; ?>"><img src="<?php echo $category['thumb']; ?>" alt="<?php echo $category['name']; ?>" title="<?php echo $category['name']; ?>" class="img-featured" style="max-height: <?php echo $maxheight;?>"/></a></div>
      <div class="caption">
          <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a><span class='pull-right'><?php echo $category['child']; ?> <?php echo $text_hotel;?></span>
      </div>
    </div>
  </div>
  <?php } ?>
</div>
