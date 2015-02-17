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
                addTable(data);
            }
        });
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
                    bPaginate: true,
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
                                TableTools.fnGetInstance('expression_results').fnSelect($(nRow));
                                var selectedItems = TableTools.fnGetInstance('expression_results').fnGetSelectedData();
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