<div class="row" id="repeatmasker">
    <div class="large-12 columns">
        <div id="repeatmasker-annotations"> </div>
        <h2>Repeatmasker Annotations:</h2>
        <div class="row">
            <div class="large-12 columns panel">
                <table style="width:100%">
                    <thead>
                        <tr><td>name</td><td>class</td><td>family</td><td>min</td><td>max</td><td>strand</td><td>length</td></tr>
                    </thead>
                    <tbody>
                        {#foreach $isoform.repeatmasker as $repeatmasker#}
                            <tr>
                                <td>{#$repeatmasker.repeat_name#}</td>
                                <td>{#$repeatmasker.repeat_class#}</td>
                                <td>{#$repeatmasker.repeat_family#}</td>
                                <td>{#$repeatmasker.fmin#}</td>
                                <td>{#$repeatmasker.fmax#}</td>
                                <td>{#if $repeatmasker.strand gt 0#}right{#else#}left{#/if#}</td>
                                <td>{#$repeatmasker.fmax-$repeatmasker.fmin+1#}</td>
                            </tr>
                        {#/foreach#}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>