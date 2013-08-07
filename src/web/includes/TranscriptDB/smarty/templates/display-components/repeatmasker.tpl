{#call_webservice path="details/annotations/feature/repeatmasker" data=["query1"=>$feature.feature_id] assign='repeatmaskers'#}
{#if count($repeatmaskers) > 0 #}
    <script type="text/javascript">addNavAnchor('repeatmasker-annotation','Repeatmasker Annotation');</script>
    <div class="row" id="repeatmasker" class="contains-tooltip">
        <div class="large-12 columns">
            <div id="repeatmasker-annotations"> </div>
            <div class="row">
                <div class="large-12 columns panel">
                    <h4>Repeatmasker Annotation:</h4>
                    <table style="width:100%" id="repeatmasker-results">
                        <thead>
                            <tr><td>Name</td><td>Class</td><td>Family</td><td>Start</td><td>End</td><td>Direction</td><td>Length</td></tr>
                        </thead>
                        <tbody>
                            {#foreach $repeatmaskers as $repeatmasker#}
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
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $('#repeatmasker-results').dataTable();
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
{#/if#}