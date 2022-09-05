<?php

erLhcoreClassRestAPIHandler::setHeaders();

erTranslationClassLhTranslation::$htmlEscape = false;

header('Cache-Control: max-age=84600');
header("Expires:".gmdate('D, d M Y H:i:s \G\M\T', time() + 3600));
header("Last-Modified: ".gmdate("D, d M Y H:i:s", time())." GMT");
header("Pragma: cache");
header("User-Cache-Control: max-age=84600");

$translations = array(
    "fields" => [
        "username" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Username*'),
        "subject" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Subject'),
        "email" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','E-mail*'),
        "phone" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Phone*'),
        "day" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Day'),
        "problem" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Describe the details of your query*'),
        "enter_phone" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Enter phone number*'),
        "choose_day" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Choose a day'),
        "schedule_callback" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Schedule a callback'),
        "choose_time" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Choose a time'),
        "time" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Time'),
        "include_country" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Please include country code in your phone number.'),
        "choose_subject" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Choose a subject*'),
        "call_scheduled" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Thank you. Your call has been scheduled. You can add it to your calendar by clicking'),
        "download" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','here'),
        "choose_day_time" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Choose day and time we should call you. Times are represented in'),
        "timezone" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','timezone.'),
        "choose_tz" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Choose other Time Zone'),
        "finish_edit" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Finish editing'),
        "no_free_days" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','At the moment we do not have any free slots for a callback.'),
        "schedule_title" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Schedule a callback'),
        "cancel_title" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Cancel a scheduled call'),
        "live_support" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Live support'),
        "try_again" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Try again'),
        "verification_failed" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','My username and e-mail verification failed to schedule a call.'),
        "close" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Close'),
        "loading" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Loading...'),
        "yes" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Yes'),
        "reschedule_option" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Would you like to reschedule for'),
        "between" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','between'),
        "and" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','and'),
        "cancel_scheduled" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Cancel a scheduled call'),
        "return" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Return'),
        "cancel_action" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Cancel a scheduled call'),
        "cancel_success" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Your call scheduled at {{d}} {{M}} {{Y}} between {{hour_start}} and {{hour_end}} has been canceled!')
    ]
);

if (isset($_GET['theme']) && !empty($_GET['theme']) && ($themeId = erLhcoreClassChat::extractTheme($_GET['theme'])) !== false) {
    $theme = erLhAbstractModelWidgetTheme::fetch($themeId);
    if ($theme instanceof erLhAbstractModelWidgetTheme) {
        $theme->translate();
        foreach (array('username','schedule_title','live_support','schedule_callback','call_scheduled','cancel_title','cancel_success','cancel_action') as $attrTranslateCore) {
            $attrTranslate = 'cbscheduler_' . $attrTranslateCore;
            if (isset($theme->bot_configuration_array[$attrTranslate]) && !empty($theme->bot_configuration_array[$attrTranslate])) {
                $translations['fields'][$attrTranslateCore] = $theme->bot_configuration_array[$attrTranslate];
            }
        }
    }
}

echo json_encode($translations);

exit;
?>