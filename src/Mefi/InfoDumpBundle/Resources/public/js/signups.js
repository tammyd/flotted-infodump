

var signupsByDate = (function() {
    var protectedInfo = {};
    var thisGraph = flotChartDisplay(protectedInfo);

    protectedInfo.prepData = function(jsonData) {
        var data = [];
        for (i=0; i<jsonData.length;i++) {
            var obj = jsonData[i]
            data.push([Date.parse(obj.date).getTime(), obj.count]);
        }

        return [data];

    };

    protectedInfo.tooltipContent = function(item) {
        var x = item.datapoint[0],
            y = item.datapoint[1];
        return new Date(x).toDateString() + ": " + y + " signups";
    }


    protectedInfo.getOptions = function() {
        var options = {
            lines: { show: true },
            points: { show: true },
            xaxis: { mode: "time", minTickSize: [1, 'day'], tickDecimals: 0},
            grid: { hoverable: true, clickable: true },
            selection: { mode: "xy" }
        };

        return options;
    };

    return thisGraph;
})();


var signupsByYear = (function() {

    var protectedInfo = {};
    var thisGraph = flotChartDisplay(protectedInfo);

    protectedInfo.prepData = function(jsonData) {
        var data = [];
        for (i=0; i<jsonData.length;i++) {
            var obj = jsonData[i]
            data.push([Date.parse(obj.date.toString()).getTime(), obj.count]);
        }

        return [data];

    };

    protectedInfo.tooltipContent = function(item) {
        var x = item.datapoint[0],
            y = item.datapoint[1];

        var year = 1900+new Date(x).getYear();
        return year + ": " + y + " signups";

    }


    protectedInfo.getOptions = function() {
        var options = {
            lines: { show: true },
            points: { show: true },
            xaxis: { mode: "time", minTickSize: [1, 'year'], tickDecimals: 0},
            grid: { hoverable: true, clickable: true },
            selection: { mode: "xy" }
        };

        return options;
    };

    return thisGraph;

})();

var signupsByMonth = (function() {

    var protectedInfo = {};
    var thisGraph = flotChartDisplay(protectedInfo);

    protectedInfo.getOptions = function() {
        var options =  {
            xaxis: {
                ticks: [], min: 0.5, max: 14
            },
            series: {
                stack: true,
                points: { show: false }
            },
            grid: { hoverable: true, clickable: true },
            selection: { mode: "xy" },
            legend: { noColumns: 1 },
            bars: { show: true, barWidth: 0.6 }
        };

        for (i=1;i<=12;i++) {
            options.xaxis.ticks.push([i +.3,protectedInfo.monthName(i)]);
        }

        return options;
    };

    protectedInfo.prepData = function(jsonData) {
        var plotData = [];
        $.each(jsonData, function(year, monthData) {
            var obj = {'label':year, data:[]}
            $.each(monthData, function(month, count) {
                obj.data.push([month, count])
            });
            plotData.push(obj)
        });

        return plotData;
    };

    protectedInfo.tooltipContent = function(item) {
        var x = item.datapoint[0],
            y = item.datapoint[1] - item.datapoint[2]
        return protectedInfo.monthName(x) + " " + item.series.label + ": " +y + " signups";
    }

    return thisGraph;

})();


var signupsByDOW = (function() {

    var protectedInfo = {};
    var thisGraph = flotChartDisplay(protectedInfo);

    protectedInfo.getOptions = function() {
        var options =  {
            xaxis: {
                ticks: [], min: 0.5, max: 8.5
            },
            series: {
                stack: true,
                points: { show: false }
            },
            grid: { hoverable: true, clickable: true },
            selection: { mode: "xy" },
            legend: { noColumns: 1 },
            bars: { show: true, barWidth: 0.6 }
        };


        for (i=1;i<=7;i++) {
            options.xaxis.ticks.push([i +.3,protectedInfo.dayOfWeekName(i)]);
        }

        return options;
    };

    protectedInfo.prepData = function(jsonData) {
        var plotData = [];
        $.each(jsonData, function(year, dowData) {
            var obj = {'label':year, data:[]}
            $.each(dowData, function(dow, count) {
                obj.data.push([dow, count])
            });
            plotData.push(obj)
        });

        return plotData;
    };

    protectedInfo.tooltipContent = function(item) {
        var x = item.datapoint[0],
            y = item.datapoint[1] - item.datapoint[2]
        return item.series.label + ": " + y + " " + protectedInfo.dayOfWeekName(x) + " signups";
    }

    return thisGraph;

})();
