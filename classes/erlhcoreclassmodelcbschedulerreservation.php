<?php
#[\AllowDynamicProperties]
class erLhcoreClassModelCBSchedulerReservation
{
    use erLhcoreClassDBTrait;

    public static $dbTable = 'lhc_cbscheduler_reservation';

    public static $dbTableId = 'id';

    public static $dbSessionHandler = 'erLhcoreClassExtensionCbscheduler::getSession';

    public static $dbSortOrder = 'DESC';

    public function getState()
    {
        return array(
            'id' => $this->id,

            'slot_id' => $this->slot_id,

            'schedule_id' => $this->schedule_id,

            'dep_id' => $this->dep_id,

            'parent_id' => $this->parent_id,

            // Timezone of slot.
            'tz' => $this->tz,

            // We store callback times directly
            'cb_time_start' => $this->cb_time_start,

            // We store callback times directly
            'cb_time_end' => $this->cb_time_end,

            'ctime' => $this->ctime,

            // Status
            'status' => $this->status,

            'region' => $this->region,

            // Will hold a cancel code
            'code' => $this->code,

            'name' => $this->name,

            'email' => $this->email,

            'phone' => $this->phone,

            'description' => $this->description,
            
            'outcome' => $this->outcome,

            'subject_id' => $this->subject_id,

            'daytime' => $this->daytime,

            'chat_id' => $this->chat_id,

            'user_id' => $this->user_id,

            'verified' => $this->verified,

            'status_accept' => $this->status_accept,

            // Time last assignment happened
            'tslasign' => $this->tslasign,
            'log_actions' => $this->log_actions,
        );
    }

    public function __toString()
    {
        return $this->name;
    }

    public function __get($var)
    {
        switch ($var) {

            case 'slot':
                $this->slot = null;
                if ($this->slot_id > 0) {
                    $this->slot = erLhcoreClassModelCBSchedulerSlot::fetch($this->slot_id);
                }
                return $this->slot;

            case 'schedule':
                $this->schedule = null;
                if ($this->schedule_id > 0) {
                    $this->schedule = erLhcoreClassModelCBSchedulerScheduler::fetch($this->schedule_id);
                }
                return $this->schedule;

            case 'phone_front':
                $this->phone_front = [$this->phone];

                $region = strtolower($this->region);

                $db = ezcDbInstance::get();

                $phoneTransform = erLhcoreClassModelCBSchedulerPhoneTransform::findOne(array('customfilter' => array('(JSON_CONTAINS(`country`,'.$db->quote('"'.$region.'"').',\'$\') AND JSON_CONTAINS(`dep_id`,\''. (int)$this->dep_id . '\',\'$\') )')));

                if (!($phoneTransform instanceof erLhcoreClassModelCBSchedulerPhoneTransform)) {
                    $phoneTransform = erLhcoreClassModelCBSchedulerPhoneTransform::findOne(array('customfilter' => array('(`country` = \'[]\' AND JSON_CONTAINS(`dep_id`,\''. (int)$this->dep_id . '\',\'$\') )')));
                }

                if ($phoneTransform instanceof erLhcoreClassModelCBSchedulerPhoneTransform) {
                    foreach ($phoneTransform->rules_array as $transformRule) {
                        $phoneReplaced = preg_replace('/'.str_replace('+','\+',$transformRule[0]).'/is',$transformRule[1], $this->phone);
                        if (!in_array($phoneReplaced, $this->phone_front)){
                            $this->phone_front[] = $phoneReplaced;
                        }
                    }
                }
                array_shift( $this->phone_front);
                return $this->phone_front;

            case 'subject':
                $this->subject = null;
                if ($this->subject_id > 0) {
                    $this->subject = erLhcoreClassModelCBSchedulerSubject::fetch($this->subject_id);
                }
                return $this->subject;

            case 'subject_front':
                $this->subject_front = (string)$this->subject;
                return $this->subject_front;

            case 'subject_list':
                $this->subject_list = [];
                if (!empty((string)$this->subject)){
                    $this->subject_list = [(string)$this->subject];
                }
                return $this->subject_list;

            case 'parent':
                $this->parent = null;
                if ($this->parent_id > 0) {
                    $this->parent = self::fetch($this->parent_id);
                }
                return $this->parent;

            case 'user':
                $this->user = null;
                if ($this->user_id > 0) {
                    $this->user = erLhcoreClassModelUser::fetch($this->user_id);
                }
                return $this->user;

            case 'user_name_official':
                $this->user_name_official = null;
                if ($this->user instanceof erLhcoreClassModelUser) {
                    $this->user_name_official = $this->user->name_official;
                }
                return $this->user_name_official;

            case 'plain_user_name':
                $this->plain_user_name = null;
                if ($this->user instanceof erLhcoreClassModelUser) {
                    $this->plain_user_name = $this->user->name_official;
                }
                return $this->plain_user_name;

            case 'dep':
                $this->dep = null;
                if ($this->dep_id > 0) {
                    $this->dep = erLhcoreClassModelDepartament::fetch($this->dep_id);
                }
                return $this->dep;

            case 'department_name':
                return $this->department_name = (string)$this->dep;

            case 'scheduler_for_front':
                    $this->scheduler_for_front = date('Y-m-d H:i',$this->cb_time_start) . ' - ' . date('Y-m-d H:i',$this->cb_time_end);
                    return $this->scheduler_for_front;

            case 'time_till_call':
                    if ($this->cb_time_start - time() > 0) {
                        $this->time_till_call = erLhcoreClassChat::formatSeconds($this->cb_time_start - time());
                    } else {
                        $this->time_till_call = 0 . ' s.';
                    }
                    return $this->time_till_call;

            case 'time_till_call_seconds':
                $this->time_till_call_seconds = $this->cb_time_start - time();
                return $this->time_till_call_seconds;

            case 'time_till_call_seconds_neg':
                $this->time_till_call_seconds_neg = $this->time_till_call_seconds <= 0;
                return $this->time_till_call_seconds_neg;

            case 'region_lower':
                $this->region_lower = strtolower($this->region);
                return $this->region_lower;

            case 'country_code':
                $this->country_code = strtolower($this->region);
                return $this->country_code;

            case 'log_actions_array':
                $this->log_actions_array = array();
                if ($this->log_actions != '') {
                    $this->log_actions_array = json_decode($this->log_actions, true);
                }
                return $this->log_actions_array;

            default:
                ;
                break;
        }
    }

