<?php

$tpl = erLhcoreClassTemplate::getInstance('lhcbscheduler/schedule.tpl.php');

$item = new erLhcoreClassModelCBSchedulerReservation();
$item->dep_id = is_numeric($Params['user_parameters_unordered']['department']) ? (int)$Params['user_parameters_unordered']['department'] : null;

// Set default department if it's not provided
if ($item->dep_id == null) {
    $department = erLhcoreClassModelDepartament::findOne(array('limit' => 1,'filter' => array('disabled' => 0)));
    $item->dep_id = $department->id;
}

$tpl->set('item', $item);
$tpl->set('department', is_numeric($Params['user_parameters_unordered']['department']) ? (int)$Params['user_parameters_unordered']['department'] : null);
$tpl->set('theme_id', null);
$tpl->set('theme_v', null);

if (isset($Params['user_parameters_unordered']['theme']) && !empty($Params['user_parameters_unordered']['theme']) && ($themeId = erLhcoreClassChat::extractTheme($Params['user_parameters_unordered']['theme'])) !== false) {
    $theme = erLhAbstractModelWidgetTheme::fetch($themeId);
    if ($theme instanceof erLhAbstractModelWidgetTheme) {
        $theme->translate();
        $Result['theme'] = $theme;
        $tpl->set('theme_id', $theme->id);
        $tpl->set('theme_v', $theme->modified);
    }
} else {
    $defaultTheme = erLhcoreClassModelChatConfig::fetch('default_theme_id')->current_value;
    if ($defaultTheme > 0) {
        $theme = erLhAbstractModelWidgetTheme::fetch($defaultTheme);
        if ($theme instanceof erLhAbstractModelWidgetTheme) {
            $theme->translate();
            $Result['theme'] = $theme;
            $tpl->set('theme_id', $theme->id);
            $tpl->set('theme_v', $theme->modified);
        }
    }
}

$Result['content'] = $tpl->fetch();
$Result['pagelayout'] = 'userchat';
$Result['hide_close_window'] = true;
$Result['hide_modal_header'] = true;
$Result['additional_header_css'] = '<link rel="stylesheet" href="' . erLhcoreClassDesign::designCSS('css/cbscheduler.css') . '"/>';
 
$Result['path'] = array(
    array(
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler', 'Schedule callback')
    )
);

?>