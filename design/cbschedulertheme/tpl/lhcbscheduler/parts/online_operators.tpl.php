<p><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','All operators in phone mode and online in the past');?> <?php echo htmlspecialchars($online_timeout)?> s. <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Operator has explicitly assigned department.');?></p>

<?php if (isset($reservation)) : ?>
<ul>
    <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Eligible for auto assign based on last auto assignment');?> - <?php if ($reservation->user_id == 0 || (time() - $reservation->tslasign) > $timeoutSeconds) : ?><span class="text-success">Y</span><?php else : ?><span class="text-danger fw-bold">N</span><?php endif; ?></li>
    <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Eligible for auto assign based on callback start time');?> - <?php if ($reservation->cb_time_start < (time()+$callInSeconds)) : ?><span class="text-success">Y</span><?php else : ?><span class="text-danger fw-bold">N</span><?php endif; ?></li>
    <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Call is not accepted by another operator');?> - <?php if ($reservation->status_accept != erLhcoreClassModelCBSchedulerReservation::CALL_ACCEPTED) : ?><span class="text-success">Y</span><?php else : ?><span class="text-danger fw-bold">N</span><?php endif; ?></li>
</ul>
<?php endif; ?>

<table ng-non-bindable class="table table-sm table-hover">
    <thead>
    <tr>
        <th width="1%" nowrap=""><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Operator');?></th>
        <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Last activity ago');?></th>
        <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Last time call was assigned');?></th>
        <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Phone mode');?></th>
        <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Can write');?></th>
        <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','No scheduled calls assigned');?></th>
    </tr>
    </thead>
    <?php foreach ($items as $item) : ?>
        <tr>
            <td nowrap="">
                <a target="_blank" href="<?php echo erLhcoreClassDesign::baseurl('user/edit')?>/<?php echo $item['user_id']?>"><span class="material-icons">open_in_new</span><?php echo (string)erLhcoreClassModelUser::fetch($item['user_id'])?></a>
            </td>
            <td>
                <span class="material-icons">error_outline</span> <?php echo erLhcoreClassChat::formatSeconds(time() - $item['last_activity']); ?> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','ago');?>.
            </td>
            <td>
                <span class="material-icons">error_outline</span><?php echo erLhcoreClassChat::formatSeconds(time() - $item['last_accepted_call']); ?> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','ago');?>.
            </td>
            <td>
                <span class="material-icons text-success">check</span>
            </td>
            <td>
                <?php if ($item['ro'] == 0) : ?>
                    <span title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Operator CAN write to selected department');?>" class="material-icons text-success">check</span>
                <?php else : ?>
                    <span title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Operator can NOT write to selected department');?>" class="material-icons text-danger">check</span>
                <?php endif; ?>
            </td>
            <td>
                <?php if ($item['slot_taken'] == true) : ?>
                    <span title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Operator has assigned callback already');?>" class="material-icons text-danger">check</span>
                <?php else : ?>
                    <span title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Operator do not have assigned callback assigned');?>" class="material-icons text-success">check</span>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>