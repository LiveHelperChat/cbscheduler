<?php

erLhcoreClassRestAPIHandler::setHeaders();

erTranslationClassLhTranslation::$htmlEscape = false;

$requestPayload = json_decode(file_get_contents('php://input'), true);

// We change chat status to pending only if we have chat
if (isset($requestPayload['chat_id']) && is_numeric($requestPayload['chat_id']) && isset($requestPayload['hash'])) {

    $chat = erLhcoreClassModelChat::fetch($requestPayload['chat_id']);

    if ($chat instanceof erLhcoreClassModelChat && $chat->hash == $requestPayload['hash'] && in_array($chat->status, [erLhcoreClassModelChat::STATUS_ACTIVE_CHAT, erLhcoreClassModelChat::STATUS_PENDING_CHAT, erLhcoreClassModelChat::STATUS_BOT_CHAT])) {

        $msg = new erLhcoreClassModelmsg();
        $msg->msg = erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler', 'Visitor clicked go to an agent button!');
        $msg->chat_id = $chat->id;
        $msg->user_id = - 1;
        $msg->time = time();
        erLhcoreClassChat::getSession()->save($msg);

        // Transfer chat to pending state if required
        if ($chat->status == erLhcoreClassModelChat::STATUS_BOT_CHAT) {
            $chat->status = erLhcoreClassModelChat::STATUS_PENDING_CHAT;
            $chat->status_sub_sub = 2; // Will be used to indicate that we have to show notification for this chat if it appears on list
            $chat->pnd_time = time();
        }

        erLhcoreClassChatEventDispatcher::getInstance()->dispatch('cbscheduler.go_to_agent', array('chat' => & $chat));

        $chat->updateThis(['update' => ['pnd_time','status_sub_sub','status','last_msg_id']]);

    }
}


exit;

?>