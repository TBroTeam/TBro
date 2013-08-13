<script type="text/javascript">
    function fnShowHide(iCol)
    {
        $('#diffexp_results').width("98%")
        /* Get the DataTables object again - this is not a recreation, just a get of the object */
        var oTable = $('#diffexp_results').dataTable();

        var bVis = !document.getElementById('columnCheckbox' + iCol).checked;
        oTable.fnSetColumnVis(iCol, bVis ? false : true);
    }
</script>
<div id="diffexpr">
    <div class="row">
        <div class="large-12 columns panel">
            <div class="row">
                <div class="large-4 columns">
                    <h4>Condition A</h4>
                </div>
                <div class="large-4 columns">
                    <h4>Condition B</h4>
                </div>

                <div class="large-4 columns">
                    <h4>Analysis</h4>
                </div>
            </div>
            <form id="diffexp_filters">
                <div class="row">
                    <div class="large-4 columns">
                        <select id="select-gdfx-conditionA" size="12"></select>
                    </div>
                    <div class="large-4 columns">
                        <select id="select-gdfx-conditionB" size="12"></select>
                    </div>
                    <div class="large-4 columns">
                        <select id="select-gdfx-analysis" size="12"></select>
                    </div>
                </div>
        </div>
    </div>
    <div class="row">
        <div class="large-5 columns panel">
            <div class="row">
                <div class="large-8 columns">
                    <h4>Filters</h4>
                </div>
                <div class="large-4 columns">
                    <button type="button" id="button-gdfx-table" value="table" disabled="disabled">Apply</button>
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
            </div>
        </div>

        <div class="large-6 columns panel query_details" style="display:none" id="query_details">
            <div class="row">
                <div class="large-12 columns query_details" style="display:none">
                    <h4>Results Overview</h4>
                </div>
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
        <div class="row" id="div-gdfxtable-columnselector" style="display:none">        
            <div class="large-6 column">
                <button class="button dropdown" data-dropdown="show-hide-dropdown" data-options="is_hover:true">Show/hide columns</button>
                <ul id="show-hide-dropdown" class="f-dropdown" data-dropdown-content>
                    <li><input type="checkbox" id="columnCheckbox1" name="columnCheckbox1" checked="checked" onclick="fnShowHide(1);"/> Alias</li>
                    <li><input type="checkbox" id="columnCheckbox2" name="columnCheckbox2" checked="checked" onclick="fnShowHide(2);"/> baseMean</li>
                    <li><input type="checkbox" id="columnCheckbox3" name="columnCheckbox3" onclick="fnShowHide(3);"/> baseMean1</li>
                    <li><input type="checkbox" id="columnCheckbox4" name="columnCheckbox4" onclick="fnShowHide(4);"/> baseMean2</li>
                    <li><input type="checkbox" id="columnCheckbox5" name="columnCheckbox5" checked="checked" onclick="fnShowHide(5);"/> foldChange</li>
                    <li><input type="checkbox" id="columnCheckbox6" name="columnCheckbox6" checked="checked" onclick="fnShowHide(6);"/> log2foldChange</li>
                    <li><input type="checkbox" id="columnCheckbox7" name="columnCheckbox7" onclick="fnShowHide(7);"/> pval</li>
                    <li><input type="checkbox" id="columnCheckbox8" name="columnCheckbox8" checked="checked" onclick="fnShowHide(8);"/> pvaladj</li>
                </ul>
            </div>
            <div class="large-6 column">
                <button class="button" id="download-csv-button"> Download .csv </button>
            </div>
        </div>
        <div class="large-12 column">
            <h4>Detailed Results</h4>
        </div>
        <div class="large-12 column">
            <div class="row">
                <div class="large-12 column">
                    <span class="left" style="vertical-align: bottom">
                        <a style="margin-bottom:0px" class="small button" href="javascript:TableTools.fnGetInstance('diffexp_results').fnSelectAll();">select all</a>
                        <a style="margin-bottom:0px" class="small button" href="javascript:TableTools.fnGetInstance('diffexp_results').fnSelectNone();">select none</a>
                        <span>click a row to select</span>
                    </span>

                    <span class="right">
                        <button class="small button" type="button" id="button-gdfx-addToCart" value="table">add selected to cart: </button>
                        <select style="width:auto" id="select-gdfx-cart"><option class="keep" value='#new#'>new</option></select>
                    </span>
                </div>
            </div>
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