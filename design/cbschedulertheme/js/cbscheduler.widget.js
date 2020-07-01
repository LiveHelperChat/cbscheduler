(function () {

    var cbSchedulerLoaded = false;

    window.lhcHelperfunctions.eventEmitter.addListener('cbscheduler.live_support', function(params) {
        window.lhcHelperfunctions.eventEmitter.emitEvent('attr_set', [{attr: ['api_data'], data: {"ignore_bot": true, "Question": params.fields.Question}}]);
        window.lhcHelperfunctions.eventEmitter.emitEvent('attr_set', [{attr: ['chat_ui','auto_start'], data: true}]);
    });

    window.lhcHelperfunctions.eventEmitter.addListener('cbscheduler.init', function (params, dispatch, getstate) {
            setTimeout( function() {
                if (document.querySelector(".modal-backdrop") === null) {
                    // Build HTML
                    var bodyPrepend = document.getElementById("root");
                    var parent = document.createElement("div");
                    parent.id = "cbscheduler-modal";
                    parent.innerHTML = "<div class=\"fade modal-backdrop show\"></div><div role=\"dialog\" id=\"dialog-content\" aria-modal=\"true\" class=\"fade modal show d-block\" tabindex=\"-1\">\n" +
                        "    <div class=\"modal-dialog modal-dialog-scrollable modal-lg\">\n" +
                        "        <div class=\"modal-content\">\n" +
                        "            <div class=\"modal-body\" id=\"CBScheduler\"><div class=\"m-auto overflow-hidden\"><div class=\"m-auto loader-cbscheduler\"></div></div>\n" +
                        "            </div>\n" +
                        "        </div>\n" +
                        "    </div>\n" +
                        "</div>"
                    bodyPrepend.prepend(parent);

                    var loadcbSchedule = function() {
                        var state = getstate();

                        var department = 0;

                        if (state.chatwidget.get('department').size > 0) {
                            department = state.chatwidget.getIn(['department',0]);
                        }

                        var prefillValues = state.chatwidget.get('attr_prefill');

                        var username = null;

                        prefillValues.forEach(function(item){
                            if (typeof item.Username !== 'undefined') {
                                username = item.Username;
                            }
                        });

                        var params = {
                            'path' : window.lhcChat['staticJS']['chunk_js'].replace('/design/defaulttheme/js/widgetv2','') + '/extension/cbscheduler/design/cbschedulertheme/js/scheduler/dist/',
                            'chat_id': (state.chatwidget.hasIn(['chatData','id']) ? state.chatwidget.getIn(['chatData','id']) : null),
                            'hash': (state.chatwidget.hasIn(['chatData','hash']) ? state.chatwidget.getIn(['chatData','hash']) : null),
                            'dep_id': department,
                            'theme': state.chatwidget.get('theme'),
                            'vid':  state.chatwidget.get('vid'),
                            'username': username,
                            'mode': 'widget',
                            'widget':'new'
                        };

                        window.lhcHelperfunctions.eventEmitter.emitEvent('loadCheduler',[params])
                    }

                    if (cbSchedulerLoaded === false) {
                        cbSchedulerLoaded = true;

                        var th = document.getElementsByTagName('head')[0];

                        // Insert CSS
                        var srcCSS = window.lhcChat['staticJS']['chunk_js'].replace('/design/defaulttheme/js/widgetv2','') + '/extension/cbscheduler/design/cbschedulertheme/css/cbscheduler.css?v=1';

                        var styleSheet = document.createElement("link");
                        styleSheet.setAttribute('rel',"stylesheet");
                        styleSheet.setAttribute('type',"text/css");
                        styleSheet.setAttribute('href',srcCSS);
                        th.appendChild(styleSheet);

                        // Insert JS
                        var src = window.lhcChat['staticJS']['chunk_js'].replace('/design/defaulttheme/js/widgetv2','') + '/extension/cbscheduler/design/cbschedulertheme/js/scheduler/dist/react.cbscheduler.app.js?v=1';

                        var s = document.createElement('script');
                        s.setAttribute('type','text/javascript');
                        s.setAttribute('src',src);
                        th.appendChild(s);
                        s.onreadystatechange = s.onload = function() {
                            loadcbSchedule();
                        };
                    } else {
                        loadcbSchedule();
                    }
                }
            }, (typeof params['delay'] != 'undefined' ? parseInt(params['delay']) * 1000 : 0))
    });

})();
