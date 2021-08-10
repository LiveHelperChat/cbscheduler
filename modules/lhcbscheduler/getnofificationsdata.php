<?php

header('content-type: application/json; charset=utf-8');
$itemsReturn = [];

if (!empty($Params['user_parameters_unordered']['id'])) {
    erLhcoreClassChat::validateFilterIn($Params['user_parameters_unordered']['id']);
    $items = erLhcoreClassModelCBSchedulerReservation::getList(array(
        'filterin' => array('id' => $Params['user_parameters_unordered']['id'])
    ));

    // var notification = new Notification(nick, { icon: WWW_DIR_JAVASCRIPT_FILES_NOTIFICATION + '/notification.png', body: message, requireInteraction : true });
    foreach ($items as $item) {
        $itemsReturn[] = [
            'id' => $item->id,
            'nick' => $item->name.' '. $item->phone,
            'body' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler', 'Call in').' - '.$item->time_till_call
        ];
    }

}

echo erLhcoreClassChat::safe_json_encode($itemsReturn);
exit;