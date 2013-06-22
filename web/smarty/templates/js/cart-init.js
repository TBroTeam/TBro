/*{#*call_webservice path="cart/sync" data=[] assign='kickoff_cart'*#}*/
var cart;

$(document).ready(function() {
    cart = new Cart({}, {
        callbacks: {
            afterDOMinsert_groupAll: groupAllAfterDOM,
            afterDOMinsert_group: groupAfterDOM,
            afterDOMinsert_item: itemAfterDOM
        }
    });

    cart.addGroup('test');
    cart.addItem(522151);


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
            console.log('removeItem(%s,%s)',id, $(this).parents('.cartGroup').attr('data-name'));
            cart.removeItem(id, {groupname:$(this).parents('.cartGroup').attr('data-name')});
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
                cart.resetCart({
                    sync: true
                });
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });


    /*
     
     var group_all = $("#cart-group-all");
     group_all.accordion({
     collapsible: true,
     heightStyle: "content"
     });
     group_all.find('.cart-button-execute').click(function(event) {
     event.stopPropagation();
     window.location = '{#$AppPath#}/graphs/all';
     });
     
     
     var tmpcart = {#$kickoff_cart['cart']|json_encode#};
     cart.rebuildDOM(tmpcart, true);
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
     */
});