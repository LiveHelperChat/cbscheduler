<?php

$def = new ezcPersistentObjectDefinition();
$def->table = "lhc_cbscheduler_reservation";
$def->class = "erLhcoreClassModelCBSchedulerReservation";

$def->idProperty = new ezcPersistentObjectIdProperty();
$def->idProperty->columnName = 'id';
$def->idProperty->propertyName = 'id';
$def->idProperty->generator = new ezcPersistentGeneratorDefinition(  'ezcPersistentNativeGenerator' );

$def->properties['slot_id'] = new ezcPersistentObjectProperty();
$def->properties['slot_id']->columnName   = 'slot_id';
$def->properties['slot_id']->propertyName = 'slot_id';
$def->properties['slot_id']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['chat_id'] = new ezcPersistentObjectProperty();
$def->properties['chat_id']->columnName   = 'chat_id';
$def->properties['chat_id']->propertyName = 'chat_id';
$def->properties['chat_id']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['schedule_id'] = new ezcPersistentObjectProperty();
$def->properties['schedule_id']->columnName   = 'schedule_id';
$def->properties['schedule_id']->propertyName = 'schedule_id';
$def->properties['schedule_id']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['dep_id'] = new ezcPersistentObjectProperty();
$def->properties['dep_id']->columnName   = 'dep_id';
$def->properties['dep_id']->propertyName = 'dep_id';
$def->properties['dep_id']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['tz'] = new ezcPersistentObjectProperty();
$def->properties['tz']->columnName   = 'tz';
$def->properties['tz']->propertyName = 'tz';
$def->properties['tz']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['outcome'] = new ezcPersistentObjectProperty();
$def->properties['outcome']->columnName   = 'outcome';
$def->properties['outcome']->propertyName = 'outcome';
$def->properties['outcome']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['cb_time_start'] = new ezcPersistentObjectProperty();
$def->properties['cb_time_start']->columnName   = 'cb_time_start';
$def->properties['cb_time_start']->propertyName = 'cb_time_start';
$def->properties['cb_time_start']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['cb_time_end'] = new ezcPersistentObjectProperty();
$def->properties['cb_time_end']->columnName   = 'cb_time_end';
$def->properties['cb_time_end']->propertyName = 'cb_time_end';
$def->properties['cb_time_end']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['status'] = new ezcPersistentObjectProperty();
$def->properties['status']->columnName   = 'status';
$def->properties['status']->propertyName = 'status';
$def->properties['status']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['code'] = new ezcPersistentObjectProperty();
$def->properties['code']->columnName   = 'code';
$def->properties['code']->propertyName = 'code';
$def->properties['code']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['name'] = new ezcPersistentObjectProperty();
$def->properties['name']->columnName   = 'name';
$def->properties['name']->propertyName = 'name';
$def->properties['name']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['email'] = new ezcPersistentObjectProperty();
$def->properties['email']->columnName   = 'email';
$def->properties['email']->propertyName = 'email';
$def->properties['email']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['phone'] = new ezcPersistentObjectProperty();
$def->properties['phone']->columnName   = 'phone';
$def->properties['phone']->propertyName = 'phone';
$def->properties['phone']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['description'] = new ezcPersistentObjectProperty();
$def->properties['description']->columnName   = 'description';
$def->properties['description']->propertyName = 'description';
$def->properties['description']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['subject_id'] = new ezcPersistentObjectProperty();
$def->properties['subject_id']->columnName   = 'subject_id';
$def->properties['subject_id']->propertyName = 'subject_id';
$def->properties['subject_id']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['daytime'] = new ezcPersistentObjectProperty();
$def->properties['daytime']->columnName   = 'daytime';
$def->properties['daytime']->propertyName = 'daytime';
$def->properties['daytime']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['ctime'] = new ezcPersistentObjectProperty();
$def->properties['ctime']->columnName   = 'ctime';
$def->properties['ctime']->propertyName = 'ctime';
$def->properties['ctime']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

// Operator who served a call
$def->properties['user_id'] = new ezcPersistentObjectProperty();
$def->properties['user_id']->columnName   = 'user_id';
$def->properties['user_id']->propertyName = 'user_id';
$def->properties['user_id']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['region'] = new ezcPersistentObjectProperty();
$def->properties['region']->columnName   = 'region';
$def->properties['region']->propertyName = 'region';
$def->properties['region']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['parent_id'] = new ezcPersistentObjectProperty();
$def->properties['parent_id']->columnName   = 'parent_id';
$def->properties['parent_id']->propertyName = 'parent_id';
$def->properties['parent_id']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

// Is phone number verified
$def->properties['verified'] = new ezcPersistentObjectProperty();
$def->properties['verified']->columnName   = 'verified';
$def->properties['verified']->propertyName = 'verified';
$def->properties['verified']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['status_accept'] = new ezcPersistentObjectProperty();
$def->properties['status_accept']->columnName   = 'status_accept';
$def->properties['status_accept']->propertyName = 'status_accept';
$def->properties['status_accept']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['tslasign'] = new ezcPersistentObjectProperty();
$def->properties['tslasign']->columnName   = 'tslasign';
$def->properties['tslasign']->propertyName = 'tslasign';
$def->properties['tslasign']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['log_actions'] = new ezcPersistentObjectProperty();
$def->properties['log_actions']->columnName   = 'log_actions';
$def->properties['log_actions']->propertyName = 'log_actions';
$def->properties['log_actions']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

return $def;

?>