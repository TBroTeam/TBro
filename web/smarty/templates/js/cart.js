function Cart(initialData, options) {
    this.options = {
        templates: {
            GroupAll: '#template_cart_all_group',
            Group: '#template_cart_new_group',
            Item: '#template_cart_new_item'
        },
        serviceNodes: {
            itemDetails: '{#$ServicePath#}/details/cartitem/'
        },
        callbacks: {
            afterDOMinsert_groupAll: function() {
            },
            afterDOMinsert_group: function() {
            },
            afterDOMinsert_item: function() {
            }
        },
        parentNode: '#Cart',
        groupNamePrefix: 'Group'
    };
    $.extend(true, this.options, options);

    this.carts = initialData.carts || {};
    this.cartitems = initialData.cartitems || {};
    this.emptyCartPrototype = {
        'all': []
    };
    this.currentContext = 'unknown';
    this.updateContext('unknown', {force: true, triggerEvent: false});
}

(function() {
    //create own scope for private variables for sync

    //current request. 
    var currentRequest;

    Cart.prototype.sync = function(syncaction, options) {
        options = $.extend({
            triggerEvent: true,
            sync: true
        }, options);

        if (options.triggerEvent)
            $.event.trigger({
                type: 'cartEvent',
                eventData: syncaction
            });

        if (options.sync === false)
            return;

        var that = this;

        currentRequest = new Date().getTime();
        $.ajax({
            url: '{#$ServicePath#}/cart/sync',
            type: 'post',
            dataType: "json",
            data: {
                action: syncaction,
                currentRequest: currentRequest,
                currentContext: this.currentContext
            },
            success: responseHandler
        });


        function responseHandler(data) {
            //handle only the most recent request
            if (parseInt(data.currentRequest) === currentRequest)
                that._compareCarts(data.cart);
        }
    };
})();

Cart.prototype._compareCarts = function(newCart) {
    //no need to compare the cartitems, we will just use the latest from the server assuming they are equal or more up-to-date
    //one exception: php gives us back [] instead of {} as there is no difference in php between an empty array and an empty associative array(object)
    //we want always {}.
    if (_.isEqual([], newCart.cartitems))
        this.cartitems = {};
    else
        this.cartitems = newCart.cartitems;

    var cartsDiffer = !_.isEqual(this.carts, newCart.carts);
    var currentCartDiffers = !_.isEqual(this.carts[this.currentContext] || {}, newCart.carts[this.currentContext] || {});

    //if carts differ, use the version from the server
    if (cartsDiffer) {
        console.log('carts differ', this.carts, newCart.carts);
        this.carts = newCart.carts;
    }
    //if there were also differences in the currently displayed cart, redraw
    if (currentCartDiffers) {
        console.log('displayed cart differs, redrawing', this.carts[this.currentContext] || {}, newCart.carts[this.currentContext] || {});
        this._redraw();
    }

};

Cart.prototype._getTemplate = _.memoize(function(templateName) {
    return _.template($(this.options.templates[templateName]).html());
});

Cart.prototype._executeTemplate$ = function(templateName) {
    var template = this._getTemplate(templateName);
    var templateArguments = Array.prototype.slice.call(arguments, 1);
    return $('<div/>').append(template.apply(window, templateArguments)).children();
};

Cart.prototype._getCartForContext = function() {
    if (typeof this.carts[this.currentContext] === 'undefined')
        this.carts[this.currentContext] = this.emptyCartPrototype;
    return this.carts[this.currentContext];
};

Cart.prototype._getGroup = function(groupname) {
    return this._getCartForContext()[groupname];
};

Cart.prototype._getGroupNode = function(groupname) {
    return $(this.options.parentNode).find('.cartGroup[data-name="' + groupname + '"]');
};

Cart.prototype._getItemDetails = function(id, callback) {
    var that = this;
    if (typeof this.cartitems[id] !== 'undefined')
        callback(this.cartitems[id]);
    else
        $.ajax({
            url: this.options.serviceNodes.itemDetails + id,
            dataType: 'JSON',
            success: function(itemDetails) {
                $.extend(true, itemDetails, {metadata: {}});
                that.cartitems[id] = itemDetails;
                callback(itemDetails);
            }
        });
};

