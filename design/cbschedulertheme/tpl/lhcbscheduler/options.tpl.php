<h1 class="attr-header"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Callback Scheduler Options');?></h1>

<form action="" method="post" ng-non-bindable>

    <?php include(erLhcoreClassDesign::designtpl('lhkernel/csfr_token.tpl.php'));?>

    <?php if (isset($updated) && $updated == 'done') : $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('chat/onlineusers','Settings updated'); ?>
        <?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php'));?>
    <?php endif; ?>

    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Block phone numbers. Wildcard at the phone number is also available.');?></label>
                <textarea placeholder="09*,070*" name="block_numbers" class="form-control form-control-sm"><?php isset($cb_options['block_numbers']) ? print htmlspecialchars($cb_options['block_numbers']) : ''?></textarea>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Allow numbers. Wildcard at the phone number is also available.');?></label>
                <textarea placeholder="370*,371*" name="allow_numbers" class="form-control form-control-sm"><?php isset($cb_options['allow_numbers']) ? print htmlspecialchars($cb_options['allow_numbers']) : ''?></textarea>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Maintenance mode message. If you enter a message callback scheduler will go to maintenance mode.');?></label>
        <textarea placeholder="" name="maintenance_mode" class="form-control form-control-sm"><?php isset($cb_options['maintenance_mode']) ? print htmlspecialchars($cb_options['maintenance_mode']) : ''?></textarea>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Allow only these countries to choose');?></label>
                <textarea placeholder="<department_id>,<country_code>,<country_code><?php echo "\n"?><department_id>,<country_code>,<country_code>" name="allow_countries" class="form-control form-control-sm"><?php isset($cb_options['allow_countries']) ? print htmlspecialchars($cb_options['allow_countries']) : ''?></textarea>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Exclude these countries for department');?></label>
                <textarea placeholder="<department_id>,<country_code>,<country_code><?php echo "\n"?><department_id>,<country_code>,<country_code>" name="exclude_countries" class="form-control form-control-sm"><?php isset($cb_options['exclude_countries']) ? print htmlspecialchars($cb_options['exclude_countries']) : ''?></textarea>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','How many days upfront allow to choose?');?></label>
        <input type="number" placeholder="14" name="days_upfront" class="form-control form-control-sm" value="<?php isset($cb_options['days_upfront']) ? print htmlspecialchars($cb_options['days_upfront']) : ''?>" />
    </div>

    <div class="form-group">
        <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Minimum time in minutes before next available slot?');?></label>
        <input type="number" placeholder="0" name="min_time" class="form-control form-control-sm" value="<?php isset($cb_options['min_time']) ? print htmlspecialchars($cb_options['min_time']) : ''?>" />
    </div>

    <div class="form-group">
        <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Default text for terms of service. If you do not enter a text we will not show a terms of service agreement option.');?></label>
        <input type="text" name="terms_of_service" class="form-control form-control-sm" value="<?php isset($cb_options['terms_of_service']) ? print htmlspecialchars($cb_options['terms_of_service']) : print 'I hereby agree to my phone call, being recorded for quality assurance purposes only'?>" />
    </div>

    <h6>Auto assignment option</h6>

    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','How long should we wait before call is assigned to another operator? (seconds)');?></label>
                <input type="number" placeholder="15 seconds" name="auto_assign_timeout" class="form-control form-control-sm" value="<?php isset($cb_options['auto_assign_timeout']) ? print htmlspecialchars($cb_options['auto_assign_timeout']) : '15'?>" />
            </div>
        </div>
        <div class="col-6">
            <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Calls which will happen in x minutes should be assigned');?></label>
            <input type="number" placeholder="10 minutes" name="call_in_minutes" class="form-control form-control-sm" value="<?php isset($cb_options['call_in_minutes']) ? print htmlspecialchars($cb_options['call_in_minutes']) : '15'?>" />
        </div>
    </div>

    <div class="form-group">
        <label>Scheduled call uniqueness decided by these fields</label>
        <label class="d-block"><input type="checkbox" name="unique[]" <?php if (isset($cb_options['unique']) && is_array($cb_options['unique']) && in_array('dep_id',$cb_options['unique'])) : ?>checked="checked"<?php endif;?> value="dep_id"> Department</label>
        <label class="d-block"><input type="checkbox" name="unique[]" <?php if (isset($cb_options['unique']) && is_array($cb_options['unique']) && in_array('name',$cb_options['unique'])) : ?>checked="checked"<?php endif;?> value="name"> Username</label>
        <label class="d-block"><input type="checkbox" name="unique[]" <?php if (isset($cb_options['unique']) && is_array($cb_options['unique']) && in_array('email',$cb_options['unique'])) : ?>checked="checked"<?php endif;?> value="email"> E-mail</label>
        <label class="d-block"><input type="checkbox" name="unique[]" <?php if (isset($cb_options['unique']) && is_array($cb_options['unique']) && in_array('phone',$cb_options['unique'])) : ?>checked="checked"<?php endif;?> value="phone"> Phone</label>
        <label class="d-block"><input type="checkbox" name="unique[]" <?php if (isset($cb_options['unique']) && is_array($cb_options['unique']) && in_array('schedule_id',$cb_options['unique'])) : ?>checked="checked"<?php endif;?> value="schedule_id"> Schedule</label>
    </div>
    <p><small>If none is selected by default we use Phone, Schedule and Department combination.</small></p>

    <input type="submit" class="btn btn-secondary" name="StoreOptions" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons','Save'); ?>" />

</form>
