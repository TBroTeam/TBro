<?php /* Smarty version Smarty-3.1.13, created on 2013-06-05 17:12:12
         compiled from "C:\Users\mail_000\Dropbox\uni\bio\s202139\web\smarty\templates\js\filteredSelect.js" */ ?>
<?php /*%%SmartyHeaderCode:3183551af554c976d81-97328445%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '95c13400236e967e16320873f009c91395d8d7f1' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\js\\filteredSelect.js',
      1 => 1370435050,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3183551af554c976d81-97328445',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51af554c9b5871_99504850',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51af554c9b5871_99504850')) {function content_51af554c9b5871_99504850($_smarty_tpl) {?>filteredSelect = function(jqNode, filterProperty, options){
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

filteredSelect.prototype.getPrecedessor =function(){
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
    
<?php }} ?>