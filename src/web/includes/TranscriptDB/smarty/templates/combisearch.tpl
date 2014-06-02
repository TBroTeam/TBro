{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
    <script type="text/javascript">
        var autocomplete_pw;
        $(document).ready(function() {
            //different allowed search methods
            var searchNodes = {
                descriptionContains: {
                    name: 'Description contains',
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
                    name: 'MapMan description contains',
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
                inPathwayID: {
                    name: 'In Pathway (KEGG ID)',
                    webservice: '{#$ServicePath#}/combisearch/inpathway_id/',
                    template_search: '#template_search_inPathwayID',
                    fnPrepareData: function() {
                        return {
                            species: organism.val(),
                            release: release.val(),
                            term: $(this).find('input.GO').val()
                        };
                    }
                },
                inPathwayTerm: {
                    name: 'In Pathway (definition contains)',
                    webservice: '{#$ServicePath#}/combisearch/inpathway_term/',
                    template_search: '#template_search_inPathwayTerm',
                    fnPrepareData: function() {
                        return {
                            species: organism.val(),
                            release: release.val(),
                            term: $(this).find('input.term').val()
                        };
                    }
                },
                interproID: {
                    name: 'Interpro ID',
                    webservice: '{#$ServicePath#}/combisearch/interpro_id/',
                    template_search: '#template_search_interpro_ID',
                    fnPrepareData: function() {
                        return {
                            species: organism.val(),
                            release: release.val(),
                            term: $(this).find('input.GO').val()
                        };
                    }
                },
                interproMatchDescription: {
                    name: 'Interpro Match Description',
                    webservice: '{#$ServicePath#}/combisearch/interpro_match_description/',
                    template_search: '#template_search_interpro_match_description',
                    fnPrepareData: function() {
                        return {
                            species: organism.val(),
                            release: release.val(),
                            term: $(this).find('input.term').val()
                        };
                    }
                }
            };

            //fill up #select-terms with searchNodes
            var selectOptions$ = $('#select-terms-dropdown-options');
            $.each(searchNodes, function(key) {
                var li = $('<li/>').text(this.name).attr("data-value", key);
                li.click(addSearchNodeToSite);
                //addSearchNode);
                selectOptions$.append(li);
            });

            var row_template = _.template($('#template_row').html());

            $.ajax('{#$ServicePath#}/listing/PathwaysAll', {
                success: function(val) {
                    autocomplete_pw = val.results;
                }
            });

            $('#start-combisearch').click(function() {
                //gui animationi
                $.when($('.results').hide(500)).then(function() {
                    if (!$('.results').is(':visible')) {
                        $('.loading').show();
                    }
                });
                var filteredResults;

                //start all searches, add them to the array deferreds
                var deferreds = $('#searchterms').children().map(function() {
                    var searchNode = $(this).data('searchNode');
                    return $.ajax(searchNode.webservice, {
                        data: searchNode.fnPrepareData.call(this),
                        dataType: 'JSON',
                        success: function(data) {
                            var results = $.map(data.results, function(value, index) {
                                return value;
                            });
                            if (typeof filteredResults === 'undefined') {
                                filteredResults = results || [];
                            } else {
                                filteredResults = _.intersection(filteredResults, results || []);
                            }
                        },
                        error: function(data) {
                            $('.loading').hide();
                            alert("Error: " + data.responseText);
                        }
                    });
                });

                //when all deferred ajax calls have finished, display feature table
                $.when.apply($, deferreds.get()).then(function() {
                    $('.loading').hide();
                    $('.waiting-for-details').html("There are " + filteredResults.length + " results. Retrieving details...")
                    $('.waiting-for-details').show();
                    $.ajax('{#$ServicePath#}/details/features', {
                        data: {terms: filteredResults},
                        type: 'POST',
                        datatype: 'JSON',
                        success: function(data) {
                            $('.waiting-for-details').hide();
                            displayFeatureTable(data.results, {});
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            $('.waiting-for-details').hide();
                            alert("It took too long to lookup the details of the " + filteredResults.length + " results. Please restrict your search.\n" + errorThrown + textStatus);
                        }
                    });
                });
            });

            function addSearchNodeToSite() {
                var searchNode = searchNodes[$(this).attr('data-value')];
                var elem = _.template($(searchNode.template_search).html())(searchNode);
                var elem$ = $('<div/>').append(row_template({row: elem})).children();
                elem$.find('.delete_row').click(function() {
                    $(this).parents('.template_row').remove();
                });
                elem$.data('searchNode', searchNode);
                $('#searchterms').append(elem$);
                refreshAutocomplete();
            }

            function refreshAutocomplete() {
                $(".pathwayName").autocomplete({source: autocomplete_pw});
            }
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
        Description contains: 
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
        MapMan description contains: 
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
    <script type="text/template" id="template_search_inPathwayID">
        <div class="row">
        <div class="large-6 columns">
        In Pathway 
        </div>
        <div class="large-3 columns" style="text-align: right">KEGG ID:</div>
        <div class="large-3 columns">
        <input type="text" class="GO" style="margin:0px"/>
        </div>
        </div>
    </script>
    <script type="text/template" id="template_search_inPathwayTerm">
        <div class="row">
        <div class="large-6 columns">
        In Pathway 
        </div>
        <div class="large-2 columns" style="text-align: right">Term:</div>
        <div class="large-4 columns">
        <input type="text" class="term pathwayName" style="margin:0px"/>
        </div>
        </div>
    </script>
    <script type="text/template" id="template_search_interpro_ID">
        <div class="row">
        <div class="large-6 columns">
        Interpro ID 
        </div>
        <div class="large-3 columns" style="text-align: right">ID:</div>
        <div class="large-3 columns">
        <input type="text" class="GO" style="margin:0px"/>
        </div>
        </div>
    </script>
    <script type="text/template" id="template_search_interpro_match_description">
        <div class="row">
        <div class="large-6 columns">
        Interpro Match Description 
        </div>
        <div class="large-2 columns" style="text-align: right">Term:</div>
        <div class="large-4 columns">
        <input type="text" class="term" style="margin:0px"/>
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
                <button class="large button dropdown expand" id="select-terms-dropdown" data-dropdown="select-terms-dropdown-options"> Search for </button>
                <ul id="select-terms-dropdown-options" class="f-dropdown medium" data-dropdown-content></ul>
            </div>
            <div class="large-4 column">
                <a id="start-combisearch" class="button large"/>Start Search</a>
            </div>
        </div>
        <div class="row">
            <div class="large-8 column">
                <ul id="searchterms">
                </ul>
            </div>
        </div>
        <div class="waiting-for-details alert-box" style="display:none;">
            Please wait, loading!
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