{#block name="head"#}

<!--[if lt IE 9]><script type="text/javascript" src="http://canvasxpress.org/js/flashcanvas.js"></script><![endif]-->
<script type="text/javascript" src="http://canvasxpress.org/js/canvasXpress.min.js"></script>
<!-- use chrome frame if installed and user is using IE -->
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<script type="text/javascript" src="{#$path_prefix#}js/blast_results.js"></script>


<script type="text/javascript">

    var div_blast_results;
    var templates;
    var resultData;
    var parsedXml;

    var colorKey = {
        40: 'rgb(0,0,0)',
        50: 'rgb(0,0,255)',
        80: 'rgb(127,255,0)',
        200: 'rgb(255,20,147)',
        Infinity: 'rgb(255,0,0)'
    };

    $(document).ready(function() {
        div_blast_results = $('#div_blast_results');

        templates = {
            ERROR: _.template($('#template_error').html()),
            PROCESSING: _.template($('#template_processing').html()),
            NOT_PROCESSED: _.template($('#template_not_processed').html()),
            UNKNOWN: _.template($('#template_unknown').html()),
            PROCESSED: _.template($('#template_processed').html()),
            RESULTDETAILS: _.template($('#template_resultDetails').html()),
            PROCESSED_HIT: _.template($('#template_hit').html()),
            PROCESSED_HSP: _.template($('#template_hsp').html())
        };

        check_job_status();
    });

    /*
     * expects results in the following form:
     * {
     *   job_status: 'PROCESSED',
     *   additional_data: {
     *     #values passed to additional_data in the blast interface will be carried here#
     *     #recommended:#
     *     display_feature_link_sprintf: 'http://mydb.org/show_feature/%s'
     *   },
     *   queue_position: (if NOT_PROCESSED)
     *   queue_length: (if NOT_PROCESSED)
     *   blast_results: [
     *     {
     *       query: string, #original query
     *       status: 'NOT_PROCESSED'|'PROCESSING'|'PROCESSED'|'ERROR',
     *       result: xmlString when PROCESSED, null otherwise
     *       errors: stderr output when ERROR, null otherwise
     *     }*
     *   ]   
     * }
     */
    function displayResults(results) {
        div_blast_results.empty().html(templates['PROCESSED'](results));

        $(document).off('change', '#query_select').on('change', '#query_select', function() {
            var resultDetailDiv = $('#resultDetails');
            resultDetailDiv.empty();
            var selectedResult = results.processed_results[$(this).val()];
            if (selectedResult.status === 'PROCESSED') {
                // 'cached' method call. google for memoization
                var parsedXML = _.memoize(parseBlastXml)(selectedResult.result);
                resultDetailDiv.html(templates['RESULTDETAILS'](parsedXML));
                displayIteration(parsedXML.iterations[0], $('#blast_results_table'), $('#alignmentGraph'), $.extend(
                {},
                display_options||{}, 
                {additional_data: results.additional_data || {}}
            ));
            } else {
                resultDetailDiv.html(templates[selectedResult.status](selectedResult));
            }
        });

        $('#query_select').change();
    }


    function check_job_status() {
        $.ajax('{#$webservice_job_results#}', {
            data: {jobid: getParameterByName('jobid')},
            dataType: 'JSON',
            success: function(ret) {
                switch (ret.job_status) {
                    case 'ERROR':
                        break;
                    case 'PROCESSING':
                        setTimeout(check_job_status, 2000);
                        break;
                    case 'NOT_PROCESSED':
                        setTimeout(check_job_status, 2000);
                        break;
                    case 'UNKNOWN':
                        setTimeout(check_job_status, 2000);
                        break;
                    case 'PROCESSED':
                    case 'PROCESSED_WITH_ERRORS':
                        displayResults(ret);
                        return;
                        break;
                    default:
                        //should not happen, quit
                        return;
                }
                ;

                div_blast_results.empty().html(templates[ret.job_status](ret));
            }
        });
    }
</script>
{#/block#}
{#block name="body"#}
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
        Job status can currently not be retrieved. Please bookmark this page and try again later.<br/>
        This page will refresh in 2 seconds.
    </div>
</script>
<script type="text/template" id="template_processed">
    <div class="large-12 columns panel">
        <div class="row">
            <div class="large-12 columns panel">
                Select a Sequence: <br/>
                <select id="query_select">
                    <% _.each(processed_results, function(result, idx){ var query=result.query; %>
                    <option value="<%=idx%>"><%= query.substr(query.indexOf('>')==-1?0:1, Math.max(query.indexOf("\n"),20)) %></option>
                    <% }); %>
                </select>
            </div>

        </div>
        <div id="resultDetails">
        </div>
    </div>
</script>
<script type="text/Template" id="template_resultDetails">
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
            </td>
        </tr>    
    </table>
</script>

<div class="row">
    <div class="large-12 columns">
        <h2>Blast Results</h2>
    </div>
    <div id="div_blast_results">
        <div class="large-12 columns panel">
            <h4>loading, please wait...</h4>
        </div>
    </div>

</div>
{#/block#}