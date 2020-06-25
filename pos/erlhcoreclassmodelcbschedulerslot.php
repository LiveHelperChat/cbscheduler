<?php

$def = new ezcPersistentObjectDefinition();
$def->table = "lhc_cbscheduler_slot";
$def->class = "erLhcoreClassModelCBSchedulerSlot";

$def->idProperty = new ezcPersistentObjectIdProperty();
$def->idProperty->columnName = 'id';
$def->idProperty->propertyName = 'id';
$def->idProperty->generator = new ezcPersistentGeneratorDefinition(  'ezcPersistentNativeGenerator' );

$def->properties['schedule_id'] = new ezcPersistentObjectProperty();
$def->properties['schedule_id']->columnName   = 'schedule_id';
$def->properties['schedule_id']->propertyName = 'schedule_id';
$def->properties['schedule_id']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['time_start_h'] = new ezcPersistentObjectProperty();
$def->properties['time_start_h']->columnName   = 'time_start_h';
$def->properties['time_start_h']->propertyName = 'time_start_h';
$def->properties['time_start_h']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['time_start_m'] = new ezcPersistentObjectProperty();
$def->properties['time_start_m']->columnName   = 'time_start_m';
$def->properties['time_start_m']->propertyName = 'time_start_m';
$def->properties['time_start_m']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['time_end_h'] = new ezcPersistentObjectProperty();
$def->properties['time_end_h']->columnName   = 'time_end_h';
$def->properties['time_end_h']->propertyName = 'time_end_h';
$def->properties['time_end_h']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['time_end_m'] = new ezcPersistentObjectProperty();
$def->properties['time_end_m']->columnName   = 'time_end_m';
$def->properties['time_end_m']->propertyName = 'time_end_m';
$def->properties['time_end_m']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['max_calls'] = new ezcPersistentObjectProperty();
$def->properties['max_calls']->columnName   = 'max_calls';
$def->properties['max_calls']->propertyName = 'max_calls';
$def->properties['max_calls']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['active'] = new ezcPersistentObjectProperty();
$def->properties['active']->columnName   = 'active';
$def->properties['active']->propertyName = 'active';
$def->properties['active']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['day'] = new ezcPersistentObjectProperty();
$def->properties['day']->columnName   = 'day';
$def->properties['day']->propertyName = 'day';
$def->properties['day']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

return $def;

?>