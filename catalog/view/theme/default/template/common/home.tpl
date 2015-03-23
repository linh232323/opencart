<?php echo $header; ?>
<div class="container">
    <div class="row">
        <div class="container">
            <div class="center-block center">
                <div class="text-center">
                    <h1>I go to [ Genui ]</h1>
                    <h2>625,000+ hotels, villas, apartments and more...</h2>
                </div>
                <div class="row">
                    <div class=" col-md-12"><?php echo $search_home; ?></div>
                </div>
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

<?php echo $footer; ?>