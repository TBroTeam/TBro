$(document).ready(function() {
    var select_assay = $('#isoform-barplot-filter-assay');
    var select_analysis = $('#isoform-barplot-filter-analysis');
    var select_tissue = $('#isoform-barplot-filter-tissue');
    var filterdata;

    select_assay.click(function() {
        var assay = $(this).val();

        var last_selected = $(this).attr('data-last-selected');
        if (assay === last_selected)
            return;
        select_analysis.empty();
        $.each(filterdata.analysis[feature_id][assay], function() {
            var data = filterdata.data.analysis[this];
            var opt = $("<option/>").val(data.id).text(data.id+"("+data.program+")").data('metadata', data);
            opt.appendTo(select_analysis);
        });

        $(this).attr('data-last-selected', assay);

        select_analysis.find('option').first().attr('selected', 'selected');
        select_analysis.click();
    });

    select_analysis.click(function() {
        var analysis = $(this).val();
        var last_selected = $(this).attr('data-last-selected');
        if (analysis === last_selected)
            return;
        select_tissue.empty();

        $.each(filterdata.biomaterial[feature_id][analysis][select_assay.val()], function() {
            var data = filterdata.data.biomaterial[this];
            var opt = $("<option/>").val(data.id).text(data.name).data('metadata', data).attr('selected', 'selected');
            opt.appendTo(select_tissue);
        });

        $(this).attr('data-last-selected', analysis);
    });

    $.ajax('{#$ServicePath#}/listing/filters/' + feature_id, {
        success: function(data) {
            filterdata = data;
            select_assay.empty();
            $.each(filterdata.assay[feature_id], function() {
                var data = filterdata.data.assay[this];
                var opt = $("<option/>").val(data.id).text(data.name).data('metadata', data);
                opt.appendTo(select_assay);
            });
            select_assay.find('option').first().attr('selected', 'selected');
            select_assay.click();
        }
    });

    $('#isoform-barplot-filter-form').tooltip({
        items: "option",
        open: function(event, ui) {
            ui.tooltip.offset({
                top: event.pageY, 
                left: event.pageX
            });
            ui.tooltip.css("max-width", "600px");
        },
        content: function() {
            var element = $(this);
            var tooltip = $("<table/>");
            $.each(element.data('metadata'), function(key, val) {
                $("<tr><td>" + key + "</td><td>" + (val !== null ? val : '') + "</td></tr>").appendTo(tooltip);
            });
            tooltip.foundation();
            return tooltip;
        }
    });
    
    function isoform_barplot_groupByTissues() {
        var checkbox = $(this);
        var cx = $('#isoform-barplot-canvas').data('canvasxpress');
        if (checkbox.is(':checked')) {
            cx.groupSamples(["Tissue_Group"]);
        } else {
            cx.groupSamples([]);
        }
    }
    
    $('#isoform-barplot-groupByTissues').click(isoform_barplot_groupByTissues);
    
    $('#isoform-barplot-filter-form').submit(function() {
        var data = {
            parents: [feature_id], 
            analysis: [], 
            assay: [], 
            biomaterial: []
        };
        data.analysis.push($('#isoform-barplot-filter-analysis option:selected').val());
        data.assay.push($('#isoform-barplot-filter-assay option:selected').val());
        $('#isoform-barplot-filter-tissue option:selected').each(function() {
            console.log(this);
            data.biomaterial.push($(this).val());
        });
        $.ajax('{#$ServicePath#}/graphs/barplot/quantifications', {
            data: data,
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


                cx = new CanvasXpress(
                    "isoform-barplot-canvas",
                    {
                        "x": val.x,
                        "y": val.y
                    },
                    {
                        "graphType": "Bar",
                        "showDataValues": true,
                        "graphOrientation": "vertical"
                    });

                canvas.data('canvasxpress', cx);
                isoform_barplot_groupByTissues();
            }
        });
        return false;
    });



});
