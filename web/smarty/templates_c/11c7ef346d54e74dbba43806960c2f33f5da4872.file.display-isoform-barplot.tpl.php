<?php /* Smarty version Smarty-3.1.13, created on 2013-04-09 14:21:20
         compiled from "/home/s202139/git/httpdocs/smarty/templates/display-isoform-barplot.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16072439935163fe366ca516-06682459%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '11c7ef346d54e74dbba43806960c2f33f5da4872' => 
    array (
      0 => '/home/s202139/git/httpdocs/smarty/templates/display-isoform-barplot.tpl',
      1 => 1365510070,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16072439935163fe366ca516-06682459',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5163fe3672d958_50789545',
  'variables' => 
  array (
    'ServicePath' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5163fe3672d958_50789545')) {function content_5163fe3672d958_50789545($_smarty_tpl) {?><div class="row">
    <div class="large-12 columns">
        <h2>Barplot</h2>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var select_assay = $('#isoform-barplot-filter-assay');
        var select_analysis = $('#isoform-barplot-filter-analysis');
        var select_tissue = $('#isoform-barplot-filter-tissue');
        var filterdata;

        select_assay.click(function() {
            var assay = $(this).val();
            var last_selected = $(this).attr('data-last-selected');
            if (assay === last_selected)
                return;
            select_analysis.empty();

            $.each(filterdata.analysis[assay], function() {
                var opt = $("<option/>").val(this.id).text(this.name).data('metadata', this);
                opt.appendTo(select_analysis);
            });

            $(this).attr('data-last-selected', assay);
            
            select_analysis.find('option').first().attr('selected','selected');
            select_analysis.click();
        });

        select_analysis.click(function() {
            var analysis = $(this).val();
            var last_selected = $(this).attr('data-last-selected');
            if (analysis === last_selected)
                return;
            select_tissue.empty();

            $.each(filterdata.biomaterial[analysis][select_assay.val()], function() {
                var opt = $("<option/>").val(this.name).text(this.name).data('metadata', this);
                opt.appendTo(select_tissue);
            });

            $(this).attr('data-last-selected', analysis);
        });

        $.ajax('<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/listing/isoform/filters/' + isoform, {
            success: function(data) {
                filterdata = data;
                select_assay.empty();
                $.each(filterdata.assay, function() {
                    var opt = $("<option/>").val(this.name).text(this.name).data('metadata', this);
                    opt.appendTo(select_assay);
                });
                select_assay.find('option').first().attr('selected','selected');
                select_assay.click();
            }
        });
    });
</script>
<style>

</style>
<div class="row">
    <div class="large-12 columns panel">

        <div class="row">
            <div class="large-12 columns">
                <h4>Filters</h4>
            </div>
        </div>

        <div class="row">
            <div class="large-3 columns">
                <h5>Assay</h5>
            </div>
            <div class="large-3 columns">
                <h5>Analysis</h5>
            </div>
            <div class="large-3 columns">
                <h5>Tissues</h5>
            </div>
            <div class="large-3 columns">
            </div>
        </div>
        <form>
            <div class="row">
                <div class="large-3 columns">
                    <select id="isoform-barplot-filter-assay" size="6" ></select>
                </div>
                <div class="large-3 columns">
                    <select id="isoform-barplot-filter-analysis" size="6" ></select>
                </div>
                <div class="large-3 columns">
                    <select id="isoform-barplot-filter-tissue" size="6" multiple="multiple"></select>
                </div>
                <div class="large-3 columns">
                    <input type="submit" class="button" />
                </div>
            </div>
        </form>
    </div>
</div>
</style>
<div class="row">
    <div class="large-12 columns panel">
        <div class="row">
            <div class="large-12 columns">
                <canvas id="isoform-barplot"></canvas>
            </div>
        </div>
    </div>
</div><?php }} ?>