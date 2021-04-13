<?php

$fieldsSearch = array();

$fieldsSearch['username'] = array (
    'type' => 'text',
    'trans' => 'Name',
    'required' => false,
    'valid_if_filled' => false,
    'filter_type' => 'like',
    'filter_table_field' => 'name',
    'validation_definition' => new ezcInputFormDefinitionElement (
        ezcInputFormDefinitionElement::OPTIONAL, 'string'
    )
);

$fieldsSearch['department_ids'] = array (
    'type' => 'text',
    'trans' => 'Department',
    'required' => false,
    'valid_if_filled' => false,
    'filter_type' => 'filterin',
    'filter_table_field' => 'dep_id',
    'validation_definition' => new ezcInputFormDefinitionElement(
        ezcInputFormDefinitionElement::OPTIONAL, 'int', array( 'min_range' => 0), FILTER_REQUIRE_ARRAY
    )
);

$fieldsSearch['department_group_ids'] = array (
    'type' => 'text',
    'trans' => 'Group',
    'required' => false,
    'valid_if_filled' => false,
    'filter_type' => false,
    'filter_table_field' => 'dep_id',
    'validation_definition' => new ezcInputFormDefinitionElement(
        ezcInputFormDefinitionElement::OPTIONAL, 'int', array( 'min_range' => 1), FILTER_REQUIRE_ARRAY
    )
);

$fieldsSearch['status'] = array (
    'type' => 'text',
    'trans' => 'Chats status',
    'required' => false,
    'valid_if_filled' => false,
    'filter_type' => 'filter',
    'filter_table_field' => 'status',
    'validation_definition' => new ezcInputFormDefinitionElement(
        ezcInputFormDefinitionElement::OPTIONAL, 'int', array( 'min_range' => 0,'max_range' => 1000)
    )
);

$fieldsSearch['timefrom'] = array (
    'type' => 'text',
    'trans' => 'Timefrom',
    'required' => false,
    'valid_if_filled' => false,
    'datatype' => 'datetime',
    'filter_type' => 'filtergte',
    'filter_table_field' => 'cb_time_start',
    'validation_definition' => new ezcInputFormDefinitionElement (
        ezcInputFormDefinitionElement::OPTIONAL, 'string'
    )
);

$fieldsSearch['timeto'] = array (
    'type' => 'text',
    'trans' => 'Timeto',
    'required' => false,
    'valid_if_filled' => false,
    'datatype' => 'datetime',
    'filter_type' => 'filterlte',
    'filter_table_field' => 'cb_time_start',
    'validation_definition' => new ezcInputFormDefinitionElement (
        ezcInputFormDefinitionElement::OPTIONAL, 'string'
    )
);

$fieldsSearch['user_ids'] = array (
    'type' => 'text',
    'trans' => 'Department',
    'required' => false,
    'valid_if_filled' => false,
    'filter_type' => 'filterin',
    'filter_table_field' => 'user_id',
    'validation_definition' => new ezcInputFormDefinitionElement(
        ezcInputFormDefinitionElement::OPTIONAL, 'int', array( 'min_range' => 0), FILTER_REQUIRE_ARRAY
    )
);

$fieldsSearch['group_ids'] = array (
    'type' => 'text',
    'trans' => 'Group',
    'required' => false,
    'valid_if_filled' => false,
    'filter_type' => false,
    'filter_table_field' => 'user_id',
    'validation_definition' => new ezcInputFormDefinitionElement(
        ezcInputFormDefinitionElement::OPTIONAL, 'int', array( 'min_range' => 1), FILTER_REQUIRE_ARRAY
    )
);

$fieldsSearch['sortby'] = array (
    'type' => 'text',
    'trans' => 'Sort by',
    'required' => false,
    'valid_if_filled' => false,
    'filter_type' => false,
    'filter_table_field' => 'user_id',
    'validation_definition' => new ezcInputFormDefinitionElement(
        ezcInputFormDefinitionElement::OPTIONAL, 'string')
);

$fieldSortAttr = array (
    'field'      => 'sortby',
    'default'    => 'iddesc',
    'serialised' => true,
    'options'    => array(
        'iddesc' => array('sort_column' => 'id DESC'),
        'idasc' => array('sort_column' => 'id ASC'),
        'schedulesasc' => array('sort_column' => 'cb_time_start ASC'),
        'schedulesdesc' => array('sort_column' => 'cb_time_start DESC')
    )
);

return array(
    'filterAttributes' => $fieldsSearch,
    'sortAttributes'   => $fieldSortAttr
);