    public function beforeSave()
    {
        if ($this->code == '') {
            $this->code = substr( md5(mt_rand(0,1000) . microtime()),0,10);
        }

        if ($this->ctime === null) {
            $this->ctime = time();
        }
    }

    public function afterSave($params = array())
    {
        erLhcoreClassChatEventDispatcher::getInstance()->dispatch('cbscheduler.reservation.after_save',array(
            'cbscheduler' => & $this
        ));
    }

    public function afterUpdate($params = array())
    {
        erLhcoreClassChatEventDispatcher::getInstance()->dispatch('cbscheduler.reservation.after_update',array(
            'cbscheduler' => & $this
        ));
    }

    public function afterRemove() {
        erLhcoreClassChatEventDispatcher::getInstance()->dispatch('cbscheduler.reservation.after_remove',array(
            'cbscheduler' => & $this
        ));
    }

    const STATUS_SCHEDULED = 0;

    const STATUS_COMPLETED = 1;

    const STATUS_CANCELED = 2;

    const NOT_ANSWERED = 3;

    // Acceptance status
    const PENDING_ACCEPT = 0;

    const CALL_ACCEPTED = 1;

    public $id = null;

    public $slot_id = null;

    public $schedule_id = null;

    public $dep_id = null;

    public $status_accept = self::PENDING_ACCEPT;

    public $tslasign = 0;

    public $tz = null;

    public $cb_time_start = null;

    public $cb_time_end = null;

    public $status = self::STATUS_SCHEDULED;

    public $code = '';

    public $name = '';

    public $email = '';

    public $phone = '';

    public $description = '';

    public $outcome = '';

    public $region = '';

    public $ctime = null;

    public $subject_id = null;

    public $chat_id = 0;

    public $user_id = 0;
    
    public $parent_id = 0;

    public $daytime = '';

    public $verified = 0;

    public $log_actions = '';

}

?>