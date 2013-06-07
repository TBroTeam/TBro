{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
<script type="text/javascript">

    var blast_results;
    var templates;
    var resultTable;
    var resultData;
    var parsedXml;
    
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
                hit.hsps = [];
                hit.def_firstword = hit.def.substr(0,hit.def.indexOf(' '));
                hit.query_coverage = 0;
                hit.max_score = 0;
                hit.max_ident = 0;
                hit.total_score = 0;
                hit.evalue = Infinity;
                jqHit.find('Hsp').each(function(){
                    var jqHsp=$(this);
                    var hsp = parse_children([], hspRx, jqHsp.children());
                    hit.query_coverage += hsp['align-len']/iteration['query-len'];
                    hit.max_score = Math.max(hit.max_score, hsp.score);
                    //this is wrong if chunks overlap. see http://wbbi170/httpdocs/blast_results/51b0c3e97c8be
                    hit.max_ident = Math.max(hit.max_ident, hsp.identity/(hsp['align-len']));
                    hit.total_score += hsp.score;
                    hit.evalue = Math.min(hit.evalue, hsp.evalue);
                    hit.hsps.push(hsp);
                });                
                iteration.hits.push(hit);
            });
            iterations.push(iteration);
        });
           
        parsedXml = {execDetails:execDetails, iterations:iterations};   
           
        console.log(parsedXml);           
           
        blast_results.empty().html(templates['PROCESSED'](parsedXml));
        $('#iteration_select').change();
    }
    
    function displayIteration(iteration){
        if (typeof resultTable == "undefined"){
            resultTable = $('#blast_results_table').dataTable({
                aaSorting: [[ 2, "desc" ]],
                aaData: iteration.hits,
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
                    $(nRow).find('td:eq(0)').html( '<a target="_blank" href="{#$AppPath#}/details/byOrganismAndUniquename/'+resultData.organism_name+'/'+resultData.release+'_'+aData.def_firstword+'">'+aData.def_firstword+'</a>' );
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
        there has been an error processing your job. if this keeps happening, notify the the administrator.<br/><br/><br/>
        <pre><%= errors %></pre>
    </div>
</script>
<script type="text/template" id="template_processing">
    <div class="large-12 columns panel">
        your job is currently being processed. please wait a moment.<br/>
        this page will refresh in 2 seconds.
    </div>
</script>
<script type="text/template" id="template_not_processed">
    <div class="large-12 columns panel">
        still in queue (position <%=queue_position%> of <%=queue_length%>). you may bookmark this page for later use.<br/>
        this page will refresh in 2 seconds.
    </div>
</script>
<script type="text/template" id="template_unknown">
    <div class="large-12 columns panel">
        job status can currently not be retreived. please bookmark this page and try again later.<br/>
        this page will refresh in 2 seconds.
    </div>
</script>
<script type="text/template" id="template_processed">
    <pre>
here will be a graph. in the meantime, picachu guards this space.


quu..__
 $$$b  `---.__
  "$$b        `--.                          ___.---uuudP
   `$$b           `.__.------.__     __.---'      $$$$"              .
     "$b          -'            `-.-'            $$$"              .'|
       ".                                       d$"             _.'  |
         `.   /                              ..."             .'     |
           `./                           ..::-'            _.'       |
            /                         .:::-'            .-'         .'
           :                          ::''\          _.'            |
          .' .-.             .-.           `.      .'               |
          : /'$$|           .@"$\           `.   .'              _.-'
         .'|$u$$|          |$$,$$|           |  <            _.-'
         | `:$$:'          :$$$$$:           `.  `.       .-'
         :                  `"--'             |    `-.     \
        :##.       ==             .###.       `.      `.    `\
        |##:                      :###:        |        >     >
        |#'     `..'`..'          `###'        x:      /     /
         \                                   xXX|     /    ./
          \                                xXXX'|    /   ./
          /`-.                                  `.  /   /
         :    `-  ...........,                   | /  .'
         |         ``:::::::'       .            |<    `.
         |             ```          |           x| \ `.:``.
         |                         .'    /'   xXX|  `:`M`M':.
         |    |                    ;    /:' xXXX'|  -'MMMMM:'
         `.  .'                   :    /:'       |-'MMMM.-'
          |  |                   .'   /'        .'MMM.-'
          `'`'                   :  ,'          |MMM<
            |                     `'            |tbap\
             \                                  :MM.-'
              \                 |              .''
               \.               `.            /
                /     .:::::::.. :           /
               |     .:::::::::::`.         /
               |   .:::------------\       /
              /   .''               >::'  /
              `',:                 :    .'
                                    
    </pre>
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
        <h2>blast results</h2>
    </div>
    <div id="blast_results">
        <div class="large-12 columns panel">
            loading, please wait...
        </div>
    </div>

</div>
{#/block#}