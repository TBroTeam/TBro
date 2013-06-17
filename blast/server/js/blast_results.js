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

function displayIterationGraph(iteration, canvasId, colorKey, elementClickCallback){
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
        
    canvas = $('#'+canvasId);
    return new CanvasXpress(
        canvasId,
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

