<?php

$def = new ezcPersistentObjectDefinition();
$def->table = "lhc_cbscheduler_scheduler_dep";
$def->class = "erLhcoreClassModelCBSchedulerSchedulerDep";

$def->idProperty = new ezcPersistentObjectIdProperty();
$def->idProperty->columnName = 'id';
$def->idProperty->propertyName = 'id';
$def->idProperty->generator = new ezcPersistentGeneratorDefinition(  'ezcPersistentNativeGenerator' );

$def->properties['schedule_id'] = new ezcPersistentObjectProperty();
$def->properties['schedule_id']->columnName   = 'schedule_id';
$def->properties['schedule_id']->propertyName = 'schedule_id';
$def->properties['schedule_id']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['dep_id'] = new ezcPersistentObjectProperty();
$def->properties['dep_id']->columnName   = 'dep_id';
$def->properties['dep_id']->propertyName = 'dep_id';
$def->properties['dep_id']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['dep_group_id'] = new ezcPersistentObjectProperty();
$def->properties['dep_group_id']->columnName   = 'dep_group_id';
$def->properties['dep_group_id']->propertyName = 'dep_group_id';
$def->properties['dep_group_id']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

return $def;

?>