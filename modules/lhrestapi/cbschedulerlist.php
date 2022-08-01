<?php

try {
    erLhcoreClassRestAPIHandler::validateRequest();

    $user = erLhcoreClassRestAPIHandler::getUser();

    if (!$user->hasAccessTo('lhcbscheduler','useapi')) {
        throw new Exception('You do not have permission to use twilio! "lhcbscheduler","useapi" permission is missing');
    }

    $filter = erLhcoreClassRestAPIHandler::getChatListFilter();

    echo erLhcoreClassRestAPIHandler::outputResponse(array(
        'error' => false,
        'result' => array_values(erLhcoreClassModelCBSchedulerReservation::getList($filter))
    ));

} catch (Exception $e) {
    http_response_code(400);
    echo erLhcoreClassRestAPIHandler::outputResponse(array(
        'error' => true,
        'result' => $e->getMessage()
    ));
}
exit;

?>