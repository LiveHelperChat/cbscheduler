<h1 class="attr-header"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Callback Scheduler Options');?></h1>

<form action="" method="post">

    <?php include(erLhcoreClassDesign::designtpl('lhkernel/csfr_token.tpl.php'));?>

    <?php if (isset($updated) && $updated == 'done') : $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('chat/onlineusers','Settings updated'); ?>
        <?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php'));?>
    <?php endif; ?>

    <div class="form-group">
        <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Block phone numbers. Wildcard at the phone number is also available.');?></label>
        <textarea placeholder="09*,070*" name="block_numbers" class="form-control form-control-sm"><?php isset($cb_options['block_numbers']) ? print htmlspecialchars($cb_options['block_numbers']) : ''?></textarea>
    </div>

    <div class="form-group">
        <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Allow numbers. Wildcard at the phone number is also available.');?></label>
        <textarea placeholder="370*,371*" name="allow_numbers" class="form-control form-control-sm"><?php isset($cb_options['allow_numbers']) ? print htmlspecialchars($cb_options['allow_numbers']) : ''?></textarea>
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
