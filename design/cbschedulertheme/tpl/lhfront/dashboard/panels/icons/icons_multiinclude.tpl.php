<?php if (erLhcoreClassUser::instance()->hasAccessTo('lhcbscheduler','use_admin')) : ?>
<a class="d-inline-block pt-2 pr-1 float-right font-weight-bold text-secondary" ng-class={'text-danger':lhc.cb_pc} id="dashboard-icon-phone" onclick="$('#tabs a[href=\'#cbscheduler\']').tab('show')">
    <i class="material-icons md-18">phone</i>{{lhc.cb_pc ? '(!)' : ''}}
</a>
<?php endif; ?>