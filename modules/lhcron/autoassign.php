<?php
/**
 * php cron.php -s site_admin -e cbscheduler -c cron/autoassign
 * */

$filter = array('sort' => 'cb_time_start ASC');

$filter['filter'] = array(
    'status' => erLhcoreClassModelCBSchedulerReservation::STATUS_SCHEDULED,
    'user_id' => erLhcoreClassUser::instance()->getUserID()
);

$cbOptions = erLhcoreClassModelChatConfig::fetch('lhcbscheduler_options');
$data = (array)$cbOptions->data;

$timeoutSeconds = isset($data['auto_assign_timeout']) && $data['auto_assign_timeout'] > 0 ? (int)$data['auto_assign_timeout'] : 15;
$callInSeconds =  isset($data['call_in_minutes']) && $data['call_in_minutes'] > 0 ? (int)$data['call_in_minutes'] * 60 : 10*60;

$isOnlineUser = (int)erLhcoreClassModelChatConfig::fetch('sync_sound_settings')->data['online_timeout'];

$db = ezcDbInstance::get();

foreach (erLhcoreClassModelCBSchedulerReservation::getList([
    'sort' => 'cb_time_start ASC',
    'filterlt' => ['cb_time_start' => (time()+$callInSeconds)],
    'filternot' => ['status_accept' => erLhcoreClassModelCBSchedulerReservation::CALL_ACCEPTED],
    'filter' => ['status' => erLhcoreClassModelCBSchedulerReservation::STATUS_SCHEDULED]
    ]) as $reservation) {

    $db->beginTransaction();

    // Lock record
    $reservation->syncAndLock();

    // Main check
    if ($reservation->user_id == 0 || (time() - $reservation->tslasign) > $timeoutSeconds) {

        $userOriginal = $reservation->user_id;

        // Reset user
        $reservation->user_id = 0;
        $reservation->updateThis(['update' => ['user_id']]);

        // All users who are in phone mode
        // And does not have assigned chat
        $sql = "SELECT `lh_userdep`.`user_id` FROM `lh_userdep` 
                            INNER JOIN lhc_cbscheduler_phone_mode ON `lhc_cbscheduler_phone_mode`.`user_id` = `lh_userdep`.`user_id` 
                            WHERE 
                              lhc_cbscheduler_phone_mode.last_accepted < :last_accepted 
                              AND ro = 0 
                              AND hide_online = 1
                              AND lhc_cbscheduler_phone_mode.on_phone = 1 
                              AND `lh_userdep`.`dep_id` = :dep_id 
                              AND (`lh_userdep`.`last_activity` > :last_activity OR `lh_userdep`.`always_on` = 1) 
                              AND `lh_userdep`.`user_id` != :user_id 
                              AND `lh_userdep`.`user_id` NOT IN (SELECT `sq`.`user_id` FROM (SELECT `lhc_cbscheduler_reservation`.`user_id` FROM `lhc_cbscheduler_reservation` WHERE status = 0) as `sq`)
                              ORDER BY `lhc_cbscheduler_phone_mode`.`last_accepted` ASC LIMIT 1";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':dep_id', $reservation->dep_id,PDO::PARAM_INT);
        $stmt->bindValue(':last_activity', (time() - $isOnlineUser),PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $userOriginal,PDO::PARAM_INT);
        $stmt->bindValue(':last_accepted', (time() - 7),PDO::PARAM_INT);
        $stmt->execute();

        $user_id = $stmt->fetchColumn();

        if (is_numeric($user_id)) {
            $reservation->user_id = $user_id;
            $reservation->tslasign = time();
            $reservation->updateThis(['update' => ['user_id','tslasign']]);

            $sql = "UPDATE lhc_cbscheduler_phone_mode SET last_accepted = :last_accepted WHERE user_id = :user_id";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':last_accepted', time(),PDO::PARAM_INT);
            $stmt->bindValue(':user_id', $user_id,PDO::PARAM_INT);
            $stmt->execute();

            echo "Assigned user [" . $user_id . "] to ".$reservation->id,"\n";
        }
    }

    $db->commit();

}