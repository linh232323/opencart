<?php echo $header; ?>
<div class="container">
    <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
    </ul>
    <div class="row">
        <div id="content" class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><?php echo $content_top; ?>
            <div class="col-lg-3  col-md-3 col-sm-3 col-xs-12">
                <div class="panel-wrapper">
                    <div class="box box-title">
                        <h4 class="title"><strong> <?php echo $title; ?></strong></h4>
                    </div>
                    <div id="form-search"  class="box box-content form-group">
                        <form method="POST" action="index.php?route=product/search">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label class="control-label" for="input-search"><?php echo $label_search; ?></label>
                                    <input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $text_keyword; ?>" id="input-search" class="form-control" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 date" id="check_in">
                                    <label class="control-label" for="input-option"><?php echo $text_labeldate_in; ?></label>
                                    <div class=" input-group">
                                        <input type="text" name="check_in" value= "<?php echo $_SESSION['check_in']; ?>" readonly="readonly" data-date-format="ddd MMM DD YYYY" class="form-control input_check_in"/>
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" id="date"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12" id="night">
                                    <label class="control-label" for="input-option"><?php echo $text_label_night; ?></label>
                                    <div class="" id="night">
                                        <select name="night" class="form-control">
                                            <?php for ($i=1;$i<=30;$i++) { ?>
                                            <option value="<?php echo $i; ?>" <?php if ($_SESSION['night'] == $i){ echo "selected";}?> ><?php echo $i; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 date1" id="check_out">
                                    <label class="control-label" for="input-option"><?php echo $text_labeldate_out; ?></label>
                                    <div class="input-group">
                                        <input type="text" name="check_out" value="<?php echo $_SESSION['check_out']; ?>" data-date-format="ddd MMM DD YYYY" readonly="readonly" class="form-control input_check_out" />
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" id="date"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8 form-group" id="guest">
                                    <label class="control-label" for="input-option217"><?php echo $text_label_guest; ?></label>
                                    <select name="guest" id = "adults" class="form-control">
                                        <option value="1" <?php if ($_SESSION['guest'] == 1){ echo "selected";}?>><?php echo $text_1adult?></option>
                                        <option value="2"<?php if ($_SESSION['guest'] == 2){ echo "selected";}?>><?php echo $text_2adults?></option>
                                        <option value="" <?php if ($_SESSION['guest'] == ""){ echo "selected";}?>><?php echo $text_more?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 form-group" id="hide">
                                    <span class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <label class="control-label"><?php echo $text_label_room; ?></label>
                                        <select name="room" class="form-control ">
                                            <?php for ($i=1;$i<10;$i++) { ?>
                                            <option value="<?php echo $i; ?>" <?php if ($_SESSION['room'] == $i){ echo "selected";}?>><?php echo $i; ?></option>
                                            <?php } ?>
                                        </select>
                                    </span>
                                    <span class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <label class="control-label"><?php echo $text_label_adults; ?></label>
                                        <select name="adults"class="form-control ">
                                            <?php for ($i=1;$i<22;$i++) { ?>
                                            <option value="<?php echo $i; ?>" <?php if ($_SESSION['adults'] == $i){ echo "selected";}?>> <?php echo $i; ?></option>
                                            <?php } ?>
                                        </select>
                                    </span>
                                    <span class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
                                        <label class="control-label"><?php echo $text_label_children; ?></label>
                                        <select name="children"class="form-control ">
                                            <?php for ($i=0;$i<4;$i++) { ?>
                                            <option value="<?php echo $i; ?>" <?php if ($_SESSION['children'] == $i){ echo "selected";}?>><?php echo $i; ?></option>
                                            <?php } ?>
                                        </select>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit" id="button-search" class="btn btn-primary btn-block" ><?php echo $button_search; ?></button>
                                </div>                
                            </div>                
                        </form>
                    </div>
                </div>
            </div>
            <div id="search-result" class="row col-lg-9 col-md-9 col-sm-9 col-xs-12">
                <h3 class="row">
                    <div class="col-lg-12">
                        <?php echo $text_found; ?><strong class= "text-primary"><?php if(isset($total))echo $total; ?></strong><?php echo $text_hotelin; ?><strong class= "text-primary"><?php echo $title_search; ?></strong>. <?php if(isset($results))echo $results; ?>
                        <div class="pull-right">
                            <button id="button-maps" class="btn btn-success" onclick="toggleContent()"><i class="glyphicon glyphicon-map-marker"></i>Maps</button>
                        </div>
                        <div class="search-panel-wrapper col-lg-12" id="maps" style="position: absolute;">
                            <span id="map" class="col-xs-12" style="height: 600px; z-index: 1000;"></span>
                        </div>
                    </div>
                </h3>
                <?php if ($proparents) { ?>
                <div class="row">
                    <div class="col-sm-2 hidden-xs">
                        <div class="btn-group">
                            <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_list; ?>"><i class="fa fa-th-list"></i></button>
                            <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_grid; ?>"><i class="fa fa-th"></i></button>
                        </div>
                    </div>
                    <div class="col-sm-3 text-right">
                        <label class="control-label" for="input-sort"><?php echo $text_sort; ?></label>
                    </div>
                    <div class="col-sm-3 text-right">
                        <select id="input-sort" class="form-control col-sm-3" onchange="location = this.value;">
                            <?php foreach ($sorts as $sorts) { ?>
                            <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
                            <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
                            <?php } else { ?>
                            <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
                            <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-2 text-right">
                        <label class="control-label" for="input-limit"><?php echo $text_limit; ?></label>
                    </div>
                    <div class="col-sm-2 text-right">
                        <select id="input-limit" class="form-control" onchange="location = this.value;">
                            <?php foreach ($limits as $limits) { ?>
                            <?php if ($limits['value'] == $limit) { ?>
                            <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
                            <?php } else { ?>
                            <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
                            <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <?php foreach ($proparents as $proparent) { ?>
                    <?php if (isset($proparent[0])) { ?>
                    <div id = "product" class="product-layout product-list col-xs-12">
                        <div class="product-thumb">
                            <div class="image"><a href="<?php echo $proparent['hrefp']; ?>"><img src="<?php echo $proparent['thumbp']; ?>" alt="<?php echo $proparent['namep']; ?>" title="<?php echo $proparent['namep']; ?>" class="img-responsive" /></a></div>
                            <div class="caption">
                                <h4 class="col-lg-9 col-md-9 col-sm-9 col-xs-12"><a href="<?php echo $proparent['hrefp']; ?>"><?php echo $proparent['namep']; ?></a><span class="rating">
                                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                                        <?php if ($proparent['star'] < $i) { ?>
                                        <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                                        <?php } else { ?>
                                        <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                                        <?php } ?>
                                        <?php } ?>
                                    </span></h4>
                                <div class="col-xs-3 pull-right text-right text-primary">
                                    <h4 class="text-primary">
                                        <?php if ($proparent['ratingp']) { ?>
                                        <?php
                                        switch ($proparent['ratingp']) {
                                        case "10":
                                        $text_rating = $text_rate_superb;
                                        break;
                                        case "9":
                                        $text_rating = $text_rate_superb;
                                        break;
                                        case "8":
                                        $text_rating = $text_rate_fantastic;
                                        break;
                                        case "7":
                                        $text_rating = $text_rate_verygood;
                                        break;
                                        case "6":
                                        $text_rating = $text_rate_good;
                                        break;
                                        case "0":
                                        $text_rating = '';
                                        $rating = '';
                                        break;
                                        default:
                                        $text_rating = $text_rate_bad;
                                        }
                                        ?>
                                        <?php echo $text_rating.' '.$proparent['ratingp']; ?>
                                        <?php } ?>
                                    </h4>
                                    <div>
                                        <?php echo $proparent['pareviews']; ?>
                                    </div>
                                </div>
                                <div class="col-xs-9"><strong><?php if ($proparent['wifi'] == 1) { ?>
                                        <?php echo $text_freewifi; ?> <img src="catalog/view/theme/default/image/icon_aniwifi.gif"/>
                                        <?php } else { ?>
                                        <?php echo $text_nowifi; ?> <img src="catalog/view/theme/default/image/icon_nowifi.png"/>
                                        <?php } ?>
                                    </strong></div>
                                <div class="col-xs-9"><?php echo $proparent['descriptionp']; ?></div>
                                <div class="pull-bottom-right">
                                    <a href="<?php echo $proparent['hrefp']; ?>" ><button type="button" class= "btn btn-primary btn-block "><i class="fa fa-shopping-cart"></i><strong> <?php echo $text_book; ?> </strong></button></a>
                                </div>
                            </div>
                            <div class= "col-xs-12" >
                                <?php if (isset($proparent[0])) { ?>
                                <div class="table table-responsive table-hover table-striped">
                                    <?php  for($i=0; $i < $proparent['product_total'];$i++) { ?>
                                    <div class="list-group">
                                        <a href="<?php echo $proparent[$i]['href'];?>" class="col-xs-12">
                                            <span class="col-lg-2 col-xs-12 text-primary"><?php echo $proparent[$i]['name'];?></span>
                                            <span class="col-lg-4 col-xs-12 text-info"><strong><?php echo $proparent[$i]['description'];?></strong></span>
                                            <?php if ($proparent[$i]['quantity'] == 1){ ?>
                                            <span class="col-lg-3 col-xs-12 text-danger"><strong><?php echo $text_ourlastroom; ?></strong></span>
                                            <?php } else { if ($proparent[$i]['quantity'] <= 5) { ?>
                                            <span class="col-lg-3 col-xs-12 text-warning"><strong><?php echo $text_ourlast; ?> <?php echo $proparent[$i]['quantity'];?> <?php echo $text_rooms; ?> </strong></span>
                                            <?php } else { ?>
                                            <span class="col-lg-3 col-xs-12 text-success"><strong><?php echo $text_available; ?></strong></span>
                                            <?php } ?>
                                            <?php } ?>
                                            <span class="col-lg-3 col-xs-12 text-right">
                                                <strong> 
                                                    <?php if (isset($product_prices)) { ?>
                                                    <?php foreach ($product_prices as $product_price) { ?>
                                                    <?php if ($proparent[$i]['product_id'] == $product_price['product_id']) { ?>
                                                    <?php if (!empty($product_price['product_price_value'])){ $price_cost = $product_price['product_price_value'];} ?>
                                                    <?php } else { ?>
                                                    <?php $cost = ''; ?>
                                                    <?php } ?>
                                                    <?php } ?>
                                                    <?php if(isset($price_cost)) { echo $price_cost;}else{ echo $cost;} ?>
                                                    <?php $price_cost = ''; ?>
                                                    <?php } ?>
                                                </strong>
                                            </span>
                                        </a> 
                                    </div>
                                    <?php ; } ?>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
                    <div class="col-sm-6 text-right"><?php echo $results; ?></div>
                </div>
                <?php } else { ?>
                <p><?php echo $text_empty; ?></p>
                <?php } ?>
            </div>
            <?php echo $content_bottom; ?></div>
    </div>
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
<script type="text/javascript">
            var locations = [
                <?php foreach ($maps as $map) { ?>
                    ["<?php echo $map['namep']; ?>", <?php echo $map['maps_apil']; ?> , <?php echo $map['maps_apir']; ?> ],
            <?php } ?>
            ];
            var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13,
                    center: new google.maps.LatLng( <?php echo $map['maps_apil']; ?> , <?php echo $map['maps_apir']; ?> ),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            var infowindow = new google.maps.InfoWindow();
            var marker, i;
            for (i = 0; i < locations.length; i++) {
    marker = new google.maps.Marker({
    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map
    });
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
            infowindow.setContent(locations[i][0]);
                    infowindow.open(map, marker);
            }
            })(marker, i));
    }
</script>
<script type="text/javascript">
    $("#maps").animate({ left: "-200%" }, 0);
            function toggleContent() {
            // Get the DOM reference
            var contentId = document.getElementById("maps");
                    // Toggle 
                    contentId.style.left == "-200%" ? $("#maps").animate({ left: "0px" }, 1200) :
                    $("#maps").animate({ left: "-200%" }, 1200);
            }
</script>
<script type="text/javascript">
    $(document).ready(
            function(){
            $("#search-change").click(
                    function(){
                    $("#change").toggle();
                    }
            );
            }
    );
</script>
<?php echo $footer; ?> 