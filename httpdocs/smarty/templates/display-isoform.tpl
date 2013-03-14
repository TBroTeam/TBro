{#extends file='layout.tpl'#}
{#block name='head'#}
{#call_webservice path="details/isoform" data=["query1"=>$isoform_uniquename] assign='data'#}

<!--[if lt IE 9]><script type="text/javascript" src="http://canvasxpress.org/js/flashcanvas.js"></script><![endif]-->
<script type="text/javascript" src="http://canvasxpress.org/js/canvasXpress.min.js"></script>
<!-- use chrome frame if installed and user is using IE -->
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<script type="text/javascript">
    var isoform='{#$data.isoform.uniquename#}';
            
    $(document).ready(function() {
        $.ajax('{#$ServicePath#}/graphs/genome/isoform/'+isoform, {
            success: function(val){
                new CanvasXpress(
                "canvas-{#$data.isoform.uniquename#}",
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
        $('form.blast').submit(function(event){
            queryInput = $(this).find('.query');
            query=$(queryInput.data('ref')).html();
            queryInput.val(query);
        });
    });
            
            
            
</script>
{#/block#}
{#block name='body'#}
<div class="row">
    <div class="large-12 columns panel">
        <h1>{#$data.isoform.uniquename#}</h1>
        <h5>last modified: {#$data.isoform.timelastmodified#}</h5>
        <h5>corresponding unigene: <a href="{#$AppPath#}/unigene-details/{#$data.isoform.unigene.uniquename#}">{#$data.isoform.unigene.uniquename#}</a></h5>
    </div>
</div>
<div class="row">        
    <div class="large-12 columns panel">
        <canvas id="canvas-{#$data.isoform.uniquename#}" width="910"></canvas>
        <div style="clear:both; height:1px; overflow:hidden">&nbsp;</div>
    </div>
</div>
<div class="row">
    <div class="large-12 columns panel">

        <div class="row">
            <div class="large-6 columns">
                <h2>Sequence</h2>
            </div>
            <div class="large-6 columns" style="text-align: right">
                <form class="blast" action="http://blast.ncbi.nlm.nih.gov/Blast.cgi" type="POST" target="_blank" style="display:inline">
                    <input type="hidden" name='CMD' value='Web' />
                    <input type="hidden" name='PROGRAM' value='blastx' />
                    <input type="hidden" name='BLAST_PROGRAMS' value='blastx' />
                    <input type="hidden" name='PAGE_TYPE' value='BlastSearch' />
                    <input type="hidden" name='SHOW_DEFAULTS' value='on' />
                    <input type="hidden" name='LINK' value='blasthome' />
                    <input type="hidden" class="query" data-ref="#sequence-{#$data.isoform.uniquename|clean_id#}" name="QUERY" value="" />
                    <input type="submit" class="small button" value="send to blastx">
                </form>

                <form class="blast" action="http://blast.ncbi.nlm.nih.gov/Blast.cgi" type="POST" target="_blank" style="display:inline">
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



    </div>
</div>
{#if count($data.isoform.predpeps) gt 0 #}
    <div class="row">
        <div class="large-12 columns">
            <h2>Predicted Peptides:</h2>

            <div class="row">
                <div class="large-1 columns">&nbsp;</div>
                <div class="large-10 columns">
                    {#foreach $data.isoform.predpeps as $predpep#}
                        <div class="row panel">
                            <div class="large-12 columns">

                                <div class="row">
                                    <div class="large-9 columns">
                                        <table style="width:100%">
                                            <tr><td>uniquename</td><td>{#$predpep.uniquename#}</td></tr>
                                            <tr><td>min</td><td>{#$predpep.fmin#}</td></tr>
                                            <tr><td>max</td><td>{#$predpep.fmax#}</td></tr>
                                            <tr><td>strand</td><td>{#if $predpep.strand gt 0#}right{#else#}left{#/if#}</td></tr>
                                            <tr><td>length</td><td>{#$predpep.seqlen#}</td></tr>
                                        </table>
                                    </div>
                                    <div class="large-3 columns" style="text-align: right">
                                        <form class="blast" action="http://blast.ncbi.nlm.nih.gov/Blast.cgi" type="POST" target="_blank">
                                            <input type="hidden" name='CMD' value='Web' />
                                            <input type="hidden" name='PROGRAM' value='blastp' />
                                            <input type="hidden" name='BLAST_PROGRAMS' value='blastp' />
                                            <input type="hidden" name='PAGE_TYPE' value='BlastSearch' />
                                            <input type="hidden" name='SHOW_DEFAULTS' value='on' />
                                            <input type="hidden" name='LINK' value='blasthome' />
                                            <input type="hidden" class="query" name="QUERY" value="" />
                                            <input type="submit" class="small button" data-ref="#sequence-{#$predpep.uniquename|clean_id#}" value="send to blastp">
                                        </form>
                                        <form class="blast" action="http://blast.ncbi.nlm.nih.gov/Blast.cgi" type="POST" target="_blank">
                                            <input type="hidden" name='CMD' value='Web' />
                                            <input type="hidden" name='PROGRAM' value='tblastn' />
                                            <input type="hidden" name='BLAST_PROGRAMS' value='tblastn' />
                                            <input type="hidden" name='PAGE_TYPE' value='BlastSearch' />
                                            <input type="hidden" name='SHOW_DEFAULTS' value='on' />
                                            <input type="hidden" name='LINK' value='blasthome' />
                                            <input type="hidden" class="query" name="QUERY" value="" />
                                            <input type="submit" class="small button" data-ref="#sequence-{#$predpep.uniquename|clean_id#}" value="send to tblastn">
                                        </form>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="large-12">
                                        <textarea style="height:100px;" id="sequence-{#$predpep.uniquename|clean_id#}">{#$predpep.residues#}</textarea>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="row">&nbsp;</div>
                    {#/foreach#}
                </div>
                <div class="large-1 columns">&nbsp;</div>
            </div>
        </div>
    </div>
{#/if#}

{#$data|var_dump#}
{#/block#}