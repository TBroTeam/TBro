{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
    <script type="text/javascript">
        $(document).ready(function() {
            $("#blast-tabs").tabs();
            $("#blast-tabs form").submit(function() {
                var data = {
                    organism: organism.val(),
                    release: release.val()
                };
                var that = this;
                $.each($(this).serializeArray(), function() {
                    var matches = this.name.match(/^(\w+)\[(\w+)\]$/);
                    if ($.isArray(matches)) {
                        if (typeof data[matches[1]] === 'undefined')
                            data[matches[1]] = {};
                        data[matches[1]][matches[2]] = this.value;
                    } else {
                        data[this.name] = this.value;
                    }
                });
                $(that).find('input[type="submit"]').prop('disabled', true);
                $.ajax('{#$ServicePath#}/blast/start_job', {
                    data: {blast_job: data},
                    complete: function() {
                        $(that).find('input[type="submit"]').prop('disabled', false);
                    },
                    success: function(ret) {
                        if (ret.job_id != -1) {
                            window.location = '{#$AppPath#}/blast_results/' + ret.job_id;
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
            <h2>Blast against selected release</h2>
        </div>
        <div class="large-12 columns panel">
            <div id="blast-tabs">
                {#$blasts=['blastn', 'blastp', 'blastx', 'tblastn', 'tblastx']#}
                {#$matrix=['BLOSUM45','BLOSUM50','BLOSUM62','BLOSUM80','BLOSUM90','PAM30','PAM70','PAM250']#}
                {#$matrix_default='BLOSUM62'#}
                <ul>
                    {#foreach $blasts as $blast#}
                        <li><a href="#tabs-{#$blast#}">{#$blast#}</a></li>
                        {#/foreach#}
                </ul>
                {#foreach $blasts as $blast#}
                    <div id="tabs-{#$blast#}">
                        <form id="blastform-{#$blast#}">
                            <div class="row">
                                <input type="hidden" name="type" value="{#$blast#}">
                                <div class="large-12 columns">
                                    <label for="blastform-{#$blast#}-query">FASTA sequence(s):</label>
                                    <textarea id="blastform-{#$blast#}-query" name="query" style="width:100%; height:200px; white-space: nowrap;">

                                    </textarea>
                                </div>
                            </div>
                            <ul class="large-block-grid-5">
                                <li>
                                    <label for="blastform-{#$blast#}-num_descriptions">Number of Descriptions:</label>
                                    <select id="blastform-{#$blast#}-num_descriptions" name="parameters[num_descriptions]" style="width:auto"><option>10</option><option>50</option><option>100</option><option>250</option><option>1000</option></select>
                                </li>
                                <li>
                                    <label for="blastform-{#$blast#}-num_alignments">Number of Alignments:</label>
                                    <select id="blastform-{#$blast#}-num_alignments" name="parameters[num_alignments]" style="width:auto"><option>10</option><option>50</option><option>100</option><option>250</option><option>1000</option></select>
                                </li>
                                <li>
                                    <label for="blastform-{#$blast#}-evalue">Maximum E-value:</label>
                                    <select id="blastform-{#$blast#}-evalue" name="parameters[evalue]" style="width:auto"><option>0.01</option><option selected="selected">0.1</option><option>1.0</option><option>10</option><option>100</option></select>
                                </li>
                                {#if $blast=='blastn'#}
                                    <li>
                                        <label for="blastform-{#$blast#}-task">Task:</label>
                                        <select id="blastform-{#$blast#}-task" name="parameters[task]" style="width:auto"><option>blastn</option><option>dc-megablast</option><option>megablast</option></select>
                                    </li>
                                {#/if#}
                                {#if $blast|in_array:['blastp', 'blastx', 'tblastn', 'tblastx']#}
                                    <li>
                                        <label for="blastform-{#$blast#}-matrix">Matrix:</label>
                                        <select id="blastform-{#$blast#}-matrix" name="parameters[matrix]" style="width:auto">
                                            {#foreach $matrix as $matrix_option#}
                                                <option {#if $matrix_option==$matrix_default#}selected="selected"{#/if#}>{#$matrix_option#}</option>
                                            {#/foreach#}
                                        </select>
                                    </li>
                                {#/if#}
                            </ul>
                            <div class="row">
                                <div class="large-2 large-offset-10 columns"><br/><input type="submit" class="button" value="start job"/></div>
                            </div>
                        </form>
                    </div>
                {#/foreach#}

            </div>
        </div>
    </div>
{#/block#}
