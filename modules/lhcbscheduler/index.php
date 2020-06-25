<?php
$tpl = erLhcoreClassTemplate::getInstance('lhcbscheduler/index.tpl.php');

$Result['content'] = $tpl->fetch();

$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('cbscheduler/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler', 'Callback scheduler')
    )
);

?>