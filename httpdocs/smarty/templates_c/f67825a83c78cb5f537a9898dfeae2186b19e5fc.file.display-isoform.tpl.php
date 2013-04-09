<?php /* Smarty version Smarty-3.1.13, created on 2013-04-09 15:15:28
         compiled from "/home/s202139/git/httpdocs/smarty/templates/display-isoform.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5782586735141cf1549bd41-83030641%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f67825a83c78cb5f537a9898dfeae2186b19e5fc' => 
    array (
      0 => '/home/s202139/git/httpdocs/smarty/templates/display-isoform.tpl',
      1 => 1365513304,
      2 => 'file',
    ),
    '1bfb3dec557c7a9258f8cf6f645e611f160e265d' => 
    array (
      0 => '/home/s202139/git/httpdocs/smarty/templates/layout.tpl',
      1 => 1365421046,
      2 => 'file',
    ),
    '11c7ef346d54e74dbba43806960c2f33f5da4872' => 
    array (
      0 => '/home/s202139/git/httpdocs/smarty/templates/display-isoform-barplot.tpl',
      1 => 1365513110,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5782586735141cf1549bd41-83030641',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5141cf155eb379_32188531',
  'variables' => 
  array (
    'AppPath' => 0,
    'ServicePath' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5141cf155eb379_32188531')) {function content_5141cf155eb379_32188531($_smarty_tpl) {?><?php if (!is_callable('smarty_function_call_webservice')) include '/home/s202139/git/httpdocs/client/../smarty/plugins/function.call_webservice.php';
if (!is_callable('smarty_modifier_clean_id')) include '/home/s202139/git/httpdocs/client/../smarty/plugins/modifier.clean_id.php';
if (!is_callable('smarty_function_dbxreflink')) include '/home/s202139/git/httpdocs/client/../smarty/plugins/function.dbxreflink.php';
if (!is_callable('smarty_function_interprolink')) include '/home/s202139/git/httpdocs/client/../smarty/plugins/function.interprolink.php';
?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width" />
        <title>Transcript Browser - dionaea muscipula</title>

        <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/css/normalize.css" />
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/css/foundation.css" />
        <!--link type="text/css" href="http://code.jquery.com/ui/1.10.1/themes/base/minified/jquery-ui.min.css" rel="Stylesheet" /-->    
        <link type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/css/custom-theme/jquery-ui-1.10.2.custom.css" rel="Stylesheet" />    

        <!--script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script-->
        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/jquery-1.9.1.min.js"></script>
        <!--script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script-->
        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/jquery-ui-1.10.2.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/vendor/custom.modernizr.js"></script>
        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/foundation.min.js"></script>        
        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/jquery.webStorage.min.js"></script>        
        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/cart.js"></script>        


        <script type="text/javascript">
            $(document).ready(function() {
                $(document).foundation();
                $("#search_unigene").autocomplete({
                    position: {
                        my: "right top", at: "right bottom"
                    },
                    source: function(request, response) {
                        $.ajax({
                            url: "<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/listing/unigenes/" + request.term,
                            dataType: "json",
                            success: function(data) {
                                response(data.results);
                            }
                        });
                    },
                    minLength: 2,
                    select: function(event, ui) {
                        window.location.href = '<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/unigene-details/' + ui.item.value;
                    }
                });
                $('#search_unigene').keydown(function(event) {
                    //Enter
                    if (event.which == 13) {
                        event.preventDefault();
                        $.ajax({
                            url: "<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/listing/unigenes/" + $(this).val(),
                            dataType: "json",
                            success: function(data) {
                                if (data.results.length == 1) {
                                    window.location.href = '<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/unigene-details/' + data.results[0];
                                }
                            }
                        });
                    }
                });

            });</script>
        <style>
            .ui-tooltip-content table{
                margin-bottom: 0px;
            }
        </style>

        
<?php echo smarty_function_call_webservice(array('path'=>"details/isoform",'data'=>array("query1"=>$_smarty_tpl->tpl_vars['isoform_uniquename']->value),'assign'=>'data'),$_smarty_tpl);?>


<!--[if lt IE 9]><script type="text/javascript" src="http://canvasxpress.org/js/flashcanvas.js"></script><![endif]-->
<script type="text/javascript" src="http://canvasxpress.org/js/canvasXpress.min.js"></script>
<!-- use chrome frame if installed and user is using IE -->
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<script type="text/javascript">
    var isoform = '<?php echo $_smarty_tpl->tpl_vars['data']->value['isoform']['uniquename'];?>
';

    $(document).ready(function() {
        $('.tabs').tabs();

        $.ajax('<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/graphs/genome/isoform/' + isoform, {
            success: function(val) {
                canvas = $('#canvas_<?php echo smarty_modifier_clean_id($_smarty_tpl->tpl_vars['data']->value['isoform']['uniquename']);?>
');
                canvas.attr('width', canvas.parent().width() - 8);
                if (val.tracks.length == 0)
                    return;
                new CanvasXpress(
                "canvas_<?php echo smarty_modifier_clean_id($_smarty_tpl->tpl_vars['data']->value['isoform']['uniquename']);?>
",
                {
                    "tracks": val.tracks
                },
                {
                    graphType: 'Genome',
                    useFlashIE: true,
                    backgroundType: 'gradient',
                    backgroundGradient1Color: 'rgb(0,183,217)',
                    backgroundGradient2Color: 'rgb(4,112,174)',
                    oddColor: 'rgb(220,220,220)',
                    evenColor: 'rgb(250,250,250)',
                    missingDataColor: 'rgb(220,220,220)',
                    setMin: val.min,
                    setMax: val.max
                }
            );
            }
        });
        $('form.blast').submit(function(event) {
            queryInput = $(this).find('.query');
            query = $(queryInput.data('ref')).html();
            queryInput.val(query);
        });


        $('.contains-dbxref').tooltip({
            items: "span.dbxref-tooltip",
            open: function(event, ui) {
                ui.tooltip.css("max-width", "600px");
            },
            content: function() {
                var element = $(this);
                var newElStr = $('#dbxref-tooltip').html();
                newElStr = newElStr.replace(/#dbname#/g, element.attr('data-dbname'));
                newElStr = newElStr.replace(/#accession#/g, element.attr('data-accession'));
                newElStr = newElStr.replace(/#name#/g, element.attr('data-name'));
                newElStr = newElStr.replace(/#definition#/g, element.attr('data-definition'));
                newElStr = newElStr.replace(/#dbversion#/g, element.attr('data-dbversion'));
                return newElStr;
            }
        });
    });



</script>


    </head>
    <body>
        <div class="fixed">
            <nav class="top-bar" id="top">
                <ul class="title-area">
                    <li class="name">
                        <h1><a>Transcript Browser: dionaea muscipula</a></h1>
                    </li>
                </ul>
                <section class="top-bar-section">
                    <ul class="right">
                        <li class="divider"></li>
                        <li><a>search for unigene:</a></li>
                        <li><input type="text" id="search_unigene"/></li>
                        <li>&nbsp;</li> 
                    </ul>
                </section>
            </nav>
        </div>
        <div class="row">
            <div class="large-9 columns">
                
<div class="contains-dbxref">
    <div id="dbxref-tooltip" style="display:none">
        <table>
            <tr><td>DbxRef</td><td>#dbname#:#accession#</td></tr>
            <tr><td>Name</td><td>#name#</td></tr>
            <tr><td>Definition</td><td>#definition#</td></tr>
            <tr><td>DB-Version</td><td>#dbversion#</td></tr>
        </table>
    </div>
    <div class="row">
        <div class="large-12 columns panel" id="description">
            <div class="row">
                <div class="large-12 columns">
                    <h1 class="left"><?php echo $_smarty_tpl->tpl_vars['data']->value['isoform']['uniquename'];?>
</h1>
                    <div class="right"><span class="button" onclick="cart.addItemToAll({uniquename: '<?php echo $_smarty_tpl->tpl_vars['data']->value['isoform']['uniquename'];?>
'});"> add to cart -> </span></div>
                </div>
            </div>
            <h5>last modified: <?php echo $_smarty_tpl->tpl_vars['data']->value['isoform']['timelastmodified'];?>
</h5>
            <h5>corresponding unigene: <a href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/unigene-details/<?php echo $_smarty_tpl->tpl_vars['data']->value['isoform']['unigene']['uniquename'];?>
"><?php echo $_smarty_tpl->tpl_vars['data']->value['isoform']['unigene']['uniquename'];?>
</a></h5>

            <div class="row">
                <div class="large-12 columns">
                    <canvas id="canvas_<?php echo smarty_modifier_clean_id($_smarty_tpl->tpl_vars['data']->value['isoform']['uniquename']);?>
" width="600"></canvas>
                    <div style="clear:both; height:1px; overflow:hidden">&nbsp;</div>
                </div>
            </div>

            <div class="row">
                <div class="large-6 columns">
                    <h4>Sequence</h4>
                </div>
                <div class="large-6 columns" style="text-align: right">
                    <form class="blast" action="http://blast.ncbi.nlm.nih.gov/Blast.cgi" method="POST" target="_blank" style="display:inline">
                        <input type="hidden" name='CMD' value='Web' />
                        <input type="hidden" name='PROGRAM' value='blastx' />
                        <input type="hidden" name='BLAST_PROGRAMS' value='blastx' />
                        <input type="hidden" name='PAGE_TYPE' value='BlastSearch' />
                        <input type="hidden" name='SHOW_DEFAULTS' value='on' />
                        <input type="hidden" name='LINK' value='blasthome' />
                        <input type="hidden" class="query" data-ref="#sequence-<?php echo smarty_modifier_clean_id($_smarty_tpl->tpl_vars['data']->value['isoform']['uniquename']);?>
" name="QUERY" value="" />
                        <input type="submit" class="small button" value="send to blastx">
                    </form>

                    <form class="blast" action="http://blast.ncbi.nlm.nih.gov/Blast.cgi" method="POST" target="_blank" style="display:inline">
                        <input type="hidden" name='CMD' value='Web' />
                        <input type="hidden" name='PROGRAM' value='blastn' />
                        <input type="hidden" name='BLAST_PROGRAMS' value='megaBlast' />
                        <input type="hidden" name='PAGE_TYPE' value='BlastSearch' />
                        <input type="hidden" name='SHOW_DEFAULTS' value='on' />
                        <input type="hidden" name='LINK' value='blasthome' />
                        <input type="hidden" class="query" data-ref="#sequence-<?php echo smarty_modifier_clean_id($_smarty_tpl->tpl_vars['data']->value['isoform']['uniquename']);?>
" name="QUERY" value="" />
                        <input type="submit" class="small button" value="send to blastn">
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <textarea style="height:100px;" id="sequence-<?php echo smarty_modifier_clean_id($_smarty_tpl->tpl_vars['data']->value['isoform']['uniquename']);?>
"><?php echo $_smarty_tpl->tpl_vars['data']->value['isoform']['residues'];?>
</textarea>
                </div>
            </div>

            <div class="row">
                <div class="large-12 columns">
                    <?php if (isset($_smarty_tpl->tpl_vars['data']->value['isoform']['blast2go'])){?>
                        <h4>possible description:</h4>
                        <?php  $_smarty_tpl->tpl_vars['blast2go'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['blast2go']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['isoform']['blast2go']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['blast2go']->key => $_smarty_tpl->tpl_vars['blast2go']->value){
$_smarty_tpl->tpl_vars['blast2go']->_loop = true;
?>
                            <h5> <?php echo $_smarty_tpl->tpl_vars['blast2go']->value['value'];?>
</h5>
                        <?php } ?>
                    <?php }?>


                    <?php if ((isset($_smarty_tpl->tpl_vars['data']->value['isoform']['dbxref']))){?>
                        <?php if ((isset($_smarty_tpl->tpl_vars['data']->value['isoform']['dbxref']['GO']))){?>
                            <h4>Gene Ontology</h4>
                            <?php  $_smarty_tpl->tpl_vars['dbxarr'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['dbxarr']->_loop = false;
 $_smarty_tpl->tpl_vars['namespace'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['data']->value['isoform']['dbxref']['GO']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['dbxarr']->key => $_smarty_tpl->tpl_vars['dbxarr']->value){
$_smarty_tpl->tpl_vars['dbxarr']->_loop = true;
 $_smarty_tpl->tpl_vars['namespace']->value = $_smarty_tpl->tpl_vars['dbxarr']->key;
?>
                                <h5><?php echo $_smarty_tpl->tpl_vars['namespace']->value;?>
</h5>
                                <table style="width:100%">
                                    <tbody>
                                        <?php  $_smarty_tpl->tpl_vars['dbxref'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['dbxref']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['dbxarr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['dbxref']->key => $_smarty_tpl->tpl_vars['dbxref']->value){
$_smarty_tpl->tpl_vars['dbxref']->_loop = true;
?>
                                            <tr><td><?php echo smarty_function_dbxreflink(array('dbxref'=>$_smarty_tpl->tpl_vars['dbxref']->value),$_smarty_tpl);?>
</td></tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            <?php } ?>
                        <?php }?>

                        <?php if ((isset($_smarty_tpl->tpl_vars['data']->value['isoform']['dbxref']['EC']))){?>
                            <h4>Enzyme classifications</h4>
                            <?php  $_smarty_tpl->tpl_vars['dbxarr'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['dbxarr']->_loop = false;
 $_smarty_tpl->tpl_vars['namespace'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['data']->value['isoform']['dbxref']['EC']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['dbxarr']->key => $_smarty_tpl->tpl_vars['dbxarr']->value){
$_smarty_tpl->tpl_vars['dbxarr']->_loop = true;
 $_smarty_tpl->tpl_vars['namespace']->value = $_smarty_tpl->tpl_vars['dbxarr']->key;
?>
                                <table style="width:100%">
                                    <tbody>
                                        <?php  $_smarty_tpl->tpl_vars['dbxref'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['dbxref']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['dbxarr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['dbxref']->key => $_smarty_tpl->tpl_vars['dbxref']->value){
$_smarty_tpl->tpl_vars['dbxref']->_loop = true;
?>
                                            <tr><td><?php echo smarty_function_dbxreflink(array('dbxref'=>$_smarty_tpl->tpl_vars['dbxref']->value),$_smarty_tpl);?>
</td></tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            <?php } ?>

                        <?php }?>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
    <div class="row large-12 columns"><a href="#top" class="button secondary right">back to top</a></div>


    <?php if (isset($_smarty_tpl->tpl_vars['data']->value['isoform']['repeatmasker'])&&count($_smarty_tpl->tpl_vars['data']->value['isoform']['repeatmasker'])>0){?>
        <div class="row" id="repeatmasker">
            <div class="large-12 columns">
                <h2>Repeatmasker Annotations:</h2>

                <div class="row">
                    <div class="large-12 columns panel">
                        <table style="width:100%">
                            <thead>
                                <tr><td>name</td><td>class</td><td>family</td><td>min</td><td>max</td><td>strand</td><td>length</td></tr>
                            </thead>
                            <tbody>
                                <?php  $_smarty_tpl->tpl_vars['repeatmasker'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['repeatmasker']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['isoform']['repeatmasker']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['repeatmasker']->key => $_smarty_tpl->tpl_vars['repeatmasker']->value){
$_smarty_tpl->tpl_vars['repeatmasker']->_loop = true;
?>
                                    <tr>
                                        <td><?php echo $_smarty_tpl->tpl_vars['repeatmasker']->value['repeat_name'];?>
</td>
                                        <td><?php echo $_smarty_tpl->tpl_vars['repeatmasker']->value['repeat_class'];?>
</td>
                                        <td><?php echo $_smarty_tpl->tpl_vars['repeatmasker']->value['repeat_family'];?>
</td>
                                        <td><?php echo $_smarty_tpl->tpl_vars['repeatmasker']->value['fmin'];?>
</td>
                                        <td><?php echo $_smarty_tpl->tpl_vars['repeatmasker']->value['fmax'];?>
</td>
                                        <td><?php if ($_smarty_tpl->tpl_vars['repeatmasker']->value['strand']>0){?>right<?php }else{ ?>left<?php }?></td>
                                        <td><?php echo $_smarty_tpl->tpl_vars['repeatmasker']->value['fmax']-$_smarty_tpl->tpl_vars['repeatmasker']->value['fmin']+1;?>
</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="row large-12 columns"><a href="#top" class="button secondary right">back to top</a></div>
    <?php }?>


    <?php if (isset($_smarty_tpl->tpl_vars['data']->value['isoform']['predpeps'])&&count($_smarty_tpl->tpl_vars['data']->value['isoform']['predpeps'])>0){?>
        <div class="row" id="predpep">
            <div class="large-12 columns">
                <h2>Predicted Peptides:</h2>


                <div class="row">
                    <div class="large-12 columns panel">
                        <div class="tabs">
                            <ul>
                                <?php  $_smarty_tpl->tpl_vars['predpep'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['predpep']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['isoform']['predpeps']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['predpep']->key => $_smarty_tpl->tpl_vars['predpep']->value){
$_smarty_tpl->tpl_vars['predpep']->_loop = true;
?>
                                    <li><p><a href="#<?php echo smarty_modifier_clean_id($_smarty_tpl->tpl_vars['predpep']->value['uniquename']);?>
"><?php if ($_smarty_tpl->tpl_vars['predpep']->value['strand']>0){?><?php echo $_smarty_tpl->tpl_vars['predpep']->value['fmin'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['predpep']->value['fmax'];?>
<?php }?>-<?php if ($_smarty_tpl->tpl_vars['predpep']->value['strand']>0){?><?php echo $_smarty_tpl->tpl_vars['predpep']->value['fmax'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['predpep']->value['fmin'];?>
<?php }?></a></p></li>
                                <?php } ?>
                            </ul>

                            <?php  $_smarty_tpl->tpl_vars['predpep'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['predpep']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['isoform']['predpeps']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['predpep']->key => $_smarty_tpl->tpl_vars['predpep']->value){
$_smarty_tpl->tpl_vars['predpep']->_loop = true;
?>
                                <div id="<?php echo smarty_modifier_clean_id($_smarty_tpl->tpl_vars['predpep']->value['uniquename']);?>
">
                                    <div class="row">
                                        <div class="large-12 columns">
                                            <table style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <td>uniquename</td>
                                                        <td>min</td>
                                                        <td>max</td>
                                                        <td>strand</td>
                                                        <td>length</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><?php echo $_smarty_tpl->tpl_vars['predpep']->value['uniquename'];?>
</td>
                                                        <td><?php echo $_smarty_tpl->tpl_vars['predpep']->value['fmin'];?>
</td>
                                                        <td><?php echo $_smarty_tpl->tpl_vars['predpep']->value['fmax'];?>
</td>
                                                        <td><?php if ($_smarty_tpl->tpl_vars['predpep']->value['strand']>0){?>right<?php }else{ ?>left<?php }?></td>
                                                        <td><?php echo $_smarty_tpl->tpl_vars['predpep']->value['seqlen'];?>
</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="large-9 columns">
                                            <textarea style="height:100px;" id="sequence-<?php echo smarty_modifier_clean_id($_smarty_tpl->tpl_vars['predpep']->value['uniquename']);?>
"><?php echo $_smarty_tpl->tpl_vars['predpep']->value['residues'];?>
</textarea>
                                        </div>
                                        <div class="large-3 columns" style="text-align: right">
                                            <form class="blast" action="http://blast.ncbi.nlm.nih.gov/Blast.cgi" method="POST" target="_blank" style="display:inline">
                                                <input type="hidden" name='CMD' value='Web' />
                                                <input type="hidden" name='PROGRAM' value='blastp' />
                                                <input type="hidden" name='BLAST_PROGRAMS' value='blastp' />
                                                <input type="hidden" name='PAGE_TYPE' value='BlastSearch' />
                                                <input type="hidden" name='SHOW_DEFAULTS' value='on' />
                                                <input type="hidden" name='LINK' value='blasthome' />
                                                <input type="hidden" class="query" data-ref="#sequence-<?php echo smarty_modifier_clean_id($_smarty_tpl->tpl_vars['predpep']->value['uniquename']);?>
" name="QUERY" value="" />
                                                <input type="submit" class="small button"  value="send to blastp">
                                            </form>
                                            <form class="blast" action="http://blast.ncbi.nlm.nih.gov/Blast.cgi" method="POST" target="_blank" style="display:inline">
                                                <input type="hidden" name='CMD' value='Web' />
                                                <input type="hidden" name='PROGRAM' value='tblastn' />
                                                <input type="hidden" name='BLAST_PROGRAMS' value='tblastn' />
                                                <input type="hidden" name='PAGE_TYPE' value='BlastSearch' />
                                                <input type="hidden" name='SHOW_DEFAULTS' value='on' />
                                                <input type="hidden" name='LINK' value='blasthome' />
                                                <input type="hidden" class="query" data-ref="#sequence-<?php echo smarty_modifier_clean_id($_smarty_tpl->tpl_vars['predpep']->value['uniquename']);?>
" name="QUERY" value="" />
                                                <input type="submit" class="small button"  value="send to tblastn">
                                            </form>
                                        </div>
                                    </div>

                                    <?php if (isset($_smarty_tpl->tpl_vars['predpep']->value['interpro'])&&count($_smarty_tpl->tpl_vars['predpep']->value['interpro'])>0){?>
                                        <div class="row" id="interpro">
                                            <div class="large-12 columns">
                                                <h4>Interpro Annotations:</h4>

                                                <table style="width:100%">
                                                    <thead>
                                                        <tr><td>interpro id</td><td>fmin</td><td>fmax</td><td>evalue</td><td>database match</td><td>time executed</td><td>dbxref</td></tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php  $_smarty_tpl->tpl_vars['interpro'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['interpro']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['predpep']->value['interpro']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['interpro']->key => $_smarty_tpl->tpl_vars['interpro']->value){
$_smarty_tpl->tpl_vars['interpro']->_loop = true;
?>
                                                            <tr><td><?php echo smarty_function_interprolink(array('id'=>$_smarty_tpl->tpl_vars['interpro']->value['interpro_id']),$_smarty_tpl);?>
</td><td><?php echo $_smarty_tpl->tpl_vars['interpro']->value['fmin'];?>
</td><td><?php echo $_smarty_tpl->tpl_vars['interpro']->value['fmax'];?>
</td>
                                                                <td><?php echo $_smarty_tpl->tpl_vars['interpro']->value['evalue'];?>
</td>
                                                                <td><?php echo smarty_function_dbxreflink(array('dbxref'=>array('dbname'=>$_smarty_tpl->tpl_vars['interpro']->value['program'],'accession'=>$_smarty_tpl->tpl_vars['interpro']->value['analysis_match_id'],'name'=>'','definition'=>$_smarty_tpl->tpl_vars['interpro']->value['analysis_match_description'],'dbversion'=>$_smarty_tpl->tpl_vars['interpro']->value['programversion'])),$_smarty_tpl);?>
</td>
                                                                <td><?php echo $_smarty_tpl->tpl_vars['interpro']->value['timeexecuted'];?>
</td>
                                                                <td>
                                                                    <?php if (isset($_smarty_tpl->tpl_vars['interpro']->value['dbxref'])&&count($_smarty_tpl->tpl_vars['interpro']->value['dbxref'])>0){?>
                                                                        <ul style="list-style: none">
                                                                            <?php  $_smarty_tpl->tpl_vars['dbxref'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['dbxref']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['interpro']->value['dbxref']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['dbxref']->key => $_smarty_tpl->tpl_vars['dbxref']->value){
$_smarty_tpl->tpl_vars['dbxref']->_loop = true;
?>
                                                                                <li><?php echo smarty_function_dbxreflink(array('dbxref'=>$_smarty_tpl->tpl_vars['dbxref']->value),$_smarty_tpl);?>
 </li>
                                                                            <?php } ?>
                                                                        </ul>
                                                                    <?php }?>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <?php }?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    <?php }?>
</div>
<div class="row large-12 columns"><a href="#top" class="button secondary right">back to top</a></div>

<?php /*  Call merged included template "display-isoform-barplot.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("display-isoform-barplot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '5782586735141cf1549bd41-83030641');
content_51641471433ad7_59938332($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "display-isoform-barplot.tpl" */?>

            </div>
            <div class="large-3 columns" >
                <div class="row large-3 columns" style="position:fixed;top:45px;bottom:0;overflow-x:hidden;overflow-y:auto;">

                    <?php echo $_smarty_tpl->getSubTemplate ('cart.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

                </div>
                <div>&nbsp;</div>
            </div>
        </div>
    </body>
</html>

<?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2013-04-09 15:15:29
         compiled from "/home/s202139/git/httpdocs/smarty/templates/display-isoform-barplot.tpl" */ ?>
<?php if ($_valid && !is_callable('content_51641471433ad7_59938332')) {function content_51641471433ad7_59938332($_smarty_tpl) {?><div class="row">
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
        
        $('#isoform-barplot-filter-form').tooltip({
            items: "option",
            open: function(event, ui) {
                ui.tooltip.offset({top: event.pageY, left: event.pageX});
                ui.tooltip.css("max-width", "600px");
            },
            content: function() {
                var element = $(this);
                var tooltip = $("<table/>");
                $.each(element.data('metadata'),function(key, val){
                    $("<tr><td>"+key+"</td><td>"+(val!==null?val:'')+"</td></tr>").appendTo(tooltip);
                });
                tooltip.foundation();
                return tooltip;
            }
        });
    });
</script>
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
        <form id='isoform-barplot-filter-form'>
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
<div class="row">
    <div class="large-12 columns panel">
        <div class="row">
            <div class="large-12 columns">
                <canvas id="isoform-barplot"></canvas>
            </div>
        </div>
    </div>
</div><?php }} ?>