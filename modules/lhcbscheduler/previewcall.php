<?php

$tpl = erLhcoreClassTemplate::getInstance('lhcbscheduler/previewcall.tpl.php');

$item =  erLhcoreClassModelCBSchedulerReservation::fetch($Params['user_parameters']['id']);

$tpl->setArray(array(
    'item' => $item,
));

echo $tpl->fetch();
exit;
?>