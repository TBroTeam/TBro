var lastGroupNumber = 0;
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
var cart_groups = null;
/**
 *&lt;div id="cart-group-all" class='ui_accordion ui_collapsible'&gt;<br/>
 *&emsp;&lt;div&gt;all&lt;div class="right"&gt;&lt;img src="/img/mimiGlyphs/23.png"/>&lt;/div&gt;&lt;/div&gt;<br/>
 *&emsp;&lt;ul&gt;<br/>
 *&emsp;*&emsp;&lt;li data-uniquename="#uniquename#"&gt;#uniquename#&lt;/li&gt;<br/>
 *&emsp;&lt;/ul&gt;<br/>
 *&lt;/div&gt;<br/>
 * @type JQuery
 */
var cart_group_all = null;
/**
 *{<br/>
 *&emsp;all:[&lt;item&gt;&#42;],<br/>
 *&emsp;groups:[&lt;group&gt;&#42;]<br/>
 *}<br/>
 *with<br/>
 *&lt;item&gt;={id:&lt;int&gt;, uniquename:&lt;string&gt;}<br/>
 *&lt;group&gt;={name:&lt;string&gt;, items:[&lt;item&gt;&#42;]}<br/>
 * @type Object
 */
var cart = {all: [], groups: []};
$(document).ready(function() {
    cart_groups = $('#cart-groups');
    cart_group_all = $('#cart-group-all');
});
RegExp.quote = function(str) {
    return str.replace(/([.?*+^$[\]\\(){}|-])/g, "\\$1");
};

function getGroupByName(name) {
    var group = null;
    $.each(cart.groups, function() {
        if (this.name === name) {
            group = this;
        }
    });
    return group;
}

$.extend({
    getGroupByName: function(name) {
        return cart_groups.find("[data-group='" + name + "']");
    }
});


function getItemByUniquename(name) {
    var item = null;
    $.each(cart.all, function() {
        if (this.uniquename === name) {
            item = this;
        }
    });
    return item;
}

/**
 *&nbsp;this function syncs all cart actions to the server.
 *&nbsp;action will be mirrored on server and new dataset will be returned.
 *&nbsp;if server data differs, local data will be overwritten and DOM will be rebuilt from server data
 *&nbsp;@param {object} action action with parameters to be synced
 *&nbsp;@param {object} options used internally
 *&nbsp;@returns nothing
 *&nbsp;*/
function syncAction(action, options) {
    if (options !== undefined && options.sync === false)
        return;
    console.log(action);
}

/**
 *&nbsp;adds a new group to the cart
 *&nbsp;@param {object} options used internally
 *&nbsp;@returns new group name
 */
