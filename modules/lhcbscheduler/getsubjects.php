<?php

erLhcoreClassRestAPIHandler::setHeaders();

echo json_encode(array_values(erLhcoreClassModelCBSchedulerSubject::getList(['sort' => '`pos` ASC, `name` ASC'])));
exit;

?>