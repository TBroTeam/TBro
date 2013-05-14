{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
<script type="text/javascript" language="javascript" src="{#$AppPath#}/js/jquery.dataTables.js"></script>
<link rel="stylesheet" href="{#$AppPath#}/css/jquery.dataTables_themeroller.css" />
<script type="text/javascript">
    $(document).ready(function($) {
        $('#diffexp').dataTable({
            "bProcessing": true,
            "sAjaxSource": '{#$AppPath#}/ajax/listing/differential_expressions'
        });
    });
</script>
{#/block#}
{#block name='body'#}
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
    <tbody>
        <tr>
            <td>comp1</td>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5</td>
            <td>6</td>
            <td>7</td>
        </tr>
        <tr>
            <td>comp2</td>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5</td>
            <td>6</td>
            <td>7</td>
        </tr><tr>
            <td>comp3</td>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5</td>
            <td>6</td>
            <td>7</td>
        </tr><tr>
            <td>comp4</td>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5</td>
            <td>6</td>
            <td>7</td>
        </tr>
    </tbody>
</table>
{#/block#}