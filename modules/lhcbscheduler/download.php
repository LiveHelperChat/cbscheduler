<?php

$tpl = erLhcoreClassTemplate::getInstance('lhcbscheduler/edit.tpl.php');

$item = erLhcoreClassModelCBSchedulerReservation::fetch($Params['user_parameters']['id']);

if ($item->code == $Params['user_parameters']['code']) {

    header('Content-Type: text/calendar; charset=utf-8');
    header('Content-Disposition: attachment; filename=invite.ics');

    $ics = new ICS(array(
        'dtstart' => gmdate('Y-m-d H:i:s',$item->cb_time_start),
        'dtend' =>  gmdate('Y-m-d H:i:s',$item->cb_time_end),
        'summary' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Your scheduled telephone callback request'),
    ));

    echo $ics->to_string();
    exit;

} else {
    die('Invalid code!');
}

?>