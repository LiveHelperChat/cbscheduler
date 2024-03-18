<?php if (erLhcoreClassUser::instance()->hasAccessTo('lhcbscheduler','use_admin')) : ?>
<a class="d-inline-block pt-2 pe-1 float-end fw-bold text-secondary" <?php /*ng-class={'text-danger':lhc.cb_pc}*/?> id="dashboard-icon-phone" onclick="$('#tabs a[href=\'#cbscheduler\']').tab('show')">
    <i class="material-icons md-18">phone</i><span class="pc-status"><?php /*{{lhc.cb_pc ? '(!)' : ''}}*/?></span>
</a>
<?php endif; ?>