<?php /* Smarty version Smarty-3.1.13, created on 2013-06-11 17:19:05
         compiled from "C:\Users\mail_000\Dropbox\uni\bio\s202139\web\smarty\templates\blast_results.tpl" */ ?>
<?php /*%%SmartyHeaderCode:628851af6f782580d6-43074241%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5ff7481f5ef94bf202bdc068c5833ab23db2d0f2' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\blast_results.tpl',
      1 => 1370963911,
      2 => 'file',
    ),
    'c44393500e69763bf56453147eb3e23dada271cd' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\layout-with-cart.tpl',
      1 => 1370435050,
      2 => 'file',
    ),
    'c9e223e75317f40ea70fe3d34aff134ea2c81027' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\layout.tpl',
      1 => 1370963911,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '628851af6f782580d6-43074241',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51af6f7828e9c8_85740464',
  'variables' => 
  array (
    'AppPath' => 0,
    'organism' => 0,
    'release' => 0,
    'default_organism' => 0,
    'default_release' => 0,
    'ServicePath' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51af6f7828e9c8_85740464')) {function content_51af6f7828e9c8_85740464($_smarty_tpl) {?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <!--meta name="viewport" content="width=device-width" /-->
        <title>Transcript Browser - dionaea muscipula</title>

        <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/css/normalize.css" />
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/css/foundation.css" />
        <!--link type="text/css" href="http://code.jquery.com/ui/1.10.1/themes/base/minified/jquery-ui.min.css" rel="Stylesheet" /-->    
        <link type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/css/custom-theme/jquery-ui-1.10.2.custom.css" rel="Stylesheet" />    

        <!--script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script-->
        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/jquery-1.9.1.min.js"></script>
        <!--script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script-->
        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/jquery-ui-1.10.2.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/vendor/custom.modernizr.js"></script>
        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/foundation.min.js"></script>        
        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/jquery.webStorage.min.js"></script>        
        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/underscore-min.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/TableTools.min.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/alphanum.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/feature/datatable-init.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/sprintf.min.js"></script>
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/css/jquery.dataTables_themeroller.css" />
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/css/TableTools.css" />

        <script type="text/javascript">
            var organism;
            var release;
            $(document).ready(function() {
                $(document).foundation();

                organism = $('#select_organism');
                release = $('#select_release');
                
            <?php if (isset($_smarty_tpl->tpl_vars['organism']->value)){?>
                    selected_organism_id = '<?php echo $_smarty_tpl->tpl_vars['organism']->value;?>
';    
                    selected_release = '<?php echo $_smarty_tpl->tpl_vars['release']->value;?>
';
            <?php }else{ ?>
                    selected_organism_id = $.webStorage.session().getItem('selected_organism_id');
                    if (selected_organism_id == null){
                        selected_organism_id = '<?php echo $_smarty_tpl->tpl_vars['default_organism']->value;?>
';
                    }
                    selected_release = $.webStorage.session().getItem('selected_release');
                    if (selected_release == null){
                        selected_release = '<?php echo $_smarty_tpl->tpl_vars['default_release']->value;?>
';
                    }
            <?php }?>
                
                
                    var rel_release = null;

                    $.ajax({
                        url: "<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/listing/organism_release",
                        dataType: "json",
                        success: function(data) {
                            organism.empty();
                            $.each(data.results.organism, function() {
                                var option = $('<option/>').val(this.organism_id).text(this.organism_name);
                                if (this.organism_id == selected_organism_id){
                                    option.attr('selected','selected');
                                }
                                option.appendTo(organism);
                            });
                            rel_release = data.results.release;
                            organism.change();
                        }
                    });

                    organism.change(function() {
                        $.webStorage.session().setItem('selected_organism_id', organism.val());
                    
                        release.empty();
                        release.removeAttr('disabled');
                        if (rel_release[organism.val()] == undefined) {
                            release.attr('disabled', 'disabled');
                            $('<option/>').val('').text('/').appendTo(release);
                        } else {
                            $.each(rel_release[organism.val()], function() {
                                var option = $('<option/>').val(this.release).text(this.release);
                                if (this.release == selected_release){
                                    option.attr('selected','selected');
                                }
                                option.appendTo(release);
                            });
                        }
                        release.change();
                    });
                
                    release.change(function(){
                        $.webStorage.session().setItem('selected_release', release.val());    
                    });

                    $("#search_unigene").autocomplete({
                        position: {
                            my: "right top", at: "right bottom"
                        },
                        source: function(request, response) {
                            $.ajax({
                                url: "<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/listing/searchbox/",
                                data: {species: organism.val(), release: release.val(), term: request.term},
                                dataType: "json",
                                success: function(data) {
                                    response(data.results);
                                }
                            });
                        },
                        minLength: 2,
                        select: function(event, ui) {
                            location.href = "<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/details/byId/" + ui.item.id;
                        }
                    });
                    $("#search_unigene").data("ui-autocomplete")._renderItem = function(ul, item) {
                        var li = $("<li>")
                        .append("<a href='<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/details/byId/" + item.id + "'><span style='display:inline-block; width:100px'>" + item.type + "</span>" + item.name + "</a>")
                        .appendTo(ul);
                        return li;
                    };
                });
        </script>
        <script type="text/javascript">
            function jumptoanchor(name){
                $(document.body).scrollTop($('#'+name).offset().top-45);
        
            }
    
            function addNavAnchor(name, linktext){
                if ($('#quicknav-pageheader').length==0){
                    $('#quicknav').append('<li class="divider" id="quicknav-pageheader"></li><li><a>on this page</a></li><li class="divider"></li>');
                }
                $('#quicknav').append('<li><a href="javascript:jumptoanchor(\'anchor-'+name+'\');">'+linktext+'</a></li>');
                document.write('<div id="anchor-'+name+'"> </div>');
            }
        </script>
        <style>
            .ui-tooltip-content table{
                margin-bottom: 0px;
            }
            textarea {
                resize:vertical;
            }
            .top-bar-section .right li div{
                padding: 0 5px;
                line-height: 45px;
                background: #111111; 
                display:block;
            }

            .top-bar-section .right li {
                height:45px;
            }

            .top-bar-section .right a {
                text-decoration: underline;
            }

            .top-bar-section .right label {
                color: #fff;
            }
        </style>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.position').each(function(){
                    var that = $(this);
                    var my = that.attr('data-my');
                    var at = that.attr('data-at');
                    var of = that.attr('data-of');
                    of = of=='PREV'?that.prev():of;
                    console.log(of);
                    that.position({my: my, at: at, of: of});
                });
            });
        </script>

        
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/feature/cart.js"></script>
<style>
    .ui-accordion .ui-accordion-header {
        margin-bottom:0px;
    }
    .ui-accordion .ui-accordion-content {
        padding: 0.5em 1em;
    }
    .beingDragged {
        list-style: none;
    }
    *[class*='cart-button-']{
        cursor: pointer;
    }

    fieldset *:last-child{
        margin-bottom: 0px;
    }

    form {
        margin: 0px;
    }
</style>

<!--[if lt IE 9]><script type="text/javascript" src="http://canvasxpress.org/js/flashcanvas.js"></script><![endif]-->
<script type="text/javascript" src="http://canvasxpress.org/js/canvasXpress.min.js"></script>
<!-- use chrome frame if installed and user is using IE -->
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<script type="text/javascript">

    var blast_results;
    var templates;
    var resultTable;
    var resultData;
    var parsedXml;
    
    var colorKey = {
        40: 'rgb(0,0,0)',
        50: 'rgb(0,0,255)',
        80: 'rgb(127,255,0)',
        200: 'rgb(255,20,147)',
        Infinity: 'rgb(255,0,0)'
    };
    
    function parse_children(skip_children, regexp, nodes){
        var ret = {};
        nodes.each(function(){
            if ($.inArray(this.nodeName, skip_children)>=0){
                return;
            }
            var matches = this.nodeName.match(regexp);
            var val = parseFloat($(this).text());
            ret[matches[1]] = isNaN(val) ? $(this).text() : val;
        });
        return ret;
    }
    
    function cut_alignment(qseq, hseq, midline, line_length, qseq_start, hseq_start){
        var ret = [];
        var qseq_pos = qseq_start;
        var hseq_pos = hseq_start;
        
        for (var i=0; i<qseq.length; i+=line_length){
            
            var qseq_sub = qseq.substring(i, i+line_length);
            var qseq_gaps = (qseq_sub.match(/\-/g)||[]).length;
            var hseq_sub = hseq.substring(i, i+line_length);
            var hseq_gaps = (hseq_sub.match(/\-/g)||[]).length;
            
            var chunk = {
                qseq:    qseq_sub,
                qseq_start: qseq_pos,
                qseq_end  : qseq_pos + qseq_sub.length - 1 - qseq_gaps,
                hseq:    hseq_sub,
                hseq_start: hseq_pos,
                hseq_end  : hseq_pos + hseq_sub.length - 1 - hseq_gaps,
                midline: midline.substring(i, i+line_length)
            };
            
            qseq_pos += line_length - qseq_gaps;
            hseq_pos += line_length - hseq_gaps;
            
            ret.push(chunk);
        }
        return ret;
    }
    
    function fmtScientific(val){
        if (val == 0)
            return val;
        if (val < 0.001)
            return sprintf('%.3e', val);
        return sprintf('%.3f',val);
    }
    
    var fnMDataScientific = function(storeValue){
        return function ( data, type, val ) {
            if (type === 'set') {
                data[storeValue] = val;
                return;
            }
            else if (type === 'display') {
                return fmtScientific(data[storeValue]);
            }
            return data[storeValue];
        }
    };

    function openCloseDetails(){
        if ( resultTable.fnIsOpen(this) ) {
            resultTable.fnClose( this );
        } else {
            var aData = resultTable.fnGetData( this );
            resultTable.fnOpen( this, templates.PROCESSED_HIT({hit: aData}), 'details' );
        }
    }

    function display_processed_job(results){
        resultData = results;
        var parmRx = /^Parameters_(.*)$/;
        var iterRx = /^Iteration_(.*)$/;
        var hitRx = /^Hit_(.*)$/;
        var hspRx = /^Hsp_(.*)$/;
        var jqR = $($.parseXML( results.job_results ));
        var execDetails = {
            program: jqR.find('BlastOutput_program').text(),
            version: jqR.find('BlastOutput_version').text(),
            reference: jqR.find('BlastOutput_reference').text()
        };
        execDetails.parameters = parse_children([], parmRx, jqR.find('BlastOutput_param Parameters').children());
        
        var iterations = [];
        jqR.find('BlastOutput_iterations Iteration').each(function(){
            var jqIt = $(this);
            var iteration = parse_children(['Iteration_hits', 'Iteration_stat'], iterRx, jqIt.children());
            
            iteration.hits = [];
            
            jqIt.find('Iteration_hits Hit').each(function(){
                var jqHit = $(this);
                var hit = parse_children(['Hit_hsps'], hitRx, jqHit.children());
                var hitcoverage = [];
                for (var i=1; i<=iteration['query-len']; i++){
                    hitcoverage[i]=false;
                }
                hit.hsps = [];
                hit.def_firstword = hit.def.substr(0,hit.def.indexOf(' '));
                hit.max_score = 0;
                hit.max_ident = 0;
                hit.total_score = 0;
                hit.evalue = Infinity;
                jqHit.find('Hsp').each(function(){
                    var jqHsp=$(this);
                    var hsp = parse_children([], hspRx, jqHsp.children());
                    for (var i=hsp['query-from']; i<=hsp['query-to']; i++){
                        hitcoverage[i]=hsp.hseq[i-1]!=='-';
                    }
                    hit.max_score = Math.max(hit.max_score, hsp.score);
                    hit.max_ident = Math.max(hit.max_ident, hsp.identity/(hsp['align-len']));
                    hit.total_score += hsp.score;
                    hit.evalue = Math.min(hit.evalue, hsp.evalue);
                    hit.hsps.push(hsp);
                });                
                hit.query_coverage = _.compact(hitcoverage).length/iteration['query-len'];
                iteration.hits.push(hit);
            });
            iterations.push(iteration);
        });
           
        parsedXml = {execDetails:execDetails, iterations:iterations};   
           
        console.log(parsedXml);           
           
        blast_results.empty().html(templates['PROCESSED'](parsedXml));
        $('#iteration_select').change();
    }
    
    function displayIterationGraph(iteration, canvasId){
        var colorForScore = function(score){
            for( var k in colorKey ) {
                if(colorKey.hasOwnProperty(k)) {
                    if (score<k)
                        return colorKey[k];
                }
            }
        };
        var tracks = [];
        var track = {
            type: 'box',
            data: [{
                    id: iteration['query-ID'],
                    fill: 'rgb(255,0,0)',
                    outline: 'rgb(0,0,0)',
                    data: [[1, iteration['query-len']]]
                }]
        };
        tracks.push(track);
        
       
        _.each(iteration.hits, function(hit){
            var track = {
                hit: hit,
                type: 'box',
                data: [{
                        id: hit['def_firstword'],
                        fill: [],
                        outline: 'rgb(0,0,0)',
                        data: []
                    }]
            };
            _.each(hit.hsps, function(hsp){
                track.data[0].data.push([hsp['query-from'], hsp['query-to']]);
                track.data[0].fill.push(colorForScore(hsp['score']));
            });
            tracks.push(track);
        });
        
        canvas = $('#'+canvasId);
        canvas.attr('width', canvas.parent().width() - 8);
        console.log(canvas.parent());
        new CanvasXpress(
        canvasId,
        {
            min:0,
            max:iteration['query-len']+1,
            tracks: tracks
        },{
            graphType: 'Genome',
            useFlashIE: true,
            backgroundType: 'gradient',
            backgroundGradient1Color: 'rgb(0,183,217)',
            backgroundGradient2Color: 'rgb(4,112,174)',
            oddColor: 'rgb(220,220,220)',
            evenColor: 'rgb(250,250,250)',
            missingDataColor: 'rgb(220,220,220)'            
        },
        {
            click: function(o) {
                var hit = o[0].hit;
                if (typeof hit == "undefined") return;
                var aSettings = resultTable.fnSettings();
                $.each (aSettings.aoData, function (){
                    var aData = this._aData;
                    if (_.isEqual(aData, hit)){
                        this.nTr.click();
                        $(document.body).animate({scrollTop: $(this.nTr).offset().top-75}, 'fast');
                        return false;
                    }
                });
            }
        }
    );
    }
    
    function displayIteration(iteration){
        console.log(iteration);
        displayIterationGraph(iteration, 'alignmentGraph');
        if (typeof resultTable == "undefined"){
            resultTable = $('#blast_results_table').dataTable({
                aaSorting: [[ 2, "desc" ]],
                aaData: iteration.hits,
                bPaginate: false,
                bFilter: false,
                aoColumns: [
                    /*{ mData: function(){return '<a href="javascript:triggerDetails(this);">details</a>';}, bSortable: false },*/
                    { mData: "def_firstword", sTitle:"id" },
                    { mData: "max_score", sTitle:"max score" },
                    { mData: "total_score", sTitle:"total score" },
                    { mData: fnMDataScientific("query_coverage"), sTitle:"coverage" },
                    { mData: fnMDataScientific("evalue"), sTitle:"evalue" },
                    { mData: fnMDataScientific("max_ident"), sTitle:"max identity" }
                ],
                fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $(nRow).find('td:eq(0)').html( '<a target="_blank" href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/details/byOrganismReleaseName/'+resultData.additional.organism+'/'+resultData.additional.release+'/'+aData.def_firstword+'#'+aData.def_firstword.replace('.','_')+'">'+aData.def_firstword+'</a>' );
                    $(nRow).css( 'cursor', 'pointer' );
                }
            });
            resultTable.on('click','tr',openCloseDetails);
        } else {
            resultTable.fnClearTable();
            resultTable.fnAddData(iteration.hits);
        }
    }
    

    var check_job_status = function () {
        $.ajax('<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/blast/job_status/<?php echo $_smarty_tpl->tpl_vars['job_uuid']->value;?>
', {
            success: function(ret) {
                switch (ret.job_status) {
                    case 'ERROR':
                        break;
                    case 'PROCESSING':
                        setTimeout(check_job_status, 2000);
                        break;
                    case 'NOT PROCESSED':
                        setTimeout(check_job_status, 2000);
                        break;
                    case 'UNKNOWN':
                        setTimeout(check_job_status, 2000);
                        break;
                    case 'PROCESSED':
                        display_processed_job(ret);
                        return;
                        break;
                    default:
                        //should not happen, quit
                        return;
                };
                blast_results.empty().html(templates[ret.job_status](ret));
            }
        });
    }

    $(document).ready(function() {
        blast_results = $('#blast_results');

        templates = {
            ERROR: _.template($('#template_error').html()),
            PROCESSING: _.template($('#template_processing').html()),
            "NOT PROCESSED": _.template($('#template_not_processed').html()),
            UNKNOWN: _.template($('#template_unknown').html()),
            PROCESSED: _.template($('#template_processed').html()),
            PROCESSED_HIT: _.template($('#template_hit').html()),
            PROCESSED_HSP: _.template($('#template_hsp').html())
        };
        check_job_status();
        
        $(document).on('change','#iteration_select', function(){
            displayIteration(parsedXml.iterations[$(this).val()]);
        });
    });
