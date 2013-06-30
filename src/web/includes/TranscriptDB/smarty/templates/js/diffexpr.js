$(document).ready(function() {
    var select_analysis = $('#select-gdfx-analysis');
    var select_conditionA = $('#select-gdfx-conditionA');
    var select_conditionB = $('#select-gdfx-conditionB');


    new filteredSelect(select_conditionB, 'bb', {
        precedessorNode: select_conditionA
    });

    var finalSelect = new filteredSelect(select_analysis, 'analysis', {
        precedessorNode: select_conditionB
    });

    release.change(function() {
        $.ajax('{#$ServicePath#}/listing/filters_diffexp/fullRelease', {
            method: 'post',
            data: {
                organism: organism.val(),
                release: release.val()
            },
            success: function(data) {
                new filteredSelect(select_conditionA, 'ba', {
                    data: data
                }).refill();
                $('#button-gdfx-table').prop('disabled', false);
            }
        });
    });

    var selectedItem;
    var dataTable;
    $('#button-gdfx-table').click(function() {
        var selected = finalSelect.filteredData();
        selectedItem = {
            conditionA: selected.values[0].dir === 'ltr' ? selected.values[0].ba : selected.values[0].bb,
            conditionB: selected.values[0].dir === 'ltr' ? selected.values[0].bb : selected.values[0].ba,
            analysis: selected.values[0].analysis

        };
        $('#div-gdfxtable').show();


        if (typeof dataTable === "undefined") {
            var serverParams = function(aoData) {
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
                $.each($('#diffexp_filters').serializeArray(), function() {
                    aoData.push(this);
                });
                /*{#if isset($cart_ids)#}*/
                $.each(cart._getCartForContext()['{#$cartname#}'] || [], function() {
                    aoData.push({
                        name: 'ids[]',
                        value: this
                    });
                });
                /*{#/if#}*/
            };
            var lastQueryData;
            var options = {
                bFilter: false,
                bProcessing: true,
                bServerSide: true,
                fnServerData: function(sSource, aoData, fnCallback, oSettings) {
                    lastQueryData = aoData;
                    oSettings.jqXHR = $.ajax({
                        "dataType": 'json',
                        "type": oSettings.sServerMethod,
                        "url": sSource,
                        "data": aoData,
                        "success": function(data) {
                            update_query_details(data);
                            fnCallback(data);
                        }
                    });
                },
                fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $('td:first', nRow).html(sprintf('<a href="{#$AppPath#}/details/byId/%s" target=”_blank”>%s</a>', aData.feature_id, aData.feature_name))
                },
                sServerMethod: "POST",
                sAjaxSource: "{#$ServicePath#}/listing/differential_expressions/fullRelease",
                fnServerParams: serverParams,
                aaSorting: [[5, "asc"]],
                aoColumns: [
                    {
                        sType: "natural",
                        mData: 'feature_name'
                    },
                    {
                        sType: "scientific",
                        mData: 'baseMean'
                    },
                    {
                        sType: "scientific",
                        mData: 'baseMeanA'
                    },
                    {
                        sType: "scientific",
                        mData: 'baseMeanB'
                    },
                    {
                        sType: "scientific",
                        mData: 'foldChange'
                    },
                    {
                        sType: "scientific",
                        mData: 'log2foldChange'
                    },
                    {
                        sType: "scientific",
                        mData: 'pval'
                    },
                    {
                        sType: "scientific",
                        mData: 'pvaladj'
                    }
                ],
                sDom: 'T<"clear">lfrtip',
                oTableTools: {
                    sSwfPath: "{#$AppPath#}/swf/copy_csv_xls_pdf.swf",
                    aButtons: [
                        {
                            "sExtends": "ajax",
                            "sButtonText": "CSV Export All",
                            "fnClick": function(nButton, oConfig) {
                                var iframe = document.createElement('iframe');
                                iframe.style.height = "0px";
                                iframe.style.width = "0px";
                                iframe.src = "{#$ServicePath#}/listing/differential_expressions/releaseCsv" + "?" + $.param(lastQueryData);
                                document.body.appendChild(iframe);
                            }
                        }
                    ],
                    sRowSelect: "multi"
                }
            };
            dataTable = $('#diffexp_results').dataTable(options);
        } else {
            //table already exists, refresh table. if "selectedItem" has changed, this will load new data.
            dataTable.fnReloadAjax();
        }

    });

    new Groupselect($('#select-gdfx-cart'), cart);

    $('#button-gdfx-addToCart').click(function() {
        var selectedItems = TableTools.fnGetInstance(dataTable[0]).fnGetSelectedData();
        var group = $('#select-gdfx-cart').val();
        if (group === '#new#')
            group = cart.addGroup();

        cart.addItem($.map(selectedItems, function(val) {
            return val.feature_id;
        }), {
            groupname: group
        });


    });

    function update_query_details(data) {
        var query_details = data.query_details;
        var domQd = $('#query_details');
        domQd.find('.conditionA').text(query_details.conditionA.name).data('metadata', query_details.conditionA);
        domQd.find('.conditionB').text(query_details.conditionB.name).data('metadata', query_details.conditionB);
        domQd.find('.analysis').text(query_details.analysis.name).data('metadata', query_details.analysis);
        domQd.find('.organism').text(query_details.organism.name);
        domQd.find('.release').text(query_details.release);
        domQd.find('.hits').text(data.iTotalRecords);
        $('.query_details').fadeIn(500);
    }

    $('#diffexpr select').tooltip(metadata_tooltip_options({
        items: "option"
    }));
    $('#query_details').tooltip(metadata_tooltip_options({
        items: ".has-tooltip"
    }));


});