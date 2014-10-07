<div id="pathways">
    <script>
        // called from mav.tpl
        function showPathwayInfo() {
            var cartitems = cart._getCartForContext()['{#$cartname#}']['items'] || [];
            $('#panel-pathways').show();
            var resultTable = $('#pathway-table');
            var pwData = [];
            $.ajax('{#$ServicePath#}/listing/pathways', {
                method: 'post',
                data: {
                    parents: cartitems
                },
                success: function (data) {
                    pwData = [];
                    var pw = data.results.pathways;
                    $.each(pw, function (key, value) {
                        var arguments = {
                            id: key,
                            pathway: value.definition,
                            components: Object.keys(value.comps),
                            num_comp: Object.keys(value.comps).length,
                            comp_array: data.results.components,
                            details: "Show",
                            featureID: getFeatureIDs(Object.keys(value.comps), data.results.components) //TODO pass appropriate featureIDs
                        };
                        pwData.push(arguments);
                    });
                    displayPwTable();
                }
            });
            function getFeatureIDs(comps, seqids){
                var ids = [];
                $.each(comps, function(key, value){
                    ids = _.union(ids, Object.keys(seqids[value].features));
                });
                return ids;
            }
            function displayPwTable() {
                if (!$.fn.DataTable.fnIsDataTable(resultTable.get()[0])) {
                    resultTable.dataTable({
                        bLengthChange: false,
//                        bPaginate: false,
//                        bDestroy: true,
                        bInfo: false,
                        aaSorting: [[2, 'desc']],
                        sDom: 'T<"clear">lfrtip',
                        aaData: pwData,
                        sPaginationType: "full_numbers",
                        bFilter: false,
                        oTableTools: {
                            aButtons: [],
                            sRowSelect: "multi"
                        },
                        aoColumns: [
                            {
                                mData: "pathway",
                                sTitle: "Pathway",
                                bSortable: true
                            },
                            {
                                mData: "id",
                                sTitle: "Map",
                                bSortable: true,
                                bVisible: true
                            },
                            {
                                mData: "num_comp",
                                sTitle: "Components",
                                bSortable: true
                            },
                            {
                                mData: "details",
                                sTitle: "Details",
                                bSortable: false,
                                sWidth: "45px"
                            }
                        ],
                        fnCreatedRow: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                            $(nRow).find('td:eq(1)').html('<a target="_blank" href="' + prepare_pathway_url(aData.id, aData.components) + '">' + aData.id + '</a>');
                            $(nRow).find('td:eq(3)').html('<a href="#" class="open-close-details"> Show </a>');
                            $(nRow).attr('data-id', aData.feature_id);
                            if (aData.feature_id !== "-1") {
                                $(nRow).draggable({
                                    appendTo: "body",
                                    helper: function () {
                                        var helper = $(nRow).find('td:eq(0)').clone().addClass('beingDragged');
                                        TableTools.fnGetInstance('pathway-table').fnSelect($(nRow));
                                        var selectedItems = TableTools.fnGetInstance('pathway-table').fnGetSelectedData();
                                        var selectedIDs = [];
                                        $.each(selectedItems, function (val) {
                                            selectedIDs = _.union(selectedIDs, val.feature_id);
                                        });
                                        $(nRow).attr('data-id', selectedIDs);
                                        if (selectedIDs.length > 1) {
                                            helper.html("<b>" + selectedIDs.length + "</b> " + helper.text() + ", ...");
                                        }
                                        return helper;
                                    },
                                    cursorAt: {top: 5, left: 30}
                                });
                            }
                        }
                    });
                    resultTable.off('click', 'a.open-close-details').on('click', 'a.open-close-details', openCloseDetails);
                } else {
                    //    TODO clear table and add updated data
                    //    Not working at the moment (TableTools use old selection)
                    //    Drawback: Pathways are not updated on cart events.
                    //    resultTable.rows().remove().clear();
                    //    resultTable[0].fnAddData(pwData);
                }

                function prepare_pathway_url(id, components) {
                    var url = "http://www.genome.jp/kegg-bin/show_pathway?map=map";
                    url += id + "&multi_query=";
                    $.each(components, function (key, value) {
                        url += value + "%0D%0A";
                    });
                    return url;
                }

                function openCloseDetails(event) {
                    event.preventDefault();
                    var row = $(this).parents("tr")[0];
                    var dT = TableTools.fnGetInstance("pathway-table");
                    dT.fnIsSelected(row) ? dT.fnDeselect(row) : dT.fnSelect(row);
                    if (resultTable.fnIsOpen(row)) {
                        resultTable.fnClose(row);
                    } else {
                        var aData = resultTable.fnGetData(row);
                        resultTable.fnOpen(row, _.template($('#template_pathway_details').html())(aData), 'details');
                    }
                }
            }



        }
    </script>
    <div id="panel-pathways" class="large-12" style="display: none">
        <table id="pathway-table">
            <thead><tr><th>Pathway</th><th>Map</th><th>Components</th><th>Details</th></tr></thead>
        </table>
        <div style="clear:both"> &nbsp; </div>
        <script type="text/template" id="template_pathway_details">
            <div class="large-12 column">
            <% _.each(components, function(comp) { 
            comp_p="http://www.chem.qmul.ac.uk/iubmb/enzyme/EC"+comp.replace(/\./g, '/')+".html";%>
            <h6><%print(comp_array[comp].definition);%><a href=<%print(comp_p);%> target="_blank"> EC:<%= comp %></a></h6>
            <ul><% _.each(comp_array[comp].features, function(value, key) { %><li> <a target="_blank" href="{#$AppPath#}/details/byId/<%=key%>"><%= value %></a> </li><% }) %></ul>
            <% }); %>
        </div>
        </script>
    </div>
</div>
