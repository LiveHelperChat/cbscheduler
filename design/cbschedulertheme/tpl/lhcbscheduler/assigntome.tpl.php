<p><b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Serviced by');?>:</b>

    <?php if ($item->user instanceof erLhcoreClassModelUser) : ?>
        <a href="<?php echo erLhcoreClassDesign::baseurl('user/edit')?>/<?php echo $item->user->id?>"><?php echo htmlspecialchars($item->user->name_official)?></a> <button type="button" class="btn btn-xs btn-warning" onclick="callAssignToMe(<?php echo $item->id?>,'unassign')"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Remove');?></button>
    <?php endif; ?>

    <?php if ($item->status != erLhcoreClassModelCBSchedulerReservation::STATUS_COMPLETED) : ?>
        <button type="button" class="btn btn-xs btn-info" onclick="callAssignToMe(<?php echo $item->id?>)"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Assign to me');?></button>
    <?php endif; ?>

    <?php if (erLhcoreClassUser::instance()->hasAccessTo('lhcbscheduler', 'manage_assignment')) : ?>
          <?php if ($item->user instanceof erLhcoreClassModelUser && $item->user_id != erLhcoreClassUser::instance()->getUserID()) : ?>
                <p>If you change call status, assigned user won't be changed.</p>
        <?php endif; ?>
        <?php echo erLhcoreClassRenderHelper::renderMultiDropdown( array (
            'input_name'     => 'user_ids[]',
            'data_prop'      => 'data-limit="1"',
            'optional_field' => erTranslationClassLhTranslation::getInstance()->getTranslation('chat/lists/search_panel','Assign operator'),
            'selected_id'    => [$item->user_id],
            'css_class'      => 'form-control',
            'display_name'   => 'name_official',
            'list_function_params' => array('limit' => false),
            'list_function'  => 'erLhcoreClassModelUser::getUserList',
        )); ?>

<script>
    $(function() {
        $('.btn-block-department').makeDropdown();
    });
</script>

    <?php endif; ?>
</p>