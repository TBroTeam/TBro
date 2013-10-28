<script type="text/javascript">
    function displayCartTable(data, opts) {
        var options = $.extend(true, {
            bProcessing: true,
            bServerSide: true,
            sAjaxSource: "{#$ServicePath#}/listing/cart_table",
            "fnServerParams": function(aoData) {
                aoData.push({"name": "terms", "value": data});
            },
            fnServerData: function(sSource, aoData, fnCallback, oSettings) {
                oSettings.jqXHR = $.ajax({
                    "dataType": 'json',
                    "type": "POST",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                });
            },

            //     bLengthChange: false,
            //     sPaginationType: "full_numbers",
                 aoColumns: [
                     {mData: 'type'},
                     {mData: 'name'},
                     {mData: 'alias'}
                 ]
            //     fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            //         console.log($(nRow).find('td:eq(1)').html());
            //         $(nRow).find('td:eq(1)').html('<a target="_blank" href="{#$AppPath#}/details/byId/' + aData.feature_id + '">' + aData.name + '</a>');
            //         $(nRow).css('cursor', 'pointer');
            //     },
            //     sDom: 'T<"clear">lrtip',
            //     oTableTools: {
            //         sRowSelect: "multi",
            //         aButtons: []
            //     },
            //     aaData: []
        }, opts);
        // $.each(data, function() {
        //     options.aaData.push(this);
        // });
        console.log(options);
        var tbl = $('#carttable');
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

                cart.addItem($.map(TableTools.fnGetInstance('carttable').fnGetVisibleSelectedData(), function(val) {
                    return val.feature_id;
                }), {groupname: groupname});

            });

            new Grouplist($('#button-features-addToCart-options'), cart, addSelectedToCart);
            $('#button-features-addToCart-options-newcart').click(addSelectedToCart);

            $("#input-filter-carttable").keyup(function() {
                fnFilter();
            });
        });
    })(jQuery);

    function fnNumOfEntries(numOfEntries)
    {
        /* Get the DataTables object again - this is not a recreation, just a get of the object */
        var oTable = $('#carttable').dataTable();
        var oSettings = oTable.fnSettings();
        oSettings._iDisplayLength = numOfEntries;
        oTable.fnDraw();
    }

    function fnFilter() {
        var oTable = $('#carttable').dataTable();
        oTable.fnFilter($("#input-filter-carttable").val());
    }

    function addSelectedToCart() {
        var group = $(this).attr('data-value');
        var selectedItems = TableTools.fnGetInstance('carttable').fnGetSelectedData();
        if (selectedItems.length === 0)
            return;
        if (group === '#new#')
            group = cart.addGroup();
        cart.addItem($.map(selectedItems, function(val) {
            return val.feature_id;
        }), {
            groupname: group
        });

    }
</script>

<div class="row">
    <div class="large-9 columns">        
        <ul class="button-group even-3">
            <li><button class="small button dropdown" id="show-entries-dropdown" data-dropdown="show-entries-dropdown-options"> Show Entries </button></li>
            <li><button class="small button dropdown" data-dropdown="select-all-none-dropdown">Select</button></li>
            <li><button class="small button dropdown" type="button" id="button-features-addToCart" data-dropdown="button-features-addToCart-options"> Store </button></li>
        </ul>

        <ul class="f-dropdown" id="show-entries-dropdown-options" data-dropdown-content>
            <li onclick="fnNumOfEntries(10);"> 10 </li> 
            <li onclick="fnNumOfEntries(20);"> 20 </li> 
            <li onclick="fnNumOfEntries(50);"> 50 </li> 
            <li onclick="fnNumOfEntries(100);"> 100 </li> 
            <li onclick="fnNumOfEntries(1000);"> 1000 </li> 
        </ul>
        <ul id="select-all-none-dropdown" class="f-dropdown" data-dropdown-content>
            <li onclick="TableTools.fnGetInstance('carttable').fnSelectAll();" style="width:100%">All visible</li>
            <li onclick="TableTools.fnGetInstance('carttable').fnSelect($('#carttable').dataTable().$('tr', {'filter': 'applied'}));" style="width:100%">Filtered</li>
            <li onclick="TableTools.fnGetInstance('carttable').fnSelectNone();" style="width:100%">None</li>
        </ul>
        <ul id="button-features-addToCart-options" class="f-dropdown" data-dropdown-content>
            <li id="button-features-addToCart-options-newcart" class="keep" data-value="#new#">new</li>
        </ul>
    </div>
    <div class="large-3 columns" style="padding-top: 6px">
        <label>Filter: <input id="input-filter-carttable">  </input></label>
    </div>
    <div class="large-12 column">
        <table style="width:100%" id="carttable">
            <thead>
                <tr>
                    <td>Type</td>
                    <td>Name</td>
                    <td>Alias</td>
                </tr>
            </thead>
            <tfoot></tfoot>
            <tbody>
            </tbody>
        </table>
    </div>
</div>