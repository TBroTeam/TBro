var lastGroupNumber = 0;
var cart_groups = null;
var cart_group_all = null;
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


function addGroup() {
    do {
        groupname = "group " + (++lastGroupNumber);
    }
    while (getGroupByName(groupname) !== null);
    var group = {name: groupname, items: []};
    cart.groups.push(group);

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

function renameGroup(oldname, newname) {
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

    // DOM manupulation
    var group = $.getGroupByName(oldname);
    group.attr('data-group', newname);
    var header = group.find('.ui-accordion-header');
    var re = new RegExp(RegExp.quote(oldname), "g");
    header.html(header.html().replace(re, newname));
}


function addItemToAll(item) {
    if (getItemByUniquename(item.uniquename) !== null) {
        console.log('can\'t add item to "All":', item, 'already exists');
        return false;
    }
    cart.all.push(item);

    // DOM manupulation
    var newElStr = $('#cart-item-dummy').html();
    newElStr = newElStr.replace(/#uniquename#/g, item.uniquename);
    newElStr = newElStr.replace(/#id#/g, item.id);
    cart_group_all.find('ul').append(newElStr);
    refresh_cart_group_all();
}

function addItemToGroup(item, groupname, modifyDOM) {
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

    // DOM manupulation
    if (!modifyDOM)
        return true;
    var newElStr = $('#cart-item-dummy').html();
    newElStr = newElStr.replace(/#uniquename#/g, item.uniquename);
    var group = $.getGroupByName(groupname).find('ul');
    group.append(newElStr);
    cleanUpGroup(item, group);
}

function removeItemFromAll(item) {
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


    //DOM manipulation
    cart_group_all.find('[data-uniquename="' + item.uniquename + '"]').remove();
}

function removeItemFromGroup(item, groupname) {
    var _group = getGroupByName(groupname);
    for (var i = 0; i < _group.items.length; i++) {
        if (_group.items[i].uniquename === item.uniquename) {
            _group.items.splice(i, 1);
            i--;
        }
    }

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