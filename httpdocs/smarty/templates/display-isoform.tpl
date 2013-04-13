{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
{#call_webservice path="details/isoform" data=["query1"=>$isoform_feature_id] assign='data'#}

<!--[if lt IE 9]><script type="text/javascript" src="http://canvasxpress.org/js/flashcanvas.js"></script><![endif]-->
<script type="text/javascript" src="http://canvasxpress.org/js/canvasXpress.min.js"></script>
<!-- use chrome frame if installed and user is using IE -->
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<script type="text/javascript">
    var isoform = '{#$data.isoform.uniquename#}';
    var isoform_id = '{#$data.isoform.feature_id#}';

    $(document).ready(function() {
        $('.tabs').tabs();

        $.ajax('{#$ServicePath#}/graphs/genome/isoform/' + isoform, {
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


        $('.contains-dbxref').tooltip({
            items: "span.dbxref-tooltip",
            open: function(event, ui) {
                ui.tooltip.css("max-width", "600px");
            },
            content: function() {
                var element = $(this);
                var newElStr = $('#dbxref-tooltip').html();
                newElStr = newElStr.replace(/#dbname#/g, element.attr('data-dbname'));
                newElStr = newElStr.replace(/#accession#/g, element.attr('data-accession'));
                newElStr = newElStr.replace(/#name#/g, element.attr('data-name'));
                newElStr = newElStr.replace(/#definition#/g, element.attr('data-definition'));
                newElStr = newElStr.replace(/#dbversion#/g, element.attr('data-dbversion'));
                return newElStr;
            }
        });
    });



</script>
{#/block#}

{#block name='body'#}
<div class="contains-dbxref">
    <div id="dbxref-tooltip" style="display:none">
        <table>
            <tr><td>DbxRef</td><td>#dbname#:#accession#</td></tr>
            <tr><td>Name</td><td>#name#</td></tr>
            <tr><td>Definition</td><td>#definition#</td></tr>
            <tr><td>DB-Version</td><td>#dbversion#</td></tr>
        </table>
    </div>
    <div class="row">
        <div class="large-12 columns panel" id="description">
            <div class="row">
                <div class="large-12 columns">
                    <h1 class="left">{#$data.isoform.uniquename#}</h1>
                    <div class="right"><span class="button" onclick="cart.addItemToAll({feature_id: '{#$data.isoform.feature_id#}', name: '{#$data.isoform.name#}', type:'isoform', import: '{#$data.isoform.import#}', organism_name: '{#$data.isoform.organism_name#}'});"> add to cart -> </span></div>
                </div>
            </div>
            <h5>last modified: {#$data.isoform.timelastmodified#}</h5>
            <h5>corresponding unigene: <a href="{#$AppPath#}/unigene-details/{#$data.isoform.unigene.uniquename#}">{#$data.isoform.unigene.uniquename#}</a></h5>

            <div class="row">
                <div class="large-12 columns">
                    <canvas id="canvas_{#$data.isoform.uniquename|clean_id#}" width="600"></canvas>
                    <div style="clear:both; height:1px; overflow:hidden">&nbsp;</div>
                </div>
            </div>

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
            <div class="row">
                <div class="large-12 columns">
                    <textarea style="height:100px;" id="sequence-{#$data.isoform.uniquename|clean_id#}">{#$data.isoform.residues#}</textarea>
                </div>
            </div>

            <div class="row">
                <div class="large-12 columns">
                    {#if isset($data.isoform.blast2go) #}
                        <h4>possible description:</h4>
                        {#foreach $data.isoform.blast2go as $blast2go#}
                            <h5> {#$blast2go.value#}</h5>
                        {#/foreach#}
                    {#/if#}


                    {#if (isset($data.isoform.dbxref))#}
                        {#if (isset($data.isoform.dbxref['GO']))#}
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
                        {#/if#}

                        {#if (isset($data.isoform.dbxref['EC']))#}
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

                        {#/if#}
                    {#/if#}
                </div>
            </div>
        </div>
    </div>
    <div class="row large-12 columns"><a href="#top" class="button secondary right">back to top</a></div>


    {#if isset($data.isoform.repeatmasker) && count($data.isoform.repeatmasker) > 0 #}
        <div class="row" id="repeatmasker">
            <div class="large-12 columns">
                <h2>Repeatmasker Annotations:</h2>

                <div class="row">
                    <div class="large-12 columns panel">
                        <table style="width:100%">
                            <thead>
                                <tr><td>name</td><td>class</td><td>family</td><td>min</td><td>max</td><td>strand</td><td>length</td></tr>
                            </thead>
                            <tbody>
                                {#foreach $data.isoform.repeatmasker as $repeatmasker#}
                                    <tr>
                                        <td>{#$repeatmasker.repeat_name#}</td>
                                        <td>{#$repeatmasker.repeat_class#}</td>
                                        <td>{#$repeatmasker.repeat_family#}</td>
                                        <td>{#$repeatmasker.fmin#}</td>
                                        <td>{#$repeatmasker.fmax#}</td>
                                        <td>{#if $repeatmasker.strand gt 0#}right{#else#}left{#/if#}</td>
                                        <td>{#$repeatmasker.fmax-$repeatmasker.fmin+1#}</td>
                                    </tr>
                                {#/foreach#}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="row large-12 columns"><a href="#top" class="button secondary right">back to top</a></div>
    {#/if#}


    {#if isset($data.isoform.predpeps) && count($data.isoform.predpeps) > 0 #}
        <div class="row" id="predpep">
            <div class="large-12 columns">
                <h2>Predicted Peptides:</h2>


                <div class="row">
                    <div class="large-12 columns panel">
                        <div class="tabs">
                            <ul>
                                {#foreach $data.isoform.predpeps as $predpep#}
                                    <li><p><a href="#{#$predpep.uniquename|clean_id#}">{#if $predpep.strand gt 0#}{#$predpep.fmin#}{#else#}{#$predpep.fmax#}{#/if#}-{#if $predpep.strand gt 0#}{#$predpep.fmax#}{#else#}{#$predpep.fmin#}{#/if#}</a></p></li>
                                {#/foreach#}
                            </ul>

                            {#foreach $data.isoform.predpeps as $predpep#}
                                <div id="{#$predpep.uniquename|clean_id#}">
                                    <div class="row">
                                        <div class="large-12 columns">
                                            <table style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <td>uniquename</td>
                                                        <td>min</td>
                                                        <td>max</td>
                                                        <td>strand</td>
                                                        <td>length</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{#$predpep.uniquename#}</td>
                                                        <td>{#$predpep.fmin#}</td>
                                                        <td>{#$predpep.fmax#}</td>
                                                        <td>{#if $predpep.strand gt 0#}right{#else#}left{#/if#}</td>
                                                        <td>{#$predpep.seqlen#}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="large-9 columns">
                                            <textarea style="height:100px;" id="sequence-{#$predpep.uniquename|clean_id#}">{#$predpep.residues#}</textarea>
                                        </div>
                                        <div class="large-3 columns" style="text-align: right">
                                            <form class="blast" action="http://blast.ncbi.nlm.nih.gov/Blast.cgi" method="POST" target="_blank" style="display:inline">
                                                <input type="hidden" name='CMD' value='Web' />
                                                <input type="hidden" name='PROGRAM' value='blastp' />
                                                <input type="hidden" name='BLAST_PROGRAMS' value='blastp' />
                                                <input type="hidden" name='PAGE_TYPE' value='BlastSearch' />
                                                <input type="hidden" name='SHOW_DEFAULTS' value='on' />
                                                <input type="hidden" name='LINK' value='blasthome' />
                                                <input type="hidden" class="query" data-ref="#sequence-{#$predpep.uniquename|clean_id#}" name="QUERY" value="" />
                                                <input type="submit" class="small button"  value="send to blastp">
                                            </form>
                                            <form class="blast" action="http://blast.ncbi.nlm.nih.gov/Blast.cgi" method="POST" target="_blank" style="display:inline">
                                                <input type="hidden" name='CMD' value='Web' />
                                                <input type="hidden" name='PROGRAM' value='tblastn' />
                                                <input type="hidden" name='BLAST_PROGRAMS' value='tblastn' />
                                                <input type="hidden" name='PAGE_TYPE' value='BlastSearch' />
                                                <input type="hidden" name='SHOW_DEFAULTS' value='on' />
                                                <input type="hidden" name='LINK' value='blasthome' />
                                                <input type="hidden" class="query" data-ref="#sequence-{#$predpep.uniquename|clean_id#}" name="QUERY" value="" />
                                                <input type="submit" class="small button"  value="send to tblastn">
                                            </form>
                                        </div>
                                    </div>

                                    {#if isset($predpep.interpro) && count($predpep.interpro) > 0 #}
                                        <div class="row" id="interpro">
                                            <div class="large-12 columns">
                                                <h4>Interpro Annotations:</h4>

                                                <table style="width:100%">
                                                    <thead>
                                                        <tr><td>interpro id</td><td>fmin</td><td>fmax</td><td>evalue</td><td>database match</td><td>time executed</td><td>dbxref</td></tr>
                                                    </thead>
                                                    <tbody>
                                                        {#foreach $predpep.interpro as $interpro#}
                                                            <tr><td>{#interprolink id=$interpro.interpro_id#}</td><td>{#$interpro.fmin#}</td><td>{#$interpro.fmax#}</td>
                                                                <td>{#$interpro.evalue#}</td>
                                                                <td>{#dbxreflink dbxref=['dbname'=>$interpro.program, 'accession'=>$interpro.analysis_match_id, 'name'=>'', 'definition'=>$interpro.analysis_match_description, 'dbversion'=>$interpro.programversion]#}</td>
                                                                <td>{#$interpro.timeexecuted#}</td>
                                                                <td>
                                                                    {#if isset($interpro.dbxref) && count($interpro.dbxref)>0 #}
                                                                        <ul style="list-style: none">
                                                                            {#foreach $interpro.dbxref as $dbxref#}
                                                                                <li>{#dbxreflink dbxref=$dbxref#} </li>
                                                                            {#/foreach#}
                                                                        </ul>
                                                                    {#/if#}
                                                                </td>
                                                            </tr>
                                                        {#/foreach#}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    {#/if#}
                                </div>
                            {#/foreach#}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    {#/if#}
</div>
<div class="row large-12 columns"><a href="#top" class="button secondary right">back to top</a></div>

{#include file="display-isoform-barplot.tpl"#}
{#/block#}
