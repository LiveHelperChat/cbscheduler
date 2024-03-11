<?php
#[\AllowDynamicProperties]
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
            'dep_ids' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'int', array( 'min_range' => 1), FILTER_REQUIRE_ARRAY
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

        if ( $form->hasValidData( 'dep_ids' ) ) {
            $item->dep_ids = json_encode($form->dep_ids);
            $item->dep_ids_array = $form->dep_ids;
        } else {
            $item->dep_ids = '';
            $item->dep_ids_array = [];
        }

        return $Errors;
    }

    public static function validateCancelSchedule(& $item, $params)
    {
        $definition = array(
            'dep_id' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'int', array('min_range' => 1)
            ),
            'email' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'validate_email'
            ),
            'phone' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
            ),
            'timezone' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
            ),
            'username' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
            ),
            'chat_id' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'int', array('min_range' => 1)
            )
        );

        $Errors = array();

        $form = new erLhcoreClassInputForm(INPUT_GET, $definition, null, $params);

        if ( !$form->hasValidData( 'email' ) ) {
            $Errors['email'] = erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Please enter a valid email address');
        } elseif ($form->hasValidData( 'email' )) {
            $item->email = strtolower($form->email);
        }

        if ( !$form->hasValidData( 'username' ) || $form->username == '' ) {
            $Errors['username'] = erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Please enter a username');
        } elseif ($form->hasValidData( 'username' )) {
            $item->name = $form->username;
        }

        if ( $form->hasValidData( 'chat_id' )) {
            $item->chat_id = $form->chat_id;
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

        if ( $form->hasValidData( 'timezone' ) ) {
            $item->tz = $form->timezone;
            self::setTimezone($item->tz);
        }

        // Both fields were selected
        if (!isset($Errors['phone'])) {

            // Schedule which was used during scheduling this call
            $schedules = erLhcoreClassModelCBSchedulerSchedulerDep::getList(array('filter' => array('dep_id' => $item->dep_id)));
            $schedulerItem = null;

            foreach ($schedules as $schedule) {
                $schedulerItem = erLhcoreClassModelCBSchedulerScheduler::fetch($schedule->schedule_id);
                if ($schedulerItem->active == 1) {
                    break;
                } else {
                    $schedulerItem = null;
                }
            }

            $filter = ['filter' => ['phone' => $item->phone, 'status' => 0]];

            if ($schedulerItem instanceof erLhcoreClassModelCBSchedulerScheduler && $schedulerItem->multi_department == 1) {
                $filter['filterin']['dep_id'] = erLhcoreClassModelCBSchedulerSchedulerDep::getCount(array('filter' => array('schedule_id' => $schedulerItem->id)), null, 'dep_id', false, false, true, true);
            } else {
                $filter['filter']['dep_id'] = $item->dep_id;
            }

            $cbOptions = erLhcoreClassModelChatConfig::fetch('lhcbscheduler_options');

            $data = (array)$cbOptions->data;

            if (isset($data['unique']) && is_array($data['unique']) && !empty($data['unique'])) {
                $filter = [];

                $filter['filter']['status'] = 0;

                if (in_array('dep_id', $data['unique'])) {
                    if ($schedulerItem instanceof erLhcoreClassModelCBSchedulerScheduler && $schedulerItem->multi_department == 0) {
                        $filter['filter']['dep_id'] = $item->dep_id;
                    } else {
                        $filter['filterin']['dep_id'] = erLhcoreClassModelCBSchedulerSchedulerDep::getCount(array('filter' => array('schedule_id' => $schedulerItem->id)), null, 'dep_id', false, false, true, true);
                    }
                }

                if (in_array('name', $data['unique'])) {
                    $filter['filter']['name'] = $item->name;
                }

                if (in_array('email', $data['unique'])) {
                    $filter['filter']['email'] = $item->email;
                }

                if (in_array('phone', $data['unique'])) {
                    $filter['filter']['phone'] = $item->phone;
                }
            }

            $presentRecord = erLhcoreClassModelCBSchedulerReservation::findOne($filter);

            // Check is there any scheduled call already
            // If it's reschedule just set present id to past ID so all attribute will be overriden
            if ($presentRecord instanceof erLhcoreClassModelCBSchedulerReservation) {

                /*You have already a call scheduled for DD MMM YYYY at HH:MM*/
                $scheduleDate = new DateTime('now', new DateTimeZone($presentRecord->tz));
                $scheduleDate->setTimestamp($presentRecord->cb_time_start);

                if ($params['12h'] && $params['12h'] == true) {
                    $hourStart = $scheduleDate->format('g:i a');
                } else {
                    $hourStart = $scheduleDate->format('H:i');
                }

                $scheduleDate->setTimestamp($presentRecord->cb_time_end);

                if ($params['12h'] && $params['12h'] == true) {
                    $hourEnd = $scheduleDate->format('g:i a');
                } else {
                    $hourEnd = $scheduleDate->format('H:i');
                }

                $presentRecord->cancel_data = [
                    'd' => $scheduleDate->format('d'),
                    'M' => $scheduleDate->format('M'),
                    'Y' => $scheduleDate->format('Y'),
                    'hour_start' => $hourStart,
                    'hour_end' => $hourEnd,
                ];

                $item = $presentRecord;

            } else {
                throw new Exception(erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler', 'We could not find a scheduled call for provided phone number! Please check your phone number and try again.'),100);
            }
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
            'multi_department' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'boolean'
            ),
            'status_configuration' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'int', array( 'min_range' => 0), FILTER_REQUIRE_ARRAY
            ),
        );

        $form = new ezcInputForm( INPUT_POST, $definition );
        $Errors = array();

        if ( $form->hasValidData( 'status_configuration' )) {
            $item->status_configuration = json_encode($form->status_configuration);
            $item->status_configuration_array = $form->status_configuration;
        } else {
            $item->status_configuration = '';
            $item->status_configuration_array = [];
        }

        if ( $form->hasValidData( 'name' ) && $form->name != '') {
            $item->name = $form->name;
        } else {
            $Errors[] =  erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Please enter a schedule name!');
        }

        if ( $form->hasValidData( 'multi_department' ) && $form->multi_department == true) {
            $item->multi_department = 1;
        } else {
            $item->multi_department = 0;
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
                    $itemSlot->max_calls = isset($form->MaxCalls[$dayId][$dayIndex]) ? $form->MaxCalls[$dayId][$dayIndex] : 1;
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
                $tsCompare = $scheduleCompare->getTimestamp();
                $scheduleDateYMDSchedule = $scheduleDate->format('Ymd');

                // This slot goes to next day
                $hasNext = false;

                for ($i = 0; $i < $daysLimit; $i++) {

                    $ts = time() + ($i * 24 * 3600);

                    if ($i == 0 && isset($data['min_time']) && is_numeric($data['min_time']) && (int)$data['min_time'] > 0) {
                        $scheduleCompare->add(new DateInterval('P0Y0M0DT0H'.$data['min_time'].'M0S'));
                    } else {
                        $scheduleCompare->setTimestamp($tsCompare);
                    }

                    $scheduleDate->setTimestamp($ts);

                    $slots = erLhcoreClassModelCBSchedulerSlot::getList(['filter' => ['schedule_id' => $schedulerItem->id, 'day' => $scheduleDate->format('N')]]);

                    // Are we working with current day
                    $currentDay = $scheduleCompare->format('Ymd') == $scheduleDate->format('Ymd');

                    $hasSlots = false;

                    if ($hasNext == true) {
                        $hasSlots = true;
                    }

                    $hasNext = false;

                    foreach ($slots as $slot) {

                        if (
                            erLhcoreClassModelCBSchedulerReservation::getCount(['filternot' => ['status' => erLhcoreClassModelCBSchedulerReservation::STATUS_CANCELED],'filter' => ['slot_id' => $slot->id, 'daytime' => $scheduleDate->format('Ymd')]]) < $slot->max_calls &&
                            ($currentDay == false || (
                                 ($slot->time_start_h > $scheduleCompare->format('H')) ||
                                 ($slot->time_start_m > $scheduleCompare->format('i') && $slot->time_start_h == $scheduleCompare->format('H'))
                                ) )
                        ) {

                            // Just afterwards to restore TZ
                            $tsRestore = $scheduleDate->getTimestamp();

                            // We need to convert schedule star/end time to user time zone start end time.
                            $scheduleDate->setTime($slot->time_start_h, $slot->time_start_m);

                            if ($scheduleDate->format('Ymd') >= $scheduleDateYMDSchedule) { // We have to have at-least one date in user time zone
                                $hasSlots = true;
                            }

                            if ($scheduleDate->format('Ymd') > $scheduleDateYMDSchedule) {
                                $hasNext = true;
                            }

                            $scheduleDate->setTimestamp($tsRestore);
                        }
                    }

                    if ($hasSlots === true) {
                        $item = new stdClass();
                        $item->id = $scheduleDate->format('Ymd');

                        if ($i == 0) {
                            $item->name = erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Today');
                        } elseif ($i == 1) {
                            $item->name = erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Tomorrow');
                        } else {
                            $item->name = $weekDays[date('N',$ts)] . ' ' . date('d',$ts) . ' ' . date('M',$ts) . ' ' . date('Y',$ts);
                        }
                        
                        $days[] = $item;
                    }
                }
            }
        }

        return $days;
    }

    public static function getDayRange($day) {

        $days = [$day/*,$day + 1, $day - 1*/];

        if ($day + 1 > 7) {
            $days[] = 1;
        } else {
            $days[] = $day + 1;
        }

        if ($day - 1 == 0) {
            $days[] = 7;
        } else {
            $days[] = $day - 1;
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

                // Check is it blocked phone number
                $cbOptions = erLhcoreClassModelChatConfig::fetch('lhcbscheduler_options');

                $data = (array)$cbOptions->data;

                $daySelected = array();

                $daySelected['y'] = substr($params['day'],0,4);
                $daySelected['m'] = substr($params['day'],4,2);
                $daySelected['d'] = substr($params['day'],6,2);

                // We need to convert visitor week day to schedule week day.
                //$scheduleDate = new DateTime('now', new DateTimeZone($params['tz']));
                $scheduleDateVisitor = new DateTime('now', new DateTimeZone($schedulerItem->tz));
                $scheduleDateVisitor->setDate($daySelected['y'],$daySelected['m'],$daySelected['d']);
                $scheduleDateVisitor->setTimezone(new DateTimeZone($params['tz']));

                $scheduleDate = new DateTime('now', new DateTimeZone($schedulerItem->tz));
                //$scheduleDate->setTimestamp(mktime(0, 0, 0, $daySelected['m'], $daySelected['d'], $daySelected['y']));
                //$scheduleDate->setTimezone(new DateTimeZone($schedulerItem->tz));
                $scheduleDate->setDate($daySelected['y'],$daySelected['m'],$daySelected['d']);
                $timestampDefault = $scheduleDate->getTimestamp();


                // Schedule present day
                $scheduleCompare = new DateTime('now', new DateTimeZone($schedulerItem->tz));

                // Are we working with current day
                $currentDay = $scheduleCompare->format('Ymd') == $scheduleDate->format('Ymd');

                // Visitor selected day in schedule time zone
                $scheduleDaySelected = new DateTime('now', new DateTimeZone($schedulerItem->tz));
                $scheduleDaySelected->setTimestamp($timestampDefault);

                $scheduleDaySelectedReservation = new DateTime('now', new DateTimeZone($schedulerItem->tz));
                $scheduleDaySelectedReservation->setTimestamp($timestampDefault);

                $slots = erLhcoreClassModelCBSchedulerSlot::getList(['sort' => 'day ASC, time_start_h ASC, time_start_m ASC', 'filterin' => ['day' => /*$scheduleDate->format('N')*/self::getDayRange($scheduleDate->format('N')) ], 'filter' => ['active' => 1, 'schedule_id' => $schedulerItem->id]]);

                if ($currentDay == true && isset($data['min_time']) && is_numeric($data['min_time']) && (int)$data['min_time'] > 0) {
                    $scheduleCompare->add(new DateInterval('P0Y0M0DT0H'.$data['min_time'].'M0S'));
                }

                foreach ($slots as $slot) {

                    // Switch to schedule Time Zone
                    $scheduleDate->setTimezone(new DateTimeZone($schedulerItem->tz));

                    $dayPrefix = ''; // Debug

                    //$dayPrefix = '{'.$scheduleDaySelected->format('N').'}';
                    if ($scheduleDaySelected->format('N') != $slot->day) {
                        //$dayPrefix .= '[' . $slot->day . ']';
                        if ($slot->day == 1 && $scheduleDaySelected->format('N') == 7) {
                            $scheduleDate->setTimestamp($timestampDefault + (24 * 3600));
                        } else if ( ($scheduleDaySelected->format('N') > $slot->day) || ($slot->day == 7 && $scheduleDaySelected->format('N') == 1)) {
                            $scheduleDate->setTimestamp($timestampDefault - (24 * 3600));
                        } else {
                            $scheduleDate->setTimestamp($timestampDefault + (24 * 3600));
                        }
                    } else {
                        $scheduleDate->setTimestamp($timestampDefault);
                    }

                    $scheduleDaySelectedReservation->setTimestamp($scheduleDate->getTimestamp());

                    if (
                        ($scheduleDaySelectedReservation->format('Ymd') < $scheduleCompare->format('Ymd') && $currentDay == true) ||
                        ($scheduleDaySelected->format('N') == $slot->day && $slot->time_start_h < $scheduleCompare->format('H') && $currentDay == true) ||
                        ($scheduleDaySelected->format('N') == $slot->day && $slot->time_start_m < $scheduleCompare->format('i') && $currentDay == true && $slot->time_start_h == $scheduleCompare->format('H')) ||
                        erLhcoreClassModelCBSchedulerReservation::getCount(['filternot' => ['status' => erLhcoreClassModelCBSchedulerReservation::STATUS_CANCELED],'filter' => ['slot_id' => $slot->id, 'daytime' => $scheduleDaySelectedReservation->format('Ymd')]]) >= $slot->max_calls
                    ) {
                        continue;
                    }
                    // Continue sort for times if monday

                    /*
                     * Start time manipulations
                     * */

                    // We need to convert schedule star/end time to user time zone start end time.
                    $scheduleDate->setTime($slot->time_start_h, $slot->time_start_m);

                    // Switch to user Time Zone
                    $scheduleDate->setTimezone(new DateTimeZone($params['tz']));

                    if (isset($params['12h']) && $params['12h'] == true) {
                        $slotTimeStart = $scheduleDate->format('g:i a');
                    } else {
                        $slotTimeStart = $scheduleDate->format('H:i');
                    }

                    $slotTimeStartDate = $scheduleDate->format('Ymd');

                    /*
                     * End time manipulations
                     * */
                    if ( $scheduleDateVisitor->format('Ymd') != $slotTimeStartDate) {
                        continue;
                    }

                    // Switch to schedule Time Zone
                    $scheduleDate->setTimezone(new DateTimeZone($schedulerItem->tz));

                    // We need to convert schedule star/end time to user time zone start end time.
                    $scheduleDate->setTime($slot->time_end_h, $slot->time_end_m);

                    // Switch to user Time Zone
                    $scheduleDate->setTimezone(new DateTimeZone($params['tz']));

                    // If start or end date is different than user timezone day, ignore it

                    if (isset($params['12h']) && $params['12h'] == true) {
                        $slotTimeEnd = $scheduleDate->format('g:i a');
                    } else {
                        $slotTimeEnd = $scheduleDate->format('H:i');
                    }

                    $offset = $scheduleDate->getOffset();

                    $times[] = ['id' => $slot->id, 'h' => (int)str_replace(':','',$slotTimeStart), 'name' => /*$slot->day .'[' . $slot->id . ']' . '-' . $dayPrefix .*/ $slotTimeStart . ' - ' . $slotTimeEnd . ' (UTC'. ($offset > 0 ? '+' : ($offset < 0 ? '' : '-')) . ($offset/3600) . ')'];
                }

                // Sort by hour always
                usort($times, function($a, $b) {
                    return $a['h'] > $b['h'] ? 1 : 0;
                });

            }
        }

        return $times;
    }

    public static function validateCBEditReservation($item, $params = array()) {
        $definition = array(
            'status' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'int', array( 'min_range' => 0, 'max_range' => 3)
            ),
            'user_ids' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'int', array('min_range' => 1), FILTER_REQUIRE_ARRAY
            ),
            'outcome' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
            )
        );

        $form = new ezcInputForm( INPUT_POST, $definition );
        $Errors = array();

        $originalStatus = $item->status;
        
        if ( $form->hasValidData( 'status' ) ) {
            $item->status = $form->status;
        }

        if ( $form->hasValidData( 'outcome' ) && $form->outcome != '') {
            $item->outcome .= "===========================\n[".date('Y-m-d H:i:s') . '] ' . $params['user']->name_official . " has updated a record\n===========================\n" . $form->outcome . "\n";
        }

        // Status was changed
        if ($originalStatus != $item->status && !erLhcoreClassUser::instance()->hasAccessTo('lhcbscheduler', 'manage_assignment')) {
            $item->user_id = $params['user_id'];
        }

        if (erLhcoreClassUser::instance()->hasAccessTo('lhcbscheduler', 'manage_assignment') && $form->hasValidData( 'user_ids' ) && !empty($form->user_ids) ) {
            $item->user_id = $form->user_ids[0];
        }

        return $Errors;
    }

    public static function validateCBTransform($item, $params = array()) {
        $definition = array(
            'country' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
            ),
            'dep_id' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'int', array('min_range' => 1), FILTER_REQUIRE_ARRAY
            ),
            'rules' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
            )
        );

        $form = new ezcInputForm( INPUT_POST, $definition );
        $Errors = array();

        if ( $form->hasValidData( 'country' ) && trim($form->country) != '') {
            $item->country = json_encode(explode(',',str_replace(' ','',trim($form->country))));
        } else {
            $item->country = json_encode([]);
        }

        if ( $form->hasValidData( 'rules' ) ) {
            $item->rules = $form->rules;
        }

        if ( $form->hasValidData( 'dep_id' ) && $form->dep_id) {
            $item->dep_id = json_encode($form->dep_id);
        } else {
            $item->dep_id = json_encode([]);
        }

        $item->dep_id_array = json_decode($item->dep_id,true);
        $item->country_array = json_decode($item->country,true);

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
            'terms_agree' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'boolean'
            ),
            'reschedule' => new ezcInputFormDefinitionElement(
                ezcInputFormDefinitionElement::OPTIONAL, 'boolean'
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
            'parent_id' => new ezcInputFormDefinitionElement(
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
            $item->email = strtolower($form->email);
        }

        if ( $form->hasValidData( 'attempt' ) ) {
            $item->attempt = $form->attempt;
        }

        if ($form->hasValidData( 'terms_agree' ) && $form->terms_agree == true) {
            $item->terms_agree = $form->terms_agree;
        } else {
            $cbOptions = erLhcoreClassModelChatConfig::fetch('lhcbscheduler_options');
            $data = (array)$cbOptions->data;
            if (isset($data['terms_of_service']) && $data['terms_of_service'] != '') {
                $Errors['terms_of_service'] = erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','You have to agree to our terms of service.');
            }
        }

        if ( !$form->hasValidData( 'username' ) || $form->username == '' ) {
            $Errors['username'] = erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Please enter a username');
        } elseif ($form->hasValidData( 'username' )) {
            $item->name = $form->username;
        }

        if ( $form->hasValidData( 'chat_id' )) {
            $item->chat_id = $form->chat_id;
        }
        
        if ( $form->hasValidData( 'parent_id' )) {
            $item->parent_id = $form->parent_id;
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

        if (empty($Errors) && erLhcoreClassModelChatBlockedUser::isBlocked(array('ip' => erLhcoreClassIPDetect::getIP(), 'dep_id' => $item->dep_id, 'nick' => $item->name))) {
            $Errors['phone'] = erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','At this moment you can contact us via email only. Sorry for the inconveniences.');
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

                    // Default filter
                    $filter = ['filter' => ['phone' => $item->phone, 'status' => 0, 'schedule_id' => $item->schedule_id]];

                    if ($schedulerItem->multi_department == 1) {
                        $filter['filterin']['dep_id'] = erLhcoreClassModelCBSchedulerSchedulerDep::getCount(array('filter' => array('schedule_id' => $schedulerItem->id)), null, 'dep_id', false, false, true, true);
                    } else {
                        $filter['filter']['dep_id'] = $item->dep_id;
                    }

                    $cbOptions = erLhcoreClassModelChatConfig::fetch('lhcbscheduler_options');

                    $data = (array)$cbOptions->data;

                    if (isset($data['unique']) && is_array($data['unique']) && !empty($data['unique'])) {
                        $filter = [];
                        
                        $filter['filter']['status'] = 0;

                        if (in_array('dep_id', $data['unique'])) {
                            if ($schedulerItem->multi_department == 0) {
                                $filter['filter']['dep_id'] = $item->dep_id;
                            } else {
                                $filter['filterin']['dep_id'] = erLhcoreClassModelCBSchedulerSchedulerDep::getCount(array('filter' => array('schedule_id' => $schedulerItem->id)), null, 'dep_id', false, false, true, true);
                            }
                        }

                        if (in_array('name', $data['unique'])) {
                            $filter['filter']['name'] = $item->name;
                        }

                        if (in_array('email', $data['unique'])) {
                            $filter['filter']['email'] = $item->email;
                        }

                        if (in_array('phone', $data['unique'])) {
                            $filter['filter']['phone'] = $item->phone;
                        }

                        if (in_array('schedule_id', $data['unique'])) {
                            $filter['filter']['schedule_id'] = $item->schedule_id;
                        }
                    }

                    $presentRecord = erLhcoreClassModelCBSchedulerReservation::findOne($filter);

                    // Check is there any scheduled call already
                    // If it's reschedule just set present id to past ID so all attribute will be overriden
                    if ($presentRecord instanceof erLhcoreClassModelCBSchedulerReservation && !(isset($params['reschedule']) && $params['reschedule'] == true && $item->id = $presentRecord->id)) {

                        /*You have already a call scheduled for DD MMM YYYY at HH:MM*/
                        $scheduleDate = new DateTime('now', new DateTimeZone($presentRecord->tz));
                        $scheduleDate->setTimestamp($presentRecord->cb_time_start);

                        if ($params['12h'] && $params['12h'] == true) {
                            $hourStart = $scheduleDate->format('g:i a');
                        } else {
                            $hourStart = $scheduleDate->format('H:i');
                        }

                        $scheduleDate->setTimestamp($presentRecord->cb_time_end);

                        if ($params['12h'] && $params['12h'] == true) {
                            $hourEnd = $scheduleDate->format('g:i a');
                        } else {
                            $hourEnd = $scheduleDate->format('H:i');
                        }

                        throw new Exception(
                            erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','You have already a call scheduled for') . ' ' .
                            $scheduleDate->format('d') . ' ' .
                            $scheduleDate->format('M') . ' ' .
                            $scheduleDate->format('Y') . ' ' . erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','between') . ' ' . $hourStart . ' ' . erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','and') . ' ' . $hourEnd
                        , 100);
                    }

                    $daySelected = array();

                    $daySelected['y'] = substr($item->day,0,4);
                    $daySelected['m'] = substr($item->day,4,2);
                    $daySelected['d'] = substr($item->day,6,2);

                    $scheduleDateVisitor = new DateTime('now', new DateTimeZone($schedulerItem->tz));
                    $scheduleDateVisitor->setDate($daySelected['y'],$daySelected['m'],$daySelected['d']);
                    $scheduleDateVisitor->setTimezone(new DateTimeZone($item->tz));

                    // We need to convert visitor week day to schedule week day.
                    $scheduleDate = new DateTime('now', new DateTimeZone($schedulerItem->tz));
                    $scheduleDate->setDate($daySelected['y'], $daySelected['m'], $daySelected['d']);

                    $timestampDefault = $scheduleDate->getTimestamp();

                    $slot = erLhcoreClassModelCBSchedulerSlot::findOne(['filter' => ['id'=> $item->slot_id, 'active' => 1, /*'day' => $scheduleDate->format('N'),*/ 'schedule_id' => $schedulerItem->id]]);

                    // Schedule present day
                    $scheduleCompare = new DateTime('now', new DateTimeZone($schedulerItem->tz));

                    // Are we working with current day
                    $currentDay = $scheduleCompare->format('Ymd') == $scheduleDate->format('Ymd');

                    // Visitor selected day in schedule time zone
                    $scheduleDaySelected = new DateTime('now', new DateTimeZone($schedulerItem->tz));
                    $scheduleDaySelected->setTimestamp($scheduleDate->getTimestamp());

                    if ($scheduleDaySelected->format('N') != $slot->day) {
                        if ($scheduleDaySelected->format('N') > $slot->day) {
                            $scheduleDate->setTimestamp($timestampDefault - (24 * 3600));
                        } else {
                            $scheduleDate->setTimestamp($timestampDefault + (24 * 3600));
                        }
                    } else { // Set original timestamp
                        $scheduleDate->setTimestamp($timestampDefault);
                    }

                    if (!($slot instanceof erLhcoreClassModelCBSchedulerSlot) ||
                        ($scheduleDaySelected->format('N') == $slot->day && $slot->time_start_h < $scheduleCompare->format('H') && $currentDay == true) ||
                        ($scheduleDaySelected->format('N') == $slot->day && $slot->time_start_m < $scheduleCompare->format('i') && $currentDay == true && $slot->time_start_h == $scheduleCompare->format('H')) ||
                        erLhcoreClassModelCBSchedulerReservation::getCount(['filternot' => ['status' => erLhcoreClassModelCBSchedulerReservation::STATUS_CANCELED],'filter' => ['slot_id' => $slot->id, 'daytime' => $scheduleDate->format('Ymd')]]) >= $slot->max_calls
                    ) {
                        throw new Exception(erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Slot became unavailable. Please choose another time.')  /*$scheduleDaySelected->format('Ymd') . print_r($slot, true) . $schedulerItem->tz . $scheduleDate->format('N') . $item->slot_id*/);
                    }

                    $scheduleDate->setTime($slot->time_start_h,$slot->time_start_m);
                    $item->cb_time_start = $scheduleDate->getTimestamp();

                    $scheduleDate->setTime($slot->time_end_h,$slot->time_end_m);
                    $item->cb_time_end = $scheduleDate->getTimestamp();

                    $cbOptions = erLhcoreClassModelChatConfig::fetch('lhcbscheduler_options');

                    $data = (array)$cbOptions->data;

                    if ($item->cb_time_start < time() || (isset($data['min_time']) && is_numeric($data['min_time']) && (int)$data['min_time'] > 0 && $item->cb_time_start < time() + ((int)$data['min_time'] * 60))) {
                        throw new Exception(erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Slot became unavailable. Please choose another time.'));
                    }

                    $scheduleDate->setTimestamp( $item->cb_time_end - 1);
                    $item->daytime = $scheduleDate->format('Ymd');
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

        $item = new stdClass();
        $item->id = 2;
        $item->name = erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Canceled');

        $options[] = $item;

        $item = new stdClass();
        $item->id = 3;
        $item->name = erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Not Answered');

        $options[] = $item;

        return $options;
    }
}

?>