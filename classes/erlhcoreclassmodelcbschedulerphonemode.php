<?php

class erLhcoreClassModelCBSchedulerPhoneMode
{
    use erLhcoreClassDBTrait;

    public static $dbTable = 'lhc_cbscheduler_phone_mode';

    public static $dbTableId = 'id';

    public static $dbSessionHandler = 'erLhcoreClassExtensionCbscheduler::getSession';

    public static $dbSortOrder = 'DESC';

    public function getState()
    {
        return array(
            'id' => $this->id,
            'user_id' => $this->user_id,
            'on_phone' => $this->on_phone,
            'last_accepted' => $this->last_accepted,
        );
    }

    public static function getInstance($userId)
    {
        $instance = self::findOne(['filter' => ['user_id' => $userId]]);
        if (!$instance instanceof erLhcoreClassModelCBSchedulerPhoneMode){
            $instance = new self();
            $instance->user_id = $userId;
            $instance->saveThis();
        }

        return $instance;
    }

    public function __toString()
    {
        return $this->user_id;
    }

    public function __get($var)
    {
        switch ($var) {

            case 'slot_time':
                $this->slot_time = $this->time_start_h . ':' . $this->time_start_m . ' - ' . $this->time_end_h . ':' . $this->time_end_m;
                return $this->slot_time;

            default:
                ;
                break;
        }
    }

    public $id = null;

    public $user_id = null;

    public $on_phone = 0;
    
    public $last_accepted = 0;
}

?>