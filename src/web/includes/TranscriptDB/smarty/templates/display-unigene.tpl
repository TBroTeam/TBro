{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
    {#call_webservice path="details/unigene" data=["query1"=>$unigene_feature_id] assign='data'#}
    <!--[if lt IE 9]><script type="text/javascript" src="http://canvasxpress.org/js/flashcanvas.js"></script><![endif]-->
    <script type="text/javascript" src="http://canvasxpress.org/js/canvasXpress.min.js"></script>
    <!-- use chrome frame if installed and user is using IE -->
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <script type="text/javascript">
        var feature_id = '{#$data.unigene.feature_id#}';

        $(document).ready(function() {
            new Grouplist($('#button-unigene-addToCart-options'), cart, addSelectedToCart);
            $('#button-unigene-addToCart-options-newcart').click(addSelectedToCart);
        });

        function addSelectedToCart() {
            var group = $(this).attr('data-value');
            if (group === '#new#')
                group = cart.addGroup();
            cart.addItem({#$data.unigene.feature_id#}, {
                groupname: group
            });
        }
        
    </script>
    <script type="text/javascript" src="{#$AppPath#}/js/feature/barplot.js"></script>

{#/block#}
{#block name='body'#}

    <div class="row">
        <div class="large-12 columns panel">
            <div class="row">
                <div class="large-12 columns">
                    <h1 class="left">Unigene {#$data.unigene.name#}</h1>
                    <div class="right">
                        <button class="large button dropdown" type="button" id="button-unigene-addToCart" data-dropdown="button-unigene-addToCart-options"> Add to Cart </button>
                        <ul id="button-unigene-addToCart-options" class="f-dropdown" data-dropdown-content>
                            <li id="button-unigene-addToCart-options-newcart" class="keep" data-value="#new#">new</li>
                        </ul>
                    </div>
                </div>
            </div>
            <h5>Imported into TBro: {#$data.unigene.timelastmodified#}</h5>
        </div>
    </div>

    {#if (isset($data.unigene.isoforms) && count($data.unigene.isoforms)>0)#}
        <script type="text/javascript">
            var isoform_data = _.map({#$data.unigene.isoforms|json_encode#}, function(elem) {
                return $.extend({alias: ''}, elem);
            });
            $(document).ready(function() {
                displayFeatureTable(isoform_data, {
                    bPaginate: false,
                    bFilter: false
                });
            });
        </script>
        <div class="row">        
            <div class="large-12 columns panel">
                <div class="row">
                    <div class="large-12 columns">
                        <h4>Known Isoforms:</h4>
                    </div>
                </div>
                {#include file="display-components/feature_table.tpl"#}
            </div>
        </div>
    {#/if#}
    {#include file="display-components/barplot.tpl"#}
{#/block#}