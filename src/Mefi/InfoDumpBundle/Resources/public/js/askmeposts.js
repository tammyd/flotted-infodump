var askposts = (function() {

    return {
        desc: 'post',
        plural: 'posts'
    }
});

var deletedAskposts = (function() {

    return {
        desc: 'deleted post',
        plural: 'deleted posts'
    }
});

var askPostsByDate = (function() {

    var protectedInfo = {};
    var thisGraph = countByDateChart(protectedInfo);

    protectedInfo.tooltipContent = function(item) {
        return thisGraph.tooltipContent(item, askposts().desc, askposts().plural)
    }

    return thisGraph;
});

var askPostsByYear = (function() {

    var protectedInfo = {};
    var thisGraph = countByYearChart(protectedInfo);

    protectedInfo.tooltipContent = function(item) {
        return thisGraph.tooltipContent(item, askposts().desc, askposts().plural)
    }

    return thisGraph;
});

var askPostsByMonth = (function() {

    var protectedInfo = {};
    var thisGraph = countByMonthChart(protectedInfo);

    protectedInfo.tooltipContent = function(item) {
        return thisGraph.tooltipContent(item, askposts().desc, askposts().plural)
    }

    return thisGraph;
});


var askPostsByDOW = (function() {

    var protectedInfo = {};
    var thisGraph = countByDOWChart(protectedInfo);

    protectedInfo.tooltipContent = function(item) {
        return thisGraph.tooltipContent(item, askposts().desc, askposts().plural)
    }

    return thisGraph;
});

var askPostsByHour = (function() {

    var protectedInfo = {};
    var thisGraph = countByHourChart(protectedInfo);

    protectedInfo.tooltipContent = function(item) {
        return thisGraph.tooltipContent(item, askposts().desc, askposts().plural)
    }

    return thisGraph;
});


var askPostsByMonthYear = (function() {

    var protectedInfo = {};
    var thisGraph = countByMonthYearChart(protectedInfo);

    protectedInfo.tooltipContent = function(item) {
        return thisGraph.tooltipContent(item, askposts().desc, askposts().plural)
    }

    return thisGraph;
});

/////

var askDeletedPostsByDate = (function() {

    var protectedInfo = {};
    var thisGraph = countByDateChart(protectedInfo);

    protectedInfo.tooltipContent = function(item) {
        return thisGraph.tooltipContent(item, deletedAskposts().desc, deletedAskposts().plural)
    }

    protectedInfo.getOptions = function() {

        var opt = thisGraph.getOptions();
        var options = $.extend(true, {}, opt, {
            bars: { show: true},
            points: { show: true }
        });

        return options;
    };

    return thisGraph;
});

var askDeletedPostsByYear = (function() {

    var protectedInfo = {};
    var thisGraph = countByYearChart(protectedInfo);

    protectedInfo.tooltipContent = function(item) {
        return thisGraph.tooltipContent(item, deletedAskposts().desc, deletedAskposts().plural)
    }

    return thisGraph;
});

var askDeletedPostsByMonth = (function() {

    var protectedInfo = {};
    var thisGraph = countByMonthChart(protectedInfo);

    protectedInfo.tooltipContent = function(item) {
        return thisGraph.tooltipContent(item, deletedAskposts().desc, deletedAskposts().plural)
    }

    return thisGraph;
});


var askDeletedPostsByDOW = (function() {

    var protectedInfo = {};
    var thisGraph = countByDOWChart(protectedInfo);

    protectedInfo.tooltipContent = function(item) {
        return thisGraph.tooltipContent(item, deletedAskposts().desc, deletedAskposts().plural)
    }

    return thisGraph;
});

var askDeletedPostsByHour = (function() {

    var protectedInfo = {};
    var thisGraph = countByHourChart(protectedInfo);

    protectedInfo.tooltipContent = function(item) {
        return thisGraph.tooltipContent(item, deletedAskposts().desc, deletedAskposts().plural)
    }

    return thisGraph;
});


var askDeletedPostsByMonthYear = (function() {

    var protectedInfo = {};
    var thisGraph = countByMonthYearChart(protectedInfo);

    protectedInfo.tooltipContent = function(item) {
        return thisGraph.tooltipContent(item, deletedAskposts().desc, deletedAskposts().plural)
    }

    return thisGraph;
});
