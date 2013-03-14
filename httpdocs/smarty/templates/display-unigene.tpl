{#extends file='layout.tpl'#}
{#block name='head'#}
{#call_webservice path="details/unigene" data=["query1"=>$unigene_uniquename] assign='data'#}
{#/block#}
{#block name='body'#}

<div class="row">
    <div class="large-12 columns">
        <div class="panel">
            <h1>{#$data.unigene.uniquename#}</h1>
            <h5>last modified: {#$data.unigene.timelastmodified#}</h5>
        </div>
        <div class="panel">
            <p>known isoforms:</p>
            <table>
                <tbody>
                    {#foreach $data.unigene.isoforms as $isoform_uniquename#}
                        <tr>
                            <td><a href='{#$AppPath#}/isoform-details/{#$isoform_uniquename#}'>{#$isoform_uniquename#}</a></td>
                        </tr>
                    {#/foreach#}
                </tbody>
            </table>
        </div>
    </div>
</div>

{#/block#}