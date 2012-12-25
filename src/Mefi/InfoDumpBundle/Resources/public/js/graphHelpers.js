var graphHelpers = (function() {

    return {
        showTooltip: function(x, y, contents) {
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
        },
        graph: function() {
            return $("#graph");
        },
        getMonthAbbr: function(i) {
            var months = {
                1:'Jan', 2:'Feb', 3:'Mar', 4:'Apr', 5:'May', 6:'Jun',
                7:'July', 8:'Oct', 9:'Sept', 10:'Oct', 11:'Nov', 12:'Dec'
            }
            return months[i];
        },

        lineGraphOptions: function() {
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
            return options;
        }
    }
})();