</script>

<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/feature/cart-init.js"></script>


    </head>
    <body>
        <div class="fixed">
            <nav class="top-bar" id="top">
                <ul class="title-area">
                    <li class="name">
                        <h1><a href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/">Transcript Browser</a></h1>
                    </li>
                </ul>
                <section class="top-bar-section">
                    <ul class="left">
                        <li class="has-dropdown"  id="quicknav-parent"><a href="#">QuickNav</a>
                            <ul class="dropdown" id="quicknav">
                                <li><a href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/diffexpr">Differential Expressions</a></li>
                                <li><a href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/blast">Blast</a></li>
                            </ul>
                        </li>
                        </ul>
                    <ul class="right">
                        <li><div><label for="select_organism">organism:</label></div></li>
                        <li><div><select id="select_organism" style="display:inline"></select></div></li>
                        <li><div><label for="select_release">release:</label></div></li>
                        <li><div><select id="select_release"></select></div></li>
                        <li class="divider"></li>
                        <li><a href='<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/multisearch'>adv. search</a></li>
                        <li class="divider"></li>
                        <li><div><label for="search">quick search:</label></div></li>
                        <li class="has-form"><input type="search" id="search_unigene"/></li>
                    </ul>
                </section>
            </nav>
        </div>
        <div class="row large-12 columns" style="padding: 0px;">
            
