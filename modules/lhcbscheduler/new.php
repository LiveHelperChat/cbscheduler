<?php

$tpl = erLhcoreClassTemplate::getInstance('lhcbscheduler/new.tpl.php');

$item = new erLhcoreClassModelCBSchedulerScheduler();

if (ezcInputForm::hasPostData()) {

    $items = array();

    $Errors = erLhcoreClassCBSchedulerValidation::validateCBSchedule($item);

    if (count($Errors) == 0) {
        try {
            $item->saveThis();

            erLhcoreClassModule::redirect('cbscheduler/schedules');
            exit;

        } catch (Exception $e) {
            $tpl->set('errors', array($e->getMessage()));
        }

    } else {
        $tpl->set('errors', $Errors);
    }
}


$tpl->set('item', $item);
$tpl->set('tab', '');

$Result['content'] = $tpl->fetch();

$Result['additional_footer_js'] = '<script type="text/javascript" language="javascript" src="' . erLhcoreClassDesign::designJS('js/cbscheduler.angular.js') . '"></script>';

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
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler', 'New')
    )
);

?>