function addGroup(options) {
    do {
        groupname = "group " + (++lastGroupNumber);
    }
    while (getGroupByName(groupname) !== null);

    var group = {name: groupname, items: []};
    cart.groups.push(group);

    //sync
    syncAction({action: 'addGroup', name: groupname}, options);

    // DOM manupulation
    var newElStr = $('#cart-group-dummy').html();
    newElStr = newElStr.replace(/#groupname#/g, groupname);
    cart_groups.append(newElStr);
    var newEl = cart_groups.find("[data-group='" + groupname + "']");
    newEl.find('.cart-target').sortable({
        items: "li:not(.placeholder)",
        accept: ":not(.ui-sortable-helper)",
        receive: function(event, ui) {
            var item = {uniquename: ui.item.attr('data-uniquename'), id: ui.item.attr('data-id')};
            //call addObjectToGroup, but tell it not to manipulate the DOM as that's already happened
            addItemToGroup(item, $(this).parent().attr('data-group'), false);
            //clean up placeholder and duplicate items
            cleanUpGroup(item, this);
        }
    });
    newEl.accordion({
        collapsible: true,
        heightStyle: "content"
    });
    return groupname;
}

function renameGroup(oldname, newname, options) {
    if (newname === oldname)
        return;
    var _group;
    if (!(getGroupByName(newname) === null)) {
        console.log("can't rename" + oldname + " to " + newname + ": group with that name already exists.");
        return false;
    }
    _group = getGroupByName(oldname);
    if (_group === null) {
        console.log("can't rename" + oldname + " to " + newname + ": group " + oldname + "not found!");
        return false;
    }
    _group.name = newname;

    // sync
    syncAction({action: 'renameGroup', oldname: oldname, newname: newname}, options);

    // DOM manupulation
    var group = $.getGroupByName(oldname);
    group.attr('data-group', newname);
    var header = group.find('.ui-accordion-header');
    var re = new RegExp(RegExp.quote(oldname), "g");
    header.html(header.html().replace(re, newname));
}


function addItemToAll(item, options) {
    if (getItemByUniquename(item.uniquename) !== null) {
        console.log('can\'t add item to "All":', item, 'already exists');
        return false;
    }
    cart.all.push(item);

    //sync
    syncAction({action: 'addItemToAll', item: item}, options);

    // DOM manupulation
    var newElStr = $('#cart-item-dummy').html();
    newElStr = newElStr.replace(/#uniquename#/g, item.uniquename);
    newElStr = newElStr.replace(/#id#/g, item.id);
    cart_group_all.find('ul').append(newElStr);
    refresh_cart_group_all();
}

function addItemToGroup(item, groupname, options) {
    if (getItemByUniquename(item.uniquename) === null) {
        console.log('can\'t add item to "' + groupname + '":', item, 'is not in "All"');
        return false;
    }
    var _group = getGroupByName(groupname);
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
    syncAction({action: 'addItemToGroup', item: item, groupname: groupname}, options);

    // DOM manupulation
    if (options !== undefined && options.modifyDOM === false)
        return true;
    var newElStr = $('#cart-item-dummy').html();
    newElStr = newElStr.replace(/#uniquename#/g, item.uniquename);
    var group = $.getGroupByName(groupname).find('ul');
    group.append(newElStr);
    cleanUpGroup(item, group);
}

function removeItemFromAll(item, options) {
    $.each(cart.groups, function() {
        var _group = this;
        var groupContainsItem = false;
        $.each(_group.items, function() {
            _item = this;
            if (_item.uniquename === item.uniquename)
                groupContainsItem = true;
        });
        if (groupContainsItem) {
            removeItemFromGroup(item, _group.name);
        }
    });

    for (var i = 0; i < cart.all.length; i++) {
        if (cart.all[i].uniquename === item.uniquename) {
            cart.all.splice(i, 1);
            i--;
        }
    }

    //sync
    syncAction({action: 'removeItemFromAll', item: item}, options);

    //DOM manipulation
    cart_group_all.find('[data-uniquename="' + item.uniquename + '"]').remove();
}

function removeItemFromGroup(item, groupname, options) {
    var _group = getGroupByName(groupname);
    for (var i = 0; i < _group.items.length; i++) {
        if (_group.items[i].uniquename === item.uniquename) {
            _group.items.splice(i, 1);
            i--;
        }
    }

    //sync
    syncAction({action: 'removeItemFromGroup', item: item, groupname: groupname}, options);

    //DOM manipulation
    var group = $.getGroupByName(groupname);
    group.find('[data-uniquename="' + item.uniquename + '"]').remove();
}

function refresh_cart_group_all() {
    cart_group_all.find('li').draggable({
        appendTo: "body",
        helper: function() {
            return $(this).clone().addClass('beingDragged');
        },
        connectToSortable: ".cart-target"
    });
}

function cleanUpGroup(newItem, group) {
    //DOM cleanup
    //remove placeholder
    $(group).find(".placeholder").remove();
    //do not allow duplicate items
    var copies = $(group).find("[data-uniquename='" + newItem.uniquename + "']");
    if (copies.length > 1)
        copies[1].remove();
}


$(document).ready(function() {
    refresh_cart_group_all();
    $('#cart-add-group').click(addGroup);
});