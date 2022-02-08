$(document).ready(function () {

    var myPendingCalls = [];
    var notificationsList = [];
    var previousState = false;

    ee.addListener('eventGetSyncFilter', function(_that) {
        if (typeof _that.toggleWidgetData['conop_sort'] !== 'undefined' && _that.toggleWidgetData['conop_sort'] !== '') {
            _that.custom_extension_filter += '/(cbonop)/'+_that.toggleWidgetData['conop_sort'];
        }
    });

    ee.addListener('eventLoadInitialData', function (data, scope, _that) {
        _that.cb_pm = data.cbscheduler.on_phone;
        _that.toggleWidgetData['conop_sort'] = _that.restoreLocalSetting('conop_sort','',false);
    });

    ee.addListener('cbSetPhoneMode', function (_that, inst) {
        $.post(WWW_DIR_JAVASCRIPT + 'cbscheduler/phonemode/'+(!inst.on_phone ? '1' : '0') + '/' + inst.user_id);
        inst.on_phone = !inst.on_phone;
    });

    ee.addListener('cbSetPhoneModeSelf', function (_that) {
        $.post(WWW_DIR_JAVASCRIPT + 'cbscheduler/phonemode/'+(!_that.cb_pm ? '1' : '0'));
        _that.cb_pm = !_that.cb_pm;
    });

    function compareNotificationsAndHide(oldStatus, newStatus) {
        if (typeof oldStatus !== 'undefined') {
            for (var i = oldStatus.length - 1; i >= 0; i--) {
                var key = oldStatus[i];
                if (-1 === newStatus.indexOf(key)) {
                    if (typeof notificationsList[key] !== 'undefined') {
                        notificationsList[key].close();
                        delete notificationsList[key];
                    }
                }
            }
        }
    };

    ee.addListener('eventLoadChatList', function (data, scope, that) {

        // Init main attributes
        that.cb_pm = data.cb_pm;
        that.cb_pc = data.cb_pc;

        var callsListNew = [];
        var pushNotifications = [];

        if (data.result.my_calls && data.result.my_calls.list) {
            var hasPendingCall = false;
            for (var i = data.result.my_calls.list.length - 1; i >= 0; i--) {
                callsListNew.push(data.result.my_calls.list[i].id);
                if (myPendingCalls.indexOf(data.result.my_calls.list[i].id) === -1 && that.isListLoaded == true) {
                    pushNotifications.push(data.result.my_calls.list[i].id);
                }
                if (!data.result.my_calls.list[i].status_accept) {
                    hasPendingCall = true;
                }
            }

            if (previousState != hasPendingCall)
            {
                if (hasPendingCall == true) {
                    $('#dashboard-tab-icon-phone').addClass('text-danger blink-ani');
                } else {
                    $('#dashboard-tab-icon-phone').removeClass('text-danger blink-ani');
                }
                previousState = hasPendingCall;
            }

        }

        compareNotificationsAndHide(myPendingCalls, callsListNew);

        if (pushNotifications.length > 0) {
            $.get(WWW_DIR_JAVASCRIPT + 'cbscheduler/getnofificationsdata/(id)/' + pushNotifications.join('/'), function (data) {
                data.forEach(function (item) {
                    if (confLH.new_chat_sound_enabled == 1 && confLH.sn_off == 1) {
                        lhinst.playNewChatAudio('new_chat');

                        if (window.Notification && window.Notification.permission == 'granted') {
                            var notification = new Notification(item.nick, {
                                icon: WWW_DIR_JAVASCRIPT_FILES_NOTIFICATION + '/notification.png',
                                body: item.body,
                                requireInteraction: true
                            });
                            notification.onclick = function () {
                                lhc.revealModal({
                                    'title': 'Edit reservation',
                                    'iframe': true,
                                    'height': 700,
                                    'url': WWW_DIR_JAVASCRIPT + 'cbscheduler/editreservation/' + item.id + '/(mode)/modal'
                                })
                                delete notificationsList[item.id];
                            };

                            notification.onclose = function () {
                                if (typeof notificationsList[item.id] !== 'undefined') {
                                    delete notificationsList[item.id];
                                }
                            };

                            notificationsList[item.id] = notification;
                        }

                    }
                    ;
                });
            });
        }

        myPendingCalls = callsListNew;
    });
})
