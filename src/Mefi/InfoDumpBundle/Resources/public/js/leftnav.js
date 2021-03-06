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
        $('#tooltip').remove();
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

    $('[class*="collapse"]').on('show', function () {
        $(this).parent().find('i.icon-caret-right').removeClass('icon-caret-right').addClass('icon-caret-down');
    })
    $('[class*="collapse"]').on('hide', function () {
        $(this).parent().find('i.icon-caret-down').removeClass('icon-caret-down').addClass('icon-caret-right');
    })

    timer && clearTimeout(timer);
    $loader.hide();

});