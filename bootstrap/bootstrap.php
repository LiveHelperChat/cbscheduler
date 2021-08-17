<?php

class erLhcoreClassExtensionCbscheduler {

    public function __construct() {

    }

    public function run() {
        $this->registerAutoload ();

        include_once 'extension/cbscheduler/vendor/autoload.php';
        $dispatcher = erLhcoreClassChatEventDispatcher::getInstance();

        $dispatcher->listen('widgetrestapi.settings', array($this, 'widgetSettings'));
        $dispatcher->listen('department.edit_department_group', array($this,'departmentGroupModified'));
        $dispatcher->listen('chat.customcommand', array($this, 'customCommand'));
        $dispatcher->listen('chat.syncadmininterface', array($this,'appendCallbacks'));
        $dispatcher->listen('chat.loadinitialdata', array($this,'loadInitialData'));

    }

    public function customCommand($paramsCommand) {
        if ($paramsCommand['command'] == '!schedule') {

            $params = $paramsCommand['params'];

            // Store as message to visitor
            $msg = new erLhcoreClassModelmsg();
            $msg->msg = isset($paramsCommand['argument']) && !empty($paramsCommand['argument']) ? $paramsCommand['argument'] : erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','We will show modal window to schedule a call!');
            $msg->meta_msg = '{"content":{"execute_js":{"text":"","ext_execute":"cbscheduler","ext_args":"{\"delay\":3}","payload":""}}}';
            $msg->chat_id = $params['chat']->id;
            $msg->user_id = $params['user']->id;
            $msg->time = time();
            $msg->name_support = $params['user']->name_support;
            $msg->saveThis();

            // Update last user msg time so auto responder work's correctly
            $params['chat']->last_op_msg_time = $params['chat']->last_user_msg_time = time();
            $params['chat']->last_msg_id = $msg->id;

            // All ok, we can make changes
            $params['chat']->updateThis(array('update' => array('last_msg_id', 'last_op_msg_time', 'status_sub', 'last_user_msg_time')));

            return array(
                'status' => erLhcoreClassChatEventDispatcher::STOP_WORKFLOW,
                'processed' => true,
                'raw_message' => '!schedule',
                'process_status' => erTranslationClassLhTranslation::getInstance()->getTranslation('chat/chatcommand', 'Schedule window was activate!')
            );
        }
    }

    public function widgetSettings($params) {
        $params['output']['static']['ex_cb_js']['cbscheduler'] = erLhcoreClassModelChatConfig::fetch('explicit_http_mode')->current_value . '//' . $_SERVER['HTTP_HOST'] . erLhcoreClassDesign::design('js/cbscheduler.widget.js') . '?v=4';
    }

    public function appendCallbacks($params) {

        if (!erLhcoreClassUser::instance()->hasAccessTo('lhcbscheduler','use_admin')){
            return ;
        }

        $limitation = erLhcoreClassChat::getDepartmentLimitation('lhc_cbscheduler_reservation');

        // Does not have any assigned department
        if ($limitation === false) {
            return array();
        }

        $filter = array('sort' => 'cb_time_start ASC');

        $filter['filter'] = array(
            'status' => erLhcoreClassModelCBSchedulerReservation::STATUS_SCHEDULED,
            'user_id' => erLhcoreClassUser::instance()->getUserID()
        );

        if ($limitation !== true) {
            $filter['customfilter'][] = $limitation;
        }

        $filter['limit'] = 10;
        $filter['offset'] = 0;
        $filter['smart_select'] = true;

        if (!empty($filterAdditional)) {
            $filter = array_merge_recursive($filter,$filterAdditional);
        }

        $filter['customfilter'][] = '`lhc_cbscheduler_reservation`.`id` IN (SELECT `id` FROM (SELECT `id` FROM `lhc_cbscheduler_reservation` ORDER BY `id` DESC LIMIT 100) AS `sq`)';

        $callbackscheduler = erLhcoreClassModelCBSchedulerReservation::getList($filter);

        erLhcoreClassChat::prefillGetAttributes($callbackscheduler,
            array('department_name','scheduler_for_front','time_till_call','time_till_call_seconds','region_lower'),
            array('dep')
        );

        $params['lists']['my_calls'] = array('list' => array_values($callbackscheduler));

        unset($filter['filter']['user_id']);
        $callbackscheduler = erLhcoreClassModelCBSchedulerReservation::getList($filter);

        erLhcoreClassChat::prefillGetAttributes($callbackscheduler,
            array('department_name','scheduler_for_front','time_till_call','time_till_call_seconds','region_lower','user_name_official'),
            array('dep')
        );

        $params['lists']['all_calls'] = array('list' => array_values($callbackscheduler));
    }

