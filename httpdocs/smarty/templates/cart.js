// In case we forget to take out console statements (and we will, because it is just too useful). IE becomes very unhappy when we forget. Let's not make IE unhappy
// taken from: http://digitalize.ca/2010/04/javascript-tip-save-me-from-console-log-errors/
try
{
    console.log('');
}
catch (err) {
    var console = {}
    console.log = console.error = console.info = console.debug = console.warn = console.trace = console.dir = console.dirxml = console.group = console.groupEnd = console.time = console.timeEnd = console.assert = console.profile = function() {
    };
}


/**
 * cart methods & data
 * @type Object
 */
var cart = {
    /**
     * *&lt;item&gt;={feature_id:&lt;string&gt;}<br/>
     * @type item[]
     */
    all: [],
    /**
     *&lt;item&gt;={feature_id:&lt;string&gt;}<br/>
     *&lt;group&gt;={name:&lt;string&gt;, items:[&lt;item&gt;&#42;]}<br/>
     * @type group[]
     */
    groups: [],
    lastSyncRequest: -1,
    /**
     * last auto-assigned group number. used by addGroup()
     * @type int
     */
    lastGroupNumber: 0,
    /**
     * @type JQuery
     */
    cart_groups: null,
    /**
     * @type JQuery
     */
    cart_group_all: null
};
$(document).ready(function() {
    cart.cart_groups = $('#cart-groups');
    cart.cart_group_all = $('#cart-group-all');
});
RegExp.quote = function(str) {
    return str.replace(/([.?*+^$[\]\\(){}|-])/g, "\\$1");
};

cart.getGroupByName = function(name) {
    var group = null;
    $.each(cart.groups, function() {
        if (this.name === name) {
            group = this;
        }
    });
    return group;
};

$.extend({
    getGroupByName: function(name) {
        return cart.cart_groups.find("[data-group='" + name + "']");
    }
});


cart.getItemByFeature_id = function(name) {
    var item = null;
    $.each(cart.all, function() {
        if (this.feature_id === name) {
            item = this;
        }
    });
    return item;
};


/**
 *&nbsp;this function syncs all cart actions to the server.
 *&nbsp;action will be mirrored on server and new dataset will be returned.
 *&nbsp;if server data differs, local data will be overwritten and DOM will be rebuilt from server data
 *&nbsp;@param {object} action action with parameters to be synced
 *&nbsp;@param {object} options used internally
 *&nbsp;@returns nothing
 *&nbsp;*/
cart.syncAction = function(action, options) {
    if (options !== undefined && options.sync === false)
        return;

    var thisSyncRequest = new Date().getTime();
    cart.lastSyncRequest = thisSyncRequest;
    $.ajax({
        url: '{#$ServicePath#}/cart/sync',
        type: 'post',
        dataType: "json",
        data: {
            action: action,
            syncRequestTime: cart.lastSyncRequest
        },
        success: function(data) {
            if (thisSyncRequest < cart.lastSyncRequest) {
                console.info('there has been a newer request, skipping ', thisSyncRequest, 'in favor of ', cart.lastSyncRequest);
                return;
            }
            // if we are receiving an answer that is outdated (a new request has already been 
            // sent and answer has been received, maybe on another tab), skip writing back
            if (data.syncTime > $.webStorage.local().getItem('syncTime')) {
                console.info('saving ', data.syncTime, 'to webStorage');

                $.webStorage.local().setItem('syncTime', data.syncTime);
                $.webStorage.local().setItem('syncedCart', data.cart);
            }


            //wait half a second for all the actions to finish, or check calls too often
            setTimeout(function() {
                //if this is still the last request, compare actual cart to webstorage (e.g. server) cart
                if (data.syncTime === $.webStorage.local().getItem('syncTime')) {
                    console.info('checking', data.syncTime);
                    var sessionCart = $.webStorage.local().getItem('syncedCart');
                    if (!cart.compareCarts(cart, sessionCart)) {
                        console.log('carts not identical, rebuilding DOM; current cart: ', cart, 'synced cart:', sessionCart);
                        cart.rebuildDOM(sessionCart, false);
                    }
                }
            }, 500);
        }
    });
};

