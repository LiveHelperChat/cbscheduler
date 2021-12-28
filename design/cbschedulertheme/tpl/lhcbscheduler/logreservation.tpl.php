<div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
        <div class="modal-header pt-1 pb-1 pl-2 pr-2">
            <h4 class="modal-title" id="myModalLabel"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Log of auto assignment');?>
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
                        <?php echo  htmlspecialchars(isset($parts[1]) ? $parts[1] : '')?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </table>


<?php include(erLhcoreClassDesign::designtpl('lhkernel/modal_footer.tpl.php'));?>