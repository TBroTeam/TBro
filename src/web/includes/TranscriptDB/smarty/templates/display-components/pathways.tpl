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
                            components: Object.keys(value.comps)
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
            <div class="large-12 panel">
                <h6> <%= pathway.definition %> 
                    (<a href="http://www.genome.jp/kegg-bin/show_pathway?map=map<%=id%>&multi_query=<% _.each(components, function(comp) { %><%=comp%>%0D%0A<% }); %>" target="_blank">
                        <%= id %> 
                    </a>)
                </h6> Components: <%print(components.length);%>
            </div>
        </script>
    </div>
</div>