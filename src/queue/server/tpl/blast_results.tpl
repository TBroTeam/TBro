{#block name="head"#}

    <!--[if lt IE 9]><script type="text/javascript" src="http://canvasxpress.org/js/flashcanvas.js"></script><![endif]-->
    <script type="text/javascript" src="http://canvasxpress.org/js/canvasXpress.min.js"></script>
    <!-- use chrome frame if installed and user is using IE -->
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <script type="text/javascript" src="{#$path_prefix#}js/blast_results.js"></script>


    <script type="text/javascript">
        var blast_alignment_width = 60;
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

        organism.val(results.additional_data.organism);
        organism.change();
        release.val(results.additional_data.release);
        release.change();

        $(document).off('change', '#query_select').on('change', '#query_select', function() {
        var resultDetailDiv = $('#resultDetails');
        resultDetailDiv.empty();
        var selectedResult = results.processed_results[$(this).val()];
        if (selectedResult.status === 'PROCESSED') {
        // 'cached' method call. google for memoization
        var parsedXML = _.memoize(parseBlastXml)(selectedResult.result);
        resultDetailDiv.html(templates['RESULTDETAILS'](parsedXML));
        displayIteration(parsedXML.iterations[0], $('#blast_results_table'), $('#alignmentGraph'), $.extend(
        {id_from_name_url: "{#$ServicePath#}/listing/ID_from_name",
        feature_details_url: "{#$ServicePath#}/details/Features"},
        display_options || {},
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

        function download_blast_xml() {
        var iframe = document.createElement('iframe');
        iframe.style.height = "0px";
        iframe.style.width = "0px";
        var data = [];
        data.push({name: "jobid",
        value: getParameterByName('jobid')});
        data.push({name: "xmlonly",
        value: true});
        data.push({name: "query_index",
        value: $('#query_select')[0].selectedIndex});
        iframe.src = "{#$ServicePath#}/queue/Job_results" + "?" + $.param(data);
        document.body.appendChild(iframe);
        }
    </script>
{#/block#}
{#block name="body"#}
    <script type="text/template" id="template_error">
        <div class="large-12 columns">
        There has been an error processing your job.<br/>
        Please review your job.<br/>
        If this keeps happening, notify the administrator.<br/><br/><br/>
        These errors occured:<br/>
        <pre><%= errors %></pre>
        </div>
    </script>
    <script type="text/template" id="template_processing">
        <div class="large-12 columns">
        Your job is currently being processed. Please wait a moment.<br/>
        This page will refresh in 2 seconds.
        </div>
    </script>
    <script type="text/template" id="template_not_processed">
        <div class="large-12 columns">
        Still in queue (position <%=queue_position%> of <%=queue_length%>). You may bookmark this page for later use.<br/>
        This page will refresh in 2 seconds.
        </div>
    </script>
    <script type="text/template" id="template_unknown">
        <div class="large-12 columns">
        Job status can currently not be retrieved. Please bookmark this page and try again later.<br/>
        This page will refresh in 2 seconds.
        </div>
    </script>
    <script type="text/template" id="template_processed">
        <div class="large-12 columns">
        <div class="large-12 columns panel" style="background:white">
        <div class="large-3 columns">
        Select a Sequence: 
        </div>
        <div class="large-9 columns">
        <select id="query_select">
        <% _.each(processed_results, function(result, idx){ var query=result.query; %>
        <option value="<%=idx%>"><%= query.substr(query.indexOf('>')==-1?0:1, Math.max(query.indexOf("\n"),20)) %></option>
        <% }); %>
        </select>
        </div>
        </div>
        <div id="resultDetails"> </div>
        </div>
    </script>
    <script type="text/Template" id="template_resultDetails">

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
        <div class="large-12 columns">&nbsp;</div>
        <div class="large-12 columns">        
        <ul class="button-group even-5">
        <li><button class="small button dropdown" id="blast-show-entries-dropdown" data-dropdown="blast-show-entries-dropdown-options"> Show Entries </button></li>
        <li><button class="small button dropdown" data-dropdown="blast-show-hide-dropdown" data-options="is_hover:true">Show Columns</button></li>
        <li><button class="small button dropdown" data-dropdown="blast-select-all-none-dropdown">Select</button></li>
        <li><button class="small button dropdown" type="button" id="blast-button-gdfx-addToCart" data-dropdown="blast-button-gdfx-addToCart-options"> Store </button></li>
        <li><button class="small button dropdown" id="blast-download-dropdown" data-dropdown="blast-download-dropdown-options"> Export </button></li>
        </ul>

        <ul class="f-dropdown" id="blast-show-entries-dropdown-options" data-dropdown-content>
        <li onclick="blastfnNumOfEntries(10);"> 10 </li> 
        <li onclick="blastfnNumOfEntries(20);"> 20 </li> 
        <li onclick="blastfnNumOfEntries(50);"> 50 </li> 
        <li onclick="blastfnNumOfEntries(100);"> 100 </li> 
        <li onclick="blastfnNumOfEntries(1000);"> 1000 </li> 
        </ul>
        <ul id="blast-show-hide-dropdown" class="f-dropdown" data-dropdown-content>
        <li onclick="blastfnShowHide(1);"><span id="blast-columnCheckbox1" style="width: 15px;">&emsp;</span> DB Alias </li>
        <li onclick="blastfnShowHide(2);"><span id="blast-columnCheckbox2" style="width: 15px;">&#10003;</span> DB Description </li>
        <li onclick="blastfnShowHide(3);"><span id="blast-columnCheckbox3" style="width: 15px;">&emsp;</span> User Alias </li>
        <li onclick="blastfnShowHide(4);"><span id="blast-columnCheckbox4" style="width: 15px;">&emsp;</span> User Description </li>
        <li onclick="blastfnShowHide(5);"><span id="blast-columnCheckbox5" style="width: 15px;">&emsp;</span> Max Score </li>
        <li onclick="blastfnShowHide(6);"><span id="blast-columnCheckbox6" style="width: 15px;">&#10003;</span> Total Score </li>
        <li onclick="blastfnShowHide(7);"><span id="blast-columnCheckbox7" style="width: 15px;">&emsp;</span> Query Coverage </li>
        <li onclick="blastfnShowHide(8);"><span id="blast-columnCheckbox8" style="width: 15px;">&#10003;</span> E-value </li>
        <li onclick="blastfnShowHide(9);"><span id="blast-columnCheckbox9" style="width: 15px;">&emsp;</span> Max Ident </li>
        </ul>
        <ul id="blast-select-all-none-dropdown" class="f-dropdown" data-dropdown-content>
        <li onclick="blastselectAll();" style="width:100%">All</li>
        <!--<li onclick="blastselectAllVisible();" style="width:100%">All visible</li>-->
        <li onclick="blastselectNone();" style="width:100%">None</li>
        </ul>
        <ul id="blast-button-gdfx-addToCart-options" class="f-dropdown" data-dropdown-content>
        <li id="blast-button-gdfx-addToCart-options-newcart" class="keep" data-value="#new#">new</li>
        </ul>
        <ul class="f-dropdown" id="blast-download-dropdown-options" data-dropdown-content>
        <li id="blast-download_xml_button" > xml </li>
        </ul>
        
        <table id="blast_results_table">
        <thead>  
        <tr>
        <th>ID</th>
        <th>DB Alias</th>
        <th>DB Description</th>
        <th>User Alias</th>
        <th>User Description</th>
        <th>Max Score</th>
        <th>Total Score</th>
        <th>Coverage</th>
        <th>evalue</th>
        <th>Max Identity</th>
        <th>Details</th>
        </tr>
        </thead>
        </table>
        </div>
        <div class="large-12 columns">&nbsp;</div>
        <div class="large-12 columns">
        <table>
        <tr><th>Program</th><td><%= execDetails.program %></td></tr>
        <tr><th>Version</th><td><%= execDetails.version %></td></tr>
        <tr><th>Reference</th><td><%= execDetails.reference %></td></tr>
        <tr>
        <th>Parameters:</th>
        <td>
        <% _.each(execDetails.parameters, function(value,key){ %>
        <%= key %>: <%= value %>; 
        <% }); %>
        </td>
        </tr>
        </table>
        </div>
    </script>
    <script type="text/template" id="template_hit">
        <% _.each(hit.hsps, function(hsp){ %>
        <%= _.template($('#template_hsp').html())({hsp:hsp}) %>
        <% }); %>
    </script>
    <script type="text/template" id="template_hsp">
        </br>
        Score <%= sprintf('%.0f',hsp['bit-score']) %> bits (<%= hsp['score'] %>), 
        Expect <%= fmtScientific(hsp['evalue']) %></br>
        Identities <%= hsp['identity'] %>/<%= hsp['align-len'] %>, 
        Positives <%= hsp['positive'] %>/<%= hsp['align-len'] %>, 
        Gaps <%= hsp['gaps'] %>/<%= hsp['align-len'] %></br>
        <% if (typeof hsp['query-frame'] !== 'undefined' ) { %>
        Query Frame <%= hsp['query-frame'] %>, 
        Hit Frame <%= hsp['hit-frame'] %>
        <% } %>
        <pre>
        <% _.each(cut_alignment(hsp.qseq, hsp.hseq, hsp.midline, blast_alignment_width, hsp['query-from'], hsp['hit-from']), function(chunk){ %>
        <%= sprintf("%7s %6d %-"+blast_alignment_width+"s %6d", 'Query', chunk.qseq_start, chunk.qseq, chunk.qseq_end) %>
        <%= sprintf("%7s %6s %-"+blast_alignment_width+"s", '', '', chunk.midline) %>
        <%= sprintf("%7s %6d %-"+blast_alignment_width+"s %6d", 'Subject', chunk.hseq_start, chunk.hseq, chunk.hseq_end) %>
        <% }); %>
        </pre>
    </script>

    <div class="large-12 columns panel">
        <div class="row">
            <div class="large-12 columns">
                <h2>Blast Results</h2>
            </div>
            <div id="div_blast_results">
                <div class="large-12 columns">
                    <h4>loading, please wait...</h4>
                </div>
            </div>

        </div>
    </div>
{#/block#}