<?php echo $header; ?>

<div class="container">
    <div class="row">
        <div class="container">
            <div class="center-block center">
                <div class="text-center text-color-white">
                    <h1 class="text-color-white"><?php echo $text_title;?></h1>
                    <h3 class="text-color-white"><?php echo $text_description;?></h3>
                </div>
                <div class="row">
                    <search>
                        <div class="row">
                            <div class="search-panel-wrapper col-md-12"><?php echo $search_hotel; ?></div>
                        </div>
                    </search>
                </div>
            </div>
        </div> 
        <br/>
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
<script type="text/javascript">
    <!--
$('.date').datetimepicker({
        pickTime: false
    });
    $('.datetime').datetimepicker({
        pickDate: true,
        pickTime: true
    });
    $('.time').datetimepicker({
        pickDate: false
    });
    -->
</script>
<?php echo $footer; ?>