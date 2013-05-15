{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
<script type="text/javascript">
    $(document).ready(function(){
        $('#start-multisearch').click(function(){
            $('.results').hide(500);
            $.ajax({
                url: "{#$ServicePath#}/listing/multisearch/",
                data: {species: organism.val(), release: release.val(), longterm: $('#multisearch').val()},
                dataType: "json",
                success: function(data) {
                    var res = $('#results');
                    var btn = $('#btn_addToCart').children().first().clone().removeAttr('id');
                    res.empty();
                    var cnt=0;
                    $.each(data.results, function(){
                        console.log(this);
                        var field;
                        var row = $("<tr/>");
                        $("<td/>").text(this.type).appendTo(row);
                        $("<td/>").text(this.name).appendTo(row);
                        $("<td/>").append(btn.clone().attr('data-id', this.id)).appendTo(row);
                        row.appendTo(res);
                        cnt++;
                    });
                    if (cnt>0)
                        $('.results').show(500);
                }
            });
        });
    });
</script>
{#/block#}

{#block name='body'#}
<div class="row">
    <div class="large-12 column">
        <h1>Advanced Search</h1>
    </div>
    
    <div class="large-12 column">
        <p>
        This field allows you to search for as many unigenes or isoforms as you want at once. <br/>
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
        <a id="start-multisearch" class="button"/>search</a>
    </div>
</div>
<div class="row results" style="display:none">
    <div class="large-12 column">
        <h2>Results</h2>
    </div>
</div>
<div class="row results" style="display:none">
    <div class="large-12 column">
        <table style="width:100%">
            <tbody id="results">
            </tbody>
        </table>
    </div>
</div>

<div style="display:none" id="btn_addToCart">
    <span class="small button right" onclick="$.ajax({url:'{#$ServicePath#}/details/cartitem/'+$(this).attr('data-id'), success: cart.addItemToAll});"> add to cart -> </span>
</div>
{#/block#}