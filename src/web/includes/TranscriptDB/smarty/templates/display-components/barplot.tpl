<script type="text/javascript" src="{#$AppPath#}/js/feature/filteredSelect.js"></script>

<div class="row">
    <div class="large-12 columns panel">
        <div class="row">
            <div class="large-10 columns">
                <h4>Barplot (Filters)</h4>
            </div>
            <div class="large-2 columns">
                <input type="submit" class="button large-12" />
            </div>
        </div>

        <div class="row">
            <div class="large-4 columns">
                <h5>Experiment</h5>
            </div>
            <div class="large-4 columns">
                <h5>Analysis</h5>
            </div>
            <div class="large-4 columns">
                <h5>Samples</h5>
            </div>
        </div>
        <form id='isoform-barplot-filter-form'>
            <div class="row">
                <div class="large-4 columns">
                    <select id="isoform-barplot-filter-assay" size="6" ></select>
                </div>
                <div class="large-4 columns">
                    <select id="isoform-barplot-filter-analysis" size="6" ></select>
                </div>
                <div class="large-4 columns">
                    <select id="isoform-barplot-filter-tissue" size="6" multiple="multiple"></select>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row" id="isoform-barplot-panel" style="display:none">
    <div class="large-12 columns panel">
        <div class="row">
            <div class="large-12 columns">
                <div style="width:100%" id="isoform-barplot-canvas-parent">
                </div>
                <input type="checkbox" id="isoform-barplot-groupByTissues"/><label style="display:inline-block" for="isoform-barplot-groupByTissues"> &nbsp;Pool by Tissue Group</label>

            </div>
        </div>
    </div>
</div>