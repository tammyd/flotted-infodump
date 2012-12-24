var test = function () {
    var d1 = [];
    for (var i = 0; i < 14; i += 0.5)
        d1.push([i, Math.sin(i)]);

    var d2 = [[0, 3], [4, 8], [8, 5], [9, 13]];

    // a null signifies separate line segments
    var d3 = [[0, 12], [7, 12], null, [7, 2.5], [12, 2.5]];

    $.plot($("#graph"), [ d1, d2, d3 ]);

};


var signupsByDate = function(data) {
    signupsOverTime(data, [1, 'day']);
}

var signupsByMonth= function(jsonData) {

    function showTooltip(x, y, contents) {
        $('<div id="tooltip">' + contents + '</div>').css( {
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 5,
            border: '1px solid #fdd',
            padding: '2px',
            'background-color': '#fee',
            opacity: 0.80
        }).appendTo("body").fadeIn(200);
    }

    function getMonth(i) {
        var months = {
            1:'Jan', 2:'Feb', 3:'Mar', 4:'Apr', 5:'May', 6:'Jun',
            7:'July', 8:'Oct', 9:'Sept', 10:'Oct', 11:'Nov', 12:'Dec'
        }
        return months[i];
    }


    var graph = $("#graph");
    var plotData = [];
    $.each(jsonData, function(year, monthData) {
        var obj = {'label':year, data:[]}
        $.each(monthData, function(month, count) {
            //console.log(year + ":" + month + ":" + count); //this will print the header contents
            obj.data.push([month, count])
        });
        plotData.push(obj)
    });

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
    for (i=1;i<=12;i++) {
        options.xaxis.ticks.push([i,getMonth(i)]);
    }


    var plot = $.plot(graph, plotData, options);

    graph.bind("plotclick", function (event, pos, item) {
        if (item) {
            plot.unhighlight();
            plot.highlight(item.series, item.datapoint);

        }
    });

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

                console.log(x)
                var tt = getMonth(parseInt(x)) + " " + item.series.label + ": " + parseInt(y) + " signups";
                showTooltip(item.pageX, item.pageY,tt );
            }
        }
        else {
            $("#tooltip").remove();
            previousPoint = null;
        }
    });



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