Cart.prototype._getItemNodes = function(id, groupname) {
    if (typeof groupname === 'undefined' || groupname === 'all')
        return $(this.options.parentNode).find('.cartItem[data-id="' + id + '"]');
    else
        return this._getGroupNode(groupname).find('.cartItem[data-id="' + id + '"]');
};

Cart.prototype.updateContext = function(newContext, options) {
    options = $.extend({
        force: false,
        triggerEvent: true
    }, options);


    if (this.currentContext === newContext && !options.force)
        //nothing to do
        return;

    this.currentContext = newContext;

    this._redraw();
    if (options.triggerEvent)
        $.event.trigger({
            type: 'cart.updateContext',
            eventData: {}
        });
};

Cart.prototype._redraw = function() {
    $(this.options.parentNode).empty();
    var cart = _.clone(this._getCartForContext());
    var cartToEmpty = this._getCartForContext();
    for (var key in cartToEmpty) {
        if (cartToEmpty.hasOwnProperty(key))
            delete cartToEmpty[key];
    }
    var that = this;

    for (var groupname in cart) {
        if (!cart.hasOwnProperty(groupname))
            continue;
        var group = cart[groupname];
        that.addGroup(groupname, {
            sync: false
        });
        for (var i = 0; i < group.length || 0; i++)
            that.addItem(group[i], {
                groupname: groupname,
                sync: false
            });
    }

};

Cart.prototype.addItem = function(id, options) {
    //make sure we don't have a string id'
    id = parseInt(id);

    options = $.extend({
        groupname: 'all',
        addToDOM: true,
        afterDOMinsert: this.options.callbacks.afterDOMinsert_item,
        sync: true
    }, options);


    var that = this;

    this._getItemDetails(id, function(itemDetails) {
        if (options.groupname !== 'all' && _.indexOf(that._getCartForContext()['all'], id) === -1)
            that.addItem(id, $.extend({}, options, {
                groupname: 'all'
            }));

        if (addInternal.call(that, itemDetails) && options.addToDOM)
            addToDOM.call(that, itemDetails);

        that.sync({action: 'addItem', id: id, groupname: options.groupname}, options);
    });

    function addInternal(itemDetails) {
        var group = this._getGroup(options.groupname);
        if (typeof group === undefined)
            group = this._getGroup(this.addGroup(options.groupname));
        if (_.indexOf(group, id) >= 0)
            return false;
        group.push(id);
        return true;
    }

    function addToDOM(itemDetails) {
        var group$ = this._getGroupNode(options.groupname);
        var item$ = this._executeTemplate$('Item', {
            item: itemDetails
        });
        item$.data('afterDOMinsert', options.afterDOMinsert);
        group$.find('.elements .placeholder').remove();
        group$.find('.elements').append(item$);
        options.afterDOMinsert.call(item$);
    }
};

Cart.prototype.updateItem = function(id, metadata, options) {
//make sure we don't have a string id'
    id = parseInt(id);

    options = $.extend({
        sync: true
    }, options);
    var that = this;

    this._getItemDetails(id, function(itemDetails) {
        if (updateInternal.call(that, itemDetails))
            updateDOM.call(that, itemDetails);

        that.sync({action: 'updateItem', id: id, metadata: metadata}, options);
    });

    function updateInternal(itemDetails) {
        if (_.isEqual(itemDetails.metadata, metadata))
            return false;
        $.extend(itemDetails.metadata, metadata);
        return true;
    }

    function updateDOM(itemDetails) {
        var items$ = this._getItemNodes(id);
        var newItem$ = this._executeTemplate$('Item', {
            item: itemDetails
        });
        var afterDOMinsert = items$.data('afterDOMinsert');
        newItem$.data('afterDOMinsert', afterDOMinsert);
        items$.replaceWith(newItem$);
        afterDOMinsert.apply(newItem$);
    }

};

