{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
    <script type="text/javascript" src="{#$AppPath#}/js/canvasxpress/canvasxpress/js/canvasXpress.min.js"></script>

    <!-- use chrome frame if installed and user is using IE -->
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <script type="text/javascript" src="{#$AppPath#}/js/feature/filteredSelect.js"></script>
    <script type="text/javascript">
        (function($) {

            $(document).ready(function() {
        {#include file="js/barplot.js"#}
                $("#tabs").tabs();

                $('select').tooltip(metadata_tooltip_options({items: "option"}));


                $('#Cart').on('cartEvent', function(event) {
                    if (!((event.eventData.action || '').match(/updateItem/) || ((event.eventData.action || '').match(/(add|remove)Item/) && event.eventData.groupname === '{#$cartname#}'))) {
                        return;
                    }

                    _.delay(function() {
                        var cartitems = cart._getCartForContext()['{#$cartname#}']['items'] || [];
                        if (cartitems.length === 0) {
                            console.log("No items in cart");
                            return;
                        }
                        $.ajax('{#$ServicePath#}/listing/Filter_by_type', {
                            method: 'post',
                            data: {
                                ids: cartitems
                            },
                            success: function(data) {
                                populateBarplotSelectionBoxes({isoform: data.isoform, unigene: data.unigene}, {type: "isoform"});
                            }
                        })
                        adjustCartgroupStyle();
                        displayCartTable(cartitems, {});
                        showPathwayInfo();
                        $('#cart-notes-textfield').text(cart._getCartForContext()['{#$cartname#}']['notes']);
                        var created = parseInt(cart._getCartForContext()['{#$cartname#}']['created']) * 1000;
                        $('#cart-created-time').html(new Date(created).toLocaleString());
                        var modified = parseInt(cart._getCartForContext()['{#$cartname#}']['modified']) * 1000;
                        $('#cart-modified-time').html(new Date(modified).toLocaleString());
                    }, 500);
                });

                $('#cart-notes-textfield').blur(function() {
                    cart.updateGroup('{#$cartname#}', $('#cart-notes-textfield').val());
                });
            });


        })(jQuery);
    </script>
    <script>
        function adjustCartgroupStyle() {
            $(".selector").accordion("option", "collapsible", true);
            $('#cartgroup-{#$cartname#}').accordion("option", "active", 0);
        }
        function drawCloud(service) {
            var cartitems = cart._getCartForContext()['{#$cartname#}']['items'] || [];
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

        function annotateCart() {
            $("#dialog-edit-cart-notes").data('cart-name', "{#$cartname#}");
            $("#dialog-edit-cart-notes").data('cart-notes', $('#cart-notes-textfield').text());
            $("#dialog-edit-cart-notes").dialog("open");
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
        <div class="large-12 columns panel">
            <h2>{#$cartname#}</h2>
        </div>
    </div>
    <div class="row panel">
        <div class="large-12" id="tabs">

            <ul>
                <li><a href="#tabs-overview">Overview</a></li>
                <li><a href="#tabs-graphs">Expression Analysis</a></li>
                <li><a href="#tabs-diffexp">Diff. Expression Analysis</a></li>
                <li><a href="#tabs-pathways">Pathway Analysis</a></li>
                <li><a href="#tabs-search">Search</a></li>
                <!-- <li><a href="#tabs-wordcloud">Annotation Wordcloud</a></li> -->
            </ul>
            <div id="tabs-overview">
                <div class="row">
                    <div class="large-12 columns">  
                        <h4>Info</h4>
                    </div>
                    <div class="large-12 columns">  
                        <table style="width:100%">
                            <tbody>
                                <tr><td>Created:</td><td id="cart-created-time"> unknown </td></tr>
                                <tr><td>Last modified:</td><td id="cart-modified-time"> unknown </td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="large-12 columns">  
                        <h4>Notes <a class="cart-button-rename" title="Change Annotation" onclick="annotateCart();" href="#"><img class="cart-button-edit" src="{#$AppPath#}/img/mimiGlyphs/39.png"/> </a></h4>
                        <table style="width:100%">
                            <tbody>
                            <td id='cart-notes-textfield'> </td>
                            </tbody>
                        </table>
                    </div>
                </div>
                {#include file="display-components/cart_table.tpl"#}
            </div>
            <div id="tabs-graphs">
                {#include file="display-components/barplot.tpl"#}
            </div>
            <div id="tabs-diffexp">
                {#include file="display-components/diffexpr.tpl" cart_ids=true instance_name="cart"#}
            </div>
            <div id="tabs-pathways">
                {#include file="display-components/pathways.tpl"#}
            </div>
            <div id="tabs-search">
                Placeholder
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
