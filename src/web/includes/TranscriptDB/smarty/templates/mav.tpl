{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
    <!--[if lt IE 9]><script type="text/javascript" src="http://canvasxpress.org/js/flashcanvas.js"></script><![endif]-->
    <script type="text/javascript" src="http://canvasxpress.org/js/canvasXpress.min.js"></script>
    <script type="text/javascript" src="{#$AppPath#}/js/jqTagCloud.js"></script> 

    <!-- use chrome frame if installed and user is using IE -->
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <script type="text/javascript" src="{#$AppPath#}/js/feature/filteredSelect.js"></script>
    <style type="text/css">
        #filters tr td, #filters tr th {
            padding: 1px !important;
        }
        #filters input {
            margin: 0px !important;
        }
    </style>
    <script type="text/javascript">
        (function($) {

        {#include file="js/mav-graphs.js"#}
            (function() {
        {#include file="js/diffexpr.js" cart_ids=true#}
            })();
            $(document).ready(function() {
                $("#tabs").tabs();

                $('select').tooltip(metadata_tooltip_options({items: "option"}));


                $('#Cart').on('cartEvent', function(event) {
                    if (!(event.eventData.action === 'updateContext'))
                        return;

                    console.log(event.eventData);
                    _.delay(function() {
                        var cartitems = cart._getCartForContext()['{#$cartname#}'] || [];
                        adjustCartgroupStyle();
                        if (cartitems.length === 0) {
                            console.log("No items in cart");
                            return;
                        }
                        displayCartTable(cartitems, {});
                        showPathwayInfo();
                    }, 500);
                });
            });


        })(jQuery);
    </script>
    <script>
        function adjustCartgroupStyle() {
            $('#cartgroup-{#$cartname#}').css("background", "green");
            $('#cartgroup-{#$cartname#}').css("color", "white");
            $('#cartgroup-{#$cartname#}').css("cursor", "auto");
            $('#cartgroup-{#$cartname#}').css("font-weight", "bold");
        }
        function drawCloud(service) {
            var cartitems = cart._getCartForContext()['{#$cartname#}'] || [];
            var prefix = '';
            if (service === 'gos') {
                prefix = 'http://amigo.geneontology.org/cgi-bin/amigo/term_details?term=GO:';
            }
            $('#panel-wordclouds').show();
            $.ajax('{#$ServicePath#}/listing/wordcloud/' + service, {
                method: 'post',
                data: {
                    parents: cartitems
                },
                success: function(data) {
                    var mf = data.results.molecular_function;
                    var bp = data.results.biological_process;
                    var cc = data.results.cellular_component;
                    var wc_mf = $('#wordcloud_mf');
                    var wc_bp = $('#wordcloud_bp');
                    var wc_cc = $('#wordcloud_cc');
                    wc_mf.empty();
                    $.each(mf, function(key, value) {
                        wc_mf.append('<a href="' + prefix + value.accession + '" count="' + value.count + '" target="_blank">' + key + '</a>');
                    });
                    wc_mf.jqTagCloud({maxSize: 35, minSize: 10});
                    wc_bp.empty();
                    $.each(bp, function(key, value) {
                        wc_bp.append('<a href="' + prefix + value.accession + '" count="' + value.count + '" target="_blank">' + key + '</a>');
                    });
                    wc_bp.jqTagCloud({maxSize: 35, minSize: 10});
                    wc_cc.empty();
                    $.each(cc, function(key, value) {
                        wc_cc.append('<a href="' + prefix + value.accession + '" count="' + value.count + '" target="_blank">' + key + '</a>');
                    });
                    wc_cc.jqTagCloud({maxSize: 35, minSize: 10});
                }
            });
        }
    </script>
    <style type="text/css">
        .wordcloud a {
            padding: 2px 5px;
        }
    </style>
{#/block#}
{#block name='body'#}

    <div class="row">
        <div class="large-12 columns">
            <h2>{#$cartname#}</h2>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns" id="tabs">

            <ul>
                <li><a href="#tabs-overview">Overview</a></li>
                <li><a href="#tabs-graphs">Expression Plots</a></li>
                <li><a href="#tabs-diffexp">Differential Expression Analysis</a></li>
                <li><a href="#tabs-pathways">Pathways</a></li>
                <!-- <li><a href="#tabs-wordcloud">Annotation Wordcloud</a></li> -->
            </ul>
            <div id="tabs-overview">
                {#include file="display-components/cart_table.tpl"#}
            </div>
            <div id="tabs-graphs">
                <div id="tabs-graphs-selection">
                    <div class="row">
                        <div class="large-4 columns">
                            <h4>Experiment</h4>
                        </div>
                        <div class="large-4 columns">
                            <h4>Analysis</h4>
                        </div>
                        <div class="large-4 columns">
                            <h4>Samples</h4>
                        </div>
                    </div>

                    <form id="filters">
                        <div class="row panel">
                            <div class="large-4 columns">
                                <select id="select-assay" size="12"></select>
                            </div>
                            <div class="large-4 columns">
                                <select id="select-analysis" size="12"></select>
                            </div>
                            <div class="large-4 columns">
                                <select id="select-sample" size="12" multiple="multiple"></select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-12 columns panel">
                                <div class="large-8 columns">
                                    <input type="checkbox" id="isoform-barplot-groupByTissues"/><label style="display:inline-block" for="isoform-barplot-groupByTissues"> &nbsp;Pool by Tissue Group</label>
                                </div>
                                <div class="large-4 columns">
                                    <button type="button" id="button-barplot" value="barplot">Barplot</button>
                                    <button type="button" id="button-heatmap" value="heatmap">Heatmap</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row" id="isoform-barplot-panel" name="isoform-barplot-panel" style="display:none">
                        <div class="large-12 columns panel">
                            <div class="row">
                                <div class="large-12 columns">
                                    <div style="width:100%" id="isoform-barplot-canvas-parent">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tabs-diffexp">
                {#include file="display-components/diffexpr.tpl" cart_ids=true#}
            </div>
            <div id="tabs-pathways">
                {#include file="display-components/pathways.tpl"#}
            </div>
            <div id="tabs-wordcloud" style="display: none">
                <button class="button" onclick="drawCloud('gos');">Draw GO wordclouds</button> 
                <div id="panel-wordclouds" style="display: none">
                    <h5> Molecular Function </h5>
                    <div id="wordcloud_mf" class="wordcloud large-12 column panel"></div>
                    <h5> Biological Process </h5>
                    <div id="wordcloud_bp" class="wordcloud large-12 column panel"></div>
                    <h5> Cellular Component </h5>
                    <div id="wordcloud_cc" class="wordcloud large-12 column panel"></div>
                </div>
            </div>
        </div>
    </div>



{#/block#}