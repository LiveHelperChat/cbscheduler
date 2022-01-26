<?php

header('content-type: application/json; charset=utf-8');

if (!isset($_SERVER['HTTP_X_CSRFTOKEN']) || !$currentUser->validateCSFRToken($_SERVER['HTTP_X_CSRFTOKEN'])) {
    die('Invalid CSRF Token');
}

if (is_numeric($Params['user_parameters']['user_id']) && $Params['user_parameters']['user_id'] > 0) {
    $user = erLhcoreClassModelUser::fetch($Params['user_parameters']['user_id']);
    if (!($user instanceof erLhcoreClassModelUser) || !erLhcoreClassUser::instance()->hasAccessTo('lhcbscheduler','change_phone_mode')) {
        exit;
    }

    $instance = erLhcoreClassModelCBSchedulerPhoneMode::getInstance($Params['user_parameters']['user_id']);
} else {
    $instance = erLhcoreClassModelCBSchedulerPhoneMode::getInstance($currentUser->getUserID());
}


$instance->on_phone = $Params['user_parameters']['status'] == 1 ? 1 : 0;
$instance->updateThis();

exit;

?>