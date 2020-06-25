<?php

$tpl = erLhcoreClassTemplate::getInstance('lhcbscheduler/newsubject.tpl.php');

$item = new erLhcoreClassModelCBSchedulerSubject();

if (ezcInputForm::hasPostData()) {

    $items = array();

    $Errors = erLhcoreClassCBSchedulerValidation::validateCBSubject($item);

    if (count($Errors) == 0) {
        try {
            $item->saveThis();

            erLhcoreClassModule::redirect('cbscheduler/subjects');
            exit ;

        } catch (Exception $e) {
            $tpl->set('errors',array($e->getMessage()));
        }

    } else {
        $tpl->set('errors',$Errors);
    }
}

$tpl->set('item', $item);

$Result['content'] = $tpl->fetch();

$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('cbscheduler/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler', 'Callback scheduler')
    ),
    array(
        'url' => erLhcoreClassDesign::baseurl('cbscheduler/subjects'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler', 'Subjects')
    ),
    array(
        'url' => erLhcoreClassDesign::baseurl('cbscheduler/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler', 'New subject')
    )
);

?>