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

var signupsByMonth= function(data) {
    signupsOverTime(data, [1, 'month']);
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