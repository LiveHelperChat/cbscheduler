<?php

erLhcoreClassRestAPIHandler::setHeaders();

$callDays = erLhcoreClassCBSchedulerValidation::getCallTimes([
    'department' => (is_numeric($Params['user_parameters_unordered']['department']) ? (int)$Params['user_parameters_unordered']['department'] : null),
    'day' => (is_numeric($Params['user_parameters']['day']) ? (int)$Params['user_parameters']['day'] : null),
    'tz' => $_GET['tz'],
]);

echo json_encode($callDays);

exit;
?>