<?php

$tpl = erLhcoreClassTemplate::getInstance('lhcbscheduler/scheduleadmin.tpl.php');

$item = new erLhcoreClassModelCBSchedulerReservation();

if (isset($_GET['department']) && is_numeric($_GET['department'])) {
    $item->dep_id = (int)$_GET['department'];
} else {
    $item->dep_id = is_numeric($Params['user_parameters_unordered']['department']) ? (int)$Params['user_parameters_unordered']['department'] : null;
}

if (is_numeric($Params['user_parameters_unordered']['parent'])) {
    $itemPrevious = erLhcoreClassModelCBSchedulerReservation::fetch((int)$Params['user_parameters_unordered']['parent']);
    $item->dep_id = $itemPrevious->dep_id;
} else {
    $itemPrevious = new erLhcoreClassModelCBSchedulerReservation();
}

$tpl->set('item', $item);
$tpl->set('itemPrevious', $itemPrevious);
$tpl->set('department', $item->dep_id);

$Result['content'] = $tpl->fetch();

$Result['additional_header_js'] = '<script type="text/javascript" src="' . erLhcoreClassDesign::designJS('js/scheduler/dist/react.cbscheduler.app.js') . '"></script>';
$Result['additional_header_css'] = '<link rel="stylesheet" href="' . erLhcoreClassDesign::designCSS('css/cbscheduler.css') . '"/>';

$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('cbscheduler/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler', 'Callback scheduler')
    ),
    array(
        'url' => erLhcoreClassDesign::baseurl('cbscheduler/reservations'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler', 'Reservations')
    ),
    array(
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler', 'Schedule callback')
    )
);

?>