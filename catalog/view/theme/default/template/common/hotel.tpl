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
                            <div class="search-panel-wrapper col-lg-12 col-md-12 col-sm-12 col-xs-12"><?php echo $search_hotel; ?></div>
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
</div>
<script type="text/javascript">
    $(function () {
        var now = new Date();
        var max = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 29);
        $('.date').datetimepicker({
            pickTime: false, minDate: moment()
        });
        $('.date1').datetimepicker({
            pickTime: false, minDate: moment(), maxDate: max
        });
        $(".date").on("dp.change", function (e) {
            var datepick = (e.date);
            var date = new Date(datepick);
            var outpick = new Date(date.getFullYear(), date.getMonth(), date.getDate() + 1);
            $('.date1').data("DateTimePicker").setMinDate(outpick);
            var checkin = (e.date);
            var datein = new Date(checkin);
            var out = new Date(datein.getFullYear(), datein.getMonth(), datein.getDate() + 30);
            $('.date1').data("DateTimePicker").setMaxDate(out);
        });
    });
</script>
<?php echo $footer; ?>