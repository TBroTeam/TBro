<script type="text/javascript">
    var dataTable;
    var selectedIDs = [];
    var allFilteredIDs;
    var allIDs;
    function displayCartTable(data, opts) {
        // save a clone of the data as allIDs
        allIDs = data.slice(0);
        allIDs = _.map(data, function(value) {
            return parseInt(value);
        });
        allFilteredIDs = data;
        allFilteredIDs = _.map(data, function(value) {
            return parseInt(value);
        });
        selectedIDs = selectedIDs.filter(function(n) {
            return data.indexOf(n) !== -1;
        });
        if (typeof dataTable === "undefined") {
            var cols = [{mData: 'type', bSortable: false, sClass: "no-wrap", sWidth: "10px"},
                {mData: 'name', bSortable: true, sClass: "no-wrap"},
                {mData: 'alias', bSortable: true, sClass: "no-wrap", bVisible: false},
                {mData: 'description', bSortable: true, sClass: "no-wrap"},
                {mData: 'user_alias', bSortable: true, sClass: "no-wrap"},
                {mData: 'user_annotations', bSortable: true, sClass: "no-wrap"},
                {mData: 'actions', bSortable: false, sClass: "no-wrap", sWidth: "90px"}];
            // disable column sorting if cart is too large
            if (data.length > 1000) {
                cols = [{mData: 'type', bSortable: false, sClass: "no-wrap", sWidth: "10px"},
                    {mData: 'name', bSortable: false, sClass: "no-wrap"},
                    {mData: 'alias', bSortable: false, sClass: "no-wrap", bVisible: false},
                    {mData: 'description', bSortable: false, sClass: "no-wrap"},
                    {mData: 'user_alias', bSortable: false, sClass: "no-wrap"},
                    {mData: 'user_annotations', bSortable: false, sClass: "no-wrap"},
                    {mData: 'actions', bSortable: false, sClass: "no-wrap", sWidth: "90px"}];
                $('#placeholder-unsortable').show();
            }
            var options = $.extend(true, {
                bDestroy: true,
                bProcessing: true,
                bServerSide: true,
                sAjaxSource: "{#$ServicePath#}/listing/cart_table",
                "fnServerParams": function(aoData) {
                    aoData.push({"name": "terms", "value": allIDs});
                    aoData.push({"name": "currentContext", "value": cart.currentContext});
                },
                fnServerData: function(sSource, aoData, fnCallback, oSettings) {
                    oSettings.jqXHR = $.ajax({
                        "dataType": 'json',
                        "type": "POST",
                        "url": sSource,
                        "data": aoData,
                        "success": function(result) {
                            if (typeof result.idsFiltered !== 'undefined') {
                                allFilteredIDs = result.idsFiltered;
                                allFilteredIDs = _.map(allFilteredIDs, function(value) {
                                    return parseInt(value);
                                });
                            }
                            else {
                                allFilteredIDs = allIDs.slice(0);
                                allFilteredIDs = _.map(allFilteredIDs, function(value) {
                                    return parseInt(value);
                                });
                            }
                            fnCallback(result);
                        }
                    });
                },
                bLengthChange: false,
                sPaginationType: "full_numbers",
                aoColumns: cols,
                fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $(nRow).find('td:eq(5)').append(
                            '<a target="_blank"  title="Goto Details Page" href="{#$AppPath#}/details/byId/' + aData.feature_id + '"><img src="{#$AppPath#}/img/mimiGlyphs/47.png"/> </a>' +
                            '<a class="cart-button-rename" title="Change Annotation" onclick="annotateElement(' + aData.feature_id + ', \'' + aData.name + '\', \'' + aData.description + '\');" href="#"><img class="cart-button-edit" src="{#$AppPath#}/img/mimiGlyphs/39.png"/> </a>' +
                            '<a class="cart-button-delete" title="Delete from Cart" onclick="deleteElement(' + aData.feature_id + ');" href="#"><img src="{#$AppPath#}/img/mimiGlyphs/51.png"/> </a>' +
                            '<a class="cart-button-delete" title="Delete Annotation" onclick="deleteAnnotation(' + aData.feature_id + ');" href="#"><img src="{#$AppPath#}/img/mimiGlyphs/own_1.png"/></a>'
                            );
                    $(nRow).find('td:eq(5)').attr("align", "center");
                    $(nRow).css('cursor', 'pointer');
                    $(nRow).attr('data-id', aData.feature_id);
                    $(nRow).draggable({
                        appendTo: "body",
                        helper: function() {
                            var helper = $(nRow).find('td:eq(1)').clone().addClass('beingDragged');
                            if (jQuery.inArray(aData.feature_id, selectedIDs) === -1) {
                                selectedIDs.push(aData.feature_id);
                                $(nRow).toggleClass('DTTT_selected');
                            }
                            if (_.intersection(selectedIDs, allFilteredIDs).length > 1) {
                                helper.html("<b>(" + _.intersection(selectedIDs, allFilteredIDs).length + ")</b> " + helper.text());
                                $(nRow).attr('data-id', _.intersection(selectedIDs, allFilteredIDs));
                            }
                            return helper;
                        },
                        cursorAt: {top: 5, left: 15}
                    });
                    $(nRow).on('click', function(event) {
                        var aData = dataTable.fnGetData(this);
                        var iId = aData.feature_id;

                        if (jQuery.inArray(iId, selectedIDs) === -1)
                        {
                            selectedIDs[selectedIDs.length++] = iId;
                        }
                        else
                        {
                            selectedIDs = jQuery.grep(selectedIDs, function(value) {
                                return value !== iId;
                            });
                        }
                        $(nRow).toggleClass('DTTT_selected');
                        event.stopPropagation();
                    });
                    if (jQuery.inArray(aData.feature_id, selectedIDs) !== -1)
                    {
                        $(nRow).addClass('DTTT_selected');
                    }
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
            var tbl = $('#carttable');
            dataTable = tbl.dataTable(options);
        } else {
            //table already exists, refresh table. if "selectedItem" has changed, this will load new data.
            dataTable.fnReloadAjax();
        }
    }

    (function($) {
        $(document).ready(function() {
            /* Click event handler */

            $('#add_selected').click(function() {
                var groupname = $('#select-group').val();
                if (groupname === '#new#') {
                    groupname = cart.addGroup();
                }
                cart.addItem(_.intersection(selectedIDs, allFilteredIDs), {groupname: groupname});
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

    function deleteElement(id) {
        var dialog = $('#dialog-delete-item');
        dialog.data('id', id);
        dialog.data('groupname', '{#$cartname#}');
        dialog.dialog("open");
    }

    function deleteAnnotation(id) {
        var dialog = $('#dialog-delete-item-annotation');
        dialog.data('id', id);
        dialog.dialog("open");
    }

    function annotateElement(id, name, description) {
        cart._getItemDetails([id], function(data) {
            if (Object.keys(cart.metadata[cart.currentContext]).length >= cartlimits.max_annotations_per_context) {
                if (typeof data[0].metadata.alias === 'undefined' && typeof data[0].metadata.annotations === 'undefined') {
                    $('#TooManyAnnotationsDialog').foundation('reveal', 'open');
                    return;
                }
            }
            $("#dialog-edit-cart-item").data('id', id);
            $("#dialog-edit-cart-item").data('name', name);
            $("#dialog-edit-cart-item").data('description', description);
            $('#item-alias').val(data[0].metadata.alias || '');
            $('#item-annotations').val(data[0].metadata.annotations || '');
            $("#dialog-edit-cart-item").dialog("open");
        });
    }

    function updateSelectedCount() {
        var selectedItems = _.intersection(selectedIDs, allFilteredIDs).length;
        $('.selectedItemsCount').html('Selected (' + selectedItems + ')');
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
        if (selectedIDs.length === 0)
            return;
        if (group === '#new#')
            group = cart.addGroup();
        cart.addItem(_.intersection(selectedIDs, allFilteredIDs), {
            groupname: group
        });
    }

    function removeSelectedFromCart() {
        if (_.intersection(selectedIDs, allFilteredIDs).length === 0)
            return;
        _.each(_.intersection(selectedIDs, allFilteredIDs), function(val) {
            cart.removeItem(val, {groupname: '{#$cartname#}'});
        });
        var oTable = $('#carttable').dataTable();
        oTable.fnReloadAjax();
    }

    function removeAllFromCart() {
        var cartitems = cart._getCartForContext()['{#$cartname#}']['items'] || [];
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

    function exportSelected(service, opts) {
        if (_.intersection(selectedIDs, allFilteredIDs).length === 0)
            return;
        var options = $.extend(true, {
            terms: _.intersection(selectedIDs, allFilteredIDs),
            cartname: '{#$cartname#}' + "_selection"
        }, opts);
        exportIds(service, options);
    }
    function exportAll(service, opts) {
        var ids = cart._getCartForContext()['{#$cartname#}']['items'] || [];
        var options = $.extend(true, {
            terms: ids,
            cartname: '{#$cartname#}'
        }, opts);
        exportIds(service, options);
    }
    function exportIds(service, options) {
        $.download(service, options, 'post');
    }
    function selectAll() {
        // fnSelectAll only for graphical selection
        selectedIDs = allFilteredIDs;
        TableTools.fnGetInstance('carttable').fnSelectAll();
    }
    function selectAllVisible() {
        // fnSelectAll only for graphical selection
        TableTools.fnGetInstance('carttable').fnSelectAll();
        selectedIDs = $.map(TableTools.fnGetInstance('carttable').fnGetVisibleSelectedData(), function(val) {
            return val.feature_id;
        });
    }
    function selectNone() {
        selectedIDs = [];
        // fnSelectAll fnSelectNone only for graphical selection
        TableTools.fnGetInstance('carttable').fnSelectAll();
        TableTools.fnGetInstance('carttable').fnSelectNone();
    }
</script>

<style>
    .no-wrap {
        white-space: nowrap;
        max-width: 150px;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .no-wrap:hover {
        overflow: visible;
    }

    .dataTable .notSortable{
        padding-right: 10px
    }

    .dataTable .notSortable .DataTables_sort_wrapper{
        padding: 0
    }
</style>

<div class="row">
    <div class="large-12 columns">  
        <h4>Items</h4>
    </div>
    <div class="large-9 columns">        
        <ul class="button-group even-5">
            <li><button class="small button dropdown" id="show-entries-dropdown" data-dropdown="show-entries-dropdown-options"> Entries </button></li>
            <li><button class="small button dropdown" data-dropdown="select-all-none-dropdown">Select</button></li>
            <li><button class="small button dropdown" onclick="updateSelectedCount();" data-dropdown="delete-dropdown">Delete</button></li>
            <li><button class="small button dropdown" type="button" id="button-features-addToCart" data-dropdown="button-features-addToCart-options"> Store </button></li>
            <li><button class="small button dropdown" onclick="updateSelectedCount();" data-dropdown="export-dropdown">Export</button></li>
        </ul>

        <ul class="f-dropdown" id="show-entries-dropdown-options" data-dropdown-content>
            <li onclick="fnNumOfEntriesCart(10);"> 10 </li> 
            <li onclick="fnNumOfEntriesCart(20);"> 20 </li> 
            <li onclick="fnNumOfEntriesCart(50);"> 50 </li> 
            <li onclick="fnNumOfEntriesCart(100);"> 100 </li> 
            <li onclick="fnNumOfEntriesCart(1000);"> 1000 </li> 
        </ul>
        <ul id="select-all-none-dropdown" class="f-dropdown" data-dropdown-content>
            <li onclick="selectAll();" style="width:100%">All</li>
            <li onclick="selectAllVisible();" style="width:100%">All visible</li>
            <li onclick="selectNone();" style="width:100%">None</li>
        </ul>
        <ul id="delete-dropdown" class="f-dropdown" data-dropdown-content>
            <li onclick="removeSelectedFromCart();" class="selectedItemsCount">Selected</li>
            <li onclick="removeAllFromCart();">All</li>
        </ul>
        <ul id="export-dropdown" class="f-dropdown" data-dropdown-content>
            <li><b class="selectedItemsCount"> Selected </b></li>
            <li onclick="exportSelected('{#$ServicePath#}/listing/Cart_table', {exportTsv: true, currentContext: cart.currentContext});" style="width:100%">Cart (tsv)</li>
            <li onclick="exportSelected('{#$ServicePath#}/export/fasta');" style="width:100%">Nucleotides (fasta)</li>
            <li onclick="exportSelected('{#$ServicePath#}/export/peptides');" style="width:100%">Peptides (fasta)</li>
            <li><b> All </b></li>            
            <li onclick="exportAll('{#$ServicePath#}/listing/Cart_table', {exportTsv: true, currentContext: cart.currentContext});" style="width:100%">Cart (tsv)</li>
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
    <div  class="large-12 column" id="placeholder-unsortable" style="display: none; color: red">
        Attention: This cart is large (>1000 entries) therefore column sorting is disabled!
    </div>
    <div class="large-12 column">
        <table style="width:100%" id="carttable">
            <thead>
                <tr>
                    <th class="notSortable">Type</th>
                    <th>Name</th>
                    <th>DB Alias</th>
                    <th>DB Description</th>
                    <th>User Alias</th>
                    <th>User Description</th>
                    <th style="text-align: center" class="notSortable">Action</th>
                </tr>
            </thead>
            <tfoot></tfoot>
            <tbody>
            </tbody>
        </table>
    </div>
</div>