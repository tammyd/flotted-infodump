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