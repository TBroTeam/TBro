
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <!--meta name="viewport" content="width=device-width" /-->
        <title>TBro &alpha;</title>

        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/foundation/4.1.6/css/normalize.css" />
        <link rel="stylesheet" type="text/css" href="{#$AppPath#}/css/foundation.min.css" />
        <link rel="stylesheet" type="text/css" href="{#$AppPath#}/css/custom-theme/jquery-ui-1.10.2.custom.css"  />    
        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/datatables/1.9.4/css/jquery.dataTables_themeroller.min.css">
        <!--link ref="stylesheet" type="text/css" href = "//cdnjs.cloudflare.com/ajax/libs/datatables-tabletools/2.1.4/css/TableTools.min.css"-->
        <link rel="stylesheet" href="{#$AppPath#}/css/TableTools.css" />        
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.4.4/underscore-min.js"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/foundation/4.0.8/js/foundation.min.js"></script>        
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.4.4/underscore-min.js"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/datatables/1.9.4/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="{#$AppPath#}/js/TableTools.min.js"></script>
        <script type="text/javascript" src="{#$AppPath#}/js/alphanum.js"></script>
        <script type="text/javascript" src="{#$AppPath#}/js/datatable-init.js"></script>
        <script type="text/javascript" src="{#$AppPath#}/js/sprintf.min.js"></script>
        <script type="text/javascript" src="{#$AppPath#}/js/jquery.webStorage.min.js"></script>       
        <!--script type="text/javascript" src="{#$AppPath#}/js/json3.min.js"></script-->

        <script type="text/javascript">
            var organism;
            var release;
            $(document).ready(function() {
                $(document).foundation();


                // set defaults for organism & release
                organism = $('#select_organism');
                release = $('#select_release');

            {#if isset($organism)#}
                selected_organism_id = '{#$organism#}';
                selected_release = '{#$release#}';
            {#else#}
                selected_organism_id = $.webStorage.session().getItem('selected_organism_id');
                if (selected_organism_id == null) {
                    selected_organism_id = '{#$default_organism#}';
                }
                selected_release = $.webStorage.session().getItem('selected_release');
                if (selected_release == null) {
                    selected_release = '{#$default_release#}';
                }
            {#/if#}


                var rel_release = null;

                //get possible organisms and releases, fill selects
                $.ajax({
                    url: "{#$ServicePath#}/listing/organism_release",
                    dataType: "json",
                    success: function(data) {
                        organism.empty();
                        $.each(data.results.organism, function() {
                            var option = $('<option/>').val(this.organism_id).text(this.organism_name);
                            if (this.organism_id == selected_organism_id) {
                                option.attr('selected', 'selected');
                            }
                            option.appendTo(organism);
                        });
                        rel_release = data.results.release;
                        organism.change();
                    }
                });

                //on organism change, update releases
                organism.change(function() {
                    $.webStorage.session().setItem('selected_organism_id', organism.val());

                    release.empty();
                    release.removeAttr('disabled');
                    if (rel_release[organism.val()] == undefined) {
                        release.attr('disabled', 'disabled');
                        $('<option/>').val('').text('/').appendTo(release);
                    } else {
                        $.each(rel_release[organism.val()], function() {
                            var option = $('<option/>').val(this.release).text(this.release);
                            if (this.release == selected_release) {
                                option.attr('selected', 'selected');
                            }
                            option.appendTo(release);
                        });
                    }
                    release.change();
                });

                //on release change, store for next page loaded
                release.change(function() {
                    $.webStorage.session().setItem('selected_release', release.val());
                });

                //autocomplete for quicksearch-box
                $("#search_unigene").autocomplete({
                    position: {
                        my: "right top", at: "right bottom"
                    },
                    source: function(request, response) {
                        $.ajax({
                            url: "{#$ServicePath#}/listing/searchbox/",
                            data: {species: organism.val(), release: release.val(), term: request.term},
                            dataType: "json",
                            success: function(data) {
                                response(data.results);
                            }
                        });
                    },
                    minLength: 2,
                    select: function(event, ui) {
                        location.href = "{#$AppPath#}/details/byId/" + ui.item.id;
                    }
                });
                //render as link to allow open in background & co
                $("#search_unigene").data("ui-autocomplete")._renderItem = function(ul, item) {
                    var li = $("<li>")
                            .append("<a href='{#$AppPath#}/details/byId/" + item.id + "'><span style='display:inline-block; width:100px'>" + item.type + "</span>" + item.name + "</a>")
                            .appendTo(ul);
                    return li;
                };
            });
        </script>
        <script type="text/javascript">
            //scrolls to #anchor
            function jumptoanchor(name) {
                $(document.body).scrollTop($('#' + name).offset().top - 45);

            }

            //adds an anchor to the document where this is called, adds link to #quicknav
            function addNavAnchor(name, linktext) {
                //manipulate DOM when page loading has finished
                $(document).ready(function() {
                    if ($('#quicknav-pageheader').length == 0) {
                        $('#quicknav').append('<li class="divider" id="quicknav-pageheader"></li><li><a>on this page</a></li><li class="divider"></li>');
                    }
                    $('#quicknav').append('<li><a href="javascript:jumptoanchor(\'anchor-' + name + '\');">' + linktext + '</a></li>');
                });
                //but add the anchor here and now
                document.write('<div id="anchor-' + name + '"> </div>');
            }
        </script>
        <style>
            .ui-tooltip-content table{
                margin-bottom: 0px;
            }
            textarea {
                resize:vertical;
            }
            .top-bar-section .right li div{
                padding: 0 5px;
                line-height: 45px;
                background: #111111; 
                display:block;
            }

            .top-bar-section .right li {
                height:45px;
            }

            .top-bar-section .right .has-dropdown li {
                height:auto;
            }
            
            .top-bar-section .right label {
                color: #fff;
            }

            .ui-tabs-panel a { 
                color: #2795b6; 
            }

            .ui-tabs-nav {
                padding-left: 0px;
                padding-top: 0px;
                padding-right: 0px;
                background: #f2f2f2;
                
            }
            
            .dataTable th td{
                white-space: nowrap;
            }
        </style>
        <script type="text/javascript">
            $(document).ready(function() {
                //elements with class position will be positioned  based on their attributes. see http://jqueryui.com/position/
                $('.position').each(function() {
                    var that = $(this);
                    var my = that.attr('data-my');
                    var at = that.attr('data-at');
                    var of = that.attr('data-of');
                    of = of === 'PREV' ? that.prev() : of;
                    that.position({my: my, at: at, of: of});
                });
            });
        </script>

    {#block name='head'#}{#/block#}

</head>
<body>
    <div class="fixed">
        <nav class="top-bar" id="top">
            <ul class="title-area">
                <li class="name">
                    <h1><a href="{#$AppPath#}/">TBro &alpha;</a></h1>
                </li>
            </ul>
            <section class="top-bar-section">
                <ul class="left">{#block name='header-nav'#}
                    <li class="has-dropdown"  id="quicknav-parent"><a href="#">Navigation</a>
                        <ul class="dropdown" id="quicknav">
                            <li><a href="{#$AppPath#}/diffexpr">Differential Expressions</a></li>
                            <li><a href="{#$AppPath#}/blast">Blast</a></li>
                        </ul>
                    </li>
                    {#/block#}</ul>
                    <ul class="right">
                        <li><div><label for="select_organism">Organism:</label></div></li>
                        <li><div><select id="select_organism" style="display:inline"></select></div></li>
                        <li><div><label for="select_release">Release:</label></div></li>
                        <li><div><select id="select_release"></select></div></li>
                        <li class="divider"></li>
                        <li class="has-dropdown"  id="searchnav-parent"><a href="#">Advanced Search</a>
                            <ul class="dropdown" id="searchnav">
                                <li><a href='{#$AppPath#}/multisearch'>Search for Multiple Features</a></li>
                                <li><a href='{#$AppPath#}/annotationsearch'>Search for Annotations</a></li>
                            </ul>
                        </li>
                        <li class="divider"></li>
                        <li><div><label for="search">Quick Search:</label></div></li>
                        <li class="has-form"><input type="search" id="search_unigene"/></li>
                    </ul>
                </section>
            </nav>
        </div>
        <div class="row large-12 columns" style="padding: 0px;">
        {#block name='body'#}{#/block#}
    </div>

</body>
</html>

