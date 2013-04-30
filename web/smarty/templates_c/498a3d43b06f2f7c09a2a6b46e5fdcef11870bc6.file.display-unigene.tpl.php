<?php /* Smarty version Smarty-3.1.13, created on 2013-04-30 13:42:16
         compiled from "/home/s202139/git/web/smarty/templates/display-unigene.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1867625120517fae18398ed4-63990888%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '498a3d43b06f2f7c09a2a6b46e5fdcef11870bc6' => 
    array (
      0 => '/home/s202139/git/web/smarty/templates/display-unigene.tpl',
      1 => 1366030847,
      2 => 'file',
    ),
    'b81c7ac9ab8f4ae5308a3d38c630ba7953eeab27' => 
    array (
      0 => '/home/s202139/git/web/smarty/templates/layout-with-cart.tpl',
      1 => 1366022477,
      2 => 'file',
    ),
    '1ed616596375c685fddd12b6d0e8d3a9d7835633' => 
    array (
      0 => '/home/s202139/git/web/smarty/templates/layout.tpl',
      1 => 1366116368,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1867625120517fae18398ed4-63990888',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'AppPath' => 0,
    'ServicePath' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_517fae18644041_27871905',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_517fae18644041_27871905')) {function content_517fae18644041_27871905($_smarty_tpl) {?><?php if (!is_callable('smarty_function_call_webservice')) include '/home/s202139/git/web/httpdocs/../smarty/plugins/function.call_webservice.php';
?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width" />
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
            .top-bar-section li div.has-select{
                padding: 0 15px;
                line-height: 45px;
                background: #111111; 
                display:block;
            }
        </style>

        
<?php echo smarty_function_call_webservice(array('path'=>"cart/sync",'data'=>array(),'assign'=>'kickoff_cart'),$_smarty_tpl);?>

<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/cart.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $("#dialog-rename-cart-group").dialog({
            autoOpen: false,
            height: 300,
            width: 350,
            modal: true,
            buttons: {
                "rename cart": function() {
                    var oldname = $(this).data('oldname');
                    var newname = $('#cartname').val();
                    var retval = cart.renameGroup(oldname, newname);
                    if (retval != null)
                        alert(retval);
                    $(this).dialog("close");
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            },
            open: function() {
                var oldname = $(this).data('oldname');
                $('#cartname').val(oldname);
            }
        });


        $("#dialog-edit-cart-item").dialog({
            autoOpen: false,
            height: 500,
            width: 500,
            modal: true,
            buttons: {
                "save changes": function() {
                    cart.dialog_edit_save({
                        feature_id: $('#item-feature_id').val(),
                        alias: $('#item-alias').val(),
                        annotations: $('#item-annotations').val()
                    });

                    $(this).dialog("close");
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            },
            open: function() {
                var feature_id = $(this).data('feature_id');
                var alias = $(this).data('alias');
                var annotations = $(this).data('annotations');
                $('#item-feature_id').val(feature_id);
                $('#item-alias').val(alias);
                $('#item-annotations').val(annotations);
            }
        });

        var group_all = $("#cart-group-all");
        group_all.accordion({
            collapsible: true,
            heightStyle: "content"
        });
        group_all.find('.cart-button-execute').click(function(event) {
            event.stopPropagation();
            window.location = '<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/graphs/all';
        });
        $("#dialog-delete-all").dialog({
            resizable: false,
            autoOpen: false,
            height: 200,
            modal: true,
            buttons: {
                "Delete all items": function() {
                    cart.resetCart({sync: true});
                    $(this).dialog("close");
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            }
        });

        group_all.find('.cart-button-delete').click(function(event) {
            event.stopPropagation();
            $("#dialog-delete-all").dialog('open');
        });


        cart.rebuildDOM(<?php echo json_encode($_smarty_tpl->tpl_vars['kickoff_cart']->value['cart']);?>
, true);
                setInterval(cart.checkRegularly, 5000); //sync over tabs if neccessary

        $('#cart').tooltip({
            items: ".cart-item",
            open: function(event, ui) {
                ui.tooltip.css("max-width", "500px");
            },
            content: function() {
                var element = $(this);
                var tooltip = $("<table />");
                $.each(element.data('metadata'),function(key, val){
                    $("<tr><td>"+key+"</td><td>"+(val!==null?val:'')+"</td></tr>").appendTo(tooltip);
                });
                tooltip.foundation();
                return tooltip;
            }
        });


        /*$('#cart').tooltip({
            items: ".cart-item",
            open: function(event, ui) {
                ui.tooltip.css("max-width", "500px");
            },
            content: function() {
                var item = cart.getItemByFeature_id($(this).attr('data-feature_id'));
                var newElStr = $('#cartitem-tooltip').html();
                newElStr = newElStr.replace(/#feature_id#/g, item.feature_id);
                newElStr = newElStr.replace(/#alias#/g, item.alias);
                newElStr = newElStr.replace(/#annotations#/g, item.annotations);
                return newElStr;
            }
        });*/

    });
