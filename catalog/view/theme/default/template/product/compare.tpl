<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <?php if ($rooms) { ?>
      <table class="table table-bordered">
        <thead>
          <tr>
            <td colspan="<?php echo count($rooms) + 1; ?>"><strong><?php echo $text_room; ?></strong></td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php echo $text_name; ?></td>
            <?php foreach ($rooms as $room) { ?>
            <td><a href="<?php echo $rooms[$room['room_id']]['href']; ?>"><strong><?php echo $rooms[$room['room_id']]['name']; ?></strong></a></td>
            <?php } ?>
          </tr>
          <tr>
            <td><?php echo $text_image; ?></td>
            <?php foreach ($rooms as $room) { ?>
            <td class="text-center"><?php if ($rooms[$room['room_id']]['thumb']) { ?>
              <img src="<?php echo $rooms[$room['room_id']]['thumb']; ?>" alt="<?php echo $rooms[$room['room_id']]['name']; ?>" title="<?php echo $rooms[$room['room_id']]['name']; ?>" class="img-thumbnail" />
              <?php } ?></td>
            <?php } ?>
          </tr>
          <tr>
            <td><?php echo $text_price; ?></td>
            <?php foreach ($rooms as $room) { ?>
            <td><?php if ($rooms[$room['room_id']]['price']) { ?>
              <?php if (!$rooms[$room['room_id']]['special']) { ?>
              <?php echo $rooms[$room['room_id']]['price']; ?>
              <?php } else { ?>
              <span class="price-old"><?php echo $rooms[$room['room_id']]['price']; ?> </span> <span class="price-new"> <?php echo $rooms[$room['room_id']]['special']; ?> </span>
              <?php } ?>
              <?php } ?></td>
            <?php } ?>
          </tr>
          <tr>
            <td><?php echo $text_model; ?></td>
            <?php foreach ($rooms as $room) { ?>
            <td><?php echo $rooms[$room['room_id']]['model']; ?></td>
            <?php } ?>
          </tr>
          <tr>
            <td><?php echo $text_manufacturer; ?></td>
            <?php foreach ($rooms as $room) { ?>
            <td><?php echo $rooms[$room['room_id']]['manufacturer']; ?></td>
            <?php } ?>
          </tr>
          <tr>
            <td><?php echo $text_availability; ?></td>
            <?php foreach ($rooms as $room) { ?>
            <td><?php echo $rooms[$room['room_id']]['availability']; ?></td>
            <?php } ?>
          </tr>
          <?php if ($review_status) { ?>
          <tr>
            <td><?php echo $text_rating; ?></td>
            <?php foreach ($rooms as $room) { ?>
            <td class="rating"><?php for ($i = 1; $i <= 5; $i++) { ?>
              <?php if ($rooms[$room['room_id']]['rating'] < $i) { ?>
              <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
              <?php } else { ?>
              <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
              <?php } ?>
              <?php } ?>
              <br />
              <?php echo $rooms[$room['room_id']]['reviews']; ?></td>
            <?php } ?>
          </tr>
          <?php } ?>
          <tr>
            <td><?php echo $text_summary; ?></td>
            <?php foreach ($rooms as $room) { ?>
            <td class="description"><?php echo $rooms[$room['room_id']]['description']; ?></td>
            <?php } ?>
          </tr>
          <tr>
            <td><?php echo $text_weight; ?></td>
            <?php foreach ($rooms as $room) { ?>
            <td><?php echo $rooms[$room['room_id']]['weight']; ?></td>
            <?php } ?>
          </tr>
          <tr>
            <td><?php echo $text_dimension; ?></td>
            <?php foreach ($rooms as $room) { ?>
            <td><?php echo $rooms[$room['room_id']]['length']; ?> x <?php echo $rooms[$room['room_id']]['width']; ?> x <?php echo $rooms[$room['room_id']]['height']; ?></td>
            <?php } ?>
          </tr>
        </tbody>
        <?php foreach ($attribute_groups as $attribute_group) { ?>
        <thead>
          <tr>
            <td colspan="<?php echo count($rooms) + 1; ?>"><strong><?php echo $attribute_group['name']; ?></strong></td>
          </tr>
        </thead>
        <?php foreach ($attribute_group['attribute'] as $key => $attribute) { ?>
        <tbody>
          <tr>
            <td><?php echo $attribute['name']; ?></td>
            <?php foreach ($rooms as $room) { ?>
            <?php if (isset($rooms[$room['room_id']]['attribute'][$key])) { ?>
            <td><?php echo $rooms[$room['room_id']]['attribute'][$key]; ?></td>
            <?php } else { ?>
            <td></td>
            <?php } ?>
            <?php } ?>
          </tr>
        </tbody>
        <?php } ?>
        <?php } ?>
        <tr>
          <td></td>
          <?php foreach ($rooms as $room) { ?>
          <td><input type="button" value="<?php echo $button_cart; ?>" class="btn btn-primary btn-block" onclick="cart.add('<?php echo $room['room_id']; ?>');" />
            <a href="<?php echo $room['remove']; ?>" class="btn btn-danger btn-block"><?php echo $button_remove; ?></a></td>
          <?php } ?>
        </tr>
      </table>
      <?php } else { ?>
      <p><?php echo $text_empty; ?></p>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-default"><?php echo $button_continue; ?></a></div>
      </div>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>