<div class="row">
    <div class="large-9 columns">
        
<script type="text/template" id="template_error">
    <div class="large-12 columns panel">
        There has been an error processing your job.<br/>
        Please review your job.<br/>
        If this keeps happening, notify the the administrator.<br/><br/><br/>
        These errors occured:<br/>
        <pre><<?php ?>%= errors %<?php ?>></pre>
    </div>
</script>
<script type="text/template" id="template_processing">
    <div class="large-12 columns panel">
        Your job is currently being processed. Please wait a moment.<br/>
        This page will refresh in 2 seconds.
    </div>
</script>
<script type="text/template" id="template_not_processed">
    <div class="large-12 columns panel">
        Still in queue (position <<?php ?>%=queue_position%<?php ?>> of <<?php ?>%=queue_length%<?php ?>>). You may bookmark this page for later use.<br/>
        This page will refresh in 2 seconds.
    </div>
</script>
<script type="text/template" id="template_unknown">
    <div class="large-12 columns panel">
        Job status can currently not be retreived. Please bookmark this page and try again later.<br/>
        This page will refresh in 2 seconds.
    </div>
</script>
<script type="text/template" id="template_processed">
    <div class="large-12 columns panel">
        <table>
            <tr><th>Program</th><td><<?php ?>%= execDetails.program %<?php ?>></td></tr>
            <tr><th>Version</th><td><<?php ?>%= execDetails.version %<?php ?>></td></tr>
            <tr><th>Reference</th><td><<?php ?>%= execDetails.reference %<?php ?>></td></tr>
            <tr>
                <th>Parameters:</th>
                <td>
                    <table>
                        <<?php ?>% _.each(execDetails.parameters, function(value,key){ %<?php ?>>
                        <tr><th><<?php ?>%= key %<?php ?>></th><td><<?php ?>%= value %<?php ?>></td></tr>
                        <<?php ?>% }); %<?php ?>>
                    </table>
                </td>
            </tr>
        </table>
        <div class="row">
            <div class="large-12 columns panel">
                Select an Iteration: <br/>
                <select id="iteration_select">
                    <<?php ?>% _.each(iterations, function(iteration, idx){ %<?php ?>>
                    <option value="<<?php ?>%=idx%<?php ?>>"><<?php ?>%= iteration['query-ID'] %<?php ?>>: <<?php ?>%= iteration['query-def'] %<?php ?>></option>
                    <<?php ?>% }); %<?php ?>>
                </select>
            </div>
        </div>

        <div class="large-centered large-6 columns ">
            <table style="width:100%;">
                <tr><th colspan="42">Color key for alignment scores</th></tr>
                <tr>
                    <<?php ?>% var lastMax; _.each(colorKey, function(color, maxVal){ %<?php ?>>
                    <th style="background-color: <<?php ?>%= color %<?php ?>>; color: white"><<?php ?>% if (maxVal == Infinity) { 
                        print('&gt;= '+lastMax);
                        } else if (typeof lastMax === 'undefined') { 
                        print('&lt; '+maxVal);
                        } else { 
                        print(lastMax+' - '+maxVal);
                        } 
                        lastMax = maxVal; }); %<?php ?>></th>
                </tr>
            </table>
        </div>   

        <div class="large-12 columns">
            <canvas id="alignmentGraph"/>
        </div>
        <table id="blast_results_table"></table>
    </div>
