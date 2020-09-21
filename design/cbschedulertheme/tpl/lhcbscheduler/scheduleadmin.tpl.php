<div id="CBScheduler"></div>

<script>
    ee.emitEvent('loadCheduler',[{
        'path' : '<?php echo erLhcoreClassDesign::design('js/scheduler/dist')?>/',
        'chat_id':<?php echo json_encode($itemPrevious->chat_id)?>,
        'dep_id':<?php echo $item->dep_id?>,
        'parent_id':<?php echo json_encode($itemPrevious->id)?>,
        'hash':null,
        'vid':null,
        'theme':null,
        'username':<?php echo json_encode($itemPrevious->name)?>,
        'email':<?php echo json_encode($itemPrevious->email)?>,
        'phone':<?php echo json_encode($itemPrevious->phone)?>,
        'subject':<?php echo json_encode($itemPrevious->subject_id)?>,
        'description':<?php echo json_encode($itemPrevious->description)?>,
        'mode':'popup',
        'widget':'new'
    }]);
</script>