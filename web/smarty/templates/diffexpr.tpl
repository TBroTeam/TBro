{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
<script type="text/javascript" language="javascript" src="{#$AppPath#}/js/jquery.dataTables.js"></script>
<link rel="stylesheet" href="{#$AppPath#}/css/jquery.dataTables_themeroller.css" />
<script type="text/javascript">
    $(document).ready(function() {
        var filters = {};
        
        var oTable = $('#diffexp').dataTable( {
            "oLanguage": {
                "sSearch": "Search all columns:"
            },
            "bProcessing": true,
            "sAjaxSource": '{#$AppPath#}/ajax/listing/differential_expressions'
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
</script>
{#/block#}
{#block name='body'#}
<div class="row">
    <div class="large-12 column">
        <h1>Differential Expressions</h1>
    </div>
</div>
<div class="row">
    <div class="large-12 column">

        <table id="diffexp">
            <thead>  
                <tr>
                    <th>feature</th>
                    <th>baseMean</th>
                    <th>baseMeanA</th>
                    <th>baseMeanB</th>
                    <th>foldChange</th>
                    <th>log2foldChange</th>
                    <th>pval</th>
                    <th>pvaladj</th>
                </tr>
            </thead>  
            <tfoot>
                <tr>
                    <td>
                        <select>
                            <option value="contains">contains</option>
                        </select>
                        <input type="text" />
                    </td>
                    {#for $i=0; $i<7; $i++#}
                    <td>
                        <select>
                            <option value="lt">&lt;</option>
                            <option value="gt">&gt;</option>
                            <option value="eq">=</option>
                            <option value="contains">contains</option>
                        </select>
                        <input type="text" />
                    </td>
                    {#/for#}
                </tr>
            </tfoot>
            <tbody></tbody>
        </table>
    </div>
</div>
{#/block#}