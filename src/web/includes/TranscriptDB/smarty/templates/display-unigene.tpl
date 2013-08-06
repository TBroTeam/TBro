{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
{#call_webservice path="details/unigene" data=["query1"=>$unigene_feature_id] assign='data'#}
<!--[if lt IE 9]><script type="text/javascript" src="http://canvasxpress.org/js/flashcanvas.js"></script><![endif]-->
<script type="text/javascript" src="http://canvasxpress.org/js/canvasXpress.min.js"></script>
<!-- use chrome frame if installed and user is using IE -->
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<script type="text/javascript">
    var feature_id = '{#$data.unigene.feature_id#}';
</script>
<script type="text/javascript" src="{#$AppPath#}/js/feature/barplot.js"></script>

{#/block#}
{#block name='body'#}

<div class="row">
    <div class="large-12 columns panel">
        <div class="row">
            <div class="large-12 columns">
                <h1 class="left">Unigene {#$data.unigene.name#}</h1>
                <div class="right"><span class="button" onclick="javascript:cart.addItem({#$data.unigene.feature_id#});"> Add to Cart </span></div>
            </div>
        </div>
        <h5>last modified: {#$data.unigene.timelastmodified#}</h5>
    </div>
</div>

{#if (isset($data.unigene.isoforms) && count($data.unigene.isoforms)>0)#}
    <script type="text/javascript">
        var isoform_data = _.map({#$data.unigene.isoforms|json_encode#}, function(elem){
            return $.extend({alias:''}, elem);
        });
        $(document).ready(function(){
            displayFeatureTable(isoform_data, {
                bPaginate: false,
                bFilter: false 
            });
        });
    </script>
    <div class="row">
        <div class="large-12 columns">
            <h4>Known Isoforms:</h4>
        </div>
    </div>
    <div class="row">        
        <div class="large-12 columns panel">
            {#include file="display-components/feature_table.tpl"#}
        </div>
    </div>
{#/if#}
{#include file="display-components/barplot.tpl"#}
{#/block#}