{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
<script type="text/javascript">

    var blast_results;
    var templates;
    
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

    function display_processed_job(results){
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
        var parameters = parse_children([], parmRx, jqR.find('BlastOutput_param Parameters').children());
        
        var iterations = [];
        jqR.find('BlastOutput_iterations Iteration').each(function(){
            var jqIt = $(this);
            var iteration = parse_children(['Iteration_hits', 'Iteration_stat'], iterRx, jqIt.children());
            iteration.hits = [];
            
            jqIt.find('Iteration_hits Hit').each(function(){
                var jqHit = $(this);
                var hit = parse_children(['Hit_hsps'], hitRx, jqHit.children());
                hit.hsps = [];
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
                    hit.max_ident = Math.max(hit.max_ident, hsp.identity/(hsp['align-len']));
                    hit.total_score += hsp.score;
                    hit.evalue = Math.min(hit.evalue, hsp.evalue);
                    hit.hsps.push(hsp);
                });                
                iteration.hits.push(hit);
            });
            iterations.push(iteration);
        });
            
        
            
        console.log (execDetails, parameters, iterations);
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
            PROCESSED: _.template($('#template_processed').html())
        };
        check_job_status();
    });
</script>
{#/block#}
{#block name='body'#}
<script type="text/template" id="template_error">
    <div class="large-12 columns panel">
        there has been an error processing your job. if this keeps happening, notify the the administrator.
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
    your job has been processed. here are your results:<br/>
    <br/>
    <div class="large-12 columns panel">
        <pre><%- job_results%></pre>
    </div>
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