</script>
<script type="text/template" id="template_hit">
    <<?php ?>% _.each(hit.hsps, function(hsp){ %<?php ?>>
    <<?php ?>%= _.template($('#template_hsp').html())({hsp:hsp}) %<?php ?>>
    <<?php ?>% }); %<?php ?>>
</script>
<script type="text/template" id="template_hsp">
    <table style="width:100%">
        <tr><th>Score</th><td><<?php ?>%= sprintf('%.0f',hsp['bit-score']) %<?php ?>> bits (<<?php ?>%= hsp['score'] %<?php ?>>)</td></tr>
        <tr><th>Expect</th><td><<?php ?>%= fmtScientific(hsp['evalue']) %<?php ?>></td></tr>
        <tr><th>Identities</th><td><<?php ?>%= hsp['identity'] %<?php ?>>/<<?php ?>%= hsp['align-len'] %<?php ?>></td></tr>
        <tr><th>Positives</th><td><<?php ?>%= hsp['positive'] %<?php ?>>/<<?php ?>%= hsp['align-len'] %<?php ?>></td></tr>
        <tr><th>Gaps</th><td><<?php ?>%= hsp['gaps'] %<?php ?>>/<<?php ?>%= hsp['align-len'] %<?php ?>></td></tr>
        <<?php ?>% if (typeof hsp['query-frame'] !== 'undefined' ) { %<?php ?>>
        <tr><th>Query Frame</th><td><<?php ?>%= hsp['query-frame'] %<?php ?>></td></tr>
        <tr><th>Hit Frame</th><td><<?php ?>%= hsp['hit-frame'] %<?php ?>></td></tr>
        <<?php ?>% } %<?php ?>>
        <tr><td colspan="2">
                <pre>
