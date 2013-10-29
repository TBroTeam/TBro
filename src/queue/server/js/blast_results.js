/**
 * get GET parameter from querystring
 */
function getParameterByName(name) {
    var uri = location.search;
    var params = uri.substr(uri.indexOf('?')+1);
    var splitParams = params.split(/(&amp;|&)/);
    for (var i=0; i<splitParams.length; i++){
        var matches = splitParams[i].match(/^(.*)=(.*)$/);
        if (matches!=null && matches[1]==name){
            return matches[2];
        }
    }
    return undefined;
}

/**
 * parses Blast XML output into a Javascript Object
 */
function parseBlastXml(job_results){
    function parse_children(skip_children, regexp, nodes){
        var ret = {};
        nodes.each(function(){
            if ($.inArray(this.nodeName, skip_children)>=0){
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
    var jqR = $($.parseXML( job_results ));
    var execDetails = {
        program: jqR.find('BlastOutput_program').text(),
        version: jqR.find('BlastOutput_version').text(),
        reference: jqR.find('BlastOutput_reference').text()
    };
    execDetails.parameters = parse_children([], parmRx, jqR.find('BlastOutput_param Parameters').children());
        
    var iterations = [];
    jqR.find('BlastOutput_iterations Iteration').each(function(){
        var jqIt = $(this);
        var iteration = parse_children(['Iteration_hits', 'Iteration_stat'], iterRx, jqIt.children());
            
        iteration.hits = [];
            
        jqIt.find('Iteration_hits Hit').each(function(){
            var jqHit = $(this);
            var hit = parse_children(['Hit_hsps'], hitRx, jqHit.children());
            var hitcoverage = [];
            for (var i=1; i<=iteration['query-len']; i++){
                hitcoverage[i]=false;
            }
            hit.hsps = [];
            hit.def_firstword = hit.def;
            if(hit.def.indexOf(' ') > 0)
                hit.def_firstword = hit.def.substr(0,hit.def.indexOf(' '));
            hit.max_score = 0;
            hit.max_ident = 0;
            hit.total_score = 0;
            hit.evalue = Infinity;
            jqHit.find('Hsp').each(function(){
                var jqHsp=$(this);
                var hsp = parse_children([], hspRx, jqHsp.children());
                for (var i=hsp['query-from']; i<=hsp['query-to']; i++){
                    hitcoverage[i]=hsp.hseq[i-1]!=='-';
                }
                hit.max_score = Math.max(hit.max_score, hsp.score);
                hit.max_ident = Math.max(hit.max_ident, hsp.identity/(hsp['align-len']));
                hit.total_score += hsp.score;
                hit.evalue = Math.min(hit.evalue, hsp.evalue);
                hit.hsps.push(hsp);
            });                
            hit.query_coverage = _.compact(hitcoverage).length/iteration['query-len'];
            iteration.hits.push(hit);
        });
        iterations.push(iteration);
    });
           
    return {
        execDetails:execDetails, 
        iterations:iterations
    };   

}

/**
 * displays a CanvasXP 'Genome'-Type Graph for the given iteration in the given canvas
 */

function displayIterationGraph(iteration, canvas, colorKey, elementClickCallback){
    var colorForScore = function(score){
        for( var k in colorKey ) {
            if(colorKey.hasOwnProperty(k)) {
                if (score<k)
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
       
    $.each(iteration.hits, function(){
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
        _.each(this.hsps, function(hsp){
            track.data[0].data.push([hsp['query-from'], hsp['query-to']]);
            track.data[0].fill.push(colorForScore(hsp['score']));
        });
        tracks.push(track);
    });
    
    return new CanvasXpress(
        canvas.attr('id'),
        {
            min:0,
            max:iteration['query-len']+1,
            tracks: tracks
        },{
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
            click: function(){
                var hit = arguments[0][0].hit;
                elementClickCallback.apply(hit, arguments);
            }
        }
        );
}


/**
 * calls displayIterationGraph, fills Iteration Table
 */    
function displayIteration(iteration, resultTable, canvas, options){
    options = $.extend({
        prepare_feature_url:function(featurename, options){
            return '/'+featurename+'#'+featurename.replace('.','_');
        }
    }, options);
    function openRowOnHit(){
        var hit = this;
        if (typeof hit == "undefined") return;
        var aSettings = resultTable.fnSettings();
        $.each (aSettings.aoData, function (){
            var aData = this._aData;
            if (_.isEqual(aData, hit)){
                this.nTr.click();
                $(document.body).animate({
                    scrollTop: $(this.nTr).offset().top-75
                }, 'fast');
                return false;
            }
        });
    }
        
    function fnMDataScientific(storeValue){
        return function ( data, type, val ) {
            if (type === 'set') {
                data[storeValue] = val;
                return;
            }
            else if (type === 'display') {
                return fmtScientific(data[storeValue]);
            }
            return data[storeValue];
        }
    };

    function openCloseDetails(){
        if ( resultTable.fnIsOpen(this) ) {
            resultTable.fnClose( this );
        } else {
            var aData = resultTable.fnGetData( this );
            resultTable.fnOpen( this, templates.PROCESSED_HIT({
                hit: aData
            }), 'details' );
        }
    }
        
    canvas.attr('width', canvas.parent().width() - 8);
    displayIterationGraph(iteration, canvas, colorKey, openRowOnHit);
    if (!$.fn.DataTable.fnIsDataTable(resultTable.get())){
        resultTable.dataTable({
            aaSorting: [[ 2, "desc" ]],
            aaData: iteration.hits,
            bPaginate: false,
            bFilter: false,
            aoColumns: [
            {
                mData: "def_firstword", 
                sTitle:"id"
            },
            {
                mData: "max_score", 
                sTitle:"max score"
            },
            {
                mData: "total_score", 
                sTitle:"total score"
            },
            {
                mData: fnMDataScientific("query_coverage"), 
                sTitle:"coverage"
            },
            {
                mData: fnMDataScientific("evalue"), 
                sTitle:"evalue"
            },
            {
                mData: fnMDataScientific("max_ident"), 
                sTitle:"max identity"
            }
            ],
            fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                $(nRow).find('td:eq(0)').html( '<a target="_blank" href="'+options.prepare_feature_url(aData.def_firstword, options)+'">'+aData.def_firstword+'</a>' );
                $(nRow).css( 'cursor', 'pointer' );
            }
        });
        resultTable.on('click','tr',openCloseDetails);
    } else {
        resultTable.fnClearTable();
        resultTable.fnAddData(iteration.hits);
    }
}
    
    
/**
 * formats a number. 0 will be output as 0, |values| less than 0.001 will be output as scientific numbers, others will be output with 3 significant numbers
 */
function fmtScientific(val){
    if (val == 0)
        return val;
    if (Math.abs(val) < 0.001)
        return sprintf('%.3e', val);
    return sprintf('%.3f',val);
}


/**
 * wordwraps the three lines hseq, qseq and midline  around line_length, prepends numbers and counts around gaps
 */
function cut_alignment(qseq, hseq, midline, line_length, qseq_start, hseq_start){
    var ret = [];
    var qseq_pos = qseq_start;
    var hseq_pos = hseq_start;
        
    for (var i=0; i<qseq.length; i+=line_length){
            
        var qseq_sub = qseq.substring(i, i+line_length);
        var qseq_gaps = (qseq_sub.match(/\-/g)||[]).length;
        var hseq_sub = hseq.substring(i, i+line_length);
        var hseq_gaps = (hseq_sub.match(/\-/g)||[]).length;
            
        var chunk = {
            qseq:    qseq_sub,
            qseq_start: qseq_pos,
            qseq_end  : qseq_pos + qseq_sub.length - 1 - qseq_gaps,
            hseq:    hseq_sub,
            hseq_start: hseq_pos,
            hseq_end  : hseq_pos + hseq_sub.length - 1 - hseq_gaps,
            midline: midline.substring(i, i+line_length)
        };
            
        qseq_pos += line_length - qseq_gaps;
        hseq_pos += line_length - hseq_gaps;
            
        ret.push(chunk);
    }
    return ret;
}