$(document).ready(function()
{
    var clearPage = function() {
        $("#graph").empty();
        $('#content').empty();
    };

    var hidePage = function() {
        $("#graph").hide();
        $('#content').hide();
    };

    var showPage = function() {
        $("#graph").show();
        $('#content').show();
    };


    var $loader = $('#spinner'), timer;
    $loader.spin("large");
    $(this).ajaxStart(function() {
        timer && clearTimeout(timer);
        timer = setTimeout(function()
        {
            $loader.show();
        },500);
    });

    $(this).ajaxStop(function() {
        clearTimeout(timer);
        $loader.hide();
    });

    $('ul.report-menu li a').click(function() {
        hidePage();
        clearPage();

        $('ul.report-menu  li.active').removeClass('active');
        $(this).parent('li').addClass('active');


        var dataRoute = $(this).data('data');
        var contentRoute = $(this).data('content');


        if (dataRoute !== undefined) {
            var dataUri = Routing.generate(dataRoute);
        }

        if (contentRoute !== undefined) {
            var contentUri = Routing.generate(contentRoute);
        }

        var displayFtn = $(this).data('display');

        if (dataUri !== undefined) {
            $.ajax({
                url: dataUri
            }).done(function( data) {
                if (displayFtn !== undefined) {
                    window[displayFtn]().show(data);
                    $('#content').load(contentUri, showPage);
                }
             });
        } else {
            //no data, just call ftn and load content
            if (displayFtn !== undefined) {
                window[displayFtn]();
            }
            $('#content').load(contentUri, showPage);
        }



    });

    timer && clearTimeout(timer);
    $loader.hide();

});