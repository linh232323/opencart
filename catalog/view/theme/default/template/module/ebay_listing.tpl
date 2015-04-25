<h3><?php echo $heading_title; ?></h3>
<div class="row room-layout">
  <?php foreach ($rooms as $room) { ?>
  <div class="col-lg-3 col-md-3s col-sm-6 col-xs-12">
    <div class="room-thumb transition">
      <div class="image"><a target="_blank" href="<?php echo $room['href']; ?>"><img src="<?php echo $room['thumb']; ?>" alt="<?php echo $room['name']; ?>" title="<?php echo $room['name']; ?>" class="img-responsive" /></a></div>
      <div class="caption">
        <p><a href="<?php echo $room['href']; ?>"><?php echo $room['name']; ?></a></p>
        <p class="price"><?php echo $room['price']; ?></p>
      </div>
    </div>
  </div>
  <?php } ?>
  <img src="<?php echo $tracking_pixel; ?>" height="0" width="0" />
</div>