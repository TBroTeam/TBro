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
            bLengthChange: false,
            sPaginationType: "full_numbers",
            aoColumns: [
                {mData: 'type',
                    bSortable: false
                },
                {mData: 'name',
                    bSortable: false
                },
                {mData: 'alias',
                    bSortable: false
                }
            ],
            fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                console.log($(nRow).find('td:eq(1)').html());
                $(nRow).find('td:eq(1)').html('<a target="_blank" href="{#$AppPath#}/details/byId/' + aData.feature_id + '">' + aData.name + '</a>');
                $(nRow).css('cursor', 'pointer');
            },
            sDom: 'T<"clear">lrtip',
            oTableTools: {
                sRowSelect: "multi",
                aButtons: []
            }
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

            new Grouplist($('#button-features-addToCart-options'), cart, addSelectedToOtherCart);
            $('#button-features-addToCart-options-newcart').click(addSelectedToOtherCart);

            $("#input-filter-carttable").focus(function() {
                if ($(this).val() === 'Filter') {
                    $(this).val("");
                    $(this).attr("style", "color: black");
                }
            });
            $("#input-filter-carttable").blur(function() {
                if ($(this).val() === '') {
                    $(this).val("Filter");
                    $(this).attr("style", "color: lightgrey");
                }
            });
            $("#input-filter-carttable").keyup(function(e) {
                // only if "Enter" key pressed.
                if (e.keyCode === 13) {
                    fnFilterCart();
                }
            });
        });
    })(jQuery);

    function updateSelectedCount() {
        var selectedItems = TableTools.fnGetInstance('carttable').fnGetSelectedData();
        $('.selectedItemsCount').html('Selected ('+selectedItems.length+')');
    }

    function fnNumOfEntriesCart(numOfEntries)
    {
        /* Get the DataTables object again - this is not a recreation, just a get of the object */
        var oTable = $('#carttable').dataTable();
        var oSettings = oTable.fnSettings();
        oSettings._iDisplayLength = numOfEntries;
        oTable.fnDraw();
    }

    function fnFilterCart() {
        var oTable = $('#carttable').dataTable();
        oTable.fnFilter($("#input-filter-carttable").val());
    }

    function addSelectedToOtherCart() {
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

    function removeSelectedFromCart() {
        var selectedItems = TableTools.fnGetInstance('carttable').fnGetSelectedData();
        if (selectedItems.length === 0)
            return;
        _.each(selectedItems, function(val) {
            cart.removeItem(val.feature_id, {groupname: '{#$cartname#}'});
        });
        var oTable = $('#carttable').dataTable();
        oTable.fnReloadAjax();
    }

    function removeAllFromCart() {
        var cartitems = cart._getCartForContext()['{#$cartname#}'] || [];
        while (cartitems.length !== 0) {
            cart.removeItem(cartitems[0], {groupname: '{#$cartname#}'});
        }
        var oTable = $('#carttable').dataTable();
        oTable.fnClearTable();
    }

    // This method for providing a download file is necessary due to the lack of a standard way.
    jQuery.download = function(url, data, method) {
        //url and data options required
        if (url && data) {
            //data can be string of parameters or array/object
            data = typeof data == 'string' ? data : jQuery.param(data);
            //split params into form inputs
            var inputs = '';
            jQuery.each(data.split('&'), function() {
                var pair = this.split('=');
                inputs += '<input type="hidden" name="' + unescape(pair[0]) + '" value="' + pair[1] + '" />';
            });
            //send request
            jQuery('<form action="' + url + '" method="' + (method || 'post') + '">' + inputs + '</form>')
                    .appendTo('body').submit().remove();
        }
        ;
    };

    function exportSelected(service) {
        var selectedItems = TableTools.fnGetInstance('carttable').fnGetSelectedData();
        if (selectedItems.length === 0)
            return;
        var ids = $.map(selectedItems, function(key, val) {
            return key.feature_id;
        });
        exportIds(service, ids, '{#$cartname#}' + "_selection");
    }
    function exportAll(service) {
        var ids = cart._getCartForContext()['{#$cartname#}'] || [];
        exportIds(service, ids, '{#$cartname#}');
    }
    function exportIds(service, ids, cartname) {
        $.download(service, {
            terms: ids,
            cartname: cartname
        }, 'post');
    }
</script>

<div class="row">
    <div class="large-9 columns">        
        <ul class="button-group even-5">
            <li><button class="small button dropdown" id="show-entries-dropdown" data-dropdown="show-entries-dropdown-options"> Entries </button></li>
            <li><button class="small button dropdown" data-dropdown="select-all-none-dropdown">Select</button></li>
            <li><button class="small button dropdown" onclick="updateSelectedCount();" data-dropdown="delete-dropdown">Delete</button></li>
            <li><button class="small button dropdown" onclick="updateSelectedCount();" data-dropdown="export-dropdown">Export</button></li>
            <li><button class="small button dropdown" type="button" id="button-features-addToCart" data-dropdown="button-features-addToCart-options"> Store </button></li>
        </ul>

        <ul class="f-dropdown" id="show-entries-dropdown-options" data-dropdown-content>
            <li onclick="fnNumOfEntriesCart(10);"> 10 </li> 
            <li onclick="fnNumOfEntriesCart(20);"> 20 </li> 
            <li onclick="fnNumOfEntriesCart(50);"> 50 </li> 
            <li onclick="fnNumOfEntriesCart(100);"> 100 </li> 
            <li onclick="fnNumOfEntriesCart(1000);"> 1000 </li> 
        </ul>
        <ul id="select-all-none-dropdown" class="f-dropdown" data-dropdown-content>
            <li onclick="TableTools.fnGetInstance('carttable').fnSelectAll();" style="width:100%">All visible</li>
            <li onclick="TableTools.fnGetInstance('carttable').fnSelectNone();" style="width:100%">None</li>
        </ul>
        <ul id="delete-dropdown" class="f-dropdown" data-dropdown-content>
            <li onclick="removeSelectedFromCart();" class="selectedItemsCount">Selected</li>
            <li onclick="removeAllFromCart();">All</li>
        </ul>
        <ul id="export-dropdown" class="f-dropdown" data-dropdown-content>
            <li><b class="selectedItemsCount"> Selected </b></li>
            <li onclick="exportSelected('{#$ServicePath#}/export/fasta');" style="width:100%">Nucleotides (fasta)</li>
            <li onclick="exportSelected('{#$ServicePath#}/export/peptides');" style="width:100%">Peptides (fasta)</li>
            <li><b> All </b></li>            
            <li onclick="exportAll('{#$ServicePath#}/export/fasta');" style="width:100%">Nucleotides (fasta)</li>
            <li onclick="exportAll('{#$ServicePath#}/export/peptides');" style="width:100%">Peptides (fasta)</li>                   

        </ul>
        <ul id="button-features-addToCart-options" class="f-dropdown" data-dropdown-content>
            <li id="button-features-addToCart-options-newcart" class="keep" data-value="#new#">new</li>
        </ul>
    </div>
    <div class="large-3 columns" style="padding-top: 6px">
        <input id="input-filter-carttable" value="Filter" style="color: lightgray">
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