<?php if (erLhcoreClassUser::instance()->hasAccessTo('lhcbscheduler','use_admin')) : ?>
<a href="#" ng-class="{'font-weight-bold': lhc.cb_pm}" class="dropdown-item pl-2" ng-click="lhc.emitEvent('cbSetPhoneModeSelf')">
    <i class="material-icons" title="Change my visibility to visible/invisible">{{lhc.cb_pm ? 'phone' : 'phone_disabled'}}</i>
    <span ng-if="lhc.cb_pm"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Phone On');?></span>
    <span ng-if="!lhc.cb_pm"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Phone Off');?></span>
</a>
<?php endif; ?>