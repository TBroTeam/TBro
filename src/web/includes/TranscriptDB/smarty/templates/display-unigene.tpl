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
            new Grouplist($('#button-unigene-addToCart-options'), cart, addUnigeneToCart);
            $('#button-unigene-addToCart-options-newcart').click(addUnigeneToCart);

            $('.unigene-header').draggable({
                appendTo: "body",
                helper: function() {
                    return $('<div>', {text: $('.unigene-header').text()}).addClass('beingDragged');
                },
                cursorAt: {top: 5, left: 5}
            });
        });

        function addUnigeneToCart() {
            var group = $(this).attr('data-value');
            if (group === '#new#')
                group = cart.addGroup();
            cart.addItem({#$data.unigene.feature_id#}, {
                groupname: group
            });
        }
    </script>

{#/block#}
{#block name='body'#}

    <div class="row">
        <div class="large-12 columns panel">
            <div class="row">
                <div class="large-12 columns">
                    <h1 class="left unigene-header" data-id="{#$data.unigene.feature_id#}">Unigene {#$data.unigene.name#}</h1>
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
    {#if isset($data.unigene.description) #}
        <div class="row">
            <div class="large-12 columns panel">
                <h4>Description</h4>
                <table style="width:100%">
                    <tbody>
                        {#foreach $data.unigene.description as $description#}
                            <tr><td>{#$description.value#}</td></tr>
                        {#/foreach#}
                    </tbody>
                </table>
            </div>
        </div>
    {#/if#}
    {#if (isset($data.unigene.isoforms) && count($data.unigene.isoforms)>0)#}
        <script type="text/javascript">
            var isoform_data = _.map({#$data.unigene.isoforms|json_encode#}, function(elem) {
                return $.extend({alias: ''}, elem);
            });
            $(document).ready(function() {
                displayFeatureTable(isoform_data, {
                    // bPaginate: false,
                    // bFilter: false
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
    <script type="text/javascript">
        $(document).ready(function() {
        {#include file="js/barplot.js"#}
            var isoform_ids = _.map({#$data.unigene.isoforms|json_encode#}, function(elem) {
                return elem.feature_id;
            });
            populateBarplotSelectionBoxes({
                isoform: isoform_ids,
                unigene: [{#$data.unigene.feature_id#}]
            }, {type: "unigene"});
        });
    </script>
    <div class="row">
        <div class="large-12 columns panel">
            <h4>Barplot</h4>
            {#include file="display-components/barplot.tpl"#}
        </div>
    </div>
{#/block#}