{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
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
                    $(nRow).find('td:eq(0)').html( '<a target="_blank" href="{#$AppPath#}/details/byOrganismReleaseName/'+resultData.additional.organism+'/'+resultData.additional.release+'/'+aData.def_firstword+'#'+aData.def_firstword.replace('.','_')+'">'+aData.def_firstword+'</a>' );
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
        $.ajax('{#$ServicePath#}/blast/job_status/{#$job_uuid#}', {
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
{#/block#}
{#block name='body'#}
<script type="text/template" id="template_error">
    <div class="large-12 columns panel">
        There has been an error processing your job.<br/>
        Please review your job.<br/>
        If this keeps happening, notify the the administrator.<br/><br/><br/>
        These errors occured:<br/>
        <pre><%= errors %></pre>
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
        Still in queue (position <%=queue_position%> of <%=queue_length%>). You may bookmark this page for later use.<br/>
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
            <tr><th>Program</th><td><%= execDetails.program %></td></tr>
            <tr><th>Version</th><td><%= execDetails.version %></td></tr>
            <tr><th>Reference</th><td><%= execDetails.reference %></td></tr>
            <tr>
                <th>Parameters:</th>
                <td>
                    <table>
                        <% _.each(execDetails.parameters, function(value,key){ %>
                        <tr><th><%= key %></th><td><%= value %></td></tr>
                        <% }); %>
                    </table>
                </td>
            </tr>
        </table>
        <div class="row">
            <div class="large-12 columns panel">
                Select an Iteration: <br/>
                <select id="iteration_select">
                    <% _.each(iterations, function(iteration, idx){ %>
                    <option value="<%=idx%>"><%= iteration['query-ID'] %>: <%= iteration['query-def'] %></option>
                    <% }); %>
                </select>
            </div>
        </div>

        <div class="large-centered large-6 columns ">
            <table style="width:100%;">
                <tr><th colspan="42">Color key for alignment scores</th></tr>
                <tr>
                    <% var lastMax; _.each(colorKey, function(color, maxVal){ %>
                    <th style="background-color: <%= color %>; color: white"><% if (maxVal == Infinity) { 
                        print('&gt;= '+lastMax);
                        } else if (typeof lastMax === 'undefined') { 
                        print('&lt; '+maxVal);
                        } else { 
                        print(lastMax+' - '+maxVal);
                        } 
                        lastMax = maxVal; }); %></th>
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
    <% _.each(hit.hsps, function(hsp){ %>
    <%= _.template($('#template_hsp').html())({hsp:hsp}) %>
    <% }); %>
</script>
<script type="text/template" id="template_hsp">
    <table style="width:100%">
        <tr><th>Score</th><td><%= sprintf('%.0f',hsp['bit-score']) %> bits (<%= hsp['score'] %>)</td></tr>
        <tr><th>Expect</th><td><%= fmtScientific(hsp['evalue']) %></td></tr>
        <tr><th>Identities</th><td><%= hsp['identity'] %>/<%= hsp['align-len'] %></td></tr>
        <tr><th>Positives</th><td><%= hsp['positive'] %>/<%= hsp['align-len'] %></td></tr>
        <tr><th>Gaps</th><td><%= hsp['gaps'] %>/<%= hsp['align-len'] %></td></tr>
        <% if (typeof hsp['query-frame'] !== 'undefined' ) { %>
        <tr><th>Query Frame</th><td><%= hsp['query-frame'] %></td></tr>
        <tr><th>Hit Frame</th><td><%= hsp['hit-frame'] %></td></tr>
        <% } %>
        <tr><td colspan="2">
                <pre>
<% _.each(cut_alignment(hsp.qseq, hsp.hseq, hsp.midline, 100, hsp['query-from'], hsp['hit-from']), function(chunk){ %>
<%= sprintf("%10s %6d %-100s %-10d", 'Query', chunk.qseq_start, chunk.qseq, chunk.qseq_end) %>
<%= sprintf("%10s %6s %-100s", '', '', chunk.midline) %>
<%= sprintf("%10s %6d %-100s %-10d", 'Subject', chunk.hseq_start, chunk.hseq, chunk.hseq_end) %>
<% }); %>
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
{#/block#}