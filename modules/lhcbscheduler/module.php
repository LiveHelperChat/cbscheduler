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
    'uparams' => array(),
    'functions' => array('use_admin'),
);

$ViewList['editreservation'] = array(
    'params' => array('id'),
    'uparams' => array(),
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

$ViewList['edit'] = array(
    'params' => array('id'),
    'uparams' => array(),
    'functions' => array('manage_schedule'),
);

$ViewList['schedule'] = array(
    'params' => array(),
    'uparams' => array('department','theme'),
);

$ViewList['schedulecb'] = array(
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

$FunctionList['use_admin'] = array('explain' => 'Allow operator to configure Callback Scheduler');
$FunctionList['manage_schedule'] = array('explain' => 'Allow operator to configure schedules');
$FunctionList['delete_reservation'] = array('explain' => 'Allow operator to delete reservations');