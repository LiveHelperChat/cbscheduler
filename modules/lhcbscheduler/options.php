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
        'allow_numbers' => new ezcInputFormDefinitionElement(
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

    if ( $form->hasValidData( 'days_upfront' )) {
        $data['days_upfront'] = $form->days_upfront;
    } else {
        $data['days_upfront'] = '';
    }

    if ( $form->hasValidData( 'allow_numbers' )) {
        $data['allow_numbers'] = $form->allow_numbers;
    } else {
        $data['allow_numbers'] = '';
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