{#if isset($feature.pub) && count($feature.pub) > 0 #}
    <div id="publications"> </div>
    <div class="row">
        <div class="large-12 columns panel">
            <h4>Publications</h4>                        
            <table style="width:100%">
                <tbody class="contains-tooltip">
                    {#foreach $feature.pub as $pub#}
                        {#publink pub=$pub#}
                    {#/foreach#}
                </tbody>
            </table>
        </div>
    </div>
{#/if#}