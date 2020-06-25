<div id="CBScheduler"></div>

<script>
    ee.emitEvent('loadCheduler',[{
        'path' : '<?php echo erLhcoreClassDesign::design('js/scheduler/dist')?>/',
        'chat_id':null,
        'dep_id':<?php echo $item->dep_id?>,
        'vid':null,
        'theme':null,
        'username':null,
        'mode':'popup'
    }]);
</script>