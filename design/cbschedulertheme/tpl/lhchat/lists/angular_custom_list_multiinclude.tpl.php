<?php if (trim($frontTab) == 'cbscheduler') : ?>
    <div role="tabpanel" class="tab-pane form-group<?php (int)erLhcoreClassModelUserSetting::getSetting('hide_tabs',1) == 1 ? print ' mt-3' : ''?>" id="cbscheduler">
        <div class="row">
            <div class="col-6">

                <?php
                $permissionsWidget = [];
                $optionsPanel = ["panelid" => "my_calls", "limitid" => "limitmy_calls","userid" => "my_callsu"];

                /* Icons in the list */
                $iconData = [];
                $iconData['icon_attr'] = 'id';
                $iconData['icon_attr_type'] = 'string';
                $iconData['icon_attr_prepend'] = '[';
                $iconData['icon_attr_append'] = '] ';
                $optionsPanel['custom_icons'][] = $iconData;

                // Assignment status
                $iconData = [];
                $iconData['class'] = 'material-icons text-success';
                $iconData['class_false'] = ['text-warning' => 'status_accept'];
                $iconData['icon_attr'] = 'user_id';
                $iconData['icon_attr_type'] = 'bool';
                $iconData['icon_attr_true'] = 'assignment_ind';
                $iconData['title'] = 'Acceptance status';
                $optionsPanel['custom_icons'][] = $iconData;

                // Verified
                $iconData = [];
                $iconData['class'] = 'material-icons';
                $iconData['class_false'] = ['text-danger' => 'verified'];
                $iconData['class_true'] = ['text-success' => 'verified'];
                $iconData['icon_attr'] = 'verified';
                $iconData['icon_attr_type'] = 'bool';
                $iconData['icon_attr_true'] = 'verified_user';
                $iconData['icon_attr_false'] = 'help_outline';
                $optionsPanel['custom_icons'][] = $iconData;

                /* <span ng-if="!chat.status" ng-class="{'bg-danger': chat.time_till_call_seconds <= 0}" class="badge mx-2 badge-warning"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Scheduled');?></span> */
                $iconData = [];
                $iconData['class'] = 'badge mx-2 bg-warning';
                $iconData['class_true'] = ['bg-danger' => 'time_till_call_seconds_neg'];
                $iconData['icon_attr'] = 'status';
                $iconData['icon_attr_type'] = 'bool';
                $iconData['icon_attr_false'] = 'Scheduled';
                $optionsPanel['custom_icons'][] = $iconData;

                /* <span ng-if="chat.status == 1" class="badge mx-2 bg-success"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Completed');?></span> */
                $iconData = [];
                $iconData['class'] = 'badge mx-2 bg-success';
                $iconData['icon_attr'] = 'status';
                $iconData['icon_attr_type'] = 'cmp';
                $iconData['icon_attr_val'] = '1';
                $iconData['icon_attr_true'] = 'Completed';
                $optionsPanel['custom_icons'][] = $iconData;

                /* <span ng-if="chat.status == 2" class="badge mx-2 bg-danger"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Canceled');?></span> */
                $iconData = [];
                $iconData['class'] = 'badge mx-2 bg-danger';
                $iconData['icon_attr'] = 'status';
                $iconData['icon_attr_type'] = 'cmp';
                $iconData['icon_attr_val'] = '2';
                $iconData['icon_attr_true'] = 'Canceled';
                $optionsPanel['custom_icons'][] = $iconData;

                /*  <span ng-if="chat.status == 3" class="badge mx-2 bg-danger"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Not Answered');?></span> */
                $iconData = [];
                $iconData['class'] = 'badge mx-2 bg-danger';
                $iconData['icon_attr'] = 'status';
                $iconData['icon_attr_type'] = 'cmp';
                $iconData['icon_attr_val'] = '3';
                $iconData['icon_attr_true'] = 'Not Answered';
                $optionsPanel['custom_icons'][] = $iconData;

                // Time till call
                $iconData = [];
                $iconData['icon_attr'] = 'time_till_call';
                $iconData['icon_attr_type'] = 'string';
                $iconData['class'] = 'fw-bold';
                $optionsPanel['custom_icons'][] = $iconData;


                // Schedule for
                $iconData = [];
                $iconData['icon_attr'] = 'scheduler_for_front';
                $iconData['icon_attr_type'] = 'string';
                $iconData['icon_attr_prepend'] = ' | ';
                $optionsPanel['custom_icons'][] = $iconData;

                ?>

                <lhc-widget hide_2_column="true" custom_visitor_icon="access_time" custom_visitor_title="time_to_call" show_visitor_title="true" show_username_title="true" show_subject_title="true" show_department_title="true" icon_class="chat-active" show_always_subject="true" column_1_width="60%" override_item_open="callbackModalOpen" no_chat_preview="true" no_additional_column="true" card_icon="phone" url="<?php echo erLhcoreClassDesign::baseurl('cbscheduler/reservations')?>/(user_ids)/<?php echo erLhcoreClassUser::instance()->getUserID()?>/(status)/0/(sortby)/schedulesasc"  no_expand="true" no_collapse="true" hide_filter_options="true" additional_sort="active_chats_sort" no_duration="true" type="my_calls" status_id="1" list_identifier="my_calls" panel_list_identifier="my_calls-panel-list" optionsPanel='<?php echo json_encode($optionsPanel);?>' www_dir_flags="<?php echo erLhcoreClassDesign::design('images/flags');?>"></lhc-widget>

                <?php /*

                <div class="card card-dashboard">
                    <div class="card-header">
                        <a href="<?php echo erLhcoreClassDesign::baseurl('cbscheduler/reservations')?>/(user_ids)/<?php echo erLhcoreClassUser::instance()->getUserID()?>/(status)/0/(sortby)/schedulesasc"><i class="material-icons chat-active">phone</i>My calls</a>
                    </div>
                    <div>
                        <div ng-if="my_calls && my_calls.list.length > 0" class="panel-list">
                            <table class="table table-sm mb-0 table-small table-fixed list-chat-table">
                                <thead>
                                <tr>
                                    <th width="70%"><i title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Visitor');?>" class="material-icons">access_time</i> Time of the callback</th>
                                    <th width="15%"><i title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Subject');?>" class="material-icons">home</i> Subject</th>
                                    <th width="15%"><i title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Department');?>" class="material-icons">home</i> Department</th>
                                </tr>
                                </thead>
                                <tr ng-repeat="chat in my_calls.list track by chat.id" data-id="{{chat.id}}" onclick="return lhc.revealModal({'title':'Edit reservation','iframe':true,'height':700, 'url':WWW_DIR_JAVASCRIPT +'cbscheduler/editreservation/'+$(this).attr('data-id')+'/(mode)/modal'})">
                                    <td>
                                        <div class="abbr-list">
                                            [{{chat.id}}]
                                            <a ng-if="!chat.status_accept" title="Acceptance status" ng-class="{'text-warning':!chat.status_accept}" class="material-icons">assignment_ind</a><i ng-class="{'text-success' : chat.verified, 'text-danger': !chat.verified}" class="material-icons">{{chat.verified ? 'verified_user' : 'help_outline'}}</i><img src="<?php echo erLhcoreClassDesign::design('images/flags'); ?>/{{chat.region_lower}}.png" alt="" />
                                            <span ng-if="!chat.status" ng-class="{'bg-danger': chat.time_till_call_seconds <= 0}" class="badge mx-2 badge-warning"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Scheduled');?></span>
                                            <span ng-if="chat.status == 1" class="badge mx-2 bg-success"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Completed');?></span>
                                            <span ng-if="chat.status == 2" class="badge mx-2 bg-danger"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Canceled');?></span>
                                            <span ng-if="chat.status == 3" class="badge mx-2 bg-danger"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Not Answered');?></span>
                                            <b>{{chat.time_till_call}}</b> | {{chat.scheduler_for_front}}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="abbr-list" title="{{chat.subject_id}}">{{chat.subject_front}}</div>
                                    </td>
                                    <td>
                                        <div class="abbr-list" title="{{chat.department_name}}}">{{chat.department_name}}</div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div ng-if="!my_calls || my_calls.list.length == 0" class="m-1 alert alert-light"><i class="material-icons">search</i><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Calls assigned to you will appear here. List includes pending and active calls.')?></div>
                    </div>
                </div>*/ ?>



            </div>
            <div class="col-6">
                    <?php
                    $permissionsWidget = [];
                    $optionsPanel = ["panelid" => "all_calls", "limitid" => "limitall_calls","userid" => "all_callsu"];

                    /* Icons in the list */
                    $iconData = [];
                    $iconData['icon_attr'] = 'id';
                    $iconData['icon_attr_type'] = 'string';
                    $iconData['icon_attr_prepend'] = '[';
                    $iconData['icon_attr_append'] = '] ';
                    $optionsPanel['custom_icons'][] = $iconData;

                    // Assignment status
                    $iconData = [];
                    $iconData['class'] = 'material-icons text-success';
                    $iconData['class_false'] = ['text-warning' => 'status_accept'];
                    $iconData['icon_attr'] = 'user_id';
                    $iconData['icon_attr_type'] = 'bool';
                    $iconData['icon_attr_true'] = 'assignment_ind';
                    $iconData['title'] = 'Acceptance status';
                    $optionsPanel['custom_icons'][] = $iconData;

                    // Verified
                    $iconData = [];
                    $iconData['class'] = 'material-icons';
                    $iconData['class_false'] = ['text-danger' => 'verified'];
                    $iconData['class_true'] = ['text-success' => 'verified'];
                    $iconData['icon_attr'] = 'verified';
                    $iconData['icon_attr_type'] = 'bool';
                    $iconData['icon_attr_true'] = 'verified_user';
                    $iconData['icon_attr_false'] = 'help_outline';
                    $optionsPanel['custom_icons'][] = $iconData;

                    /* <span ng-if="!chat.status" ng-class="{'bg-danger': chat.time_till_call_seconds <= 0}" class="badge mx-2 badge-warning"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Scheduled');?></span> */
                    $iconData = [];
                    $iconData['class'] = 'badge mx-2 bg-warning';
                    $iconData['class_true'] = ['bg-danger' => 'time_till_call_seconds_neg'];
                    $iconData['icon_attr'] = 'status';
                    $iconData['icon_attr_type'] = 'bool';
                    $iconData['icon_attr_false'] = 'Scheduled';
                    $optionsPanel['custom_icons'][] = $iconData;

                    /* <span ng-if="chat.status == 1" class="badge mx-2 bg-success"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Completed');?></span> */
                    $iconData = [];
                    $iconData['class'] = 'badge mx-2 bg-success';
                    $iconData['icon_attr'] = 'status';
                    $iconData['icon_attr_type'] = 'cmp';
                    $iconData['icon_attr_val'] = '1';
                    $iconData['icon_attr_true'] = 'Completed';
                    $optionsPanel['custom_icons'][] = $iconData;

                    /* <span ng-if="chat.status == 2" class="badge mx-2 bg-danger"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Canceled');?></span> */
                    $iconData = [];
                    $iconData['class'] = 'badge mx-2 bg-danger';
                    $iconData['icon_attr'] = 'status';
                    $iconData['icon_attr_type'] = 'cmp';
                    $iconData['icon_attr_val'] = '2';
                    $iconData['icon_attr_true'] = 'Canceled';
                    $optionsPanel['custom_icons'][] = $iconData;

                    /*  <span ng-if="chat.status == 3" class="badge mx-2 bg-danger"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Not Answered');?></span> */
                    $iconData = [];
                    $iconData['class'] = 'badge mx-2 bg-danger';
                    $iconData['icon_attr'] = 'status';
                    $iconData['icon_attr_type'] = 'cmp';
                    $iconData['icon_attr_val'] = '3';
                    $iconData['icon_attr_true'] = 'Not Answered';
                    $optionsPanel['custom_icons'][] = $iconData;

                    // Time till call
                    $iconData = [];
                    $iconData['icon_attr'] = 'time_till_call';
                    $iconData['icon_attr_type'] = 'string';
                    $iconData['class'] = 'fw-bold';
                    $optionsPanel['custom_icons'][] = $iconData;

                    // Schedule for
                    $iconData = [];
                    $iconData['icon_attr'] = 'scheduler_for_front';
                    $iconData['icon_attr_type'] = 'string';
                    $iconData['icon_attr_prepend'] = ' | ';
                    $optionsPanel['custom_icons'][] = $iconData;

                    ?>

                    <lhc-widget hide_2_column="true" custom_visitor_icon="access_time" custom_visitor_title="time_to_call" show_visitor_title="true" show_username_title="true" show_subject_title="true" show_department_title="true" no_expand="true" show_always_subject="true" column_1_width="60%" show_username_always="true" override_item_open="callbackModalOpen" no_chat_preview="true" no_additional_column="true" card_icon="phone" url="<?php echo erLhcoreClassDesign::baseurl('cbscheduler/reservations')?>/(status)/0/(sortby)/schedulesasc" custom_settings_url="cbscheduler/onlineoperators" custom_settings_url_icon="bar_chart" no_collapse="true" hide_filter_options="true" additional_sort="active_chats_sort" no_duration="true" type="all_calls" status_id="1" list_identifier="all_calls" panel_list_identifier="all_calls-panel-list" optionsPanel='<?php echo json_encode($optionsPanel);?>' www_dir_flags="<?php echo erLhcoreClassDesign::design('images/flags');?>"></lhc-widget>

