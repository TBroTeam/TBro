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
                            if(val === null)
                                val = 0;
                            $('#stat_' + key).html(val);
                        });
                    }
                });
                $('#stat_release_header').html('<h4>Statistics (' + organism.find(':selected').text() + " - " + release.val() + ")</h4>");
            });
        });
    </script>
    <style type="text/css">
        .btn1{
            background-color: #66CD00;
            border-color: #3B5323;
        }
        .btn1:hover{
            background-color: #4A7023;
        }
        .btn2{
            background-color: #93DB70;
            border-color: #3B5323;
        }
        .btn2:hover{
            background-color: #4A7023;
        }
        .btn3{
            background-color: #93DB70;
            border-color: #3B5323;
        }
        .btn3:hover{
            background-color: #4A7023;
        }
        .btn4{
            background-color: #66CD00;
            border-color: #3B5323;
        }
        .btn4:hover{
            background-color: #4A7023;
        }
    </style>
{#/block#}
{#block name='body'#}
    <div class="row">
        <div class="large-12 columns panel">
            <h2>Welcome to <span style="color: #2ba6bc">T</span>ranscriptome <span style="color: #2ba6bc">Bro</span>wser &beta;</h2>
        </div>
    </div>

    <div class="row">
        <div class="large-12 columns panel">
            <div class="row">
                <div class="large-6 columns">
                    <a class="large button expand btn1" href="{#$AppPath#}/multisearch">
                        <h4>Search by Name</h4>
                    </a>
                </div>
                <div class="large-6 columns">
                    <a class="large button expand btn2" href="{#$AppPath#}/blast" >
                        <h4>Search by Homology</h4>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="large-6 columns">
                    <a class="large button expand btn3" href="{#$AppPath#}/annotationsearch">
                        <h4>Search by Annotation</h4>
                    </a>
                </div>
                <div class="large-6 columns">
                    <a class="large button expand btn4" href="{#$AppPath#}/diffexpr">
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
                        <tr><th align="left">Species in this database: </th><td id='stat_organisms' align="right"></td></tr>
                        <tr><th align="left">Releases in this database: </th><td id='stat_releases' align="right"></td></tr>
                        <tr><th align="left">Unigenes in this database: </th><td id='stat_total_unigenes' align="right"></td></tr>
                        <tr><th align="left">Isoforms in this database: </th><td id='stat_total_isoforms' align="right"></td></tr>
                    </table>

                </div>
                <div class="large-6 columns">
                    <table>
                        <tr><th align="left">Unigenes in the selected release: </th><td id='stat_count_unigenes' align="right"></td></tr>
                        <tr><th align="left">Isoforms in the selected release: </th><td id='stat_count_isoforms' align="right"></td></tr>
                    </table></div>
            </div>
        </div>
    </div>
{#/block#}