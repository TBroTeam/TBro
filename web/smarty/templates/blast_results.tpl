{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
    <script type="text/javascript">

        var blast_results;
        var templates;

        function check_job_status() {
            $.ajax('{#$ServicePath#}/blast/job_status/{#$job_uuid#}', {
                success: function(ret) {
                    switch (ret.job_status) {
                        case 'ERROR':
                            break;
                        case 'PROCESSING':
                            blast_results.text('');
                            window.setTimeout(check_job_status, 10000);
                            break;
                        case 'NOT PROCESSED':
                            break;
                        case 'UNKNOWN':
                            window.setTimeout(check_job_status, 10000);
                            break;
                        case 'PROCESSED':
                            break;
                        default:
                            //should not happen, quit
                            return;
                    }
                    ;
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
            your job is currently being processed. please wait a moment.
        </div>
    </script>
    <script type="text/template" id="template_not_processed">
        <div class="large-12 columns panel">
            still in queue (position <%=queue_position%> of <$=queue_length%>). you may bookmark this page for later use.
        </div>
    </script>
    <script type="text/template" id="template_unknown">
        <div class="large-12 columns panel">
            job status can currently not be retreived. please bookmark this page and try again later.
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