<?php

$tpl = erLhcoreClassTemplate::getInstance('lhcbscheduler/assigntome.tpl.php');

$item =  erLhcoreClassModelCBSchedulerReservation::fetch($Params['user_parameters']['id']);
$item->user_id = $Params['user_parameters_unordered']['action'] == 'unassign' ? 0 : erLhcoreClassUser::instance()->getUserID();

if ($Params['user_parameters_unordered']['action'] == 'unassign') {
    $item->status_accept = erLhcoreClassModelCBSchedulerReservation::PENDING_ACCEPT;
} else {
    $item->status_accept = erLhcoreClassModelCBSchedulerReservation::CALL_ACCEPTED;
}

$item->updateThis();

$tpl->set('item',$item);

echo $tpl->fetch();
exit;

?>