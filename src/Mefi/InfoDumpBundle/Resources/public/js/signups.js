//Base class
var flotChartDisplay = (function(protected) {

    //chart private variables
    protected = protected || {};
    protected.jsonData = null,
        protected.graph = null,
        protected.previousPoint = null,
        protected.data = null,
        protected.tooltipId = null,
        protected.options = null;

    protected.getOptions = function() {
        return {};
    };

    protected.prepData = function(jsonData) {
        return jsonData;
    };

    protected.showTooltip = function(id, x, y, contents) {
        var div = $('<div id="' + id + '">' + contents + '</div>');
        div.css( {
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 5,
            border: '1px solid #fdd',
            padding: '2px',
            'background-color': '#fee',
            opacity: 0.80
        }).appendTo("body").fadeIn(200);
    };

    protected.tooltipContent = function(item) {
        return "This is a tooltip."
    };

    protected.hideTooltip = function(id) {
        $('#'+id).remove();
    };

    protected.selected = function (event, ranges) {
        var opt = $.extend(true, {}, protected.options, {
            xaxis: { min: ranges.xaxis.from, max: ranges.xaxis.to },
            yaxis: { min: ranges.yaxis.from, max: ranges.yaxis.to }
        });
        $.plot(protected.graph,protected.data, opt);
    };

    protected.unselected = function () {
        $.plot(protected.graph,protected.data, protected.options);
    };

    protected.hover = function (event, pos, item) {
        if (item) {
            var index = item.seriesIndex.toFixed(0) + item.dataIndex.toFixed(0);

            if (protected.previousPoint != index) {
                protected.hideTooltip(protected.tooltipId);
                protected.showTooltip(protected.tooltipId, item.pageX, item.pageY, protected.tooltipContent(item));
            }
        }
        else {
            protected.hideTooltip(protected.tooltipId);
            protected.previousPoint = null;
        }
    };

    protected.monthName = function(i) {
        return Date.parse(i+"/01/2012").toString('MMM');
    }

    protected.dayOfWeekName = function(i) {
        return Date.today().moveToDayOfWeek(i-1).toString('dddd');
    }

    protected.showGraph = function(data) {
        protected.jsonData = data;
        protected.graph = $("#graph");
        protected.tooltipId = 'tooltip';
        protected.options = protected.getOptions();
        protected.data = protected.prepData(protected.jsonData);
        var plot = $.plot(protected.graph, protected.data, protected.options);
        protected.graph.bind("plothover", protected.hover);
        protected.graph.bind("plotselected", protected.selected);
        protected.graph.bind("plotunselected",protected.unselected);
    }

    return {
        show:protected.showGraph
    }

});

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
        return graphHelpers.getMonthAbbr(x) + " " + item.series.label + ": " +y + " signups";
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
        return item.series.label + ": " + y + " " + graphHelpers.getDOWAbbr(x) + " signups";
    }

    return thisGraph;

})();


var signupsOverTime= function(data, tickSize, tooltipText) {

    var graph = graphHelpers.graph();
    var formattedData = [];

    for (i=0; i<data.length;i++) {
        var obj = data[i]
        formattedData.push([Date.parse(obj.date).getTime(), obj.count]);
    }

    var options = {
        lines: { show: true },
        points: { show: true },
        xaxis: { mode: "time", minTickSize: tickSize, tickDecimals: 0},
        grid: { hoverable: true, clickable: true },
        selection: { mode: "xy" }
    };


    $.plot(graph,
        [{data:formattedData}], options);
    var previousPoint = null;

    graph.bind("plothover", function (event, pos, item) {
        $("#x").text(pos.x);
        $("#y").text(pos.y);

        if (item) {
            if (previousPoint != item.dataIndex) {
                previousPoint = item.dataIndex;

                $("#tooltip").remove();
                var x = item.datapoint[0].toFixed(2),
                    y = item.datapoint[1].toFixed(2);

                var tt = tooltipText(item.series.label, x, y)
                graphHelpers.showTooltip(item.pageX, item.pageY,tt );
            }
        }
        else {
            $("#tooltip").remove();
            previousPoint = null;
        }
    });

    graph.bind("plotselected", function (event, ranges) {

        var opt = $.extend(true, {}, options, {
            xaxis: { min: ranges.xaxis.from, max: ranges.xaxis.to },
            yaxis: { min: ranges.yaxis.from, max: ranges.yaxis.to }
        });
        $.plot(graph,
            [{data:formattedData}], opt);
    });

    graph.bind("plotunselected", function () {

        $.plot(graph,
            [{data:formattedData}], options);
    });
};