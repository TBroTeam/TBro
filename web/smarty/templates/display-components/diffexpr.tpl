<div id="diffexpr">
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
            <div class="large-4 columns panel">
                <select id="select-gdfx-conditionA" size="12"></select>
            </div>
            <div class="large-4 columns panel">
                <select id="select-gdfx-conditionB" size="12"></select>
            </div>
            <div class="large-4 columns panel">
                <select id="select-gdfx-analysis" size="12"></select>
            </div>
        </div>
        <div class="row">
            <div class="large-5 columns">
                <h4>Filters</h4>
            </div>
            <div class="large-2 columns">
                &nbsp;
            </div>
            <div class="large-5 columns query_details" style="display:none">
                <h4>Results overview</h4>
            </div>
        </div>
        <div class="row">
            <div class="large-5 columns panel">

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

            <div class="large-2 columns position" data-my="left center" data-at="right center" data-of="PREV">
                <button type="button" id="button-gdfx-table" value="table">display Table</button>
            </div>

            <div class="large-5 columns  panel query_details" style="display:none" id="query_details">
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
        <div class="large-12 column">
            <h4>Detailed Results</h4>
        </div>
        <div class="large-12 column panel">
            <div class="large-12 column">
                <table id="diffexp_results">
                    <thead>  
                        <tr>
                            <th>feature</th>
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
                </table>
            </div>
            <div class="large-12 column">
                <span>
                    click a row to select
                </span>
                <span class=" right">
                    <button class="small button" type="button" id="button-gdfx-addToCart" value="table">add selected to cart: </button>
                    <select style="width:auto" id="select-gdfx-cart"><option value='#new#'>new</option><option value='all'>all</option></select>
                </span>
            </div>
        </div>
    </div>
</div>