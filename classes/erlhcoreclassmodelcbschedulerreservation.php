<?php

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

            case 'subject':
                $this->subject = null;
                if ($this->subject_id > 0) {
                    $this->subject = erLhcoreClassModelCBSchedulerSubject::fetch($this->subject_id);
                }
                return $this->subject;

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

            case 'dep':
                $this->dep = null;
                if ($this->dep_id > 0) {
                    $this->dep = erLhcoreClassModelDepartament::fetch($this->dep_id);
                }
                return $this->dep;

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

    const STATUS_SCHEDULED = 0;

    const STATUS_COMPLETED = 1;

    const STATUS_CANCELED = 2;

    public $id = null;

    public $slot_id = null;

    public $schedule_id = null;

    public $dep_id = null;

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

}

?>