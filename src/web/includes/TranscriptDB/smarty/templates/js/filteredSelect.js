
/**
 * Created over a select item, this allows multiple selects to be coupled to each other's selections.
 * @constructor
 * @param {jQuery} jqNode html select element as jQuery node
 * @param {String} filterNode propertie this select works on
 * @param {Collection} options options
 * @param {jQuery} [options.precedessorNode] select this node depends on. either this value or options.data have to be set
 * @param {Array} [options.data] data as returned from web service /listing/filters/
 * @param {function(obj)} [options.getDisplayString] returns value to be displayed
 */
filteredSelect = function(jqNode, filterProperty, options){
    this.options = $.extend({
        precedessorNode: null,
        data: null,
        getDisplayString: function(obj){
            return obj.name;
        }
    }, options);

    this.jqNode = jqNode;
    this.filterProperty = filterProperty;
    jqNode.data('filteredSelect', this);
    
    var that = this;
    if (this.options.precedessorNode != null){
        this.options.precedessorNode.on('selectionChanged', function(){
            that.refill();
        });
    }

    jqNode.click(function(){
        jqNode.trigger('selectionChanged');
    });
}

filteredSelect.prototype.getPrecedessor = function(){
    if (this.options.precedessorNode == null)
        return null;
    return this.options.precedessorNode.data('filteredSelect');
}

filteredSelect.prototype.getNode =function(){
    return this.jqNode;
}

filteredSelect.prototype.getData = function(){
    if (this.getPrecedessor()!=null){
        return this.getPrecedessor().filteredData();
    } else {
        return this.options.data;
    }
}

filteredSelect.prototype.filteredData = function(){
    var data = this.getData();
    var ret = {
        data: data.data, 
        values: []
    };
    var selectedValues = _.map(this.jqNode.find(':selected'), function(jq){
        return jq.value+"";
    });
    
    var filterProperty = this.filterProperty;
    ret.values = _.filter(data['values'], function(value, key, list){
        return _.indexOf(selectedValues, value[filterProperty]+"")>=0;
    });
    return ret;
}

filteredSelect.prototype.refill = function(){
    var jqNode = this.jqNode;
    
    var filterProperty = this.filterProperty;
    var data = this.getData();
    var options = this.options;
    
    var duplicates = [];
    
    jqNode.empty();
    _.each(data.values, function(value, key, list){
        var id = value[filterProperty];
        if (_.indexOf(duplicates, id)>=0)
            return;
        duplicates.push(id);
        var obj = data.data[filterProperty][id];
        var item = $('<option />').attr('selected','selected').text(options.getDisplayString(obj)).val(id).data('metadata', obj);
        jqNode.append(item);
    });
    jqNode.trigger('selectionChanged');
}
    
