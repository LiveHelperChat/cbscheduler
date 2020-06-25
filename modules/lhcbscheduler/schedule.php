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

$Result['content'] = $tpl->fetch();
$Result['pagelayout'] = 'userchat';
$Result['hide_close_window'] = true;
$Result['hide_modal_header'] = true;

// Theme handling
if (isset($Params['user_parameters_unordered']['theme']) && (int)$Params['user_parameters_unordered']['theme'] > 0){
    try {
        $theme = erLhAbstractModelWidgetTheme::fetch($Params['user_parameters_unordered']['theme']);
        $theme->translate();
        $Result['theme'] = $theme;
    } catch (Exception $e) {

    }
} else {
    $defaultTheme = erLhcoreClassModelChatConfig::fetch('default_theme_id')->current_value;
    if ($defaultTheme > 0) {
        try {
            $theme = erLhAbstractModelWidgetTheme::fetch($defaultTheme);
            $theme->translate();
            $Result['theme'] = $theme;
        } catch (Exception $e) {

        }
    }
}

$Result['additional_header_js'] = '<script type="text/javascript" src="' . erLhcoreClassDesign::designJS('js/scheduler/dist/react.cbscheduler.app.js') . '"></script>';
$Result['additional_header_css'] = '<link rel="stylesheet" href="' . erLhcoreClassDesign::designCSS('css/cbscheduler.css') . '"/>';

$Result['path'] = array(
    array(
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler', 'Schedule callback')
    )
);

?>