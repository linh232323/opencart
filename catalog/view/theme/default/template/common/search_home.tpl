<form action ="index?route=common/home" method="get">
    <div class="form-group required">
        <input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $text_search; ?>" class="form-control input-lg" />

    </div>

    <div class="form-group required">
        <label class="control-label" for="input-option219">Date</label>
        <div class="input-group date">
            <input type="text" name="option[219]" value="" data-date-format="YYYY-MM-DD" id="input-option219" class="form-control" />
            <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
            </span></div>
    </div>

    <div class="form-group required">
        <label class="control-label" for="input-option217">Select</label>
        <select name="option[217]" id="input-option217" class="form-control">
            <option value=""></option>

        </select>
    </div>

    <div class="input-group-btn">
        <button type="submit" class="btn btn-primary btn-lg btn-block">Search</button>
    </div>

</form>
