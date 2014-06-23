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
            
            $('#Cart').on('cartEvent', function(event) {
                if (!((event.eventData.action || '').match(/updateItem/) || ((event.eventData.action || '').match(/(add|remove)Item/)))) {
                    return;
                }
                var metadata = cart._getMetadataForContext(cart.currentContext)['{#$data.unigene.feature_id#}'];
                var alias = "";
                var description = "";
                if (typeof metadata !== 'undefined') {
                    if (typeof metadata.alias !== 'undefined') {
                        alias = metadata.alias;
                    }
                    if (typeof metadata.annotations !== 'undefined') {
                        description = metadata.annotations;
                    }
                }
                $('#user-alias-textfield').val(alias);
                $('#user-description-textfield').val(description);
            });

            $('#user-alias-textfield').blur(function() {
                cart.updateItem({#$data.unigene.feature_id#}, {alias: $('#user-alias-textfield').val(), annotations: $('#user-description-textfield').val()});
            });

            $('#user-description-textfield').blur(function() {
                cart.updateItem({#$data.unigene.feature_id#}, {alias: $('#user-alias-textfield').val(), annotations: $('#user-description-textfield').val()});
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

        function updateContainingCartsSection() {
            var cfc = cart._getCartForContext();
            var hits = [];
            $.each(cfc, function(key, attr) {
                if (_.indexOf(attr.items, {#$data.unigene.feature_id#}) !== -1)
                    hits.push(key);
            });
            $('#containing-carts-section').empty();
            if (hits.length === 0) {
                $('#containing-carts-section').append('<li style="font-size:1.5em">No carts yet...</li>');
            } else {
                $.each(hits, function(id, attr) {
                    $('#containing-carts-section').append('<li style="font-size:1.5em"><a href="/graphs/' + attr + '">' + attr + '</a></li>');
                });
            }
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
            <table style="width:100%">
                <tbody>
                    <tr><td>Containing Carts</td><td><a data-reveal-id="myModal" href="#" onclick="updateContainingCartsSection();">Show</a></td></tr>
                    <tr><td>User Alias</td><td><input id='user-alias-textfield'  type="text" class="text ui-widget-content ui-corner-all"  maxlength="{#$max_chars_user_alias#}"> </td></tr>
                    <tr><td>User Description</td><td><textarea id="user-description-textfield" class="text ui-widget-content ui-corner-all" maxlength="{#$max_chars_user_description#}"></textarea>
                            <div class="right"><small>Max. {#$max_chars_user_description#} characters</small></div></td></tr>
                </tbody>
            </table>
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
            <h4>Expression Analysis</h4>
            {#include file="display-components/barplot.tpl"#}
        </div>
    </div>

    <div class="row">
        <div class="large-12 columns panel">
            <h5>Imported into TBro: {#$data.unigene.timelastmodified#}</h5>
        </div>
    </div>

    <div id="myModal" class="reveal-modal">
        <h2>This isoform is in the following carts:</h2>
        <ul id="containing-carts-section"></ul>
        <a class="close-reveal-modal">&#215;</a>
    </div>
{#/block#}