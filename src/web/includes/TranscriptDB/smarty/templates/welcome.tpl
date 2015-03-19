{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
<script type="text/javascript">
    $(document).ready(function () {
        //load statistical information
        release.change(function () {
            $.ajax({
                url: "{#$ServicePath#}/details/statistical_information/" + organism.find(':selected').text() + "/" + release.val(),
                dataType: "json",
                success: function (data) {
                    $.each(data.results, function (key, val) {
                        if (val === null)
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
        background-color: #00A0B1;
        border-color: #008090;
    }
    .btn1:hover{
        background-color: #008299;
    }
    .btn2{
        background-color: #2E8DEF;
        border-color: #2070E0;
        border-width: 5px;
    }
    .btn2:hover{
        border-color: #8C0095;
    }
    .btn3{
        background-color: #A700AE;
        border-color: #800090;
    }
    .btn3:hover{
        background-color: #8C0095;
    }
    .btn4{
        background-color: #643EBF;
        border-color: #5030A0;
    }
    .btn4:hover{
        background-color: #5133AB;
    }

    .overlay-container {
        position: relative; /* <-- Set as the reference for the positioned overlay */
    }

    .overlay-container .overlay {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 0;
        // background-color: rgba(255, 255, 255, 0.7);
        text-align: center;
        //   font: 0/0 a; /* Remove the gap between inline(-block) elements */
    }

    .overlay-container .overlay:before {
        content: ' ';
        display: inline-block;
        vertical-align: middle;
        height: 100%;
    }

    .overlay-container .overlay span {
        //  font: 16px/1 Arial, sans-serif; /* Reset the font property */
        display: inline-block;
        vertical-align: middle;
    }
</style>
{#/block#}
{#block name='body'#}
<div class="row">
    <div class="large-12 columns panel">
        <div class="large-10 columns">
            <h1 style="line-height: 2"> <span style="color: #2ba6cb">T</span>ranscriptome <span style="color: #2ba6cb">Bro</span>wser 0.9.0  </h1>
        </div>
        <div class="large-2 columns">
            <img src="{#$AppPath#}/img/tbro_logo.svg"/>
        </div>
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
                <a class="large button expand btn2" style="padding-top: 0; padding-bottom: 0" href="{#$AppPath#}/blast" >
                    <div class="overlay-container">
                        <img src="{#$AppPath#}/img/wordclouds/cloud-homology.png" style="display: block"/>
                        <div class="overlay"><span><h4>Homology<br>Search</h4></span></div>
                    </div>
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
                <table style="width:100%">
                    <tr><th align="left">Homepage: </th><td><a href="http://tbroteam.github.io/TBro/">GitHub Pages</a></td></tr>
                    <tr><th align="left">Demo: </th><td><a href="http://wbbi011.biozentrum.uni-wuerzburg.de/tbro/">Cannabis sativa transcriptome</a></td></tr>
                    <tr><th align="left">Tutorial: </th><td><a href="//tbro-tutorial.readthedocs.org/en/latest/">Read the Docs</a></td></tr>
                    <tr><th align="left">Code: </th><td><a href="https://github.com/TBroTeam/TBro">GitHub</a></td></tr>
                </table>

            </div>
            <div class="large-6 columns">
                <table style="width:100%">
                    <tr><th align="left">Publication: </th><td>in preparation</td></tr>
                    <tr><th align="left">Docker: </th><td><a href="https://registry.hub.docker.com/repos/tbroteam/">Docker Hub</a></td></tr>
                    <tr><th align="left">Bugs: </th><td><a href="https://github.com/TBroTeam/TBro/issues">GitHub Issues</a></td></tr>
                    <tr><th align="left">Example cart: </th><td>in preparation</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row" style="display: none">
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