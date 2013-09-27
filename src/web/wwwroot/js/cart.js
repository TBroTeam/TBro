/**
 * Creates an instance of Cart
 * On actions, Events of type "cartEvent" will be triggered on the rootNode.
 * @constructor
 * @this Cart
 * @param {Collection|null} initialData data for the cart to be initialized with
 * @param {Collection} [initialData.carts={}]
 * @param {Array} [initialData.cartitems=[]]
 * @param {Collection} options configuration options for the car
 * @param {jQuery} options.rootNode jQuery node in which all cart DOM will take place
 * @param {String} [options.templates.GroupAll='#template_cart_all_group'] template for the "All" Group
 * @param {String} [options.templates.Group='#template_cart_new_group'] template for any other Group
 * @param {String} [options.templates.Item='#template_cart_new_item'] template for all Items
 * @param {String} [options.serviceNodes.itemDetails='/details/features'] web service for Item Features
 * @param {String} [options.serviceNodes.sync='/cart/sync'] web service for Cart Sync
 * @param {Function} [options.callbacks.afterDOMinsert_groupAll] callback on the new groupAll jQuery node after it has been inserted into the DOM
 * @param {Function} [options.callbacks.afterDOMinsert_group] callback on a new group jQuery node after it has been inserted into the DOM
 * @param {Function} [options.callbacks.afterDOMinsert_item] callback on a new item jQuery node after it has been inserted into the DOM
 * @param {String} [options.groupNamePrefix]
 * @return {Cart}
 */
function Cart(initialData, options) {
    /**
     * See constructor Documentation
     * @public
     */
    this.options = {
        templates: {
            GroupAll: '#template_cart_all_group',
            Group: '#template_cart_new_group',
            Item: '#template_cart_new_item'
        },
        serviceNodes: {
            itemDetails: '/details/features',
            sync: '/cart/sync'
        },
        callbacks: {
            afterDOMinsert_groupAll: function() {
            },
            afterDOMinsert_group: function() {
            },
            afterDOMinsert_item: function() {
            }
        },
        rootNode: null,
        groupNamePrefix: 'Group'
    };
    $.extend(true, this.options, options);
    /** @private */
    this.carts = initialData.carts || {};
    /** @private */
    this.cartitems = initialData.cartitems || {};
    /** @private */
    this.emptyCartPrototype = {
        'all': []
    };
    /** @private */
    this.currentContext = 'unknown';
    this.updateContext('unknown', {
        force: true,
        triggerEvent: false
    });
}

