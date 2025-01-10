<?php

erLhcoreClassRestAPIHandler::setHeaders();

erTranslationClassLhTranslation::$htmlEscape = false;

$requestPayload = json_decode(file_get_contents('php://input'),true);

$country = '';
// If department is not passed take it from chat
if (is_numeric($requestPayload['chat_id']) && (!is_numeric($requestPayload['dep_id']) || $requestPayload['dep_id'] == 0)) {
    $chat = erLhcoreClassModelChat::fetch($requestPayload['chat_id']);
    if ($chat instanceof erLhcoreClassModelChat) {
        $requestPayload['dep_id'] = $chat->dep_id;
        $country = $chat->country_code;
    }
}

if (isset($requestPayload['dep_id']) && !is_numeric($requestPayload['dep_id'])) {
    $parametersDepartment = erLhcoreClassChat::extractDepartment([$requestPayload['dep_id']]);
    $requestPayload['dep_id'] = !empty($parametersDepartment['system']) ? $parametersDepartment['system'][0] : $requestPayload['dep_id'];
}

// If country still unknown detect it directly
if (empty($country)) {
    $onlineUser = new erLhcoreClassModelChatOnlineUser();
    $onlineUser->ip = erLhcoreClassIPDetect::getIP();
    erLhcoreClassModelChatOnlineUser::detectLocation($onlineUser);
    $country = strtolower($onlineUser->user_country_code);
}

$twelfthFormatCountries = ['us', 'gb', 'ph', 'ca', 'au', 'nz', 'in', 'eg', 'sa', 'co', 'pk', 'my','mx','ie','ni','hn','sv','jo','bd'];
$requestPayload['12h'] = in_array($country,$twelfthFormatCountries);

$item = new erLhcoreClassModelCBSchedulerReservation();

$outputResponse = [];

try {
    $errors = erLhcoreClassCBSchedulerValidation::validateSchedule($item, $requestPayload);

    $cbOptions = erLhcoreClassModelChatConfig::fetch('lhcbscheduler_options');

    $data = (array)$cbOptions->data;

    if (isset($data['maintenance_mode']) && $data['maintenance_mode'] != '') {
        $errors['maintenance_mode'] = $data['maintenance_mode'];
    }

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
        erLhcoreClassRestAPIHandler::outputResponse(['error' => true, 'messages' => $errors, 'code' => 0]);
        exit;
    }

} catch (Exception $e) {
    erLhcoreClassRestAPIHandler::outputResponse(['error' => true, 'message' => $e->getMessage(), 'code' => $e->getCode()]);
    exit;
}

erLhcoreClassRestAPIHandler::outputResponse($outputResponse);

exit;

?>