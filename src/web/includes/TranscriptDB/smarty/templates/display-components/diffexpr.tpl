<script type="text/javascript">
    {#if isset($cart_ids)#}
        {#include file="js/diffexpr.js" instance_name=$instance_name cart_ids=$cart_ids#}
    {#else#}
        {#include file="js/diffexpr.js" instance_name=$instance_name#}
    {#/if#}


    $(document).ready(function() {
        new Grouplist($('#{#$instance_name#}-button-gdfx-addToCart-options'), cart, {#$instance_name#}addSelectedToCart);
        $('#{#$instance_name#}-button-gdfx-addToCart-options-newcart').click({#$instance_name#}addSelectedToCart);
    });

    function {#$instance_name#}addSelectedToCart() {
        var group = $(this).attr('data-value');
        if (diffexpSelectedIDs.length === 0)
            return;
        if (group === '#new#')
            group = cart.addGroup();
        cart.addItem(diffexpSelectedIDs, {
            groupname: group
        });

    }

    function {#$instance_name#}fnShowHide(iCol)
    {
        $('#{#$instance_name#}-diffexp_results').width("98%");
        /* Get the DataTables object again - this is not a recreation, just a get of the object */
        var oTable = $('#{#$instance_name#}-diffexp_results').dataTable();
        var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
        $('#{#$instance_name#}-columnCheckbox' + iCol).html(bVis ? '&emsp;' : '&#10003;');
        oTable.fnSetColumnVis(iCol, bVis ? false : true);
    }
    function {#$instance_name#}fnNumOfEntries(numOfEntries)
    {
        /* Get the DataTables object again - this is not a recreation, just a get of the object */
        var oTable = $('#{#$instance_name#}-diffexp_results').dataTable();
        var oSettings = oTable.fnSettings();
        oSettings._iDisplayLength = numOfEntries;
        oTable.fnDraw();
    }
    function {#$instance_name#}selectAll() {
        if (typeof lastQueryData === 'undefined')
            return;
        var data = lastQueryData;
        data.push({name: "currentContext",
            value: organism.val() + '_' + release.val()
        });

        $.ajax('{#$ServicePath#}/listing/differential_expressions/getAllMatching', {
            method: 'post',
            data: data,
            success: function(response) {
                diffexpSelectedIDs = response;
                // fnSelectAll only for graphical selection
                TableTools.fnGetInstance('{#$instance_name#}-diffexp_results').fnSelectAll();
            }
        });
    }
    function {#$instance_name#}selectAllVisible() {
        // fnSelectAll only for graphical selection
        TableTools.fnGetInstance('{#$instance_name#}-diffexp_results').fnSelectAll();
        diffexpSelectedIDs = $.map(TableTools.fnGetInstance('{#$instance_name#}-diffexp_results').fnGetVisibleSelectedData(), function(val) {
            return val.feature_id;
        });
    }
    function {#$instance_name#}selectNone() {
        diffexpSelectedIDs = [];
        // fnSelectAll fnSelectNone only for graphical selection
        TableTools.fnGetInstance('{#$instance_name#}-diffexp_results').fnSelectAll();
        TableTools.fnGetInstance('{#$instance_name#}-diffexp_results').fnSelectNone();
    }

</script>

<style type="text/css">
    #{#$instance_name#}-filters tr td, #{#$instance_name#}-filters tr th {
        padding: 1px !important;
    }
    #{#$instance_name#}-filters input {
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
                    <h4>Condition A</h4>
                </div>
                <div class="large-3 columns">
                    <h4>Condition B</h4>
                </div>

                <div class="large-3 columns">
                    <h4>Analysis</h4>
                </div>
            </div>
            <form id="{#$instance_name#}-diffexp_filters">
                <div class="row">
                    <div class="large-3 columns">
                        <select id="{#$instance_name#}-select-gdfx-assay" size="12"></select>
                    </div>
                    <div class="large-3 columns">
                        <select id="{#$instance_name#}-select-gdfx-conditionA" size="12"></select>
                    </div>
                    <div class="large-3 columns">
                        <select id="{#$instance_name#}-select-gdfx-conditionB" size="12"></select>
                    </div>
                    <div class="large-3 columns">
                        <select id="{#$instance_name#}-select-gdfx-analysis" size="12"></select>
                    </div>
                </div>
        </div>
    </div>

    <div class="row">
        <div class="large-6 panel" style="float:left;  width:49%">
            <div class="large-12 columns">
                <h4>Filters</h4>
            </div>


            <table id="{#$instance_name#}-filters" style="width:100%">
                {#$i=5#}
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
            <button class="right" type="button" id="{#$instance_name#}-button-gdfx-table" value="table" disabled="disabled">Apply</button>


        </div>

        <div class="large-6 query_details  panel" style="display:none; float:right; width:49%" id="{#$instance_name#}-query_details">
            <div class="large-12 columns query_details" style="display:none">
                <h4>Results Overview</h4>
            </div>
            <div id='{#$instance_name#}-swappedWarning' class='large-12 columns panel' style="display: none; color:#c60f13">
                Warning! Conditions A and B have been swapped due to their orientation in the database.
                Filters still apply to your selection but the table does not.
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

<div class="row" id="{#$instance_name#}-div-gdfxtable" style="display:none">
    <div class="large-12 column panel">
        <div class="large-12">
            <h4>Detailed Results</h4>
        </div>
        <div class="large-12" id="{#$instance_name#}-div-gdfxtable-columnselector" style="display:none">        
            <ul class="button-group even-5">
                <li><button class="small button dropdown" id="{#$instance_name#}-show-entries-dropdown" data-dropdown="{#$instance_name#}-show-entries-dropdown-options"> Show Entries </button></li>
                <li><button class="small button dropdown" data-dropdown="{#$instance_name#}-show-hide-dropdown" data-options="is_hover:true">Show Columns</button></li>
                <li><button class="small button dropdown" data-dropdown="{#$instance_name#}-select-all-none-dropdown">Select</button></li>
                <li><button class="small button dropdown" type="button" id="{#$instance_name#}-button-gdfx-addToCart" data-dropdown="{#$instance_name#}-button-gdfx-addToCart-options"> Store </button></li>
                <li><button class="small button dropdown" id="{#$instance_name#}-download-dropdown" data-dropdown="{#$instance_name#}-download-dropdown-options"> Export </button></li>
            </ul>

            <ul class="f-dropdown" id="{#$instance_name#}-show-entries-dropdown-options" data-dropdown-content>
                <li onclick="{#$instance_name#}fnNumOfEntries(10);"> 10 </li> 
                <li onclick="{#$instance_name#}fnNumOfEntries(20);"> 20 </li> 
                <li onclick="{#$instance_name#}fnNumOfEntries(50);"> 50 </li> 
                <li onclick="{#$instance_name#}fnNumOfEntries(100);"> 100 </li> 
                <li onclick="{#$instance_name#}fnNumOfEntries(1000);"> 1000 </li> 
                <!--<li onclick="fnNumOfEntries(1000000);"> All (Caution!) </li>-->
            </ul>
            <ul id="{#$instance_name#}-show-hide-dropdown" class="f-dropdown" data-dropdown-content>
                <li onclick="{#$instance_name#}fnShowHide(1);"><span id="{#$instance_name#}-columnCheckbox1" style="width: 15px; display: inline-block"/>&emsp;</span> DB Alias</li>
                <li onclick="{#$instance_name#}fnShowHide(2);"><span id="{#$instance_name#}-columnCheckbox2" style="width: 15px; display: inline-block"/>&#10003;</span> DB Description</li>
                <li onclick="{#$instance_name#}fnShowHide(3);"><span id="{#$instance_name#}-columnCheckbox3" style="width: 15px; display: inline-block"/>&#10003;</span> User Alias</li>
                <li onclick="{#$instance_name#}fnShowHide(4);"><span id="{#$instance_name#}-columnCheckbox4" style="width: 15px; display: inline-block"/>&#10003;</span> User Description</li>
                <li onclick="{#$instance_name#}fnShowHide(5);"><span id="{#$instance_name#}-columnCheckbox5" style="width: 15px; display: inline-block"/>&emsp;</span> baseMean</li>
                <li onclick="{#$instance_name#}fnShowHide(6);"><span id="{#$instance_name#}-columnCheckbox6" style="width: 15px; display: inline-block"/>&emsp;</span> baseMeanA</li>
                <li onclick="{#$instance_name#}fnShowHide(7);"><span id="{#$instance_name#}-columnCheckbox7" style="width: 15px; display: inline-block"/>&emsp;</span> baseMeanB</li>
                <li onclick="{#$instance_name#}fnShowHide(8);"><span id="{#$instance_name#}-columnCheckbox8" style="width: 15px;"/>&#10003;</span> foldChange</li>
                <li onclick="{#$instance_name#}fnShowHide(9);"><span id="{#$instance_name#}-columnCheckbox6" style="width: 15px; display: inline-block"/>&emsp;</span> log2foldChange</li>
                <li onclick="{#$instance_name#}fnShowHide(10);"><span id="{#$instance_name#}-columnCheckbox7" style="width: 15px; display: inline-block"/>&emsp;</span> pval</li>
                <li onclick="{#$instance_name#}fnShowHide(11);"><span id="{#$instance_name#}-columnCheckbox8" style="width: 15px;"/>&#10003;</span> pvaladj</li>
            </ul>
            <ul id="{#$instance_name#}-select-all-none-dropdown" class="f-dropdown" data-dropdown-content>
                <li onclick="{#$instance_name#}selectAll();" style="width:100%">All</li>
                <li onclick="{#$instance_name#}selectAllVisible();" style="width:100%">All visible</li>
                <li onclick="{#$instance_name#}selectNone();" style="width:100%">None</li>
            </ul>
            <ul id="{#$instance_name#}-button-gdfx-addToCart-options" class="f-dropdown" data-dropdown-content>
                <li id="{#$instance_name#}-button-gdfx-addToCart-options-newcart" class="keep" data-value="#new#">new</li>
            </ul>
            <ul class="f-dropdown" id="{#$instance_name#}-download-dropdown-options" data-dropdown-content>
                <li id="{#$instance_name#}-download_csv_button" > csv </li> 
            </ul>
        </div>
        <div class="large-12" style="padding-right: 4px;">
            <table id="{#$instance_name#}-diffexp_results">
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