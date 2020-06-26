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
    'tz' => $_GET['tz'],
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

echo json_encode([
    'days' => $callDays,
    'default_country' => $defaultCountry,
    'logo' => $logo,
    'department' => $department,
    'username' => $username,
    'email' => $email,
]);

exit;
?>