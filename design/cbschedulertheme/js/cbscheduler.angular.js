
lhcAppControllers.controller('CBSCheduler',['$scope', '$document', function($scope, $document, iVoiceCallbackSchedulerFactory) {

    this.data = {
        1 : [],
        2 : [],
        3 : [],
        4 : [],
        5 : [],
        6 : [],
        7 : []
    };

    var that = this;

    this.addTime = function(schedule) {
        var item = {
            "start_minute":0,
            "end_minute":0,
            "start_hour":8,
            "end_hour":20,
            "max_calls":"1",
            "id":null,
            "start_time":"8:0",
            "end_time":"8:15"
        };

        var nextItem = this.getNextHour(schedule);

        item.start_minute = nextItem.start_minute;
        item.start_hour = nextItem.start_hour;
        item.start_time = nextItem.start_hour + ':' + nextItem.start_minute;

        item.end_hour = nextItem.end_hour;
        item.end_minute = nextItem.end_minute;
        item.end_time = nextItem.end_hour + ':' + nextItem.end_minute;

        // Max calls
        item.max_calls = nextItem.max_calls;

        schedule.push(item);

        this.sortByStartTime(schedule);
    }

    this.getNextHour = function (schedule) {

        var start_hour = 0;
        var start_minute = 0;
        var end_hour = 0;
        var end_minute = 0;
        var max_calls = 1;

        schedule.forEach(function(item) {
            var startData = item.end_time.split(':');
            if (start_hour < parseInt(startData[0]) || (start_hour == parseInt(startData[0]) && start_minute < parseInt(startData[1]))) {
                end_hour = start_hour = parseInt(startData[0]);
                start_minute = parseInt(startData[1]);
                if (start_minute > 25) {
                    end_minute = 0;
                    end_hour++;
                } else {
                    end_minute += 30;
                }
                max_calls = item.max_calls;
            }
        });

        return {
            'start_hour' : start_hour,
            'start_minute' : start_minute,
            'end_hour' : end_hour,
            'end_minute' : end_minute,
            'max_calls' : max_calls
        }
    }

    this.sortByStartTime = function(items) {
        items.sort(function(a, b) {
            var partsA = a.start_time.split(':');
            var partsB = b.start_time.split(':');
            partsA[0] = parseInt(partsA[0]);
            partsA[1] = parseInt(partsA[1]);

            partsB[0] = parseInt(partsB[0]);
            partsB[1] = parseInt(partsB[1]);

            if (partsA[0] == partsB[0]) {
                return partsA[1] > partsB[1] ? 1 : -1;
            }

            return (partsA[0] > partsB[0] ? 1 : -1);
        });
    }

    this.sortChange = function(dayschedule, item) {
        this.sortByStartTime(dayschedule);
    }

    this.sortChangeException = function(dayschedule, item) {
        this.sortByStartTime(dayschedule);    }

    this.removeTime = function(dayschedule, item) {
        var index = dayschedule.indexOf(item);
        dayschedule.splice(index, 1);
    }

    this.move = function(list, element, offset) {
        index = list.indexOf(element);
        newIndex = index + offset;
        if (newIndex > -1 && newIndex < list.length){
            removedElement = list.splice(index, 1)[0];
            list.splice(newIndex, 0, removedElement)
        }
    };

    this.addBelow = function(schedule, item)
    {
        index = schedule.items.indexOf(item);
        newIndex = index + 1;
        schedule.items.splice( newIndex, 0, {
            "start_day":schedule.day,
            "start_minute":1,
            "end_minute":0,
            "start_hour":8,
            "end_hour":20,
            "concurrent_calls":"1",
            "schedule_id":schedule.table_id,
            "end_day":schedule.day,
            "blocking":false,
            "max_calls":"100",
            "id":null,
            "start_time":"8:0",
            "end_time":"8:15"
        });
    }

    this.getRepresents = function(total,today) {
        return (Math.round(today/total*10000)/100);
    }

    this.moveUpSchedule = function(dayschedule, item) {
        this.move(dayschedule,item,-1);
    }

    this.moveDownSchedule = function(dayschedule, item) {
        this.move(dayschedule, item,1);
    }

    this.validateLimit = function (item,limit,attr) {
        item[attr+'_invalid'] = null;
        if (isNaN(item[attr])) {
            item[attr] = '';
            item[attr+'_invalid'] = 'Only numbers are allowed';
        } else if (!isNaN(limit) && limit > 0 &&item[attr] > limit) {
            item[attr] = limit;
            item[attr+'_invalid'] = 'Maximum value ' + limit;
        }
    }

    this.renderTime = function(time) {
        var parts = time.split(':');
        return (parts[0].length == 1 ? '0'+parts[0] : parts[0]) + ':' + (parts[1].length == 1 ? '0' + parts[1]  : parts[1]);
    }

    this.setMaxCalls = function(items, maxCalls) {
        items.forEach(function(item) {
            item.max_calls = maxCalls;
        });
    }

}]);