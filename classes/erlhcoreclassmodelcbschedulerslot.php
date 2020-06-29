<?php

class erLhcoreClassModelCBSchedulerSlot
{
    use erLhcoreClassDBTrait;

    public static $dbTable = 'lhc_cbscheduler_slot';

    public static $dbTableId = 'id';

    public static $dbSessionHandler = 'erLhcoreClassExtensionCbscheduler::getSession';

    public static $dbSortOrder = 'DESC';

    public function getState()
    {
        return array(
            'id' => $this->id,
            'schedule_id' => $this->schedule_id,
            'time_start_h' => $this->time_start_h,
            'time_start_m' => $this->time_start_m,
            'time_end_h' => $this->time_end_h,
            'time_end_m' => $this->time_end_m,
            'day' => $this->day,
            'max_calls' => $this->max_calls,
            'active' => $this->active,
        );
    }

    public function __toString()
    {
        return $this->ctime;
    }

    public function __get($var)
    {
        switch ($var) {

            case 'slot_time':
                $this->slot_time = $this->time_start_h . ':' . $this->time_start_m . ' - ' . $this->time_end_h . ':' . $this->time_end_m;
                return $this->slot_time;

            case 'schedule':
                $this->schedule = null;
                if ($this->schedule_id > 0) {
                    $this->schedule = erLhcoreClassModelChat::fetch($this->schedule_id);
                }
                return $this->schedule;


            default:
                ;
                break;
        }
    }

    public $id = null;

    public $schedule_id = null;

    public $time_start_h = null;

    public $time_start_m = null;

    public $time_end_h = null;

    public $time_end_m = null;

    public $max_calls = 1;

    public $active = 1;

    public $day = null;
}

?>