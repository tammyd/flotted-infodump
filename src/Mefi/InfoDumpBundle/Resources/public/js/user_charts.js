var signupsByDate = function(data) {
    signupsOverTime(data, [1, 'day']);
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
        grid: { hoverable: true, clickable: true }
    }

    var doDisplay = function() {
        //Using the jsonData, build up the plot data
        $.each(jsonData, function(year, monthData) {
            var obj = {'label':year, data:[]}
            $.each(monthData, function(month, count) {
                //console.log(year + ":" + month + ":" + count); //this will print the header contents
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
                    var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1].toFixed(2);

                    console.log(x)
                    var tt = graphHelpers.getMonthAbbr(parseInt(x)) + " " + item.series.label + ": " + parseInt(y) + " signups";
                    graphHelpers.showTooltip(item.pageX, item.pageY,tt );
                }
            }
            else {
                $("#tooltip").remove();
                previousPoint = null;
            }
        });
    };

    doDisplay();

}

var signupsByYear= function(data) {
    signupsOverTime(data, [1, 'year']);
}

var signupsOverTime= function(data, tickSize) {
    var formattedData = [];
    for (i=0; i<data.length;i++) {
        var obj = data[i]
        formattedData.push([Date.parse(obj.date).getTime(), obj.count]);
    }

    var options = {
        lines: { show: true },
        points: { show: true },
        xaxis: { mode: "time", minTickSize: tickSize}
    };

    $.plot($("#graph"),
        [{data:formattedData}], options);
};