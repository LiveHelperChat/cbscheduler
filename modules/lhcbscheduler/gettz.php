<?php

erLhcoreClassRestAPIHandler::setHeaders();

echo json_encode(DateTimeZone::listIdentifiers(DateTimeZone::ALL));

exit;
?>