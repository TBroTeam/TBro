var select_assay = $('#select-diffexp-assay');
var select_acquisition = $('#select-diffexp-acquisition');
var select_quantification = $('#select-diffexp-quantification');
var select_analysis = $('#select-diffexp-analysis');

var options;
var expdata;

//filteredSelect: select_assay => select_analysis => select_tissues
new filteredSelect(select_acquisition, 'acquisition', {
    precedessorNode: select_assay
});
new filteredSelect(select_quantification, 'quantification', {
    precedessorNode: select_acquisition
});
new filteredSelect(select_analysis, 'analysis', {
    precedessorNode: select_quantification
});

function populateDiffexpSelectionBoxes() {
    $.ajax('{#$ServicePath#}/listing/filters_diffexp/fullRelease', {
        method: 'post',
        data: {
            organism: organism.val(),
            release: release.val()
        },
        success: function (data) {
            var filterdata = data;
            new filteredSelect(select_assay, 'assay', {
                data: filterdata,
            }).refill();
        }
    });
}

//get selected filters as collection

function getFilterData() {
    var data = {
        featureid: featureid,
        analysis: select_analysis.find(':selected').val(),
        quantification: select_quantification.find(':selected').val()
    };
    return data;
}

$('#diffexp-padj-filter').on("change", function () {
    var cutoff = Number($('#diffexp-padj-filter').val());
    oldcor = expdata.y.data;
    for (var i = 0; i < oldcor.length; i++) {
        for (var j = 0; j < oldcor[i].length; j++) {
            if (Number(expdata.y.padj[i][j]) <= cutoff) {
                expdata.y.cor[i][j] = oldcor[i][j];
            } else {
                expdata.y.cor[i][j] = "NA";
            }
        }
    }
    redrawCorrelationPlot(expdata);
    //canvas.data('canvasxpress', cx);
});

//display barplot
$('#button-draw-diffexp-heatmap').click(function () {
    $('#diffexp-heatmap-panel').hide(200);
    $('#diffexp-padj-filter').val('');
    $.ajax('{#$ServicePath#}/graphs/heatmap/diffexp', {
        method: 'post',
        data: getFilterData(),
        success: redrawCorrelationPlot
    });
    return false;
});

function redrawCorrelationPlot(val) {
    expdata = val;
    if (val.y.smps.length > 0) {

        $('#diffexp-heatmap-panel').show(0);
        var parent = $("#diffexp-heatmap-canvas-parent");

        //if we already have an old canvas, we have to clean that up first
        var canvas = $('#diffexp-heatmap-canvas');
        var cx = canvas.data('canvasxpress');
        if (cx != null) {
            cx.destroy();
            parent.empty();
        }

        canvas = $('<canvas id="diffexp-heatmap-canvas"></canvas>');
        parent.append(canvas);
        canvas.attr('width', parent.width() - 8);
        canvas.attr('height', 500);

        window.location.hash = "diffexp-heatmap-panel";

        val.y.names = [];
        for (var i = 0; i < val.y.data.length; i++) {
            val.y.names[i] = val.y.vars[i];
        }

        cx = new CanvasXpress(
                "diffexp-heatmap-canvas",
                {
                    "x": val.x,
                    "y": val.y
                },
        {
            graphType: "Correlation",
            zoomSamplesDisable: true,
            zoomVariablesDisable: true,
            yAxisTitle: "log2foldchange",
            missingDataColor: "rgb(100,100,100)"
                    //    outlineBy: "Outline",
                    //    outlineByData: "padj"
        }, {
            mousemove: function (o, e, t) {
                var text = "<h6>" + o.x.Condition[0] + " vs " + o.x.Condition[1] + ": " + Math.round(o.y.data * 1000) / 1000 + "</h6><br/><table>";
                if (o.x.Condition[0] != o.x.Condition[1]) {
                    text += "<tr><th> log2foldchange </th><td> " + Math.round(expdata.values[o.x.Condition[0]][o.x.Condition[1]].log2foldchange * 1000) / 1000 + "</td></tr>";
                    text += "<tr><th> p-value adjusted </th><td> " + Math.round(expdata.values[o.x.Condition[0]][o.x.Condition[1]].pvaladj * 100000) / 100000 + "</td></tr>";
                    text += "<tr><th> p-value </th><td> " + Math.round(expdata.values[o.x.Condition[0]][o.x.Condition[1]].pval * 100000) / 100000 + "</td></tr>";
                    text += "<tr><th> baseMean </th><td> " + Math.round(expdata.values[o.x.Condition[0]][o.x.Condition[1]].baseMean * 1000) / 1000 + "</td></tr>";
                    text += "<tr><th> baseMeanA </th><td> " + Math.round(expdata.values[o.x.Condition[0]][o.x.Condition[1]].baseMeanA * 1000) / 1000 + "</td></tr>";
                    text += "<tr><th> baseMeanB </th><td> " + Math.round(expdata.values[o.x.Condition[0]][o.x.Condition[1]].baseMeanB * 1000) / 1000 + "</td></tr>";
                    text += "<tr><th> foldchange </th><td> " + Math.round(expdata.values[o.x.Condition[0]][o.x.Condition[1]].foldchange * 1000) / 1000 + "</td></tr>";
                    text += "<tr><th> inverted </th><td> " + Math.round(expdata.values[o.x.Condition[0]][o.x.Condition[1]].inverted * 1000) / 1000 + "</td></tr>";
                }
                text += "</table>";
                $('#diffexp-mouseover-info').html(text);
            }
        });

        canvas.data('canvasxpress', cx);

        addTable(val.table);
    } else {
        alert("No differential expression data found for this feature/quantification/analysis combination.");
    }
}


function addTable(table) {
    var parent = $('#feature-diffexp-table-div');
    var tbl = $('<table id="feature_diffexp_table"></table>');
    // y.smps = tissues
    // y.vars = names
    // y.data = data

    var tblColumns = [];
    for (var x = 0; x < table.header.length; x++)
        tblColumns.push({sTitle: table.header[x]});

    var tblData = table.rows;

    parent.empty();
    parent.append(tbl);
    tbl.dataTable(
            {
                aoColumns: tblColumns,
                aaData: tblData,
                sScrollX: "100%",
                bScrollCollapse: true,
                bFilter: false,
                bInfo: false,
                bPaginate: false,
                sDom: 'T<"clear">lfrtip',
                oTableTools: {
                    aButtons: [],
                    sRowSelect: "multi"
                },
            }

    );
}