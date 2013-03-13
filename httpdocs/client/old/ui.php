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
        <style>
            .ui-autocomplete {
                max-height: 200px;
                overflow-y: auto;
                /* prevent horizontal scrollbar */
                overflow-x: hidden;
            }
            /* IE 6 doesn't support max-height
             * we use height instead, but this forces the menu to always be this tall
            */
            * html .ui-autocomplete {
                height: 200px;
            }
        </style>
        <script type="text/javascript">
            var tooltip_toomany = null;
            
            
            
            $(document).ready(function() {
                tooltip_toomany = $( "#search_unigene_tooltip" );
                tooltip_toomany.hide(0);
                $( "#search_unigene" ).autocomplete({
                    source: function( request, response ) {
                        $.ajax({
                            url: "../service/list/unigenes",
                            dataType: "json",
                            data: {
                                query: request.term
                            },
                            success: function( data ) {
                                if (data.full_count>data.results.length)
                                    tooltip_toomany.show();
                                else
                                    tooltip_toomany.hide();
                                response( data.results );
                            }
                        });
                    },
                    minLength: 2,
                    select: function( event, ui ) {
                        tooltip_toomany.hide();
                        if ($("#tabs").length>0)
                            $("#tabs").tabs("destroy");
                        $('#ajax_unigene').empty();
                        $('#ajax_unigene').load('unigene_details.php',{unigene: ui.item.value});
                    }
                });
  
            
            });
            
            
                  
            
        </script>
    </head>
    <body>
        <div>explore a bit. we recommend looking for isoform '1.01_comp231081_c0' or '1.01_comp214244_c0'</div>
        <div id="explore-unigenes">
            <h1>search for Unigene</h1>
            <p>
                <input type="text" id="search_unigene" />
            <div style="position:relative; left:30px; top:-100px;" class="ui-tooltip ui-widget ui-corner-all ui-widget-content" id="search_unigene_tooltip">There are more results available. Please specify your search!</div>
        </p>
    </div>
    <div id="ajax_unigene">
    </div>
</body>
</html>
