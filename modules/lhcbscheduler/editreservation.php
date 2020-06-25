<?php

$tpl = erLhcoreClassTemplate::getInstance('lhcbscheduler/editreservation.tpl.php');

$item =  erLhcoreClassModelCBSchedulerReservation::fetch($Params['user_parameters']['id']);

if (ezcInputForm::hasPostData()) {

    if (isset($_POST['Cancel_action'])) {
        erLhcoreClassModule::redirect('cbscheduler/reservations');
        exit ;
    }

    $Errors = erLhcoreClassCBSchedulerValidation::validateCBEditReservation($item);

    if (count($Errors) == 0) {
        try {
            $item->saveThis();

            if (isset($_POST['Update_page'])) {
                $tpl->set('updated',true);
            } else {
                erLhcoreClassModule::redirect('cbscheduler/reservations');
                exit;
            }

        } catch (Exception $e) {
            $tpl->set('errors',array($e->getMessage()));
        }

    } else {
        $tpl->set('errors',$Errors);
    }
}

$tpl->setArray(array(
    'item' => $item,
    'tab' => ''
));

$Result['content'] = $tpl->fetch();

$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('cbscheduler/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler', 'Callback scheduler')
    ),
    array(
        'url' => erLhcoreClassDesign::baseurl('cbscheduler/reservations'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler', 'Reservations')
    ),
    array(
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler', 'Edit')
    )
);

?>