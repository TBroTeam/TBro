<?php /* Smarty version Smarty-3.1.13, created on 2013-05-10 12:18:43
         compiled from "C:\Users\mail_000\Dropbox\uni\bio\s202139\web\smarty\templates\graphs.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17284518cb35a53ef94-19477966%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2be43bf12443c59f7eb9c4f64f8cff4311ed1ec6' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\graphs.tpl',
      1 => 1368181046,
      2 => 'file',
    ),
    'c44393500e69763bf56453147eb3e23dada271cd' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\layout-with-cart.tpl',
      1 => 1368172198,
      2 => 'file',
    ),
    'c9e223e75317f40ea70fe3d34aff134ea2c81027' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\layout.tpl',
      1 => 1368181122,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17284518cb35a53ef94-19477966',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_518cb35a685160_09866913',
  'variables' => 
  array (
    'AppPath' => 0,
    'ServicePath' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_518cb35a685160_09866913')) {function content_518cb35a685160_09866913($_smarty_tpl) {?><?php if (!is_callable('smarty_function_call_webservice')) include 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\/plugins\\function.call_webservice.php';
?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <!--meta name="viewport" content="width=device-width" /-->
        <title>Transcript Browser - dionaea muscipula</title>

        <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/css/normalize.css" />
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/css/foundation.css" />
        <!--link type="text/css" href="http://code.jquery.com/ui/1.10.1/themes/base/minified/jquery-ui.min.css" rel="Stylesheet" /-->    
        <link type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/css/custom-theme/jquery-ui-1.10.2.custom.css" rel="Stylesheet" />    

        <!--script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script-->
        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/jquery-1.9.1.min.js"></script>
        <!--script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script-->
        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/jquery-ui-1.10.2.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/vendor/custom.modernizr.js"></script>
        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/foundation.min.js"></script>        
        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/jquery.webStorage.min.js"></script>        
        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/underscore-min.js"></script>


        <script type="text/javascript">
            var organism;
            var dataset;
            $(document).ready(function() {
                $(document).foundation();

                organism = $('#select_organism');
                dataset = $('#select_dataset');
                var rel_dataset = null;

                $.ajax({
                    url: "<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/listing/organism_dataset",
                    dataType:"json",
                    success:function(data){
                        organism.empty();
                        $.each(data.results.organism, function(){
                            $('<option/>').val(this.organism_id).text(this.organism_name).appendTo(organism);
                        });
                        rel_dataset = data.results.dataset;
                        organism.click();   
                    }
                });
                
                organism.click(function(){
                    dataset.empty();
                    dataset.removeAttr('disabled');
                    if (rel_dataset[organism.val()] == undefined){
                        dataset.attr('disabled','disabled');
                        $('<option/>').val('').text('/').appendTo(dataset);
                    } else {
                        $.each(rel_dataset[organism.val()], function(){
                            $('<option/>').val(this.dataset).text(this.dataset).appendTo(dataset);
                        });
                    }
                });

                $("#search_unigene").autocomplete({
                    position: {
                        my: "right top", at: "right bottom"
                    },
                    source: function(request, response) {
                        $.ajax({
                            url: "<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/listing/searchbox/",
                            data: {species: organism.val(), dataset: dataset.val(), term: request.term},
                            dataType: "json",
                            success: function(data) {
                                response(data.results);
                            }
                        });
                    },
                    minLength: 2,
                    select: function(event, ui) {
                        location.href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/"+ui.item.type+"-details/byId/"+ui.item.id;
                    }
                });
                $("#search_unigene").data("ui-autocomplete")._renderItem = function(ul, item) {
                    var li =$("<li>")
                    .append("<a href='<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/"+item.type+"-details/byId/"+item.id+"'><span style='display:inline-block; width:100px'>"+item.type+"</span>" + item.name+ "</a>")
                    .appendTo(ul);
                    return li;
                };
            });</script>
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
            
            .top-bar-section .right a {
                text-decoration: underline;
            }
            
            .top-bar-section .right label {
                color: #fff;
            }
        </style>

        
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/feature/cart.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/feature/cart-init.js"></script>
<style>
    .ui-accordion .ui-accordion-header {
        margin-bottom:0px;
    }
    .ui-accordion .ui-accordion-content {
        padding: 0.5em 1em;
    }
    .beingDragged {
        list-style: none;
    }
    *[class*='cart-button-']{
        cursor: pointer;
    }

    fieldset *:last-child{
        margin-bottom: 0px;
    }

    form {
        margin: 0px;
    }
</style>

<?php echo smarty_function_call_webservice(array('path'=>"cart/getitems",'data'=>array("query1"=>$_smarty_tpl->tpl_vars['cartname']->value),'assign'=>'cartitems'),$_smarty_tpl);?>

<!--[if lt IE 9]><script type="text/javascript" src="http://canvasxpress.org/js/flashcanvas.js"></script><![endif]-->
<script type="text/javascript" src="http://canvasxpress.org/js/canvasXpress.min.js"></script>
<!-- use chrome frame if installed and user is using IE -->
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<script type="text/javascript">
    var filterdata;


    function arr_intersect(a1, a2) {
        var ret = [];
        $.each(a1, function() {
            var a = this;
            $.each(a2, function() {
                if (_.isEqual(this, a)) {
                    ret.push(this);
                    return false; //jquery break;
                }
            });
        });
        return ret;
    }

    $(document).ready(function() {
        $('#filters').tooltip({
            items: "option",
            open: function(event, ui) {
                ui.tooltip.offset({top: event.pageY, left: event.pageX});
                ui.tooltip.css("max-width", "600px");
            },
            content: function() {
                var element = $(this);
                var tooltip = $("<table />");
                $.each(element.data('metadata'), function(key, val) {
                    $("<tr><td>" + key + "</td><td>" + (val !== null ? val : '') + "</td></tr>").appendTo(tooltip);
                });
                tooltip.foundation();
                return tooltip;
            }
        });

        var ids = [];

        var select_element = $('#select-elements');
        var select_assay = $('#select-assay');
        var select_analysis = $('#select-analysis');
        var select_tissues = $('#select-tissues');


        var cartitems = <?php echo json_encode($_smarty_tpl->tpl_vars['cartitems']->value);?>
;

        $.each(cartitems, function() {
            var item = this;
            ids.push(item.feature_id);
            var displayname = (item.alias != undefined) ? item.alias : item.name;
            $('<option />').
                    text(displayname).
                    val(item.feature_id).
                    data('metadata', item).
                    attr('selected', 'selected').
                    appendTo(select_element);
        });

        $.ajax('<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/listing/filters/', {
            method: 'post',
            data: {ids: ids},
            success: function(data) {
                filterdata = data;
                select_element.click();
            }
        });

        function getSelectedArr() {
            var selected = select_element.find(':selected');
            var ret = [];
            selected.each(function() {
                ret.push($(this).val());
            });
            return ret;
        }

        select_element.click(function() {
            var selected = select_element.find(':selected');

            var currently_selected = {
                elements: getSelectedArr()
            };
            var last_selected = $(this).data('last-selected');
            if (_.isEqual(currently_selected, last_selected))
                return;
            $(this).data('last-selected', currently_selected);

            var intersection = [];
            selected.each(function() {
                var feature_id = $(this).data('metadata').feature_id;
                var this_assays = filterdata.assay[feature_id];
                if (this_assays == null) {
                    intersection = [];
                    //jquery break
                    return false;
                }
                if (intersection.length === 0) {
                    intersection = this_assays;
                } else {
                    intersection = arr_intersect(intersection, this_assays);
                }
            });
            select_assay.empty();
            $.each(intersection, function() {
                var data = filterdata.data.assay[this];
                var opt = $("<option/>").val(data.id).text(data.name).data('metadata', data);
                opt.appendTo(select_assay);
            });

            select_assay.find('option').first().attr('selected', 'selected');
            select_assay.click();
        });

        select_assay.click(function() {
            var assay = $(this).val();

            var selected = select_element.find(':selected');
            var currently_selected = {
                assay: assay,
                elements: getSelectedArr()
            };

            var last_selected = $(this).data('last-selected');
            if (_.isEqual(currently_selected, last_selected))
                return;
            $(this).data('last-selected', currently_selected);

            if (assay == null) {
                select_analysis.empty();
                select_analysis.click();
                return;
            }

            var intersection = [];
            selected.each(function() {
                if (filterdata.analysis[$(this).data('metadata').feature_id] == null
                        || filterdata.analysis[$(this).data('metadata').feature_id][assay] == null) {
                    intersection = [];
                    //jquery break
                    return false;
                }
                var this_analysises = filterdata.analysis[$(this).data('metadata').feature_id][assay];
                if (intersection.length === 0) {
                    intersection = this_analysises;
                } else {
                    intersection = arr_intersect(intersection, this_analysises);
                }
            });
            select_analysis.empty();

            $.each(intersection, function() {
                var data = filterdata.data.analysis[this];
                var opt = $("<option/>").val(data.id).text(data.id + "(" + data.program + ")").data('metadata', data);
                opt.appendTo(select_analysis);
            });


            select_analysis.find('option').first().attr('selected', 'selected');
            select_analysis.click();
        });

        select_analysis.click(function() {
            var analysis = $(this).val();

            var selected = select_element.find(':selected');
            var assay = select_assay.val();
            var currently_selected = {
                assay: assay,
                analysis: analysis,
                elements: getSelectedArr()
            };

            var last_selected = $(this).data('last-selected');
            if (_.isEqual(currently_selected, last_selected))
                return;
            $(this).data('last-selected', currently_selected);

            if (analysis == null) {
                select_tissues.empty();
                return;
            }

            var intersection = [];
            selected.each(function() {
                var this_tissues = filterdata.biomaterial[$(this).data('metadata').feature_id][analysis][assay];
                if (intersection.length === 0) {
                    intersection = this_tissues;
                } else {
                    intersection = arr_intersect(intersection, this_tissues);
                }
            });

            select_tissues.empty();

            $.each(intersection, function() {
                var data = filterdata.data.biomaterial[this];
                var opt = $("<option/>").val(data.id).text(data.name).data('metadata', data).attr('selected', 'selected');
                opt.appendTo(select_tissues);
            });
        });


        function getFilterData() {
            var data = {parents: [], analysis: [], assay: [], biomaterial: []};
            select_element.find(':selected').each(function() {
                data.parents.push($(this).val());
            });
            data.analysis.push(select_analysis.find(':selected').val());
            data.assay.push(select_assay.find(':selected').val());
            select_tissues.find(':selected').each(function() {
                data.biomaterial.push($(this).val());
            });
            return data;
        }

        $('#button-barplot').click(function() {

            $.ajax('<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/graphs/barplot/quantifications', {
                data: getFilterData(),
                success: function(val) {
                    $('#isoform-barplot-panel').show(0);
                    var parent = $("#isoform-barplot-canvas-parent");

                    //if we already have an old canvas, we have to clean that up first
                    var canvas = $('#isoform-barplot-canvas');
                    var cx = canvas.data('canvasxpress');
                    if (cx != null) {
                        cx.destroy();
                        parent.empty();
                    }

                    canvas = $('<canvas id="isoform-barplot-canvas"></canvas>');
                    parent.append(canvas);
                    canvas.attr('width', parent.width() - 8);
                    canvas.attr('height', 500);

                    window.location.hash = "isoform-barplot-panel";


                    cx = new CanvasXpress(
                            "isoform-barplot-canvas",
                            {
                                "x": val.x,
                                "y": val.y
                            },
                    {
                        "graphType": "Bar",
                        "showDataValues": true,
                        "graphOrientation": "vertical"
                    });

                    canvas.data('canvasxpress', cx);

                    groupByTissues();


                }
            });
            return false;
        });

        $('#button-heatmap').click(function() {
            $.ajax('<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/graphs/barplot/quantifications', {
                data: getFilterData(),
                success: function(val) {
                    $('#isoform-barplot-panel').show(0);
                    var parent = $("#isoform-barplot-canvas-parent");

                    //if we already have an old canvas, we have to clean that up first
                    var canvas = $('#isoform-barplot-canvas');
                    var cx = canvas.data('canvasxpress');
                    if (cx != null) {
                        cx.destroy();
                        parent.empty();
                    }

                    canvas = $('<canvas id="isoform-barplot-canvas"></canvas>');
                    parent.append(canvas);
                    canvas.attr('width', parent.width() - 8);
                    canvas.attr('height', 500);

                    window.location.hash = "isoform-barplot-panel";


                    cx = new CanvasXpress(
                            "isoform-barplot-canvas",
                            {
                                "x": val.x,
                                "y": val.y
                            },
                    {
                        "graphType": "Heatmap",
                        "showDataValues": true,
                        "graphOrientation": "vertical"
                    });

                    canvas.data('canvasxpress', cx);
                            groupByTissues();


                }
            });
            return false;
        });

        function groupByTissues() {
            var checkbox = $(this);
            var cx = $('#isoform-barplot-canvas').data('canvasxpress');
            if (checkbox.is(':checked')) {
                cx.groupSamples(["Tissue_Group"]);
            } else {
                cx.groupSamples([]);
            }
        }

        $('#isoform-barplot-groupByTissues').click(groupByTissues);


    });
</script>



    </head>
    <body>
        <div class="fixed">
            <nav class="top-bar" id="top">
                <ul class="title-area">
                    <li class="name">
                        <h1><a href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/">Transcript Browser</a></h1>
                    </li>
                </ul>
                <section class="top-bar-section">
                    <ul class="left"></ul>
                    <ul class="right">
                        <li><div><label for="select_organism">organism:</label></div></li>
                        <li><div><select id="select_organism" style="display:inline"></select></div></li>
                        <li><div><label for="select_dataset">release:</label></div></li>
                        <li><div><select id="select_dataset"></select></div></li>
                        <li class="divider"></li>
                        <li><a href='<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/multisearch'>adv. search</a></li>
                        <li class="divider"></li>
                        <li><div><label for="search">quick search:</label></div></li>
                        <li class="has-form"><input type="search" id="search_unigene"/></li>
                    </ul>
                </section>
            </nav>
        </div>
        <div class="row large-12 columns" style="padding: 0px;">
            
<div class="row">
    <div class="large-9 columns">
        

<div class="row">
    <div class="large-12 columns">
        <h2>Graph View</h2>
    </div>
</div>

<div class="row">
    <div class="large-3 columns">
        <h4>Elements</h4>
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
    <div class="large-3 columns" >
        <div class="row large-3 columns" style="position:fixed;top:45px;bottom:0;overflow-x:hidden;overflow-y:auto;">


            <div style="display: none">
                <div id="cartitem-tooltip">
                    <table>
                        <tr><td>Feature_id</td><td>#feature_id#</td></tr>
                        <tr><td>Alias</td><td>#alias#</td></tr>
                        <tr><td>Annotations</td><td>#annotations#</td></tr>
                    </table>
                </div>

                <div id="dialog-rename-cart-group" title="rename cart">
                    <form>
                        <fieldset>
                            <label for="cartname">cart name</label>
                            <input type="text" name="name" id="cartname" class="text ui-widget-content ui-corner-all" />
                        </fieldset>
                    </form>
                </div>

                <div id="dialog-delete-all" title="Delete all items and groups?">
                    <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>This will remove all your cart items and groups. Are you sure?</p>
                </div>

                <div id="dialog-edit-cart-item" title="edit item">
                    <form>
                        <fieldset>
                            <label for="item-feature_id">feature_id</label>
                            <input type="text" name="feature_id" id="item-feature_id" disabled="disabled" class="text ui-widget-content ui-corner-all" />
                        </fieldset>
                        <fieldset>
                            <label for="item-alias">display alias</label>
                            <input type="text" name="alias" id="item-alias" class="text ui-widget-content ui-corner-all" />
                            <label for="item-annotations">annotations</label>
                            <textarea name="annotations" id="item-annotations" class="text ui-widget-content ui-corner-all"></textarea>
                        </fieldset>
                    </form>
                </div>
            </div>

            <div class="panel large-12 columns">
                <?php if ((isset($_SESSION['OpenID']))){?>
                <form action="?logout" method="post">
                    <button>Logout</button>
                </form>
                <?php }else{ ?>
                <form action="?login" method="post">
                    <button>Login with Google</button>
                </form>
                <?php }?>
            </div>

            <div class="panel large-12 columns" id="cart">
                <h4>Cart</h4>
                <div id="cart-group-all" class='ui_accordion ui_collapsible'>
                    <div class="large-12 columns"><div class="left">all</div><div class="right"><img class="cart-button-delete" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/51.png"/><img class="cart-button-execute"  src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/23.png"/></div></div>
                    <ul class="large-12 columns">
                    </ul>
                </div>
                <div>
                    <a id="cart-add-group" class="button secondary right">add new cart</a>
                    <div style="clear:both">&nbsp;</div>
                </div>
                <div id="cart-groups">

                </div>
            </div>

            <div style="display: none">
                <div id="cart-group-dummy"> 
                    <div class='cart-group' data-group="#groupname#">
                        <div class="large-12 columns">
                            <div class="groupname left">#groupname#</div>
                            <div class="right">
                                <img class="cart-button-rename" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/39.png"/>
                                <img class="cart-button-delete" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/51.png"/>
                                <img class="cart-button-execute" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/23.png"/>
                            </div>
                        </div>
                        <ul class="cart-target large-12 columns">
                            <li class="placeholder">drag your items here</li>
                        </ul>
                    </div>
                </div>

                <ul id="cart-item-dummy"> 
                    <li style="clear:both" class="large-12 cart-item">
                        <div class="left"><img class="cart-button-goto" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/47.png"/> <span class="displayname"></span></div>
                        <div class="right">
                            <img class="cart-button-edit" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/39.png"/>
                            <img class="cart-button-delete" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/51.png"/>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div>&nbsp;</div>
    </div>
</div>

        </div>

    </body>
</html>

<?php }} ?>