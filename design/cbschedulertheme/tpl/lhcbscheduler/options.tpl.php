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

    <input type="submit" class="btn btn-secondary" name="StoreOptions" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons','Save'); ?>" />

</form>
