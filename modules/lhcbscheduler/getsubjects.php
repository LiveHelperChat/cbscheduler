<?php

erLhcoreClassRestAPIHandler::setHeaders();

$department = (is_numeric($Params['user_parameters_unordered']['department']) && $Params['user_parameters_unordered']['department'] > 0 ? (int)$Params['user_parameters_unordered']['department'] : null);

$filter = [
    'sort' => '`pos` ASC, `name` ASC',
    'ignore_fields' => ['dep_ids', 'pos', 'active']
];

if ($department === null) {
    $filter['filterlor'] = array(
        'dep_ids' => array('','[]')
    );
} else {
    $filter['customfilter'] = array("(JSON_CONTAINS(`dep_ids`,'" . $department . "','$') OR dep_ids = '' OR dep_ids = '[]')");
}

echo json_encode(array_values(erLhcoreClassModelCBSchedulerSubject::getList($filter)));

exit;

?>