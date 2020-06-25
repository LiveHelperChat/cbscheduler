<div class="row">
    <div class="col-6">
        <p><b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Phone');?></b> - <?php echo htmlspecialchars($item->phone)?></p>
    </div>

    <div class="col-6">
        <p><b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Username');?></b> - <?php echo htmlspecialchars($item->name)?></p>
    </div>

    <div class="col-6">
        <p><b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','E-mail');?></b> - <?php echo htmlspecialchars($item->email)?></p>
    </div>

    <div class="col-6">
        <p><b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Scheduled for');?></b> - <?php echo htmlspecialchars($item->time_till_call)?> | <?php echo htmlspecialchars($item->scheduler_for_front)?></p>
    </div>

    <div class="col-6">
        <p><b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Subject');?></b> - <?php echo htmlspecialchars($item->subject)?></p>
    </div>

    <div class="col-6">
        <p><b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Department');?></b> - <?php echo htmlspecialchars($item->dep)?></p>
    </div>


    <div class="col-6">
        <p><b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Chat ID');?></b> - <?php echo htmlspecialchars($item->chat_id)?></p>
    </div>

    <div class="col-12">
        <p><b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Description');?></b></p>
        <p><?php echo htmlspecialchars($item->description)?></p>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label><b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Status');?></b></label>
            <?php echo erLhcoreClassRenderHelper::renderCombobox(array(
                'input_name'     => 'status',
                'selected_id'    => $item->status,
                'css_class'      => 'form-control form-control-sm',
                'list_function'  => 'erLhcoreClassCBSchedulerValidation::getStatusOptions',
                'list_function_params'  => array(),
            )); ?>
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label><b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Outcome of the call');?></b></label>
            <textarea name="outcome" class="form-control form-control-sm"><?php echo htmlspecialchars($item->outcome)?></textarea>
        </div>
    </div>

</div>

