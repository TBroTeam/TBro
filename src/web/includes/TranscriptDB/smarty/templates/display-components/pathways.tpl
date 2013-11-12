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
        <script type="text/template"  id="template_pathway"> 
            <div class="large-12 columns panel">
                <div class="row">
                <div class="large-10 columns">
                <h5> <%= pathway.definition %> 
                    (<a href="http://www.genome.jp/kegg-bin/show_pathway?map=map<%=id%>&multi_query=<% _.each(components, function(comp) { %><%=comp%>%0D%0A<% }); %>" target="_blank">
                        <%= id %> 
                    </a>)
                </h5> Components: <%print(components.length);%>
                </div>
                <div class="large-2 columns">
                <div class="button" onclick="$('#pathway-<%=id%>-details').toggle();"> Details </div>
                </div>
                </div>
                <div class="large-12" style="display: none" id="pathway-<%=id%>-details">
                    <% _.each(components, function(comp) { 
                        comp_p="http://www.chem.qmul.ac.uk/iubmb/enzyme/EC"+comp.replace(/\./g, '/')+".html";%>
                                <div class="panel"><h6><%print(comp_array[comp].definition);%><a href=<%print(comp_p);%> target="_blank"> EC:<%= comp %></a></h6>
                                <ul><% _.each(comp_array[comp].features, function(value, key) { %><li> <a target="_blank" href="{#$AppPath#}/details/byId/<%=key%>"><%= value %></a> </li><% }) %></ul>
                                </div>
                        <% }); %>
                <div>
            </div>
        </script>
    </div>
</div>