<?php

$tpl = erLhcoreClassTemplate::getInstance('lhcbscheduler/editreservation.tpl.php');

$item = erLhcoreClassModelCBSchedulerReservation::fetch($Params['user_parameters']['id']);

// Accept call on open if chat is assigned to same user and it's waiting for acceptance
if ($item->user_id == erLhcoreClassUser::instance()->getUserID() && $item->status_accept == erLhcoreClassModelCBSchedulerReservation::PENDING_ACCEPT) {
    $item->status_accept = erLhcoreClassModelCBSchedulerReservation::CALL_ACCEPTED;
    $item->updateThis(array('update' => array('status_accept')));
}

if (ezcInputForm::hasPostData()) {

    if (isset($_POST['Cancel_action'])) {
        erLhcoreClassModule::redirect('cbscheduler/reservations');
        exit ;
    }

    $Errors = erLhcoreClassCBSchedulerValidation::validateCBEditReservation($item, array('user' => $currentUser->getUserData(true), 'user_id' => $currentUser->getUserID()));

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

if ($Params['user_parameters_unordered']['mode'] == 'modal') {
    $Result['pagelayout'] = 'chattabs';
    $tpl->set('is_modal',true);
}

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