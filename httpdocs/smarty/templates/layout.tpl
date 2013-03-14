
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width" />
        <title>Transcript Browser - dionaea muscipula</title>
        <link rel="stylesheet" href="{#$AppPath#}/css/normalize.css" />
        <link rel="stylesheet" href="{#$AppPath#}/css/foundation.css" />
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
        <link type="text/css" href="http://code.jquery.com/ui/1.10.1/themes/base/minified/jquery-ui.min.css" rel="Stylesheet" />    
        <script type="text/javascript" src="{#$AppPath#}/js/vendor/custom.modernizr.js"></script>
        <script type="text/javascript" src="{#$AppPath#}/js/foundation.min.js"></script>


        <script type="text/javascript">
            $(document).ready(function() {
                $(document).foundation();
                $( "#search_unigene" ).autocomplete({
                    position: {
                        my: "right top", at: "right bottom"
                    },
                    source: function( request, response ) {
                        $.ajax({
                            url: "{#$ServicePath#}/listing/unigenes/"+request.term,
                            dataType: "json",
                            success: function( data ) {
                                response( data.results );
                            }
                        });
                    },
                    minLength: 2,
                    select: function( event, ui ) {
                        window.location.href = '{#$AppPath#}/unigene-details/'+ui.item.value;
                    }
                });
                $('#search_unigene').keydown(function(event) {
                    //Enter
                    if (event.which == 13) {
                        event.preventDefault();
                        $.ajax({
                            url: "{#$ServicePath#}/listing/unigenes/"+$(this).val(),
                            dataType: "json",
                            success: function( data ) {
                                if (data.results.length==1){
                                    window.location.href = '{#$AppPath#}/unigene-details/'+data.results[0];
                                }
                            }
                        });
                    }
                });
            });
        </script>

        {#block name=head#}{#/block#}

    </head>
    <body>

        <nav class="top-bar">
            <ul class="title-area">
                <li class="name">
                    <h1><a>Transcript Browser: dionaea muscipula</a></h1>
                </li>
            </ul>
            <section class="top-bar-section">
                <ul class="right">
                    <li class="divider"></li>
                    <li><a>search for unigene:</a></li>
                    <li><input type="text" id="search_unigene" data-tooltip class="has-tip" title="try 1.01_comp231081_c0 or 1.01_comp214244_c0"/></li>
                    <li>&nbsp;</li> 
                </ul>
            </section>
        </nav>

        {#block name=body#}{#/block#}
    </body>
</html>