function Cart(options){
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
            afterDOMinsert_groupAll:function(){},
            afterDOMinsert_group:function(){},
            afterDOMinsert_item:function(){}
        },
        parentNode: '#Cart',
        groupNamePrefix: 'Group'
    };
    $.extend(true, this.options, options);
        
    this.carts = {};
    this.cartitems = {};
    this.currentContext = null;
    this.updateContext('unknown');
}

    

Cart.prototype._getTemplate = _.memoize(function(templateName){
    return _.template($(this.options.templates[templateName]).html());
});

Cart.prototype._executeTemplate$ = function(templateName){
    var template = this._getTemplate(templateName);
    var templateArguments = Array.prototype.slice.call(arguments, 1);
    return $('<div/>').append(template.apply(window, templateArguments)).children();
};

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
    var that=this;
    if (typeof this.cartitems[id] !== 'undefined')
        callback(this.cartitems[id]);
    else
        $.ajax({
            url:this.options.serviceNodes.itemDetails+id,
            dataType: 'JSON',
            success: function(itemDetails){
                that.cartitems[id] = itemDetails;
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
    this._redraw();
};    

Cart.prototype._redraw = function(){
    $(this.options.parentNode).empty();
    var cart = _.clone(this._getCartForContext());
    var cartToEmpty = this._getCartForContext();
    for (var key in cartToEmpty){
        if (cartToEmpty.hasOwnProperty(key))
            delete cartToEmpty[key];
    }
    var that = this;
    
    $.each(cart, function(groupname, group){
        that.addGroup(groupname, {
            sync: false
        });
        for (var i=0; i<group.length; i++)
            that.addItem(group[i], {
                groupname: groupname,
                sync: false
            });
    })
}

Cart.prototype.addItem = function(id, options){
    //make sure we don't have a string id'
    id = parseInt(id);
    console.log(arguments);
    options = $.extend({
        groupname: 'all',
        addToDOM: true,
        afterDOMinsert: this.options.callbacks.afterDOMinsert_item,
        sync: true
    }, options);

    
    var that = this;
    
    if (options.groupname != 'all' && _.indexOf(this._getCartForContext()['all'], id)==-1)
        this.addItem(id, $.extend({},options,{
            groupname:'all'
        }));

    this._getItemDetails(id, function(itemDetails){
        if (addInternal.call(that, itemDetails) && options.addToDOM)
            addToDOM.call(that, itemDetails);
    });
    
    function addInternal (itemDetails){
        var group = this._getGroup(options.groupname);
        if (typeof group === undefined)
            group = this.addGroup(options.groupname);
        if (_.indexOf(group, id) >= 0)
            return false;
        group.push(id);
        return true;
    }
    
    function addToDOM(itemDetails){
        var group$ = this._getGroupNode(options.groupname);
        var item$ = this._executeTemplate$('Item', {
            item:itemDetails
        });
        item$.data('afterDOMinsert', options.afterDOMinsert);
        group$.find('.elements .placeholder').remove();
        group$.find('.elements').append(item$);
        options.afterDOMinsert.call(item$);
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
        var newItem$ = this._executeTemplate$('Item',itemDetails);
        var afterDOMinsert = items$.data('afterDOMinsert');
        newItem$.data('afterDOMinsert', afterDOMinsert);
        items$.replaceWith(newItem$);
        afterDOMinsert.apply(newItem$);
    }
    
};
    
Cart.prototype.removeItem = function(id, options){
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
    if (typeof options.afterDOMinsert == 'undefined'){
        
        if (groupname=='all')
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
    if (typeof this._getGroup(groupname) === 'undefined'){
        addInternal.call(this) ;
        addToDOM.call(this);
    }
    return this._getGroup(groupname);

    function addInternal (){
        this._getCartForContext()[groupname] = [];
    }
    
    function addToDOM(){
        var parent$ = $(this.options.parentNode);
        var group$;
        if (groupname === 'all'){
            group$ = this._executeTemplate$('GroupAll');
        } else {
            group$ = this._executeTemplate$('Group',{
                groupname:groupname
            });
        }
        group$.data('afterDOMinsert', options.afterDOMinsert);
        parent$.append(group$);
        options.afterDOMinsert.call(group$);
    }
};

Cart.prototype.renameGroup = function(oldname, newname, options){
    options = $.extend({
        sync: true
    }, options);
    
    if (oldname == newname)
        return;
    
    if (this._getGroup(newname) !== undefined){
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
        var newGroup$ = this._executeTemplate$('Group',{
            groupname:newname
        });
        var afterDOMinsert = oldGroup$.data('afterDOMinsert');
        newGroup$.data('afterDOMinsert', afterDOMinsert);
        newGroup$.find('.elements').append(items$);
        oldGroup$.replaceWith(newGroup$);
        afterDOMinsert.call(newGroup$);
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