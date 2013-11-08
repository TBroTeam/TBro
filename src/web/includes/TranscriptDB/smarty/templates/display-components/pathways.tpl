<div id="pathways">
    <script>
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
                    pw_panel.empty();
                    $.each(pw, function(key, value) {
                        pw_panel.append(value.definition+"\n");
                    });
                }
            });
        }
    </script>
    <button class="button" onclick="showPathwayInfo();">Show Pathway Information</button> 
    <div id="panel-pathways" style="display: none">
    </div>
</div>