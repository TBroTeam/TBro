{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
{#call_webservice path="details/unigene" data=["query1"=>$unigene_feature_id] assign='data'#}
{#/block#}
{#block name='body'#}

<div class="row">
    <div class="large-12 columns panel">
        <div class="row">
            <div class="large-12 columns">
                <h1 class="left">{#$data.unigene.uniquename#}</h1>
                <div class="right"><span class="button" onclick="$.ajax({url:'{#$ServicePath#}/details/cartitem/{#$data.unigene.feature_id#}', success: cart.addItemToAll});"> add to cart -> </span></div>
            </div>
        </div>
        <h5>last modified: {#$data.unigene.timelastmodified#}</h5>
    </div>
</div>

<div class="row">        
    <div class="large-12 columns panel">
        <p>known isoforms:</p>
        <table>
            {#foreach $data.unigene.isoforms as $isoform#}
                <tr>
                    <td>
                        <a href='{#$AppPath#}/isoform-details/byId/{#$isoform.feature_id#}'>{#$isoform.uniquename#}</a>
                    </td><td>
                        <div class="right"><span class="small button" onclick="$.ajax({url:'{#$ServicePath#}/details/cartitem/{#$isoform.feature_id#}', success: cart.addItemToAll});"> add to cart -> </span></div>
                    </td>
                </tr>
            {#/foreach#}
        </table>
    </div>
</div>

{#/block#}