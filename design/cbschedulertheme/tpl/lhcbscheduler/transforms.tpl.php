<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Transforms');?></h1>

<?php if (isset($items)) : ?>
    <table cellpadding="0" cellspacing="0" class="table table-sm" width="100%" ng-non-bindable>
        <thead>
        <tr>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Departments');?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Countries');?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Rules');?></th>
            <th width="1%"></th>
        </tr>
        </thead>
        <?php foreach ($items as $item) : ?>
            <tr>
                <td title="<?php echo htmlspecialchars($item->dep_id)?>"><?php echo htmlspecialchars($item->departments_names)?></td>
                <td>
                    <?php echo htmlspecialchars($item->country); ?>
                </td>
                <td>
                    <?php echo htmlspecialchars($item->rules); ?>
                </td>
                <td>
                    <div class="btn-group" role="group" aria-label="..." style="width:60px;">
                        <a class="btn btn-secondary btn-xs" href="<?php echo erLhcoreClassDesign::baseurl('cbscheduler/edittransform')?>/<?php echo $item->id?>" ><i class="material-icons me-0">&#xE254;</i></a>
                        <a class="btn btn-danger btn-xs csfr-required" onclick="return confirm('<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('kernel/messages','Are you sure?');?>')" href="<?php echo erLhcoreClassDesign::baseurl('cbscheduler/deletetransform')?>/<?php echo $item->id?>" ><i class="material-icons me-0">&#xE872;</i></a>
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

<a class="btn btn-secondary btn-sm" href="<?php echo erLhcoreClassDesign::baseurl('cbscheduler/newtransform')?>"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','New');?></a>