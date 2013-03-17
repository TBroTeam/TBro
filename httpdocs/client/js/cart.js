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
function receiveItemAtGroup(event, ui) {
    var item = {uniquename: ui.item.attr('data-uniquename'), id: ui.item.attr('data-id')};
    //call addObjectToGroup, but tell it not to manipulate the DOM as that's already happened
    addItemToGroup(item, $(this).parent().attr('data-group'), false);
    //DOM cleanup
    //remove placeholder
    $(this).find(".placeholder").remove();
    //do not allow duplicate items
    var copies = $(this).find("[data-uniquename='" + ui.item.attr('data-uniquename') + "']");
    if (copies.length > 1)
        copies[1].remove();
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
        receive: receiveItemAtGroup
    });
    newEl.accordion({
        collapsible: true,
        heightStyle: "content"
    });


    return groupname;
}

function getGroupByName(name) {
    var group = null;
    $.each(cart.groups, function() {
        if (this.name === name) {
            group = this;
        }
    });
    return group;
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
    var group = cart_groups.find("[data-group='" + oldname + "'] .ui-accordion-header");
    var re = new RegExp(RegExp.quote(oldname), "g");
    group.html(group.html().replace(re, newname));
}

function getItemByUniquename(name) {
    var item = null;
    $.each(cart.all, function() {
        if (this.uniquename === name) {
            item = this;
        }
    });
    return item;
}

function addItemToAll(object) {
    if (getItemByUniquename(object.uniquename) !== null) {
        console.log('can\'t add object to "All":', object, 'already exists');
        return false;
    }
    cart.all.push(object);
    // DOM manupulation
    var newElStr = $('#cart-item-dummy').html();
    newElStr = newElStr.replace(/#uniquename#/g, object.uniquename);
    newElStr = newElStr.replace(/#id#/g, object.id);
    cart_group_all.find('ul').append(newElStr);
    refresh_cart_group_all();
}

function addItemToGroup(item, groupname, modifyDOM) {
    if (getItemByUniquename(object.uniquename) === null) {
        console.log('can\'t add object to "'+groupname+'":', object, 'is not in "All"');
        return false;
    }
    var group = getGroupByName(groupname);
    if (group === null) {
        console.log('can\'t add object to "'+groupname+'": group doesn\'t exist!');
        return false;
    }
    group.items.push(item);
    
    // DOM manupulation
    if (!modifyDOM)
        return true;
}

function removeItemFromAll(item) {
}

function removeItemFromGroup(item, groupname) {
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

$(document).ready(function() {
    refresh_cart_group_all();
    $('#cart-add-group').click(addGroup);
});