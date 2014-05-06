/**
 * Creates an instance of Cart
 * On actions, Events of type "cartEvent" will be triggered on the rootNode.
 * @constructor
 * @this Cart
 * @param {Collection|null} initialData data for the cart to be initialized with
 * @param {Collection} [initialData.carts={}]
 * @param {Array} [initialData.cartitems=[]]
 * @param {Collection} options configuration options for the car
 * @param {jQuery} [options.rootNode] jQuery node in which all cart DOM will take place
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
            Group: '#template_cart_new_group',
            Item: '#template_cart_new_item'
        },
        serviceNodes: {
            itemDetails: '/details/features',
            sync: '/cart/sync'
        },
        callbacks: {
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
    this.metadata = initialData.metadata || {};
    /** @private */
    this.md5sum = initialData.md5sum || '';
    /** @private */
    this.emptyCartPrototype = {
    };
    /** @private */
    this.autoSync = true;
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
            sync: true,
            context: this.currentContext,
            auto: false,
            customCallback: null
        }, options);
        if (options.auto && !this.autoSync)
            return;
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
                currentContext: options.context
            },
            success: responseHandler
        });
        function responseHandler(data) {
            if (options.customCallback !== null) {
                options.customCallback();
            }
            //handle only the most recent request
            if (parseInt(data.currentRequest) === currentRequest) {
                that._compareCarts(data);
                if (typeof data.cart !== 'undefined') {
                    that._replaceCarts(data);
                }
            }
        }
    };
})();
(function() {
    /** @private */
    Cart.prototype._replaceCarts = function(data) {
        var newCart = data.cart;
        console.log("replacing old carts by new");
        this.md5sum = data.md5sum;
        this.metadata = newCart.metadata;
        this.carts = newCart.carts;
        this._redraw();
    };
    /** @private */
    Cart.prototype._compareCarts = function(data) {
        var newCart = data.cart;
        if (this.md5sum !== data.md5sum) {
            console.log("md5sums differ: " + this.md5sum + " vs " + data.md5sum);
            this.md5sum = data.md5sum;
            this.sync({
                action: 'fullSync'
            }, {});
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
Cart.prototype._getCartForContext = function(context) {
    if (typeof context === 'undefined')
        context = this.currentContext;
    if (typeof this.carts[context] === 'undefined')
        this.carts[context] = this.emptyCartPrototype;
    return this.carts[context];
};
/** @private */
Cart.prototype._getMetadataForContext = function(context) {
    if (typeof context === 'undefined')
        context = this.currentContext;
    if (typeof this.metadata[context] === 'undefined')
        this.metadata[context] = {};
    return this.metadata[context];
};
/** @private */
Cart.prototype._getGroup = function(groupname, context) {
    if (typeof context === 'undefined')
        context = this.currentContext;
    return this._getCartForContext(context)[groupname];
};
/** @private */
Cart.prototype._getGroupNode = function(groupname) {
    return this.options.rootNode.find('.cartGroup[data-name="' + groupname + '"]');
};
var itemsToShow = 15;
/** @private */
Cart.prototype._getItemDetails = function(ids, callback) {
    var that = this;
    var missingIDs = [];
    var newCartitems = {};
    var retArray = [];
    var dfd = $.Deferred();
    $.each(that._getMetadataForContext(), function(id, meta) {
        if (typeof that.cartitems[id] !== 'undefined') {
            that.cartitems[id].metadata = meta;
        }
    });
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
//hier "processing" einblenden
        $('body').css('cursor', 'wait');
        $.ajax({
            url: this.options.serviceNodes.itemDetails,
            data: {
                terms: missingIDs
            },
            type: 'POST',
            dataType: 'JSON',
            success: function(data) {
                $.each(data.results, function() {
                    var id = this.feature_id;
                    var itemDetails = $.extend(true, this, {
                        metadata: that._getMetadataForContext()[id] || {}
                    });
                    that.cartitems[id] = itemDetails;
                    $.extend(newCartitems[id], itemDetails);
                });
                callback(retArray);
                dfd.resolve();
            },
            complete: function() {
//hier fertig - "processing" ausblenden
                $('body').css('cursor', 'default');
            }
        });
    }
    return dfd.promise();
};
/** @private */
Cart.prototype._getItemNodes = function(id, groupname) {
    if (typeof groupname === 'undefined')
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
        context: this.currentContext,
        addToDOM: true,
        afterDOMinsert: this.options.callbacks.afterDOMinsert_item,
        sync: true
    }, options);
    var that = this;
    var missingIds = _.difference(ids, that._getCartForContext(options.context)[options.groupname || []]);
    var showItems = missingIds;
    if (missingIds.length > itemsToShow) {
        showItems = missingIds.slice(0, itemsToShow);
    }

    if (missingIds.length === 0) {
// we have nothing to do. return from here.
        dfd.resolve();
        return dfd.promise();
    }

    work();
    return dfd.promise();
    function work() {
        that._getItemDetails(showItems, function(aItemDetails) {
            console.log(aItemDetails);
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
        var group = this._getGroup(options.groupname, options.context);
        if (typeof group === "undefined")
            group = this._getGroup(this.addGroup(options.groupname, {context: options.context, sync: false}), options.context);
        for (var i = 0; i < ids.length; i++)
            if (_.indexOf(group, ids[i]) === -1)
                group.push(ids[i]);
    }

    function addToDOM(aItemDetails) {
        $('body').css('cursor', 'default');
        var group$ = that._getGroupNode(options.groupname);
        var group = that._getGroup(options.groupname);
        group$.find('.numelements').html('(' + group.length + ')');
        var full_placeholder = $('li.cartFullText', group$);
        $.each(aItemDetails, function(key, itemDetails) {

            if (group$.is(':has(li.cartItem[data-id="' + itemDetails.feature_id + '"])')) {
                return;
            }


            var item$ = that._executeTemplate$('Item', {
                item: itemDetails
            });
            item$.data('afterDOMinsert', options.afterDOMinsert);
            group$.find('.elements .placeholder').remove();
            if (full_placeholder.length !== 0) {
                full_placeholder.before(item$);
            }
            else {
                group$.find('.elements').append(item$);
            }
            options.afterDOMinsert.call(item$);
        });
        if (group.length > itemsToShow) {
            if (full_placeholder.length === 0) {
                full_placeholder = $('<li class="cartFullText" style="clear:both" onclick="window.location = \'/graphs/' + options.groupname + '\'"></li>');
                full_placeholder.css('cursor', 'pointer');
                group$.find('.elements').append(full_placeholder)
            }
        }
        full_placeholder.text('There are ' + (group.length - group$.find(".elements").children("li").length + 1) + " more items (go to cart)");
    }

};
//comment: get all cart items with metadata

/*
 var groupData = $.map(cart._getGroup('all'),function(){
 return cart.cartitems[this];
 });
 */

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
        if (afterDOMinsert === null)
            return;
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
    var that = this;
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
        var group = this._getGroup(options.groupname);
        var index;
        if ((index = _.indexOf(group, id)) >= 0)
            group.splice(index, 1);
        that._item_removed(id);
    }

    function removeFromDOM() {
        this._getItemNodes(id, options.groupname).remove();
        var group$ = that._getGroupNode(options.groupname);
        var group = that._getGroup(options.groupname);
        group$.find('.numelements').html('(' + group.length + ')');
    }
};
Cart.prototype._item_removed = function(id) {
    var inothercart = false;
    $.each(cart, function(key, value) {
        inothercart |= _.indexOf(value, id) >= 0;
    });
    if (!inothercart) {
        delete this.cartitems[id];
    }
}

/**
 * Adds a new group to the cart
 * @param {String} groupname
 * @param {Collection} [options]
 * @param {bool} [options.sync] sync?
 */
Cart.prototype.addGroup = function(groupname, options) {
    options = $.extend({
        sync: true,
        context: this.currentContext
    }, options);
    if (typeof options.afterDOMinsert === 'undefined') {
        options.afterDOMinsert = this.options.callbacks.afterDOMinsert_group;
    }


    var lastGroupNumber = 0;
    //if we did not recevie a group name, generate a new unused one
    if (typeof groupname === 'undefined')
        do {
            groupname = this.options.groupNamePrefix + (++lastGroupNumber);
        } while (typeof this._getGroup(groupname, options.context) !== 'undefined');
    //create a group if we need to
    if (typeof this._getGroup(groupname, options.context) === 'undefined') {
        addInternal.call(this);
        if (options.context === this.currentContext)
            addToDOM.call(this);
        this.sync({
            action: 'addGroup',
            groupname: groupname
        }, options);
    }
    return groupname;
    function addInternal() {
        this._getCartForContext(options.context)[groupname] = [];
    }

    function addToDOM() {
        var parent$ = this.options.rootNode;
        var group$;
        group$ = this._executeTemplate$('Group', {
            groupname: groupname
        });
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
        var cft$ = oldGroup$.find('.cartFullText');
        var newGroup$ = this._executeTemplate$('Group', {
            groupname: newname
        });
        var afterDOMinsert = oldGroup$.data('afterDOMinsert');
        newGroup$.data('afterDOMinsert', afterDOMinsert);
        newGroup$.find('.elements').append(items$);
        if (newGroup$.find(".elements").children("li").length >= 1) {
            newGroup$.find('.placeholder').remove();
        }
        if (typeof cft$ !== 'undefined') {
            newGroup$.find('.elements').append(cft$);
        }
        oldGroup$.replaceWith(newGroup$);
        afterDOMinsert.call(newGroup$);
        var numOfElements = this._getGroup(newname).length;
        newGroup$.find('.numelements').html('(' + numOfElements + ')');
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
        sync: true,
        context: this.currentContext
    }, options);
    var that = this;
    removeInternal.call(this);
    removeFromDOM.call(this);
    this.sync({
        action: 'removeGroup',
        groupname: groupname
    }, options);
    function removeInternal() {
        var oldgroup = this._getCartForContext()[groupname];
        delete this._getCartForContext()[groupname];
        $.each(oldgroup, function() {
            that._item_removed(this);
        });
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
    this.cartitems.length = 0;
    delete this.carts[this.currentContext];
    this.sync({
        action: 'clear'
    }, options);
    this.updateContext(this.currentContext, {
        force: true
    });
};
/**
 * Removes everything from all contexts
 * @param {Collection} [options]
 * @param {bool} [options.sync] sync?
 */
Cart.prototype.clearAll = function(options) {
    options = $.extend({
        sync: true
    }, options);
    this.cartitems.length = 0;
    this.carts = {};
    this.sync({
        action: 'clearAll'
    }, options);
    this.updateContext(this.currentContext, {
        force: true
    });
};
/**
 * Get all items from a given group, in the format {"carts":{context:{name:[id,...],...},...},"metadata":{id:{"alias":alias,"annotation":annotation},...}}
 * @param {String} groupname
 * @returns {Array}
 */
Cart.prototype.exportGroup = function(groupname) {
    var result = {carts: {}, metadata: {}};
    var group = this._getGroup(groupname) || [];
    result.carts[this.currentContext] = {};
    result.metadata[this.currentContext] = {};
    result.carts[this.currentContext][groupname] = group;
    for (var i = 0; i < group.length; i++) {
        var meta = (this._getMetadataForContext()[group[i]] || {});
        if (!_.isEmpty(meta)) {
            result.metadata[this.currentContext][group[i]] = meta;
        }
    }
    return result;
};
/**
 * Get all items from all groups, in the format {"carts":{context:{name:[id,...],...},...},"metadata":{id:{"alias":alias,"annotation":annotation},...}}
 * @param {String} groupname
 * @returns {Array}
 */
Cart.prototype.exportAllGroups = function() {
    return {carts: this.carts, metadata: this.metadata};
};
/**
 * Get all items from all groups for a given context, in the format {"carts":{context:{name:[id,...],...},...},"metadata":{id:{"alias":alias,"annotation":annotation},...}}
 * @param {String} groupname
 * @returns {Array}
 */
Cart.prototype.exportAllGroupsOfCurrentContext = function(context) {
    if (typeof context === 'undefined')
        context = this.currentContext;
    var result = {carts: {}, metadata: {}};
    result.metadata[context] = this._getMetadataForContext(context);
    result.carts[context] = this._getCartForContext(context);
    return result;
};
/**
 * Imports passed Array items as new/existing Groups to the cart. 
 * @param {Array} items {"carts":{context:{name:[id,...],...},...},"metadata":{id:{"alias":alias,"annotation":annotation},...}}
 * @param {Collection} options
 * @param {Enum(keep|merge|overwrite)} [metadata_conflict='keep',group_conflict='keep'] defaults to keep
 */
Cart.prototype.importGroups = function(items, options) {
// disable autoSync for the import time to prevent intermediate results to be overwritten
    this.autoSync = false;
    options = $.extend({
        group_conflict: 'keep',
        metadata_conflict: 'keep'
    }, options);
    this.importMetadata(items.metadata, options);
    var that = this;
    $.each(items.carts, function(context, carts) {
        $.each(carts, function(name, cart) {
            that.importGroup({context: context, name: name, items: cart}, options);
        });
    });
    // reenable autoSync
    this.autoSync = true;
};
/**
 * Imports passed Array items as new/existing Group to the cart. 
 * @param {Array} items {context: context, name: name, items:[id, ...]}
 * @param {Collection} options
 * @param {Enum(keep|merge|overwrite)} [group_conflict='keep'] defaults to keep
 */
Cart.prototype.importGroup = function(items, options) {
    options = $.extend({
        group_conflict: 'keep'
    }, options);
    var that = this;
    if (typeof this._getGroup(items.name, items.context) !== 'undefined') {
        if (options.group_conflict === 'keep')
            console.log(items.name + " already exists in context " + items.context + " ... skipping.");
        else if (options.group_conflict === 'merge') {
            console.log(items.name + " already exists in context " + items.context + " ... merging.");
            var addDOM = (items.context === this.currentContext);
            this.addItem(items.items, {groupname: items.name, context: items.context, addToDOM: addDOM});
        }
        else {
            console.log(items.name + " already exists in context " + items.context + " ... replacing.");
            this.removeGroup(items.name, {context: items.context, customCallback: function() {
                    var addDOM = (items.context === this.currentContext);
                    that.addItem(
                            items.items, {groupname: items.name, context: items.context, addToDOM: addDOM})
                }
            });
        }
    }
    else {
// Group is automatically added if it does not exist.
        var addDOM = (items.context === this.currentContext);
        this.addItem(items.items, {groupname: items.name, context: items.context, addToDOM: addDOM});
    }
};
/**
 * Imports passed Array items as metadata.
 * @param {Array} items {id: {alias: string, annotations:string}, ...}
 * @param {Collection} options
 * @param {Enum(keep|merge|overwrite)} [metadata_conflict='keep'] defaults to keep
 */
Cart.prototype.importMetadata = function(items, options) {
    options = $.extend({
        metadata_conflict: 'keep'
    }, options);
    var that = this;
    $.each(items, function(context, meta) {
        $.each(meta, function(key, value) {
            switch (options.metadata_conflict) {
                case 'keep':
                    break;
                case 'merge':
                    var new_metadata = $.extend({}, value, that._getMetadataForContext(context)[key]);
                    if (!_.isEqual(new_metadata, that._getMetadataForContext(context)[key]))
                        that.updateItem(key, new_metadata);
                    break;
                case 'overwrite':
                    if (!_.isEqual(value, that._getMetadataForContext(context)[key]))
                        that.updateItem(key, value);
                    break;
            }
        });
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