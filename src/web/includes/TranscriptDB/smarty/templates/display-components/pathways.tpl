<div id="pathways">
    <script>
        // called from mav.tpl
        function showPathwayInfo() {
            var cartitems = cart._getCartForContext()['{#$cartname#}'] || [];
            $('#panel-pathways').show();
            $.ajax('{#$ServicePath#}/listing/pathways', {
                method: 'post',
                data: {
                    parents: cartitems
                },
                success: function(data) {
                    var pw = data.results.pathways;
                    var pw_table = $('#pathway-table-body');
                    var details_panel = $('#pathway-details');
                    pw_table.empty();
                    $.each(pw, function(key, value) {
                        var arguments = {
                            id: key,
                            pathway: value,
                            components: Object.keys(value.comps),
                            comp_array: data.results.components
                        };
                        var entry$ = _executePathwayTemplate$(arguments);
                        var details$ = _executePathwayDetailsTemplate$(arguments);
                        pw_table.append(entry$);
                        details_panel.append(details$);
                    });
                    $('#pathway-table').dataTable({
                        bLengthChange: false,
                        bPaginate: false,
                        bInfo: false,
                        aaSorting: [[2,'desc'],[0,'asc']],
                        sDom: 'T<"clear">lrtip',
                        oTableTools: {
                            aButtons: []
                        }
                    });
                }
            });
            _executePathwayTemplate$ = function(args) {
                var template$ = _.template($('#template_pathway').html(), args);
                return template$;
            };
            _executePathwayDetailsTemplate$ = function(args) {
                var template$ = _.template($('#template_pathway_details').html(), args);
                return template$;
            };
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
        <table class="large-12 columns" id='pathway-table'>
            <thead><tr><th>Pathway</th><th>Map</th><th>Components</th><th>Details</th></tr></thead>
            <tbody id="pathway-table-body">
            </tbody>
        </table>
        <div style="clear:both"> &nbsp; </div>
        <script type="text/template"  id="template_pathway_details">
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
        {#include file="display-components/diffexpr.tpl" cart_ids=true#}
    </div>
</div>
