<div class="row" id="callback-outcome">
    <div class="col-6">
        <div class="form-inline">
             <p><b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Phone');?></b>
             <input type="text" class="form-control form-control-sm d-inline" id="cbdata-phone" readonly value="<?php echo htmlspecialchars($item->phone)?>" />&nbsp;<i class="material-icons <?php echo $item->verified == 1 ? 'text-success' : 'text-danger'?>"><?php echo $item->verified == 1 ? 'verified_user' : 'help_outline'?></i>&nbsp;<span title="Copy" data-field="cbdata-phone" class="copy-action material-icons action-image">content_copy</span>
             </p>
        </div>
    </div>

    <div class="col-6">
        <div class="form-inline">
            <p>
                <b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Username');?></b>
                <input type="text" class="form-control form-control-sm d-inline" id="cbdata-username" readonly value="<?php echo htmlspecialchars($item->name)?>" />&nbsp;<span data-field="cbdata-username" title="Copy" class="copy-action material-icons action-image">content_copy</span>
            </p>
        </div>
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

    <?php if ($item->parent instanceof erLhcoreClassModelCBSchedulerReservation) : ?>
    <div class="col-6">
        <p><b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Previous call');?></b> - <a onclick="return lhc.revealModal({'height':350,'url':WWW_DIR_JAVASCRIPT +'cbscheduler/previewcall/<?php echo $item->parent_id?>'})"><i class="material-icons mr-0">info</i> [<?php echo $item->parent_id?>] Preview</a></p>
    </div>
    <?php endif; ?>

    <div class="col-6">
        <p><b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Chat ID');?></b> - <?php echo htmlspecialchars($item->chat_id)?></p>
    </div>

    <div class="col-6" id="call-serviced-by">
        <?php include(erLhcoreClassDesign::designtpl('lhcbscheduler/assigntome.tpl.php'));?>
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
            <label><b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Outcome of the call');?>&nbsp;<span data-field="cbdata-outcome" title="Copy" class="copy-action material-icons action-image">content_copy</span></b></label>
            <textarea name="outcome" id="cbdata-outcome" class="form-control form-control-sm"><?php echo htmlspecialchars($item->outcome_new)?></textarea>
        </div>
    </div>

    <?php if ($item->outcome != '') : ?>
    <div class="col-12">
        <div class="form-group">
            <label><b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Present outcome of the call');?>&nbsp;<span data-field="cbdata-outcome-all" title="Copy" class="copy-action material-icons action-image">content_copy</span></b></label>
            <textarea class="form-control form-control-sm" rows="10" readonly id="cbdata-outcome-all"><?php echo htmlspecialchars($item->outcome)?></textarea>
        </div>
    </div>
    <?php endif; ?>

    <div class="col-12">
        <div class="form-group">
            <a class="btn btn-info btn-xs" target="_blank" title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Follow up');?>" href="<?php echo erLhcoreClassDesign::baseurl('cbscheduler/scheduleadmin')?>/(parent)/<?php echo $item->id?>" ><i class="material-icons">open_in_new</i> <i class="material-icons mr-0">add_ic_call</i></a>
        </div>
    </div>

</div>

<script>

    $('#id_status').change(function () {
        if (<?php echo $item->status?> == 1 && $(this).val() != 1) {
            if (!confirm("<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Are you sure you want to schedule this call again?');?>")) {
                $(this).val(1);
            }
        }
    });
    
    function callAssignToMe(id) {
        $.get(WWW_DIR_JAVASCRIPT + 'cbscheduler/assigntome/' + id, function(data) {
            $('#call-serviced-by').html(data);
        });
    }

    $('#callback-outcome .copy-action').click(function() {
        $('#callback-outcome #' + $(this).attr('data-field')).select();
        document.execCommand("copy");
        if (window.getSelection) {
            if (window.getSelection().empty) {  // Chrome
                window.getSelection().empty();
            } else if (window.getSelection().removeAllRanges) {  // Firefox
                window.getSelection().removeAllRanges();
            }
        } else if (document.selection) {  // IE?
            document.selection.empty();
        }
    });
</script>
