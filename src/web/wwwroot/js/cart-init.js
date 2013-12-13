var cart;

$(document).ready(function() {

    cart = new Cart({}, $.extend(true, {
        callbacks: {
            afterDOMinsert_groupAll: groupAllAfterDOM,
            afterDOMinsert_group: groupAfterDOM,
            afterDOMinsert_item: itemAfterDOM
        },
        rootNode: $('#Cart')
    }, cartoptions));

    cart.sync({action: 'load'});

    release.on('change', function() {
        cart.updateContext(organism.val() + '_' + release.val());
    });


    setInterval(function() {
        console.log('sync');;
        cart.sync({
            action: 'refreshCart'
        }, {
            sync: true,
            triggerEvent: false
        });
    }, 5000); //sync over tabs if neccessary

    function groupAllAfterDOM() {
        this.accordion({
            collapsible: true,
            heightStyle: "content", 
            active: false
        });

        this.find('.exportBtn').click(function() {
            exportBtnClick.call(this, 'all');
        });

        this.find('a').click(function(event) {
            event.stopPropagation();
        });
        this.find('button').click(cartButtonClick);
    }
    

    function cartButtonClick(event) {
        if ($(this).is('.cartMenuButton')) {
            var menu = $('#' + $(this).attr('data-cartMenu'));
            menu.toggle().position({
                my: "left top",
                at: "left bottom",
                collision: "none none",
                of: this
            });
            $(document).on("click", function() {
                menu.hide();
            });
        }
        event.stopPropagation();
    }

    function exportBtnClick(cartname) {
        var ids = $.map(cart._getCartForContext()[cartname] || [], function(key, val) {
            return val;
        });
        var a = $(this);
        var service = a.attr("data-servicePath");
        a.attr("href", service + "?" + $.param({terms: ids, cartname: cartname}));
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
            heightStyle: "content",
            active: false
        });
        
        this.find('.exportBtn').click(function() {
            exportBtnClick.call(this, that.attr('data-name'));
        });

        this.find('a').click(function(event) {
            event.stopPropagation();
        });
        this.find('button').click(cartButtonClick);

        this.find('.cart-button-rename').click(function(event) {
            var dialog = $('#dialog-rename-cart-group');
            dialog.data('oldname', that.attr('data-name'));
            dialog.dialog("open");
        });

        this.find('.cart-button-copy').click(function(event) {
            var dialog = $('#dialog-copy-cart-group');
            dialog.data('data', cart.exportGroup(that.attr('data-name')));
            dialog.dialog("open");
        });
    }

    function itemAfterDOM() {
        var id = this.attr('data-id');

        //if (this.parents('.cartGroup').attr('data-name') === 'all')
            this.draggable({
                appendTo: "body",
                helper: function() {
                    return $(this).clone().addClass('beingDragged');
                }
            });

        this.find('.cart-button-rename').click(function() {
            cart._getItemDetails([id], function(data) {
                $('#item-feature_id').val(id);
                $('#item-alias').val(data[0].metadata.alias || '');
                $('#item-annotations').val(data[0].metadata.annotations || '');
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
                if (!/^[a-zA-Z0-9_]+$/.test(newname)) {
                    alert('New name contains illegal characters. Please use only letters, numbers and underscore!');
                    return false;
                }
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

    $("#dialog-copy-cart-group").dialog({
        autoOpen: false,
        height: 600,
        width: 700,
        modal: true,
        buttons: {
            Close: function() {
                $(this).dialog("close");
            }
        },
        open: function() {
            var data = $(this).data('data');
            $('#copy-json').val(JSON.stringify(data));
        }
    });

    $("#dialog-paste-cart-group").dialog({
        autoOpen: false,
        height: 600,
        width: 700,
        modal: true,
        buttons: {
            "rename cart": function() {
                var data = JSON.parse($('#paste-json').val());
                cart.importGroup(data, {metadata_conflict: $('#paste-conflict').val()});
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        },
        open: function() {
            $('#paste-json').val('');
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
                        tooltip.append($('<tr/>').append($('<td/>').text(k)).append($('<td/>').append(v || '')));
                    });
                } else {
                    //TODO secure this up
                    tooltip.append($('<tr/>').append($('<td/>').text(key)).append($('<td/>').text(val || '')));
                }
            });
            tooltip.foundation();
            return tooltip;
        }
    });
});