<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />

        <title></title>
        <!--[if lt IE 9]><script type="text/javascript" src="http://canvasxpress.org/js/flashcanvas.js"></script><![endif]-->
        <script type="text/javascript" src="http://canvasxpress.org/js/canvasXpress.min.js"></script>
        <?php /* use chrome frame if installed and user is using IE */ ?>
        <meta http-equiv="X-UA-Compatible" content="chrome=1">


        <link type="text/css" href="http://code.jquery.com/ui/1.10.1/themes/base/minified/jquery-ui.min.css" rel="Stylesheet" />    
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
        <script type="text/javascript">
            var tabs = null;
            var tabTemplate = "<li><a href='isoform_details.php?isoform={isoform}'>{isoform}</a></li>";
            
            function load_isoforms(unigene){
                $('#tabs > ul > li').remove();
                $('#tabs > div').remove();
                i=0;
                $.ajax({url: "http://wbbi162/httpdocs/service/list/isoforms",
                    dataType: "json",
                    data: {
                        query: unigene
                    },
                    success: function(data){
                        $(data.results).each(function(index, isoform){
                            li = tabTemplate.replace( /\{isoform\}/g, isoform );
                            tabs.find( ".ui-tabs-nav" ).append( $(li) );                            
                        });
                        tabs.tabs( "refresh" );
                        tabs.tabs({ active: 0 });
                    }
                });
            }
            
            
            $(document).ready(function() {
                tabs = $( "#tabs" ).tabs({heightStyle: "content" });
                $( ".tooltip-toomany" ).tooltip({ content: "There are more results available. Please specify your search!" ,  items: ".tooltip-toomany"} );
                $( ".tooltip-toomany" ).tooltip("disable");
                $( "#search_unigene" ).autocomplete({
                    source: function( request, response ) {
                        $.ajax({
                            url: "http://wbbi162/httpdocs/service/list/unigenes",
                            dataType: "json",
                            data: {
                                query: request.term
                            },
                            success: function( data ) {
                                if (data.full_count>data.results.length)
                                    $( "#search_unigene" ).tooltip( "open" );
                                else
                                    $( "#search_unigene" ).tooltip( "close" );
                                response( data.results );
                            }
                        });
                    },
                    minLength: 2,
                    select: function( event, ui ) {
                        load_isoforms(ui.item.value);
                    }
                });
  
            
            });
            
            
                  
            
        </script>
    </head>
    <body>
        <div>explore a bit. we recommend exploring for isoform '1.01_comp231081_c0_seq1'</div>
        <div id="explore-unigenes">
            <h1>search for Unigene:</h1>
            <input type="text" id="search_unigene" class="tooltip-toomany"/>
        </div>
        <div id="unigene">
            <div id="tabs">
                <ul></ul>
            </div>
        </div>
    </body>
</html>
