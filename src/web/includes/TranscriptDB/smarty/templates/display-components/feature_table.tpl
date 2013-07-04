<script type="text/javascript">
    function displayFeatureTable(data, opts) {
        var options = $.extend(true, {
            aoColumns: [
                {mData: 'type'},
                {mData: 'name'},
                {mData: 'alias'}
            ],
            fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                console.log($(nRow).find('td:eq(1)').html());
                $(nRow).find('td:eq(1)').html('<a target="_blank" href="{#$AppPath#}/details/byId/' + aData.feature_id + '">' + aData.name + '</a>');
                $(nRow).css('cursor', 'pointer');
            },
            sDom: 'T<"clear">lfrtip',
            oTableTools: {
                sRowSelect: "multi",
                aButtons: []
            },
            aaData: []
        }, opts);
        $.each(data, function() {
            options.aaData.push(this);
        });
        console.log(options);
        $('.results').show(500);
        var tbl = $('#results');
        if (!$.fn.DataTable.fnIsDataTable(tbl.get(0)))
            tbl.dataTable(options);
        else {
            //table already exists, refresh table. if "selectedItem" has changed, this will load new data.
            tbl.dataTable().fnClearTable();
            var dataArray = [];
            $.each(data, function() {
                dataArray.push(this);
            });
            tbl.dataTable().fnAddData(dataArray);
        }
    }

    (function($) {
        $(document).ready(function() {
            $('#add_selected').click(function() {
                var groupname = $('#select-group').val();
                if (groupname === '#new#') {
                    groupname = cart.addGroup();
                }

                cart.addItem($.map(TableTools.fnGetInstance('results').fnGetVisibleSelectedData(), function(val) {
                    return val.feature_id;
                }), {groupname: groupname});

            });

            $('#results').tooltip({
                items: ".has-tooltip",
                open: function(event, ui) {
                    ui.tooltip.css("max-width", "600px");
                },
                content: function() {
                    var that = this;
                    var tooltip = $("<table/>");
                    $.ajax({url: '{#$ServicePath#}/details/cartitem/' + $(that).attr('data-id'), success: function(data) {
                            $.each(data, function(name, value) {
                                $("<tr><td>" + name + "</td><td>" + value + "</td></tr>").appendTo(tooltip);
                            });
                        }});

                    tooltip.foundation();
                    return tooltip;
                }
            });

            new Groupselect($('#select-group'), cart);
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
    <a class="has-tooltip" data-id="<%= feature_id %>" href="{#$AppPath#}/details/byId/<%= feature_id %>"><%= name %></a>
    </td>
    <td data-id="<%= feature_id %>">
    <span><% if (typeof alias != "undefined" ) print(alias) %></span>
    </td>
    <td>
    <span style="margin-bottom:0px" class="small button right"  onclick="javascript:cart.addItem(<%= feature_id %>);"> add to cart -> </span>
    </td>
    </tr>
</script>
<div class="row">
    <div class="large-12 column">
        <table style="width:100%" id="results">
            <thead>
                <tr>
                    <td>Type</td>
                    <td>Name</td>
                    <td>Alias</td>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td colspan="3">
                        <span class="left" style="vertical-align: bottom">
                            <a style="margin-bottom:0px" class="small button" href="javascript:TableTools.fnGetInstance('results').fnSelectAll();">select all</a>
                            <a style="margin-bottom:0px" class="small button" href="javascript:TableTools.fnGetInstance('results').fnSelectNone();">select none</a>
                            <span>click a row to select</span>
                        </span>
                        <span class="right">
                            <span style="margin-bottom:0px" class="small button" id="add_selected"> add selected to cart -> </span>
                            <select style="width:auto" id="select-group" ><option class="keep" value='#new#'>new</option></select>
                        </span>
                    </td>
                </tr>
            </tfoot>
            <tbody>
            </tbody>
        </table>
    </div>
</div>