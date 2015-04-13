/*function parseLogin()
{  var currentUrl = $.mobile.activePage.data('url');
        var match = /username\=/.exec(currentUrl);
    if(match)
    {
        console.log(match);
        window.location.hash= 'hhh' ;
    }
}
*/

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function tab(ep)
{
    var art=ep;
    $.ajax({
        url: 'favorite_ajax',
        data: {art:art},
        success:function(fav){
            var regexp = /good/;
            var match = regexp.exec(fav);
            if(match!=null)
            {
                $("span[id="+art+'sec'+"]").removeClass('glyphicon-star-empty');
                $("span[id="+art+'sec'+"]").addClass('glyphicon glyphicon-star');
            }
        }
    });
}

function article(art)
{
    if($('.arta').length)
    {
        if(!$("li[id="+art+"]").length)
        {
               console.log('Ничего еще нет...');
            if ($("span[id=" + art + "]").hasClass('glyphicon-arrow-down'))
            {
                $(".arta").addClass('glyphicon-arrow-down');
            }
        }
        else
        {
            if ($("span[id=" + art + "]").hasClass('glyphicon-arrow-down'))
            {
                $(".article_show").hide("normal");
                $(".arta").addClass('glyphicon-arrow-down');
                $("span[id=" + art + "]").removeClass('glyphicon-arrow-down');
                $("span[id=" + art + "]").addClass('glyphicon-arrow-up');
                $("p[id=" + art + "]").toggle("normal");
            }
            else
            {
                $("p[id=" + art + "]").hide("normal");
                $("span[id=" + art + "]").removeClass('glyphicon-arrow-up');
                $("span[id=" + art + "]").addClass('glyphicon-arrow-down');
            }
        }
    }
}
function articleRead(art)
{
    if($('.sect').length)
    {
        if ($("span[id=" + art + "]").hasClass('glyphicon-arrow-down'))
        {
            $("#arts_show").hide("normal");
            $(".arta").addClass('glyphicon-arrow-down');
            $("span[id=" + art + "]").removeClass('glyphicon-arrow-down');
            $("span[id=" + art + "]").addClass('glyphicon-arrow-up');
            $("div[class=" + art + "]").toggle("normal");
        }
        else
        {
            $("div[class=" + art + "]").hide("normal");
            $("span[id=" + art + "]").removeClass('glyphicon-arrow-up');
            $("span[id=" + art + "]").addClass('glyphicon-arrow-down');
        }
    }
}


function read(id)
{
    $.ajax({
        url: 'art_read',
        data: {art:id},
        success:function(rent){
        }
    });
};

function favDel(id)
{
    $.ajax({
        url: 'favorite_delete',
        data: {art:id},
        success:function(rent){
            location.reload();
        }
    });
}


$('document').ready(function(){

        var refresh=setInterval(
            function()
            {
                $.ajax({
                    url: check,
                    success:function(resp){
                        var regexp = /bad/;
                        var match = regexp.exec(resp);
                        if(match==null)
                        {
                        try
                        {
                            console.log(resp);
                            var temp;
                            try
                            {
                                temp= $.parseJSON(resp);
                            }
                            catch (e)
                            {
                                temp= resp;
                            }
                            //console.log(temp);
                            for(var key in temp)
                            {
                                $(".badge[data-info=" + key + "]").text(temp[key].count);
                                $("p[id="+key+"]").html(temp[key].articles);
                            }
                        }
                        catch(e)
                        {
                            console.info('Parse failed!');
                        }
                        }
                         else
                         {
                             $('.badge').html('');
                         }
                    }
                })
            },500000
        );

    var currentUrl = $.mobile.activePage.data('url');
    console.log(currentUrl);

    if($("#progress").length)
    {
    var chik=setTimeout(
        function()
        {
            $.ajax({
                url: check,
                success:function(resp){
                    var regexp = /bad/;
                    var match = regexp.exec(resp);
                    if(match==null)
                    {
                        try
                        {
                            console.log(resp);
                            var temp;
                            try
                            {
                                temp= $.parseJSON(resp);
                            }
                            catch (e)
                            {
                                temp= resp;
                            }
                            //console.log(temp);
                            for(var key in temp)
                            {
                                $(".badge[data-info=" + key + "]").text(temp[key].count);
                                $("p[id="+key+"]").html(temp[key].articles);
                                $(".for_show[data-info=" + key + "]").show("normal");
                            }
                        }
                        catch(e)
                        {
                            console.info('Parse failed!');
                        }
                    }
                    else
                    {
                        $('.badge').html('');
                    }
                }
            })
        }
    )
    }
})

