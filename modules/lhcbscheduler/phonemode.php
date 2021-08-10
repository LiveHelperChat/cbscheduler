<?php

header('content-type: application/json; charset=utf-8');

$instance = erLhcoreClassModelCBSchedulerPhoneMode::getInstance($currentUser->getUserID());
$instance->on_phone = $Params['user_parameters']['status'] == 1 ? 1 : 0;
$instance->updateThis();

exit;

?>