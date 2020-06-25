<div class="form-group">
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Name');?></label>
    <input type="text" maxlength="250" class="form-control form-control-sm" name="name" value="<?php echo htmlspecialchars($item->name)?>" />
</div>

<div class="form-group">
    <label><input type="checkbox" name="active" value="on" <?php $item->active == 1 ? print ' checked="checked" ' : ''?> > <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Active');?></label>
</div>

<div class="form-group">
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Position');?></label>
    <input type="text" maxlength="250" class="form-control form-control-sm" name="pos" value="<?php echo htmlspecialchars($item->pos)?>" />
</div>