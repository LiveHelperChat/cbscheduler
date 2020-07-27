<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Reservations');?></h1>

<?php include(erLhcoreClassDesign::designtpl('lhcbscheduler/parts/form_filter.tpl.php'));?>

<?php if (isset($items)) : ?>
    <table cellpadding="0" cellspacing="0" class="table table-sm" width="100%">
        <thead>
        <tr>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','ID');?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Department');?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Agent');?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Phone number');?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Username');?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','E-mail');?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','scheduled for');?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Status');?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','User timezone');?></th>
            <th width="1%"></th>
        </tr>
        </thead>
        <?php foreach ($items as $item) : ?>
            <tr>
                <td><?php echo $item->id?></td>
                <td><?php echo date('Y-m-d H:i:s',$item->ctime)?> | <?php echo htmlspecialchars($item->dep)?></td>
                <td><?php echo htmlspecialchars($item->user_name_official)?></td>
                <td><img src="<?php echo erLhcoreClassDesign::design('images/flags'); ?>/<?php echo strtolower($item->region)?>.png" alt="" /> <?php echo htmlspecialchars($item->phone)?></td>
                <td>
                    <?php include(erLhcoreClassDesign::designtpl('lhcbscheduler/username_row.tpl.php')); ?>
                </td>
                <td><?php echo htmlspecialchars($item->email)?></td>
                <td>
                    <b><?php echo $item->time_till_call?></b> | <?php echo $item->scheduler_for_front?>
                </td>
                <td>
                    <?php if ($item->status == erLhcoreClassModelCBSchedulerReservation::STATUS_SCHEDULED) : ?>
                        <span class="badge <?php $item->time_till_call > 0 ? print ' badge-warning' : print ' badge-danger'?>"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Scheduled');?></span>
                    <?php elseif ($item->status == erLhcoreClassModelCBSchedulerReservation::STATUS_COMPLETED) : ?>
                        <span class="badge badge-success"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Completed');?></span>
                    <?php elseif ($item->status == erLhcoreClassModelCBSchedulerReservation::STATUS_CANCELED) : ?>
                        <span class="badge badge-warning"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Canceled');?></span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php echo htmlspecialchars($item->tz)?>
                </td>
                <td>
                    <div class="btn-group" role="group" aria-label="..." style="width:60px;">
                        <a class="btn btn-secondary btn-xs" href="<?php echo erLhcoreClassDesign::baseurl('cbscheduler/editreservation')?>/<?php echo $item->id?>" ><i class="material-icons mr-0">&#xE254;</i></a>
                        <?php if (erLhcoreClassUser::instance()->hasAccessTo('lhcbscheduler','delete_reservation')) : ?>
                        <a class="btn btn-danger btn-xs csfr-required" onclick="return confirm('<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('kernel/messages','Are you sure?');?>')" href="<?php echo erLhcoreClassDesign::baseurl('cbscheduler/deletereservation')?>/<?php echo $item->id?>" ><i class="material-icons mr-0">&#xE872;</i></a>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php include(erLhcoreClassDesign::designtpl('lhkernel/secure_links.tpl.php')); ?>

    <?php if (isset($pages)) : ?>
        <?php include(erLhcoreClassDesign::designtpl('lhkernel/paginator.tpl.php')); ?>
    <?php endif;?>
<?php else : ?>
<p>Empty</p>
<?php endif; ?>
