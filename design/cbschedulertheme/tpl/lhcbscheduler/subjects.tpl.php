<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Subjects');?></h1>

<?php if (isset($items)) : ?>
    <table cellpadding="0" cellspacing="0" class="table table-sm" width="100%">
        <thead>
        <tr>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Name');?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Position');?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Active');?></th>
            <th width="1%"></th>
        </tr>
        </thead>
        <?php foreach ($items as $item) : ?>
            <tr>
                <td><?php echo htmlspecialchars($item->name)?></td>
                <td>
                    <?php echo $item->pos; ?>
                </td>
                <td>
                    <?php if ($item->active == 1) : ?>
                        <i title="Ok" class="material-icons chat-active">&#xE5CA;</i>
                    <?php else : ?>
                        <i title="Blocked" class="material-icons chat-closed">&#xE14B;</i>
                    <?php endif; ?>
                </td>
                <td>
                    <div class="btn-group" role="group" aria-label="..." style="width:60px;">
                        <a class="btn btn-secondary btn-xs" href="<?php echo erLhcoreClassDesign::baseurl('cbscheduler/editsubject')?>/<?php echo $item->id?>" ><i class="material-icons mr-0">&#xE254;</i></a>
                        <a class="btn btn-danger btn-xs csfr-required" onclick="return confirm('<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('kernel/messages','Are you sure?');?>')" href="<?php echo erLhcoreClassDesign::baseurl('cbscheduler/deletesubject')?>/<?php echo $item->id?>" ><i class="material-icons mr-0">&#xE872;</i></a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php include(erLhcoreClassDesign::designtpl('lhkernel/secure_links.tpl.php')); ?>

    <?php if (isset($pages)) : ?>
        <?php include(erLhcoreClassDesign::designtpl('lhkernel/paginator.tpl.php')); ?>
    <?php endif;?>
<?php endif; ?>

<a class="btn btn-secondary" href="<?php echo erLhcoreClassDesign::baseurl('cbscheduler/newsubject')?>"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','New');?></a>