
    <div class="d-flex flex-row">
        <div>
            <b class="fs13 no-wrap"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Serviced by');?>:</b>
        </div>

        <?php if ($item->user instanceof erLhcoreClassModelUser) : ?>
        <div class="pl-2">
                <a class="no-wrap" href="<?php echo erLhcoreClassDesign::baseurl('user/edit')?>/<?php echo $item->user->id?>"><?php echo htmlspecialchars($item->user->name_official)?></a>
        </div>
            <div class="pl-2">
                <button type="button" class="btn btn-xs btn-warning" onclick="callAssignToMe(<?php echo $item->id?>,'unassign')"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Remove');?></button>
        </div>
         <?php endif; ?>

        <?php if ($item->status != erLhcoreClassModelCBSchedulerReservation::STATUS_COMPLETED) : ?>
        <div class="pl-2">
                <button type="button" class="no-wrap btn btn-xs btn-info" onclick="callAssignToMe(<?php echo $item->id?>)"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Assign to me');?></button>
        </div>
        <?php endif; ?>

        <?php if ($item->user_id > 0) : ?>
        <div class="pl-2">
                <a title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Acceptance status');?>" class="material-icons <?php $item->status == erLhcoreClassModelCBSchedulerReservation::PENDING_ACCEPT ? print('text-warning'): print('text-success')?>" >assignment_ind</a>
        </div>
        <?php endif; ?>


        <?php if (erLhcoreClassUser::instance()->hasAccessTo('lhcbscheduler', 'manage_assignment')) : ?>
        <div>
            <?php echo erLhcoreClassRenderHelper::renderMultiDropdown( array (
                'input_name'     => 'user_ids[]',
                'optional_field' => erTranslationClassLhTranslation::getInstance()->getTranslation('chat/lists/search_panel','Assign operator'),
                'selected_id'    => [$item->user_id],
                'css_class'      => 'form-control',
                'display_name'   => 'name_official',
                'list_function_params' => array('limit' => false),
                'list_function'  => 'erLhcoreClassModelUser::getUserList',
            )); ?>
        </div>
    </div>

            <?php if ($item->user instanceof erLhcoreClassModelUser && $item->user_id != erLhcoreClassUser::instance()->getUserID()) : ?>

                <div class="fs13">If you change call status, assigned user won't be changed.</div>
            <?php endif; ?>

            <script>
                $(function() {
                    $('.btn-block-department').makeDropdown();
                });
            </script>
        <?php else : ?>
    </div>
        <?php endif; ?>










    

