$(document).ready(function () {

    var myPendingCalls = [];
    var notificationsList = [];
    var previousState = false;
    var cb_pm = false;
    var cb_pc = false;

    function updatePhoneMode()
    {
        if (cb_pm == false) {
            $('#set-phone-mode').removeClass('fw-bold');
            $('#set-phone-mode > .phone-on').hide();
            $('#set-phone-mode > .phone-off').show();
            $('#phone-mode-icon').text('phone_disabled');
        } else {
            $('#set-phone-mode > .phone-on').show();
            $('#set-phone-mode > .phone-off').hide();
            $('#phone-mode-icon').text('phone');
            $('#set-phone-mode').addClass('fw-bold');
        }

        if (cb_pc == true) {
            $('#dashboard-icon-phone').addClass('text-danger');
            $('#dashboard-icon-phone > span.pc-status').text('(!)');
        } else {
            $('#dashboard-icon-phone').removeClass('text-danger');
            $('#dashboard-icon-phone > span.pc-status').text('');
        }
    }

    $('#set-phone-mode').click(function(){
        $.post(WWW_DIR_JAVASCRIPT + 'cbscheduler/phonemode/'+(!cb_pm ? '1' : '0'));
        cb_pm = !cb_pm;
        updatePhoneMode();
    })

    // Migrated
    ee.addListener('eventGetSyncFilterSvelte', function(_that) {
        if (typeof _that.toggleWidgetData !== 'undefined' && typeof _that.toggleWidgetData['conop_sort'] !== 'undefined' && _that.toggleWidgetData['conop_sort'] !== '') {
            _that.custom_extension_filter += '/(cbonop)/'+_that.toggleWidgetData['conop_sort'];
        }
    });

    // Migrated
    ee.addListener('callbackModalOpen', function (chat) {
        return lhc.revealModal({'title':'Edit reservation','iframe':true,'height':700, 'url':WWW_DIR_JAVASCRIPT +'cbscheduler/editreservation/' + chat.id + '/(mode)/modal'})
    });


    // Migrated
    ee.addListener('eventLoadInitialData', function (data, list, _that) {
        cb_pm = data.cbscheduler.on_phone;
        list.toggleWidgetData['conop_sort'] = _that.restoreLocalSetting('conop_sort','',false);
        updatePhoneMode();
    });

    // Migrated
    ee.addListener('cbSetPhoneMode', function (inst) {
        $.post(WWW_DIR_JAVASCRIPT + 'cbscheduler/phonemode/'+(!inst.on_phone ? '1' : '0') + '/' + inst.user_id);
        inst.on_phone = !inst.on_phone;
        ee.emitEvent('angularLoadChatList');
    });

    ee.addListener('cbSetPhoneModeSelf', function () {
        /*$.post(WWW_DIR_JAVASCRIPT + 'cbscheduler/phonemode/'+(!cb_pm ? '1' : '0'));
        cb_pm = !cb_pm;*/
        console.log('Should not be used');
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

    ee.addListener('eventLoadChatListSvelte', function (data, scope, lhcLogic) {

        // Init main attributes
        cb_pm = data.cb_pm;
        cb_pc = data.cb_pc;

        updatePhoneMode();

        var callsListNew = [];
        var pushNotifications = [];

        if (data.result.my_calls && data.result.my_calls.list) {
            var hasPendingCall = false;
            for (var i = data.result.my_calls.list.length - 1; i >= 0; i--) {
                callsListNew.push(data.result.my_calls.list[i].id);
                if (myPendingCalls.indexOf(data.result.my_calls.list[i].id) === -1 && lhcLogic.isListLoaded == true) {
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
                });
            });
        }

        myPendingCalls = callsListNew;
    });
})
