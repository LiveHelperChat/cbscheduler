<?php

class erLhcoreClassModelCBSchedulerSubject
{
    use erLhcoreClassDBTrait;

    public static $dbTable = 'lhc_cbscheduler_subject';

    public static $dbTableId = 'id';

    public static $dbSessionHandler = 'erLhcoreClassExtensionCbscheduler::getSession';

    public static $dbSortOrder = 'DESC';

    public function getState()
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'pos' => $this->pos,
            'active' => $this->active,
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

            default:
                ;
                break;
        }
    }

    public $id = null;

    public $name = '';

    public $pos = 0;

    public $active = 1;

}

?>