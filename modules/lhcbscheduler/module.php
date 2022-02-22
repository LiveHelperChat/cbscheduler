<?php

$Module = array( "name" => "Callback Scheduler" );

$ViewList = array();

$ViewList['index'] = array(
    'params' => array(),
    'functions' => array('use_admin'),
);

$ViewList['schedules'] = array(
    'params' => array(),
    'uparams' => array(),
    'functions' => array('manage_schedule'),
);

$ViewList['subjects'] = array(
    'params' => array(),
    'uparams' => array(),
    'functions' => array('manage_schedule'),
);

$ViewList['reservations'] = array(
    'params' => array(),
    'uparams' => array(
        'status',
        'department_ids',
        'department_group_ids',
        'username',
        'timefrom',
        'timefrom_hours',
        'timefrom_minutes',
        'timeto',
        'timeto_hours',
        'timeto_minutes',
        'user_ids',
        'group_ids',
        'sortby',
    ),
    'functions' => array('use_admin'),
    'multiple_arguments' => array(
        'department_ids',
        'department_group_ids',
        'user_ids',
        'group_ids',
    )
);

$ViewList['editreservation'] = array(
    'params' => array('id'),
    'uparams' => array('mode'),
    'functions' => array('use_admin'),
);

$ViewList['logreservation'] = array(
    'params' => array('id'),
    'uparams' => array('mode'),
    'functions' => array('use_admin'),
);

$ViewList['assigntome'] = array(
    'params' => array('id'),
    'uparams' => array('action'),
    'functions' => array('use_admin'),
);

$ViewList['deletereservation'] = array(
    'params' => array('id'),
    'uparams' => array('csfr'),
    'functions' => array('delete_reservation'),
);

$ViewList['delete'] = array(
    'params' => array('id'),
    'uparams' => array('csfr'),
    'functions' => array('manage_schedule'),
);

$ViewList['options'] = array(
    'params' => array(),
    'uparams' => array(),
    'functions' => array('manage_schedule'),
);

$ViewList['deletesubject'] = array(
    'params' => array('id'),
    'uparams' => array('csfr'),
    'functions' => array('manage_schedule'),
);

$ViewList['new'] = array(
    'params' => array(),
    'uparams' => array(),
    'functions' => array('manage_schedule'),
);

$ViewList['newsubject'] = array(
    'params' => array(),
    'uparams' => array(),
    'functions' => array('manage_schedule'),
);

$ViewList['editsubject'] = array(
    'params' => array('id'),
    'uparams' => array(),
    'functions' => array('manage_schedule'),
);

$ViewList['transforms'] = array(
    'params' => array(),
    'uparams' => array(),
    'functions' => array('manage_schedule'),
);

$ViewList['newtransform'] = array(
    'params' => array(),
    'uparams' => array(),
    'functions' => array('manage_schedule'),
);

$ViewList['edittransform'] = array(
    'params' => array('id'),
    'uparams' => array(),
    'functions' => array('manage_schedule'),
);

$ViewList['deletetransform'] = array(
    'params' => array('id'),
    'uparams' => array('csfr'),
    'functions' => array('manage_schedule'),
);

$ViewList['edit'] = array(
    'params' => array('id'),
    'uparams' => array(),
    'functions' => array('manage_schedule'),
);

$ViewList['schedule'] = array(
    'params' => array(),
    'uparams' => array('department','theme'),
);

$ViewList['scheduleadmin'] = array(
    'params' => array(),
    'uparams' => array('department','parent'),
    'functions' => array('use_admin'),
);

$ViewList['previewcall'] = array(
    'params' => array('id'),
    'uparams' => array(),
    'functions' => array('use_admin'),
);

$ViewList['schedulecb'] = array(
    'params' => array(),
    'uparams' => array('department'),
);

$ViewList['cancelschedulecb'] = array(
    'params' => array(),
    'uparams' => array('department'),
);

$ViewList['lang'] = array(
    'params' => array(),
    'uparams' => array(),
);

$ViewList['download'] = array(
    'params' => array('id','code'),
    'uparams' => array(),
);

$ViewList['getdays'] = array(
    'params' => array(),
    'uparams' => array('department', 'chat', 'vid', 'theme'),
    'functions' => array(),
);

$ViewList['gettimes'] = array(
    'params' => array('day'),
    'uparams' => array('department','chat'),
    'functions' => array(),
);

$ViewList['getsubjects'] = array(
    'params' => array(),
    'uparams' => array(),
    'functions' => array(),
);

$ViewList['gotoagent'] = array(
    'params' => array(),
    'uparams' => array(),
    'functions' => array(),
);

$ViewList['phonemode'] = array(
    'params' => array('status','user_id'),
    'functions' => array('use_admin'),
);

$ViewList['onlineoperators'] = array(
    'params' => array(),
    'uparams' => array('dep_id','call_id'),
    'functions' => array('use_admin'),
);

$ViewList['getnofificationsdata'] = array(
    'params' => array(),
    'uparams' => array('id'),
    'functions' => array('use_admin'),
    'multiple_arguments' => array(
        'id'
    )
);

$FunctionList['use_admin'] = array('explain' => 'Allow operator to see reservations');
$FunctionList['manage_schedule'] = array('explain' => 'Allow operator to configure schedules');
$FunctionList['delete_reservation'] = array('explain' => 'Allow operator to delete reservations');
$FunctionList['manage_assignment'] = array('explain' => 'Allow operator to manage assignment manually');
$FunctionList['change_phone_mode'] = array('explain' => 'Allow operator to change other operators phone mode');
