//Base class
var flotChartDisplay = (function(protected) {

    //chart private variables
    protected = protected || {};
    protected.jsonData = null,
        protected.graph = null,
        protected.previousPoint = null,
        protected.data = null,
        protected.tooltipId = null,
        protected.options = null,
        protected.hovercount = 0,
        protected.hoveroff = 5;

    protected.getOptions = function() {
        return {
            grid: {
                hoverable: true,
                clickable: true,
                backgroundColor: { colors: ["#fff", "#eee"] }
            },
            selection: { mode: "xy" }
        }
    };

    protected.prepData = function(jsonData) {
        return jsonData;
    };

    protected.showTooltip = function(x, y, contents) {
        var div = $('<div id="' + protected.tooltipId + '">' + contents + '</div>');
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

    protected.hideTooltip = function() {
        protected.hovercount = 0;
        $('#'+protected.tooltipId).remove();
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
                protected.hideTooltip();
                protected.showTooltip(item.pageX, item.pageY, protected.tooltipContent(item));
            }
        }
        else {
            protected.hovercount += 1;
            if (protected.hovercount > protected.hoveroff) {
                protected.hideTooltip();
                protected.previousPoint = null;
            }
        }
    };

    protected.monthName = function(i) {
        return Date.parse(i+"/01/2012").toString('MMM');
    }

    protected.dayOfWeekName = function(i) {
        return Date.today().moveToDayOfWeek(i-1).toString('dddd');
    }

    protected.unbindEvents = function() {
        protected.graph.unbind("plothover");
        protected.graph.unbind("plotselected");
        protected.graph.unbind("plotunselected");
    }

    protected.showGraph = function(data) {
        protected.jsonData = data;
        protected.graph = $("#graph");
        protected.tooltipId = 'tooltip';
        protected.options = protected.getOptions();
        protected.data = protected.prepData(protected.jsonData);
        var plot = $.plot(protected.graph, protected.data, protected.options);
        protected.unbindEvents();
        protected.graph.bind("plothover", protected.hover);
        protected.graph.bind("plotselected", protected.selected);
        protected.graph.bind("plotunselected",protected.unselected);
        protected.hideTooltip();
    }

    return {
        show:protected.showGraph,
        hideTooltip: protected.hideTooltip,
        getOptions: protected.getOptions,
        tooltipContent: protected.tooltipContent
    }

});

var countByDateChart = (function(protectedInfo) {
    protectedInfo = protectedInfo || {};
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
        return new Date(x).toDateString() + ": " + y
    }

    protectedInfo.getOptions = function() {

        var opt = thisGraph.getOptions();
        var options = $.extend(true, {}, opt, {
            lines: { show: true },
            points: { show: true },
            xaxis: { mode: "time", minTickSize: [1, 'day'], tickDecimals: 0}
        });

        return options;
    };

    //Returning thisGraph doesn't get the correct tooltip content. This does,
    //but is horrible. TODO: fix this.
    return {
        show:protectedInfo.showGraph,
        hideTooltip: protectedInfo.hideTooltip,
        getOptions: protectedInfo.getOptions,
        tooltipContent: protectedInfo.tooltipContent
    }
});


var countByYearChart  = (function(protectedInfo) {

    protectedInfo = protectedInfo || {};
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
        return year + ": " + y;

    }

    protectedInfo.getOptions = function() {

        var opt = thisGraph.getOptions();
        var options = $.extend(true, {}, opt, {
            lines: { show: true },
            points: { show: true },
            xaxis: { mode: "time", minTickSize: [1, 'year'], tickDecimals: 0}
        });

        return options;
    };

    //TODO: Fix this as well, see countByDateChart
    return {
        show:protectedInfo.showGraph,
        hideTooltip: protectedInfo.hideTooltip,
        getOptions: protectedInfo.getOptions,
        tooltipContent: protectedInfo.tooltipContent
    }

});

var countByMonthChart = (function(protectedInfo) {

    protectedInfo = protectedInfo || {};
    var thisGraph = flotChartDisplay(protectedInfo);

    protectedInfo.getOptions = function() {

        var opt = thisGraph.getOptions();
        var options = $.extend(true, {}, opt, {
            xaxis: {
                ticks: [], min: 0.5, max: 14
            },
            series: {
                stack: true,
                points: { show: false }
            },
            legend: { noColumns: 1 },
            bars: { show: true, barWidth: 0.6}
        });

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
        return protectedInfo.monthName(x) + " " + item.series.label + ": " +y
    }

    //TODO: Fix this as well, see countByDateChart
    return {
        show:protectedInfo.showGraph,
        hideTooltip: protectedInfo.hideTooltip,
        getOptions: protectedInfo.getOptions,
        tooltipContent: protectedInfo.tooltipContent
    }

});

var countByDOWChart = (function(protectedInfo) {

    var protectedInfo = protectedInfo || {};
    var thisGraph = flotChartDisplay(protectedInfo);

    protectedInfo.getOptions = function() {

        var opt = thisGraph.getOptions();
        var options = $.extend(true, {}, opt, {
            xaxis: {
                ticks: [], min: 0.5, max: 8.5
            },
            series: {
                stack: true,
                points: { show: false }
            },
            legend: { noColumns: 1 },
            bars: { show: true, barWidth: 0.6}
        });

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
        return item.series.label + ": " + y + " " + protectedInfo.dayOfWeekName(x);
    }

    //TODO: Fix this as well, see countByDateChart
    return {
        show:protectedInfo.showGraph,
        hideTooltip: protectedInfo.hideTooltip,
        getOptions: protectedInfo.getOptions,
        tooltipContent: protectedInfo.tooltipContent
    }

});