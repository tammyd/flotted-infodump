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
        return {};
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
        hideTooltip: protected.hideTooltip
    }

});