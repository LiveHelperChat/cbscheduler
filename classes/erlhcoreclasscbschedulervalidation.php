<?php

class erLhcoreClassCBSchedulerValidation
{

    public static function validateCBSubject($item) {
        $definition = array(
            'name' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
            ),
            'pos' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'int', array( 'min_range' => 0)
            ),
            'active' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'boolean'
            ),
        );

        $form = new ezcInputForm( INPUT_POST, $definition );
        $Errors = array();

        if ( $form->hasValidData( 'name' ) && $form->name != '')
        {
            $item->name = $form->name;
        } else {
            $Errors[] =  erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Please enter a name!');
        }

        if ( $form->hasValidData( 'pos' )) {
            $item->pos = $form->pos;
        } else {
            $item->pos = 0;
        }

        if ( $form->hasValidData( 'active' ) && $form->active == true) {
            $item->active = 1;
        } else {
            $item->active = 0;
        }

        return $Errors;
    }

    public static function validateCBSchedule($item)
    {
        $definition = array(
            'name' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
            ),
            'department_ids' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'int', array( 'min_range' => 0), FILTER_REQUIRE_ARRAY
            ),
            'department_group_ids' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'int', array( 'min_range' => 0), FILTER_REQUIRE_ARRAY
            ),
            'UserTimeZone' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
            ),
            'StartTime' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw', null, FILTER_REQUIRE_ARRAY
            ),
            'EndTime' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw', null, FILTER_REQUIRE_ARRAY
            ),
            'MaxCalls' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw', null, FILTER_REQUIRE_ARRAY
            ),
            'idTableItem' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw', null, FILTER_REQUIRE_ARRAY
            ),
            'active' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'boolean'
            ),
        );

        $form = new ezcInputForm( INPUT_POST, $definition );
        $Errors = array();

        if ( $form->hasValidData( 'name' ) && $form->name != '') {
            $item->name = $form->name;
        } else {
            $Errors[] =  erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Please enter a schedule name!');
        }

        if ( $form->hasValidData( 'active' ) && $form->active == true) {
            $item->active = 1;
        } else {
            $item->active = 0;
        }

        if ( $form->hasValidData( 'UserTimeZone' ) && $form->UserTimeZone != '')
        {
            $item->tz = $form->UserTimeZone;
        } else {
            $Errors[] = erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Please choose a time zone!');
        }

        if ($form->hasValidData( 'department_ids') && !empty($form->department_ids)) {
            $item->department_ids = $form->department_ids;
        } else {
            $item->department_ids = [];
        }

        if ($form->hasValidData( 'department_group_ids') && !empty($form->department_group_ids)) {
            $item->department_group_ids = $form->department_group_ids;
        } else {
            $item->department_group_ids = [];
        }

        $slotItems = array();

        if ($form->hasValidData( 'idTableItem' ) && !empty($form->idTableItem)) {

            foreach ($form->idTableItem as $dayId => $dayItems) {
                foreach ($dayItems as $dayIndex => $dayItem) {

                    $startTimeData = explode(':', $form->StartTime[$dayId][$dayIndex]);
                    $endTimeData = explode(':', $form->EndTime[$dayId][$dayIndex]);

                    $itemSlot = new erLhcoreClassModelCBSchedulerSlot();
                    $itemSlot->time_start_h = $startTimeData[0];
                    $itemSlot->time_start_m = $startTimeData[1];
                    $itemSlot->time_end_h = $endTimeData[0];
                    $itemSlot->time_end_m = $endTimeData[1];
                    $itemSlot->max_calls = $form->MaxCalls[$dayId][$dayIndex];
                    $itemSlot->day = $dayId;

                    // Keep old id
                    if (is_numeric($dayItem)) {
                        $itemSlot->id = $dayItem;
                    }

                    $slotItems[] = $itemSlot;
                }
            }
        }

        $item->slots = $slotItems;

        return $Errors;
    }

    public static function setTimezone($tz) {
        if (isset($tz) && is_numeric($tz)) {
            $timezone_name = timezone_name_from_abbr(null, (int)$tz * 3600, true);
            if ($timezone_name !== false) {
                $tzSet = $timezone_name;
            }
        } elseif (isset($tz) && erLhcoreClassChatValidator::isValidTimezoneId2($tz)) {
            $tzSet = $tz;
        }

        if ( isset($tzSet) ) {
            erLhcoreClassModule::$defaultTimeZone = $tzSet;
            date_default_timezone_set(erLhcoreClassModule::$defaultTimeZone);
        }
    }

    public static function getCallDays($params) {

        self::setTimezone($params['tz']);

        $weekDays = self::weekDays();

        // Check is it blocked phone number
        $cbOptions = erLhcoreClassModelChatConfig::fetch('lhcbscheduler_options');

        $data = (array)$cbOptions->data;

        $daysLimit = 14;

        if (isset($data['days_upfront']) && is_numeric($data['days_upfront']) && (int)$data['days_upfront'] > 0 && (int)$data['days_upfront'] < 100) {
            $daysLimit = (int)$data['days_upfront'];
        }

        $schedule = erLhcoreClassModelCBSchedulerSchedulerDep::findOne(array('filter' => array('dep_id' => $params['department'])));

        $days = array();

        if ($schedule instanceof erLhcoreClassModelCBSchedulerSchedulerDep) {
            $schedulerItem = erLhcoreClassModelCBSchedulerScheduler::fetch($schedule->schedule_id);
            if ($schedulerItem->active == 1) {

                $scheduleDate = new DateTime('now', new DateTimeZone($schedulerItem->tz));
                $scheduleCompare = new DateTime('now', new DateTimeZone($schedulerItem->tz));

                for ($i = 0; $i < $daysLimit; $i++) {

                    $ts = time() + ($i * 24 * 3600);

                    $scheduleDate->setTimestamp($ts);

                    $slots = erLhcoreClassModelCBSchedulerSlot::getList(['filter' => ['schedule_id' => $schedulerItem->id, 'day' => $scheduleDate->format('N')]]);

                    // Are we working with current day
                    $currentDay = $scheduleCompare->format('Ymd') == $scheduleDate->format('Ymd');

                    $hasSlots = false;
                    foreach ($slots as $slot) {
                        if (
                            erLhcoreClassModelCBSchedulerReservation::getCount(['filter' => ['slot_id' => $slot->id, 'daytime' => $scheduleDate->format('Ymd')]]) < $slot->max_calls &&
                            ($currentDay == false || (
                                 ($slot->time_start_h > $scheduleCompare->format('H')) ||
                                 ($slot->time_start_m > $scheduleCompare->format('i') && $slot->time_start_h == $scheduleCompare->format('H'))
                                ) )
                        ) {
                            $hasSlots = true;
                            break;
                        }
                    }

                    if ($hasSlots === true) {
                        $item = new stdClass();
                        $item->id = date('Ymd',$ts);

                        if ($i == 0) {
                            $item->name = erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Today');
                        } elseif ($i == 1) {
                            $item->name = erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Tomorrow');
                        } elseif ($i >= 2 && $i <= 6) {
                            $item->name = $weekDays[date('N',$ts)];
                        } else {
                            $item->name = $weekDays[date('N',$ts)] . ' [' . date('Y-m-d',$ts) . ']';
                        }

                        $days[] = $item;
                    }
                }
            }
        }

        return $days;
    }

    public static function getCallTimes($params) {

        self::setTimezone($params['tz']);

        $schedule = erLhcoreClassModelCBSchedulerSchedulerDep::findOne(array('filter' => array('dep_id' => $params['department'])));

        $times = array();

        if ($schedule instanceof erLhcoreClassModelCBSchedulerSchedulerDep) {
            $schedulerItem = erLhcoreClassModelCBSchedulerScheduler::fetch($schedule->schedule_id);
            if ($schedulerItem->active == 1) {

                $daySelected = array();

                $daySelected['y'] = substr($params['day'],0,4);
                $daySelected['m'] = substr($params['day'],4,2);
                $daySelected['d'] = substr($params['day'],6,2);

                // We need to convert visitor week day to schedule week day.
                $scheduleDate = new DateTime('now', new DateTimeZone($params['tz']));
                $scheduleDate->setTimestamp(mktime(date('H'), date('i'), date('s'), $daySelected['m'], $daySelected['d'], $daySelected['y']));
                $scheduleDate->setTimezone(new DateTimeZone($schedulerItem->tz));

                // Schedule present day
                $scheduleCompare = new DateTime('now', new DateTimeZone($schedulerItem->tz));

                // Are we working with current day
                $currentDay = $scheduleCompare->format('Ymd') == $scheduleDate->format('Ymd');

                // Visitor selected day in schedule time zone
                $scheduleDaySelected = new DateTime('now', new DateTimeZone($schedulerItem->tz));
                $scheduleDaySelected->setTimestamp($scheduleDate->getTimestamp());

                $slots = erLhcoreClassModelCBSchedulerSlot::getList(['sort' => 'time_start_h ASC, time_start_m ASC', 'filter' => ['active' => 1, 'day' => $scheduleDate->format('N'), 'schedule_id' => $schedulerItem->id]]);

                foreach ($slots as $slot) {

                    if ( ($slot->time_start_h < $scheduleCompare->format('H') && $currentDay == true) ||
                        ($slot->time_start_m < $scheduleCompare->format('i') && $currentDay == true && $slot->time_start_h == $scheduleCompare->format('H')) ||
                        erLhcoreClassModelCBSchedulerReservation::getCount(['filter' => ['slot_id' => $slot->id, 'daytime' => $scheduleDaySelected->format('Ymd')]]) >= $slot->max_calls
                    ) {
                        continue;
                    }

                    /*
                     * Start time manipulations
                     * */

                    // Switch to schedule Time Zone
                    $scheduleDate->setTimezone(new DateTimeZone($schedulerItem->tz));

                    // We need to convert schedule star/end time to user time zone start end time.
                    $scheduleDate->setTime($slot->time_start_h, $slot->time_start_m);

                    // Switch to user Time Zone
                    $scheduleDate->setTimezone(new DateTimeZone($params['tz']));

                    $slotTimeStart = $scheduleDate->format('H:i');

                    /*
                     * End time manipulations
                     * */

                    // Switch to schedule Time Zone
                    $scheduleDate->setTimezone(new DateTimeZone($schedulerItem->tz));

                    // We need to convert schedule star/end time to user time zone start end time.
                    $scheduleDate->setTime($slot->time_end_h, $slot->time_end_m);

                    // Switch to user Time Zone
                    $scheduleDate->setTimezone(new DateTimeZone($params['tz']));

                    $slotTimeEnd = $scheduleDate->format('H:i');

                    $times[] = ['id' => $slot->id, 'name' => $slotTimeStart . ' - ' . $slotTimeEnd];
                }
            }
        }

        return $times;
    }

    public static function validateCBEditReservation($item) {
        $definition = array(
            'status' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'int', array( 'min_range' => 0, 'max_range' => 1)
            ),
            'outcome' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
            )
        );

        $form = new ezcInputForm( INPUT_POST, $definition );
        $Errors = array();

        if ( $form->hasValidData( 'status' ) ) {
            $item->status = $form->status;
        }

        if ( $form->hasValidData( 'outcome' ) ) {
            $item->outcome = $form->outcome;
        }

        return $Errors;
    }

    public static function isBlocked($phone) {

        $phone = str_replace('+','',$phone);

        // Check is it blocked phone number
        $cbOptions = erLhcoreClassModelChatConfig::fetch('lhcbscheduler_options');

        $data = (array)$cbOptions->data;

        if (isset($data['block_numbers']) && trim($data['block_numbers']) != '') {
            $numbers = explode(',',$data['block_numbers']);
            foreach ($numbers as $number) {
                $number = trim($number);
                if (strpos($number,'*') === false && $number == $phone) {
                    return true;
                } else if (strpos($number,'*') !== false) {
                    $number = str_replace('*','', $number);
                    if (preg_match('/' . $number . '.*/',$phone)) {
                        return true;
                    }
                }
            }
        }

        if (isset($data['allow_numbers']) && trim($data['allow_numbers']) != '') {
            $numbers = explode(',',$data['allow_numbers']);
            foreach ($numbers as $number) {
                $number = trim($number);
                if (strpos($number,'*') === false && $number == $phone) {
                    return false;
                } else if (strpos($number,'*') !== false) {
                    $number = str_replace('*','', $number);
                    if (preg_match('/' . $number . '.*/',$phone)) {
                        return false;
                    }
                }
            }
            return true;
        }

        return false;
    }

    public static function validateSchedule($item, $params) {

        $definition = array(
            'dep_id' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'int', array('min_range' => 1)
            ),
            'description' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
            ),
            'email' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'validate_email'
            ),
            'phone' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
            ),
            'subject' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'int', array('min_range' => 1)
            ),
            'timezone' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
            ),
            'username' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
            ),
            'day' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'int', array('min_range' => 1)
            ),
            'time' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'int', array('min_range' => 1)
            ),
            'chat_id' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'int', array('min_range' => 1)
            ),
            'attempt' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'int', array('min_range' => 0)
            )
        );

        $Errors = array();

        $form = new erLhcoreClassInputForm(INPUT_GET, $definition, null, $params);

        if ( !$form->hasValidData( 'email' ) ) {
            $Errors['email'] = erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Please enter a valid email address');
        } elseif ($form->hasValidData( 'email' )) {
            $item->email = $form->email;
        }

        if ( $form->hasValidData( 'attempt' ) ) {
            $item->attempt = $form->attempt;
        }

        if ( !$form->hasValidData( 'username' ) || $form->username == '' ) {
            $Errors['username'] = erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Please enter a username');
        } elseif ($form->hasValidData( 'username' )) {
            $item->name = $form->username;
        }

        if ( $form->hasValidData( 'chat_id' )) {
            $item->chat_id = $form->chat_id;
        }

        if ( !$form->hasValidData( 'subject' ) ) {
            $Errors['subject'] = erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Please choose a subject');
        } elseif ($form->hasValidData( 'subject' )) {
            $item->subject_id = $form->subject;
        }

        if ( !$form->hasValidData( 'dep_id' ) ) {
            throw new Exception(erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Department is missing'));
        } elseif ($form->hasValidData( 'dep_id' )) {
            $item->dep_id = $form->dep_id;
        }

        if ( !$form->hasValidData( 'phone' ) || $form->phone == '' ) {
            $Errors['phone'] = erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Please enter a phone');
        } elseif ($form->hasValidData( 'phone' )) {

            // We need to check is there any scheduled calls for this phone number

            $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();

            try {
                $cbNumberProto = $phoneUtil->parse($form->phone);

                if ($phoneUtil->isValidNumber($cbNumberProto)) {

                    $item->phone = $phoneUtil->format($cbNumberProto, \libphonenumber\PhoneNumberFormat::E164);

                    $item->region = $phoneUtil->getRegionCodeForNumber($cbNumberProto);

                    if (self::isBlocked($item->phone)) {
                        $Errors['phone'] = erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Invalid phone number!');
                    }

                } else {
                    $Errors['phone'] = erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Your phone number does not look as valid phone number!');
                }

            } catch (\libphonenumber\NumberParseException $e) {
                $Errors['phone'] = $e->getMessage();
            }
        }

        if ( !$form->hasValidData( 'description' ) || $form->description == '' ) {
            $Errors['description'] = erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Please enter a description');
        } elseif ($form->hasValidData( 'description' )) {
            $item->description = $form->description;
        }

        if ( $form->hasValidData( 'timezone' ) ) {
            $item->tz = $form->timezone;
            self::setTimezone($item->tz);
        }

        if ( !$form->hasValidData( 'day' ) ) {
            $Errors['day'] = erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Please choose a day');
        } elseif ($form->hasValidData( 'day' )) {
            $item->day = $form->day;
        }

        if (!isset($Errors['day']))
        {
            if ( !$form->hasValidData( 'time' ) ) {
                $Errors['time'] = erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Please choose a time');
            } elseif ($form->hasValidData( 'time' )) {
                $item->slot_id = $form->time;
            }
        }

        // Both fields were selected
        if (!isset($Errors['time']) && !isset($Errors['day']) && !isset($Errors['phone'])) {

            $schedule = erLhcoreClassModelCBSchedulerSchedulerDep::findOne(array('filter' => array('dep_id' => $item->dep_id)));

            if ($schedule instanceof erLhcoreClassModelCBSchedulerSchedulerDep) {

                $schedulerItem = erLhcoreClassModelCBSchedulerScheduler::fetch($schedule->schedule_id);

                if ($schedulerItem->active == 1) {

                    $item->schedule_id = $schedulerItem->id;

                    // Check is there any scheduled call already
                    if (erLhcoreClassModelCBSchedulerReservation::getCount(['filter' => ['phone' => $item->phone, 'status' => 0, 'schedule_id' => $item->schedule_id, 'dep_id' => $item->dep_id]]) > 0) {
                        throw new Exception(erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','You already have a scheduled call!'));
                    }

                    $daySelected = array();

                    $daySelected['y'] = substr($item->day,0,4);
                    $daySelected['m'] = substr($item->day,4,2);
                    $daySelected['d'] = substr($item->day,6,2);

                    // We need to convert visitor week day to schedule week day.
                    $scheduleDate = new DateTime('now', new DateTimeZone($item->tz));
                    $scheduleDate->setTimestamp(mktime(date('H'), date('i'), date('s'), $daySelected['m'], $daySelected['d'], $daySelected['y']));
                    $scheduleDate->setTimezone(new DateTimeZone($schedulerItem->tz));

                    $slot = erLhcoreClassModelCBSchedulerSlot::findOne(['filter' => ['id'=> $item->slot_id, 'active' => 1, 'day' => $scheduleDate->format('N'), 'schedule_id' => $schedulerItem->id]]);

                    // Schedule present day
                    $scheduleCompare = new DateTime('now', new DateTimeZone($schedulerItem->tz));

                    // Are we working with current day
                    $currentDay = $scheduleCompare->format('Ymd') == $scheduleDate->format('Ymd');

                    // Visitor selected day in schedule time zone
                    $scheduleDaySelected = new DateTime('now', new DateTimeZone($schedulerItem->tz));
                    $scheduleDaySelected->setTimestamp($scheduleDate->getTimestamp());

                    if (!($slot instanceof erLhcoreClassModelCBSchedulerSlot) || ($slot->time_start_h < $scheduleCompare->format('H') && $currentDay == true) ||
                        ($slot->time_start_m < $scheduleCompare->format('i') && $currentDay == true && $slot->time_start_h == $scheduleCompare->format('H')) ||
                        erLhcoreClassModelCBSchedulerReservation::getCount(['filter' => ['slot_id' => $slot->id, 'daytime' => $scheduleDaySelected->format('Ymd')]]) >= $slot->max_calls
                    ) {
                        throw new Exception(erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Slot became unavailable. Please choose another time.'));
                    }

                    $scheduleDate->setTime($slot->time_start_h,$slot->time_start_m);
                    $item->cb_time_start = $scheduleDate->getTimestamp();

                    $scheduleDate->setTime($slot->time_end_h,$slot->time_end_m);
                    $item->cb_time_end = $scheduleDate->getTimestamp();

                    $item->daytime = $scheduleDaySelected->format('Ymd');
                }
            }
        }

        erLhcoreClassChatEventDispatcher::getInstance()->dispatch('cbscheduler.validate_callback', array('item' => & $item, 'errors' => & $Errors));

        return $Errors;
    }

    public static function weekDays() {
        return array(
            1 => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Monday'),
            2 => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Tuesday'),
            3 => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Wednesday'),
            4 => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Thursday'),
            5 => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Friday'),
            6 => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Saturday'),
            7 => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Sunday'),
        );
    }

    public static function getStatusOptions() {
        $options = [];

        $item = new stdClass();
        $item->id = 0;
        $item->name = erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Scheduled');

        $options[] = $item;

        $item = new stdClass();
        $item->id = 1;
        $item->name = erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Completed');

        $options[] = $item;

        return $options;
    }
}

?>