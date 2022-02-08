<div class="col-4">
    <div class="form-group">
        <label title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Offline chat');?>"><input type="checkbox" <?php if (isset($can_edit_groups) && $can_edit_groups === false) : ?>disabled="disabled"<?php endif;?> value="on" name="HideMyStatus" <?php echo $user->hide_online == 1 ? 'checked="checked"' : '' ?> /> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/new','Offline chat')?></label>
    </div>
</div>
<div class="col-4">
    <div class="form-group">
        <label title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Offline phone');?>"><input type="checkbox" <?php if (isset($can_edit_groups) && $can_edit_groups === false) : ?>disabled="disabled"<?php endif;?> value="on" name="HidePhoneStatus" <?php echo erLhcoreClassModelCBSchedulerPhoneMode::getCount(['filterin' => ['on_phone' => 1, 'user_id' => $user->id]]) == 0 ? 'checked="checked"' : '' ?> /> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/new','Offline phone')?></label>
    </div>
</div>