$(document).ready(function()
{
    $('ul.report-menu > li > a').click(function() {
        var dataRoute = Routing.generate($(this).data('data'));
        var contentRoute = Routing.generate($(this).data('content'));
        var ftn = $(this).data('ftn');
        $.ajax({
            url: dataRoute
        }).done(function( data) {
            $('#content').load(contentRoute);
            window[ftn](data);
         });

    });

});