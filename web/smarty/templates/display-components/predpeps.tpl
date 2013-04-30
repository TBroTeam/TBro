<div class="row" id="predpep">
    <div class="large-12 columns">
        <div id="predpeps"> </div>
        <h2>Predicted Peptides:</h2>
        <div class="row">
            <div class="large-12 columns panel">
                <div class="tabs">
                    <ul>
                        {#foreach $isoform.predpeps as $predpep#}
                            <li><p><a href="#{#$predpep.uniquename|clean_id#}">{#if $predpep.strand gt 0#}{#$predpep.fmin#}{#else#}{#$predpep.fmax#}{#/if#}-{#if $predpep.strand gt 0#}{#$predpep.fmax#}{#else#}{#$predpep.fmin#}{#/if#}</a></p></li>
                        {#/foreach#}
                    </ul>

                    {#foreach $isoform.predpeps as $predpep#}
                        <div id="{#$predpep.uniquename|clean_id#}">
                            <div class="row">
                                <div class="large-12 columns">
                                    <table style="width:100%">
                                        <thead>
                                            <tr>
                                                <td>uniquename</td>
                                                <td>min</td>
                                                <td>max</td>
                                                <td>strand</td>
                                                <td>length</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{#$predpep.uniquename#}</td>
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
                                        <input type="submit" class="small button"  value="send to blastp">
                                    </form>
                                    <form class="blast" action="http://blast.ncbi.nlm.nih.gov/Blast.cgi" method="POST" target="_blank" style="display:inline">
                                        <input type="hidden" name='CMD' value='Web' />
                                        <input type="hidden" name='PROGRAM' value='tblastn' />
                                        <input type="hidden" name='BLAST_PROGRAMS' value='tblastn' />
                                        <input type="hidden" name='PAGE_TYPE' value='BlastSearch' />
                                        <input type="hidden" name='SHOW_DEFAULTS' value='on' />
                                        <input type="hidden" name='LINK' value='blasthome' />
                                        <input type="hidden" class="query" data-ref="#sequence-{#$predpep.uniquename|clean_id#}" name="QUERY" value="" />
                                        <input type="submit" class="small button"  value="send to tblastn">
                                    </form>
                                </div>
                            </div>

                            {#if isset($predpep.interpro) && count($predpep.interpro) > 0 #}
                                <div class="row">
                                    <div class="large-12 columns">
                                        <h4>Interpro Annotations:</h4>

                                        <table style="width:100%">
                                            <thead>
                                                <tr><td>interpro id</td><td>fmin</td><td>fmax</td><td>evalue</td><td>database match</td><td>time executed</td><td>dbxref</td></tr>
                                            </thead>
                                            <tbody>
                                                {#foreach $predpep.interpro as $interpro#}
                                                    <tr><td>{#interprolink id=$interpro.interpro_id#}</td><td>{#$interpro.fmin#}</td><td>{#$interpro.fmax#}</td>
                                                        <td>{#$interpro.evalue#}</td>
                                                        <td>{#dbxreflink dbxref=['dbname'=>$interpro.program, 'accession'=>$interpro.analysis_match_id, 'name'=>'', 'definition'=>$interpro.analysis_match_description, 'dbversion'=>$interpro.programversion]#}</td>
                                                        <td>{#$interpro.timeexecuted#}</td>
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