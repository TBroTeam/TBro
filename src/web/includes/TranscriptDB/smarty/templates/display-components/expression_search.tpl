<script type="text/javascript">
    {#include file="js/expression_search.js"#}

    $(document).ready(function () {
        new Grouplist($('#expression-button-gdfx-addToCart-options'), cart, expressionaddSelectedToCart);
        $('#expression-button-gdfx-addToCart-options-newcart').click(expressionaddSelectedToCart);
    });

    function expressionaddSelectedToCart() {
        var group = $(this).attr('data-value');
        var selectedItems = TableTools.fnGetInstance('expression-results').fnGetSelectedData();
        if (selectedItems.length === 0)
            return;
        if (group === '#new#')
            group = cart.addGroup();
        cart.addItem($.map(selectedItems, function (val) {
            return val[0];
        }), {
            groupname: group
        });
    }

    function expressionfnNumOfEntries(numOfEntries)
    {
        /* Get the DataTables object again - this is not a recreation, just a get of the object */
        var oTable = $('#expression-results').dataTable();
        var oSettings = oTable.fnSettings();
        oSettings._iDisplayLength = numOfEntries;
        oTable.fnDraw();
    }
</script>

<script type="text/template"  id="template_biomaterial_filter"> 
    <tr>
                    <th><%= name %></th>
                    <td>
                        <select id="expressions_filter_mean_type_<%=id%>" biomaterial-id="<%=id%>">
                            <option value="lt">&lt;</option>
                            <option value="gt">&gt;</option>
                            <option value="leq">&lt;=</option>
                            <option value="geq">&gt;=</option>
                            <option value="eq">=</option>
                        </select>
                    </td>
                    <td>
                        <input id="expressions_filter_mean_value_<%=id%>" type="text" biomaterial-id="<%=id%>"/>
                    </td>
                </tr>
</script>

<style type="text/css">
    #expression-filters tr td, #expression-filters tr th, #biomaterial-expression-filters tr td, #biomaterial-expression-filters tr th {
        padding: 1px !important;
    }
    #expression-filters input, #biomaterial-expression-filters input {
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
            <h4>Filters</h4>
            <h6>General</h6>
            <table id="expression-filters" style="width:100%">
                <tr>
                    <th>All</th>
                    <td>
                        <select id="expressions_filter_all_type">
                            <option value="lt">&lt;</option>
                            <option value="gt">&gt;</option>
                            <option value="leq">&lt;=</option>
                            <option value="geq">&gt;=</option>
                            <option value="eq">=</option>
                        </select>
                    </td>
                    <td>
                        <input id="expressions_filter_all_value" type="text" />
                    </td>
                </tr>
                <tr>
                    <th>One</th>
                    <td>
                        <select id="expressions_filter_one_type">
                            <option value="lt">&lt;</option>
                            <option value="gt">&gt;</option>
                            <option value="leq">&lt;=</option>
                            <option value="geq">&gt;=</option>
                            <option value="eq">=</option>
                        </select>
                    </td>
                    <td>
                        <input id="expressions_filter_one_value" type="text" />
                    </td>
                </tr>
                <tr>
                    <th>Mean</th>
                    <td>
                        <select id="expressions_filter_mean_type">
                            <option value="lt">&lt;</option>
                            <option value="gt">&gt;</option>
                            <option value="leq">&lt;=</option>
                            <option value="geq">&gt;=</option>
                            <option value="eq">=</option>
                        </select>
                    </td>
                    <td>
                        <input id="expressions_filter_mean_value" type="text" />
                    </td>
                </tr>
            </table>
            <h6>Biomaterial (Mean)</h6>
            <table id="biomaterial-expression-filters" style="width:100%">

            </table>
            <button class="right" type="button" id="expression-button-gdfx-table" value="table" disabled="disabled">Apply</button>
        </div>
    </div>
</form>

<div class="loading alert-box" style="display:none;">
    Please wait, loading!
</div>
<div class="row" id="expression-div-gdfxtable" style="display:none">
    <div class="large-12 column panel">
        <div class="large-12">
            <h4>Results</h4>
        </div>
        <div class="large-12" id="expression-div-gdfxtable-columnselector">        
            <ul class="button-group even-4">
                <li><button class="small button dropdown" id="expression-show-entries-dropdown" data-dropdown="expression-show-entries-dropdown-options"> Show Entries </button></li>
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
                <li onclick="$('#expression-results').dataTable().fnSelectAll();" style="width:100%">All</li>
                <li onclick="$('#expression-results').dataTable().fnSelectNone();" style="width:100%">None</li>
            </ul>
            <ul id="expression-button-gdfx-addToCart-options" class="f-dropdown" data-dropdown-content>
                <li id="expression-button-gdfx-addToCart-options-newcart" class="keep" data-value="#new#">new</li>
            </ul>
            <ul class="f-dropdown" id="expression-download-dropdown-options" data-dropdown-content>
                <li id="expression-download_csv_button" > tsv </li> 
            </ul>
        </div>
        <div class="large-12" style="padding-right: 4px;">
            <table id="expression-results">

            </table>
        </div>
    </div>
</div>
</div>