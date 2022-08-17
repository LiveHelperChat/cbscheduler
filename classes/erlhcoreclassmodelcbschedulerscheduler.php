<?php

class erLhcoreClassModelCBSchedulerScheduler
{
    use erLhcoreClassDBTrait;

    public static $dbTable = 'lhc_cbscheduler_scheduler';

    public static $dbTableId = 'id';

    public static $dbSessionHandler = 'erLhcoreClassExtensionCbscheduler::getSession';

    public static $dbSortOrder = 'DESC';

    public function getState()
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'tz' => $this->tz,
            'active' => $this->active,
            'multi_department' => $this->multi_department
        );
    }

    public function __toString()
    {
        return $this->name;
    }

    public function __get($var)
    {
        switch ($var) {

            case 'slots':
                if ($this->id > 0) {
                    $this->slots = erLhcoreClassModelCBSchedulerSlot::getList(array('filter' => ['schedule_id' => $this->id]));
                } else {
                    $this->slots = [];
                }
                return $this->slots;

            case 'department_ids':
                    $this->department_ids = erLhcoreClassModelCBSchedulerSchedulerDep::getCount(array('filter' => array('schedule_id' => $this->id, 'dep_group_id' => 0)), '', false, 'dep_id', false, true, true);
                    return $this->department_ids;

            case 'department_group_ids':
                    $this->department_group_ids = erLhcoreClassModelCBSchedulerSchedulerDepGroup::getCount(array('filter' => array('schedule_id' => $this->id)), '', false, 'dep_group_id', false, true, true);
                    return $this->department_group_ids;

            case 'ctime_front':
                $this->ctime_front = date('Ymd') == date('Ymd', $this->ctime) ? date(erLhcoreClassModule::$dateHourFormat, $this->ctime) : date(erLhcoreClassModule::$dateDateHourFormat, $this->ctime);
                return $this->ctime_front;

            default:
                ;
                break;
        }
    }

    public function beforeSave()
    {
        if ($this->id > 0) {

            /*
             * Slots handling
             * */
            $slotsPast = erLhcoreClassModelCBSchedulerSlot::getList(array('filter' => array('schedule_id' => $this->id)));

            $newKeys = array();

            foreach ($this->slots as $slot) {
                if ($slot->id > 0) {
                    $newKeys[] = $slot->id;
                }
            }

            $keysRemove = array_diff(array_keys($slotsPast), $newKeys);

            foreach ($keysRemove as $keyRemove) {
                $slotsPast[$keyRemove]->removeThis();
            }

            /*
             * Departments handling
             * */
            $departmentsPast = erLhcoreClassModelCBSchedulerSchedulerDep::getList(array('filter' => array('schedule_id' => $this->id, 'dep_group_id' => 0)));

            $departmentsPastID = array();
            foreach ($departmentsPast as $dep) {
                $departmentsPastID[] = $dep->dep_id;
            }

            $keysRemove = array_diff($departmentsPastID, $this->department_ids);

            foreach ($departmentsPast as $dep) {
                if (in_array($dep->dep_id,$keysRemove)) {
                    $dep->removeThis();
                }
            }

            /*
             * Departments handling
             * */
            $departmentsPast = erLhcoreClassModelCBSchedulerSchedulerDepGroup::getList(array('filter' => array('schedule_id' => $this->id)));

            $departmentsPastID = array();
            foreach ($departmentsPast as $dep) {
                $departmentsPastID[] = $dep->dep_group_id;
            }

            $keysRemove = array_diff($departmentsPastID, $this->department_group_ids);

            foreach ($departmentsPast as $dep) {
                if (in_array($dep->dep_group_id, $keysRemove)) {
                    $dep->removeThis();
                }
            }

        }
    }

    public function afterSave()
    {
        foreach ($this->slots as $slot) {
            $slot->schedule_id = $this->id;
            $slot->saveThis();
        }

        foreach ($this->department_ids as $depId) {
            if (erLhcoreClassModelCBSchedulerSchedulerDep::getCount(array('filter' => array('dep_id' => $depId, 'schedule_id' => $this->id, 'dep_group_id' => 0))) == 0) {
                $item = new erLhcoreClassModelCBSchedulerSchedulerDep();
                $item->schedule_id = $this->id;
                $item->dep_id = $depId;
                $item->type = 0;
                $item->saveThis();
            }
        }

        foreach ($this->department_group_ids as $depId) {
            if (erLhcoreClassModelCBSchedulerSchedulerDepGroup::getCount(array('filter' => array('dep_group_id' => $depId, 'schedule_id' => $this->id))) == 0) {
                $item = new erLhcoreClassModelCBSchedulerSchedulerDepGroup();
                $item->schedule_id = $this->id;
                $item->dep_group_id = $depId;
                $item->saveThis();
            }
        }
    }

    public function afterRemove()
    {
        $q = ezcDbInstance::get()->createDeleteQuery();

        // Slots
        $q->deleteFrom( 'lhc_cbscheduler_slot' )->where( $q->expr->eq( 'schedule_id', $this->id ) );
        $stmt = $q->prepare();
        $stmt->execute();

        // Departments
        $q->deleteFrom( 'lhc_cbscheduler_scheduler_dep' )->where( $q->expr->eq( 'schedule_id', $this->id ) );
        $stmt = $q->prepare();
        $stmt->execute();

        // Departments groups
        $q->deleteFrom( 'lhc_cbscheduler_scheduler_dep_group' )->where( $q->expr->eq( 'schedule_id', $this->id ) );
        $stmt = $q->prepare();
        $stmt->execute();
    }

    public static function getData($item) {

        $returnData = [
            1 => [],
            2 => [],
            3 => [],
            4 => [],
            5 => [],
            6 => [],
            7 => [],
        ];

        foreach ($item->slots as $slot) {
            $returnData[$slot->day][] = array(
                'id' => $slot->id,
                'start_time' => $slot->time_start_h . ':' . $slot->time_start_m,
                'end_time' => $slot->time_end_h . ':' . $slot->time_end_m,
                'start_hour' => $slot->time_start_h,
                'start_minute' => $slot->time_start_m,
                'max_calls' => $slot->max_calls
            );
        }

        foreach ($returnData as $day => & $dayData) {
            usort($dayData, function ($a, $b) {
                if ($a['start_hour'] == $b['start_hour']) {
                    return (int)$a['start_minute'] > (int)$b['start_minute'] ? 1 : -1;
                }
                return (int)$a['start_hour'] > (int)$b['start_hour'] ? 1 : -1;
            });
        }

        return $returnData;
    }

    public $id = null;

    public $tz = '';

    public $active = 1;

    public $multi_department = 0;

    public $name = '';
}

?>