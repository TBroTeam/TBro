var cart;

$(document).ready(function() {

    cart = new Cart({}, $.extend(true, {
        callbacks: {
            afterDOMinsert_group: groupAfterDOM,
            afterDOMinsert_item: itemAfterDOM
        },
        rootNode: $('#Cart')
    }, cartoptions));

    cart.sync({action: 'load'});

    release.on('change', function() {
        cart.updateContext(organism.val() + '_' + release.val());
    });
    cart.updateContext(organism.val() + '_' + release.val());


    setInterval(function() {
        cart.sync({
            action: 'refreshCart'
        }, {
            sync: true,
            triggerEvent: false,
            auto: true
        });
    }, 5000); //sync over tabs if neccessary

    function cartButtonClick(event) {
        if ($(this).is('.cartMenuButton')) {
            var menu = $('#' + $(this).attr('data-cartMenu'));
            if (menu.is(':visible')) {
                menu.hide();
            }
            else {
                menu.show().position({
                    my: "right top",
                    at: "right bottom",
                    collision: "none none",
                    of: this
                });
            }
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
                if (typeof ui.draggable.attr('data-id') !== "undefined") {
                    cart.addItem(ui.draggable.attr('data-id').split(","), {
                        groupname: that.attr('data-name'),
                        addToDOM: true
                    });
                }
            }
        });
        this.find('.cartgroup').droppable({
            accept: ":not(.ui-sortable-helper)",
            drop: function(event, ui) {
                if (typeof ui.draggable.attr('data-id') !== "undefined") {
                    cart.addItem(ui.draggable.attr('data-id').split(","), {
                        groupname: that.attr('data-name'),
                        addToDOM: true
                    });
                }
            }
        });
        this.find('.cartGroup').accordion({
            collapsible: true,
            heightStyle: "content",
            active: false
        });

        this.find('.exportBtn').click(function(event) {
            event.preventDefault();
            exportBtnClick.call(this, that.attr('data-name'));
        });

        this.find('a').click(function(event) {
            event.stopPropagation();
        });
        this.find('button').click(cartButtonClick);

        this.find('.cart-button-rename').click(function(event) {
            event.preventDefault();
            var dialog = $('#dialog-rename-cart-group');
            dialog.data('oldname', that.attr('data-name'));
            dialog.dialog("open");
        });

        this.find('.cart-button-copy').click(function(event) {
            event.preventDefault();
            var dialog = $('#dialog-copy-cart-group');
            dialog.data('data', cart.exportGroup(that.attr('data-name')));
            dialog.dialog("open");
        });

        this.find('.cart-button-remove').click(function(event) {
            event.preventDefault();
            var dialog = $('#dialog-delete-cart');
            dialog.data('groupname', that.attr('data-name'));
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

        this.find('.cart-button-rename').click(function(event) {
            event.preventDefault();
            cart._getItemDetails([id], function(data) {
                if (Object.keys(cart._getMetadataForContext()).length >= cartlimits.max_annotations_per_context) {
                    if (Object.keys(data[0].metadata).length === 0) {
                        $('#TooManyAnnotationsDialog').foundation('reveal', 'open');
                        return;
                    }
                }
                $("#dialog-edit-cart-item").data('id', id);
                $("#dialog-edit-cart-item").data('name', cart.cartitems[id]['name']);
                $("#dialog-edit-cart-item").data('description', cart.cartitems[id]['description']);
                $('#item-alias').val(data[0].metadata.alias || '');
                $('#item-annotations').val(data[0].metadata.annotations || '');
                $("#dialog-edit-cart-item").dialog("open");
            });

        });

        this.find('.cart-button-delete').click(function(event) {
            event.preventDefault();
            var dialog = $('#dialog-delete-item');
            dialog.data('id', id);
            dialog.data('groupname', $(this).parents('.cartGroup').attr('data-name'));
            dialog.dialog("open");
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
            $("#dialog-rename-cart-group").keypress(function(e) {
                if (e.keyCode === $.ui.keyCode.ENTER) {
                    e.preventDefault();
                    console.log($(this).parent().find("button:contains('rename cart')").text());
                    $(this).parent().find("button:contains('rename cart')").trigger("click");
                }
            });
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

    $("#dialog-copy-all-carts").dialog({
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
            $('#copy-all-json').val(JSON.stringify(data));
        }
    });

    $("#dialog-paste-cart-group").dialog({
        autoOpen: false,
        height: 680,
        width: 700,
        modal: true,
        buttons: {
            "Import": function() {
                var data = JSON.parse($('#paste-json').val());
                cart.importGroups(data, {metadata_conflict: $('#metadata-conflict').val(), group_conflict: $('#group-conflict').val()});
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

    $("#dialog-edit-cart-notes").dialog({
        autoOpen: false,
        height: 400,
        width: 500,
        modal: true,
        buttons: {
            "Save Changes": function() {
                cart.updateGroup($('#cart-name').val(), $('#cart-notes').val());
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        },
        open: function(event, ui) {
            $('#cart-name').val($(this).data('cart-name'));
            $('#cart-notes').val($(this).data('cart-notes'));
            $('#cart-notes').focus();
        }
    });

    $("#dialog-edit-cart-item").dialog({
        autoOpen: false,
        height: 500,
        width: 500,
        modal: true,
        buttons: {
            "Save Changes": function() {
                cart.updateItem($(this).data('id'), {alias: $('#item-alias').val(), annotations: $('#item-annotations').val()});
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        },
        open: function(event, ui) {
            $('#item-name').val($(this).data('name'));
            $('#item-db-description').val($(this).data('description'));
            $('#item-alias').focus();
        }
    });

    $("#dialog-delete-all").dialog({
        resizable: false,
        autoOpen: false,
        height: 200,
        modal: true,
        dialogClass: "warningDialogClass",
        buttons: {
            "Delete": function() {
                cart.clearAll({
                    sync: true
                });
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });

    $("#dialog-delete-all-context").dialog({
        resizable: false,
        autoOpen: false,
        height: 200,
        modal: true,
        dialogClass: "warningDialogClass",
        buttons: {
            "Delete": function() {
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

    $("#dialog-delete-annotations").dialog({
        resizable: false,
        autoOpen: false,
        height: 200,
        modal: true,
        dialogClass: "warningDialogClass",
        buttons: {
            "Delete": function() {
                cart.clearAllAnnotations({
                    sync: true
                });
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });

    $("#dialog-delete-annotations-context").dialog({
        resizable: false,
        autoOpen: false,
        height: 200,
        modal: true,
        dialogClass: "warningDialogClass",
        buttons: {
            "Delete": function() {
                cart.clearAnnotations({
                    sync: true
                });
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });

    $("#dialog-delete-item").dialog({
        resizable: false,
        autoOpen: false,
        height: 200,
        modal: true,
        dialogClass: "warningDialogClass",
        buttons: {
            "Delete item": function() {
                cart.removeItem($(this).data('id'), {groupname: $(this).data('groupname')});
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });

    $("#dialog-delete-cart").dialog({
        resizable: false,
        autoOpen: false,
        height: 200,
        modal: true,
        dialogClass: "warningDialogClass",
        buttons: {
            "Delete cart": function() {
                cart.removeGroup($(this).data('groupname'));
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });

    $("#dialog-delete-item-annotation").dialog({
        resizable: false,
        autoOpen: false,
        height: 200,
        modal: true,
        dialogClass: "warningDialogClass",
        buttons: {
            "Delete annotation": function() {
                cart.updateItem($(this).data('id'), {alias: "", annotations: ""});
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
            tooltip.append($('<tr/>').append($('<td/>').text("Name")).append($('<td/>').append(itemdata['name'] || '')));
            tooltip.append($('<tr/>').append($('<td/>').text("Type")).append($('<td/>').append(itemdata['type'] || '')));
            // tooltip.append($('<tr/>').append($('<td/>').text("Release")).append($('<td/>').append(itemdata['dataset'] || '')));
            tooltip.append($('<tr/>').append($('<td/>').text("DB Alias")).append($('<td/>').append(itemdata['alias'] || '')));
            tooltip.append($('<tr/>').append($('<td/>').text("DB Description")).append($('<td/>').append(itemdata['description'] || '')));
            if (typeof itemdata['metadata']['alias'] !== 'undefined' || typeof itemdata['metadata']['descriptions'] !== 'undefined') {
                tooltip.append($('<tr/>').append($('<td/>').text("User Alias")).append($('<td/>').append(itemdata['metadata']['alias'] || '')));
                tooltip.append($('<tr/>').append($('<td/>').text("User Description")).append($('<td/>').append(itemdata['metadata']['annotations'] || '')));
            }
            tooltip.foundation();
            return tooltip;
        }
    });

    $("#dialog-import-finished").dialog({
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
            //var data = $(this).data('data');
        }
    });

    $('#Cart').sortable({
        helper: 'clone',
        axis: "y",
        cursorAt: {top: 30, left: 5},
        forcePlaceholderSize: true,
        items: "> .sortable",
        tolerance: "pointer",
        placeholder: "sortable-placeholder",
        handle: ".handle",
        distance: 5,
        delay: 200,
        start: function(e, ui) {
            ui.placeholder.height(112);
        },
        stop: function(e, ui) {
            cart.setCartOrder($("#Cart").sortable("toArray", {attribute: "data-name"}));
        }
    });
});