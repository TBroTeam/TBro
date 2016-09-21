
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <!--meta name="viewport" content="width=device-width" /-->
        <title>TBro {#$tbro_version#}</title>

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

        {#if isset($google_analytics_id)#}
        <script type="text/javascript">
            var gaProperty = '{#$google_analytics_id#}';

            // Disable tracking if the opt-out cookie exists.
            var disableStr = 'ga-disable-' + gaProperty;
            if (document.cookie.indexOf(disableStr + '=true') > -1) {
                window[disableStr] = true;
                $('document').ready(function () {
                    $('#google-analytics-info').html('Google Analytics is disabled for you');
                });
            }

            // Opt-out function
            function gaOptout() {
                document.cookie = disableStr + '=true; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/';
                window[disableStr] = true;
                $('#google-analytics-info').html('Google Analytics is disabled for you');
            }

            function openGADialog() {
                var dia = $('#dialog-google-analytics');
                dia.dialog({width: 800});
            }

            (function (i, s, o, g, r, a, m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)}, i[r].l = 1 * new Date()
                    ;
            a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
                    ga('create', '{#$google_analytics_id#}', 'auto', {
                        anonymizeIp: true
                    });
            ga('send', 'pageview');
        </script>
        {#/if#}

        <script type="text/javascript">
            var organism;
            var release;
            $(document).ready(function () {
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
                    success: function (data) {
                        organism.empty();
                        $.each(data.results.organism, function () {
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
                organism.change(function () {
                    $.webStorage.session().setItem('selected_organism_id', organism.val());

                    release.empty();
                    release.removeAttr('disabled');
                    if (rel_release[organism.val()] == undefined) {
                        release.attr('disabled', 'disabled');
                        $('<option/>').val('').text('/').appendTo(release);
                    } else {
                        $.each(rel_release[organism.val()], function () {
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
                release.change(function () {
                    $.webStorage.session().setItem('selected_release', release.val());
                });

                //autocomplete for quicksearch-box
                $("#search_unigene").autocomplete({
                    position: {
                        my: "right top", at: "right bottom"
                    },
                    source: function (request, response) {
                        $.ajax({
                            url: "{#$ServicePath#}/listing/searchbox/",
                            data: {species: organism.val(), release: release.val(), term: request.term},
                            dataType: "json",
                            success: function (data) {
                                response(data.results);
                            }
                        });
                    },
                    minLength: 3,
                    delay: 500,
                    select: function (event, ui) {
                        // nothing to do (follow link via a)
                        // do not try to use this function, it will not work properly as the _renderItem function does not return separate list items
                    }
                });
                //render as link to allow open in background & co
                $("#search_unigene").data("ui-autocomplete")._renderItem = function (ul, item) {
                    var li = ul.find('#quick-search-li');
                    var table = ul.find('#quick-search-table');
                    if(table.length === 0){
                        li = $("<li id='quick-search-li'>").appendTo(ul);
                        table = $("<table id='quick-search-table'>").appendTo(li);
                    }
                    var tr = $("<tr>")
                            .append("<td><a href='{#$AppPath#}/details/byId/" + item.id + "'>" + item.type + "</a></td>" +
                            "<td><a href='{#$AppPath#}/details/byId/" + item.id + "'>" + item.name + "</a></td>" +
                            "<td><a href='{#$AppPath#}/details/byId/" + item.id + "'>" + item.hit + "</a></td>")
                            .appendTo(table);
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
                $(document).ready(function () {
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

            .ui-tabs {
                border-top-width: 0px;
                border-right-width: 0px;
                border-left-width: 0px;
                border-bottom-width: 0px;
                padding-left: 0px; 
                padding-right: 0px; 
                padding-top: 0px;
                padding-bottom: 0px; 
            }

            .ui-tabs-nav {
                padding-left: 0px;
                padding-top: 0px;
                padding-right: 0px;
                background: #f2f2f2;
                border-left-width: 0px;
                border-top-width: 0px;
                border-right-width: 0px;
                border-bottom-width: 0px;
            }

            .ui-tabs-panel {
                border-width: 1px !important;
                border-color: #aaaaaa;
            }

            .dataTable th td{
                white-space: nowrap;
            }

            /* Start by setting display:none to make this hidden.
   Then we position it in relation to the viewport window
   with position:fixed. Width, height, top and left speak
   speak for themselves. Background we set to 80% white with
   our animation centered, and no-repeating */
            .modal {
                display:    none;
                position:   fixed;
                z-index:    1000;
                top:        0;
                left:       0;
                height:     100%;
                width:      100%;
                background: rgba( 255, 255, 255, .8 ) 
                    url('{#$AppPath#}/img/ajax-loader.gif') 
                    50% 50% 
                    no-repeat;
            }

            /* When the body has the loading class, we turn
               the scrollbar off with overflow:hidden */
            body.loading {
                overflow: hidden;   
            }

            /* Anytime the body has the loading class, our
               modal element will be visible */
            body.loading .modal {
                display: block;
            }
        </style>
        <script type="text/javascript">
            $(document).ready(function () {
                //elements with class position will be positioned  based on their attributes. see http://jqueryui.com/position/
                $('.position').each(function () {
                    var that = $(this);
                    var my = that.attr('data-my');
                    var at = that.attr('data-at');delete-item-annotation
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
                        <h1><a href="{#$AppPath#}/">TBro {#$tbro_version#}</a></h1>
                    </li>
                </ul>
                <section class="top-bar-section">
                    <ul class="left">{#block name='header-nav'#}
                        <li class="has-dropdown"  id="quicknav-parent"><a href="#">Navigation</a>
                            <ul class="dropdown" id="quicknav">
                                <li><a href="{#$AppPath#}/">Home</a></li>
                                <li><a href="{#$AppPath#}/impressum">Impressum</a></li>
                            </ul>
                        </li>
                        {#/block#}
                        <li class="has-dropdown"  id="searchnav-parent"><a href="#">Search</a>
                            <ul class="dropdown" id="searchnav">
                                <li><a href='{#$AppPath#}/multisearch'>Search by Name</a></li>
                                <li><a href='{#$AppPath#}/blast'>Search by Homology</a></li>
                                <li><a href='{#$AppPath#}/annotationsearch'>Search by Annotation</a></li>
                            </ul>
                        </li>
                        <li class="has-dropdown"  id="datanav-parent"><a href="#">Data</a>
                            <ul class="dropdown" id="datanav">
                                <li><a href='{#$AppPath#}/expression'>Expression Counts</a></li>
                                <li><a href='{#$AppPath#}/diffexpr'>Differential Expressions</a></li>
                            </ul>
                        </li>
                    </ul>
                    {#if isset($google_analytics_id)#}
                    <ul class="left" style="background:transparent">
                        <li>
                            <div id="google-analytics-info" style="color:white; font-size: 75%">
                                &nbsp;&nbsp;This page uses<a onclick="openGADialog()" style="padding-left: 5px;">Google Analytics (info/opt-out)</a>
                            </div>
                        </li>
                    </ul>
                    {#/if#}
                    <ul class="right">
                        <li><div><label for="select_organism">Organism:</label></div></li>
                        <li><div><select id="select_organism" style="display:inline"></select></div></li>
                        <li><div><label for="select_release">Release:</label></div></li>
                        <li><div><select id="select_release"></select></div></li>

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

        <div id="dialog-google-analytics" title="Google Analytics" style="display: none;">
            <p>

            <h4>English</h4>
            This website uses Google Analytics, a web analytics service provided by Google, Inc. (“Google”). Google Analytics uses “cookies”, which are text files placed on your computer, to help the website analyze how users use the site. The information generated by the cookie about your use of the website will be transmitted to and stored by Google on servers in the United States .
            In case IP-anonymisation is activated on this website, your IP address will be truncated within the area of Member States of the European Union or other parties to the Agreement on the European Economic Area. Only in exceptional cases the whole IP address will be first transfered to a Google server in the USA and truncated there. The IP-anonymisation is active on this website.
            Google will use this information on behalf of the operator of this website for the purpose of evaluating your use of the website, compiling reports on website activity for website operators and providing them other services relating to website activity and internet usage.
            The IP-address, that your Browser conveys within the scope of Google Analytics, will not be associated with any other data held by Google. You may refuse the use of cookies by selecting the appropriate settings on your browser, however please note that if you do this you may not be able to use the full functionality of this website. You can also opt-out from being tracked by Google Analytics with effect for the future by downloading and installing Google Analytics Opt-out Browser Addon for your current web browser: <a href="http://tools.google.com/dlpage/gaoptout?hl=en">http://tools.google.com/dlpage/gaoptout?hl=en</a>.
            As an alternative to the browser Addon or within browsers on mobile devices, you can <a href="javascript:gaOptout()">click this link</a> in order to opt-out from being tracked by Google Analytics within this website in the future (the opt-out applies only for the browser in which you set it and within this domain). - See more at: http://rechtsanwalt-schwenke.de/google-analytics-rechtssicher-nutzen-anleitung-fuer-webmaster/#sthash.jLLgpAZg.dpuf. An opt-out cookie will be stored on your device, which means that you'll have to click this link again, if you delete your cookies.

            <h4>German</h4>
            Diese Website benutzt Google Analytics, einen Webanalysedienst der Google Inc. („Google“). Google Analytics verwendet sog. „Cookies“, Textdateien, die auf Ihrem Computer gespeichert werden und die eine Analyse der Benutzung der Website durch Sie ermöglichen. Die durch den Cookie erzeugten Informationen über Ihre Benutzung dieser Website werden in der Regel an einen Server von Google in den USA übertragen und dort gespeichert.
            Im Falle der Aktivierung der IP-Anonymisierung auf dieser Webseite, wird Ihre IP-Adresse von Google jedoch innerhalb von Mitgliedstaaten der Europäischen Union oder in anderen Vertragsstaaten des Abkommens über den Europäischen Wirtschaftsraum zuvor gekürzt. Nur in Ausnahmefällen wird die volle IP-Adresse an einen Server von Google in den USA übertragen und dort gekürzt. Die IP-Anonymisierung ist auf dieser Website aktiv. Im Auftrag des Betreibers dieser Website wird Google diese Informationen benutzen, um Ihre Nutzung der Website auszuwerten, um Reports über die Websiteaktivitäten zusammenzustellen und um weitere mit der Websitenutzung und der Internetnutzung verbundene Dienstleistungen gegenüber dem Websitebetreiber zu erbringen.
            Die im Rahmen von Google Analytics von Ihrem Browser übermittelte IP-Adresse wird nicht mit anderen Daten von Google zusammengeführt. Sie können die Speicherung der Cookies durch eine entsprechende Einstellung Ihrer Browser-Software verhindern; wir weisen Sie jedoch darauf hin, dass Sie in diesem Fall gegebenenfalls nicht sämtliche Funktionen dieser Website vollumfänglich werden nutzen können. Sie können darüber hinaus die Erfassung der durch das Cookie erzeugten und auf Ihre Nutzung der Website bezogenen Daten (inkl. Ihrer IP-Adresse) an Google sowie die Verarbeitung dieser Daten durch Google verhindern, indem sie das unter dem folgenden Link verfügbare Browser-Plugin herunterladen und installieren: <a href="http://tools.google.com/dlpage/gaoptout?hl=de">http://tools.google.com/dlpage/gaoptout?hl=de</a>.
            Alternativ zum Browser-Add-On oder innerhalb von Browsern auf mobilen Geräten, <a title="Google Analytics Opt-Out-Cookie setzen" href="javascript:gaOptout()">klicken Sie bitte diesen Link</a>, um die Erfassung durch Google Analytics innerhalb dieser Website zukünftig zu verhindern (das Opt Out funktioniert nur in dem Browser und nur für diese Domain). Dabei wird ein Opt-Out-Cookie auf Ihrem Ger&auml;t abgelegt. L&ouml;schen Sie Ihre Cookies in diesem Browser, m&uuml;ssen Sie diesen Link erneut klicken.

            </p>
        </div>

        <div class="modal"><!-- Placeholder to block page when busy --></div>
        <!-- Code to render GitHub buttons -->
        <script async defer id="github-bjs" src="https://buttons.github.io/buttons.js"></script>
    </body>
</html>

