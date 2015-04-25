<div id="search_hotel" class="search-panel jumbotron">
    <div class=" form-group">
        <form method="POST" action="index.php?route=product/search" >
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                    <label class="control-label" for="search"><?php echo $text_labelname; ?></label>
                    <input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $text_labelname; ?>" class="form-control input-group" />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-9 col-sm-9 col-xs-12 date" id="check_in">
                    <label class="control-label" for="input-option"><?php echo $text_labeldate_in; ?></label>
                    <div class=" input-group">
                        <input type="text" name="check_in" value= "<?php echo date('D M d Y');?>" readonly="readonly" data-date-format="ddd MMM DD YYYY" class="form-control input_check_in"/>
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" id="date"><i class="fa fa-calendar"></i></button>
                        </span>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12" id="night">
                    <label class="control-label" for="input-option"><?php echo $text_labelnight; ?></label>
                    <div class="" id="night">
                        <select name="night" class="form-control">
                            <?php for ($i=1;$i<=30;$i++) { ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-5 col-md-8 col-sm-8 col-xs-12 date1" id="check_out">
                    <label class="control-label" for="input-option"><?php echo $text_labeldate_out; ?></label>
                    <div class="input-group">
                        <input type="text" name="check_out" value="<?php echo date('D M d Y');?>" data-date-format="ddd MMM DD YYYY" readonly="readonly" class="form-control input_check_out" />
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" id="date"><i class="fa fa-calendar"></i></button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4" id="guest">
                    <label class="control-label" for="input-option217"><?php echo $text_labelguest; ?></label>
                    <select name="guest" id = "adults" class="form-control">
                        <option value="1"><?php echo $text_1adult?></option>
                        <option value="2" selected="selected"><?php echo $text_2adults?></option>
                        <option value=""><?php echo $text_more?></option>
                    </select>
                </div>
                <div class="col-lg-8" id="hide">
                    <span class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        <label class="control-label"><?php echo $text_labelroom; ?></label>
                        <select name="room" class="form-control ">
                            <?php for ($i=1;$i<10;$i++) { ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </span>
                    <span class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        <label class="control-label"><?php echo $text_labeladults; ?></label>
                        <select name="adults"class="form-control ">
                            <?php for ($i=1;$i<22;$i++) { ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </span>
                    <span class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        <label class="control-label"><?php echo $text_labelchildren; ?></label>
                        <select name="children"class="form-control ">
                            <?php for ($i=0;$i<4;$i++) { ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" id="submit" ><strong><?php echo $text_search; ?></strong></button>
                </div>
            </div>
        </form>
    </div>
</div>