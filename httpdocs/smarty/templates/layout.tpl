
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width" />
        <title>Transcript Browser - dionaea muscipula</title>

        <link rel="stylesheet" href="{#$AppPath#}/css/normalize.css" />
        <link rel="stylesheet" href="{#$AppPath#}/css/foundation.css" />
        <link type="text/css" href="http://code.jquery.com/ui/1.10.1/themes/base/minified/jquery-ui.min.css" rel="Stylesheet" />    

        <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
        <script type="text/javascript" src="{#$AppPath#}/js/vendor/custom.modernizr.js"></script>
        <script type="text/javascript" src="{#$AppPath#}/js/foundation.min.js"></script>        


        <script type="text/javascript">
            $(document).ready(function() {
                $(document).foundation();
                $("#search_unigene").autocomplete({
                    position: {
                        my: "right top", at: "right bottom"
                    },
                    source: function(request, response) {
                        $.ajax({
                            url: "{#$ServicePath#}/listing/unigenes/" + request.term,
                            dataType: "json",
                            success: function(data) {
                                response(data.results);
                            }
                        });
                    },
                    minLength: 2,
                    select: function(event, ui) {
                        window.location.href = '{#$AppPath#}/unigene-details/' + ui.item.value;
                    }
                });
                $('#search_unigene').keydown(function(event) {
                    //Enter
                    if (event.which == 13) {
                        event.preventDefault();
                        $.ajax({
                            url: "{#$ServicePath#}/listing/unigenes/" + $(this).val(),
                            dataType: "json",
                            success: function(data) {
                                if (data.results.length == 1) {
                                    window.location.href = '{#$AppPath#}/unigene-details/' + data.results[0];
                                }
                            }
                        });
                    }
                });
                $("#catalog-all").accordion({
                    collapsible: true,
                    heightStyle: "content"
                });
            });
        </script>
        <style>
            .ui-accordion .ui-accordion-header {
                margin-bottom:0px;
            }
        </style>

        {#block name='head'#}{#/block#}

    </head>
    <body>
        <div class="fixed">
            <nav class="top-bar" id="top">
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
        </div>
        <div class="row">
            <div class="large-9 columns">
                {#block name='body'#}{#/block#}
            </div>
            <div class="large-3 columns" >
                <div class="row large-3 columns" style="position:fixed;top:45px;bottom:0;overflow-x:hidden;overflow-y:auto;">
                    <script type="text/javascript">
                        $(document).ready(function() {
                            /*$("#catalog-all li").draggable({
                             appendTo: "body",
                             helper: "clone"
                             });*/
                            $('#catalog-all li').draggable({
                                appendTo: "body",
                                helper: "clone"
                            });


                            var i = 0;


                            $('#catalog-add-group').click(function() {
                                newEl = $('#cart-dummy').html();
                                newEl = newEl.replace('#number#', ++i);
                                newEl = $('#catalog-groups').append(newEl).children().last()
                                newEl.find('.cart-target').droppable({
                                    accept: ":not(.ui-sortable-helper)",
                                    drop: function(event, ui) {
                                        $(this).find(".placeholder").remove();
                                        $("<li></li>").text(ui.draggable.text()).appendTo(this);
                                    }
                                }).sortable({
                                    items: "li:not(.placeholder)",
                                    sort: function() {
                                        // gets added unintentionally by droppable interacting with sortable
                                        // using connectWithSortable fixes this, but doesn't allow you to customize active/hoverClass options
                                        $(this).removeClass("ui-state-default");
                                    }
                                });
                                newEl.accordion({
                                    collapsible: true,
                                    heightStyle: "content"
                                });
                            });
                        });
                    </script>
                    <div id="cart-dummy" style="display: none"> 
                        <div class='ui_accordion ui_collapsible'>
                            <div>cart #number#</div>
                            <ul class="cart-target">
                                <li class="placeholder">drag your items here</li>
                            </ul>
                        </div>
                    </div>
                    <div class=" panel large-12 columns">
                        <h4>Cart</h4>
                        <div id="catalog-all" class='ui_accordion ui_collapsible'>
                            <div>all<div class="right"><img src="{#$AppPath#}/img/mimiGlyphs/23.png"/></div></div>
                            <ul>
                                <li>1.01_comp231081_c0_seq1</li>
                                <li>1.01_comp214244_c0_seq1</li>
                                <li>1.01_comp214244_c0_seq2</li>
                            </ul>
                        </div>
                        <div>
                            <a id="catalog-add-group" class="button secondary right">add new cart</a>
                            <div style="clear:both">&nbsp;</div>
                        </div>
                        <div id="catalog-groups">

                        </div>
                    </div>

                </div>
                <div>&nbsp;</div>
            </div>
        </div>
    </body>
</html>