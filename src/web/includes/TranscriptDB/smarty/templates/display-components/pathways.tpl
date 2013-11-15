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
        var pw_panel = $('#panel-pathways');
        var template$ = $('#template_pathway');
        pw_panel.empty();
        pw_panel.append(template$);
        $.each(pw, function(key, value) {
        var entry$ = _executePathwayTemplate$({
        id: key,
        pathway: value,
        components: Object.keys(value.comps),
        comp_array: data.results.components
        });
        pw_panel.append(entry$);
        });
        }
        });
        _executePathwayTemplate$ = function(args) {
        var template$ = _.template($('#template_pathway').html(), args);
        return template$;
        };
        }
    </script>
    <div id="panel-pathways" class="large-12" style="display: none">
        <table>
            <thead><tr><th>Pathway</th><th>Map</th><th>Components</th><th>Details</th></tr></thead>
            <tbody>
                <script type="text/template"  id="template_pathway"> 
                    <tr>
                        <td> <%= pathway.definition %> </td>
                        <td> <a href="http://www.genome.jp/kegg-bin/show_pathway?map=map<%=id%>&multi_query=<% _.each(components, function(comp) { %><%=comp%>%0D%0A<% }); %>" target="_blank">
                                    <%= id %> 
                                </a> </td>
                            <td> <%print(components.length);%> <td>
                        <td>
                            <a href="#" onclick="$('#pathway-<%=id%>-details').toggle();"> Details </a>
                        </td>
                    </tr>
                    <tr style="display: none" id="pathway-<%=id%>-details">
                        <% _.each(components, function(comp) { 
                        comp_p="http://www.chem.qmul.ac.uk/iubmb/enzyme/EC"+comp.replace(/\./g, '/')+".html";%>
                        <h6><%print(comp_array[comp].definition);%><a href=<%print(comp_p);%> target="_blank"> EC:<%= comp %></a></h6>
                            <ul><% _.each(comp_array[comp].features, function(value, key) { %><li> <a target="_blank" href="{#$AppPath#}/details/byId/<%=key%>"><%= value %></a> </li><% }) %></ul>
                        <% }); %>
                    </tr>
                </script>
            </tbody>
        </table>
    </div>
</div>