<div class="form-group" ng-non-bindable>
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Name');?></label>
    <input type="text" maxlength="250" class="form-control form-control-sm" name="name" value="<?php echo htmlspecialchars($item->name)?>" />
</div>

<div class="form-group" ng-non-bindable>
    <label><input type="checkbox" name="active" value="on" <?php $item->active == 1 ? print ' checked="checked" ' : ''?> > <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Active');?></label>
</div>

<div class="form-group" ng-non-bindable>
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Position');?></label>
    <input type="text" maxlength="250" class="form-control form-control-sm" name="pos" value="<?php echo htmlspecialchars($item->pos)?>" />
</div>

<div class="form-group">
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/lists/search_panel','Available only for those departments. If not chosen will be available for all');?></label>
    <?php echo erLhcoreClassRenderHelper::renderMultiDropdown( array (
        'input_name'     => 'dep_ids[]',
        'optional_field' => erTranslationClassLhTranslation::getInstance()->getTranslation('chat/lists/search_panel','Choose department'),
        'selected_id'    => $item->dep_ids_array,
        'ajax'           => 'deps',
        'css_class'      => 'form-control',
        'display_name'   => 'name',
        'list_function_params' => ['sort' => '`name` ASC', 'limit' => 50],
        'list_function'  => 'erLhcoreClassModelDepartament::getList'
    )); ?>
</div>

<script>
    $(function() {
        $('.btn-block-department').makeDropdown();
    });
</script>