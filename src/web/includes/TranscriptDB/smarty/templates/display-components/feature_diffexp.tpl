<div class="row">
    <script type="text/javascript" src="{#$AppPath#}/js/feature/filteredSelect.js"></script>
    <script type="text/javascript">
        {#include file="js/feature_diffexp.js"#}
    </script>
    <div id="tabs-diffexp-heatmap-selection" class="large-12 columns">
        <div class="row">
            <div class="large-3 columns">
                <h4>Experiment</h4>
            </div>
            <div class="large-3 columns">
                <h4>Acquisition</h4>
            </div>
            <div class="large-3 columns">
                <h4>Quantification</h4>
            </div>
            <div class="large-3 columns">
                <h4>Analysis</h4>
            </div>
        </div>
    </div>
    <div class="large-12 columns">
        <form id="diffexp-heatmap-filters">
            <div class="large-12 columns panel">
                <div class="row">
                    <div class="large-3 columns">
                        <select id="select-diffexp-assay" size="12" ></select>
                    </div>
                    <div class="large-3 columns">
                        <select id="select-diffexp-acquisition" size="12" ></select>
                    </div>
                    <div class="large-3 columns">
                        <select id="select-diffexp-quantification" size="12" ></select>
                    </div>
                    <div class="large-3 columns">
                        <select id="select-diffexp-analysis" size="12" ></select>
                    </div>
                </div>
                <div class="row">&nbsp;</div>
                <div class="row">
                    <div class="right large-2 columns">
                        <div class="button expand" id="button-draw-diffexp-heatmap"> Draw </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="large-12 columns" id="diffexp-heatmap-panel" name="diffexp-heatmap-panel" style="display:none">
        <div class="large-12 columns panel">
            <div class="row">
                <div class="large-12 columns">
                    <div style="width:100%" id="diffexp-heatmap-canvas-parent">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>