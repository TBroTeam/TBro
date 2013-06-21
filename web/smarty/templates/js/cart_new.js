function Cart(options){
    this.options = {
        templates: {
            GroupAll: '#template_cart_all_cart',
            Group: '#template_cart_new_cart',
            Item: '#template_cart_new_item'
        },
        serviceNodes: {
            itemDetails: '{#$ServicePath#}/cart/itemDetails'
        },
        parentNode: '#Cart',
        groupNamePrefix: 'Group'
    };
    $.extend(true, this.options, options);
        
    this.carts = {};
    this.cartitems = {};
    this.currentContext = 'unknown';
}

    

Cart.prototype._getTemplate = _.memoize(function(templateName){
    return _.template($(this.options.templates[templateName].html()));
});

Cart.prototype._getCartForContext = function(){
    return this.carts[this.currentContext];
};

Cart.prototype._getGroup = function(groupname) {
    return this._getCartForContext()[groupname];
};

Cart.prototype._getGroupNode = function(groupname){
    return $(this.options.parentNode).find('.cartGroup[data-name="'+groupname+'"]');
};

Cart.prototype._getItemDetails = function(id, callback){
    if (typeof this.cartitems[id] !== 'undefined')
        callback(this.cartitems[id]);
    else
        $.ajax({
            url:this.serviceNodes.itemDetails,
            data: {
                id: id
            },
            dataType: 'JSON',
            success: function(itemDetails){
                this.cartitems[id] = itemDetails;
                callback(itemDetails);
            }
        });
};

Cart.prototype._getItemNodes = function(id, groupname){
    if (typeof groupname === undefined || groupname === 'all')
        return $(this.options.parentNode).find('.cartItem[data-id="'+id+'"]');
    else
        return this._getGroupNode(groupname).find('.cartItem[data-id="'+id+'"]');
}
    
Cart.prototype.updateContext = function(newContext, force){
    if (this.currentContext == newContext && !force)
        //nothing to do
        return;
    this.currentContext = newContext;
    if (typeof this.carts[newContext] === 'undefined')
        this.carts[newContext] = {
            'all': []
        };
    
//TODO redraw
};    

Cart.prototype.addToCart = function(id, options){
    options = $.extend({
        groupname: 'all',
        sync: true
    }, options);
    var that = this;

    this._getItemDetails(id, function(itemDetails){
        if (addInternal.call(that, itemDetails))
            addToDOM.call(that, itemDetails);
    });
    
    function addInternal (itemDetails){
        var group = getGroup(options.groupname);
        if (typeof group === undefined)
            group = this.addGroup(options.groupname);
        if (_.indexOf(group, id) >= 0)
            return false;
        group.push(id);
        return true;
    }
    
    function addToDOM(itemDetails){
        var group$ = this._getGroupNode();
        var item$ = this._getTemplate('Item')(itemDetails);
        group$.append(item$);
    }
};
    
Cart.prototype.updateItem = function(id, metadata, options){
    options = $.extend({
        sync: true
    }, options);
    var that = this;
    
    this._getItemDetails(id, function(itemDetails){
        if (updateInternal.call(that, itemDetails))
            updateDOM.call(that, itemDetails);
    });
    
    function updateInternal(itemDetails){
        if (_.isEqual(itemDetails.metadata, metadata))
            return false;
        $.extend(itemDetails.metadata, metadata);
        return true;
    }
        
    function updateDOM(itemDetails){
        var items$ = this._getItemNodes(id);
        items$.replaceWith(this._getTemplate('Item')(itemDetails));
    }
    
};
    
Cart.prototype.removeFromCart = function(id, options){
    options = $.extend({
        groupname: 'all',
        sync: true
    }, options);

    removeInternal.call(this);
    removeFromDOM.call(this);
    
    function removeInternal (){
        var cart = this._getCartForContext();
        if (options.groupname == all){
            $.each(cart, function(){
                var index;
                if ((index=_.indexOf(this, id))>=0)
                    this.splice(index,1);
            });
            delete this.cartitems[id];
        } else {
            var group = this._getGroup(options.groupname);
            var index;
            if ((index=_.indexOf(group, id))>=0)
                group.splice(index,1);
        }
    }
    
    function removeFromDOM(){
        this._getItemNodes(id, options.groupname).remove();
    }   
};

Cart.prototype.addGroup = function(groupname, options){
    options = $.extend({
        sync: true
    }, options);
    var lastGroupNumber = 0;
        
    //if we did not recevie a group name, generate a new unused one
    if (typeof groupname === 'undefined')
        do {
            groupname = this.options.groupNamePrefix + (++lastGroupNumber);
        } while (typeof getGroup(groupname) !== 'undefined');

    //create a group if we need to
    if (typeof getGroup(groupname) === undefined){
        addInternal.call(this) ;
        addToDOM.call(this);
    }
    return getGroup(groupname);

    function addInternal (){
        this._getCartForContext()[groupname] = [];
    }
    
    function addToDOM(){
        var parent$ = $(this.options.parentNode);
        var group$;
        if (groupname === 'all'){
            group$ = this._getTemplate('GroupAll')();    
        } else {
            group$ = this._getTemplate('Group')(groupname);
        }
        parent$.append(group$);
    }
};

Cart.prototype.renameGroup = function(oldname, newname, options){
    options = $.extend({
        sync: true
    }, options);
    
    if (this.getGroupByName(newname) !== undefined){
        throw new Error("Cart with this name already exists!");
    }
    
    renameInternal.call(this) ;
    renameInDOM.call(this);
    
    function renameInternal (){
        var cart = this._getCartForContext();
        var group = cart[oldname];
        cart[newname] = group;
        delete cart[oldname];
    }
    
    function renameInDOM(){
        var oldGroup$ = this._getGroupNode(oldname);
        var items$ = oldGroup$.find('.cartItem');
        var newGroup$ = this._getTemplate('Group')(newname);
        newGroup$.append(items$);
        oldGroup$.replaceWith(newGroup$);
    }
};

Cart.prototype.removeGroup = function(groupname, options){
    options = $.extend({
        sync: true
    }, options);

    removeInternal.call(this);
    removeFromDOM.call(this);
    
    function removeInternal (){
        delete this._getCartForContext()[groupname];
    }
    
    function removeFromDOM(){
        this._getGroupNode(groupname).remove();
    }
};

Cart.prototype.clear = function(){
    options = $.extend({
        sync: true
    }, options);

    delete this.carts[this.currentContext];
    this.updateContext(this.currentContext, true);
}