$(document).ready(function () {

    var myPendingCalls = [];
    var notificationsList = [];

    ee.addListener('eventLoadInitialData', function (data) {
        if (data.cbscheduler.on_phone) {
            $('#activate-cb-scheduler').addClass('font-weight-bold');
        }
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
        var callsListNew = [];
        var pushNotifications = [];

        if (data.result.my_calls && data.result.my_calls.list) {
            for (var i = data.result.my_calls.list.length - 1; i >= 0; i--) {
                callsListNew.push(data.result.my_calls.list[i].id);
                if (myPendingCalls.indexOf(data.result.my_calls.list[i].id) === -1 && that.isListLoaded == true) {
                    pushNotifications.push(data.result.my_calls.list[i].id);
                }
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


    $('#activate-cb-scheduler').click(function () {
        if (!$(this).hasClass('font-weight-bold')) {
            $(this).addClass('font-weight-bold');
            $.get(WWW_DIR_JAVASCRIPT + 'user/setoffline/1');
            $.get(WWW_DIR_JAVASCRIPT + 'cbscheduler/phonemode/1');
        } else {
            $(this).removeClass('font-weight-bold');
            $.get(WWW_DIR_JAVASCRIPT + 'cbscheduler/phonemode/0');
        }
    });
})
