{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
    <!--[if lt IE 9]><script type="text/javascript" src="http://canvasxpress.org/js/flashcanvas.js"></script><![endif]-->
    <script type="text/javascript" src="http://canvasxpress.org/js/canvasXpress.min.js"></script>
    <script type="text/javascript" src="{#$AppPath#}/js/jquery.awesomeCloud-0.2.min.js"></script> 

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
            });
        })(jQuery);
    </script>
{#/block#}
{#block name='body'#}

    <div class="row">
        <div class="large-12 columns">
            <h2>Multi-Feature Actions on Cart {#$cartname#}</h2>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns" id="tabs">

            <ul>
                <li><a href="#tabs-graphs">Graphs</a></li>
                <li><a href="#tabs-diffexp">differential Expressions</a></li>
                <li><a href="#tabs-wordcloud">Wordcloud</a></li>
            </ul>
            <div id="tabs-graphs">
                <div class="row">
                    <div class="large-3 columns">
                        <h4>Assay</h4>
                    </div>
                    <div class="large-3 columns">
                        <h4>Analysis</h4>
                    </div>
                    <div class="large-3 columns">
                        <h4>Features</h4>
                    </div>
                    <div class="large-3 columns">
                        <h4>Samples</h4>
                    </div>
                </div>

                <form id="filters">
                    <div class="row">
                        <div class="large-3 columns panel">
                            <select id="select-assay" size="12"></select>
                        </div>
                        <div class="large-3 columns panel">
                            <select id="select-analysis" size="12"></select>
                        </div>
                        <div class="large-3 columns panel">
                            <select id="select-elements" size="12" multiple="multiple"></select>
                        </div>
                        <div class="large-3 columns panel">
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
            <div id="tabs-diffexp">
                {#include file="display-components/diffexpr.tpl" cart_ids=true#}
            </div>
            <div id="tabs-wordcloud">
                <div id="wordcloud" style="border:1px solid #f00;height:150px;width:150px;">
                    <span data-weight="14">word</span>
                    <span data-weight="5">another</span>
                    <span data-weight="7">things</span>
                    <span data-weight="23">super</span>
                    <span data-weight="10">cloud</span>
                </div>
                <script>
                    var settings = {
                        "size": {
                            "grid": 16
                        },
                        "options": {
                            "color": "random-dark",
                            "printMultiplier": 3
                        },
                        "font": "Futura, Helvetica, sans-serif",
                        "shape": "square"
                    }
                    $("#wordcloud").awesomeCloud(settings);
                </script>
            </div>
        </div>
    </div>



{#/block#}