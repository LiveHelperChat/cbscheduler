<?php

erLhcoreClassRestAPIHandler::setHeaders();

erLhcoreClassRestAPIHandler::setHeaders();

erTranslationClassLhTranslation::$htmlEscape = false;

$requestPayload = json_decode(file_get_contents('php://input'),true);

$item = new erLhcoreClassModelCBSchedulerReservation();

$outputResponse = [];

try {
    $errors = erLhcoreClassCBSchedulerValidation::validateSchedule($item, $requestPayload);

    if (empty($errors)) {

        $item->saveThis();

        erLhcoreClassRestAPIHandler::outputResponse(['error' => false, 'data' => [
            'ics' => (erLhcoreClassModelChatConfig::fetch('explicit_http_mode')->current_value . '//' . $_SERVER['HTTP_HOST'] . erLhcoreClassDesign::baseurl('cbscheduler/download') . '/' . $item->id . '/' . $item->code),
            'id' => $item->id,
            'code' => $item->code]]);

        exit;

    } else {
        erLhcoreClassRestAPIHandler::outputResponse(['error' => true, 'messages' => $errors]);
        exit;
    }

} catch (Exception $e) {
    erLhcoreClassRestAPIHandler::outputResponse(['error' => true, 'message' => $e->getMessage()]);
    exit;
}

erLhcoreClassRestAPIHandler::outputResponse($outputResponse);

exit;

?>