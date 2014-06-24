/**
 * get GET parameter from querystring
 */
function getParameterByName(name) {
    var uri = location.search;
    var params = uri.substr(uri.indexOf('?') + 1);
    var splitParams = params.split(/(&amp;|&)/);
    for (var i = 0; i < splitParams.length; i++) {
        var matches = splitParams[i].match(/^(.*)=(.*)$/);
        if (matches != null && matches[1] == name) {
            return matches[2];
        }
    }
    return undefined;
}

/**
 * parses Blast XML output into a Javascript Object
 */
function parseBlastXml(job_results) {
    function parse_children(skip_children, regexp, nodes) {
        var ret = {};
        nodes.each(function() {
            if ($.inArray(this.nodeName, skip_children) >= 0) {
                return;
            }
            var matches = this.nodeName.match(regexp);
            var val = parseFloat($(this).text());
            ret[matches[1]] = isNaN(val) ? $(this).text() : val;
        });
        return ret;
    }

    var parmRx = /^Parameters_(.*)$/;
    var iterRx = /^Iteration_(.*)$/;
    var hitRx = /^Hit_(.*)$/;
    var hspRx = /^Hsp_(.*)$/;
    var jqR = $($.parseXML(job_results));
    var execDetails = {
        program: jqR.find('BlastOutput_program').text(),
        version: jqR.find('BlastOutput_version').text(),
        reference: jqR.find('BlastOutput_reference').text()
    };
    execDetails.parameters = parse_children([], parmRx, jqR.find('BlastOutput_param Parameters').children());
    var iterations = [];
    jqR.find('BlastOutput_iterations Iteration').each(function() {
        var jqIt = $(this);
        var iteration = parse_children(['Iteration_hits', 'Iteration_stat'], iterRx, jqIt.children());
        iteration.hits = [];
        jqIt.find('Iteration_hits Hit').each(function() {
            var jqHit = $(this);
            var hit = parse_children(['Hit_hsps'], hitRx, jqHit.children());
            var hitcoverage = [];
            for (var i = 1; i <= iteration['query-len']; i++) {
                hitcoverage[i] = false;
            }
            hit.hsps = [];
            hit.def_firstword = hit.def;
            if (hit.def.indexOf(' ') > 0)
                hit.def_firstword = hit.def.substr(0, hit.def.indexOf(' '));
            hit.max_score = 0;
            hit.max_ident = 0;
            hit.total_score = 0;
            hit.evalue = Infinity;
            hit.details = "";
            jqHit.find('Hsp').each(function() {
                var jqHsp = $(this);
                var hsp = parse_children([], hspRx, jqHsp.children());
                for (var i = hsp['query-from']; i <= hsp['query-to']; i++) {
                    hitcoverage[i] = hsp.hseq[i - 1] !== '-';
                }
                hit.max_score = Math.max(hit.max_score, hsp.score);
                hit.max_ident = Math.max(hit.max_ident, hsp.identity / (hsp['align-len']));
                hit.total_score += hsp.score;
                hit.evalue = Math.min(hit.evalue, hsp.evalue);
                hit.hsps.push(hsp);
            });
            hit.query_coverage = _.compact(hitcoverage).length / iteration['query-len'];
            iteration.hits.push(hit);
        });
        iterations.push(iteration);
    });
    return {
        execDetails: execDetails,
        iterations: iterations
    };
}

/**
 * displays a CanvasXP 'Genome'-Type Graph for the given iteration in the given canvas
 */

function displayIterationGraph(iteration, canvas, colorKey, elementClickCallback) {
    var colorForScore = function(score) {
        for (var k in colorKey) {
            if (colorKey.hasOwnProperty(k)) {
                if (score < k)
                    return colorKey[k];
            }
        }
        return 'rgb(0,0,0)';
    };
    var tracks = [];
    var track = {
        type: 'box',
        data: [{
                id: iteration['query-ID'],
                fill: 'rgb(255,0,0)',
                outline: 'rgb(0,0,0)',
                data: [[1, iteration['query-len']]]
            }]
    };
    tracks.push(track);
    $.each(iteration.hits, function() {
        var track = {
            hit: this,
            type: 'box',
            data: [{
                    id: this['def_firstword'],
                    fill: [],
                    outline: 'rgb(0,0,0)',
                    data: []
                }]
        };
        _.each(this.hsps, function(hsp) {
            track.data[0].data.push([hsp['query-from'], hsp['query-to']]);
            track.data[0].fill.push(colorForScore(hsp['score']));
        });
        tracks.push(track);
    });
    return new CanvasXpress(
            canvas.attr('id'),
            {
                min: 0,
                max: iteration['query-len'] + 1,
                tracks: tracks
            }, {
        graphType: 'Genome',
        useFlashIE: true,
        backgroundType: 'gradient',
        backgroundGradient1Color: 'rgb(0,183,217)',
        backgroundGradient2Color: 'rgb(4,112,174)',
        oddColor: 'rgb(220,220,220)',
        evenColor: 'rgb(250,250,250)',
        missingDataColor: 'rgb(220,220,220)'
    },
    {
        click: function() {
            var hit = arguments[0][0].hit;
            elementClickCallback.apply(hit, arguments);
        }
    }
    );
}


