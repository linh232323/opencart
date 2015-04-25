<h3><?php echo $heading_title; ?></h3>
<div class="row">
  <?php foreach ($rooms as $room) { ?>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="room-thumb transition">
      <div class="image"><a href="<?php echo $room['href']; ?>"><img src="<?php echo $room['thumb']; ?>" alt="<?php echo $room['name']; ?>" title="<?php echo $room['name']; ?>" class="img-responsive" /></a></div>
      <div class="caption">
        <h4><a href="<?php echo $room['href']; ?>"><?php echo $room['name']; ?></a></h4>
        <p><?php echo $room['description']; ?></p>
        <?php if ($room['rating']) { ?>
        <div class="rating">
          <?php for ($i = 1; $i <= 5; $i++) { ?>
          <?php if ($room['rating'] < $i) { ?>
          <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
          <?php } else { ?>
          <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
          <?php } ?>
          <?php } ?>
        </div>
        <?php } ?>
        <?php if ($room['price']) { ?>
        <p class="price">
          <?php if (!$room['special']) { ?>
          <?php echo $room['price']; ?>
          <?php } else { ?>
          <span class="price-new"><?php echo $room['special']; ?></span> <span class="price-old"><?php echo $room['price']; ?></span>
          <?php } ?>
          <?php if ($room['tax']) { ?>
          <span class="price-tax"><?php echo $text_tax; ?> <?php echo $room['tax']; ?></span>
          <?php } ?>
        </p>
        <?php } ?>
      </div>
      <div class="button-group">
        <button type="button" onclick="cart.add('<?php echo $room['room_id']; ?>');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $room['room_id']; ?>');"><i class="fa fa-heart"></i></button>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $room['room_id']; ?>');"><i class="fa fa-exchange"></i></button>
      </div>
    </div>
  </div>
  <?php } ?>
</div>
