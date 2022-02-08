<?php

if (
    (is_numeric($Params['user_parameters_unordered']['dep_id']) && $Params['user_parameters_unordered']['dep_id'] > 0) ||
    (is_numeric($Params['user_parameters_unordered']['call_id']) && $Params['user_parameters_unordered']['call_id'] > 0)
) {

    $tpl = erLhcoreClassTemplate::getInstance('lhcbscheduler/parts/online_operators.tpl.php');

    $userFilter = '';
    $userOriginal = 0;
    if (is_numeric($Params['user_parameters_unordered']['call_id'])) {
        $call = erLhcoreClassModelCBSchedulerReservation::fetch($Params['user_parameters_unordered']['call_id']);
        $dep_id = $call->dep_id;
        $userOriginal = $call->user_id;
        $userFilter = ' AND `lh_userdep`.`user_id` != :user_id ';
        $tpl->set('reservation',$call);
    } else {
        $dep_id = $Params['user_parameters_unordered']['dep_id'];
    }

    $cbOptions = erLhcoreClassModelChatConfig::fetch('lhcbscheduler_options');
    $data = (array)$cbOptions->data;

    $timeoutSeconds = isset($data['auto_assign_timeout']) && $data['auto_assign_timeout'] > 0 ? (int)$data['auto_assign_timeout'] : 15;
    $callInSeconds =  isset($data['call_in_minutes']) && $data['call_in_minutes'] > 0 ? (int)$data['call_in_minutes'] * 60 : 10*60;

    $tpl->set('timeoutSeconds', $timeoutSeconds);
    $tpl->set('callInSeconds', $callInSeconds);

    $isOnlineUser = (int)erLhcoreClassModelChatConfig::fetch('sync_sound_settings')->data['online_timeout'];

    $db = ezcDbInstance::get();
    $sql = "SELECT `lh_userdep`.*, `lhc_cbscheduler_phone_mode`.`last_accepted` AS `last_accepted_call` FROM `lh_userdep`
                            INNER JOIN lhc_cbscheduler_phone_mode ON `lhc_cbscheduler_phone_mode`.`user_id` = `lh_userdep`.`user_id` 
                            WHERE 
                              lhc_cbscheduler_phone_mode.last_accepted < :last_accepted 
                              AND lhc_cbscheduler_phone_mode.on_phone = 1 
                              AND `lh_userdep`.`dep_id` = :dep_id 
                              {$userFilter}
                              AND (`lh_userdep`.`last_activity` > :last_activity OR `lh_userdep`.`always_on` = 1) 
                              ORDER BY `lhc_cbscheduler_phone_mode`.`last_accepted` ASC LIMIT 50";

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':dep_id', $dep_id, PDO::PARAM_INT);
    $stmt->bindValue(':last_activity', (time() - $isOnlineUser),PDO::PARAM_INT);
    $stmt->bindValue(':last_accepted', (time() - 7),PDO::PARAM_INT);
    if ($userFilter != '') {
        $stmt->bindValue(':user_id', $userOriginal,PDO::PARAM_INT);
    }
    $stmt->execute();

    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $db->prepare('SELECT `lhc_cbscheduler_reservation`.`user_id` FROM `lhc_cbscheduler_reservation` WHERE status = 0');
    $stmt->execute();
    $itemsUser = $stmt->fetchAll(PDO::FETCH_COLUMN);

    foreach ($items as $index => $item) {
        $items[$index]['slot_taken'] = in_array($item['user_id'], $itemsUser);
    }

    $tpl->setArray(array(
        'items' => $items,
        'online_timeout' => $isOnlineUser
    ));

    echo $tpl->fetch();
    exit;
}

$tpl = erLhcoreClassTemplate::getInstance('lhcbscheduler/onlineoperators.tpl.php');

echo $tpl->fetch();
exit;


?>