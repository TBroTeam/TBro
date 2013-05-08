{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
<script type="text/javascript">
    var actions = null;
var searchtbl = null;
    
function addRow(actionname){
    var action = actions[actionname];
    console.log(action);
    var i = searchtbl.children().size() + 1;
    var selector = $('<select />');
    var item;
    $.each(action.selectors, function(){
        $('<option />').val(this).text(this).appendTo(selector);
    });
    if (action.type === 'select'){
        item = $('<select />');
        $.each(action.options, function(){
            $('<option/>').val(this).text(this).appendTo(item);
        });
    } else if (action.type === 'input'){
        item = $('<input type="text"/>');
        if (action.regex != undefined)
            item.data('validator', new RegExp(action.regex));
    }
        
    selector.attr('name', 'selector['+i+']');
    item.attr('name', 'item['+i+']');
        
    var line = $('<tr/>');
    if (action.required==='required')
        line.append($('<td/>'));
    else
        line.append($('<td/>').append($('<span>X</span>').click(function(){line.remove();})));
    line.append($('<td/>').text(actionname));
    line.append($('<td/>').append(selector));
    line.append($('<td/>').append(item));
    line.appendTo(searchtbl);
}
    
$(document).ready(function(){
    searchtbl = $('#searchtbl');
    var newvalues = $('#newvalues');
        
    $.ajax('{#$ServicePath#}/advancedsearch/actions', {
        success: function(data){
            actions = data.actions;
            $.each(actions, function(key, val){
                if (val.required==='required'){
                    addRow(key);
                } else
                newvalues.append($('<option/>').text(key).val(key));
            });
        }
    });
});
</script>
{#/block#}

{#block name='body'#}
<div class="row">
    <div class="large-12 columns panel">
        <div class="row">
            <div class="large-12 columns">
                <a href="javascript:addRow($('#newvalues').val());" class="small button">add Filter</a>
                <select id="newvalues" style="width:300px"></select>
            </div>
        </div>
        <div class="row">
            <div class="large-12 columns">
                <table style="padding:0px; margin:0px; width: 100%">
                    <tbody id="searchtbl"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{#/block#}