<<?php ?>% _.each(cut_alignment(hsp.qseq, hsp.hseq, hsp.midline, 100, hsp['query-from'], hsp['hit-from']), function(chunk){ %<?php ?>>
<<?php ?>%= sprintf("%10s %6d %-100s %-10d", 'Query', chunk.qseq_start, chunk.qseq, chunk.qseq_end) %<?php ?>>
<<?php ?>%= sprintf("%10s %6s %-100s", '', '', chunk.midline) %<?php ?>>
<<?php ?>%= sprintf("%10s %6d %-100s %-10d", 'Subject', chunk.hseq_start, chunk.hseq, chunk.hseq_end) %<?php ?>>
<<?php ?>% }); %<?php ?>>
                </pre>
            </td></tr>    
    </table>
</script>

<div class="row">
    <div class="large-12 columns">
        <h2>Blast Results</h2>
    </div>
    <div id="blast_results">
        <div class="large-12 columns panel">
            <h4>loading, please wait...</h4>
        </div>
    </div>

</div>

    </div>
    <div class="large-3 columns" >
        <div class="row large-3 columns" style="position:fixed;top:45px;bottom:0;overflow-x:hidden;overflow-y:auto;">


            <div style="display: none">

                <div id="dialog-rename-cart-group" title="rename cart">
                    <form>
                        <fieldset>
                            <label for="cartname">cart name</label>
                            <input type="text" name="name" id="cartname" class="text ui-widget-content ui-corner-all" />
                        </fieldset>
                    </form>
                </div>

                <div id="dialog-delete-all" title="Delete all items and groups?">
                    <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>This will remove all your cart items and groups. Are you sure?</p>
                </div>

                <div id="dialog-edit-cart-item" title="edit item">
                    <form>
                        <fieldset>
                            <label for="item-feature_id">feature_id</label>
                            <input type="text" name="feature_id" id="item-feature_id" disabled="disabled" class="text ui-widget-content ui-corner-all" />
                        </fieldset>
                        <fieldset>
                            <label for="item-alias">display alias</label>
                            <input type="text" name="alias" id="item-alias" class="text ui-widget-content ui-corner-all" />
                            <label for="item-annotations">annotations</label>
                            <textarea name="annotations" id="item-annotations" class="text ui-widget-content ui-corner-all"></textarea>
                        </fieldset>
                    </form>
                </div>
            </div>

            <div class="panel large-12 columns">
                <?php if ((isset($_SESSION['OpenID']))){?>
                    <form action="?logout" method="post">
                        <button>Logout</button>
                    </form>
                <?php }else{ ?>
                    <form action="?login" method="post">
                        <button>Login with Google</button>
                    </form>
                <?php }?>
            </div>

            <div class="panel large-12 columns" id="cart">
                <h4>Cart</h4>
                <div id="cart-group-all" class='ui_accordion ui_collapsible'>
                    <div class="large-12 columns"><div class="left">all</div><div class="right"><img class="cart-button-delete" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/51.png"/><img class="cart-button-execute"  src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/23.png"/></div></div>
                    <ul class="large-12 columns">
                    </ul>
                </div>
                <div>
                    <a id="cart-add-group" class="button secondary right">add new cart</a>
                    <div style="clear:both">&nbsp;</div>
                </div>
                <div id="cart-groups">

                </div>
            </div>

            <script type="text/template" id="cart-group-template"> 
                <div class='cart-group' data-group="<<?php ?>%= groupname %<?php ?>>">
                    <div class="large-12 columns">
                        <div class="groupname left"><<?php ?>%= groupname %<?php ?>></div>
                        <div class="right">
                            <img class="cart-button-rename" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/39.png"/>
                            <img class="cart-button-delete" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/51.png"/>
                            <img class="cart-button-execute" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/23.png"/>
                        </div>
                    </div>
                    <ul class="cart-target large-12 columns">
                        <li class="placeholder">drag your items here</li>
                    </ul>
                </div>
                </script>

                <script type="text/template"  id="cart-item-template"> 
                    <li style="clear:both" class="large-12 cart-item">
                        <div class="left"><img class="cart-button-goto" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/47.png"/> <span class="displayname">
                                <<?php ?>%= (item.alias !== undefined && item.alias !== '') ? item.alias : ((item.name !== undefined && item.name !== '') ? item.name : item.feature_id) %<?php ?>>
                            </span>
                        </div>
                        <div class="right">
                            <img class="cart-button-edit" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/39.png"/>
                            <img class="cart-button-delete" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/51.png"/>
                        </div>
                    </li>
                    </script>
                </div>
                <div>&nbsp;</div>
            </div>
        </div>
        
        </div>

    </body>
</html>

<?php }} ?>