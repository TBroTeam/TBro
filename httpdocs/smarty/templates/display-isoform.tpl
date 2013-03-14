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
                console.log(val);
                console.log(val.tracks);
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
            
    });
            
            
            
</script>
{#/block#}
{#block name='body'#}
<div class="row">
    <div class="large-12 columns">
        <div class="panel">
            <h1>{#$data.isoform.uniquename#}</h1>
            <h5>last modified: {#$data.isoform.timelastmodified#}</h5>
            <h5>corresponding unigene: {#$data.isoform.unigene.uniquename#}</h5>
        </div>
    </div>
</div>
<div class="row">        
    <div class="large-12 columns">
        <div class="panel">
        <canvas id="canvas-{#$data.isoform.uniquename#}" width="910"></canvas>
           <div style="clear:both; height:1px; overflow:hidden">&nbsp;</div>
        </div>
    </div>
</div>
<div class="row">        
    <div class="large-12 columns">
        <div class="panel" style="word-wrap: break-word;">
            <h2>Sequence</h2>
            <p>
                {#$data.isoform.residues#}
            </p>
        </div>
    </div>
</div>

{#$data|var_dump#}
{#/block#}