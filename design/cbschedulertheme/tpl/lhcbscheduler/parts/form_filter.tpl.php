<form action="<?php echo $input->form_action?>" method="get" class="mb-2">

    <input type="hidden" name="doSearch" value="1">

    <div class="row">
        <div class="col-4">
            <div class="form-group">
                <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/lists/search_panel','Status');?></label>
                <select class="form-control form-control-sm" name="status">
                    <option>All</option>
                    <option value="<?php echo erLhcoreClassModelCBSchedulerReservation::STATUS_SCHEDULED?>" <?php $input->status === erLhcoreClassModelCBSchedulerReservation::STATUS_SCHEDULED ? print 'selected="selected"' : ''?>>Scheduled</option>
                    <option value="<?php echo erLhcoreClassModelCBSchedulerReservation::STATUS_COMPLETED?>" <?php $input->status === erLhcoreClassModelCBSchedulerReservation::STATUS_COMPLETED ? print 'selected="selected"' : ''?>>Completed</option>
                </select>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/lists/search_panel','Department');?></label>
                <?php echo erLhcoreClassRenderHelper::renderMultiDropdown( array (
                    'input_name'     => 'department_ids[]',
                    'optional_field' => erTranslationClassLhTranslation::getInstance()->getTranslation('chat/lists/search_panel','Choose department'),
                    'selected_id'    => $input->department_ids,
                    'css_class'      => 'form-control',
                    'display_name'   => 'name',
                    'list_function_params' => erLhcoreClassUserDep::conditionalDepartmentFilter(),
                    'list_function'  => 'erLhcoreClassModelDepartament::getList'
                )); ?>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/lists/search_panel','Department group');?></label>
                <?php echo erLhcoreClassRenderHelper::renderMultiDropdown( array (
                    'input_name'     => 'department_group_ids[]',
                    'optional_field' => erTranslationClassLhTranslation::getInstance()->getTranslation('chat/lists/search_panel','Choose department group'),
                    'selected_id'    => $input->department_group_ids,
                    'css_class'      => 'form-control',
                    'display_name'   => 'name',
                    'list_function_params' => erLhcoreClassUserDep::conditionalDepartmentGroupFilter(),
                    'list_function'  => 'erLhcoreClassModelDepartamentGroup::getList'
                )); ?>
            </div>
        </div>
    </div>

    <div class="btn-group" role="group" aria-label="...">
        <input type="submit" name="doSearch" class="btn btn-sm btn-secondary" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/lists/search_panel','Search');?>" />
    </div>

</form>