/**
 * calls displayIterationGraph, fills Iteration Table
 */
function displayIteration(iteration, resultTable, canvas, options) {
    options = $.extend({
        prepare_feature_url: function(featurename, options) {
            return '/' + featurename + '#' + featurename.replace('.', '_');
        }
    }, options);
    var names = [];
    $.each(iteration.hits, function(key, value) {
        names.push(value.def_firstword);
    });
    $.ajax(options.id_from_name_url, {
        method: 'post',
        data: {
            names: names,
            species: options.additional_data.organism,
            release: options.additional_data.release
        },
        success: function(data) {
            var feature_ids = [];
            var id_to_row_map = {};
            $.each(iteration.hits, function(key, value) {
                value.feature_id = -1;
                value.db_alias = "";
                value.db_description = "";
                value.user_alias = "";
                value.user_description = "";
                if (typeof data.results[value.def_firstword] !== 'undefined') {
                    var id = data.results[value.def_firstword];
                    value.feature_id = id;
                    feature_ids.push(id);
                    id_to_row_map[id] = value;
                }
            });
            if (feature_ids.length > 0) {
                getFeatureDetailsForIDs(feature_ids, id_to_row_map);
            } else {
                $('#blast-button-gdfx-addToCart').attr('disabled', 'disabled');
                displayCanvasAndTable();
            }
        }
    });

    function getFeatureDetailsForIDs(feature_ids, id_to_row_map) {
        $.ajax(options.feature_details_url, {
            method: 'post',
            data: {
                terms: feature_ids
            },
            success: function(data) {
                var meta = cart._getMetadataForContext();
                $.each(data.results, function(key, value) {
                    id_to_row_map[value.feature_id].db_alias = value.alias;
                    id_to_row_map[value.feature_id].db_description = value.description;
                    if (typeof meta[value.feature_id] !== 'undefined') {
                        id_to_row_map[value.feature_id].user_alias = meta[value.feature_id]['alias'];
                        id_to_row_map[value.feature_id].user_description = meta[value.feature_id]['annotations'];
                    }
                });

                displayCanvasAndTable();
            }
        });
    }

    function openRowOnHit() {
        var hit = this;
        if (typeof hit == "undefined")
            return;
        var aSettings = resultTable.fnSettings();
        $.each(aSettings.aoData, function() {
            var aData = this._aData;
            if (_.isEqual(aData, hit)) {
                this.nTr.click();
                $(document.body).animate({
                    scrollTop: $(this.nTr).offset().top - 75
                }, 'fast');
                return false;
            }
        });
    }

    function fnMDataScientific(storeValue) {
        return function(data, type, val) {
            if (type === 'set') {
                data[storeValue] = val;
                return;
            }
            else if (type === 'display') {
                return fmtScientific(data[storeValue]);
            }
            return data[storeValue];
        }
    }
    ;
    function openCloseDetails(event) {
        event.preventDefault();
        var row = $(this).parents("tr")[0];
        var dT = TableTools.fnGetInstance('blast_results_table');
        dT.fnIsSelected(row) ? dT.fnDeselect(row) : dT.fnSelect(row);
        if (resultTable.fnIsOpen(row)) {
            resultTable.fnClose(row);
        } else {
            var aData = resultTable.fnGetData(row);
            resultTable.fnOpen(row, templates.PROCESSED_HIT({
                hit: aData
            }), 'details');
        }
    }

    function displayCanvasAndTable() {
        new Grouplist($('#blast-button-gdfx-addToCart-options'), cart, blastaddSelectedToCart);
        $('#blast-button-gdfx-addToCart-options-newcart').click(blastaddSelectedToCart);
        $('#blast-download_xml_button').click(download_blast_xml);
        cart._redraw();

        canvas.attr('width', canvas.parent().width() - 8);
        displayIterationGraph(iteration, canvas, colorKey, openRowOnHit);
        if (!$.fn.DataTable.fnIsDataTable(resultTable.get())) {
            resultTable.dataTable({
                aaSorting: [[8, "asc"]],
                aaData: iteration.hits,
                sPaginationType: "full_numbers",
                bFilter: false,
                sDom: 'T<"clear">lfrtip',
                oTableTools: {
                    aButtons: [],
                    sRowSelect: "multi"
                },
                bLengthChange: false,
                aoColumns: [
                    {
                        mData: "def_firstword",
                        sTitle: "name",
                        bSortable: false
                    },
                    {
                        mData: "db_alias",
                        sTitle: "DB Alias",
                        bSortable: false,
                        bVisible: false
                    },
                    {
                        mData: "db_description",
                        sTitle: "DB Description",
                        bSortable: false
                    },
                    {
                        mData: "user_alias",
                        sTitle: "User Alias",
                        bSortable: false,
                        bVisible: false
                    },
                    {
                        mData: "user_description",
                        sTitle: "User Description",
                        bSortable: false,
                        bVisible: false
                    },
                    {
                        mData: "max_score",
                        sTitle: "max score",
                        bVisible: false
                    },
                    {
                        mData: "total_score",
                        sTitle: "total score"
                    },
                    {
                        mData: fnMDataScientific("query_coverage"),
                        sTitle: "coverage",
                        bVisible: false
                    },
                    {
                        mData: fnMDataScientific("evalue"),
                        sTitle: "evalue"
                    },
                    {
                        mData: fnMDataScientific("max_ident"),
                        sTitle: "max identity",
                        bVisible: false
                    },
                    {
                        mData: "details",
                        sTitle: "Details",
                        bSortable: false,
                        sWidth: "45px"
                    }
                ],
                fnCreatedRow: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $(nRow).find('td:eq(0)').html('<a target="_blank" href="' + options.prepare_feature_url(aData.def_firstword, options) + '">' + aData.def_firstword + '</a>');
                    $(nRow).find('td:eq(4)').html('<a href="#" class="open-close-details"> Show </a>');
                    $(nRow).attr('data-id', aData.feature_id);
                    if (aData.feature_id !== -1) {
                        $(nRow).draggable({
                            appendTo: "body",
                            helper: function() {
                                var helper = $(nRow).find('td:eq(0)').clone().addClass('beingDragged');
                                TableTools.fnGetInstance('blast_results_table').fnSelect($(nRow));
                                var selectedItems = TableTools.fnGetInstance('blast_results_table').fnGetSelectedData();
                                var selectedIDs = $.map(selectedItems, function(val) {
                                    return val.feature_id;
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
            });
            resultTable.on('click', 'a.open-close-details', openCloseDetails);
        } else {
            resultTable.fnClearTable();
            resultTable.fnAddData(iteration.hits);
        }
    }
}


function blastaddSelectedToCart() {
    var group = $(this).attr('data-value');
    var selectedIDs = [];
    $.each(TableTools.fnGetInstance('blast_results_table').fnGetSelectedData(), function(key, value) {
        selectedIDs.push(value.feature_id);
    });
    console.log(selectedIDs);
    if (selectedIDs.length === 0)
        return;
    if (group === '#new#')
        group = cart.addGroup();
    cart.addItem(selectedIDs, {
        groupname: group
    });
}


/**
 * formats a number. 0 will be output as 0, |values| less than 0.001 will be output as scientific numbers, others will be output with 3 significant numbers
 */
function fmtScientific(val) {
    if (val == 0)
        return val;
    if (Math.abs(val) < 0.001)
        return sprintf('%.3e', val);
    return sprintf('%.3f', val);
}


/**
 * wordwraps the three lines hseq, qseq and midline  around line_length, prepends numbers and counts around gaps
 */
function cut_alignment(qseq, hseq, midline, line_length, qseq_start, hseq_start) {
    var ret = [];
    var qseq_pos = qseq_start;
    var hseq_pos = hseq_start;
    for (var i = 0; i < qseq.length; i += line_length) {

        var qseq_sub = qseq.substring(i, i + line_length);
        var qseq_gaps = (qseq_sub.match(/\-/g) || []).length;
        var hseq_sub = hseq.substring(i, i + line_length);
        var hseq_gaps = (hseq_sub.match(/\-/g) || []).length;
        var chunk = {
            qseq: qseq_sub,
            qseq_start: qseq_pos,
            qseq_end: qseq_pos + qseq_sub.length - 1 - qseq_gaps,
            hseq: hseq_sub,
            hseq_start: hseq_pos,
            hseq_end: hseq_pos + hseq_sub.length - 1 - hseq_gaps,
            midline: midline.substring(i, i + line_length)
        };
        qseq_pos += line_length - qseq_gaps;
        hseq_pos += line_length - hseq_gaps;
        ret.push(chunk);
    }
    return ret;
}

function blastfnNumOfEntries(numOfEntries)
{
    /* Get the DataTables object again - this is not a recreation, just a get of the object */
    var oTable = $('#blast_results_table').dataTable();
    var oSettings = oTable.fnSettings();
    oSettings._iDisplayLength = numOfEntries;
    oTable.fnDraw();
}

function blastselectAll() {
// fnSelectAll only for graphical selection
    TableTools.fnGetInstance('blast_results_table').fnSelectAll();
}
function blastselectAllVisible() {
// fnSelectAll only for graphical selection
    TableTools.fnGetInstance('blast_results_table').fnSelect($('#blast_results_table').dataTable().$('tr', {'filter': 'applied'}));
}
function blastselectNone() {
    TableTools.fnGetInstance('blast_results_table').fnSelectNone();
}

function blastfnShowHide(iCol) {
    $('#blast_results_table').width("98%");
    /* Get the DataTables object again - this is not a recreation, just a get of the object */
    var oTable = $('#blast_results_table').dataTable();
    var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
    $('#blast-columnCheckbox' + iCol).html(bVis ? '&emsp;' : '&#10003;');
    oTable.fnSetColumnVis(iCol, bVis ? false : true);
}
