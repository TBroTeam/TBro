var select_assay = $('#select-assay');
var select_analysis = $('#select-analysis');
var select_tissues = $('#select-sample');

var itemIDs;
var options;

//filteredSelect: select_assay => select_analysis => select_tissues
new filteredSelect(select_analysis, 'analysis', {
    precedessorNode: select_assay
});
new filteredSelect(select_tissues, 'sample', {
    precedessorNode: select_analysis
});

function populateBarplotSelectionBoxes(items, opt) {
    console.log(items);
    options = $.extend(true, {type: "isoform"}, opt);
    itemIDs = items;
    $.ajax('{#$ServicePath#}/listing/filters/', {
        method: 'post',
        data: {
            ids: itemIDs[options.type]
        },
        success: function(data) {
            var filterdata = data;
            new filteredSelect(select_assay, 'assay', {
                data: filterdata
            }).refill();
        }
    });
}

//get selected filters as collection

function getFilterData() {
    var data = {
        parents: itemIDs[options.type],
        analysis: [],
        assay: [],
        biomaterial: []
    };
    data.analysis.push(select_analysis.find(':selected').val());
    data.assay.push(select_assay.find(':selected').val());
    select_tissues.find(':selected').each(function() {
        data.biomaterial.push($(this).val());
    });
    return data;
}

//display barplot
$('#button-barplot').click(function() {

    $.ajax('{#$ServicePath#}/graphs/barplot/quantifications', {
        method: 'post',
        data: getFilterData(),
        success: function(val) {
            $('#isoform-barplot-panel').show(0);
            var parent = $("#isoform-barplot-canvas-parent");

            //if we already have an old canvas, we have to clean that up first
            var canvas = $('#isoform-barplot-canvas');
            var cx = canvas.data('canvasxpress');
            if (cx != null) {
                cx.destroy();
                parent.empty();
            }

            canvas = $('<canvas id="isoform-barplot-canvas"></canvas>');
            parent.append(canvas);
            canvas.attr('width', parent.width() - 8);
            canvas.attr('height', 500);

            window.location.hash = "isoform-barplot-panel";

            val.y.names = [];
            for (var i = 0; i < val.y.data.length; i++) {
                val.y.names[i] = val.y.vars[i];
                var meta = cart._getMetadataForContext()[val.y.ids[i]];
                if (typeof meta !== 'undefined') {
                    if (typeof meta['alias'] !== 'undefined')
                        val.y.vars[i] = meta['alias'];
                }
            }

            cx = new CanvasXpress(
                    "isoform-barplot-canvas",
                    {
                        "x": val.x,
                        "y": val.y
                    },
            {
                graphType: "Bar",
                showDataValues: true,
                graphOrientation: "vertical"
            });

            canvas.data('canvasxpress', cx);

            groupByTissues();

            addTable(parent, val);
        }
    });
    return false;
});

//display heatmap
$('#button-heatmap').click(function() {
    $.ajax('{#$ServicePath#}/graphs/barplot/quantifications', {
        method: 'post',
        data: getFilterData(),
        success: function(val) {
            $('#isoform-barplot-panel').show(0);
            var parent = $("#isoform-barplot-canvas-parent");

            //if we already have an old canvas, we have to clean that up first
            var canvas = $('#isoform-barplot-canvas');
            var cx = canvas.data('canvasxpress');
            if (cx != null) {
                cx.destroy();
                parent.empty();
            }

            canvas = $('<canvas id="isoform-barplot-canvas"></canvas>');
            parent.append(canvas);
            canvas.attr('width', parent.width() - 8);
            canvas.attr('height', 500);

            window.location.hash = "isoform-barplot-panel";

            val.y.names = [];
            for (var i = 0; i < val.y.data.length; i++) {
                val.y.names[i] = val.y.vars[i];
                var meta = cart._getMetadataForContext()[val.y.ids[i]];
                if (typeof meta !== 'undefined') {
                    if (typeof meta['alias'] !== 'undefined')
                        val.y.vars[i] = meta['alias'];
                }
            }

            cx = new CanvasXpress(
                    "isoform-barplot-canvas",
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
            groupByTissues();

            addTable(parent, val);
        }
    });
    return false;
});

function addTable(parent, val) {
    var tbl = $('<table></table>');
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
                fnCreatedRow: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $('td:first', nRow).html(sprintf('<a href="{#$AppPath#}/details/byId/%s" target=”_blank”>%s</a>', aData[0], aData[1]))
                    $(nRow).attr('data-id', aData[0]);
                    $(nRow).draggable({
                        appendTo: "body",
                        helper: function() {
                            return $(nRow).find('td:first').clone().addClass('beingDragged');
                        },
                        cursorAt: {top: 5, left: 5}
                    });
                }
            }

    );
}

//group by tissues button clicked
function groupByTissues() {
    var checkbox = $('#isoform-barplot-groupByTissues');
    var cx = $('#isoform-barplot-canvas').data('canvasxpress');
    if (checkbox.is(':checked')) {
        cx.groupSamples(["Tissue_Group"]);
    } else {
        cx.groupSamples([]);
    }
}

$('#isoform-barplot-button').click(function() {
    populateBarplotSelectionBoxes(itemIDs, $.extend(true, options, {type: "isoform"}));
    return false;
});

$('#unigene-barplot-button').click(function() {
    populateBarplotSelectionBoxes(itemIDs, $.extend(true, options, {type: "unigene"}));
    return false;
});

$('#isoform-barplot-groupByTissues').click(groupByTissues);
