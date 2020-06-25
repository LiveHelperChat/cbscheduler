<?php

erLhcoreClassRestAPIHandler::setHeaders();

echo json_encode(array_values(erLhcoreClassModelCBSchedulerSubject::getList()));

exit;

?>