<?php if ($hotelreviews) { ?>
<?php foreach ($hotelreviews as $hotelreview) { ?>
<table class="table table-striped table-bordered">
    <tr>
        <td style="width: 50%;" class="text-primary"><strong><?php echo $hotelreview['author']; ?></strong></td>
        <td class="text-right"><?php echo $hotelreview['date_added']; ?></td>
    </tr>
    <tr class="rating">
        <td colspan="2"><p><?php echo $hotelreview['text']; ?></p>
            <?php for ($i = 1; $i <= 10; $i++) { ?>
            <?php if ($hotelreview['rating'] < $i) { ?>
            <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
            <?php } else { ?>
            <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
            <?php } ?>
            <?php } ?>
        </td>
    </tr>
</table>
<?php } ?>
<div class="text-right"><?php echo $pagination; ?></div>
<?php } else { ?>
<p><?php echo $text_no_hotelreviews; ?></p>
<?php } ?>
