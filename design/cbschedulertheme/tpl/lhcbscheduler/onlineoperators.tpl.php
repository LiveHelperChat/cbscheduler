<div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
        <div class="modal-header pt-1 pb-1 pl-2 pr-2">
            <h4 class="modal-title" id="myModalLabel"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Operators statistic');?>
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body mx550">

            <div class="row">
                <div class="col-6">
                    <?php
                        $params = array (
                            'input_name'     => 'departmentFilterCBScheduler',
                            'display_name'   => 'name',
                            'css_class'      => 'form-control form-control-sm mb-2',
                            'selected_id'    => 0,
                            'list_function'  => 'erLhcoreClassModelDepartament::getList',
                            'list_function_params'  => array('limit' => false,'sort' => '`name` ASC'),
                            'optional_field' => erTranslationClassLhTranslation::getInstance()->getTranslation('department/edit','Choose department to check against')
                        );
                        echo erLhcoreClassRenderHelper::renderCombobox($params);
                    ?>
                </div>
                <div class="col-6">
                    <?php
                    $params = array (
                        'input_name'     => 'callbackFilterCBScheduler',
                        'display_name'   => function($item){
                            return $item->phone.' ['.$item->id.']';
                        },
                        'css_class'      => 'form-control form-control-sm mb-2',
                        'selected_id'    => 0,
                        'list_function'  => 'erLhcoreClassModelCBSchedulerReservation::getList',
                        'list_function_params'  => array('filter' => ['status' => erLhcoreClassModelCBSchedulerReservation::STATUS_SCHEDULED], 'limit' => false, 'sort' => '`cb_time_start` ASC'),
                        'optional_field' => erTranslationClassLhTranslation::getInstance()->getTranslation('department/edit','Choose a callback to evaluate')
                    );
                    echo erLhcoreClassRenderHelper::renderCombobox($params);
                    ?>
                </div>
            </div>

            <div id="cbscheduler-online-operators"></div>

            <script>
                (function(){
                    $('#id_departmentFilterCBScheduler').change(function(){
                        if (parseInt($(this).val()) > 0) {
                            $.get(WWW_DIR_JAVASCRIPT + 'cbscheduler/onlineoperators/(dep_id)/' + $(this).val(), function (data) {
                                $('#cbscheduler-online-operators').html(data);
                            });
                        }
                    });
                    $('#id_callbackFilterCBScheduler').change(function(){
                        if (parseInt($(this).val()) > 0) {
                            $.get(WWW_DIR_JAVASCRIPT + 'cbscheduler/onlineoperators/(call_id)/' + $(this).val(), function (data) {
                                $('#cbscheduler-online-operators').html(data);
                            });
                        }
                    });
                })();
            </script>

<?php include(erLhcoreClassDesign::designtpl('lhkernel/modal_footer.tpl.php'));?>