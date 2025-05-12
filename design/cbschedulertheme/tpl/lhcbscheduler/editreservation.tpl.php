<?php if (!isset($is_modal)) : ?>
<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/cbscheduler','Edit reservation');?></h1>
<?php endif; ?>

<form action="<?php echo erLhcoreClassDesign::baseurl('cbscheduler/editreservation')?>/<?php echo $item->id?><?php if (isset($is_modal)) : ?>/(mode)/modal<?php endif;?>" method="post">

    <?php if (isset($updated)) : $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Updated'); ?>
        <?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php'));?>
    <?php endif; ?>

    <?php if (isset($errors)) : ?>
        <?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php'));?>
    <?php endif; ?>

    <?php include(erLhcoreClassDesign::designtpl('lhcbscheduler/parts/form_reservation_top.tpl.php'));?>

    <?php include(erLhcoreClassDesign::designtpl('lhcbscheduler/parts/form_reservation.tpl.php'));?>
    
    <br>
    <div class="btn-group" role="group" aria-label="...">
        <input type="submit" class="btn btn-secondary" name="Save_page" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons','Save');?>"/>
        <input type="submit" class="btn btn-secondary" name="Update_page" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons','Update');?>"/>
        <input type="submit" class="btn btn-secondary" name="Cancel_page" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons','Cancel');?>"/>
    </div>

</form>