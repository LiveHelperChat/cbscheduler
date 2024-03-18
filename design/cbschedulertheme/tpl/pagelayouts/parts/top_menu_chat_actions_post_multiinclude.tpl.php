<?php if (erLhcoreClassUser::instance()->hasAccessTo('lhcbscheduler','use_admin')) : ?>
<a href="#" id="set-phone-mode" <?php /*ng-class="{'fw-bold': lhc.cb_pm}"*/ ?> class="dropdown-item ps-2" <?php /*ng-click="lhc.emitEvent('cbSetPhoneModeSelf')"*/ ?> >
    <i class="material-icons" id="phone-mode-icon" title="Change my visibility to visible/invisible">phone<?php /*{{lhc.cb_pm ? 'phone' : 'phone_disabled'}}*/ ?></i>
    <span class="phone-on" style="display: none" <?php /*ng-if="lhc.cb_pm"*/?> ><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Phone On');?></span>
    <span class="phone-off"  <?php /*ng-if="!lhc.cb_pm"*/?>><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Phone Off');?></span>
</a>
<?php endif; ?>