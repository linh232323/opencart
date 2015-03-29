<div id="search_home" class="jumbotron">
    <div class="form-group required">
        <label class="control-label" for="search"><?php echo $text_labelname; ?></label>
        <input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $text_labelname; ?>" class="form-control input-lg" />
        <div class="col-xs-6 input-group">
            <label class="control-label" for="input-option219"><?php echo $text_labeldate; ?></label>
            <div class="input-group date">
                <input type="text" name="date" value="" data-date-format="YYYY-MM-DD" placeholder="<?php echo date('Y-m-d');?>" class="form-control" />
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button" id="date"><i class="fa fa-calendar"></i></button>
                </span>
            </div>
        </div>
        <div class="col-xs-6 input-group">
            <label class="control-label" for="input-option217"><?php echo $text_labelguest; ?></label>
            <select name="adults" class="form-control ">
                <option value="">--- Please Select ---</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="2">3</option>
            </select>
        </div>
        <br />
        <div class="col-xs-12 input-group">
            <div class="form-group">
                <button type="button" class="btn btn-primary btn-lg btn-block" id="submit">Search</button>
            </div>
        </div>
    </div>
</div>
