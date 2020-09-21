<?php

erLhcoreClassRestAPIHandler::setHeaders();

// If department is not passed take it from chat
if (is_numeric($Params['user_parameters_unordered']['chat']) && (!is_numeric($Params['user_parameters_unordered']['department']) || $Params['user_parameters_unordered']['department'] == 0)) {
    $chat = erLhcoreClassModelChat::fetch($Params['user_parameters_unordered']['chat']);
    $Params['user_parameters_unordered']['department'] = $chat->dep_id;
}

$callDays = erLhcoreClassCBSchedulerValidation::getCallTimes([
    'department' => (is_numeric($Params['user_parameters_unordered']['department']) ? (int)$Params['user_parameters_unordered']['department'] : null),
    'day' => (is_numeric($Params['user_parameters']['day']) ? (int)$Params['user_parameters']['day'] : null),
    'tz' => $_GET['tz'],
]);

echo json_encode($callDays);

exit;
?>