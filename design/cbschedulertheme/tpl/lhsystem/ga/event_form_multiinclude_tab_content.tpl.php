<div role="tabpanel" class="tab-pane <?php if ($tab == 'cbscheduler') : ?>active<?php endif;?>" id="cbscheduler">
    <label title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/etracking', 'Track this event')?> [CBValidationFailed]" class="fw-bold"><input type="checkbox" value="on" <?php if (isset($ga_options['CBValidationFailed_on']) && $ga_options['CBValidationFailed_on'] == 1) : ?>checked="checked"<?php endif;?> name="CBValidationFailed_on"> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/etracking', 'Validation failed')?></label>
    <div class="row">
        <div class="col-4">
            <div class="form-group">
                <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/etracking', 'Category')?> [eventCategory]*</label>
                <input type="text" class="form-control form-control-sm" name="CBValidationFailed_category" value="<?php isset($ga_options['CBValidationFailed_category']) ? print htmlspecialchars($ga_options['CBValidationFailed_category']) : print 'CBScheduler'?>" />
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/etracking', 'Event action')?> [eventAction]*</label>
                <input type="text" class="form-control form-control-sm" name="CBValidationFailed_action" value="<?php isset($ga_options['CBValidationFailed_action']) ? print htmlspecialchars($ga_options['CBValidationFailed_action']) : print 'CBValidationFailed'?>" />
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/etracking', 'Event label')?> [eventLabel]</label>
                <input type="text" class="form-control form-control-sm" name="CBValidationFailed_label" value="<?php isset($ga_options['CBValidationFailed_label']) ? print htmlspecialchars($ga_options['CBValidationFailed_label']) : ''?>" />
            </div>
        </div>
    </div>

    <label title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/etracking', 'Track this event')?> [CBSCheduled]" class="fw-bold"><input type="checkbox" value="on" <?php if (isset($ga_options['CBSCheduled_on']) && $ga_options['CBSCheduled_on'] == 1) : ?>checked="checked"<?php endif;?> name="CBSCheduled_on"> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/etracking', 'Callback scheduled')?></label>
    <div class="row">
        <div class="col-4">
            <div class="form-group">
                <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/etracking', 'Category')?> [eventCategory]*</label>
                <input type="text" class="form-control form-control-sm" name="CBSCheduled_category" value="<?php isset($ga_options['CBSCheduled_category']) ? print htmlspecialchars($ga_options['CBSCheduled_category']) : print 'CBScheduler'?>" />
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/etracking', 'Event action')?> [eventAction]*</label>
                <input type="text" class="form-control form-control-sm" name="CBSCheduled_action" value="<?php isset($ga_options['CBSCheduled_action']) ? print htmlspecialchars($ga_options['CBSCheduled_action']) : print 'CBSCheduled'?>" />
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/etracking', 'Event label')?> [eventLabel]</label>
                <input type="text" class="form-control form-control-sm" name="CBSCheduled_label" value="<?php isset($ga_options['CBSCheduled_label']) ? print htmlspecialchars($ga_options['CBSCheduled_label']) : ''?>" />
            </div>
        </div>
    </div>
</div>