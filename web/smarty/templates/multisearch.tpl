{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
<script type="text/javascript">
    $(document).ready(function(){
        $('#start-multisearch').click(function(){
            $('.results').hide(500);
            var datatable = null;
            $.ajax({
                url: "{#$ServicePath#}/listing/multisearch/",
                data: {species: organism.val(), release: release.val(), longterm: $('#multisearch').val()},
                dataType: "json",
                success: function(data) {
                    var res = $('#results tbody');
                    var btn = $('#btn_addToCart').children().first().clone().removeAttr('id');
                    res.empty();
                    var cnt=0;
                    var template = _.template($('#result-template').html());
                    $.each(data.results, function(){
                        res.append(template(this));
                        cnt++;
                    });
                    if (cnt>0){
                        $('.results').show(500);
                        if (datatable == null)
                            datatable = $('#results').dataTable({bAutoWidth:false});
                    }
                }
            });
            $('#add_selected').click(function(){
                $('#results tbody').find('input:checked').each(function(){
                    $.ajax({url:'{#$ServicePath#}/details/cartitem/'+$(this).val(), success: cart.addItemToAll});
                });
            });
            
            $('#compare_selected').click(function(){
                var cartname = cart.addGroup({});
                var calls = [];
                var checkboxes = $('#results tbody').find('input:checked');
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
            
            $('#check_all').click(function(){
                $('#results tbody').find('input[type="checkbox"]').prop('checked',$(this).prop('checked')); 
            });
        });
    });
</script>
{#/block#}

{#block name='body'#}
<script type="text/template" id="result-template">
    <tr>
        <td>
            <input type="checkbox" value="<%= id %>"/>
        </td>
        <td>
            <span><%= type %></span>
        </td>
        <td data-id="<%= id %>">
            <a href="{#$AppPath#}/details/byId/<%= id %>"><%= name %></a>
        </td>
        <td>
            <span style="margin-bottom:0px" class="small button right"  onclick="$.ajax({url:'{#$ServicePath#}/details/cartitem/'+$(this).attr('data-id'), success: cart.addItemToAll});"> add to cart -> </span>
        </td>
    </tr>
</script>
<div class="row">
    <div class="large-12 column">
        <h1>Advanced Search</h1>
    </div>

    <div class="large-12 column">
        <p>
            This field allows you to search for as many unigenes or isoforms as you want at once. <br/>
            For every found isoform, corresponding unigene will be shown.</br>
            For each found unigene, all isoforms will be shown.<br/>
            <b>This search does not allow wildcards.</b>
        </p>
    </div>
</div>

<div class="row">
    <div class="large-8 column">
        <textarea id="multisearch" style="max-width: 100%; height: 150px"></textarea>
    </div>
    <div class="large-4 column">
        <a id="start-multisearch" class="button"/>search</a>
    </div>
</div>

<div class="results" style="display:none">
    <div class="row" >
        <div class="large-12 column">
            <h2>Results</h2>
        </div>
    </div>
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
</div>


{#/block#}