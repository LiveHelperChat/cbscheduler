<?php

erLhcoreClassRestAPIHandler::setHeaders();

// If department is not passed take it from chat
$country = '';
if (is_numeric($Params['user_parameters_unordered']['chat']) && (!is_numeric($Params['user_parameters_unordered']['department']) || $Params['user_parameters_unordered']['department'] == 0)) {
    $chat = erLhcoreClassModelChat::fetch($Params['user_parameters_unordered']['chat']);
    if ($chat instanceof erLhcoreClassModelChat) {
        $Params['user_parameters_unordered']['department'] = $chat->dep_id;
        $country = $chat->country_code;
    }
}

if (isset($Params['user_parameters_unordered']['department']) && $Params['user_parameters_unordered']['department'] != '' && !is_numeric($Params['user_parameters_unordered']['department'])) {
    $parametersDepartment = erLhcoreClassChat::extractDepartment([$Params['user_parameters_unordered']['department']]);
    $Params['user_parameters_unordered']['department'] = !empty($parametersDepartment['system']) ? $parametersDepartment['system'][0] : null;
}

// If country still unknown detect it directly
if (empty($country)) {
    $onlineUser = new erLhcoreClassModelChatOnlineUser();
    $onlineUser->ip = erLhcoreClassIPDetect::getIP();
    erLhcoreClassModelChatOnlineUser::detectLocation($onlineUser);
    $country = strtolower($onlineUser->user_country_code);
}

$twelfthFormatCountries = ['us', 'gb', 'ph', 'ca', 'au', 'nz', 'in', 'eg', 'sa', 'co', 'pk', 'my','mx','ie','ni','hn','sv','jo','bd'];

$callDays = erLhcoreClassCBSchedulerValidation::getCallTimes([
    'department' => (is_numeric($Params['user_parameters_unordered']['department']) ? (int)$Params['user_parameters_unordered']['department'] : null),
    'day' => (is_numeric($Params['user_parameters']['day']) ? (int)$Params['user_parameters']['day'] : null),
    'tz' => ((isset($_GET['tz']) && $_GET['tz'] != 'undefined') ? $_GET['tz'] : 'UTC'),
    '12h' => in_array($country,$twelfthFormatCountries)
]);

echo json_encode($callDays);

exit;
?>