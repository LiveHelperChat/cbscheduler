<p><b><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Serviced by');?>:</b>

    <?php if ($item->status != erLhcoreClassModelCBSchedulerReservation::STATUS_COMPLETED) : ?>
        <button type="button" class="btn btn-xs btn-info" onclick="callAssignToMe(<?php echo $item->id?>)"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Assign to me');?></button>
    <?php endif; ?>

    <?php if ($item->user instanceof erLhcoreClassModelUser) : ?><a href="<?php echo erLhcoreClassDesign::baseurl('user/edit')?>/<?php echo $item->user->id?>"><?php echo htmlspecialchars($item->user->name_official)?></a><?php endif; ?>

</p>