</script>
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

<?php echo smarty_function_call_webservice(array('path'=>"details/unigene",'data'=>array("query1"=>$_smarty_tpl->tpl_vars['unigene_feature_id']->value),'assign'=>'data'),$_smarty_tpl);?>




    </head>
    <body>
        <div class="fixed">
            <nav class="top-bar" id="top">
                <ul class="title-area">
                    <li class="name">
                        <h1><a href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
">Transcript Browser</a></h1>
                    </li>
                </ul>
                <section class="top-bar-section">
                    <ul class="left"></ul>
                    <ul class="right">
                        <li><a href='<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/multisearch'>multisearch</a></li>
                        <li class="divider"></li>
                        <li><a>quicksearch:</a></li>
                        <li><div class="has-select"><select id="select_organism" style="display:inline"></select></div></li>
                        <li><div class="has-select"><select id="select_dataset"></select></div></li>
                        <li class="has-form"><input type="search" id="search_unigene"/></li>
                    </ul>
                </section>
            </nav>
        </div>
        <div class="row large-12 columns" style="padding: 0px;">
            
<div class="row">
    <div class="large-9 columns">
        

<div class="row">
    <div class="large-12 columns panel">
        <div class="row">
            <div class="large-12 columns">
                <h1 class="left"><?php echo $_smarty_tpl->tpl_vars['data']->value['unigene']['uniquename'];?>
</h1>
                <div class="right"><span class="button" onclick="$.ajax({url:'<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/details/cartitem/<?php echo $_smarty_tpl->tpl_vars['data']->value['unigene']['feature_id'];?>
', success: cart.addItemToAll});"> add to cart -> </span></div>
            </div>
        </div>
        <h5>last modified: <?php echo $_smarty_tpl->tpl_vars['data']->value['unigene']['timelastmodified'];?>
</h5>
    </div>
</div>

<div class="row">        
    <div class="large-12 columns panel">
        <p>known isoforms:</p>
        <table>
            <?php  $_smarty_tpl->tpl_vars['isoform'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['isoform']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['unigene']['isoforms']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['isoform']->key => $_smarty_tpl->tpl_vars['isoform']->value){
$_smarty_tpl->tpl_vars['isoform']->_loop = true;
?>
                <tr>
                    <td>
                        <a href='<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/isoform-details/byId/<?php echo $_smarty_tpl->tpl_vars['isoform']->value['feature_id'];?>
'><?php echo $_smarty_tpl->tpl_vars['isoform']->value['uniquename'];?>
</a>
                    </td><td>
                        <div class="right"><span class="small button" onclick="$.ajax({url:'<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/details/cartitem/<?php echo $_smarty_tpl->tpl_vars['isoform']->value['feature_id'];?>
', success: cart.addItemToAll});"> add to cart -> </span></div>
                    </td>
                </tr>
            <?php } ?>
        </table>
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