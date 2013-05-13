{#call_webservice path="details/annotations/feature/pub" data=["query1"=>$feature.feature_id] assign='publications'#}
{#if count($publications) > 0 #}
    <div id="publications"> </div>
    <div class="row">
        <div class="large-12 columns panel">
            <h4>Publications</h4>                        
            <table style="width:100%">
                <tbody class="contains-tooltip">
                    {#foreach $publications as $pub#}
                        {#publink pub=$pub#}
                    {#/foreach#}
                </tbody>
            </table>
        </div>
    </div>
{#/if#}