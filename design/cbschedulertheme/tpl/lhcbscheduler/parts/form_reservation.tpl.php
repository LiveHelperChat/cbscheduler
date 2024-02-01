<div id="callback-outcome" class="row" ng-non-bindable>
        <div class="col-6">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label fs14"><b><i class="material-icons <?php echo $item->verified == 1 ? 'text-success' : 'text-danger'?>"><?php echo $item->verified == 1 ? 'verified_user' : 'help_outline'?></i><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Phone');?></b></label>
                <div class="col-sm-9">
                    <div class="input-group mb-2 me-sm-2">

                            <div class="input-group-text"><span title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Original phone number entered by user');?>" class="material-icons">person</span> <span title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Copy');?>" data-field="cbdata-phone" class="me-0 copy-action material-icons action-image">content_copy</span></div>

                        <input type="text" class="form-control form-control-sm d-inline" id="cbdata-phone" readonly value="<?php echo htmlspecialchars($item->phone)?>" />
                        <?php include(erLhcoreClassDesign::designtpl('lhcbscheduler/parts/phone_number_link.tpl.php'));?>
                    </div>
                    <?php foreach ($item->phone_front as $indexAlias => $phone) : ?>
                        <div class="input-group mb-2 me-sm-2">

                                <div class="input-group-text"><span title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Copy alias');?>" data-field="cbdata-phone-<?php echo $indexAlias?>" class="me-0 copy-action material-icons action-image">content_copy</span></div>

                            <input type="text" class="form-control form-control-sm d-inline" id="cbdata-phone-<?php echo $indexAlias?>" readonly value="<?php echo htmlspecialchars($phone)?>" />
                            <?php include(erLhcoreClassDesign::designtpl('lhcbscheduler/parts/phone_number_link_alias.tpl.php'));?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label fs14"><b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Username');?></b></label>
                <div class="col-sm-9">
                    <div class="input-group mb-2 me-sm-2">

                            <div class="input-group-text"><span data-field="cbdata-username" title="Copy" class="copy-action me-0 material-icons action-image">content_copy</span></div>
                        
                        <input type="text" class="form-control form-control-sm d-inline" id="cbdata-username" readonly value="<?php echo htmlspecialchars($item->name)?>" />&nbsp;
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="form-group row">
                <label class="col-sm-3 fs14 col-form-label"><b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','E-mail');?></b></label>
                <div class="col-sm-9">
                    <label class="col-form-label"><?php echo htmlspecialchars($item->email)?></label>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group row">
                <label class="col-sm-3 fs14 col-form-label">
                    <b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Scheduled for');?></b>
                </label>
                <div class="col-sm-9">
                    <label class="col-form-label"><?php echo htmlspecialchars($item->time_till_call)?> | <?php echo htmlspecialchars($item->scheduler_for_front)?></label>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label fs14">
                    <b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Subject');?></b>
                </label>
                <label class="col-sm-9 col-form-label">
                    <?php echo htmlspecialchars($item->subject)?>
                </label>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label fs14">
                    <b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Department');?></b>
                </label>
                <label class="col-sm-9 col-form-label">
                    <?php echo htmlspecialchars($item->dep)?>
                </label>
            </div>
        </div>

        <?php if ($item->parent instanceof erLhcoreClassModelCBSchedulerReservation) : ?>
            <div class="col-6">
                <label class="col-form-label fs14">
                    <b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Previous call');?> <a onclick="return lhc.revealModal({'height':350,'url':WWW_DIR_JAVASCRIPT +'cbscheduler/previewcall/<?php echo $item->parent_id?>'})"><i class="material-icons me-0">info</i> [<?php echo $item->parent_id?>] Preview</a></b>
                </label>
            </div>
        <?php endif; ?>

        <?php if ($item->chat_id >= 0) : ?>
        <div class="col-6">
            <div class="form-group row">
                <label class="col-sm-3 fs14 col-form-label">
                    <b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Chat ID');?></b>
                </label>
                <label class="col-sm-9 col-form-label">
                    <?php echo htmlspecialchars($item->chat_id)?>
                </label>
            </div>
        </div>
        <?php endif; ?>

        <div class="col-6" id="call-serviced-by" ng-non-bindable>
            <?php include(erLhcoreClassDesign::designtpl('lhcbscheduler/assigntome.tpl.php'));?>
        </div>

        <div class="col-12" ng-non-bindable>
            <p class="mb-2"><b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Description');?></b></p>
            <p class="mb-2"><?php echo htmlspecialchars($item->description)?></p>
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

        <div class="col-12" ng-non-bindable id="outcome-new-controller" style="display: none">
            <div class="form-group">
                <label>
                    <b><span data-field="cbdata-outcome" title="Copy" class="copy-action material-icons action-image">content_copy</span><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Outcome of the call');?></b>
                </label>
                <textarea name="outcome" id="cbdata-outcome" class="form-control form-control-sm"><?php echo htmlspecialchars((string)$item->outcome_new)?></textarea>
            </div>
        </div>

        <?php if ($item->outcome != '') : ?>
        <div class="col-12" ng-non-bindable>
            <div class="form-group">
                <label><b><span data-field="cbdata-outcome-all" title="Copy" class="copy-action material-icons action-image">content_copy</span><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Present outcome of the call');?></b></label>
                <textarea class="form-control form-control-sm" rows="10" readonly id="cbdata-outcome-all"><?php echo htmlspecialchars($item->outcome)?></textarea>
            </div>
        </div>
        <?php endif; ?>

        <div class="col-12">
            <div class="form-group">
                <a class="btn btn-info btn-xs" target="_blank" title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Follow up');?>" href="<?php echo erLhcoreClassDesign::baseurl('cbscheduler/scheduleadmin')?>/(parent)/<?php echo $item->id?>" ><i class="material-icons">open_in_new</i> <i class="material-icons me-0">add_ic_call</i></a>
                <button type="button" onclick="return lhc.revealModal({'title' : 'Log', 'height':350, backdrop:true, 'url': WWW_DIR_JAVASCRIPT + 'cbscheduler/logreservation/<?php echo $item->id?>'})" class="btn btn-link btn-xs"><span class="material-icons">history</span><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/lists/search_panel','Log')?></button>
            </div>
        </div>

    </div>

<script>
    <?php $item->schedule->status_configuration_array;?>
    function outcomeAvailable(){
        let outcome_status = <?php echo json_encode(isset($item->schedule->status_configuration_array) ? $item->schedule->status_configuration_array : [])?>;
        if ( outcome_status.length == 0 || outcome_status.indexOf(parseInt($('#id_status').val())) !== -1) {
            $('#outcome-new-controller').show();
        } else {
            $('#outcome-new-controller').hide();
            $('#cbdata-outcome').val('');
        }
    }

    outcomeAvailable();

    $('#id_status').change(function () {
        outcomeAvailable();
        if (<?php echo $item->status?> == 1 && $(this).val() != 1) {
            if (!confirm("<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Are you sure you want to schedule this call again?');?>")) {
                $(this).val(1);
            }
        }
    });
    
    function callAssignToMe(id,action) {
        $.get(WWW_DIR_JAVASCRIPT + 'cbscheduler/assigntome/' + id + '/(action)/' + (action ? action : 'assign'), function(data) {
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
