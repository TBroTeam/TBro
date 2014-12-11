{#call_webservice path="details/annotations/feature/dbxref" data=["query1"=>$feature.feature_id] assign='dbxref'#}
{#call_webservice path="details/annotations/feature/pathway" data=["query1"=>$feature.feature_id] assign='pathway'#}

{#if (isset($dbxref['GO']))#}
    <div class="row contains-tooltip">
        <div class="large-12 columns panel">                    
            <h4>Gene Ontology</h4>
            {#foreach $dbxref['GO'] as $namespace=>$dbxarr#}
                <h5>{#$namespace|go_section#}</h5>
                <table style="width:100%">
                    <tbody>
                        {#foreach $dbxarr as $ref#}
                            <tr><td>{#dbxreflink dbxref=$ref#}</td></tr>
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
            <h4>Enzyme Commission</h4>
            {#foreach $dbxref['EC'] as $namespace=>$dbxarr#}
                {#foreach $dbxarr as $dbxref#}
                    <table style="width:100%">
                        <tbody>
                            <tr><td>{#dbxreflink dbxref=$dbxref#}</td></tr>
                        </tbody>
                    </table>


                    {#if (isset($pathway) && count($pathway)>0)#}
                        <h6>Associated Pathways</h6>
                        <table style="width:100%">
                            <tbody>
                                {#foreach $pathway as $pw#}
                                    {#if ($pw['ec'] === $dbxref['accession'])#}
                                        <tr>
                                            <td>
                                                <a href="http://www.genome.jp/kegg-bin/show_pathway?query={#$pw['ec']#}&map=map{#$pw['accession']#}" target="_blank">{#$pw['accession']#}</a>
                                            </td>
                                            <td>{#$pw['definition']#}</td>
                                        </tr>
                                    {#/if#}
                                {#/foreach#}
                            </tbody>
                        </table>
                    {#/if#}
                {#/foreach#}
            {#/foreach#}
        </div>
    </div>
{#/if#}