<script>
    window.lhcChat = {};
    window.lhcChat['theme'] = <?php echo json_encode($theme_id)?>;
    window.lhcChat['theme_v'] = <?php echo json_encode($theme_v)?>;
</script>

<script type="text/javascript" src="<?php echo erLhcoreClassDesign::designJS('js/scheduler/dist/react.cbscheduler.app.js')?>"></script>

<div id="CBScheduler"></div>

<script>
    ee.emitEvent('loadCheduler',[{
        'path' : '<?php echo erLhcoreClassDesign::design('js/scheduler/dist')?>/',
        'chat_id':null,
        'dep_id':<?php echo $item->dep_id?>,
        'hash':null,
        'vid':null,
        'theme':<?php echo json_encode($theme_id)?>,
        'theme_v':<?php echo json_encode($theme_v)?>,
        'username':null,
        'mode':'popup',
        'widget':'new'
    }]);
</script>