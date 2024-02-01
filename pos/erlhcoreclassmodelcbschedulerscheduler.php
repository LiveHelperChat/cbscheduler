<?php

$def = new ezcPersistentObjectDefinition();
$def->table = "lhc_cbscheduler_scheduler";
$def->class = "erLhcoreClassModelCBSchedulerScheduler";

$def->idProperty = new ezcPersistentObjectIdProperty();
$def->idProperty->columnName = 'id';
$def->idProperty->propertyName = 'id';
$def->idProperty->generator = new ezcPersistentGeneratorDefinition(  'ezcPersistentNativeGenerator' );

$def->properties['name'] = new ezcPersistentObjectProperty();
$def->properties['name']->columnName   = 'name';
$def->properties['name']->propertyName = 'name';
$def->properties['name']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['tz'] = new ezcPersistentObjectProperty();
$def->properties['tz']->columnName   = 'tz';
$def->properties['tz']->propertyName = 'tz';
$def->properties['tz']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['status_configuration'] = new ezcPersistentObjectProperty();
$def->properties['status_configuration']->columnName   = 'status_configuration';
$def->properties['status_configuration']->propertyName = 'status_configuration';
$def->properties['status_configuration']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['active'] = new ezcPersistentObjectProperty();
$def->properties['active']->columnName   = 'active';
$def->properties['active']->propertyName = 'active';
$def->properties['active']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['multi_department'] = new ezcPersistentObjectProperty();
$def->properties['multi_department']->columnName   = 'multi_department';
$def->properties['multi_department']->propertyName = 'multi_department';
$def->properties['multi_department']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

return $def;

?>