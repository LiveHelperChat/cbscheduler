<div class="form-group">
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/cannedmsg','Department');?></label>
    <div class="row" style="max-height: 500px; overflow: auto">
        <?php $params = array (
            'input_name'     => 'dep_id[]',
            'display_name'   => 'name',
            'css_class'      => 'form-control',
            'multiple'       => true,
            'wrap_prepend'   => '<div class="col-4">',
            'wrap_append'    => '</div>',
            'selected_id'    => $item->dep_id_array,
            'list_function'  => 'erLhcoreClassModelDepartament::getList',
            'list_function_params'  => array('sort' => 'sort_priority ASC, id ASC', 'limit' => '1000000'));

        if (empty($limitDepartments) || (isset($showAnyDepartment) && $showAnyDepartment == true)) {
            $params['optional_field'] = erTranslationClassLhTranslation::getInstance()->getTranslation('department/edit','Any');
        }

        echo erLhcoreClassRenderHelper::renderCheckbox( $params ); ?>
    </div></div>

<div class="form-group" ng-non-bindable>
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Country to apply to');?></label>
    <textarea class="form-control form-control-sm" name="country" placeholder="E.g lt,uk,de"><?php echo htmlspecialchars(implode(',',$item->country_array))?></textarea>
</div>

<div class="form-group" ng-non-bindable>
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Rules');?></label>
    <textarea class="form-control form-control-sm" placeholder="^+67==>67000<?php echo "\n"?>^+68==>68000" name="rules"><?php echo htmlspecialchars($item->rules)?></textarea>
</div>