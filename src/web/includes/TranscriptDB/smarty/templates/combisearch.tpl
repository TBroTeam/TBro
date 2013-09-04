{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
    <script type="text/javascript">
        $(document).ready(function() {
            //different allowed search methods
            var searchNodes = {
                descriptionContains: {
                    name: 'Description Contains',
                    webservice: '{#$ServicePath#}/combisearch/description_contains/',
                    template_search: '#template_search_description_contains',
                    fnPrepareData: function() {
                        return {
                            species: organism.val(),
                            release: release.val(),
                            term: $(this).find('input.term').val()
                        };
                    }
                },
                mapmanContains: {
                    name: 'MapMan Contains',
                    webservice: '{#$ServicePath#}/combisearch/mapman_contains/',
                    template_search: '#template_search_mapman_contains',
                    fnPrepareData: function() {
                        return {
                            species: organism.val(),
                            release: release.val(),
                            term: $(this).find('input.term').val()
                        };
                    }
                },
                mapmanHasbin: {
                    name: 'MapMan has Bincode',
                    webservice: '{#$ServicePath#}/combisearch/mapman_hasbin/',
                    template_search: '#template_search_mapman_hasbin',
                    fnPrepareData: function() {
                        return {
                            species: organism.val(),
                            release: release.val(),
                            term: $(this).find('input.term').val()
                        };
                    }
                },
                hasGO: {
                    name: 'Has GO',
                    webservice: '{#$ServicePath#}/combisearch/hasgo/',
                    template_search: '#template_search_hasGO',
                    fnPrepareData: function() {
                        return {
                            species: organism.val(),
                            release: release.val(),
                            term: $(this).find('input.GO').val()
                        };
                    }
                },
                hasGO_or_children: {
                    name: 'Has GO or Children (slower!)',
                    webservice: '{#$ServicePath#}/combisearch/hasgo_or_children/',
                    template_search: '#template_search_hasGO_or_children',
                    fnPrepareData: function() {
                        return {
                            species: organism.val(),
                            release: release.val(),
                            term: $(this).find('input.GO').val()
                        };
                    }
                }
            };

            //fill up #select-terms with searchNodes
            var select$ = $('#select-terms');
            $.each(searchNodes, function(key) {
                select$.append($('<option/>').val(key).text(this.name));
            });

            var row_template = _.template($('#template_row').html());

            //adds a term for selected searchNode using template searchNode.template_search
            $('#add-term').click(function() {
                var searchNode = searchNodes[$('#select-terms').val()];
                var elem = _.template($(searchNode.template_search).html())(searchNode);
                var elem$ = $('<div/>').append(row_template({row: elem})).children();
                elem$.find('.delete_row').click(function() {
                    $(this).parents('.template_row').remove();
                });
                elem$.data('searchNode', searchNode);
                $('#searchterms').append(elem$);
            });

            $('#start-combisearch').click(function() {
                //gui animationi
                $.when($('.results').hide(500)).then(function() {
                    $('.loading').show();
                });
                var filteredResults;

                //start all searches, add them to the array deferreds
                var deferreds = $('#searchterms').children().map(function() {
                    var searchNode = $(this).data('searchNode');
                    return $.ajax(searchNode.webservice, {
                        data: searchNode.fnPrepareData.call(this),
                        dataType: 'JSON',
                        success: function(data) {
                            if (typeof filteredResults === 'undefined') {
                                filteredResults = data.results || [];
                            } else {
                                filteredResults = _.intersection(filteredResults, data.results || []);
                            }
                        }
                    });
                });

                //when all deferred ajax calls have finished, display feature table
                $.when.apply($, deferreds.get()).then(function() {
                    $.ajax('{#$ServicePath#}/details/features', {
                        data: {terms: filteredResults},
                        type: 'POST',
                        datatype: 'JSON',
                        success: function(data) {
                            $('.loading').hide();
                            displayFeatureTable(data.results, {});
                        }
                    });
                });
            });
        });
    </script>
    <script type="text/template" id="template_row">
        <div class="row template_row panel" style="margin-bottom:5px; margin-left:0px; margin-right:0px">
        <div class="large-11 columns ">
        <%= row %>
        </div>    
        <div class="large-1 columns">
        <a class="delete_row"><img src="{#$AppPath#}/img/mimiGlyphs/51.png" /></a>
        </div>            
        </div>
    </script>
    <script type="text/template" id="template_search_description_contains">
        <div class="row">
        <div class="large-6 columns">
        Description Contains: 
        </div>
        <div class="large-2 columns" style="text-align: right">Term:</div>
        <div class="large-4 columns">
        <input type="text" class="term" style="margin:0px"/>
        </div>
        </div>
    </script>
    <script type="text/template" id="template_search_mapman_contains">
        <div class="row">
        <div class="large-6 columns">
        MapMan Contains: 
        </div>
        <div class="large-2 columns" style="text-align: right">Term:</div>
        <div class="large-4 columns">
        <input type="text" class="term" style="margin:0px"/>
        </div>
        </div>
    </script>
    <script type="text/template" id="template_search_mapman_hasbin">
        <div class="row">
        <div class="large-6 columns">
        Has Mapman Bincode: 
        </div>
        <div class="large-3 columns" style="text-align: right">Bincode:</div>
        <div class="large-3 columns">
        <input type="text" class="term" style="margin:0px"/>
        </div>
        </div>
    </script>
    <script type="text/template" id="template_search_hasGO">
        <div class="row">
        <div class="large-6 columns">
        Has GO: 
        </div>
        <div class="large-3 columns" style="text-align: right">GO:</div>
        <div class="large-3 columns">
        <input type="text" class="GO" style="margin:0px"/>
        </div>
        </div>
    </script>
    <script type="text/template" id="template_search_hasGO_or_children">
        <div class="row">
        <div class="large-6 columns">
        Has GO or Children of GO: 
        </div>
        <div class="large-3 columns" style="text-align: right">GO:</div>
        <div class="large-3 columns">
        <input type="text" class="GO" style="margin:0px"/>
        </div>
        </div>
    </script>
{#/block#}

{#block name='body'#}

    <div class="large-12 column panel">
        <div class="row">
            <div class="large-12 column">
                <h1>Annotation Search</h1>
            </div>

            <div class="large-12 column">
                <p>
                    Here you can search for annotations. All subsearches will be AND'ed.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="large-8 column">
                Search for: <select id="select-terms"></select>
            </div>
            <div class="large-4 column">
                <a id="add-term" class="button"/>Add Term</a>
            </div>
        </div>
        <div class="row">
            <div class="large-8 column">
                <ul id="searchterms">
                </ul>
            </div>
            <div class="large-4 column">
                <a id="start-combisearch" class="button"/>Search</a>
            </div>
        </div>
        <div class="loading alert-box" style="display:none;">
            Please wait, loading!
        </div>
    </div>
    <div class="row">&nbsp;</div>
    <div class="results panel" style="display:none">
        <div class="row" >
            <div class="large-12 column">
                <h2>Results</h2>
            </div>
        </div>
        {#include file="display-components/feature_table.tpl"#}
    </div>


{#/block#}