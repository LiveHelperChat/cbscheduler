<?php

erLhcoreClassRestAPIHandler::setHeaders();

erTranslationClassLhTranslation::$htmlEscape = false;

$requestPayload = json_decode(file_get_contents('php://input'),true);

$item = new erLhcoreClassModelCBSchedulerReservation();

$outputResponse = [];

try {
    $errors = erLhcoreClassCBSchedulerValidation::validateSchedule($item, $requestPayload);

    if (empty($errors)) {

        $item->saveThis();

        // Save message within a chat
        if ($item->chat_id > 0) {
            $msg = new erLhcoreClassModelmsg();
            $msg->msg = erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler', 'Visitor has scheduled a call!') . ' [url=' . erLhcoreClassDesign::baseurl('cbscheduler/editreservation') . '/' . $item->id . ']' . erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler', 'view reservation') . '[/url]';
            $msg->chat_id = $item->chat_id;
            $msg->user_id = - 1;
            $msg->time = time();
            erLhcoreClassChat::getSession()->save($msg);

            $chat = erLhcoreClassModelChat::fetch($item->chat_id);
            if ($chat instanceof erLhcoreClassModelChat){
                $chat->last_msg_id = $msg->id;
                $chat->updateThis(['update' => ['last_msg_id']]);
            }
        }

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