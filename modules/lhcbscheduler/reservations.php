<?php

$tpl = erLhcoreClassTemplate::getInstance('lhcbscheduler/reservations.tpl.php');

if (isset($_GET['doSearch'])) {
    $filterParams = erLhcoreClassSearchHandler::getParams(array('customfilterfile' => 'extension/cbscheduler/classes/filter/schedules.php','format_filter' => true, 'use_override' => true, 'uparams' => $Params['user_parameters_unordered']));
    $filterParams['is_search'] = true;
} else {
    $filterParams = erLhcoreClassSearchHandler::getParams(array('customfilterfile' => 'extension/cbscheduler/classes/filter/schedules.php','format_filter' => true, 'uparams' => $Params['user_parameters_unordered']));
    $filterParams['is_search'] = false;
}

$append = erLhcoreClassSearchHandler::getURLAppendFromInput($filterParams['input_form']);

erLhcoreClassChatStatistic::formatUserFilter($filterParams, 'lhc_cbscheduler_reservation');

if (isset($filterParams['filter']['filterin']['lh_chat.dep_id'])) {
    $filterParams['filter']['filterin']['dep_id'] = $filterParams['filter']['filterin']['lh_chat.dep_id'];
    unset($filterParams['filter']['filterin']['lh_chat.dep_id']);
}

/**
 * Departments filter
 * */
$limitation = erLhcoreClassChat::getDepartmentLimitation('lhc_cbscheduler_reservation');

if ($limitation !== false) {

    if ($limitation !== true) {
        $filterParams['filter']['customfilter'][] = $limitation;
    }

    $filterParams['filter']['smart_select'] = true;
}

$pages = new lhPaginator();
$pages->items_total = erLhcoreClassModelCBSchedulerReservation::getCount($filterParams['filter']);
$pages->translationContext = 'chat/activechats';
$pages->serverURL = erLhcoreClassDesign::baseurl('cbscheduler/reservations').$append;
$pages->paginate();
$tpl->set('pages',$pages);

if ($pages->items_total > 0) {
    $items = erLhcoreClassModelCBSchedulerReservation::getList(array_merge(array('limit' => $pages->items_per_page, 'offset' => $pages->low),$filterParams['filter']));
    $tpl->set('items',$items);
}

$filterParams['input_form']->form_action = erLhcoreClassDesign::baseurl('cbscheduler/reservations');
$tpl->set('input',$filterParams['input_form']);
$tpl->set('inputAppend',$append);

$Result['require_angular'] = true;
$Result['content'] = $tpl->fetch();


$Result['path'] = array (
    array('url' => erLhcoreClassDesign::baseurl('cbscheduler/index'), 'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Callback scheduler')),
    array('url' => erLhcoreClassDesign::baseurl('cbscheduler/reservations'), 'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Reservations'))
);

?>