
<?php if ($pareviews) { ?>
<?php foreach ($pareviews as $pareview) { ?>
<table class="table table-striped table-bordered">
  <tr>
      <td style="width: 50%;" class="text-primary"><strong><?php echo $pareview['author']; ?></strong></td>
    <td class="text-right"><?php echo $pareview['date_added']; ?></td>
  </tr>
  <tr class="rating">
    <td colspan="2"><p><?php echo $pareview['text']; ?></p>
      <?php for ($i = 1; $i <= 5; $i++) { ?>
      <?php if ($pareview['rating'] < $i) { ?>
      <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
      <?php } else { ?>
      <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
      <?php } ?>
      <?php } ?></td>
  </tr>
</table>
<?php } ?>
<div class="text-right"><?php echo $pagination; ?></div>
<?php } else { ?>
<p><?php echo $text_no_pareviews; ?></p>
<?php } ?>
