var diffexpSelectedIDs = [];
var lastQueryData;

$(document).ready(function () {
    var select_assay = $('#expression-select-gdfx-assay');
    var select_analysis = $('#expression-select-gdfx-analysis');
    var select_parent_biomaterial = $('#expression-select-gdfx-biomaterial');
    var select_sample = $('#expression-select-gdfx-sample');


    //filteredSelect: select_conditionA => select_conditionB => select_analysis

    new filteredSelect(select_analysis, 'analysis', {
        precedessorNode: select_assay
    });

    new filteredSelect(select_parent_biomaterial, 'parent_biomaterial', {
        precedessorNode: select_analysis
    });

    var finalSelect = new filteredSelect(select_sample, 'sample', {
        precedessorNode: select_parent_biomaterial
    });

    release.change(function () {
        var url = '{#$ServicePath#}/listing/filters_expression';
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
                $('#expression-button-gdfx-table').prop('disabled', false);
            }
        });
    });

    var selectedItem;
    var dataTable;
    $('#expression-button-gdfx-table').click(function () {
        var selected = finalSelect.filteredData();

        //show result table
        $('#expression-div-gdfxtable').show();
        $('#expression-div-gdfxtable-columnselector').show();

        $.ajax('{#$ServicePath#}/listing/expressions', {
            method: 'post',
            data: {
                organism: organism.val(),
                release: release.val(),
                assay: [selected.values[0].assay],
                analysis: [selected.values[0].analysis],
                biomaterial: $.map(selected.values, function (n) {
                    return n.sample
                })
            },
            success: function (data) {
                console.log(data);
            }
        });

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
                $.each($('#expression-diffexp_filters').serializeArray(), function () {
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
            dataTable = $('#expression-results').dataTable(options);
        } else {
            //table already exists, refresh table. if "selectedItem" has changed, this will load new data.
            dataTable.fnReloadAjax();
        }

    });

    //updates table displaying query details
    function update_query_details(data) {
        var query_details = data.query_details;
        var domQd = $('#expression-query_details');
        var swapped = finalSelect.filteredData().values[0].dir !== 'ltr';
        if (swapped) {
            domQd.find('#expression-swappedWarning').show();
        }
        else {
            domQd.find('#expression-swappedWarning').hide();
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

    $('#expression-download_csv_button').click(download_csv);

    $('#expression-diffexpr select').tooltip(metadata_tooltip_options({
        items: "option"
    }));
    $('#expression-query_details').tooltip(metadata_tooltip_options({
        items: ".has-tooltip"
    }));

    function addTable(data) {
        var tbl = $('#expression-results');
        // y.smps = tissues
        // y.vars = names
        // y.data = data

        var tblColumns = $.map(data.header, function(n){return {sTitle: n}});

        var tblData = data.data;
      //  for (var i = 0; i < val.y.data.length; i++) {
      //      for (var j = 0; j < val.y.data[i].length; j++) {
      //          val.y.data[i][j] = Math.round(val.y.data[i][j]);
      //      }
      //      var alias = "";
      //      var meta = cart._getMetadataForContext()[val.y.ids[i]];
      //      if (typeof meta !== 'undefined') {
      //          if (typeof meta['alias'] !== 'undefined')
      //              alias = meta['alias'];
      //      }
      //      var row = [val.y.ids[i], val.y.names[i], alias];
      //      Array.prototype.push.apply(row, val.y.data[i]);
      //      tblData.push(row);
      //  }


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

});