<?php if (erLhcoreClassUser::instance()->hasAccessTo('lhcbscheduler','use_admin')) : ?>
<a href="#" class="dropdown-item pl-2" id="activate-cb-scheduler" data-offline="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Phone Off');?>" data-online="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Phone On');?>">
    <i class="material-icons" title="Change my visibility to visible/invisible">phone</i>
    <span>Phone</span>
</a>
<?php endif; ?>