<?php
#[\AllowDynamicProperties]
class erLhcoreClassModelCBSchedulerSchedulerDep
{
    use erLhcoreClassDBTrait;

    public static $dbTable = 'lhc_cbscheduler_scheduler_dep';

    public static $dbTableId = 'id';

    public static $dbSessionHandler = 'erLhcoreClassExtensionCbscheduler::getSession';

    public static $dbSortOrder = 'DESC';

    public function getState()
    {
        return array(
            'id' => $this->id,
            'schedule_id' => $this->schedule_id,
            'dep_id' => $this->dep_id,
            'dep_group_id' => $this->dep_group_id,
        );
    }

    public $id = null;

    public $schedule_id = null;

    public $dep_id = null;

    public $dep_group_id = 0;
}

?>