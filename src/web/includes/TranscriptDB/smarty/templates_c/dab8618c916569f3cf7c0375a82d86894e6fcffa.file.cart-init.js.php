<?php /* Smarty version Smarty-3.1.13, created on 2013-06-27 17:42:58
         compiled from "C:\Users\mail_000\Dropbox\uni\bio\s202139\web\smarty\templates\js\cart-init.js" */ ?>
<?php /*%%SmartyHeaderCode:2148251c4dd01076f61-77932682%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dab8618c916569f3cf7c0375a82d86894e6fcffa' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\js\\cart-init.js',
      1 => 1372331522,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2148251c4dd01076f61-77932682',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51c4dd010d3240_10268085',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51c4dd010d3240_10268085')) {function content_51c4dd010d3240_10268085($_smarty_tpl) {?>/**/
var cart;

$(document).ready(function() {
    cart = new Cart({}, {
        callbacks: {
            afterDOMinsert_groupAll: groupAllAfterDOM,
            afterDOMinsert_group: groupAfterDOM,
            afterDOMinsert_item: itemAfterDOM
        },
        rootNode: $('#Cart')
    });

    cart.sync({action: 'load'});

    release.on('change', function() {
        cart.updateContext(organism.val() + '_' + release.val());
    });

    function groupAllAfterDOM() {
        this.accordion({
            collapsible: true,
            heightStyle: "content"
        });

        this.find('a').click(function(event) {
            event.stopPropagation();
        });
    }

    function groupAfterDOM() {
        var that = this;

        this.find('.elements').droppable({
            items: "li:not(.placeholder)",
            accept: ":not(.ui-sortable-helper)",
            drop: function(event, ui) {
                cart.addItem(ui.draggable.attr('data-id'), {
                    groupname: that.attr('data-name'),
                    addToDOM: true
                });
            }
        });
        this.accordion({
            collapsible: true,
            heightStyle: "content"
        });

        this.find('a').click(function(event) {
            event.stopPropagation();
        });

        this.find('.cart-button-rename').click(function(event) {
            var dialog = $('#dialog-rename-cart-group');
            dialog.data('oldname', that.attr('data-name'));
            dialog.dialog("open");
        });
    }

    function itemAfterDOM() {
        var id = this.attr('data-id');

        if (this.parents('.cartGroup').attr('data-name') === 'all')
            this.draggable({
                appendTo: "body",
                helper: function() {
                    return $(this).clone().addClass('beingDragged');
                }
            });

        this.find('.cart-button-rename').click(function() {
            cart._getItemDetails(id, function(data) {
                $('#item-feature_id').val(id);
                $('#item-alias').val(data.metadata.alias || '');
                $('#item-annotations').val(data.metadata.annotations || '');
                $("#dialog-edit-cart-item").dialog("open");
            });

        });

        this.find('.cart-button-delete').click(function(event) {
            console.log('removeItem(%s,%s)', id, $(this).parents('.cartGroup').attr('data-name'));
            cart.removeItem(id, {groupname: $(this).parents('.cartGroup').attr('data-name')});
        });
    }


    $("#dialog-rename-cart-group").dialog({
        autoOpen: false,
        height: 300,
        width: 350,
        modal: true,
        buttons: {
            "rename cart": function() {
                var oldname = $(this).data('oldname');
                var newname = $('#cartname').val();
                try {
                    cart.renameGroup(oldname, newname);
                } catch (e) {
                    alert(e);
                }
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
                cart.updateItem($('#item-feature_id').val(), {alias: $('#item-alias').val(), annotations: $('#item-annotations').val()});
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        },
        open: function(event, ui) {
        }
    });

    $("#dialog-delete-all").dialog({
        resizable: false,
        autoOpen: false,
        height: 200,
        modal: true,
        buttons: {
            "Delete all items": function() {
                cart.clear({
                    sync: true
                });
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });


    $('#cart').tooltip({
        items: ".cartItem",
        open: function(event, ui) {
            ui.tooltip.css("max-width", "500px");
        },
        content: function() {
            var element = $(this);
            itemdata = cart.cartitems[element.attr('data-id')];
            var tooltip = $("<table />");
            $.each(itemdata, function(key, val) {
                if (_.isObject(val)) {
                    $.each(val, function(k, v) {
                        tooltip.append($('<tr/>').append($('<td/>').text(k)).append($('<td/>').append(v||'')));
                    });
                } else {
                    //TODO secure this up
                    tooltip.append($('<tr/>').append($('<td/>').text(key)).append($('<td/>').text(val||'')));
                }
            });
            tooltip.foundation();
            return tooltip;
        }
    });
});<?php }} ?>