Cart.prototype.removeItem = function(id, options) {
    //make sure we don't have a string id'
    id = parseInt(id);

    options = $.extend({
        groupname: 'all',
        sync: true
    }, options);

    removeInternal.call(this);
    removeFromDOM.call(this);
    this.sync({action: 'removeItem', id: id, groupname: options.groupname}, options);

    function removeInternal() {
        var cart = this._getCartForContext();
        if (options.groupname === 'all') {
            $.each(cart, function() {
                var index;
                if ((index = _.indexOf(this, id)) >= 0)
                    this.splice(index, 1);
            });
            delete this.cartitems[id];
        } else {
            var group = this._getGroup(options.groupname);
            var index;
            if ((index = _.indexOf(group, id)) >= 0)
                group.splice(index, 1);
        }
    }

    function removeFromDOM() {
        this._getItemNodes(id, options.groupname).remove();
    }
};

Cart.prototype.addGroup = function(groupname, options) {
    options = $.extend({
        sync: true
    }, options);
    if (typeof options.afterDOMinsert === 'undefined') {

        if (groupname === 'all')
            options.afterDOMinsert = this.options.callbacks.afterDOMinsert_groupAll;
        else
            options.afterDOMinsert = this.options.callbacks.afterDOMinsert_group;
    }


    var lastGroupNumber = 0;
    //if we did not recevie a group name, generate a new unused one
    if (typeof groupname === 'undefined')
        do {
            groupname = this.options.groupNamePrefix + (++lastGroupNumber);
        } while (typeof this._getGroup(groupname) !== 'undefined');

    //create a group if we need to
    if (typeof this._getGroup(groupname) === 'undefined') {
        addInternal.call(this);
        addToDOM.call(this);
        this.sync({action: 'addGroup', groupname: groupname}, options);
    }
    return groupname;

    function addInternal() {
        this._getCartForContext()[groupname] = [];
    }

    function addToDOM() {
        var parent$ = $(this.options.parentNode);
        var group$;
        if (groupname === 'all') {
            group$ = this._executeTemplate$('GroupAll');
        } else {
            group$ = this._executeTemplate$('Group', {
                groupname: groupname
            });
        }
        group$.data('afterDOMinsert', options.afterDOMinsert);
        parent$.append(group$);
        options.afterDOMinsert.call(group$);
    }
};

Cart.prototype.renameGroup = function(oldname, newname, options) {
    options = $.extend({
        sync: true
    }, options);

    if (oldname === newname)
        return;

    if (this._getGroup(newname) !== undefined) {
        throw new Error("Cart with this name already exists!");
    }

    renameInternal.call(this);
    renameInDOM.call(this);
    this.sync({action: 'renameGroup', groupname: oldname, newname: newname}, options);

    function renameInternal() {
        var cart = this._getCartForContext();
        var group = cart[oldname];
        cart[newname] = group;
        delete cart[oldname];
    }

    function renameInDOM() {
        var oldGroup$ = this._getGroupNode(oldname);
        var items$ = oldGroup$.find('.cartItem');
        var newGroup$ = this._executeTemplate$('Group', {
            groupname: newname
        });
        var afterDOMinsert = oldGroup$.data('afterDOMinsert');
        newGroup$.data('afterDOMinsert', afterDOMinsert);
        newGroup$.find('.elements').append(items$);
        oldGroup$.replaceWith(newGroup$);
        afterDOMinsert.call(newGroup$);
    }
};

Cart.prototype.removeGroup = function(groupname, options) {
    options = $.extend({
        sync: true
    }, options);


    removeInternal.call(this);
    removeFromDOM.call(this);
    this.sync({action: 'removeGroup', groupname: groupname}, options);

    function removeInternal() {
        delete this._getCartForContext()[groupname];
    }

    function removeFromDOM() {
        this._getGroupNode(groupname).remove();
    }
};

Cart.prototype.clear = function() {
    options = $.extend({
        sync: true
    }, options);

    delete this.carts[this.currentContext];
    this.updateContext(this.currentContext, {force: true});
};