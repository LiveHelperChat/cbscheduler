<?php

$tpl = erLhcoreClassTemplate::getInstance('lhcbscheduler/editsubject.tpl.php');

$item =  erLhcoreClassModelCBSchedulerSubject::fetch($Params['user_parameters']['id']);

if (ezcInputForm::hasPostData()) {

    if (isset($_POST['Cancel_action'])) {
        erLhcoreClassModule::redirect('cbscheduler/subjects');
        exit ;
    }

    $Errors = erLhcoreClassCBSchedulerValidation::validateCBSubject($item);

    if (count($Errors) == 0) {
        try {
            $item->saveThis();

            if (isset($_POST['Update_page'])) {
                $tpl->set('updated',true);
            } else {
                erLhcoreClassModule::redirect('cbscheduler/subjects');
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
));

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
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler', 'Edit subject')
    )
);

?>