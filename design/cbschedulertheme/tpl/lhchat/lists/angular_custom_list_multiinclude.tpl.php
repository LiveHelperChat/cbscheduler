<?php if (trim($frontTab) == 'cbscheduler') : ?>
    <div role="tabpanel" class="tab-pane form-group<?php (int)erLhcoreClassModelUserSetting::getSetting('hide_tabs',1) == 1 ? print ' mt-3' : ''?>" id="cbscheduler">
        <div class="row">
            <div class="col-6">
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
                                            <span ng-if="!chat.status" ng-class="{'badge-danger': chat.time_till_call_seconds <= 0}" class="badge mx-2 badge-warning"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Scheduled');?></span>
                                            <span ng-if="chat.status == 1" class="badge mx-2 badge-success"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Completed');?></span>
                                            <span ng-if="chat.status == 2" class="badge mx-2 badge-danger"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Canceled');?></span>
                                            <span ng-if="chat.status == 3" class="badge mx-2 badge-danger"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Not Answered');?></span>
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
                </div>
            </div>
            <div class="col-6">
                <div class="card card-dashboard">
                    <div class="card-header">
                        <i title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Live operators online status');?>" class="material-icons mr-0 action-image"  onclick="return lhc.revealModal({'url':WWW_DIR_JAVASCRIPT +'cbscheduler/onlineoperators'})">bar_chart</i>
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
                                            <a ng-if="chat.user_id" title="Acceptance status" ng-class="{'text-warning':!chat.status_accept}" class="material-icons text-success">assignment_ind</a><i ng-class="{'text-success' : chat.verified, 'text-danger': !chat.verified}" class="material-icons">{{chat.verified ? 'verified_user' : 'help_outline'}}</i><img src="<?php echo erLhcoreClassDesign::design('images/flags'); ?>/{{chat.region_lower}}.png" alt="" />
                                            <span ng-if="!chat.status" ng-class="{'badge-danger': chat.time_till_call_seconds <= 0}" class="badge mx-2 badge-warning"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Scheduled');?></span>
                                            <span ng-if="chat.status == 1" class="badge mx-2 badge-success"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Completed');?></span>
                                            <span ng-if="chat.status == 2" class="badge mx-2 badge-danger"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Canceled');?></span>
                                            <span ng-if="chat.status == 3" class="badge mx-2 badge-danger"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Not Answered');?></span>
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
            </div>
        </div>
    </div>
<?php endif; ?>
