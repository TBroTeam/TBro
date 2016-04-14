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
    
        $('#defaultCartExportButton').click(function(){
            $.ajax({
                url: "{#$ServicePath#}/cart/DefaultCart",
                dataType: "json",
                success: function (data) {
                    var dialog = $('#dialog-copy-all-carts');
                    dialog.data('data', data);
                    dialog.dialog('open');
                }
            });
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

    .round-button {
        width: 30%;
        height: 0;
        padding-bottom: 30%;
        border-radius: 50%;
        border: 2px solid #f5f5f5;
        overflow: hidden;
        background: #ffffff;
        margin: auto;
        transition: all .2s ease-in-out;
    }
    a:hover > .round-button {
        border-color: #565656;
        transform: scale(1.1);
    }
    .round-button img {
        display: block;
        width: 76%;
        margin: auto;
        height: auto;
        vertical-align:middle;
    }

</style>
{#/block#}
{#block name='body'#}
<div class="row">
    <div class="large-12 columns panel">
        <div class="large-10 columns">
            <h1 style="line-height: 2"> {#$instance_title#}  </h1>
        </div>
        <div class="large-2 columns">
            <img src="{#$logo_url#}"/>
        </div>
    </div>
</div>

<div class="row">
    <div class="large-12 columns panel">
        <div class="row">
            <div class="large-6 columns">
                <a href="{#$AppPath#}/multisearch">
                    <div class="round-button">
                        <img src="{#$AppPath#}/img/ownGlyphs/1.svg" style="padding-top: 10%;"/>
                    </div>
                    <h4 align="center">Search by Name</h4>
                </a>
                <div align="center">
                    Using the name search, you can search directly for genes or isoforms using IDs or synonyms.
                </div>
            </div>
            <div class="large-6 columns">
                <a href="{#$AppPath#}/blast" >
                    <div class="round-button">
                        <img src="{#$AppPath#}/img/ownGlyphs/3.svg" style="padding-top: 38%;"/>
                    </div>
                    <h4 align="center">Homology Search</h4>
                </a>
                <div align="center">
                    Using the homology search, you can use BLAST to find isoforms with similar sequence.
                </div>
            </div>
        </div>
        <div class="row"><div class="large-12 columns" style="height:40px">&nbsp;</div></div>
        <div class="row">
            <div class="large-6 columns">
                <a href="{#$AppPath#}/annotationsearch">
                    <div class="round-button">
                        <img src="{#$AppPath#}/img/ownGlyphs/5.svg" style="padding-top: 44%;"/>
                    </div>
                    <h4 align="center">Annotation Search</h4>
                </a>
                <div align="center">
                    Using the annotation search, you can search for different features like GO terms, descriptions and pathways.
                </div>
            </div>
            <div class="large-6 columns">
                <a href="{#$AppPath#}/diffexpr">
                    <div class="round-button">
                        <img src="{#$AppPath#}/img/ownGlyphs/4.svg" style="padding-top: 42%;"/>
                    </div>
                    <h4 align="center">Differential Expression</h4>
                </a>
                <div align="center">
                    Using the differential expression page, you can filter genes and isoforms by differential expression results in different experiments.
                </div>
            </div>
        </div>
        <div class="row"><div class="large-12 columns" style="height:40px">&nbsp;</div></div>
        <div class="row">
            <div class="large-3 columns">&nbsp;</div>
            <div class="large-6 columns">
                <a href="{#$AppPath#}/expression">
                    <div class="round-button">
                        <img src="{#$AppPath#}/img/ownGlyphs/2.svg" style="padding-top: 5%;"/>
                    </div>
                    <h4 align="center">Expression Search</h4>
                </a>
                <div align="center">
                    Using the expression search, you can filter genes and isoforms depending on their expression in different tissues or states.
                </div>
            </div>
            <div class="large-3 columns">&nbsp;</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="large-12 columns panel">
        <div class="row">
            <div class="large-6 columns">
                <table style="width:100%">
                    <tr><th align="left">Homepage: </th><td><a href="http://tbroteam.github.io/TBro/" target="_blank">GitHub Pages</a></td></tr>
                    <!-- tr><th align="left">Demo: </th><td><a href="http://tbro.carnivorom.com/" target="_blank">Venus Flytrap</a></td></tr> -->
                    <tr><th align="left">Tutorial: </th><td><a href="//tbro-tutorial.readthedocs.org/en/latest/" target="_blank">Read the Docs</a></td></tr>
                    <tr><th align="left">Code: </th><td><a href="https://github.com/TBroTeam/TBro" target="_blank">GitHub</a></td></tr>
                    <tr><th align="left">Docker: </th><td><a href="https://hub.docker.com/u/tbroteam/" target="_blank">Docker Hub</a></td></tr>
                </table>

            </div>
            <div class="large-6 columns">
                <table style="width:100%">
                    <tr><th align="left">Example cart: </th><td><a id="defaultCartExportButton">Export</a></td></tr>
                    <tr><th align="left">Publication: </th><td>in preparation</td></tr>
                    <tr><th align="left">Bugs: </th><td><a data-icon="octicon-issue-opened" href="https://github.com/TBroTeam/TBro/issues" target="_blank" class="github-button">Issue</a></td></tr>
                    <tr><th align="left">Twitter: </th><td><a href="https://twitter.com/TBroTeam" target="_blank" class="twitter-follow-button" data-show-count="false" data-dnt="true">Follow @TBroTeam</a>
                            <script>!function (d, s, id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs')
                                    ;</script></td></tr>
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