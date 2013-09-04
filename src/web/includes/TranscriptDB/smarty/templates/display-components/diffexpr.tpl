<script type="text/javascript">
    $(document).ready(function() {
        new Grouplist($('#button-gdfx-addToCart-options'), cart, addSelectedToCart);
        $('#button-gdfx-addToCart-options-newcart').click(addSelectedToCart);
    });

    function addSelectedToCart() {
        var group = $(this).attr('data-value');
        var selectedItems = TableTools.fnGetInstance('diffexp_results').fnGetSelectedData();
        if (selectedItems.length === 0)
            return;
        if (group === '#new#')
            group = cart.addGroup();
        cart.addItem($.map(selectedItems, function(val) {
            return val.feature_id;
        }), {
            groupname: group
        });

    }

    function fnShowHide(iCol)
    {
        $('#diffexp_results').width("98%")
        /* Get the DataTables object again - this is not a recreation, just a get of the object */
        var oTable = $('#diffexp_results').dataTable();
        var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
        $('#columnCheckbox' + iCol).html(bVis ? '&emsp;' : '&#10003;');
        oTable.fnSetColumnVis(iCol, bVis ? false : true);
    }
    function fnNumOfEntries(numOfEntries)
    {
        /* Get the DataTables object again - this is not a recreation, just a get of the object */
        var oTable = $('#diffexp_results').dataTable();
        var oSettings = oTable.fnSettings();
        oSettings._iDisplayLength = numOfEntries;
        oTable.fnDraw();
    }
