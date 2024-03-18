<?php

/* Icons in the list */
$iconData = [];

if (erLhcoreClassUser::instance()->hasAccessTo('lhcbscheduler','change_phone_mode')) {
    $iconData['class'] = 'material-icons action-image';
    $iconData['click'] = 'cbSetPhoneMode';
} else {
    $iconData['class'] = 'material-icons';
}

$iconData['icon_attr'] = 'on_phone';
$iconData['icon_attr_type'] = 'bool';
$iconData['icon_attr_true'] = 'phone';
$iconData['icon_attr_false'] = 'phone_disabled';

$optionsPanel['custom_icons'][] = $iconData;

/* Sort icons */

$sortIconData = [];
$sortIconData['sort_options'] = ['cb_desc','cb_asc'];
$sortIconData['sort_identifier'] = 'conop_sort';
$sortIconData['sort_icon_cb_asc'] = 'phone';
$sortIconData['sort_icon_cb_desc'] = 'phone_disabled';
$sortIconData['title'] = htmlspecialchars_decode(erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Sort by phone mode'));

$optionsPanel['custom_sort_icons'][] = $sortIconData;

?>