$(document).ready(function() {
    var filters = {};
    
    jQuery.extend( jQuery.fn.dataTableExt.oSort, {
        "natural-asc": function ( a, b ) {
            return alphanum(a,b);
        },
 
        "natural-desc": function ( a, b ) {
            return alphanum(a,b) * -1;
        },
        "scientific-pre": function ( a ) {
            if (a=='Inf') return Infinity;
            if (a=='-Inf') return -Infinity;
            return parseFloat(a);
        },
 
        "scientific-asc": function ( a, b ) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },
 
        "scientific-desc": function ( a, b ) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
    } );
        
    $.fn.dataTableExt.afnFiltering.push(
        function( oSettings, aData, iDataIndex ) {
            for (var i=0; i<aData.length; i++){
                var filter = filters[i];
                if (filter == undefined || filter.type == undefined) continue;
                if (filter.value=='') continue;
                
                var val = aData[i];
                switch (filter.type){
                    case 'contains':
                        if (!(val.indexOf(filter.value) !== -1)) return false;
                        break;
                    case 'lt':
                        if (!(parseFloat(val) < parseFloat(filter.value))) return false;
                        break;
                    case 'gt':
                        if (!(parseFloat(val) > parseFloat(filter.value))) return false;
                        break;
                    case 'eq':
                        if (!(parseFloat(val) == parseFloat(filter.value))) return false;
                        break;
                }
            }
            return true;
        });
        
        
        
    $.ajax('{#$ServicePath#}/listing/differential_expressions', {
        method: 'post',
        data: {
            ids: $.map(cartitems, function(v){
                return v.feature_id;
            })
        },
        success: function(data) {
            var oTable = $('#diffexp').dataTable( {
                bJQueryUI: true,
                aaData: data.aaData,
                oLanguage: {
                    sSearch: "Search all columns:"
                },
                aoColumns: [
                {
                    sType: "natural"
                },
                {
                    sType: "scientific"
                },
                {
                    sType: "scientific"
                },
                {
                    sType: "scientific"
                },
                {
                    sType: "scientific"
                },
                {
                    sType: "scientific"
                },
                {
                    sType: "scientific"
                },
                {
                    sType: "scientific"
                },
                ],
                sDom: 'T<"clear">lfrtip',
                oTableTools: {
                    sSwfPath: "{#$AppPath#}/swf/copy_csv_xls_pdf.swf"
                }
            } );
        }
    });

        
        
    function update_filter() {
        /* Filter on the column (the index) of this element */
        var index = $(this).parent().parent().children().index($(this).parent());
        var oldfilters = filters;
        filters[index] = {
            type : $("tfoot select")[index].value,
            value: $("tfoot input")[index].value
        };
            
        if (!_.isEquals(oldfilters, filters))
            oTable.fnDraw();
    }
     
    $("tfoot input").keyup( update_filter);
    $("tfoot select").click( update_filter);
        
});