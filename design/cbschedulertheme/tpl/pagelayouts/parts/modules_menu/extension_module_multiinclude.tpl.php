<?php if (erLhcoreClassUser::instance()->hasAccessTo('lhcbscheduler','use_admin')) : ?>
<li class="nav-item"><a class="nav-link" href="<?php echo erLhcoreClassDesign::baseurl('cbscheduler/index')?>"><i class="material-icons">phone_callback</i><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Callback scheduler');?></a></li>
<?php endif; ?>