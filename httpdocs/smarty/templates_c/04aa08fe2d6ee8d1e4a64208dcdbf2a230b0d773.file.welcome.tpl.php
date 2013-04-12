<?php /* Smarty version Smarty-3.1.13, created on 2013-04-12 17:27:08
         compiled from "/home/s202139/git/httpdocs/smarty/templates/welcome.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17300283651409c3b02f598-98116107%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '04aa08fe2d6ee8d1e4a64208dcdbf2a230b0d773' => 
    array (
      0 => '/home/s202139/git/httpdocs/smarty/templates/welcome.tpl',
      1 => 1365766329,
      2 => 'file',
    ),
    '5f954c49e74b64ac04f0d562c20e5168f11931f4' => 
    array (
      0 => '/home/s202139/git/httpdocs/smarty/templates/layout-with-cart.tpl',
      1 => 1365766293,
      2 => 'file',
    ),
    '1bfb3dec557c7a9258f8cf6f645e611f160e265d' => 
    array (
      0 => '/home/s202139/git/httpdocs/smarty/templates/layout.tpl',
      1 => 1365766609,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17300283651409c3b02f598-98116107',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51409c3b0f28f8_15762558',
  'variables' => 
  array (
    'AppPath' => 0,
    'ServicePath' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51409c3b0f28f8_15762558')) {function content_51409c3b0f28f8_15762558($_smarty_tpl) {?><?php if (!is_callable('smarty_function_call_webservice')) include '/home/s202139/git/httpdocs/client/../smarty/plugins/function.call_webservice.php';
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
/js/cart.js"></script>        


        <script type="text/javascript">
            $(document).ready(function() {
                $(document).foundation();
                $("#search_unigene").autocomplete({
                    position: {
                        my: "right top", at: "right bottom"
                    },
                    source: function(request, response) {
                        $.ajax({
                            url: "<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/listing/unigenes/" + request.term,
                            dataType: "json",
                            success: function(data) {
                                response(data.results);
                            }
                        });
                    },
                    minLength: 2,
                    select: function(event, ui) {
                        window.location.href = '<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/unigene-details/' + ui.item.value;
                    }
                });
                $('#search_unigene').keydown(function(event) {
                    //Enter
                    if (event.which == 13) {
                        event.preventDefault();
                        $.ajax({
                            url: "<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/listing/unigenes/" + $(this).val(),
                            dataType: "json",
                            success: function(data) {
                                if (data.results.length == 1) {
                                    window.location.href = '<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/unigene-details/' + data.results[0];
                                }
                            }
                        });
                    }
                });

            });</script>
        <style>
            .ui-tooltip-content table{
                margin-bottom: 0px;
            }
        </style>

        
<?php echo smarty_function_call_webservice(array('path'=>"cart/sync",'data'=>array(),'assign'=>'kickoff_cart'),$_smarty_tpl);?>

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
                        uniquename: $('#item-uniquename').val(),
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
                var uniquename = $(this).data('uniquename');
                var alias = $(this).data('alias');
                var annotations = $(this).data('annotations');
                $('#item-uniquename').val(uniquename);
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
            height:200,
            modal: true,
            buttons: {
                "Delete all items": function() {
                    cart.resetCart({sync: true});
                    $( this ).dialog( "close" );
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
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
                var item = cart.getItemByUniquename($(this).attr('data-uniquename'));
                var newElStr = $('#cartitem-tooltip').html();
                newElStr = newElStr.replace(/#uniquename#/g, item.uniquename);
                newElStr = newElStr.replace(/#alias#/g, item.alias);
                newElStr = newElStr.replace(/#annotations#/g, item.annotations);
                return newElStr;
            }
        });

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



    </head>
    <body>
        <div class="fixed">
            <nav class="top-bar" id="top">
                <ul class="title-area">
                    <li class="name">
                        <h1><a>Transcript Browser: dionaea muscipula</a></h1>
                    </li>
                </ul>
                <section class="top-bar-section">
                    <ul class="right">
                        <li class="divider"></li>
                        <li><a>search for unigene:</a></li>
                        <li><input type="text" id="search_unigene"/></li>
                        <li>&nbsp;</li> 
                    </ul>
                </section>
            </nav>
        </div>
        <div class="row large-12 columns" style="padding: 0px;">
                
<div class="row">
    <div class="large-9 columns">
        
<div class="row">
    <div class="large-12 columns panel">
            <h2>Welcome to the dionaea muscipula transcript browser</h2>
    </div>
</div>
<div class="row">
    <div class="large-12 columns panel">
            <p>Try searching for 1.01_comp231081_c0 or 1.01_comp214244_c0.</p>
    </div>
</div>

    </div>
    <div class="large-3 columns" >
        <div class="row large-3 columns" style="position:fixed;top:45px;bottom:0;overflow-x:hidden;overflow-y:auto;">


            <div style="display: none">
                <div id="cartitem-tooltip">
                    <table>
                        <tr><td>Uniquename</td><td>#uniquename#</td></tr>
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
                            <label for="item-uniquename">uniquename</label>
                            <input type="text" name="uniquename" id="item-uniquename" disabled="disabled" class="text ui-widget-content ui-corner-all" />
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