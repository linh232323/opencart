<?php if (!isset($redirect)) { ?>
<div class="table-responsive">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <td class="text-left"><?php echo $column_name; ?></td>
        <td class="text-left"><?php echo $column_model; ?></td>
        <td class="text-left"><?php echo $column_check_in; ?></td>
        <td class="text-left"><?php echo $column_check_out; ?></td>
        <td class="text-right"><?php echo $column_night; ?></td>
        <td class="text-right"><?php echo $column_quantity; ?></td>
        <td class="text-right"><?php echo $column_price; ?></td>
        <td class="text-right"><?php echo $column_total; ?></td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($rooms as $room) { ?>
      <tr>
        <td class="text-left"><a href="<?php echo $room['href']; ?>"><?php echo $room['name']; ?></a>
          <?php foreach ($room['option'] as $option) { ?>
          <br />
          &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
          <?php } ?>
          <?php if($room['recurring']) { ?>
          <br />
          <span class="label label-info"><?php echo $text_recurring_item; ?></span> <small><?php echo $room['recurring']; ?></small>
          <?php } ?></td>
        <td class="text-left"><?php echo $room['model']; ?></td>
        <td class="text-left"><?php echo $room['check_in']; ?></td>
        <td class="text-left"><?php echo $room['check_out']; ?></td>
        <td class="text-right"><?php echo $room['night']; ?></td>
        <td class="text-right"><?php echo $room['quantity']; ?></td>
        <td class="text-right"><?php echo $room['price']; ?></td>
        <td class="text-right"><?php echo $room['total']; ?></td>
      </tr>
      <?php } ?>
      <?php foreach ($vouchers as $voucher) { ?>
      <tr>
        <td class="text-left"><?php echo $voucher['description']; ?></td>
        <td class="text-left"></td>
        <td class="text-right">1</td>
        <td class="text-right"><?php echo $voucher['amount']; ?></td>
        <td class="text-right"><?php echo $voucher['amount']; ?></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php foreach ($totals as $total) { ?>
      <tr>
        <td colspan="7" class="text-right"><strong><?php echo $total['title']; ?>:</strong></td>
        <td class="text-right"><?php echo $total['text']; ?></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
</div>
<?php echo $payment; ?>
<?php } else { ?>
<script type="text/javascript"><!--
location = '<?php echo $redirect; ?>';
//--></script>
<?php } ?>
