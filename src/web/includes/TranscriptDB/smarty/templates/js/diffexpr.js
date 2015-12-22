var diffexpSelectedIDs = [];
var lastQueryData;

$(document).ready(function () {
    var select_analysis = $('#{#$instance_name#}-select-gdfx-analysis');
    var select_acquisition = $('#{#$instance_name#}-select-gdfx-acquisition');
    var select_quantification = $('#{#$instance_name#}-select-gdfx-quantification');
    var select_conditionA = $('#{#$instance_name#}-select-gdfx-conditionA');
    var select_conditionB = $('#{#$instance_name#}-select-gdfx-conditionB');
    var select_assay = $('#{#$instance_name#}-select-gdfx-assay');


    //filteredSelect: select_conditionA => select_conditionB => select_analysis

    new filteredSelect(select_acquisition, 'acquisition', {
        precedessorNode: select_assay
    });

    new filteredSelect(select_quantification, 'quantification', {
        precedessorNode: select_acquisition
    });

    new filteredSelect(select_conditionA, 'ba', {
        precedessorNode: select_quantification
    });

    new filteredSelect(select_conditionB, 'bb', {
        precedessorNode: select_conditionA
    });

    var finalSelect = new filteredSelect(select_analysis, 'analysis', {
        precedessorNode: select_conditionB
    });


    /*{#if isset($cartname)#}*/
//if selected cart group changes (adding/removing items or context switch), update  filters accordingly
    $('#Cart').on('cartEvent', function (event) {
        if (!((event.eventData.action || '').match(/(add|remove)Item/) && event.eventData.groupname !== '{#$cartname#}') && !(event.eventData.action === 'updateContext'))
            return;

        var myItemEvent = new Date().getTime();
        lastItemEvent = myItemEvent;

        setTimeout(function () {

            //if another itemEvent has happened in the last 100ms, skip.
            if (lastItemEvent !== myItemEvent)
                return;

            var data = {
                organism: organism.val(),
                release: release.val()
            };

            var url = '{#$ServicePath#}/listing/filters_diffexp/forCart';

            $.ajax(url, {
                method: 'post',
                data: data,
                success: function (data) {
                    new filteredSelect(select_assay, 'assay', {
                        data: data
                    }).refill();
                    $('#{#$instance_name#}-button-gdfx-table').prop('disabled', false);
                }
            });
        }, 100);
    });

    /*{#else#}*/
    release.change(function () {
        var url = '{#$ServicePath#}/listing/filters_diffexp/fullRelease';
        var data = {
            organism: organism.val(),
            release: release.val()
        };
        $.ajax(url, {
            method: 'post',
            data: data,
            success: function (data) {
                new filteredSelect(select_assay, 'assay', {
                    data: data
                }).refill();
                $('#{#$instance_name#}-button-gdfx-table').prop('disabled', false);
            }
        });
    });
    release.change();
    /*{#/if#}*/

    var selectedItem;
    var dataTable;
    $('#{#$instance_name#}-button-gdfx-table').click(function () {
        var selected = finalSelect.filteredData();
        //conditionA and conditionB have to be re-ordered (are shown both directions but sotred internally only one diferction)
        selectedItem = {
            conditionA: selected.values[0].dir === 'ltr' ? selected.values[0].ba : selected.values[0].bb,
            conditionB: selected.values[0].dir === 'ltr' ? selected.values[0].bb : selected.values[0].ba,
            analysis: selected.values[0].analysis,
            quantification: selected.values[0].quantification
        };
        //show result table
        $('#{#$instance_name#}-div-gdfxtable').show();
        $('#{#$instance_name#}-div-gdfxtable-columnselector').show();
        $("#{#$instance_name#}-maplot-canvas-parent").empty();


        if (typeof dataTable === "undefined") {
            diffexpSelectedIDs = [];
            //build server request filters
            var serverParams = function (aoData) {
                aoData.push({
                    name: "organism",
                    value: organism.val()
                });
                aoData.push({
                    name: "release",
                    value: release.val()
                });
                aoData.push({
                    name: "analysis",
                    value: selectedItem.analysis
                });
                aoData.push({
                    name: "quantification",
                    value: selectedItem.quantification
                });
                aoData.push({
                    name: "conditionA",
                    value: selectedItem.conditionA
                });
                aoData.push({
                    name: "conditionB",
                    value: selectedItem.conditionB
                });
                aoData.push({name: "currentContext",
                    value: organism.val() + '_' + release.val()
                });
                $.each($('#{#$instance_name#}-diffexp_filters').serializeArray(), function () {
                    aoData.push(this);
                });
                /*{#if isset($cart_ids)#}*/
                $.each(cart._getCartForContext()['{#$cartname#}']['items'] || [], function () {
                    aoData.push({
                        name: 'ids[]',
                        value: this
                    });
                });
                /*{#/if#}*/
            };
            //dataTable options
            var options = {
                bLengthChange: false,
                sPaginationType: "full_numbers",
                sScrollX: "100%",
                bScrollCollapse: true,
                bFilter: false,
                bProcessing: true,
                bServerSide: true,
                fnServerData: function (sSource, aoData, fnCallback, oSettings) {
                    lastQueryData = aoData;
                    oSettings.jqXHR = $.ajax({
                        "dataType": 'json',
                        "type": oSettings.sServerMethod,
                        "url": sSource,
                        "data": aoData,
                        "success": function (data) {
                            update_query_details(data);
                            fnCallback(data);
                        }
                    });
                },
                fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $('td:first', nRow).html(sprintf('<a href="{#$AppPath#}/details/byId/%s" target=”_blank”>%s</a>', aData.feature_id, aData.feature_name))
                    $(nRow).attr('data-id', aData.feature_id);
                    $(nRow).draggable({
                        appendTo: "body",
                        helper: function () {
                            var helper = $(nRow).find('td:first').clone().addClass('beingDragged');
                            if (jQuery.inArray(aData.feature_id, diffexpSelectedIDs) === -1) {
                                diffexpSelectedIDs.push(aData.feature_id);
                                $(nRow).toggleClass('DTTT_selected');
                            }
                            $(nRow).attr('data-id', diffexpSelectedIDs);
                            if (diffexpSelectedIDs.length > 1) {
                                helper.html("<b>" + diffexpSelectedIDs.length + "</b> " + helper.text() + ", ...");
                            }
                            return helper;
                        },
                        cursorAt: {top: 5, left: 30}
                    });
                    $(nRow).on('click', function (event) {
                        var aData = dataTable.fnGetData(this);
                        var iId = aData.feature_id;
                        if (jQuery.inArray(iId, diffexpSelectedIDs) === -1)
                        {
                            diffexpSelectedIDs[diffexpSelectedIDs.length++] = iId;
                        }
                        else
                        {
                            diffexpSelectedIDs = jQuery.grep(diffexpSelectedIDs, function (value) {
                                return value !== iId;
                            });
                        }
                        console.log(diffexpSelectedIDs);
                        $(nRow).toggleClass('DTTT_selected');
                        event.stopPropagation();
                    });
                    if (jQuery.inArray(aData.feature_id, diffexpSelectedIDs) !== -1)
                    {
                        $(nRow).addClass('DTTT_selected');
                    }
                },
                sServerMethod: "POST",
                sAjaxSource: "{#$ServicePath#}/listing/differential_expressions/fullRelease",
                fnServerParams: serverParams,
                aaSorting: [[11, "asc"]],
                aoColumns: [
                    {
                        sType: "natural",
                        mData: 'feature_name',
                        sClass: "no-wrap"
                    },
                    {
                        sType: "natural",
                        mData: 'synonym_name',
                        bVisible: false,
                        sClass: "no-wrap"
                    },
                    {
                        sType: "natural",
                        mData: 'db_description',
                        bSortable: false,
                        sClass: "no-wrap"
                    },
                    {
                        sType: "natural",
                        mData: 'user_alias',
                        bSortable: false,
                        sClass: "no-wrap"
                    },
                    {
                        sType: "natural",
                        mData: 'user_annotations',
                        bSortable: false,
                        sClass: "no-wrap"
                    },
                    {
                        sType: "scientific",
                        mData: 'baseMean',
                        bVisible: false,
                        sClass: "no-wrap"
                    },
                    {
                        sType: "scientific",
                        mData: 'baseMeanA',
                        bVisible: false,
                        sClass: "no-wrap"
                    },
                    {
                        sType: "scientific",
                        mData: 'baseMeanB',
                        bVisible: false,
                        sClass: "no-wrap"
                    },
                    {
                        sType: "scientific",
                        mData: 'foldChange',
                        sClass: "no-wrap"
                    },
                    {
                        sType: "scientific",
                        mData: 'log2foldChange',
                        bVisible: false,
                        sClass: "no-wrap"
                    },
                    {
                        sType: "scientific",
                        mData: 'pval',
                        bVisible: false,
                        sClass: "no-wrap"
                    },
                    {
                        sType: "scientific",
                        mData: 'pvaladj',
                        sClass: "no-wrap"
                    }

                ],
                sDom: 'T<"clear">lfrtip',
                oTableTools: {
                    sSwfPath: "{#$AppPath#}/swf/copy_csv_xls_pdf.swf",
                    aButtons: [],
                    sRowSelect: "multi"
                }
            };
            //execute dataTable
            dataTable = $('#{#$instance_name#}-diffexp_results').dataTable(options);
        } else {
            //table already exists, refresh table. if "selectedItem" has changed, this will load new data.
            dataTable.fnReloadAjax();
        }

    });

//    new Groupselect($('#select-gdfx-cart'), cart);

    //add selected to cart $('#select-gdfx-cart').val()
//    $('#button-gdfx-addToCart').click(function() {
//        var selectedItems = TableTools.fnGetInstance(dataTable[0]).fnGetSelectedData();
//        var group = $('#select-gdfx-cart').val();
//        if (group === '#new#')
//            group = cart.addGroup();

//        cart.addItem($.map(selectedItems, function(val) {
//            return val.feature_id;
//        }), {
//            groupname: group
//        });


//    });

    //updates table displaying query details
    function update_query_details(data) {
        var query_details = data.query_details;
        var domQd = $('#{#$instance_name#}-query_details');
        var swapped = finalSelect.filteredData().values[0].dir !== 'ltr';
        if (swapped) {
            domQd.find('#{#$instance_name#}-swappedWarning').show();
        }
        else {
            domQd.find('#{#$instance_name#}-swappedWarning').hide();
        }
        domQd.find('.conditionA').text(query_details.conditionA.name).data('metadata', query_details.conditionA);
        domQd.find('.conditionB').text(query_details.conditionB.name).data('metadata', query_details.conditionB);
        domQd.find('.analysis').text(query_details.analysis.name).data('metadata', query_details.analysis);
        domQd.find('.organism').text(query_details.organism.name);
        domQd.find('.release').text(query_details.release);
        domQd.find('.hits').text(data.iTotalRecords);
        $('.query_details').fadeIn(500);
    }

    function download_csv() {
        var iframe = document.createElement('iframe');
        iframe.style.height = "0px";
        iframe.style.width = "0px";
        var data = lastQueryData;
        data.push({name: "currentContext",
            value: organism.val() + '_' + release.val()
        });
        /*{#if isset($cartname)#}*/
        data.push({name: "cartname",
            value: '{#$cartname#}'
        });
        /*{#/if#}*/
        data = jQuery.grep(data, function (value) {
            return value['name'] !== 'ids[]';
        });
        if (typeof lastQueryData !== 'undefined') {
            iframe.src = "{#$ServicePath#}/listing/differential_expressions/releaseCsv" + "?" + $.param(data);
            document.body.appendChild(iframe);
        }
    }

    $('#{#$instance_name#}-download_csv_button').click(download_csv);

    $('#{#$instance_name#}-diffexpr select').tooltip(metadata_tooltip_options({
        items: "option"
    }));
    $('#{#$instance_name#}-query_details').tooltip(metadata_tooltip_options({
        items: ".has-tooltip"
    }));

    //display barplot
    $('#{#$instance_name#}-button-draw-maplot').click(function () {
        var data = lastQueryData;
        data.push({name: "currentContext",
            value: organism.val() + '_' + release.val()
        });
        $.ajax('{#$ServicePath#}/listing/differential_expressions/maPlot', {
            method: 'post',
            data: data,
            error: function(jqXHR, textStatus, errorThrown){
                alert("There was an error drawing the plot: " + textStatus + ". See console for details.")
                console.log(textStatus, errorThrown);
                console.log(jqXHR);
            }, 
            success: function (val) {
                var parent = $("#{#$instance_name#}-maplot-canvas-parent");

                //if we already have an old canvas, we have to clean that up first
                var canvas = $('#{#$instance_name#}-maplot-canvas');
                var cx = canvas.data('canvasxpress');
                if (cx != null) {
                    cx.destroy();
                    parent.empty();
                }

                canvas = $('<canvas id="{#$instance_name#}-maplot-canvas"></canvas>');
                parent.append(canvas);
                canvas.attr('width', parent.width() - 8);
                canvas.attr('height', 500);

                window.location.hash = "{#$instance_name#}-maplot-panel";
                
                // initialize with reduced data to speed things up
                var y = {data: [], vars: []};
                y.data = val.y.data.slice(1,1000);
                y.vars = val.y.vars.slice(1,1000);
                y.smps = val.y.smps;

                cx = new CanvasXpress(
                        "{#$instance_name#}-maplot-canvas",
                        {
                            "x": val.x,
                            "y": y,
                            "z": val.z
                        },
                {
                    graphType: "Scatter2D",
                    colorBy: "Status",
                    //colorScheme: "user",
                    //colors: ["rgb(240,0,0)", "rgb(0,240,0)", "rgb(0,0,240)"],
                    xAxisTransform: "log2",
                    showIndicators: false,
                    sizes: [2, 4, 6, 8],
                    showLegend: false
                });

                canvas.data('canvasxpress', cx);
                
                // now change the data to the full set and redraw
                cx.data.y.data = val.y.data;
                cx.data.y.vars = val.y.vars;
                cx.redraw();
                
                // manually create legend
                var legend_table = $('#{#$instance_name#}-legend-diffexp_results');
                legend_table.empty();
                $.each(cx.legendColors, function(key, value){
                    legend_table.append($('<tr><td><div style="border: 1px solid #000000;width:20px;height:20px;border-radius:20px;background:'+value+';"></div></td><td>'+key+'</td></tr>'));
                });
            }
        });
        return false;
    });

});