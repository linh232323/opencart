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
      <h2><?php echo $heading_title; ?></h2>
      <?php if ($rooms) { ?>
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <td class="text-center"><?php echo $column_image; ?></td>
            <td class="text-left"><?php echo $column_name; ?></td>
            <td class="text-left"><?php echo $column_model; ?></td>
            <td class="text-right"><?php echo $column_stock; ?></td>
            <td class="text-right"><?php echo $column_price; ?></td>
            <td class="text-right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rooms as $room) { ?>
          <tr>
            <td class="text-center"><?php if ($room['thumb']) { ?>
              <a href="<?php echo $room['href']; ?>"><img src="<?php echo $room['thumb']; ?>" alt="<?php echo $room['name']; ?>" title="<?php echo $room['name']; ?>" /></a>
              <?php } ?></td>
            <td class="text-left"><a href="<?php echo $room['href']; ?>"><?php echo $room['name']; ?></a></td>
            <td class="text-left"><?php echo $room['model']; ?></td>
            <td class="text-right"><?php echo $room['stock']; ?></td>
            <td class="text-right"><?php if ($room['price']) { ?>
              <div class="price">
                <?php if (!$room['special']) { ?>
                <?php echo $room['price']; ?>
                <?php } else { ?>
                <b><?php echo $room['special']; ?></b> <s><?php echo $room['price']; ?></s>
                <?php } ?>
              </div>
              <?php } ?></td>
            <td class="text-right"><button type="button" onclick="cart.add('<?php echo $room['room_id']; ?>');" data-toggle="tooltip" title="<?php echo $button_cart; ?>" class="btn btn-primary"><i class="fa fa-shopping-cart"></i></button>
              <a href="<?php echo $room['remove']; ?>" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-times"></i></a></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <?php } else { ?>
      <p><?php echo $text_empty; ?></p>
      <?php } ?>
      <div class="buttons clearfix">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?> 