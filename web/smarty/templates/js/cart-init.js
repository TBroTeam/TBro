/*{#call_webservice path="cart/sync" data=[] assign='kickoff_cart'#}*/
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
        window.location = '{#$AppPath#}/graphs/all';
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

    group_all.find('.cart-button-delete').click(function(event) {
        event.stopPropagation();
        $("#dialog-delete-all").dialog('open');
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

});