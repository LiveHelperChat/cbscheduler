<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','New schedule');?></h1>

<?php if (isset($errors)) : ?>
    <?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php'));?>
<?php endif; ?>

<form action="<?php echo erLhcoreClassDesign::baseurl('cbscheduler/new')?>" method="post">

    <?php include(erLhcoreClassDesign::designtpl('lhcbscheduler/parts/form.tpl.php'));?>

    <br>
    <div class="btn-group" role="group" aria-label="...">
        <input type="submit" class="btn btn-secondary" name="Save_page" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons','Save');?>"/>
        <input type="submit" class="btn btn-secondary" name="Cancel_page" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons','Cancel');?>"/>
    </div>

</form>
<script>$('.btn-block-department').makeDropdown();</script>