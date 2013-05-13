{#if isset($feature.synonym) && count($feature.synonym) > 0 #}
    <div id="synonyms"> </div>
    <div class="row">
        <div class="large-12 columns panel">
            <h4>Synonyms</h4>                        
            <table style="width:100%">
                <tbody class="contains-tooltip">
                    {#foreach $feature.synonym as $synonym#}
                        <tr><th>{#$synonym.synonym_name#}</th><td>{#$synonym.synonym_type#}</td></tr>
                        {#publink pub=$synonym#}
                    {#/foreach#}
                </tbody>
            </table>
        </div>
    </div>
{#/if#}