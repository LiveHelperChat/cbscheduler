<?php

$tpl = erLhcoreClassTemplate::getInstance('lhcbscheduler/options.tpl.php');

$cbOptions = erLhcoreClassModelChatConfig::fetch('lhcbscheduler_options');
$data = (array)$cbOptions->data;

if ( isset($_POST['StoreOptions']) ) {

    $definition = array(
        'block_numbers' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
        ),
        'days_upfront' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'int'
        ),
        'min_time' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'int'
        ),
        'auto_assign_timeout' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'int'
        ),
        'call_in_minutes' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'int'
        ),
        'allow_numbers' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
        ),
        'allow_countries' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
        ),
        'exclude_countries' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
        ),
        'terms_of_service' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
        ),
        'unique' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw',null,FILTER_REQUIRE_ARRAY
        ),
        'maintenance_mode' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
        )
    );

    $form = new ezcInputForm( INPUT_POST, $definition );
    $Errors = array();

    if ( $form->hasValidData( 'block_numbers' )) {
        $data['block_numbers'] = $form->block_numbers;
    } else {
        $data['block_numbers'] = '';
    }
    
    if ( $form->hasValidData( 'maintenance_mode' )) {
        $data['maintenance_mode'] = $form->maintenance_mode;
    } else {
        $data['maintenance_mode'] = '';
    }
    
    if ( $form->hasValidData( 'allow_countries' )) {
        $data['allow_countries'] = $form->allow_countries;
    } else {
        $data['allow_countries'] = '';
    }

    if ( $form->hasValidData( 'terms_of_service' )) {
        $data['terms_of_service'] = $form->terms_of_service;
    } else {
        $data['terms_of_service'] = '';
    }

    if ( $form->hasValidData( 'exclude_countries' )) {
        $data['exclude_countries'] = $form->exclude_countries;
    } else {
        $data['exclude_countries'] = '';
    }

    if ( $form->hasValidData( 'days_upfront' )) {
        $data['days_upfront'] = $form->days_upfront;
    } else {
        $data['days_upfront'] = '';
    }

    if ( $form->hasValidData( 'min_time' )) {
        $data['min_time'] = $form->min_time;
    } else {
        $data['min_time'] = '';
    }

    if ( $form->hasValidData( 'auto_assign_timeout' )) {
        $data['auto_assign_timeout'] = $form->auto_assign_timeout;
    } else {
        $data['auto_assign_timeout'] = '';
    }

    if ( $form->hasValidData( 'call_in_minutes' )) {
        $data['call_in_minutes'] = $form->call_in_minutes;
    } else {
        $data['call_in_minutes'] = '';
    }

    if ( $form->hasValidData( 'allow_numbers' )) {
        $data['allow_numbers'] = $form->allow_numbers;
    } else {
        $data['allow_numbers'] = '';
    }

    if ( $form->hasValidData( 'unique' )) {
        $data['unique'] = $form->unique;
    } else {
        $data['unique'] = [];
    }

    $cbOptions->explain = '';
    $cbOptions->type = 0;
    $cbOptions->hidden = 1;
    $cbOptions->identifier = 'lhcbscheduler_options';
    $cbOptions->value = serialize($data);
    $cbOptions->saveThis();

    $tpl->set('updated','done');
}

$tpl->set('cb_options',$data);

$Result['content'] = $tpl->fetch();

$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('cbscheduler/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler', 'Callback scheduler')
    ),
    array(
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler', 'Options')
    )
);

?>