<?php /*

                <div class="card card-dashboard">
                    <div class="card-header">
                        <i title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Live operators online status');?>" class="material-icons me-0 action-image"  onclick="return lhc.revealModal({'url':WWW_DIR_JAVASCRIPT +'cbscheduler/onlineoperators'})">bar_chart</i>
                        <a href="<?php echo erLhcoreClassDesign::baseurl('cbscheduler/reservations')?>/(status)/0/(sortby)/schedulesasc"><i class="material-icons chat-pending">phone</i>All pending calls</a>
                    </div>
                    <div>
                        <div ng-if="all_calls && all_calls.list.length > 0" class="panel-list">
                            <table class="table table-sm mb-0 table-small table-fixed list-chat-table">
                                <thead>
                                <tr>
                                    <th width="60%"><i title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Visitor');?>" class="material-icons">access_time</i> Time of the callback</th>
                                    <th width="20%"><i title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Agent');?>" class="material-icons">face</i> Agent</th>
                                    <th width="20%"><i title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Subject');?>" class="material-icons">label</i> Subject</th>
                                    <th width="20%"><i title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Department');?>" class="material-icons">home</i> Department</th>
                                </tr>
                                </thead>
                                <tr ng-repeat="chat in all_calls.list track by chat.id" data-id="{{chat.id}}" onclick="return lhc.revealModal({'title':'Edit reservation','iframe':true,'height':700, 'url':WWW_DIR_JAVASCRIPT +'cbscheduler/editreservation/'+$(this).attr('data-id')+'/(mode)/modal'})">
                                    <td>
                                        <div class="abbr-list">
                                            [{{chat.id}}]

                                            <a ng-if="chat.user_id" title="Acceptance status" ng-class="{'text-warning':!chat.status_accept}" class="material-icons text-success">assignment_ind</a>
 <i ng-class="{'text-success' : chat.verified, 'text-danger': !chat.verified}" class="material-icons">{{chat.verified ? 'verified_user' : 'help_outline'}}</i>
 <img src="<?php echo erLhcoreClassDesign::design('images/flags'); ?>/{{chat.region_lower}}.png" alt="" />



                                            <span ng-if="!chat.status" ng-class="{'bg-danger': chat.time_till_call_seconds <= 0}" class="badge mx-2 badge-warning"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Scheduled');?></span>
                                            <span ng-if="chat.status == 1" class="badge mx-2 bg-success"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Completed');?></span>
                                            <span ng-if="chat.status == 2" class="badge mx-2 bg-danger"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Canceled');?></span>
                                            <span ng-if="chat.status == 3" class="badge mx-2 bg-danger"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Not Answered');?></span>



                                            <b>{{chat.time_till_call}}</b> | {{chat.scheduler_for_front}}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="abbr-list" title="{{chat.user_name_official}}">{{chat.user_name_official}}</div>
                                    </td>
                                    <td>
                                        <div class="abbr-list" title="{{chat.subject_id}}">{{chat.subject_front}}</div>
                                    </td>
                                    <td>
                                        <div class="abbr-list" title="{{chat.department_name}}}">{{chat.department_name}}</div>
                                    </td>
                                </tr>
                            </table>
                        </div>



                        <div ng-if="!all_calls || all_calls.list.length == 0" class="m-1 alert alert-light"><i class="material-icons">search</i><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Active/pending calls will appear here')?></div>
                    </div>
                </div>
                */ ?>


            </div>
        </div>
    </div>
<?php endif; ?>
