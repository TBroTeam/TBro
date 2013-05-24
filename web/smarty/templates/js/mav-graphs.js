var filterdata;

        
function arr_intersect(a1, a2) {
    var ret = [];
    $.each(a1, function() {
        var a = this;
        $.each(a2, function() {
            if (_.isEqual(this, a)) {
                ret.push(this);
                return false; //jquery break;
            }
        });
    });
    return ret;
}

        
$(document).ready(function() {
    $('#filters').tooltip({
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
            var tooltip = $("<table />");
            $.each(element.data('metadata'), function(key, val) {
                $("<tr><td>" + key + "</td><td>" + (val !== null ? val : '') + "</td></tr>").appendTo(tooltip);
            });
            tooltip.foundation();
            return tooltip;
        }
    });

    var ids = [];

    var select_element = $('#select-elements');
    var select_assay = $('#select-assay');
    var select_analysis = $('#select-analysis');
    var select_tissues = $('#select-tissues');

    $.each(cartitems, function() {
        var item = this;
        ids.push(item.feature_id);
        var displayname = (item.alias != undefined) ? item.alias : item.name;
        $('<option />').
        text(displayname).
        val(item.feature_id).
        data('metadata', item).
        attr('selected', 'selected').
        appendTo(select_element);
    });

    $.ajax('{#$ServicePath#}/listing/filters/', {
        method: 'post',
        data: {
            ids: ids
        },
        success: function(data) {
            filterdata = data;
            select_element.click();
        }
    });

    function getSelectedArr() {
        var selected = select_element.find(':selected');
        var ret = [];
        selected.each(function() {
            ret.push($(this).val());
        });
        return ret;
    }

    select_element.click(function() {
        var selected = select_element.find(':selected');

        var currently_selected = {
            elements: getSelectedArr()
        };
        var last_selected = $(this).data('last-selected');
        if (_.isEqual(currently_selected, last_selected))
            return;
        $(this).data('last-selected', currently_selected);

        var intersection = [];
        selected.each(function() {
            var feature_id = $(this).data('metadata').feature_id;
            var this_assays = filterdata.assay[feature_id];
            if (this_assays == null) {
                intersection = [];
                //jquery break
                return false;
            }
            if (intersection.length === 0) {
                intersection = this_assays;
            } else {
                intersection = arr_intersect(intersection, this_assays);
            }
        });
        select_assay.empty();
        $.each(intersection, function() {
            var data = filterdata.data.assay[this];
            var opt = $("<option/>").val(data.id).text(data.name).data('metadata', data);
            opt.appendTo(select_assay);
        });

        select_assay.find('option').first().attr('selected', 'selected');
        select_assay.click();
    });

    select_assay.click(function() {
        var assay = $(this).val();

        var selected = select_element.find(':selected');
        var currently_selected = {
            assay: assay,
            elements: getSelectedArr()
        };

        var last_selected = $(this).data('last-selected');
        if (_.isEqual(currently_selected, last_selected))
            return;
        $(this).data('last-selected', currently_selected);

        if (assay == null) {
            select_analysis.empty();
            select_analysis.click();
            return;
        }

        var intersection = [];
        selected.each(function() {
            if (filterdata.analysis[$(this).data('metadata').feature_id] == null
                || filterdata.analysis[$(this).data('metadata').feature_id][assay] == null) {
                intersection = [];
                //jquery break
                return false;
            }
            var this_analysises = filterdata.analysis[$(this).data('metadata').feature_id][assay];
            if (intersection.length === 0) {
                intersection = this_analysises;
            } else {
                intersection = arr_intersect(intersection, this_analysises);
            }
        });
        select_analysis.empty();

        $.each(intersection, function() {
            var data = filterdata.data.analysis[this];
            var opt = $("<option/>").val(data.id).text(data.id + "(" + data.program + ")").data('metadata', data);
            opt.appendTo(select_analysis);
        });


        select_analysis.find('option').first().attr('selected', 'selected');
        select_analysis.click();
    });

    select_analysis.click(function() {
        var analysis = $(this).val();

        var selected = select_element.find(':selected');
        var assay = select_assay.val();
        var currently_selected = {
            assay: assay,
            analysis: analysis,
            elements: getSelectedArr()
        };

        var last_selected = $(this).data('last-selected');
        if (_.isEqual(currently_selected, last_selected))
            return;
        $(this).data('last-selected', currently_selected);

        if (analysis == null) {
            select_tissues.empty();
            return;
        }

        var intersection = [];
        selected.each(function() {
            var this_tissues = filterdata.biomaterial[$(this).data('metadata').feature_id][analysis][assay];
            if (intersection.length === 0) {
                intersection = this_tissues;
            } else {
                intersection = arr_intersect(intersection, this_tissues);
            }
        });

        select_tissues.empty();

        $.each(intersection, function() {
            var data = filterdata.data.biomaterial[this];
            var opt = $("<option/>").val(data.id).text(data.name).data('metadata', data).attr('selected', 'selected');
            opt.appendTo(select_tissues);
        });
    });


    function getFilterData() {
        var data = {
            parents: [], 
            analysis: [], 
            assay: [], 
            biomaterial: []
        };
        select_element.find(':selected').each(function() {
            data.parents.push($(this).val());
        });
        data.analysis.push(select_analysis.find(':selected').val());
        data.assay.push(select_assay.find(':selected').val());
        select_tissues.find(':selected').each(function() {
            data.biomaterial.push($(this).val());
        });
        return data;
    }

    $('#button-barplot').click(function() {

        $.ajax('{#$ServicePath#}/graphs/barplot/quantifications', {
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

                groupByTissues();


            }
        });
        return false;
    });

    $('#button-heatmap').click(function() {
        $.ajax('{#$ServicePath#}/graphs/barplot/quantifications', {
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


                cx = new CanvasXpress(
                    "isoform-barplot-canvas",
                    {
                        "x": val.x,
                        "y": val.y
                    },
                    {
                        "graphType": "Heatmap",
                        "showDataValues": true,
                        "graphOrientation": "vertical"
                    });

                canvas.data('canvasxpress', cx);
                groupByTissues();


            }
        });
        return false;
    });

    function groupByTissues() {
        var checkbox = $(this);
        var cx = $('#isoform-barplot-canvas').data('canvasxpress');
        if (checkbox.is(':checked')) {
            cx.groupSamples(["Tissue_Group"]);
        } else {
            cx.groupSamples([]);
        }
    }

    $('#isoform-barplot-groupByTissues').click(groupByTissues);


});