    // Department group was modified we have to assign new departments to a schedule
    public function departmentGroupModified($params) {
        $departmentsGroupsToResave = erLhcoreClassModelCBSchedulerSchedulerDepGroup::getList(['filter' => ['dep_group_id' => $params['department_group']->id]]);

        // Resave department group add add department
        foreach ($departmentsGroupsToResave as $depGroup) {
            $depGroup->afterSave();
        }
    }

    public static function getSession() {
        if (! isset ( self::$persistentSession )) {
            self::$persistentSession = new ezcPersistentSession ( ezcDbInstance::get (), new ezcPersistentCodeManager ( './extension/cbscheduler/pos' ) );
        }
        return self::$persistentSession;
    }

    public function autoload($className)
    {
        $classesArray = array(
            'erLhcoreClassModelCBSchedulerReservation' => 'extension/cbscheduler/classes/erlhcoreclassmodelcbschedulerreservation.php',
            'erLhcoreClassModelCBSchedulerScheduler' => 'extension/cbscheduler/classes/erlhcoreclassmodelcbschedulerscheduler.php',
            'erLhcoreClassModelCBSchedulerSchedulerDep' => 'extension/cbscheduler/classes/erlhcoreclassmodelcbschedulerschedulerdep.php',
            'erLhcoreClassModelCBSchedulerSchedulerDepGroup' => 'extension/cbscheduler/classes/erlhcoreclassmodelcbschedulerschedulerdepgroup.php',
            'erLhcoreClassModelCBSchedulerSlot' => 'extension/cbscheduler/classes/erlhcoreclassmodelcbschedulerslot.php',
            'erLhcoreClassCBSchedulerValidation' => 'extension/cbscheduler/classes/erlhcoreclasscbschedulervalidation.php',
            'erLhcoreClassModelCBSchedulerSubject' => 'extension/cbscheduler/classes/erlhcoreclassmodelcbschedulersubject.php',
            'erLhcoreClassModelCBSchedulerPhoneMode' => 'extension/cbscheduler/classes/erlhcoreclassmodelcbschedulerphonemode.php',
            'erLhcoreClassModelCBSchedulerPhoneTransform' => 'extension/cbscheduler/classes/erlhcoreclassmodelcbschedulerphonetransform.php',
            'ICS' => 'extension/cbscheduler/classes/ICS.php'
        );

        if (key_exists($className, $classesArray)) {
            include_once $classesArray[$className];
        }
    }

    public function loadInitialData($params)
    {
        $params['lists']['cbscheduler']['on_phone'] = erLhcoreClassModelCBSchedulerPhoneMode::getInstance(erLhcoreClassUser::instance()->getUserID())->on_phone;
    }

    public function registerAutoload() {
        spl_autoload_register ( array (
            $this,
            'autoload'
        ), true, false );
    }

    public function __get($var) {
        switch ($var) {

            case 'settings' :
                $this->settings = include ('extension/cbscheduler/settings/settings.ini.php');
                return $this->settings;
                break;

            default :
                ;
                break;
        }
    }

    private static $persistentSession;
}

?>