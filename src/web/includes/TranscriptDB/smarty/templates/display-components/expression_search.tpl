<script type="text/javascript">
    {#include file="js/expression_search.js"#}

    $(document).ready(function () {
        new Grouplist($('#expression-button-gdfx-addToCart-options'), cart, expressionaddSelectedToCart);
        $('#expression-button-gdfx-addToCart-options-newcart').click(expressionaddSelectedToCart);
    });

    function expressionaddSelectedToCart() {
        var group = $(this).attr('data-value');
        if (diffexpSelectedIDs.length === 0)
            return;
        if (group === '#new#')
            group = cart.addGroup();
        cart.addItem(diffexpSelectedIDs, {
            groupname: group
        });

    }

    function expressionfnShowHide(iCol)
    {
        $('#expression-diffexp_results').width("98%");
        /* Get the DataTables object again - this is not a recreation, just a get of the object */
        var oTable = $('#expression-diffexp_results').dataTable();
        var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
        $('#expression-columnCheckbox' + iCol).html(bVis ? '&emsp;' : '&#10003;');
        oTable.fnSetColumnVis(iCol, bVis ? false : true);
    }
    function expressionfnNumOfEntries(numOfEntries)
    {
        /* Get the DataTables object again - this is not a recreation, just a get of the object */
        var oTable = $('#expression-diffexp_results').dataTable();
        var oSettings = oTable.fnSettings();
        oSettings._iDisplayLength = numOfEntries;
        oTable.fnDraw();
    }
    function expressionselectAll() {
        if (typeof lastQueryData === 'undefined')
            return;
        var data = lastQueryData;
        data.push({name: "currentContext",
            value: organism.val() + '_' + release.val()
        });

        $.ajax('{#$ServicePath#}/listing/differential_expressions/getAllMatching', {
            method: 'post',
            data: data,
            success: function (response) {
                diffexpSelectedIDs = response;
                // fnSelectAll only for graphical selection
                TableTools.fnGetInstance('expression-diffexp_results').fnSelectAll();
            }
        });
    }
    function expressionselectAllVisible() {
        // fnSelectAll only for graphical selection
        TableTools.fnGetInstance('expression-diffexp_results').fnSelectAll();
        diffexpSelectedIDs = $.map(TableTools.fnGetInstance('expression-diffexp_results').fnGetVisibleSelectedData(), function (val) {
            return val.feature_id;
        });
    }
    function expressionselectNone() {
        diffexpSelectedIDs = [];
        // fnSelectAll fnSelectNone only for graphical selection
        TableTools.fnGetInstance('expression-diffexp_results').fnSelectAll();
        TableTools.fnGetInstance('expression-diffexp_results').fnSelectNone();
    }

</script>

<style type="text/css">
    #expression-filters tr td, #expression-filters tr th {
        padding: 1px !important;
    }
    #expression-filters input {
        margin: 0px !important;
    }
    .no-wrap {
        white-space: nowrap;
        max-width: 150px;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .no-wrap:hover {
        overflow: visible;
    }
</style>       

<div id="diffexpr">
    <div class="row">
        <div class="large-12 columns panel">
            <div class="row">
                <div class="large-3 columns">
                    <h4>Experiment</h4>
                </div>
                <div class="large-3 columns">
                    <h4>Analysis</h4>
                </div>
                <div class="large-3 columns">
                    <h4>Biomaterial</h4>
                </div>

                <div class="large-3 columns">
                    <h4>Sample</h4>
                </div>
            </div>
            <form id="expression-diffexp_filters">
                <div class="row">
                    <div class="large-3 columns">
                        <select id="expression-select-gdfx-assay" size="12"></select>
                    </div>
                    <div class="large-3 columns">
                        <select id="expression-select-gdfx-analysis" size="12"></select>
                    </div>
                    <div class="large-3 columns">
                        <select id="expression-select-gdfx-biomaterial" size="12" multiple="multiple"></select>
                    </div>
                    <div class="large-3 columns">
                        <select id="expression-select-gdfx-sample" size="12" multiple="multiple"></select>
                    </div>
                </div>
        </div>
    </div>

    <div class="row">
        <div class="large-6 panel" style="float:left;  width:49%">
            <div class="large-12 columns">
                <h4>Filters</h4>
            </div>


            <table id="expression-filters" style="width:100%">
                {#$i=5#}
                {#foreach ['All','One'] as $filter_key#}
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
            <button class="right" type="button" id="expression-button-gdfx-table" value="table" disabled="disabled">Apply</button>


        </div>

        <div class="large-6 query_details  panel" style="display:none; float:right; width:49%" id="expression-query_details">
            <div class="large-12 columns query_details" style="display:none">
                <h4>Results Overview</h4>
            </div>
            <table style="width:100%" >
                <tr>
                    <td>Condition A</td>
                    <td class='conditionA has-tooltip'></td>
                </tr>
                <tr>
                    <td>Condition B</td>
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

<div class="row" id="expression-div-gdfxtable" style="display:none">
    <div class="large-12 column panel">
        <div class="large-12">
            <h4>Detailed Results</h4>
        </div>
        <div class="large-12" id="expression-div-gdfxtable-columnselector" style="display:none">        
            <ul class="button-group even-5">
                <li><button class="small button dropdown" id="expression-show-entries-dropdown" data-dropdown="expression-show-entries-dropdown-options"> Show Entries </button></li>
                <li><button class="small button dropdown" data-dropdown="expression-show-hide-dropdown" data-options="is_hover:true">Show Columns</button></li>
                <li><button class="small button dropdown" data-dropdown="expression-select-all-none-dropdown">Select</button></li>
                <li><button class="small button dropdown" type="button" id="expression-button-gdfx-addToCart" data-dropdown="expression-button-gdfx-addToCart-options"> Store </button></li>
                <li><button class="small button dropdown" id="expression-download-dropdown" data-dropdown="expression-download-dropdown-options"> Export </button></li>
            </ul>

            <ul class="f-dropdown" id="expression-show-entries-dropdown-options" data-dropdown-content>
                <li onclick="expressionfnNumOfEntries(10);"> 10 </li> 
                <li onclick="expressionfnNumOfEntries(20);"> 20 </li> 
                <li onclick="expressionfnNumOfEntries(50);"> 50 </li> 
                <li onclick="expressionfnNumOfEntries(100);"> 100 </li> 
                <li onclick="expressionfnNumOfEntries(1000);"> 1000 </li> 
                <!--<li onclick="fnNumOfEntries(1000000);"> All (Caution!) </li>-->
            </ul>
            <ul id="expression-show-hide-dropdown" class="f-dropdown" data-dropdown-content>
                <li onclick="expressionfnShowHide(1);"><span id="expression-columnCheckbox1" style="width: 15px; display: inline-block"/>&emsp;</span> DB Alias</li>
                <li onclick="expressionfnShowHide(2);"><span id="expression-columnCheckbox2" style="width: 15px; display: inline-block"/>&#10003;</span> DB Description</li>
                <li onclick="expressionfnShowHide(3);"><span id="expression-columnCheckbox3" style="width: 15px; display: inline-block"/>&#10003;</span> User Alias</li>
                <li onclick="expressionfnShowHide(4);"><span id="expression-columnCheckbox4" style="width: 15px; display: inline-block"/>&#10003;</span> User Description</li>
                <li onclick="expressionfnShowHide(5);"><span id="expression-columnCheckbox5" style="width: 15px; display: inline-block"/>&emsp;</span> baseMean</li>
                <li onclick="expressionfnShowHide(6);"><span id="expression-columnCheckbox6" style="width: 15px; display: inline-block"/>&emsp;</span> baseMeanA</li>
                <li onclick="expressionfnShowHide(7);"><span id="expression-columnCheckbox7" style="width: 15px; display: inline-block"/>&emsp;</span> baseMeanB</li>
                <li onclick="expressionfnShowHide(8);"><span id="expression-columnCheckbox8" style="width: 15px;"/>&#10003;</span> foldChange</li>
                <li onclick="expressionfnShowHide(9);"><span id="expression-columnCheckbox6" style="width: 15px; display: inline-block"/>&emsp;</span> log2foldChange</li>
                <li onclick="expressionfnShowHide(10);"><span id="expression-columnCheckbox7" style="width: 15px; display: inline-block"/>&emsp;</span> pval</li>
                <li onclick="expressionfnShowHide(11);"><span id="expression-columnCheckbox8" style="width: 15px;"/>&#10003;</span> pvaladj</li>
            </ul>
            <ul id="expression-select-all-none-dropdown" class="f-dropdown" data-dropdown-content>
                <li onclick="expressionselectAll();" style="width:100%">All</li>
                <li onclick="expressionselectAllVisible();" style="width:100%">All visible</li>
                <li onclick="expressionselectNone();" style="width:100%">None</li>
            </ul>
            <ul id="expression-button-gdfx-addToCart-options" class="f-dropdown" data-dropdown-content>
                <li id="expression-button-gdfx-addToCart-options-newcart" class="keep" data-value="#new#">new</li>
            </ul>
            <ul class="f-dropdown" id="expression-download-dropdown-options" data-dropdown-content>
                <li id="expression-download_csv_button" > tsv </li> 
            </ul>
        </div>
        <div class="large-12" style="padding-right: 4px;">
            <table id="expression-diffexp_results">
                <thead>  
                    <tr>
                        <th>Sequence ID</th>
                        <th>DB Alias</th>
                        <th>DB Description</th>
                        <th>User Alias</th>
                        <th>User Description</th>
                        <th>baseMean</th>
                        <th>baseMeanA</th>
                        <th>baseMeanB</th>
                        <th>foldChange</th>
                        <th>log2foldChange</th>
                        <th>pval</th>
                        <th>pvaladj</th>
                    </tr>
                </thead>
                <tbody style="white-space:nowrap"></tbody>
                <tfoot></tfoot>
            </table>
        </div>
    </div>
</div>
</div>