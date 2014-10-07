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
                            featureID: "-1" //TODO pass appropriate featureIDs
                        };
                        pwData.push(arguments);
                    });
                    displayPwTable();
                }
            });
            function displayPwTable() {
                if (!$.fn.DataTable.fnIsDataTable(resultTable.get())) {
                    resultTable.dataTable({
                        bLengthChange: false,
                        bPaginate: false,
                        bDestroy: true,
                        bInfo: false,
                        aaSorting: [[2, 'desc']],
                        sDom: 'T<"clear">lrtip',
                        aaData: pwData,
                        // sPaginationType: "full_numbers",
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
                            if (aData.feature_id !== -1) {
                                $(nRow).draggable({
                                    appendTo: "body",
                                    helper: function () {
                                        var helper = $(nRow).find('td:eq(0)').clone().addClass('beingDragged');
                                        TableTools.fnGetInstance('pathway-table').fnSelect($(nRow));
                                        var selectedItems = TableTools.fnGetInstance('pathway-table').fnGetSelectedData();
                                        var selectedIDs = $.map(selectedItems, function (val) {
                                            return val.feature_id;
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
                    //       resultTable.on('click', 'a.open-close-details', openCloseDetails);
                } else {
                    resultTable.fnClearTable();
                    resultTable.fnAddData(pwData);
                }

                function prepare_pathway_url(id, components) {
                    var url = "http://www.genome.jp/kegg-bin/show_pathway?map=map";
                    url += id + "&multi_query=";
                    $.each(components, function (key, value) {
                        url += value + "%D%0A";
                    });
                }
            }



        }
    </script>
    <div id="panel-pathways" class="large-12" style="display: none">
        <script type="text/template"  id="template_pathway"> 
            <tr>
            <td> <%= pathway.definition %> </td>
            <td> <a href="http://www.genome.jp/kegg-bin/show_pathway?map=map<%=id%>&multi_query=<% _.each(components, function(comp) { %><%=comp%>%0D%0A<% }); %>" target="_blank">
            <%= id %> 
            </a> </td>
            <td> <%print(components.length);%> </td>
            <td>
            <a href="#" onclick="$('#pathway-details').show();$('#pathway-details').children().hide();$('#pathway-details-<%=id%>').toggle();"> Details </a>
            </td>
            </tr>
        </script>
        <table id="pathway-table">
            <thead><tr><th>Pathway</th><th>Map</th><th>Components</th><th>Details</th></tr></thead>
        </table>
        <div style="clear:both"> &nbsp; </div>
        <script type="text/template" id="template_pathway_details">
            <div style="display: none" id="pathway-details-<%=id%>">
            <h5>Details of <%= pathway.definition %> (<a href="http://www.genome.jp/kegg-bin/show_pathway?map=map<%=id%>&multi_query=<% _.each(components, function(comp) { %><%=comp%>%0D%0A<% }); %>" target="_blank">
            <%= id %> 
            </a>)</h5>
            <% _.each(components, function(comp) { 
            comp_p="http://www.chem.qmul.ac.uk/iubmb/enzyme/EC"+comp.replace(/\./g, '/')+".html";%>
            <h6><%print(comp_array[comp].definition);%><a href=<%print(comp_p);%> target="_blank"> EC:<%= comp %></a></h6>
            <ul><% _.each(comp_array[comp].features, function(value, key) { %><li> <a target="_blank" href="{#$AppPath#}/details/byId/<%=key%>"><%= value %></a> </li><% }) %></ul>
            <% }); %>
            </tr>
        </script>
        <div class="large-12 columns panel" id="pathway-details" style="display:none">
        </div>
    </div>
</div>