cart.checkRegularly = function() {
    var storageSyncTime = $.webStorage.local().getItem('syncTime');
    console.info('performing regular cart check, lastSyncRequest is', cart.lastSyncRequest, 'storageSyncTime is', storageSyncTime);
    if (cart.lastSyncRequest < storageSyncTime) {
        var sessionCart = $.webStorage.local().getItem('syncedCart');
        if (!cart.compareCarts(cart, sessionCart)) {
            console.log('carts not identical, rebuilding DOM; current cart: ', cart, 'synced cart:', sessionCart);
            cart.rebuildDOM(sessionCart, false);
        } else {
            console.info('local and remote cart identical, everything okay');
        }
        cart.lastSyncRequest = storageSyncTime;
    }
};

cart.syncFromServer = function() {
    cart.syncAction({
        action: 'syncFromServer'
    });
};

cart.resetCart = function(options) {
    cart.all = [];
    cart.groups = [];

    //sync
    cart.syncAction({
        action: 'resetCart'
    }, options);

    //DOM manipulation
    cart.cart_group_all.find('ul li').remove();
    cart.cart_groups.find('div').remove();
};

cart.compareCarts = function(first, second) {
    try {
        if (first.all.length !== second.all.length) {
            console.error(first.all, ' group "All" count differs: ', second.all);
            throw "";
        }
        $.each(first.all, function() {
            if (!$.inArray(this, second.all)) {
                console.error(this, 'not found in all: ', second.all);
                throw "";
            }
        });

        if (first.groups.length !== second.groups.length) {
            console.error(first.groups, first.groups.length, ' group count differs: ', second.groups, second.groups.length);
            throw "";
        }

        $.each(first.groups, function() {
            //find matching groups
            var group_a = this;
            var group_b = null;
            $.each(second.groups, function() {
                if (this.name === group_a.name) {
                    group_b = this;
                    return false; //jquery break
                }
            });
            if (group_b === null) {
                console.error("could not find a counterpart group for ", group_a, "in", second.groups);
                throw "";
            }

            if (Object.keys(group_a.items).length !== Object.keys(group_b.items).length){
                console.error("group item counts differ: ", group_a.items, group_b.items);
                throw "";
            }

            //check groups for matching items. only compare "feature_id" for match
            $.each(group_a.items, function() {
                var origin = this;
                var match = null;
                $.each(group_b.items, function() {
                    if (origin.feature_id === this.feature_id) {
                        match = this;
                        return false; //jquery break
                    }
                });
                if (match === null) {
                    console.error("could not find a counterpart item for ", origin, "in", group_b);
                    throw "";
                }
            });

        });


    } catch (e) {
        console.error(e);
        return false;
    }
    return true;
};


cart.rebuildDOM = function(newCart, saveToWebStorage) {
    if (saveToWebStorage) {
        $.webStorage.local().setItem('syncTime', new Date().getTime());
        $.webStorage.local().setItem('syncedCart', newCart);
    }

    cart.resetCart({
        sync: false
    });
    $.each(newCart.all, function() {
        cart.addItemToAll(this, {
            sync: false
        });
    });
    $.each(newCart.groups, function() {
        var groupname = this.name;
        cart.addGroup({
            name: groupname,
            sync: false
        });
        $.each(this.items, function() {
            cart.addItemToGroup(this, groupname, {
                sync: false
            });
        });
    });

};

/**
 *&nbsp;adds a new group to the cart
 *&nbsp;@param {object} options used internally
 *&nbsp;@returns new group name
 */
