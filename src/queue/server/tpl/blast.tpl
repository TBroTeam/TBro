
{#block name='head'#}
<script type="text/javascript">
    $(document).ready(function() {
        var databases;
        
        window.refreshProgramDatabases = function (){
            //get possible databases from the WebService    
            $.ajax('{#$webservice_program_databases#}', {
                data: {filter_string: _.isFunction(get_filter_string)?get_filter_string():{}},
                dataType: 'JSON',
                success: function(data) {
                    databases = data;
                    $('#blastform-type').change();
                }
            });
        }
        
        refreshProgramDatabases();

        //if the user selects another blast type, hide and show input fields accordingly
        //repopulate the database-select
        $('#blastform-type').change(function() {
            var blasttype = $(this).val();
            $('li:has(.type-switched)').not(':has(.' + blasttype + ')').hide();
            $('li:has(.type-switched.' + blasttype + ')').show();
            var db_select = $('#blastform-db');
            db_select.empty();
            $.each(databases[$(this).val()], function() {
                $('<option>' + this + '</option>').appendTo(db_select);
            });

        });

        //on form submit
        $("#blastform").submit(function() {
            var data = {additional_data: _.isFunction(get_additional_data)?get_additional_data():{}};
            var that = $(this);

            //copy all form fields that are currently not hidden into the data object
            $.each($(this).serializeArray(), function() {
                var input = $('[name="' + this.name + '"]');
                if (input.hasClass('type-switched') && !input.hasClass($('#blastform-type').val())) {
                    return; //skip this parameter
                }
                var matches = this.name.match(/^(\w+)\[(\w+)\]$/);
                if ($.isArray(matches)) {
                    if (typeof data[matches[1]] === 'undefined')
                        data[matches[1]] = {};
                    data[matches[1]][matches[2]] = this.value;
                } else {
                    data[this.name] = this.value;
                }
            });
            //disable the submit button
            that.find('input[type="submit"]').prop('disabled', true);
            //send the form data
            $.ajax(that.attr('action'), {
                data: {job: data},
                type: that.attr('method'),
                dataType: 'JSON',
                complete: function() {
                    //on complete, reenable the submit button
                    that.find('input[type="submit"]').prop('disabled', false);
                },
                success: function(ret) {
                    if (ret.status === 'success') {
                        //if the job could be planned, go to the url stored in the form's "data-togo"-attribute
                        window.location = that.attr('data-goto') + ret.job_id;
                    } else {
                        //else, display the error message as received from the service
                        alert(ret.message);
                    }
                }
            });
            return false;
        });
    });
</script>
{#/block#}
{#block name='body'#}
<div class="row">
    <div class="large-12 columns">
        <h2>Blast</h2>
    </div>
    <div class="large-12 columns panel">

        <form id="blastform" method="POST" action="{#$webservice_job_start#}" data-goto="{#$result_page#}?jobid=">
            <div class="row">
                <div class="large-12 columns">
                    <label for="blastform-type">Blast type:</label>
                    <select id="blastform-type" name="type"><option>blastn</option><option>blastp</option><option>blastx</option><option>tblastn</option><option>tblastx</option></select>    
                    <label for="blastform-db">Blast against Database:</label>
                    <select id="blastform-db" name="database"></select>    
                </div>
            </div>
            <div class="row">

                <div class="large-12 columns">
                    <label for="blastform-query">FASTA sequence(s):</label>
                    <textarea id="blastform-query" name="query" style="width:100%; height:200px; white-space: nowrap;">

                    </textarea>
                </div>
            </div>
            <ul class="large-block-grid-5">
                <li>
                    <label for="blastform-num_descriptions">Number of Descriptions:</label>
                    <select id="blastform-num_descriptions" name="parameters[num_descriptions]" style="width:auto"><option>10</option><option>50</option><option>100</option><option>250</option><option>1000</option></select>
                </li>
                <li>
                    <label for="blastform-num_alignments">Number of Alignments:</label>
                    <select id="blastform-num_alignments" name="parameters[num_alignments]" style="width:auto"><option>10</option><option>50</option><option>100</option><option>250</option><option>1000</option></select>
                </li>
                <li>
                    <label for="blastform-evalue">Maximum E-value:</label>
                    <select id="blastform-evalue" name="parameters[evalue]" style="width:auto"><option>0.01</option><option selected="selected">0.1</option><option>1.0</option><option>10</option><option>100</option></select>
                </li>
                <li>
                    <label for="blastform-task">Task:</label>
                    <select id="blastform-task" name="parameters[task]" style="width:auto"  class="type-switched blastn"><option>blastn</option><option>dc-megablast</option><option>megablast</option></select>
                </li>
                <li>
                    <label for="blastform-matrix">Matrix:</label>
                    <select id="blastform-matrix" name="parameters[matrix]" style="width:auto" class="type-switched blastp blastx tblastn tblastx">
                        <option >BLOSUM45</option>
                        <option >BLOSUM50</option>
                        <option selected="selected">BLOSUM62</option>
                        <option >BLOSUM80</option>
                        <option >BLOSUM90</option>
                        <option >PAM30</option>
                        <option >PAM70</option>
                        <option >PAM250</option>
                    </select>
                </li>
            </ul>
            <div class="row">
                <div class="large-2 large-offset-10 columns"><br/><input type="submit" class="button" value="start job"/></div>
            </div>
        </form>
    </div>
</div>
{#/block#}
