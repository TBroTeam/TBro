{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
{#call_webservice path="details/isoform" data=["query1"=>$isoform_feature_id] assign='data'#}

<!--[if lt IE 9]><script type="text/javascript" src="http://canvasxpress.org/js/flashcanvas.js"></script><![endif]-->
<script type="text/javascript" src="http://canvasxpress.org/js/canvasXpress.min.js"></script>
<!-- use chrome frame if installed and user is using IE -->
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<script type="text/javascript">
    var feature_id = '{#$data.isoform.feature_id#}';

    $(document).ready(function() {
        $('.tabs').tabs();

        $.ajax('{#$ServicePath#}/graphs/genome/isoform/' + feature_id, {
            success: function(val) {
                canvas = $('#canvas_{#$data.isoform.uniquename|clean_id#}');
                canvas.attr('width', canvas.parent().width() - 8);
                if (val.tracks.length == 0)
                    return;
                new CanvasXpress(
                "canvas_{#$data.isoform.uniquename|clean_id#}",
                {
                    "tracks": val.tracks
                },
                {
                    graphType: 'Genome',
                    useFlashIE: true,
                    backgroundType: 'gradient',
                    backgroundGradient1Color: 'rgb(0,183,217)',
                    backgroundGradient2Color: 'rgb(4,112,174)',
                    oddColor: 'rgb(220,220,220)',
                    evenColor: 'rgb(250,250,250)',
                    missingDataColor: 'rgb(220,220,220)',
                    setMin: val.min,
                    setMax: val.max
                }
            );
            }
        });
        $('form.blast').submit(function(event) {
            queryInput = $(this).find('.query');
            query = $(queryInput.data('ref')).html();
            queryInput.val(query);
        });
        
        $('.contains-tooltip').tooltip({
            items: ".has-tooltip",
            open: function(event, ui) {
                /*ui.tooltip.offset({
                top: event.pageY, 
                left: event.pageX
            });*/
                ui.tooltip.css("max-width", "600px");
            },
            content: function() {
                var element = $(this);
                var tooltip = $("<table/>");
                console.log(this.attributes);
                
                $.each(this.attributes, function(key,attr) {
                    if (attr.name.substr(0,5)=='data-'){
                        var splitAt = attr.nodeValue.indexOf('|');
                        var name = attr.nodeValue.substr(0,splitAt);
                        var value = attr.nodeValue.substr(splitAt+1);
                        $("<tr><td>" + name + "</td><td>" + value + "</td></tr>").appendTo(tooltip);
                    }
                });
                tooltip.foundation();
                return tooltip;
            }
        });
    });

    

    function jumptoanchor(name){
        $(document.body).scrollTop($('#'+name).offset().top-45);
        
    }
    
</script>
<script type="text/javascript" src="{#$AppPath#}/js/feature/barplot.js"></script>
{#/block#}
{#block name='header-nav'#}
<li class="has-dropdown"><a href="#">QuickNav</a>
    <ul class="dropdown">
        <li><a href="javascript:jumptoanchor('isoform-overview');">Isoform Overview</a></li>
        <li><a href="javascript:jumptoanchor('isoform-browser');">Isoform Browser</a></li>
        <li><a href="javascript:jumptoanchor('isoform-annotations');">Isoform Annotations</a></li>
    {#if isset($data.isoform.repeatmasker) && count($data.isoform.repeatmasker) > 0 #}<li><a href="javascript:jumptoanchor('repeatmasker-annotations');">Repeatmasker Annotations</a></li>{#/if#}
{#if isset($data.isoform.predpeps) && count($data.isoform.predpeps) > 0 #}<li><a href="javascript:jumptoanchor('predpeps');">Predicted Peptides</a></li>{#/if#}
</ul>
</li>
{#/block#}
{#block name='body'#}

<div>
    <div class="row">
        <div id="isoform-overview"> </div>
        <div class="large-12 columns panel" id="description">
            <div class="row">
                <div class="large-12 columns">
                    <h1 class="left">{#$data.isoform.name#}</h1>
                    <div class="right"><span class="button" onclick="$.ajax({url:'{#$ServicePath#}/details/cartitem/{#$data.isoform.feature_id#}', success: cart.addItemToAll});"> add to cart -> </span></div>
                </div>
            </div>
            <table style="width:100%">
                <tbody>
                    <tr><td>Last modified</td><td>{#$data.isoform.timelastmodified#}</td></tr>
                    <tr><td>Corresponding unigene</td><td><a href="{#$AppPath#}/details/byId/{#$data.isoform.unigene.feature_id#}">{#$data.isoform.unigene.uniquename#}</a></td></tr>
                    <tr><td>Release</td><td>{#$data.isoform.import#}</td></tr>
                    <tr><td>Organism</td><td>{#$data.isoform.organism_name#}</td></tr>
                </tbody>
            </table>
        </div>
    </div>                
    <div id="isoform-browser"> </div>
    <div class="row">
        <div class="large-12 columns">
            <h4>Isoform Browser</h4>
        </div>
        <div class="large-12 columns panel">
            <canvas id="canvas_{#$data.isoform.uniquename|clean_id#}" width="600"></canvas>
            <div style="clear:both; height:1px; overflow:hidden">&nbsp;</div>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <div class="row">
                <div class="large-6 columns">
                    <h4>Sequence</h4>
                </div>
                <div class="large-6 columns" style="text-align: right">
                    <form class="blast" action="http://blast.ncbi.nlm.nih.gov/Blast.cgi" method="POST" target="_blank" style="display:inline">
                        <input type="hidden" name='CMD' value='Web' />
                        <input type="hidden" name='PROGRAM' value='blastx' />
                        <input type="hidden" name='BLAST_PROGRAMS' value='blastx' />
                        <input type="hidden" name='PAGE_TYPE' value='BlastSearch' />
                        <input type="hidden" name='SHOW_DEFAULTS' value='on' />
                        <input type="hidden" name='LINK' value='blasthome' />
                        <input type="hidden" class="query" data-ref="#sequence-{#$data.isoform.uniquename|clean_id#}" name="QUERY" value="" />
                        <input type="submit" class="small button" value="send to blastx">
                    </form>

                    <form class="blast" action="http://blast.ncbi.nlm.nih.gov/Blast.cgi" method="POST" target="_blank" style="display:inline">
                        <input type="hidden" name='CMD' value='Web' />
                        <input type="hidden" name='PROGRAM' value='blastn' />
                        <input type="hidden" name='BLAST_PROGRAMS' value='megaBlast' />
                        <input type="hidden" name='PAGE_TYPE' value='BlastSearch' />
                        <input type="hidden" name='SHOW_DEFAULTS' value='on' />
                        <input type="hidden" name='LINK' value='blasthome' />
                        <input type="hidden" class="query" data-ref="#sequence-{#$data.isoform.uniquename|clean_id#}" name="QUERY" value="" />
                        <input type="submit" class="small button" value="send to blastn">
                    </form>
                </div>
            </div>
        </div>
        <div class="large-12 columns panel">
            <textarea style="height:100px;" id="sequence-{#$data.isoform.uniquename|clean_id#}">{#$data.isoform.residues#}</textarea>
        </div>
    </div>
    <div id="isoform-annotations"> </div>
    {#if isset($data.isoform.description) #}
        <div class="row">
            <div class="large-12 columns panel">
                <h4>possible description:</h4>
                {#foreach $data.isoform.description as $description#}
                    <h5> {#$description.value#}</h5>
                {#/foreach#}

            </div>
        </div>
    {#/if#}

    {#if (isset($data.isoform.dbxref))#}                
        {#if (isset($data.isoform.dbxref['GO']))#}
            <div class="row contains-tooltip">
                <div class="large-12 columns panel">                    
                    <h4>Gene Ontology</h4>
                    {#foreach $data.isoform.dbxref['GO'] as $namespace=>$dbxarr#}
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


        {#if (isset($data.isoform.dbxref['EC']))#}
            <div class="row contains-tooltip">
                <div class="large-12 columns panel">
                    <h4>Enzyme classifications</h4>
                    {#foreach $data.isoform.dbxref['EC'] as $namespace=>$dbxarr#}
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
    {#/if#}
    {#if isset($data.isoform.pub) && count($data.isoform.pub) > 0 #}
        <div id="isoform-publications"> </div>
        <div class="row">
            <div class="large-12 columns panel">
                <h4>Publications</h4>                        
                <table style="width:100%">
                    <tbody class="contains-tooltip">
                        {#foreach $data.isoform.pub as $pub#}
                            {#publink pub=$pub#}
                        {#/foreach#}
                    </tbody>
                </table>
            </div>
        </div>
    {#/if#}


    {#if isset($data.isoform.repeatmasker) && count($data.isoform.repeatmasker) > 0 #}
        {#include file="display-components/repeatmasker.tpl" isoform=$data.isoform #}
    {#/if#}


    {#if isset($data.isoform.predpeps) && count($data.isoform.predpeps) > 0 #}
        {#include file="display-components/predpeps.tpl" isoform=$data.isoform #}
    {#/if#}
</div>

{#include file="display-components/barplot.tpl"#}
{#/block#}
