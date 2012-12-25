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

    var options = {
        xaxis: {
            ticks: []
        },
        series: {
            lines: { show: true },
            points: { show: true }
        },
        grid: { hoverable: true, clickable: true },
        selection: { mode: "xy" },
        legend: { noColumns: 1 }
    }

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

var signupsByDOW = function(data) {
    var graph = graphHelpers.graph();
    var plotData = [];

    var options = {
        xaxis: {
            ticks: []
        },
        series: {
            lines: { show: true },
            points: { show: true }
        },
        grid: { hoverable: true, clickable: true },
        selection: { mode: "xy" },
        legend: { noColumns: 1 }
    }

    for (i=0;i<data.length;i++) {
        var record = data[i]

        plotData.push([record.dow, record.count])
        options.xaxis.ticks.push([record.dow,record.dayOfWeek]);
    }
    plotData = [{label:'# Signups', 'data':plotData}];


    //plot the data
    var plot = $.plot(graph, plotData, options);
    var previousPoint = null;

    //bind the plot to click and over events
    graph.bind("plotclick", function (event, pos, item) {
        if (item) {
            plot.unhighlight();
            plot.highlight(item.series, item.datapoint);

        }
    });


    graph.bind("plothover", function (event, pos, item) {
        $("#x").text(pos.x);
        $("#y").text(pos.y);

        if (item) {
            if (previousPoint != item.dataIndex) {
                previousPoint = item.dataIndex;

                $("#tooltip").remove();
                var x = item.datapoint[0].toFixed(0),
                    y = item.datapoint[1].toFixed(0);

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
        console.log(plotData);
        $.plot(graph,plotData, opt);
    });

    graph.bind("plotunselected", function () {

        $.plot(graph,
            plotData, options);
    });



}


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