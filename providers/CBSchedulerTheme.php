<?php

namespace LiveHelperChatExtension\cbscheduler\providers {
    #[\AllowDynamicProperties]
    class CBSchedulerTheme {
        public static function themeDefinition($params) {
            $params['fields']['cbscheduler_username'] = array(
                'type' => 'text',
                'main_attr' => 'bot_configuration_array',
                'translatable' => true,
                'trans' => \erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Use different title for username field'),
                'placeholder' => \erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Username*'),
                'required' => false,
                'hidden' => true,
                'nginit' => true,
                'validation_definition' => new \ezcInputFormDefinitionElement(
                    \ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
                ));

            $params['fields']['cbscheduler_schedule_title'] = array(
                'type' => 'text',
                'main_attr' => 'bot_configuration_array',
                'translatable' => true,
                'trans' => \erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Set custom schedule a callback title'),
                'placeholder' => \erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Schedule a callback'),
                'required' => false,
                'hidden' => true,
                'nginit' => true,
                'validation_definition' => new \ezcInputFormDefinitionElement(
                    \ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
                ));

            $params['fields']['cbscheduler_schedule_callback'] = array(
                'type' => 'text',
                'main_attr' => 'bot_configuration_array',
                'translatable' => true,
                'trans' => \erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Button title for schedule a callback action'),
                'placeholder' => \erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Schedule a callback'),
                'required' => false,
                'hidden' => true,
                'nginit' => true,
                'validation_definition' => new \ezcInputFormDefinitionElement(
                    \ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
                ));

            $params['fields']['cbscheduler_cancel_title'] = array(
                'type' => 'text',
                'main_attr' => 'bot_configuration_array',
                'translatable' => true,
                'trans' => \erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Set custom title in cancel a callback window'),
                'placeholder' => \erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Cancel a scheduled call'),
                'required' => false,
                'hidden' => true,
                'nginit' => true,
                'validation_definition' => new \ezcInputFormDefinitionElement(
                    \ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
                ));

            $params['fields']['cbscheduler_live_support'] = array(
                'type' => 'text',
                'main_attr' => 'bot_configuration_array',
                'translatable' => true,
                'trans' => \erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Go to agent button title on error'),
                'placeholder' => \erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Live support'),
                'required' => false,
                'hidden' => true,
                'nginit' => true,
                'validation_definition' => new \ezcInputFormDefinitionElement(
                    \ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
                ));

            $params['fields']['cbscheduler_cancel_action'] = array(
                'type' => 'text',
                'main_attr' => 'bot_configuration_array',
                'translatable' => true,
                'trans' => \erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Button title for cancel a scheduled call action'),
                'placeholder' => \erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Cancel a scheduled call'),
                'required' => false,
                'hidden' => true,
                'nginit' => true,
                'validation_definition' => new \ezcInputFormDefinitionElement(
                    \ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
                ));

            $params['fields']['cbscheduler_cancel_scheduled'] = array(
                'type' => 'text',
                'main_attr' => 'bot_configuration_array',
                'translatable' => true,
                'trans' => \erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Button title for navigation to cancel workflow page'),
                'placeholder' => \erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Cancel a scheduled call'),
                'required' => false,
                'hidden' => true,
                'nginit' => true,
                'validation_definition' => new \ezcInputFormDefinitionElement(
                    \ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
                ));

            $params['fields']['cbscheduler_call_scheduled'] = array(
                'type' => 'text',
                'main_attr' => 'bot_configuration_array',
                'translatable' => true,
                'trans' => \erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Confirmed scheduled callback text'),
                'placeholder' => \erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Thank you. Your call has been scheduled. You can add it to your calendar by clicking'),
                'required' => false,
                'hidden' => true,
                'nginit' => true,
                'validation_definition' => new \ezcInputFormDefinitionElement(
                    \ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
                ));

            $params['fields']['cbscheduler_cancel_success'] = array(
                'type' => 'text',
                'main_attr' => 'bot_configuration_array',
                'translatable' => true,
                'trans' => \erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Call cancel confirmation message, variables - {{d}}, {{M}}, {{Y}}, {{hour_start}}, {{hour_end}}'),
                'placeholder' => \erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Your call scheduled at {{d}} {{M}} {{Y}} between {{hour_start}} and {{hour_end}} has been canceled!'),
                'required' => false,
                'hidden' => true,
                'nginit' => true,
                'validation_definition' => new \ezcInputFormDefinitionElement(
                    \ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
                ));
        }
    }
}