<?php /* Smarty version Smarty-3.1.13, created on 2013-04-12 13:20:26
         compiled from "/home/s202139/git/httpdocs/smarty/templates/cart.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11939871145151afabe85b94-60138036%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4cc783b883d8b6a00565eecd628981b51b7c27e2' => 
    array (
      0 => '/home/s202139/git/httpdocs/smarty/templates/cart.tpl',
      1 => 1365765478,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11939871145151afabe85b94-60138036',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5151afac000f42_65681396',
  'variables' => 
  array (
    'AppPath' => 0,
    'kickoff_cart' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5151afac000f42_65681396')) {function content_5151afac000f42_65681396($_smarty_tpl) {?><?php if (!is_callable('smarty_function_call_webservice')) include '/home/s202139/git/httpdocs/client/../smarty/plugins/function.call_webservice.php';
?><?php echo smarty_function_call_webservice(array('path'=>"cart/sync",'data'=>array(),'assign'=>'kickoff_cart'),$_smarty_tpl);?>


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

<?php }} ?>