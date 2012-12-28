var askPostsByDate = (function() {

    var protectedInfo = {};
    var thisGraph = countByDateChart(protectedInfo);

    protectedInfo.tooltipContent = function(item) {
        return  thisGraph.tooltipContent(item) + " posts"
    }

    return thisGraph;
});

var askPostsByYear = (function() {

    var protectedInfo = {};
    var thisGraph = countByYearChart(protectedInfo);

    protectedInfo.tooltipContent = function(item) {
        return  thisGraph.tooltipContent(item) + " posts"
    }

    return thisGraph;
});

var askPostsByMonth = (function() {

    var protectedInfo = {};
    var thisGraph = countByMonthChart(protectedInfo);

    protectedInfo.tooltipContent = function(item) {
        return  thisGraph.tooltipContent(item) + " posts"
    }

    return thisGraph;
});

var askPostsByDOW = (function() {

    var protectedInfo = {};
    var thisGraph = countByDOWChart(protectedInfo);

    protectedInfo.tooltipContent = function(item) {
        return  thisGraph.tooltipContent(item) + " posts"
    }

    return thisGraph;
});

