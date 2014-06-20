<div class="row">
    <script type="text/javascript" src="{#$AppPath#}/js/feature/filteredSelect.js"></script>
    <div id="tabs-graphs-selection" class="large-12 columns">
        <div class="row">
            <div class="large-4 columns">
                <h4>Experiment</h4>
            </div>
            <div class="large-4 columns">
                <h4>Analysis</h4>
            </div>
            <div class="large-4 columns">
                <h4>Samples</h4>
            </div>
        </div>
    </div>
    <div class="large-12 columns">
        <form id="filters">
            <div class="large-12 columns panel">
                <div class="row">
                    <div class="large-4 columns">
                        <select id="select-assay" size="12"></select>
                    </div>
                    <div class="large-4 columns">
                        <select id="select-analysis" size="12"></select>
                    </div>
                    <div class="large-4 columns">
                        <select id="select-sample" size="12" multiple="multiple"></select>
                    </div>
                </div>
                <div class="row">&nbsp;</div>
                <div class="row">
                    <div class="large-12 columns">
                        <div class="large-4 columns">
                            <input type="checkbox" id="isoform-barplot-groupByTissues"/><label style="display:inline-block" for="isoform-barplot-groupByTissues"> &nbsp;Pool by Tissue Group</label>
                            <input type="checkbox" id="isoform-barplot-transpose"/><label style="display:inline-block" for="isoform-barplot-transpose"> &nbsp;Transpose</label>
                        </div>
                        <div class="large-8 columns">
                            <button class="button" id="unigene-barplot-button">Unigene</button>
                            <button class="button" id="isoform-barplot-button">Isoforms</button>
                            <button type="button" id="button-barplot" value="barplot">Barplot</button>
                            <button type="button" id="button-heatmap" value="heatmap">Heatmap</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="large-12 columns" id="isoform-barplot-panel" name="isoform-barplot-panel" style="display:none">
        <div class="large-12 columns panel">
            <div class="row">
                <div class="large-12 columns">
                    <div style="width:100%" id="isoform-barplot-canvas-parent">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>