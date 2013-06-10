{#call_webservice path="details/annotations/feature/interpro_predpeps" data=["query1"=>$feature.feature_id] assign='predpeps'#}
{#if count($predpeps) > 0 #}
    <script type="text/javascript">addNavAnchor('interpro-annotation','Interpro Annotation');</script>
    <div class="row" id="predpep">
        <div class="large-12 columns">
            <div id="predpeps"> </div>
            <h4>Predicted Peptides:</h4>
            <div class="row">
                <div class="large-12 columns panel">
                    <div class="tabs">
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
                                                    <td>{#if $predpep.strand gt 0#}right{#else#}left{#/if#}</td>
                                                    <td>{#$predpep.seqlen#}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="large-9 columns">
                                        <textarea style="height:100px;" id="sequence-{#$predpep.uniquename|clean_id#}">{#$predpep.residues#}</textarea>
                                    </div>
                                    <div class="large-3 columns" style="text-align: right">
                                        <form class="blast" action="http://blast.ncbi.nlm.nih.gov/Blast.cgi" method="POST" target="_blank" style="display:inline">
                                            <input type="hidden" name='CMD' value='Web' />
                                            <input type="hidden" name='PROGRAM' value='blastp' />
                                            <input type="hidden" name='BLAST_PROGRAMS' value='blastp' />
                                            <input type="hidden" name='PAGE_TYPE' value='BlastSearch' />
                                            <input type="hidden" name='SHOW_DEFAULTS' value='on' />
                                            <input type="hidden" name='LINK' value='blasthome' />
                                            <input type="hidden" class="query" data-ref="#sequence-{#$predpep.uniquename|clean_id#}" name="QUERY" value="" />
                                            <input type="submit" class="small button"  value="send to blastp" style="width:100%">
                                        </form>
                                        <form class="blast" action="http://blast.ncbi.nlm.nih.gov/Blast.cgi" method="POST" target="_blank" style="display:inline">
                                            <input type="hidden" name='CMD' value='Web' />
                                            <input type="hidden" name='PROGRAM' value='tblastn' />
                                            <input type="hidden" name='BLAST_PROGRAMS' value='tblastn' />
                                            <input type="hidden" name='PAGE_TYPE' value='BlastSearch' />
                                            <input type="hidden" name='SHOW_DEFAULTS' value='on' />
                                            <input type="hidden" name='LINK' value='blasthome' />
                                            <input type="hidden" class="query" data-ref="#sequence-{#$predpep.uniquename|clean_id#}" name="QUERY" value="" />
                                            <input type="submit" class="small button"  value="send to tblastn" style="width:100%">
                                        </form>
                                    </div>
                                </div>

                                {#if isset($predpep.interpro) && count($predpep.interpro) > 0 #}
                                    <div class="row">
                                        <div class="large-12 columns">
                                            <h4>Interpro Annotations:</h4>

                                            <table style="width:100%" class="contains-tooltip dataTable">
                                                <thead>
                                                    <tr><td>Interpro ID</td><td>Start</td><td>End</td><td>eValue</td><td>Match Description</td><td>GO</td></tr>
                                                </thead>
                                                <tbody>
                                                    {#foreach $predpep.interpro as $interpro#}
                                                        <tr><td>{#interprolink id=$interpro.interpro_id#}</td><td>{#$interpro.fmin#}</td><td>{#$interpro.fmax#}</td>
                                                            <td>{#$interpro.evalue#}</td>
                                                            <td>
                                                                <span class="has-tooltip" data-version="Interpro-Version|{#$interpro.programversion#}" data-src="Source|{#$interpro.sourcename#}" data-id="ID|{#$interpro.analysis_match_id#}" data-desc="Description|{#$interpro.analysis_match_description#}">
                                                            {#if $interpro.analysis_match_description!='no description'#}{#$interpro.analysis_match_description#}{#else#}{#$interpro.sourcename#}:{#$interpro.analysis_match_id#}{#/if#}
                                                        </span>
                                                    <td>
                                                        {#if isset($interpro.dbxref) && count($interpro.dbxref)>0 #}
                                                            <ul style="list-style: none">
                                                                {#foreach $interpro.dbxref as $dbxref#}
                                                                    <li>{#dbxreflink dbxref=$dbxref#} </li>
                                                                {#/foreach#}
                                                            </ul>
                                                        {#/if#}
                                                    </td>
                                                </tr>
                                            {#/foreach#}
                                        </tbody>
                                    </table>
                                    <script type="text/javascript">
                                        $(document).ready(function(){
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