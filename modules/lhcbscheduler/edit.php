<?php

$tpl = erLhcoreClassTemplate::getInstance('lhcbscheduler/edit.tpl.php');

$item =  erLhcoreClassModelCBSchedulerScheduler::fetch($Params['user_parameters']['id']);

if (ezcInputForm::hasPostData()) {

    if (isset($_POST['Cancel_action'])) {
        erLhcoreClassModule::redirect('cbscheduler/schedules');
        exit ;
    }

    $Errors = erLhcoreClassCBSchedulerValidation::validateCBSchedule($item);

    if (count($Errors) == 0) {
        try {
            $item->saveThis();

            if (isset($_POST['Update_page'])) {
                $tpl->set('updated',true);
            } else {
                erLhcoreClassModule::redirect('cbscheduler/schedules');
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

$Result['additional_footer_js'] = '<script type="text/javascript" language="javascript" src="'.erLhcoreClassDesign::designJS('js/cbscheduler.angular.js').'"></script>';

$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('cbscheduler/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler', 'Callback scheduler')
    ),
    array(
        'url' => erLhcoreClassDesign::baseurl('cbscheduler/schedules'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler', 'Schedules')
    ),
    array(
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler', 'Edit')
    )
);

?>