<?php
#[\AllowDynamicProperties]
class erLhcoreClassModelCBSchedulerSchedulerDepGroup
{
    use erLhcoreClassDBTrait;

    public static $dbTable = 'lhc_cbscheduler_scheduler_dep_group';

    public static $dbTableId = 'id';

    public static $dbSessionHandler = 'erLhcoreClassExtensionCbscheduler::getSession';

    public static $dbSortOrder = 'DESC';

    public function getState()
    {
        return array(
            'id' => $this->id,
            'schedule_id' => $this->schedule_id,
            'dep_group_id' => $this->dep_group_id
        );
    }

    public function afterRemove()
    {
        $q = ezcDbInstance::get()->createDeleteQuery();

        // Departments
        $q->deleteFrom( 'lhc_cbscheduler_scheduler_dep' )->where(
            $q->expr->eq( 'dep_group_id', $this->id ),
            $q->expr->eq( 'schedule_id', $this->schedule_id )
        );

        $stmt = $q->prepare();
        $stmt->execute();
    }

    public function afterSave()
    {
        // Continue here
        $members = erLhcoreClassModelDepartamentGroupMember::getList(array('filter' => array('dep_group_id' => $this->dep_group_id)));

        // remove legacy departments
        $presentDepartments = erLhcoreClassModelCBSchedulerSchedulerDep::getList(['filter' => ['schedule_id' => $this->schedule_id, 'dep_group_id' => $this->id]]);
        foreach ($presentDepartments as $presentDepartment) {
            if (erLhcoreClassModelDepartamentGroupMember::getCount(array('filter' => array('dep_id' => $presentDepartment->dep_id, 'dep_group_id' => $this->dep_group_id))) == 0) {
                $presentDepartment->removeThis();
            }
        }

        // Add ne departments
        foreach ($members as $member) {
            if (erLhcoreClassModelCBSchedulerSchedulerDep::getCount(['filter' => ['dep_id' =>  $member->dep_id, 'schedule_id' => $this->schedule_id, 'dep_group_id' => $this->id]]) == 0)
            {
                $item = new erLhcoreClassModelCBSchedulerSchedulerDep();
                $item->schedule_id = $this->schedule_id;
                $item->dep_group_id = $this->id;
                $item->dep_id = $member->dep_id;
                $item->saveThis();
            }
        }
    }

    public $id = null;

    public $schedule_id = null;

    public $dep_group_id = null;
}

?>