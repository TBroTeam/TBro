{#extends file='layout-with-cart.tpl'#}
{#block name='head'#}
<script type="text/javascript" src="{#$AppPath#}/js/feature/filteredSelect.js"></script>
<style type="text/css">
    #filters tr td, #filters tr th {
        padding: 1px !important;
    }
    #filters input {
        margin: 0px !important;
    }
</style>
{#/block#}
{#block name="body"#}
{#include file="display-components/diffexpr.tpl" instance_name="diffexpr"#}
{#/block#}