var test = function () {
    var d1 = [];
    for (var i = 0; i < 14; i += 0.5)
        d1.push([i, Math.sin(i)]);

    var d2 = [[0, 3], [4, 8], [8, 5], [9, 13]];

    // a null signifies separate line segments
    var d3 = [[0, 12], [7, 12], null, [7, 2.5], [12, 2.5]];

    $.plot($("#graph"), [ d1, d2, d3 ]);

};


var signupsByMonth = function(data) {
    var formattedData = [];
    for (i=0; i<data.length;i++) {
        var obj = data[i]
        formattedData.push([Date.parse(obj.date).getTime(), obj.count]);
    }
    $.plot($("#graph"), [{data:formattedData, bars:{show:true}}], { xaxis: { mode: "time", minTickSize: [1, "month"] } });
};