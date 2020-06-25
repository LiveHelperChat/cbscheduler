<div class="form-group">
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Name');?></label>
    <input type="text" maxlength="250" class="form-control form-control-sm" name="name" value="<?php echo htmlspecialchars($item->name)?>" />
</div>

<div class="form-group">
    <label><input type="checkbox" name="active" value="on" <?php $item->active == 1 ? print ' checked="checked" ' : ''?> > <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Active');?></label>
</div>

<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label>Department</label>
            <?php echo erLhcoreClassRenderHelper::renderMultiDropdown( array (
                'input_name'     => 'department_ids[]',
                'optional_field' => erTranslationClassLhTranslation::getInstance()->getTranslation('chat/lists/search_panel','Choose department'),
                'selected_id'    => $item->department_ids,
                'css_class'      => 'form-control',
                'display_name'   => 'name',
                'list_function_params' => erLhcoreClassUserDep::conditionalDepartmentFilter(),
                'list_function'  => 'erLhcoreClassModelDepartament::getList'
            )); ?>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label>Department group</label>
            <?php echo erLhcoreClassRenderHelper::renderMultiDropdown( array (
                'input_name'     => 'department_group_ids[]',
                'optional_field' => erTranslationClassLhTranslation::getInstance()->getTranslation('chat/lists/search_panel','Choose department group'),
                'selected_id'    => $item->department_group_ids,
                'css_class'      => 'form-control',
                'display_name'   => 'name',
                'list_function_params' => erLhcoreClassUserDep::conditionalDepartmentGroupFilter(),
                'list_function'  => 'erLhcoreClassModelDepartamentGroup::getList'
            )); ?>
        </div>
    </div>
</div>

<div class="form-group">
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Time Zone of the schedule');?></label>
    <?php $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL); ?>
    <select name="UserTimeZone" class="form-control form-control-sm">
        <option value=""><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Choose Time Zone');?></option>
        <?php foreach ($tzlist as $zone) : ?>
            <option value="<?php echo htmlspecialchars($zone)?>" <?php $item->tz == $zone ? print 'selected="selected"' : ''?>><?php echo htmlspecialchars($zone)?></option>
        <?php endforeach;?>
    </select>
</div>

<div ng-controller="CBSCheduler as cbsc" ng-cloak ng-init='cbsc.data = <?php echo json_encode(erLhcoreClassModelCBSchedulerScheduler::getData($item), JSON_HEX_APOS)?>;'>

    <ul class="nav nav-tabs mb-3" role="tablist">
    <?php $weekDays = erLhcoreClassCBSchedulerValidation::weekDays();
    for ($i = 1; $i <= 7; $i++) : ?>
        <li role="presentation" class="nav-item"><a href="#day-<?php echo $i?>" class="nav-link<?php if (($tab == '' && $i == 1) || $tab == $i) : ?> active<?php endif;?>" aria-controls="account" role="tab" data-toggle="tab"><?php echo $weekDays[$i]?></a></li>
    <?php endfor; ?>
    </ul>

    <div class="tab-content">
        <?php for ($i = 1; $i <= 7; $i++) : ?>
        <div role="tabpanel" class="tab-pane <?php if (($tab == '' && $i == 1) || $tab == $i) : ?>active<?php endif;?>" id="day-<?php echo $i?>">

            <a href="" ng-click="cbsc.addTime(cbsc.data[<?php echo $i?>])" class="btn btn-sm btn-secondary"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Add');?></a>
            <hr>
            <div ng-repeat="dayscheduleitems in cbsc.data[<?php echo $i?>] track by $index">

                <input type="hidden" value="{{dayscheduleitems.id}}" name="idTableItem[<?php echo $i?>][{{$index}}]" />

                <div class="row">

                    <div class="col-3">
                        <div class="form-group">

                            <label class="label-control"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Start time');?></label>
                            <a href="" ng-if="!dayscheduleitems.modeEditStartTime" ng-click="dayscheduleitems.modeEditStartTime=true"><i class="material-icons">mode_edit</i>{{cbsc.renderTime(dayscheduleitems.start_time)}}</a>
                            <input type="hidden" name="StartTime[<?php echo $i?>][{{$index}}]" value="{{dayscheduleitems.start_time}}" ng-model="dayscheduleitems.start_time">
                            <select ng-if="dayscheduleitems.modeEditStartTime" ng-change="cbsc.sortChange(cbsc.data[<?php echo $i?>],dayscheduleitems)" name="StartTime[{{dayschedule.day}}][{{$index}}]" class="form-control form-control-sm" ng-model="dayscheduleitems.start_time">
                                <?php for ($h = 0; $h <= 23; $h++) : ?>
                                    <?php for ($m = 0; $m < 12; $m++) : ?>
                                        <option value="<?php echo $h?>:<?php echo $m*5?>"><?php echo str_pad($h,2, '0', STR_PAD_LEFT),':',str_pad($m*5, 2, '0', STR_PAD_LEFT)?></option>
                                    <?php endfor;?>
                                <?php endfor;?>
                            </select>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label class="label-control"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','End time');?></label>
                            <a href="" ng-if="!dayscheduleitems.modeEditEndTime" ng-click="dayscheduleitems.modeEditEndTime=true"><i class="material-icons">mode_edit</i>{{cbsc.renderTime(dayscheduleitems.end_time)}}</a>
                            <input type="hidden" name="EndTime[<?php echo $i?>][{{$index}}]" value="{{dayscheduleitems.end_time}}" ng-model="dayscheduleitems.end_time">
                            <select ng-if="dayscheduleitems.modeEditEndTime" name="EndTime[<?php echo $i?>][{{$index}}]" class="form-control form-control-sm" ng-model="dayscheduleitems.end_time">
                                <?php for ($h = 0; $h <= 23; $h++) : ?>
                                    <?php for ($m = 0; $m < 12; $m++) : ?>
                                        <option value="<?php echo $h?>:<?php echo $m*5?>"><?php echo str_pad($h,2, '0', STR_PAD_LEFT),':',str_pad($m*5, 2, '0', STR_PAD_LEFT)?></option>
                                    <?php endfor;?>
                                <?php endfor;?>
                            </select>
                        </div>
                    </div>

                    <div class="col-3 pr-1">
                        <div class="form-group">
                            <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Max Calls');?></label>
                            <a href="" ng-if="!dayscheduleitems.max_callsEnabled" ng-click="dayscheduleitems.max_callsEnabled=true"><i class="material-icons">mode_edit</i>{{dayscheduleitems.max_calls}}</a>
                            <input ng-show="dayscheduleitems.max_callsEnabled" class="form-control form-control-sm" type="text" name="MaxCalls[<?php echo $i?>][{{$index}}]" ng-model="dayscheduleitems.max_calls" />
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <div class="btn-group" role="group" aria-label="...">
                                <button ng-click="cbsc.removeTime(cbsc.data[<?php echo $i?>],dayscheduleitems)" type="button" class="btn btn-danger btn-xs"><i class="material-icons mr-0">&#xE872;</i></button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
        <?php endfor; ?>
    </div>
</div>