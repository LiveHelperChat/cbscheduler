<?php

class erLhcoreClassModelCBSchedulerSubject
{
    use erLhcoreClassDBTrait;

    public static $dbTable = 'lhc_cbscheduler_subject';

    public static $dbTableId = 'pos';

    public static $dbSessionHandler = 'erLhcoreClassExtensionCbscheduler::getSession';

    public static $dbSortOrder = 'ASC';

    public function getState()
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'pos' => $this->pos,
            'active' => $this->active,
            'dep_ids' => $this->dep_ids,
        );
    }

    public function __toString()
    {
        return $this->name;
    }

    public function __get($var)
    {
        switch ($var) {

            case 'schedule':
                $this->schedule = null;

                if ($this->schedule_id > 0) {
                    $this->schedule = erLhcoreClassModelChat::fetch($this->chat_id);
                }

                return $this->schedule;

            case 'dep_ids_array':
                $this->dep_ids_array = json_decode($this->dep_ids, true);
                if (!is_array($this->dep_ids_array)) {
                    $this->dep_ids_array = [];
                }
                return $this->dep_ids_array;

            default:
                ;
                break;
        }
    }

    public $id = null;

    public $name = '';

    public $dep_ids = '';

    public $pos = 0;

    public $active = 1;

}

?>