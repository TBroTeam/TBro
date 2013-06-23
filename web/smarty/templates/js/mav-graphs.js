$(document).ready(function() {

    var select_element = $('#select-elements');
    var select_assay = $('#select-assay');
    var select_analysis = $('#select-analysis');
    var select_tissues = $('#select-sample');


    new filteredSelect(select_analysis, 'analysis', {
        precedessorNode: select_assay
    });
    new filteredSelect(select_element, 'feature', {
        precedessorNode: select_analysis
    });
    new filteredSelect(select_tissues, 'sample', {
        precedessorNode: select_element
    });


    var lastItemEvent = 0;
    $(document).on('cartEvent', function(event) {
        if (!(event.eventData.action || '').match(/(add|remove)Item/) || event.eventData.groupname !== '{#$cartname#}')
            return;

        var myItemEvent = new Date().getTime();
        lastItemEvent = myItemEvent;

        setTimeout(function() {
            //if another itemEvent has happened in the last 100ms, skip.
            if (lastItemEvent !== myItemEvent)
                return;

            var cartitems = cart._getCartForContext()['{#$cartname#}'] || [];

            $.ajax('{#$ServicePath#}/listing/filters/', {
                method: 'post',
                data: {
                    ids: cartitems
                },
                success: function(data) {
                    var filterdata = data;
                    $.each(cartitems, function() {
                        filterdata.data.feature[this] = cart.cartitems[this];
                    });
                    new filteredSelect(select_assay, 'assay', {
                        data: filterdata
                    }).refill();

                }
            });
        }, 100);

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
                    graphType: "Bar",
                    showDataValues: true,
                    graphOrientation: "vertical"
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
                    graphType: "Heatmap",
                    showDataValues: true,
                    graphOrientation: "vertical",
                    zoomSamplesDisable: true,
                    zoomVariablesDisable: true
                });

                canvas.data('canvasxpress', cx);
                groupByTissues();


            }
        });
        return false;
    });

    function groupByTissues() {
        var checkbox = $('#isoform-barplot-groupByTissues');
        var cx = $('#isoform-barplot-canvas').data('canvasxpress');
        if (checkbox.is(':checked')) {
            cx.groupSamples(["Tissue_Group"]);
        } else {
            cx.groupSamples([]);
        }
    }

    $('#isoform-barplot-groupByTissues').click(groupByTissues);

});

