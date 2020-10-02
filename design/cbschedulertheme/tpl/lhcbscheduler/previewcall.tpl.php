<div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
        <div class="modal-header pt-1 pb-1 pl-2 pr-2">
            <h4 class="modal-title" id="myModalLabel"><span class="material-icons">info_outline</span>[<?php echo $item->id?>]&nbsp;<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Preview call');?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body mx550">
            <?php include(erLhcoreClassDesign::designtpl('lhcbscheduler/parts/form_reservation_top.tpl.php'));?>
            <div class="row" id="callback-outcome-preview">
                <div class="col-6">
                    <div class="form-inline">
                        <p><b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Phone');?></b>
                            <input type="text" class="form-control form-control-sm d-inline" id="cbdata-phone" readonly value="<?php echo htmlspecialchars($item->phone)?>" />&nbsp;<i class="material-icons <?php echo $item->verified == 1 ? 'text-success' : 'text-warning'?>">verified_user</i>&nbsp;<span title="Copy" data-field="cbdata-phone" class="copy-action material-icons action-image">content_copy</span>
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
                        <p><b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Previous call');?></b> - <a onclick="return lhc.revealModal({'url':WWW_DIR_JAVASCRIPT +'cbscheduler/previewcall/<?php echo $item->parent_id?>'})"><i class="material-icons mr-0">open_in_new</i> Preview</a></p>
                    </div>
                <?php endif; ?>

                <div class="col-6">
                    <p><b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Chat ID');?></b> - <?php echo htmlspecialchars($item->chat_id)?></p>
                </div>

                <?php if ($item->user instanceof erLhcoreClassModelUser) : ?>
                    <div class="col-6"><p><b>Serviced by:</b> <a href="<?php echo erLhcoreClassDesign::baseurl('user/edit')?>/<?php echo $item->user->id?>"><?php echo htmlspecialchars($item->user->name_official)?></a></p></div>
                <?php endif; ?>

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
                            <label><b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Present outcome of the call');?>&nbsp;<span data-field="cbdata-outcome-all-preview" title="Copy" class="copy-action material-icons action-image">content_copy</span></b></label>
                            <textarea class="form-control form-control-sm" rows="10" readonly id="cbdata-outcome-all-preview"><?php echo htmlspecialchars($item->outcome)?></textarea>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
            <script>
                $('#callback-outcome-preview .copy-action').click(function() {
                    $('#callback-outcome-preview #' + $(this).attr('data-field')).select();
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
        </div>

    </div>
</div>