</script>
<div id="diffexpr">
    <div class="row">
        <div class="large-12 columns panel">
            <div class="row">
                <div class="large-3 columns">
                    <h4>Experiment</h4>
                </div>
                <div class="large-3 columns">
                    <h4>Condition A</h4>
                </div>
                <div class="large-3 columns">
                    <h4>Condition B</h4>
                </div>

                <div class="large-3 columns">
                    <h4>Analysis</h4>
                </div>
            </div>
            <form id="diffexp_filters">
                <div class="row">
                    <div class="large-3 columns">
                        <select id="select-gdfx-assay" size="12"></select>
                    </div>
                    <div class="large-3 columns">
                        <select id="select-gdfx-conditionA" size="12"></select>
                    </div>
                    <div class="large-3 columns">
                        <select id="select-gdfx-conditionB" size="12"></select>
                    </div>
                    <div class="large-3 columns">
                        <select id="select-gdfx-analysis" size="12"></select>
                    </div>
                </div>
        </div>
    </div>

    <div class="row">
        <div class="large-6 panel" style="float:left;  width:49%">
                <div class="large-12 columns">
                    <h4>Filters</h4>
                </div>


                <table id="filters" style="width:100%">
                    {#$i=1#}
                    {#foreach ['baseMean','baseMeanA','baseMeanB','foldChange','log2foldChange','pval','pvaladj'] as $filter_key#}
                        <tr>
                            <th>{#$filter_key#}</th>
                            <td>
                                <select name="filter_column[{#$i#}][type]">
                                    <option value="lt">&lt;</option>
                                    <option value="gt">&gt;</option>
                                    <option value="leq">&lt;=</option>
                                    <option value="geq">&gt;=</option>
                                    <option value="eq">=</option>
                                </select>
                            </td>
                            <td>
                                <input name="filter_column[{#$i#}][value]" type="text" />
                            </td>
                        </tr>
                        {#$i=$i+1#}
                    {#/foreach#}
                </table>
                <button class="right" type="button" id="button-gdfx-table" value="table" disabled="disabled">Apply</button>


        </div>

        <div class="large-6 query_details  panel" style="display:none; float:right; width:49%" id="query_details">
                <div class="large-12 columns query_details" style="display:none">
                    <h4>Results Overview</h4>
                </div>
                <table style="width:100%" >
                    <tr>
                        <td>Condition 1</td>
                        <td class='conditionA has-tooltip'></td>
                    </tr>
                    <tr>
                        <td>Condition 2</td>
                        <td class='conditionB has-tooltip'></td>
                    </tr>
                    <tr>
                        <td>Analysis</td>
                        <td class='analysis has-tooltip'></td>
                    </tr>
                    <tr>
                        <td>Organism</td>
                        <td class='organism'></td>
                    </tr>
                    <tr>
                        <td>Release</td>
                        <td class='release'></td>
                    </tr>
                    <tr>
                        <td>Hits</td>
                        <td class='hits'></td>
                    </tr>
                </table>
        </div>
    </div>
</form>

<div class="row" id="div-gdfxtable" style="display:none">
    <div class="large-12 column panel">
        <div class="large-12">
            <h4>Detailed Results</h4>
        </div>
        <div class="large-12" id="div-gdfxtable-columnselector" style="display:none">        
            <ul class="button-group even-5">
                <li><button class="small button dropdown" id="show-entries-dropdown" data-dropdown="show-entries-dropdown-options"> Show Entries </button></li>
                <li><button class="small button dropdown" data-dropdown="show-hide-dropdown" data-options="is_hover:true">Show Columns</button></li>
                <li><button class="small button dropdown" data-dropdown="select-all-none-dropdown">Select</button></li>
                <li><button class="small button dropdown" type="button" id="button-gdfx-addToCart" data-dropdown="button-gdfx-addToCart-options"> Store </button></li>
                <li><button class="small button dropdown" id="download-dropdown" data-dropdown="download-dropdown-options"> Export </button></li>
            </ul>

            <ul class="f-dropdown" id="show-entries-dropdown-options" data-dropdown-content>
                <li onclick="fnNumOfEntries(10);"> 10 </li> 
                <li onclick="fnNumOfEntries(20);"> 20 </li> 
                <li onclick="fnNumOfEntries(50);"> 50 </li> 
                <li onclick="fnNumOfEntries(100);"> 100 </li> 
            </ul>
            <ul id="show-hide-dropdown" class="f-dropdown" data-dropdown-content>
                <li onclick="fnShowHide(1);"><span id="columnCheckbox1" style="width: 15px; display: inline-block"/>&#10003;</span> Alias</li>
                <li onclick="fnShowHide(2);"><span id="columnCheckbox2" style="width: 15px; display: inline-block"/>&#10003;</span> baseMean</li>
                <li onclick="fnShowHide(3);"><span id="columnCheckbox3" style="width: 15px; display: inline-block"/>&emsp;</span> baseMean1</li>
                <li onclick="fnShowHide(4);"><span id="columnCheckbox4" style="width: 15px; display: inline-block"/>&emsp;</span> baseMean2</li>
                <li onclick="fnShowHide(5);"><span id="columnCheckbox5" style="width: 15px; display: inline-block"/>&#10003;</span> foldChange</li>
                <li onclick="fnShowHide(6);"><span id="columnCheckbox6" style="width: 15px; display: inline-block"/>&#10003;</span> log2foldChange</li>
                <li onclick="fnShowHide(7);"><span id="columnCheckbox7" style="width: 15px; display: inline-block"/>&emsp;</span> pval</li>
                <li onclick="fnShowHide(8);"><span id="columnCheckbox8" style="width: 15px;"/>&#10003;</span> pvaladj</li>
            </ul>
            <ul id="select-all-none-dropdown" class="f-dropdown" data-dropdown-content>
                <li onclick="TableTools.fnGetInstance('diffexp_results').fnSelectAll();" style="width:100%">All</li>
                <li onclick="TableTools.fnGetInstance('diffexp_results').fnSelectNone();" style="width:100%">None</li>
            </ul>
            <ul id="button-gdfx-addToCart-options" class="f-dropdown" data-dropdown-content>
                <li id="button-gdfx-addToCart-options-newcart" class="keep" data-value="#new#">new</li>
            </ul>
            <ul class="f-dropdown" id="download-dropdown-options" data-dropdown-content>
                <li id="download_csv_button" > csv </li> 
            </ul>
        </div>
        <div class="large-12" style="padding-right: 4px;">
            <table id="diffexp_results">
                <thead>  
                    <tr>
                        <th>Sequence ID</th>
                        <th>Alias</th>
                        <th>baseMean</th>
                        <th>baseMean1</th>
                        <th>baseMean2</th>
                        <th>foldChange</th>
                        <th>log2foldChange</th>
                        <th>pval</th>
                        <th>pvaladj</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot></tfoot>
            </table>
        </div>
    </div>
</div>
</div>