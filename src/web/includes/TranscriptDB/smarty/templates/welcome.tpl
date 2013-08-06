{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
    <script type="text/javascript">
        $(document).ready(function() {
            //load statistical information
            release.change(function() {
                $.ajax({
                    url: "{#$ServicePath#}/details/statistical_information/" + organism.find(':selected').text() + "/" + release.val(),
                    dataType: "json",
                    success: function(data) {
                        $.each(data.results, function(key, val) {
                            $('#stat_' + key).html(val);
                        });
                    }
                });
            });
        });
    </script>
{#/block#}
{#block name='body'#}
    <div class="row">
        <div class="large-12 columns panel">
            <h2>Welcome to TBro</h2>
        </div>
    </div>

    <div class="row">
        <div class="large-6 columns panel">
            <h4>Search by name</h4>
        </div>
        <div class="large-6 columns panel">
            <h4>Search by homology</h4>
        </div>
    </div>
    <div class="row">
        <div class="large-6 columns panel">
            <h4>Search by annotation</h4>
        </div>
        <div class="large-6 columns panel">
            <h4>Bulk data retrival</h4>
        </div>
    </div>

    <div class="row">
        <div class="large-12 columns panel">
            <div class="large-12 columns">
                <h4>Statistics</h4>
            </div>
            <table>
                <tr><th>Species in this database: </th><td id='stat_organisms'></td></tr>
                <tr><th>Releases in this database: </th><td id='stat_releases'></td></tr>
                <tr><th>Unigenes in this database: </th><td id='stat_total_unigenes'></td></tr>
                <tr><th>Isoforms in this database: </th><td id='stat_total_isoforms'></td></tr>
                <tr><td></td></tr>
                <tr><th>Unigenes in the selected release: </th><td id='stat_count_unigenes'></td></tr>
                <tr><th>Isoforms in the selected release: </th><td id='stat_count_isoforms'></td></tr>
            </table>
        </div>
    </div>
{#/block#}