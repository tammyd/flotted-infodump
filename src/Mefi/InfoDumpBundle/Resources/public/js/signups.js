var signupsByDate = function(data) {

    var tooltipText = function(label, x, y) {
        return new Date(parseInt(x)).toDateString() + ": " + parseInt(y) + " signups";
    }

    signupsOverTime(data, [1, 'day'], tooltipText);
}

var signupsByYear= function(data) {
    var tooltipText = function(label, x, y) {
        return new Date(parseInt(x)).getFullYear() + ": " + parseInt(y) + " signups";
    }

    signupsOverTime(data, [1, 'year'], tooltipText);
}


var signupsByMonth= function(jsonData) {

    var graph = graphHelpers.graph();
    var plotData = [];

    var options = graphHelpers.lineGraphOptions();

    var doDisplay = function() {
        //Using the jsonData, build up the plot data
        $.each(jsonData, function(year, monthData) {
            var obj = {'label':year, data:[]}
            $.each(monthData, function(month, count) {
                obj.data.push([month, count])
            });
            plotData.push(obj)
        });

        //auto generate the plot ticks
        for (i=1;i<=12;i++) {
            options.xaxis.ticks.push([i,graphHelpers.getMonthAbbr(i)]);
        }


        //plot the data
        var plot = $.plot(graph, plotData, options);
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

                    var tt = graphHelpers.getMonthAbbr(parseInt(x)) + " " + item.series.label + ": " + parseInt(y) + " signups";
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
            $.plot(graph,plotData, opt);
        });

        graph.bind("plotunselected", function () {

            $.plot(graph,
                plotData, options);
        });
    };

    doDisplay();

}


var signupsByDOW = (function() {

    //chart variables
    var jsonData = null;
    var graph = graphHelpers.graph();
    var previousPoint = null;
    var data = null;
    var tooltipId = 'tooltip';
    var options = null;

    var getOptions = function() {
        var options =  {
            xaxis: {
                ticks: [], min: 0.5, max: 8.5
            },
            series: {
                stack: true,
                points: { show: true }
            },
            grid: { hoverable: true, clickable: true },
            selection: { mode: "xy" },
            legend: { noColumns: 1 },
            bars: { show: true, barWidth: 0.6 }
        };


        for (i=1;i<=7;i++) {
            options.xaxis.ticks.push([i +.3,graphHelpers.getDOWAbbr(i)]);
        }

        return options;
    };

    var prepData = function(jsonData) {
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

    var showTooltip = function(id, x, y, contents) {
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

    var hideTooltip = function(id) {
        $('#'+id).remove();
    };

    var hover = function (event, pos, item) {
        if (item) {
            var index = item.seriesIndex.toFixed(0) + item.dataIndex.toFixed(0);

            if (previousPoint != index) {
                hideTooltip(tooltipId);
                var x = item.datapoint[0],
                    y = item.datapoint[1] - item.datapoint[2]

                var tt = item.series.label + ": " + y + " " + graphHelpers.getDOWAbbr(x) + " signups";
                showTooltip(tooltipId, item.pageX, item.pageY, tt);
            }
        }
        else {
            hideTooltip(tooltipId);
            previousPoint = null;
        }
    };

    var selected = function (event, ranges) {
        var opt = $.extend(true, {}, options, {
            xaxis: { min: ranges.xaxis.from, max: ranges.xaxis.to },
            yaxis: { min: ranges.yaxis.from, max: ranges.yaxis.to }
        });
        $.plot(graph,data, opt);
    };

    var unselected = function () {
        $.plot(graph, data, options);
    };

    var showGraph = function(data) {
        console.log(jsonData);
        jsonData = data;
        graph = $("#graph");
        tooltipId = 'tooltip';
        options = getOptions();
        data = prepData(jsonData);
        var plot = $.plot(graph, data, options);
        graph.bind("plothover", hover);
        graph.bind("plotselected", selected);
        graph.bind("plotunselected",unselected);
    }

    return {
        show: function(jsonData) {
            showGraph(jsonData);
        }
    }

})();



var signupsByDOWX = function(data) {
    var graph = graphHelpers.graph();
    var options = graphHelpers.lineGraphOptions();
    var plotData = [];

    options = $.extend(true, {}, options, {
       series: {stack: true},
       lines: { show: false },
       bars: { show: true, barWidth: 0.6 },
       xaxis: { min: 0.5, max: 8.5 }
    });

    //Using the jsonData, build up the plot data
    $.each(data, function(year, dowData) {
        var obj = {'label':year, data:[]}
        $.each(dowData, function(dow, count) {
            obj.data.push([dow, count])
        });
        plotData.push(obj)
       // options.xaxis.ticks[dow-1] = [dow, ]
    });

    //auto generate the plot ticks
    for (i=1;i<=7;i++) {
        options.xaxis.ticks.push([i +.3,graphHelpers.getDOWAbbr(i)]);
    }



    //plot the data
    var plot = $.plot(graph, plotData, options);
    var previousPoint = null;


    graph.bind("plothover", function (event, pos, item) {
        $("#x").text(pos.x);
        $("#y").text(pos.y);

        if (item) {
            if (previousPoint != item.dataIndex) {
                previousPoint = item.dataIndex;

                $("#tooltip").remove();
                var x = item.datapoint[0]
                    y = item.datapoint[2] - item.datapoint[1]

                var value = data[parseInt(item.series.label)][parseInt(x)];
                var tt = item.series.label + ": " + value + " " + graphHelpers.getDOWAbbr(parseInt(x)) + " signups";
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
        console.log(plotData);
        $.plot(graph,plotData, opt);
    });

    graph.bind("plotunselected", function () {

        $.plot(graph,
            plotData, options);
    });



};


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