cart.addGroup = function(options) {
    do {
        groupname = "group " + (++cart.lastGroupNumber);
    }
    while (cart.getGroupByName(groupname) !== null);

    if (options !== undefined && options.name !== undefined)
        groupname = options.name;

    var group = {
        name: groupname,
        items: []
    };
    cart.groups.push(group);

    //sync
    cart.syncAction({
        action: 'addGroup',
        name: groupname
    }, options);

    // DOM manupulation
    var newElStr = $('#cart-group-dummy').html();
    newElStr = newElStr.replace(/#groupname#/g, groupname);
    newEl = $('<div/>').html(newElStr).children();

    newEl.find('.cart-target').droppable({
        items: "li:not(.placeholder)",
        accept: ":not(.ui-sortable-helper)",
        drop: function(event, ui) {
            var item = {
                feature_id: ui.draggable.attr('data-feature_id')
            };
            //call addObjectToGroup, but tell it not to manipulate the DOM as that's already happened
            cart.addItemToGroup(item, $(this).parent().attr('data-group'));
        }
    });
    newEl.accordion({
        collapsible: true,
        heightStyle: "content"
    });
    newEl.find('.cart-button-delete').click(function(event) {
        event.stopPropagation();
        var group = $(this).parents('.cart-group').first();
        cart.removeGroup(group.attr('data-group'));
    });
    newEl.find('.cart-button-rename').click(function(event) {
        event.stopPropagation();
        var group = $(this).parents('.cart-group').first();
        var dialog = $('#dialog-rename-cart-group');
        dialog.data('oldname', group.attr('data-group'));
        dialog.dialog("open");
    });
    newEl.find('.cart-button-execute').click(function(event) {
        event.stopPropagation();
        window.location = '{#$AppPath#}/graphs/'+$(this).parents('.cart-group').first().attr('data-group');
    });

    newEl.appendTo(cart.cart_groups).hide(0).fadeIn(500);
    return groupname;
};


cart.cleanUpGroup = function(newItem, group) {
    //DOM cleanup
    //remove placeholder
    $(group).find(".placeholder").hide(0);
    //do not allow duplicate items
    var copies = $(group).find("[data-feature_id='" + newItem.feature_id + "']");
    if (copies.length > 1)
        copies[1].remove();
};

cart.renameGroup = function(oldname, newname, options) {
    if (newname === oldname)
        return "no rename neccessary. old name matches new name";
    if (newname === "all" || !newname.match({#$regexCartName#})){
        return "this name is not valid"
    };
    var _group;
    if (!(cart.getGroupByName(newname) === null)) {
        var msg = "can't rename" + oldname + " to " + newname + ": group with that name already exists.";
        console.error(msg);
        return msg;
    }
    _group = cart.getGroupByName(oldname);
    if (_group === null) {
        var msg = "can't rename" + oldname + " to " + newname + ": group " + oldname + "not found!";
        console.error(msg);
        return msg;
    }
    _group.name = newname;

    // sync
    cart.syncAction({
        action: 'renameGroup',
        oldname: oldname,
        newname: newname
    }, options);

    // DOM manupulation
    var group = $.getGroupByName(oldname);
    group.attr('data-group', newname);
    var header = group.find('.ui-accordion-header');
    var re = new RegExp(RegExp.quote(oldname), "g");
    header.html(header.html().replace(re, newname));
};

cart.removeGroup = function(groupname, options) {
    for (var i = 0; i < cart.groups.length; i++) {
        if (cart.groups[i].name === groupname) {
            cart.groups.splice(i, 1);
            i--;
        }
    }

    // sync
    cart.syncAction({
        action: 'removeGroup',
        groupname: groupname
    }, options);

    // DOM manupulation
    var group = $.getGroupByName(groupname);
    group.remove();
};

cart.addItemToAll = function(item, options) {
    if (cart.getItemByFeature_id(item.feature_id) !== null) {
        console.error('can\'t add item to "All":', item, 'already exists');
        return false;
    }
    cart.all.unshift(item);

    //sync
    cart.syncAction({
        action: 'addItemToAll',
        item: item
    }, options);

    // DOM manupulation
    newEl = cart.buildCartItemDOM(item);
    newEl.find('.cart-button-delete').click(function() {
        cart.removeItemFromAll({
            feature_id: item.feature_id
        });
    });
    newEl.appendTo(cart.cart_group_all.find('ul'));
    cart.refresh_cart_group_all();
};

cart.addItemToGroup = function(item, groupname, options) {
    if (cart.getItemByFeature_id(item.feature_id) === null) {
        console.error('can\'t add item to "' + groupname + '":', item, 'is not in "All"');
        return false;
    }
    var _group = cart.getGroupByName(groupname);
    if (_group === null) {
        console.error('can\'t add item to "' + groupname + '": group doesn\'t exist!');
        return false;
    }
    var groupContainsItem = false;
    $.each(_group.items, function() {
        if (this.feature_id === item.feature_id)
            groupContainsItem = true;
    });
    if (groupContainsItem) {
        console.error('can\'t add item to "' + groupname + '": group already contains item!');
        return false;
    }
    _group.items.push(item);

    //sync
    cart.syncAction({
        action: 'addItemToGroup',
        item: item,
        groupname: groupname
    }, options);

    // DOM manupulation
    if (options !== undefined && options.modifyDOM === false)
        return true;

    var group = $.getGroupByName(groupname).find('ul');
    newEl = cart.buildCartItemDOM(cart.getItemByFeature_id(item.feature_id));
    newEl.find('.cart-button-delete').click(function() {
        var group = $(this).parents('.cart-group').first();
        cart.removeItemFromGroup({
            feature_id: item.feature_id
        }, group.attr('data-group'));
    });
    newEl.appendTo(group).hide(0).fadeIn(500);
    cart.cleanUpGroup(item, group);
};

cart.removeItemFromAll = function(item, options) {
    $.each(cart.groups, function() {
        var _group = this;
        var groupContainsItem = false;
        $.each(_group.items, function() {
            _item = this;
            if (_item.feature_id === item.feature_id)
                groupContainsItem = true;
        });
        if (groupContainsItem) {
            cart.removeItemFromGroup(item, _group.name);
        }
    });

    for (var i = 0; i < cart.all.length; i++) {
        if (cart.all[i].feature_id === item.feature_id) {
            cart.all.splice(i, 1);
            i--;
        }
    }

    //sync
    cart.syncAction({
        action: 'removeItemFromAll',
        item: item
    }, options);

    //DOM manipulation
    cart.cart_group_all.find('[data-feature_id="' + item.feature_id + '"]').remove();
};

cart.removeItemFromGroup = function(item, groupname, options) {
    var _group = cart.getGroupByName(groupname);
    if (_group === null) {
        console.error('group ', groupname, ' not found');
        return false;
    }

    for (var i = 0; i < _group.items.length; i++) {
        if (_group.items[i].feature_id === item.feature_id) {
            _group.items.splice(i, 1);
            i--;
        }
    }

    //sync
    cart.syncAction({
        action: 'removeItemFromGroup',
        item: item,
        groupname: groupname
    }, options);

    //DOM manipulation
    var group = $.getGroupByName(groupname);
    group.find('[data-feature_id="' + item.feature_id + '"]').remove();
    if (group.find('li:visible').length === 0) {
        group.find('.placeholder').show(0);
    }
};

cart.refresh_cart_group_all = function() {
    cart.cart_group_all.find('li').draggable({
        appendTo: "body",
        helper: function() {
            return $(this).clone().addClass('beingDragged');
        }/*,
         snap: ".cart-target",
         snapMode: 'inner'*/
    });
};

cart.buildCartItemDOM = function(item) {
    var newElStr = $('#cart-item-dummy').html();
    newEl = $('<div/>').html(newElStr).children();
    newEl.attr('data-feature_id', item.feature_id);
    newEl.find('.displayname').html((item.alias !== undefined && item.alias !== '') ? item.alias : item.feature_id);
    newEl.data('metadata', item);
    newEl.find('.cart-button-goto').click(function() {
        window.location = '{#$AppPath#}/isoform-details/byId/' + item.feature_id;
    });
    newEl.find('.cart-button-edit').click(function() {
        cart.dialog_edit_open(item.feature_id);
    });
    return newEl;
};

cart.dialog_edit_open = function(feature_id) {
    var item = cart.getItemByFeature_id(feature_id);
    var dialog = $('#dialog-edit-cart-item');
    dialog.data('feature_id', item.feature_id);
    dialog.data('alias', item.alias);
    dialog.data('annotations', item.annotations);
    dialog.dialog("open");
};

cart.dialog_edit_save = function(item, options) {
    var feature_id = item.feature_id;
    cartitem = cart.getItemByFeature_id(feature_id);
    if (cartitem === null)
        return "Error saving cart: item not found in cart 'All'";
    if (cartitem.alias !== item.alias) {
        $("[data-feature_id='" + item.feature_id + "']").find('.displayname').html(item.alias);
    }
    $.each(item, function(key, value) {
        if (key !== 'feature_id')
            cartitem[key] = value;
    });

    cart.syncAction({
        action: 'edit_item',
        name: feature_id,
        values: item
    }, options);
}


$(document).ready(function() {
    cart.refresh_cart_group_all();
    $('#cart-add-group').click(cart.addGroup);
});