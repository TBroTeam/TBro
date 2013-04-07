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
     * *&lt;item&gt;={uniquename:&lt;string&gt;}<br/>
     * @type item[]
     */
    all: [],
    /**
     *&lt;item&gt;={uniquename:&lt;string&gt;}<br/>
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
     *&lt;div id="cart-groups"&gt;<br/>
     *&emsp;&lt;div class='cart-group' data-group="#groupname#"&gt;<br/>
     *&emsp;&emsp;&lt;div class="groupname"&gt;#groupname#&lt;/div&gt;<br/>
     *&emsp;&emsp;&emsp;&lt;ul class="cart-target"&gt;<br/>
     *&emsp;&emsp;&emsp;&emsp;&lt;li class="placeholder"&gt;drag your items here&lt;/li&gt;<br/>
     *&emsp;&emsp;&emsp;&lt;/ul&gt;<br/>
     *&emsp;&emsp;&lt;/div&gt;<br/>
     *&emsp;&lt;/div&gt;<br/>
     *&lt;/div&gt;<br/>
     * @type JQuery
     */
    cart_groups: null,
    /**
     *&lt;div id="cart-group-all" class='ui_accordion ui_collapsible'&gt;<br/>
     *&emsp;&lt;div&gt;all&lt;div class="right"&gt;&lt;img src="/img/mimiGlyphs/23.png"/>&lt;/div&gt;&lt;/div&gt;<br/>
     *&emsp;&lt;ul&gt;<br/>
     *&emsp;*&emsp;&lt;li data-uniquename="#uniquename#"&gt;#uniquename#&lt;/li&gt;<br/>
     *&emsp;&lt;/ul&gt;<br/>
     *&lt;/div&gt;<br/>
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


cart.getItemByUniquename = function(name) {
    var item = null;
    $.each(cart.all, function() {
        if (this.uniquename === name) {
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
    console.log(action);

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
                console.log('there has been a newer request, skipping ', thisSyncRequest, 'in favor of ', cart.lastSyncRequest);
                return;
            }
            // if we are receiving an answer that is outdated (a new request has already been 
            // sent and answer has been received, maybe on another tab), skip writing back
            if (data.syncTime > $.webStorage.local().getItem('syncTime')) {
                console.log('saving ', data.syncTime, 'to webStorage');

                $.webStorage.local().setItem('syncTime', data.syncTime);
                $.webStorage.local().setItem('syncedCart', data.cart);
            }


            //wait half a second for all the actions to finish, or check calls too often
            setTimeout(function() {
                //if this is still the last request, compare actual cart to webstorage (e.g. server) cart
                if (data.syncTime === $.webStorage.local().getItem('syncTime')) {
                    console.log('checking', data.syncTime);
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
    console.log('performing regular cart check, lastSyncRequest is', cart.lastSyncRequest, 'storageSyncTime is', storageSyncTime);
    if (cart.lastSyncRequest < storageSyncTime) {
        var sessionCart = $.webStorage.local().getItem('syncedCart');
        if (!cart.compareCarts(cart, sessionCart)) {
            console.log('carts not identical, rebuilding DOM; current cart: ', cart, 'synced cart:', sessionCart);
            cart.rebuildDOM(sessionCart, false);
        } else {
            console.log('local and remote cart identical, everything okay');
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
    var cancel = false;
    if (first.all.length !== second.all.length) {
        console.log(first.all, ' group "All" count differs: ', second.all);
        return false;
    }


    $.each(first.all, function() {
        if (!$.inArray(this, second.all)) {
            console.log(this, 'not found in all: ', second.all);
            cancel = true;
        }
    });
    if (cancel)
        return false;

    if (first.groups.length !== second.groups.length) {
        console.log(first.groups, first.groups.length, ' group count differs: ', second.groups, second.groups.length);
        return false;
    }

    var groupsFound = 0;
    $.each(first.groups, function() {
        if (cancel)
            return;
        for (var i = 0; i < second.groups.length; i++) {
            if (this.name !== second.groups[i].name)
                continue;
            groupsFound++;

            if (this.items.length !== second.groups[i].items.length) {
                console.log(first.groups, ' group ', this.name, ' item count differs: ', second.groups);
                cancel = true;
                return;
            }

            $.each(this.items, function() {
                if (!$.inArray(this, second.groups[i].items)) {
                    console.log(this, 'not found in group ', second.groups[i].name, ':', second.groups.name);
                    cancel = true;
                    return;
                }
            });
        }
    });
    if (cancel)
        return false;
    if (groupsFound !== first.groups.length) {
        console.log(first.groups, ' group names do not match up ', second.groups);
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
                uniquename: ui.draggable.attr('data-uniquename')
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
        alert('not implemented yet.');
    });

    newEl.appendTo(cart.cart_groups).hide(0).fadeIn(500);
    return groupname;
};


cart.cleanUpGroup = function(newItem, group) {
    //DOM cleanup
    //remove placeholder
    $(group).find(".placeholder").hide(0);
    //do not allow duplicate items
    var copies = $(group).find("[data-uniquename='" + newItem.uniquename + "']");
    if (copies.length > 1)
        copies[1].remove();
};

cart.renameGroup = function(oldname, newname, options) {
    if (newname === oldname)
        return "no rename neccessary. old name matches new name";
    var _group;
    if (!(cart.getGroupByName(newname) === null)) {
        var msg = "can't rename" + oldname + " to " + newname + ": group with that name already exists.";
        console.log(msg);
        return msg;
    }
    _group = cart.getGroupByName(oldname);
    if (_group === null) {
        var msg = "can't rename" + oldname + " to " + newname + ": group " + oldname + "not found!";
        console.log(msg);
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
    if (cart.getItemByUniquename(item.uniquename) !== null) {
        console.log('can\'t add item to "All":', item, 'already exists');
        return false;
    }
    cart.all.unshift(item);

    //sync
    cart.syncAction({
        action: 'addItemToAll',
        item: item
    }, options);

    // DOM manupulation
    var newElStr = $('#cart-item-dummy').html();
    newEl = $('<div/>').html(newElStr).children();
    newEl.attr('data-uniquename', item.uniquename);
    newEl.find('.displayname').html(item.uniquename);
    newEl.find('.cart-button-delete').click(function() {
        var item = $(this).parents('.cart-item').first();
        cart.removeItemFromAll({
            uniquename: item.attr('data-uniquename')
        });
    });
    newEl.find('.cart-button-goto').click(function() {
        var item = $(this).parents('.cart-item').first();
        window.location = '{#$AppPath#}/isoform-details/' + item.attr('data-uniquename');
    });
    newEl.find('.cart-button-edit').click(function() {
        cart.opendialog_edit(item.uniquename);
    });
    newEl.appendTo(cart.cart_group_all.find('ul'));
    cart.refresh_cart_group_all();
};

cart.addItemToGroup = function(item, groupname, options) {
    if (cart.getItemByUniquename(item.uniquename) === null) {
        console.log('can\'t add item to "' + groupname + '":', item, 'is not in "All"');
        return false;
    }
    var _group = cart.getGroupByName(groupname);
    if (_group === null) {
        console.log('can\'t add item to "' + groupname + '": group doesn\'t exist!');
        return false;
    }
    var groupContainsItem = false;
    $.each(_group.items, function() {
        if (this.uniquename === item.uniquename)
            groupContainsItem = true;
    });
    if (groupContainsItem) {
        console.log('can\'t add item to "' + groupname + '": group already contains item!');
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
    var newElStr = $('#cart-item-dummy').html();

    var group = $.getGroupByName(groupname).find('ul');
    newEl = $('<div/>').html(newElStr).children();
    newEl.attr('data-uniquename', item.uniquename);
    newEl.find('.displayname').html(item.uniquename);
    newEl.find('.cart-button-delete').click(function() {
        var item = $(this).parents('.cart-item').first();
        var group = $(this).parents('.cart-group').first();
        cart.removeItemFromGroup({
            uniquename: item.attr('data-uniquename')
        }, group.attr('data-group'));
    });
    newEl.find('.cart-button-goto').click(function() {
        var item = $(this).parents('.cart-item').first();
        window.location = '{#$AppPath#}/isoform-details/' + item.attr('data-uniquename');
    });
    newEl.find('.cart-button-edit').click(function() {
        cart.opendialog_edit(item.uniquename);
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
            if (_item.uniquename === item.uniquename)
                groupContainsItem = true;
        });
        if (groupContainsItem) {
            cart.removeItemFromGroup(item, _group.name);
        }
    });

    for (var i = 0; i < cart.all.length; i++) {
        if (cart.all[i].uniquename === item.uniquename) {
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
    cart.cart_group_all.find('[data-uniquename="' + item.uniquename + '"]').remove();
};

cart.removeItemFromGroup = function(item, groupname, options) {
    var _group = cart.getGroupByName(groupname);
    if (_group === null) {
        console.log('group ', groupname, ' not found');
        return false;
    }

    for (var i = 0; i < _group.items.length; i++) {
        if (_group.items[i].uniquename === item.uniquename) {
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
    group.find('[data-uniquename="' + item.uniquename + '"]').remove();
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

cart.opendialog_edit = function(uniquename) {
    var item = cart.getItemByUniquename(uniquename);
    var dialog = $('#dialog-edit-cart-item');
    dialog.data('uniquename', item.uniquename);
    dialog.data('alias', item.alias);
    dialog.data('annotations', item.annotations);
    dialog.dialog("open");
};


$(document).ready(function() {
    cart.refresh_cart_group_all();
    $('#cart-add-group').click(cart.addGroup);
});