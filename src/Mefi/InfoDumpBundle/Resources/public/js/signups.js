


var signupsByDate = (function() {

    var protectedInfo = {};
    var thisGraph = countByDateChart(protectedInfo);

    protectedInfo.tooltipContent = function(item) {
        return  thisGraph.tooltipContent(item) + " signups"
    }

    return thisGraph;
});

var signupsByYear = (function() {

    var protectedInfo = {};
    var thisGraph = countByYearChart(protectedInfo);

    protectedInfo.tooltipContent = function(item) {
        return  thisGraph.tooltipContent(item) + " signups"
    }

    return thisGraph;
});

var signupsByMonthYear = (function() {

    var protectedInfo = {};
    var thisGraph = countByMonthYearChart(protectedInfo);

    protectedInfo.tooltipContent = function(item) {
        return  thisGraph.tooltipContent(item) + " signups"
    }

    return thisGraph;
});

var signupsByDOW = (function() {

    var protectedInfo = {};
    var thisGraph = countByDOWChart(protectedInfo);

    protectedInfo.tooltipContent = function(item) {
        return  thisGraph.tooltipContent(item) + " signups"
    }

    return thisGraph;
});

var signupsByHour = (function() {

    var protectedInfo = {};
    var thisGraph = countByHourChart(protectedInfo);

    protectedInfo.tooltipContent = function(item) {
        return  thisGraph.tooltipContent(item) + " signups"
    }

    return thisGraph;
});

var signupsByMonth = (function() {

    var protectedInfo = {};
    var thisGraph = countByMonthChart(protectedInfo);

    protectedInfo.tooltipContent = function(item) {
        return  thisGraph.tooltipContent(item) + " signups"
    }

    return thisGraph;
});



