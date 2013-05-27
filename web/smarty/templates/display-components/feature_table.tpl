<script type="text/javascript">
    var datatable = null;
    
    function displayFeatureTable(data, opts){
        var options = $.extend(true, {
            aoColumns: [
                {bSortable: false},
                {},
                {},
                {bSortable: false}
            ]
        }, opts);
        console.log(options);
        var res = $('#results tbody');
        res.empty();
        var cnt=0;
        var template = _.template($('#result-template').html());
        $.each(data, function(){
            res.append(template(this));
            cnt++;
        });
        if (cnt>0){
            $('.results').show(500);
            if (datatable == null)
                datatable = $('#results').dataTable(options);
        }
    }
    
    (function($){
        $(document).ready(function(){
            $('#add_selected').click(function(){
                $('#results tbody').find('input:checked').each(function(){
                    $.ajax({url:'{#$ServicePath#}/details/cartitem/'+$(this).val(), success: cart.addItemToAll});
                });
            });
            
            $('#compare_selected').click(function(){
                var cartname = cart.addGroup({});
                var calls = [];
                var checkboxes = $('#results tbody').find('input:checked');
                if (checkboxes.length==0) return;
                var count_finished = 0;
                checkboxes.each(function(){
                    calls.push(
                    $.ajax({url:'{#$ServicePath#}/details/cartitem/'+$(this).val(), success: function(data){
                            cart.addItemToAll(data);
                            cart.addItemToGroup(data, cartname, {})
                            //all ajax calls & callbacks have finished, we can continue to the graph page
                            if (++count_finished == checkboxes.length){
                                window.location = '{#$AppPath#}/graphs/'+cartname;
                            }
                        }}));
                });
            });
            $('#check_all').prop('checked',false);
            $('#check_all').click(function(){
                $('#results tbody').find('input[type="checkbox"]').prop('checked',$(this).prop('checked')); 
            });
        });
    })(jQuery);

</script>


<script type="text/template" id="result-template">
    <tr>
        <td>
            <input type="checkbox" value="<%= feature_id %>"/>
        </td>
        <td>
            <span><%= type %></span>
        </td>
        <td data-id="<%= feature_id %>">
            <a href="{#$AppPath#}/details/byId/<%= feature_id %>"><%= name %></a>
        </td>
        <td>
            <span style="margin-bottom:0px" class="small button right"  onclick="$.ajax({url:'{#$ServicePath#}/details/cartitem/<%= feature_id %>', success: cart.addItemToAll});"> add to cart -> </span>
        </td>
    </tr>
</script>
<div class="row">
    <div class="large-12 column">
        <table style="width:100%" id="results">
            <thead>
                <tr>
                    <td></td>
                    <td>Type</td>
                    <td>Name</td>
                    <td></td>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td><input type="checkbox" id="check_all"/></td>
                    <td></td>
                    <td><span style="margin-bottom:0px" class="small button right" id="compare_selected">compare selected</span></td>
                    <td><span style="margin-bottom:0px" class="small button right" id="add_selected"> add selected to cart -> </span></td>
                </tr>
            </tfoot>
            <tbody>
            </tbody>
        </table>
    </div>
</div>