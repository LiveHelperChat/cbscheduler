<?php

$tpl = erLhcoreClassTemplate::getInstance('lhcbscheduler/assigntome.tpl.php');

$item =  erLhcoreClassModelCBSchedulerReservation::fetch($Params['user_parameters']['id']);
$item->user_id = erLhcoreClassUser::instance()->getUserID();
$item->updateThis();

$tpl->set('item',$item);

echo $tpl->fetch();
exit;

?>