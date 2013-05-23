{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
{#call_webservice path="cart/getitems" data=["query1"=>$cartname] assign='cartitems'#}
<!--[if lt IE 9]><script type="text/javascript" src="http://canvasxpress.org/js/flashcanvas.js"></script><![endif]-->
<script type="text/javascript" src="http://canvasxpress.org/js/canvasXpress.min.js"></script>
<!-- use chrome frame if installed and user is using IE -->
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<script type="text/javascript" language="javascript" src="{#$AppPath#}/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="{#$AppPath#}/js/TableTools.min.js"></script>
<script type="text/javascript" language="javascript" src="{#$AppPath#}/js/alphanum.js"></script>
<link rel="stylesheet" href="{#$AppPath#}/css/jquery.dataTables_themeroller.css" />
<link rel="stylesheet" href="{#$AppPath#}/css/TableTools.css" />
<script type="text/javascript">
    (function($){
        var cartitems = {#$cartitems|json_encode#};
        (function(){
    {#include file="js/mav-graphs.js"#}
            })();
            (function(){
    {#include file="js/mav-diffexpr.js"#}
            })();
            $(document).ready(function(){
                $( "#tabs" ).tabs();    
            });
        })(jQuery);
</script>
{#/block#}
{#block name='body'#}

<div class="row">
    <div class="large-12 columns">
        <h2>Multi-Feature Actions</h2>
    </div>
</div>
<div class="row">
    <div class="large-12 columns" id="tabs">

        <ul>
            <li><a href="#tabs-graphs">Graphs</a></li>
            <li><a href="#tabs-diffexp">differential Expressions</a></li>
        </ul>
        <div id="tabs-graphs">
            <div class="row">
                <div class="large-3 columns">
                    <h4>Features</h4>
                </div>
                <div class="large-3 columns">
                    <h4>Assay</h4>
                </div>
                <div class="large-3 columns">
                    <h4>Analysis</h4>
                </div>
                <div class="large-3 columns">
                    <h4>Samples</h4>
                </div>
            </div>

            <form id="filters">
                <div class="row">
                    <div class="large-3 columns panel">
                        <select id="select-elements" size="12" multiple="multiple"></select>
                    </div>
                    <div class="large-3 columns panel">
                        <select id="select-assay" size="12"></select>
                    </div>
                    <div class="large-3 columns panel">
                        <select id="select-analysis" size="12"></select>
                    </div>
                    <div class="large-3 columns panel">
                        <select id="select-tissues" size="12" multiple="multiple"></select>
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
            <div class="row">
                <div class="large-12 column">

                    <table id="diffexp">
                        <thead>  
                            <tr>
                                <th>feature</th>
                                <th>baseMean</th>
                                <th>baseMeanA</th>
                                <th>baseMeanB</th>
                                <th>foldChange</th>
                                <th>log2foldChange</th>
                                <th>pval</th>
                                <th>pvaladj</th>
                            </tr>
                        </thead>  
                        <tfoot>
                            <tr>
                                <td>
                                    <select>
                                        <option value="contains">contains</option>
                                    </select>
                                    <input type="text" />
                                </td>
                                {#for $i=0; $i<7; $i++#}
                                <td>
                                    <select>
                                        <option value="lt">&lt;</option>
                                        <option value="gt">&gt;</option>
                                        <option value="eq">=</option>
                                        <option value="contains">contains</option>
                                    </select>
                                    <input type="text" />
                                </td>
                                {#/for#}
                            </tr>
                        </tfoot>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



{#/block#}