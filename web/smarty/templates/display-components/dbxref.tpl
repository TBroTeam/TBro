{#call_webservice path="details/annotations/feature/dbxref" data=["query1"=>$feature.feature_id] assign='dbxref'#}
{#if (isset($dbxref['GO']))#}
    <div class="row contains-tooltip">
        <div class="large-12 columns panel">                    
            <h4>Gene Ontology</h4>
            {#foreach $dbxref['GO'] as $namespace=>$dbxarr#}
                <h5>{#$namespace#}</h5>
                <table style="width:100%">
                    <tbody>
                        {#foreach $dbxarr as $dbxref#}
                            <tr><td>{#dbxreflink dbxref=$dbxref#}</td></tr>
                        {#/foreach#}
                    </tbody>
                </table>
            {#/foreach#}
        </div>
    </div>
{#/if#}


{#if (isset($dbxref['EC']))#}
    <div class="row contains-tooltip">
        <div class="large-12 columns panel">
            <h4>Enzyme classifications</h4>
            {#foreach $dbxref['EC'] as $namespace=>$dbxarr#}
                <table style="width:100%">
                    <tbody>
                        {#foreach $dbxarr as $dbxref#}
                            <tr><td>{#dbxreflink dbxref=$dbxref#}</td></tr>
                        {#/foreach#}
                    </tbody>
                </table>
            {#/foreach#}
        </div>
    </div>
{#/if#}