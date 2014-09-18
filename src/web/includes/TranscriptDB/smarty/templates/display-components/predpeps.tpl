{#call_webservice path="details/annotations/feature/interpro_predpeps" data=["query1"=>$feature.feature_id] assign='predpeps'#}
{#if count($predpeps) > 0 #}
    <script type="text/javascript">addNavAnchor('interpro-annotation', 'Interpro Annotation');</script>
    <div class="row" id="predpep">
        <div class="large-12 columns">
            <div id="predpeps"> </div>
            <div class="row">
                <div class="large-12 columns panel">
                    <div class="left"><h4>Predicted Peptides</h4></div><div class="right"><a target="_blank" href="http://blast.ncbi.nlm.nih.gov/Blast.cgi?PROGRAM=blastp&PAGE_TYPE=BlastSearch&QUERY=>{#foreach $predpeps as $predpep#}>{#$predpep.name#}%0A{#$predpep.residues#}%0A{#/foreach#}" class="button">BLAST @ NCBI</a></div>
                    <div class="tabs" style="padding-left: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px;"
>
                        <ul>
                            {#foreach $predpeps as $predpep#}
                                <li><p><a href="#{#$predpep.name|clean_id#}">{#$predpep.name#}</a></p></li>
                                        {#/foreach#}
                        </ul>

                        {#foreach $predpeps as $predpep#}
                            <div id="{#$predpep.name|clean_id#}">
                                <div class="row">
                                    <div class="large-12 columns">
                                        <table style="width:100%">
                                            <thead>
                                                <tr>
                                                    <td>Name</td>
                                                    <td>Start</td>
                                                    <td>End</td>
                                                    <td>Direction</td>
                                                    <td>Length</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{#$predpep.name#}</td>
                                                    <td>{#$predpep.fmin#}</td>
                                                    <td>{#$predpep.fmax#}</td>
                                                    <td>{#if $predpep.strand gt 0#}+{#else#}-{#/if#}</td>
                                                    <td>{#$predpep.seqlen#}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="large-12 columns">
                                        <textarea style="height:100px;" id="sequence-{#$predpep.uniquename|clean_id#}">>{#$predpep.name#} REF={#$feature.name#} START={#$predpep.fmin#} END={#$predpep.fmax#} STRAND={#$predpep.strand#}&#10;{#$predpep.residues#}</textarea>
                                    </div>
                                </div>

                                {#if isset($predpep.interpro) && count($predpep.interpro) > 0 #}
                                    <div class="row">
                                        <div class="large-12 columns">
                                            <h4>Interpro Annotation</h4>

                                            <table style="width:100%" class="contains-tooltip dataTable">
                                                <thead>
                                                    <tr><td>ID</td><td>Description</td><td>Start</td><td>End</td><td>eValue</td><td>Match Description</td><!--<td>GO</td>--></tr>
                                                </thead>
                                                <tbody>
                                                    {#foreach $predpep.interpro as $interpro#}
                                                        <tr>
                                                            <td><a href="http://www.ebi.ac.uk/interpro/entry/{#$interpro.interpro_id#}">{#$interpro.interpro_id#}</a></td>
                                                            <td>{#$interpro.interpro_description#}</td>
                                                            <td>{#$interpro.fmin#}</td>
                                                            <td>{#$interpro.fmax#}</td>
                                                            <td>{#$interpro.evalue#}</td>
                                                            <td>
                                                                <span class="has-tooltip" data-version="Interpro-Version|{#$interpro.programversion#}" data-src="Source|{#$interpro.sourcename#}" data-id="ID|{#$interpro.analysis_match_id#}" data-desc="Description|{#$interpro.analysis_match_description#}" style="display:inline-block;width:100%">
                                                                    {#if $interpro.analysis_match_description!='no description' && $interpro.analysis_match_description && !empty($interpro.analysis_match_description)#}
                                                                        {#$interpro.analysis_match_description#}
                                                                    {#else#}
                                                                        {#$interpro.sourcename#}:{#$interpro.analysis_match_id#}
                                                                    {#/if#}
                                                                </span>
                                                            </td>
                                                        <!--    <td>
                                                                {#if isset($interpro.dbxref) && count($interpro.dbxref)>0 #}
                                                                    <ul style="list-style: none">
                                                                        {#foreach $interpro.dbxref as $dbxref#}
                                                                            <li>{#dbxreflink dbxref=$dbxref#} </li>
                                                                            {#/foreach#}
                                                                    </ul>
                                                                {#/if#}
                                                            </td> -->
                                                        </tr>
                                                    {#/foreach#}
                                                </tbody>
                                            </table>
                                            <script type="text/javascript">
                                                $(document).ready(function() {
                                                    $('#{#$predpep.uniquename|clean_id#} table.dataTable').dataTable();
                                                });

                                            </script>
                                        </div>
                                    </div>
                                {#/if#}
                            </div>
                        {#/foreach#}
                    </div>
                </div>
            </div>
        </div>
    </div>
{#/if#}