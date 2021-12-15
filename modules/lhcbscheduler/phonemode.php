<?php

header('content-type: application/json; charset=utf-8');

if (!isset($_SERVER['HTTP_X_CSRFTOKEN']) || !$currentUser->validateCSFRToken($_SERVER['HTTP_X_CSRFTOKEN'])) {
    die('Invalid CSRF Token');
}

$instance = erLhcoreClassModelCBSchedulerPhoneMode::getInstance($currentUser->getUserID());
$instance->on_phone = $Params['user_parameters']['status'] == 1 ? 1 : 0;
$instance->updateThis();

exit;

?>