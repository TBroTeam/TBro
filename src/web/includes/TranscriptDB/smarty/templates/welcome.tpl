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
                $('stat_release_header').html('Statistics (' + organism.find(':selected').text() + " " + release.val() + ")");
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
        <div class="large-12 columns panel">
            <div class="row">
                <div class="large-6 columns">
                    <a class="large button expand" href="/multisearch">
                        <h4>Search by Name</h4>
                    </a>
                </div>
                <div class="large-6 columns">
                    <a class="large button expand secondary" href="/blast">
                        <h4>Search by Homology</h4>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="large-6 columns">
                    <a class="large button expand alert" href="/annotationsearch">
                        <h4>Search by Annotation</h4>
                    </a>
                </div>
                <div class="large-6 columns">
                    <a class="large button expand success" href="/diffexpr">
                        <h4>Differential Expression</h4>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="large-12 columns panel">
            <div class="row">
                <div class="large-6 columns">
                    <h4>Statistics (Overall)</h4>
                </div>
                <div class="large-6 columns" id="stat_release_header">
                    <h4>Statistics (selected release)</h4>
                </div>
            </div>
            <div class="row">
                <div class="large-6 columns">
                    <table>
                        <tr><th align="left">Species in this database: </th><td id='stat_organisms' align="rigth"></td></tr>
                        <tr><th align="left">Releases in this database: </th><td id='stat_releases' align="rigth"></td></tr>
                        <tr><th align="left">Unigenes in this database: </th><td id='stat_total_unigenes' align="rigth"></td></tr>
                        <tr><th align="left">Isoforms in this database: </th><td id='stat_total_isoforms' align="rigth"></td></tr>
                    </table>

                </div>
                <div class="large-6 columns">
                    <table>
                        <tr><th align="left">Unigenes in the selected release: </th><td id='stat_count_unigenes' align="rigth"></td></tr>
                        <tr><th align="left">Isoforms in the selected release: </th><td id='stat_count_isoforms' align="rigth"></td></tr>
                    </table></div>
            </div>
        </div>
    </div>
{#/block#}