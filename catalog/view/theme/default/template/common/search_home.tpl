<form action ="index?route=common/home" method="get" class="jumbotron ">
    <div class="form-group required">
        <label class="control-label" for="search">Search a city, hotel, landmark or destination:</label>
        <input type="text" name="search" value="<?php echo $search; ?>" placeholder="City, hotel, landmark or destination" class="form-control input-lg" />

    </div>

    <div class="form-group required">
        <label class="control-label" for="input-option219">Check in:</label>
        
        <div class="input-group date">
            <input type="text" name="option[219]" value="" data-date-format="YYYY-MM-DD" placeholder="<?php echo date('Y-m-d');?>" id="input-option219" class="form-control" />
            <span class="input-group-btn">
                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
            </span></div>
    </div>

    <div class="form-group required col-xs-6">
        <label class="control-label" for="input-option217">Guests:</label>
        <select name="option[217]" id="input-option217" class="form-control ">
            <option value="">--- Please Select ---</option>
            <option value="1">1</option>
            <option value="2">2</option>

        </select>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary btn-lg btn-block">Search</button>
    </div>

</form>
