(function () {

    var cbSchedulerLoaded = false;
    var goToAgent = false;
    var listenersSet = false

    window.lhcHelperfunctions.eventEmitter.addListener('cbscheduler.init', function (params, dispatch, getstate) {
            goToAgent = false;

            if (listenersSet === false) {

                listenersSet = true;

                window.lhcHelperfunctions.eventEmitter.addListener('cbscheduler.live_support', function(params) {
                    goToAgent = true;
                    // We are not in the chat mode yet.
                    if (params.chat_id === null) {
                        window.lhcHelperfunctions.eventEmitter.emitEvent('attr_set', [{attr: ['api_data'], data: {"ignore_bot": true, "Question": params.fields.Question}}]);
                        window.lhcHelperfunctions.eventEmitter.emitEvent('attr_set', [{attr: ['chat_ui','auto_start'], data: true}]);
                    } else {
                        // Force to check for a new messages
                        window.lhcHelperfunctions.eventEmitter.emitEvent('chat_check_messages',[]);
                    }
                });

                window.lhcHelperfunctions.eventEmitter.addListener('cbscheduler.close_modal', function(params) {
                    if (!params.chat_id && goToAgent == false) {
                        var state = getstate();
                        if (state.chatwidget.get('mode') != 'embed') {
                            window.lhcHelperfunctions.sendMessageParent('closeWidget', [{'sender' : 'closeButton'}]);
                        }
                    }
                });

                window.lhcHelperfunctions.eventEmitter.addListener('cbscheduler.event_tracker', function(params) {
                    window.lhcHelperfunctions.sendMessageParent(params.ea);
                });
            }

            setTimeout( function() {
                if (document.querySelector(".modal-backdrop") === null) {
                    // Build HTML
                    var bodyPrepend = document.getElementById("root");
                    var parent = document.createElement("div");
                    parent.id = "cbscheduler-modal";

                    var state = getstate(),
                    classAppend = (!state.chatwidget.hasIn(['chatData','id']) ? ' h-100' : '');

                    parent.innerHTML = "<div class=\"fade modal-backdrop show\"></div><div role=\"dialog\" id=\"dialog-content\" aria-modal=\"true\" class=\"fade modal show d-block\" tabindex=\"-1\">\n" +
                        "    <div class=\"modal-dialog modal-dialog-scrollable modal-lg" + classAppend + "\">\n" +
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

                        prefillValues.forEach(function(item) {
                            if (typeof item.Username !== 'undefined') {
                                username = item.Username;
                            }
                        });

                        if (username === null || username === "") {
                            try {
                                state.chatwidget.get('jsVarsPrefill').forEach(function(item) {
                                    if (typeof item.Username !== 'undefined') {
                                        username = item.Username;
                                    }
                                });
                            } catch (e) {
                                // Older lhc version just
                            }
                        }

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
                        var srcCSS = window.lhcChat['staticJS']['chunk_js'].replace('/design/defaulttheme/js/widgetv2','') + '/extension/cbscheduler/design/cbschedulertheme/css/cbscheduler.css?v=16';

                        var styleSheet = document.createElement("link");
                        styleSheet.setAttribute('rel',"stylesheet");
                        styleSheet.setAttribute('type',"text/css");
                        styleSheet.setAttribute('href',srcCSS);
                        th.appendChild(styleSheet);

                        // Insert JS
                        var src = window.lhcChat['staticJS']['chunk_js'].replace('/design/defaulttheme/js/widgetv2','') + '/extension/cbscheduler/design/cbschedulertheme/js/scheduler/dist/react.cbscheduler.app.js?v=16';

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
