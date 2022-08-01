<?php

try {
    erLhcoreClassRestAPIHandler::validateRequest();

    $user = erLhcoreClassRestAPIHandler::getUser();

    if (!$user->hasAccessTo('lhcbscheduler','useapi')) {
        throw new Exception('You do not have permission to use twilio! "lhcbscheduler","useapi" permission is missing');
    }

    $record = erLhcoreClassModelCBSchedulerReservation::fetch($Params['user_parameters']['id']);

    if (!($record instanceof erLhcoreClassModelCBSchedulerReservation)) {
        throw new Exception('Record with id \''.$Params['user_parameters']['id'] . '\' could not be found!');
    }

    echo erLhcoreClassRestAPIHandler::outputResponse(array(
        'error' => false,
        'result' => $record->getState()
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