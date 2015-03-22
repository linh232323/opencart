<?php echo $header; ?>
<div class="container">
    <div class="row">
        <div class="container col-md-6 center-block">
            <div class="text-center">
                <h1>I go to [ Genui ]</h1>
                <h2>625,000+ hotels, villas, apartments and more...</h2>
            </div>
            <div class="row">
                <div class=" col-md-12"><?php echo $search; ?></div>
            </div>
        </div> 
        <?php echo $column_left; ?>
        <?php if ($column_left && $column_right) { ?>
        <?php $class = 'col-sm-6'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
        <?php $class = 'col-sm-9'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-12'; ?>
        <?php } ?>
        <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?><?php echo $content_bottom; ?></div>
        <?php echo $column_right; ?></div>
</div>
<div class ="logopay">
    <div class="container">
        <div class="row">
            <img src="catalog/view/theme/default/image/logopayment/payment-visa.png"/>
            <img src="catalog/view/theme/default/image/logopayment/payment-paypal.png"/>
            <img src="catalog/view/theme/default/image/logopayment/payment-master-card.png"/>
            <img src="catalog/view/theme/default/image/logopayment/payment-jcb.png"/>
            <img src="catalog/view/theme/default/image/logopayment/payment-american-express.png"/>
        </div>
    </div>
</div>
<?php echo $footer; ?>