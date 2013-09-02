{#call_webservice path="details/annotations/feature/synonym" data=["query1"=>$feature.feature_id] assign='synonyms'#}
{#if count($synonyms) > 0 #}
    <div id="synonyms"> </div>
    <div class="row">
        <div class="large-12 columns panel">
            <h4>Synonyms</h4>                        
            <table style="width:100%">
                <tbody class="contains-tooltip">
                    {#foreach $synonyms as $synonym#}
                        <tr><td>{#$synonym.synonym_name#}</td><td>{#$synonym.synonym_type#}</td>
                        {#publinkshort pub=$synonym#}</tr>
                    {#/foreach#}
                </tbody>
            </table>
        </div>
    </div>
{#/if#}