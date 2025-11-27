<?php

$def = new ezcPersistentObjectDefinition();
$def->table = "lhc_cbscheduler_reservation";
$def->class = "erLhcoreClassModelCBSchedulerReservation";

$def->idProperty = new ezcPersistentObjectIdProperty();
$def->idProperty->columnName = 'id';
$def->idProperty->propertyName = 'id';
$def->idProperty->generator = new ezcPersistentGeneratorDefinition(  'ezcPersistentNativeGenerator' );

// Integer type properties
$intProperties = [
    'slot_id',
    'chat_id',
    'schedule_id',
    'dep_id',
    'cb_time_start',
    'cb_time_end',
    'status',
    'subject_id',
    'daytime',
    'ctime',
    'user_id',        // Operator who served a call
    'parent_id',
    'verified',       // Is phone number verified
    'status_accept',
    'tslasign'
];

foreach ($intProperties as $property) {
    $def->properties[$property] = new ezcPersistentObjectProperty();
    $def->properties[$property]->columnName   = $property;
    $def->properties[$property]->propertyName = $property;
    $def->properties[$property]->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;
}

// String type properties
$stringProperties = [
    'tz',
    'outcome',
    'attr_system',
    'code',
    'name',
    'email',
    'phone',
    'description',
    'region',
    'log_actions'
];

foreach ($stringProperties as $property) {
    $def->properties[$property] = new ezcPersistentObjectProperty();
    $def->properties[$property]->columnName   = $property;
    $def->properties[$property]->propertyName = $property;
    $def->properties[$property]->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;
}

return $def;

?>