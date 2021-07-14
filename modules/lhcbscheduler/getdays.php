<?php

erLhcoreClassRestAPIHandler::setHeaders();

// Detect country
$defaultCountry = null;
$username = null;
$email = null;
$department = (is_numeric($Params['user_parameters_unordered']['department']) && $Params['user_parameters_unordered']['department'] > 0 ? (int)$Params['user_parameters_unordered']['department'] : null);

if (is_numeric($Params['user_parameters_unordered']['chat']) && ($chat = erLhcoreClassModelChat::fetch($Params['user_parameters_unordered']['chat'])) instanceof erLhcoreClassModelChat && $chat->country_code != '') {
    $defaultCountry = strtoupper($chat->country_code);
} elseif ($Params['user_parameters_unordered']['vid'] !== 'null' && ($vid = erLhcoreClassModelChatOnlineUser::fetchByVid($Params['user_parameters_unordered']['vid'])) instanceof erLhcoreClassModelChatOnlineUser && $vid->user_country_code != '') {
    $defaultCountry = strtoupper($vid->user_country_code);
} else {

    $ou = new erLhcoreClassModelChatOnlineUser();
    $ou->ip = erLhcoreClassIPDetect::getIP();

    erLhcoreClassModelChatOnlineUser::detectLocation($ou);

    if ($ou->user_country_code != '') {
        $defaultCountry = strtoupper($ou->user_country_code);
    }
}

if (isset($chat) && $chat instanceof erLhcoreClassModelChat) {

    if ($chat->nick != 'Visitor') {
        $username = $chat->nick;
    }

    if ($chat->email != '') {
        $email = $chat->email;
    }

    if ($department === null) {
        $department = $chat->dep_id;
    }
}

// @todo detect first department

$logo = null;

$callDays = erLhcoreClassCBSchedulerValidation::getCallDays([
    'tz' => ((isset($_GET['tz']) && $_GET['tz'] != 'undefined') ? $_GET['tz'] : 'UTC'),
    'department' => $department
]);

// Theme for a logo
if (is_numeric($Params['user_parameters_unordered']['theme']) && ($theme = erLhAbstractModelWidgetTheme::fetch($Params['user_parameters_unordered']['theme'])) instanceof erLhAbstractModelWidgetTheme) {
    if ($theme->logo_image_url !== false) {
        $logo = $theme->logo_image_url;
    } elseif ($theme->operator_image_url !== false) {
        $logo = $theme->operator_image_url;
    }
} else {
    $logo =  '//' . $_SERVER['HTTP_HOST'] . erLhcoreClassDesign::design('images/general/logo_user.png');
}


$responseArray = [
    'days' => $callDays,
    'default_country' => $defaultCountry,
    'logo' => $logo,
    'department' => $department,
    'username' => $username,
    'email' => $email,
];

$cbOptions = erLhcoreClassModelChatConfig::fetch('lhcbscheduler_options');
$data = (array)$cbOptions->data;

if (isset($data['terms_of_service']) && $data['terms_of_service'] != '') {
    $responseArray['terms_of_service'] = $data['terms_of_service'];
}

if (is_numeric($department)) {
    $allowArray = [];
    if (isset($data['allow_countries']) && !empty($data['allow_countries'])) {
        $pairs = explode("\n",trim(strtoupper($data['allow_countries'])));
        foreach ($pairs as $pair) {
            $options = explode(",", str_replace(' ','',$pair));
            $allowArray[array_shift($options)] = $options;
        }
    }

    $excludeArray = [];
    if (isset($data['exclude_countries']) && !empty($data['exclude_countries'])) {
        $pairs = explode("\n",trim(strtoupper($data['exclude_countries'])));
        foreach ($pairs as $pair) {
            $options = explode(",", str_replace(' ','',$pair));
            $excludeArray[array_shift($options)] = $options;
        }
    }

    if (!empty($allowArray) && isset($allowArray[$department])) {
        $responseArray['countries'] = $allowArray[$department];
    } elseif (!empty($excludeArray) && isset($excludeArray[$department])) {
        $countriesJSON = json_decode(file_get_contents('extension/cbscheduler/doc/countries.json'),true);
        $responseArray['countries'] = array_values(array_diff(array_keys($countriesJSON),$excludeArray[$department]));
    }
}

echo json_encode($responseArray);

exit;
?>