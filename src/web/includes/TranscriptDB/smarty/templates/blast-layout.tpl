{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
{#$webservice_program_databases="$ServicePath/queue/job_program_databases"#}
{#$webservice_job_start="$ServicePath/queue/job_start"#}
{#$webservice_job_results="$ServicePath/queue/job_results"#}
{#$result_page="$AppPath/blast_results"#}
{#$path_prefix="$AppPath/"#}
{#$feature_prefix="$AppPath/details/byId/"#}

<script type="text/javascript">
    var display_options = {
        prepare_feature_url:function(featurename, options){
            return '{#$AppPath#}/details/byOrganismReleaseName/'+options.additional_data.organism+'/'+options.additional_data.release+'/'+featurename+'#'+featurename.replace('.','_');
        }
    };
    
    function get_additional_data(){
        return  {
            organism: organism.val(),
            release: release.val()
        };
    }
</script>

{#$smarty.block.child#}
{#/block#}
{#block name='body'#}
{#$smarty.block.child#}
{#/block#}