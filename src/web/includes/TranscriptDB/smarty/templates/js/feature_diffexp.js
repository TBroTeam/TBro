var select_assay = $('#select-diffexp-assay');
var select_acquisition = $('#select-diffexp-acquisition');
var select_quantification = $('#select-diffexp-quantification');
var select_analysis = $('#select-diffexp-analysis');

var options;

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

//display barplot
$('#button-draw-diffexp-heatmap').click(function () {
    $('#diffexp-heatmap-panel').hide(200);
    $.ajax('{#$ServicePath#}/graphs/heatmap/diffexp', {
        method: 'post',
        data: getFilterData(),
        success: function (val) {
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
                    graphType: "Heatmap",
                    showDataValues: true,
                    graphOrientation: "vertical",
                    zoomSamplesDisable: true,
                    zoomVariablesDisable: true
                });

                canvas.data('canvasxpress', cx);

                // addTable(parent, val);
            } else {
                alert("No differential expression data found for this feature/quantification/analysis combination.");
            }
        }
    });
    return false;
});

// unused
function addTable(parent, val) {
    var tbl = $('<table id="expression_table"></table>');
    // y.smps = tissues
    // y.vars = names
    // y.data = data

    var tblColumns = [{sTitle: 'id', bVisible: false}, {sTitle: 'ID'}, {sTitle: 'Alias'}];
    for (var x = 0; x < val.y.smps.length; x++)
        tblColumns.push({sTitle: val.y.smps[x]});

    var tblData = [];
    for (var i = 0; i < val.y.data.length; i++) {
        for (var j = 0; j < val.y.data[i].length; j++) {
            val.y.data[i][j] = Math.round(val.y.data[i][j]);
        }
        var alias = "";
        var meta = cart._getMetadataForContext()[val.y.ids[i]];
        if (typeof meta !== 'undefined') {
            if (typeof meta['alias'] !== 'undefined')
                alias = meta['alias'];
        }
        var row = [val.y.ids[i], val.y.names[i], alias];
        Array.prototype.push.apply(row, val.y.data[i]);
        tblData.push(row);
    }


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
                fnCreatedRow: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $('td:first', nRow).html(sprintf('<a href="{#$AppPath#}/details/byId/%s" target=”_blank”>%s</a>', aData[0], aData[1]))
                    $(nRow).attr('data-id', aData[0]);
                    $(nRow).draggable({
                        appendTo: "body",
                        helper: function () {
                            var helper = $(nRow).find('td:first').clone().addClass('beingDragged');
                            TableTools.fnGetInstance('expression_table').fnSelect($(nRow));
                            var selectedItems = TableTools.fnGetInstance('expression_table').fnGetSelectedData();
                            var selectedIDs = $.map(selectedItems, function (val) {
                                return val[0];
                            });
                            $(nRow).attr('data-id', selectedIDs);
                            if (selectedIDs.length > 1) {
                                helper.html("<b>" + selectedIDs.length + "</b> " + helper.text() + ", ...");
                            }
                            return helper;
                        },
                        cursorAt: {top: 5, left: 30}
                    });
                }
            }

    );
}