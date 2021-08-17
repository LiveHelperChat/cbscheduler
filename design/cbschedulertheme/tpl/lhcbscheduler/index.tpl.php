<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Callback scheduler');?></h1>
<ul>
    <li><a href="<?php echo erLhcoreClassDesign::baseurl('cbscheduler/reservations')?>"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Reservations');?></a></li>
    <?php if (erLhcoreClassUser::instance()->hasAccessTo('lhcbscheduler','manage_schedule')) : ?>
        <li><a href="<?php echo erLhcoreClassDesign::baseurl('cbscheduler/options')?>"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Options');?></a></li>
        <li><a href="<?php echo erLhcoreClassDesign::baseurl('cbscheduler/schedules')?>"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Schedules');?></a></li>
        <li><a href="<?php echo erLhcoreClassDesign::baseurl('cbscheduler/subjects')?>"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Subjects');?></a></li>
        <li><a href="<?php echo erLhcoreClassDesign::baseurl('cbscheduler/transforms')?>"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Transforms');?></a></li>
    <?php endif; ?>
</ul>
