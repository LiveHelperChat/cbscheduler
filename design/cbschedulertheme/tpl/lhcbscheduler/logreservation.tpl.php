<div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
        <div class="modal-header pt-1 pb-1 ps-2 pe-2">
            <h4 class="modal-title" id="myModalLabel"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Log of auto assignment');?>
            </h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body mx550">

            <table ng-non-bindable class="table table-sm table-hover">
                <thead>
                <tr>
                    <th width="1%" nowrap=""><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Time');?></th>
                    <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Action');?></th>
                </tr>
                </thead>
            <?php foreach ($item->log_actions_array as $item) : $parts = explode('|||',$item);?>
                <tr>
                    <td nowrap="">
                        <?php echo date('Y-m-d H:i:s',(int)$parts[0])?>
                    </td>
                    <td>
                        <?php
                        $logText = isset($parts[1]) ? $parts[1] : '';
                        $logText = preg_replace_callback('/TS_(\d+)/', function($matches) {
                            return date('Y-m-d H:i:s', (int)$matches[1]);
                        }, $logText);
                        echo htmlspecialchars($logText);
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </table>


<?php include(erLhcoreClassDesign::designtpl('lhkernel/modal_footer.tpl.php'));?>