{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
<script type="text/javascript">
    $(document).ready(function(){
        
        var searchNodes = {
            hasGO: {
                name: 'hasGO',
                webservice: '{#$ServicePath#}/combisearch/hasGO/', 
                template_search: '#template_search_hasGO',
                template_result: '#template_result_hasGO', 
                fnPrepareData: function(){
                    return {GO: $(this).find('input.GO').val()};
                }
            }
        };
        
        var select$ = $('#select-terms');
        $.each(searchNodes, function(key){
            select$.append($('<option/>').val(key).text(this.name));
        });
        
        $('#add-term').click(function(){
            
            var searchNode = searchNodes[$('#select-terms').val()];
            var elem$ = $('<div/>').append(_.template($(searchNode.template_search).html())(searchNode)).children();
            elem$.data('searchNode', searchNode);            
            $('#searchterms').append(elem$);
        });
        
        $('#start-combisearch').click(function(){
            $('.results').hide(500);
            
            var filteredResults;
 
            var deferreds = $('#searchterms').children().map(function(){
                var searchNode = $(this).data('searchNode');
                return $.ajax(searchNode.webservice, {
                    data: searchNode.fnPrepareData.call(this),
                    dataType: 'JSON',
                    success: function(data){
                        if (typeof filteredResults === 'undefined'){
                            filteredResults = data.results || [];
                        } else {
                            filteredResults = _.intersection(filteredResults, data.results || []);
                        }
                    }
                });
            });
            
            //when all deferred ajax calls have finished
            $.when.apply($, deferreds.get()).then(function(){
                displayFeatureTable(filteredResults);
            });            
        });
    });
</script>
<script type="text/template" id="template_search_hasGO">
    <div>
        has GO: <input type="text" class="GO"/>
    </div>
</script>
<script type="text/template" id="template_result_hasGO">
    <p>
        GO: <%- GO %>
    </p>
</script>
{#/block#}

{#block name='body'#}

<div class="row">
    <div class="large-12 column">
        <h1>Annotation Search</h1>
    </div>

    <div class="large-12 column">
        <p>
            Some explanation text here.
        </p>
    </div>
</div>

<div class="row">
    <div class="large-8 column">
        Search for: <select id="select-terms"></select>
    </div>
    <div class="large-4 column">
        <a id="add-term" class="button"/>add term</a>
    </div>
</div>
<div class="row">
    <div class="large-8 column">
        <ul id="searchterms">
        </ul>
    </div>
    <div class="large-4 column">
        <a id="start-combisearch" class="button"/>search</a>
    </div>
</div>

<div class="results" style="display:none">
    <div class="row" >
        <div class="large-12 column">
            <h2>Results</h2>
        </div>
    </div>
    {#include file="display-components/feature_table.tpl"#}
</div>


{#/block#}