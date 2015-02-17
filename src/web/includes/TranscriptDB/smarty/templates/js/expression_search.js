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
        $.when($('#expression-div-gdfxtable').hide(500)).then(function () {
            if (!$('#expression-div-gdfxtable').is(':visible')) {
                $('.loading').show();
            }
        });

        $.ajax('{#$ServicePath#}/listing/expressions', {
            method: 'post',
            data: {
                organism: organism.val(),
                release: release.val(),
                assay: [selected.values[0].assay],
                analysis: [selected.values[0].analysis],
                biomaterial: $.map(selected.values, function (n) {
                    return n.sample
                }),
                currentContext: organism.val() + '_' + release.val()
            },
            success: function (data) {
                var start = new Date().getTime();
                addTable(data);
                var end = new Date().getTime();
                var time = end - start;
                console.log('Execution time: ' + time);
                $('.loading').hide();
                $('#expression-div-gdfxtable').show();
            }
        });
    });

    function download_csv() {
        var iframe = document.createElement('iframe');
        iframe.style.height = "0px";
        iframe.style.width = "0px";
        var data = lastQueryData;
        data.push({name: "currentContext",
            value: organism.val() + '_' + release.val()
        });
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

        var tblColumns = $.map(data.header, function (n, i) {
            return {sTitle: n, bVisible: i !== 0}
        });

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
                    bLengthChange: false,
                    sPaginationType: "full_numbers",
                    sDom: 'T<"clear">lfrtip',
                    bDestroy: true,
                    oTableTools: {
                        aButtons: [],
                        sRowSelect: "multi"
                    },
                    fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                        $('td:first', nRow).html(sprintf('<a href="{#$AppPath#}/details/byId/%s" target=”_blank”>%s</a>', aData[0], aData[1]))
                        $(nRow).attr('data-id', aData[0]);
                        $(nRow).draggable({
                            appendTo: "body",
                            helper: function () {
                                var helper = $(nRow).find('td:first').clone().addClass('beingDragged');
                                TableTools.fnGetInstance('expression-results').fnSelect($(nRow));
                                var selectedItems = TableTools.fnGetInstance('expression-results').fnGetSelectedData();
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