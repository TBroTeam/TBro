{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
    <script type="text/javascript">
        $(document).ready(function() {
            //start search
            $('#start-multisearch').click(function() {
                $('.results').hide(500);
                $.ajax({
                    url: "{#$ServicePath#}/listing/multisearch/",
                    type: "POST",
                    data: {species: organism.val(), release: release.val(), longterm: $('#multisearch').val(), strict: $('#strict').is(':checked')},
                    dataType: "json",
                    success: function(data) {
                        displayFeatureTable(data.results);
                    }
                });

            });
        });
    </script>
{#/block#}

{#block name='body'#}

    <div class="large-12 column panel">
        <div class="row">
            <div class="large-12 column">
                <h1>Advanced Search</h1>
            </div>

            <div class="large-12 column">
                <p>
                    This field allows you to search for as many unigenes or isoforms as you want at once. (Up to a reasonable limit) <br/>
                    For every found isoform, corresponding unigene will be shown.</br>
                    For each found unigene, all isoforms will be shown.<br/>
                    <b>This search does not allow wildcards.</b>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="large-8 column">
                <textarea id="multisearch" style="max-width: 100%; height: 150px"></textarea>
            </div>
            <div class="large-4 column">
                <a id="start-multisearch" class="button"/>search</a><br>
                <input type="checkbox" id="strict" checked="true"> <label for="strict">Strict Search</label>
            </div>
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