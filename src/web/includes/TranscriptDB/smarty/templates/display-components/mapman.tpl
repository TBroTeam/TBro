{#call_webservice path="details/annotations/feature/mapman" data=["query1"=>$feature.feature_id] assign='mapman'#}

{#if (count($mapman)>0)#}
    <div class="row contains-tooltip">
        <div class="large-12 columns panel">                    
            <h4>MapMan Annotation</h4>
            <table style="width:100%">
                <tbody>
                    {#foreach $mapman as $hit#}
                        <tr>
                            <td style="font-size:100%">
                                <table style="width:100%; margin-bottom:0px">
                                    <tr><th style="font-size:100%">Annotation:</th><td style="font-size:100%">{#$hit['annotation']#}</td></tr>
                                    <tr><th style="font-size:100%">Bincode:</th><td style="font-size:100%">{#$hit['bin_accession']#}: {#$hit['bin_definition']#}</td></tr>
                                    {#if isset($hit['bin_annotations']) && count($hit['bin_annotations'])>0 #}
                                        <tr><th style="font-size:100%">Bincode Annotations:</th><td>
                                                <table style="width:100%; margin-bottom:0px">
                                                    {#foreach $hit['bin_annotations'] as $bin_annot#}
                                                        <tr><td></td><td style="font-size:100%">{#$bin_annot['bin_annot_chem']#}</td><td>{#$bin_annot['bin_annot_definition']#}</td></tr>
                                                    {#/foreach#}
                                                </table>
                                            </td>
                                        </tr>
                                    {#/if#}
                                </table>
                            </td>
                        </tr>
                    {#/foreach#}
                </tbody>
            </table>
        </div>
    </div>
{#/if#}