(function() {
    //create own scope for private variables for sync

    //current request. 
    var currentRequest;

    /**
 * Syncronizes an Action with the options.serviceNodes.sync web service.
 * @param {Collection} syncaction action to sync.
 * @param {Collection} [options]
 * @param {bool} [options.triggerEvent] determines if an event is to be triggered
 * @param {bool} [options.sync] determines if this event should be synced to the WebService
 */
    Cart.prototype.sync = function(syncaction, options) {
        options = $.extend({
            triggerEvent: true,
            sync: true
        }, options);


        if (options.triggerEvent) {
            this.options.rootNode.trigger({
                type: 'cartEvent',
                eventData: syncaction
            });
        }

        if (options.sync === false)
            return;

        var that = this;

        currentRequest = new Date().getTime();
        $.ajax({
            url: this.options.serviceNodes.sync,
            type: 'post',
            dataType: "JSON",
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

(function(){
    function checkEqual(obj1, obj2){
        if (obj1==obj2)
            return true;
        for (var key in obj1){
            if (!obj1.hasOwnProperty(key))
                continue;
            if (typeof obj2[key] === "undefined")
                return false;
        }
        
        for (key in obj2){
            if (!obj2.hasOwnProperty(key))
                continue;
            if (typeof obj1[key] === "undefined")
                return false;
            
            if (!checkEqual(obj1[key], obj2[key]))
                return false;
        }
        
        return true;
    }

    /** @private */
    Cart.prototype._compareCarts = function(newCart) {
        //no need to compare the cartitems, we will just use the latest from the server assuming they are equal or more up-to-date
        //one exception: php gives us back [] instead of {} as there is no difference in php between an empty array and an empty associative array(object)
        //we want always {}.
        if (_.isEqual([], newCart.cartitems))
            this.cartitems = {};
        else
            this.cartitems = newCart.cartitems || {};

        var cartsDiffer = !checkEqual(this.carts, newCart.carts);
        var currentCartDiffers = !checkEqual(this.carts[this.currentContext] || {}, newCart.carts[this.currentContext] || {});
        //log
        cartsDiffer && console.log('carts differ', this.carts, newCart.carts);
        currentCartDiffers && console.log('displayed cart differs, redrawing', this.carts[this.currentContext] || {}, newCart.carts[this.currentContext] || {});

        //if carts differ, use the version from the server
        if (cartsDiffer) {
            this.carts = newCart.carts;
        }

        //if there were also differences in the currently displayed cart, redraw
        if (currentCartDiffers) {
            this._redraw();
        }
    };

})();

/** @private */
Cart.prototype._getTemplate = _.memoize(function(templateName) {
    return _.template($(this.options.templates[templateName]).html());
});
/** @private */
Cart.prototype._executeTemplate$ = function(templateName) {
    var template = this._getTemplate(templateName);
    var templateArguments = Array.prototype.slice.call(arguments, 1);
    return $('<div/>').append(template.apply(window, templateArguments)).children();
};
/** @private */
Cart.prototype._getCartForContext = function() {
    if (typeof this.carts[this.currentContext] === 'undefined')
        this.carts[this.currentContext] = this.emptyCartPrototype;
    return this.carts[this.currentContext];
};
/** @private */
Cart.prototype._getGroup = function(groupname) {
    return this._getCartForContext()[groupname];
};
/** @private */
Cart.prototype._getGroupNode = function(groupname) {
    return this.options.rootNode.find('.cartGroup[data-name="' + groupname + '"]');
};
/** @private */
Cart.prototype._getItemDetails = function(ids, callback) {
    var that = this;
    var missingIDs = [];
    var newCartitems = {};
    var retArray = [];
    var dfd = $.Deferred();
    $.each(ids, function(key, id) {
        if (typeof that.cartitems[id] !== 'undefined')
            retArray.push(that.cartitems[id]);
        else {
            //add a reference that will be filled after the ajax call
            newCartitems[id] = {};
            retArray.push(newCartitems[id]);
            missingIDs.push(id);
        }
    });
    if (missingIDs.length === 0) {
        callback(retArray);
        dfd.resolve();
    } else {
        $.ajax({
            url: this.options.serviceNodes.itemDetails,
            data: {
                terms: missingIDs
            },
            dataType: 'JSON',
            success: function(data) {
                $.each(data.results, function() {
                    var itemDetails = $.extend(true, this, {
                        metadata: {}
                    });
                    var id = itemDetails.feature_id;
                    that.cartitems[id] = itemDetails;
                    $.extend(newCartitems[id], itemDetails);
                });
                callback(retArray);
                dfd.resolve();
            }
        });
    }
    return dfd.promise();
};
/** @private */
Cart.prototype._getItemNodes = function(id, groupname) {
    if (typeof groupname === 'undefined' || groupname === 'all')
        return this.options.rootNode.find('.cartItem[data-id="' + id + '"]');
    else
        return this._getGroupNode(groupname).find('.cartItem[data-id="' + id + '"]');
};
/**
 * sets a new context. if forced, or old context differs from new context, the cart will be redrawn with new items
 * @param {String} newContext
 * @param {Collection} [options]
 * @param {bool} [options.triggerEvent] determines if an event is to be triggered
 * @param {bool} [options.force] if this is set, context will be updated, even when oldContext==newContext
 */
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

    this.sync({
        action: 'updateContext'
    }, {
        sync: false,
        triggerEvent: options.triggerEvent
    });
};
/** @private */
Cart.prototype._redraw = function() {
    this.options.rootNode.empty();
    this.sync({
        action: 'redraw'
    }, {
        sync: false,
        triggerEvent: true
    });

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
        that.addItem(group, {
            groupname: groupname,
            sync: false
        });
    }

};
/**
 * Adds one or more Features to a given Cart Group. If the group does not exist, it is created.
 * This method is asynchronous and if an event has to be executed after it has been finished, this can be done with the returned Deferred Promise:
 * $.when(cart.add(...)).then(function(){});
 * @param {Array|Number} ids ids of features to add to the cart
 * @param {Collection} [options]
 * @param {bool} [options.groupname='all'] Group to add to. Defaults to 'all'
 * @param {bool} [options.addToDOM] should this only be added internally or to the DOM?
 * @param {bool} [options.afterDOMinsert] callback
 * @param {bool} [options.sync] sync?
 * @returns {jQuery Deferred Promise}
 */
Cart.prototype.addItem = function(ids, options) {
    //convert object values to array. keys will be lost
    if (_.isObject(ids)) {
        ids = _.map(ids, function(value) {
            return value;
        });
    }
    //if ids is still no array, it was passed as a single value. convert to array
    if (!_.isArray(ids)) {
        ids = [ids];
    }
    //convert all array values to Int
    for (var i = 0; i < ids.length; i++) {
        ids[i] = parseInt(ids[i]);
    }
    //this function is very asynchronous, this deferred object is a way to see if it finished ( via $.when(cart.addItem(id)).then(function) )
    var dfd = $.Deferred();
    options = $.extend({
        groupname: 'all',
        addToDOM: true,
        afterDOMinsert: this.options.callbacks.afterDOMinsert_item,
        sync: true
    }, options);

    var that = this;
    var missingIds = _.difference(ids, that._getCartForContext()[options.groupname || []]);
    if (missingIds.length == 0) {
        // we have nothing to do. return from here.
        dfd.resolve();
        return dfd.promise();
    }

    if (options.groupname !== 'all')
        $.when(this.addItem(ids, $.extend({}, options, {
            groupname: 'all'
        }))).then(work);
    else
        work();

    return dfd.promise();

    function work() {
        that._getItemDetails(missingIds, function(aItemDetails) {

            addInternal.call(that);
            if (options.addToDOM)
                addToDOM.call(that, aItemDetails);

            that.sync({
                action: 'addItem',
                ids: missingIds,
                groupname: options.groupname
            }, options);

            dfd.resolve();
        });
    }

    function addInternal() {
        var group = this._getGroup(options.groupname);
        if (typeof group === undefined)
            group = this._getGroup(this.addGroup(options.groupname));

        for (var i = 0; i < ids.length; i++)
            if (_.indexOf(group, ids[i]) === -1)
                group.push(ids[i]);
    }

    function addToDOM(aItemDetails) {
        $.each(aItemDetails, function(key, itemDetails) {
            var group$ = that._getGroupNode(options.groupname);
            if (group$.is(':has(li.cartItem[data-id="' + itemDetails.feature_id + '"])')) {
                return;
            }
            var item$ = that._executeTemplate$('Item', {
                item: itemDetails
            });
            item$.data('afterDOMinsert', options.afterDOMinsert);
            group$.find('.elements .placeholder').remove();
            group$.find('.elements').append(item$);
            options.afterDOMinsert.call(item$);
        });
    }
};

/**
 * Updates Metadata for a cart Item
 * @param {Number} id of features to add to the cart
 * @param {Collection} metadata
 * @param {Collection} [options]
 * @param {bool} [options.sync] sync?
 */
Cart.prototype.updateItem = function(id, metadata, options) {
    //make sure we don't have a string id'
    id = parseInt(id);

    options = $.extend({
        sync: true
    }, options);
    var that = this;

    this._getItemDetails([id], function(aItemDetails) {
        if (updateInternal.call(that, aItemDetails[0]))
            updateDOM.call(that, aItemDetails[0]);

        that.sync({
            action: 'updateItem',
            id: id,
            metadata: metadata
        }, options);
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

/**
 * Removes a feature from a group or all groups
 * @param {Number} id of features to remove
 * @param {Collection} [options]
 * @param {bool} [options.groupname] defaults to 'all'
 * @param {bool} [options.sync] sync?
 */
Cart.prototype.removeItem = function(id, options) {
    //make sure we don't have a string id'
    id = parseInt(id);

    options = $.extend({
        groupname: 'all',
        sync: true
    }, options);

    removeInternal.call(this);
    removeFromDOM.call(this);
    this.sync({
        action: 'removeItem',
        id: id,
        groupname: options.groupname
    }, options);

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

/**
 * Adds a new group to the cart
 * @param {String} groupname
 * @param {Collection} [options]
 * @param {bool} [options.sync] sync?
 */
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
        this.sync({
            action: 'addGroup',
            groupname: groupname
        }, options);
    }
    return groupname;

    function addInternal() {
        this._getCartForContext()[groupname] = [];
    }

    function addToDOM() {
        var parent$ = this.options.rootNode;
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

/**
 * Renames a cart group
 * @param {String} groupname
 * @param {String} newname
 * @param {Collection} [options]
 * @param {bool} [options.sync] sync?
 */
Cart.prototype.renameGroup = function(groupname, newname, options) {
    options = $.extend({
        sync: true
    }, options);

    if (groupname === newname)
        return;

    if (this._getGroup(newname) !== undefined) {
        throw new Error("Cart with this name already exists!");
    }

    renameInternal.call(this);
    renameInDOM.call(this);
    this.sync({
        action: 'renameGroup',
        groupname: groupname,
        newname: newname
    }, options);

    function renameInternal() {
        var cart = this._getCartForContext();
        var group = cart[groupname];
        cart[newname] = group;
        delete cart[groupname];
    }

    function renameInDOM() {
        var oldGroup$ = this._getGroupNode(groupname);
        var items$ = oldGroup$.find('.cartItem');
        var newGroup$ = this._executeTemplate$('Group', {
            groupname: newname
        });
        var afterDOMinsert = oldGroup$.data('afterDOMinsert');
        newGroup$.data('afterDOMinsert', afterDOMinsert);
        newGroup$.find('.elements').append(items$);
        if($( ".elements" ).length > 0){
            newGroup$.find('.elements .placeholder').remove();
        }
        oldGroup$.replaceWith(newGroup$);
        afterDOMinsert.call(newGroup$);
    }
};

/**
 * Removes a cart group
 * @param {String} groupname
 * @param {Collection} [options]
 * @param {bool} [options.sync] sync?
 */
Cart.prototype.removeGroup = function(groupname, options) {
    options = $.extend({
        sync: true
    }, options);


    removeInternal.call(this);
    removeFromDOM.call(this);
    this.sync({
        action: 'removeGroup',
        groupname: groupname
    }, options);

    function removeInternal() {
        delete this._getCartForContext()[groupname];
    }

    function removeFromDOM() {
        this._getGroupNode(groupname).remove();
    }
};

/**
 * Removes everything from the current context
 * @param {Collection} [options]
 * @param {bool} [options.sync] sync?
 */
Cart.prototype.clear = function(options) {
    options = $.extend({
        sync: true
    }, options);

    var that = this;
    $.each(this._getCartForContext()['all'], function() {
        delete that.cartitems[this];
    });

    delete this.carts[this.currentContext];
    this.sync({
        action: 'clear'
    }, options);


    this.updateContext(this.currentContext, {
        force: true
    });
};

/**
 * Get all items from a given group, in the format [{id: id[, metadata:{metadata}]}]
 * @param {String} groupname
 * @returns {Array}
 */
Cart.prototype.exportGroup = function(groupname) {
    var group = this._getGroup(groupname) || [];
    var items = [];
    for (var i = 0; i < group.length; i++) {
        var item = {
            id: group[i]
            };
        var metadata = (this.cartitems[group[i]] || {}).metadata || {};
        if (!_.isEmpty(metadata)) {
            item.metadata = metadata;
        }
        items.push(item);
    }
    return items;
};

/**
 * Imports passed Array items as new Group to the cart. 
 * @param {Array} items [{id: id, metadata:{alias: string, annotations:string}}, ...]
 * @param {Collection} options
 * @param {Enum(keep|merge|overwrite)} [metadata_conflict='keep'] defaults to keep
 */
Cart.prototype.importGroup = function(items, options) {
    options = $.extend({
        metadata_conflict: 'keep'
    }, options);
    console.log(items);
    var groupname = this.addGroup();
    var that = this;
    $.when(that.addItem($.map(items, function(val) {
        return val.id;
    }), {
        groupname: groupname
    })).then(function() {
        console.log(options.metadata_conflict);
        for (var i = 0; i < items.length; i++) {
            var item = items[i];
            var cartitem = that.cartitems[item.id];
            if (!_.isEmpty(item.metadata))
                switch (options.metadata_conflict) {
                    case 'keep':
                        break;
                    case 'merge':
                        var new_metadata = $.extend({}, item.metadata, cartitem.metadata);
                        if (!_.isEqual(new_metadata, cartitem.metadata))
                            that.updateItem(item.id, new_metadata);
                        break;
                    case 'overwrite':
                        if (!_.isEqual(item.metadata, cartitem.metadata))
                            that.updateItem(item.id, item.metadata);
                        break;
                }
        }
    });
};

/**
* Binds a select element to a cart, always keeping Groups synchronized as Select Options
* @constructor
 * @param {jQuery} node$ a Select
 * @param {Cart} cart
 * @returns {Groupselect} 
 * */
function Groupselect(node$, cart) {
    this.node$ = node$;
    this.cart = cart;
    this.cart.options.rootNode.on('cartEvent', function(e) {
        if (e.eventData.action === 'addGroup') {
            node$.append($('<option/>').text(e.eventData.groupname).val(e.eventData.groupname));
        }
        else if (e.eventData.action === 'renameGroup') {
            node$.find('option[value="' + e.eventData.groupname + '"]').text(e.eventData.newname).val(e.eventData.newname);
        }
        else if (e.eventData.action === 'removeGroup') {
            node$.find('option[value="' + e.eventData.groupname + '"]').remove();
        } else if (e.eventData.action === 'redraw') {
            node$.find('option:not(.keep)').remove();
        }
    });
}


/**
* Binds a list element to a cart, always keeping Groups synchronized as list items
* @constructor
 * @param {jQuery} node$ a List
 * @param {Cart} cart
 * @param {Function} callback
 * @returns {Grouplist} 
 * */
function Grouplist(node$, cart, callback) {
    this.node$ = node$;
    this.cart = cart;
    this.cart.options.rootNode.on('cartEvent', function(e) {
        if (e.eventData.action === 'addGroup') {
            var li = $('<li/>').text(e.eventData.groupname).attr("data-value", e.eventData.groupname);
            li.click(callback);
            node$.append(li);
        }
        else if (e.eventData.action === 'renameGroup') {
            node$.find('li[data-value="' + e.eventData.groupname + '"]').text(e.eventData.newname).attr("data-value", e.eventData.newname);
        }
        else if (e.eventData.action === 'removeGroup') {
            node$.find('li[data-value="' + e.eventData.groupname + '"]').remove();
        } else if (e.eventData.action === 'redraw') {
            node$.find('li:not(.keep)').remove();
        }
    });
}