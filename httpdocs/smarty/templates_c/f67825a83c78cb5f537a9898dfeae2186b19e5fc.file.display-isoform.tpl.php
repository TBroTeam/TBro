<?php /* Smarty version Smarty-3.1.13, created on 2013-03-20 16:58:11
         compiled from "/home/s202139/git/httpdocs/smarty/templates/display-isoform.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5782586735141cf1549bd41-83030641%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f67825a83c78cb5f537a9898dfeae2186b19e5fc' => 
    array (
      0 => '/home/s202139/git/httpdocs/smarty/templates/display-isoform.tpl',
      1 => 1363795089,
      2 => 'file',
    ),
    '1bfb3dec557c7a9258f8cf6f645e611f160e265d' => 
    array (
      0 => '/home/s202139/git/httpdocs/smarty/templates/layout.tpl',
      1 => 1363700145,
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
    'kickoff_cart' => 0,
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
                $("#cart-group-all").accordion({
                    collapsible: true,
                    heightStyle: "content"
                });
                <?php echo smarty_function_call_webservice(array('path'=>"cart/sync",'data'=>array(),'assign'=>'kickoff_cart'),$_smarty_tpl);?>


                cart.rebuildDOM(<?php echo json_encode($_smarty_tpl->tpl_vars['kickoff_cart']->value['cart']);?>
);
                setInterval(cart.checkRegularly, 5000); //sync over tabs if neccessary
            });</script>

        <script type="text/javascript">
            function buildTestCart() {
                cart.resetCart({sync: true});
                cart.addGroup();
                cart.addItemToAll({uniquename: '1.01_comp231081_c0_seq1'});
                cart.addItemToAll({uniquename: '1.01_comp231081_c0_seq1'});
                cart.addItemToAll({uniquename: '1.01_comp231123_c0_seq1'});
                cart.addItemToAll({uniquename: '1.01_comp2381_c0_seq1'});
                cart.addGroup();
                cart.renameGroup('group 1', 'myGroup!');
                cart.addItemToGroup({uniquename: '1.01_comp2381_c0_seq1'}, 'myGroup!');
                cart.addItemToGroup({uniquename: '1.01_comp231123_c0_seq1'}, 'myGroup!');
                cart.removeItemFromAll({uniquename: '1.01_comp2381_c0_seq1'});
            }

            $(document).ready(function() {
                //buildTestCart();
            });
        </script>
        <style>
            .ui-accordion .ui-accordion-header {
                margin-bottom:0px;
            }
            .ui-accordion .ui-accordion-content {
                padding: 0.5em 1em;
            }
            .beingDragged {
                list-style: none;
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
                        <li><input type="text" id="search_unigene" data-tooltip class="has-tip" title="try 1.01_comp231081_c0 or 1.01_comp214244_c0"/></li>
                        <li>&nbsp;</li> 
                    </ul>
                </section>
            </nav>
        </div>
        <div class="row">
            <div class="large-9 columns">
                
<div class="row">
    <div class="large-12 columns panel">
        <ul class="inline-list">
            <li>Quick Navigation:</li>
            <li><a href="#description">Isoform Description</a></li>
            <?php if (isset($_smarty_tpl->tpl_vars['data']->value['isoform']['repeatmasker'])&&count($_smarty_tpl->tpl_vars['data']->value['isoform']['repeatmasker'])>0){?>
                <li><a href="#repeatmasker">Repeatmasker Annotations</a></li>
            <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['data']->value['isoform']['predpeps'])&&count($_smarty_tpl->tpl_vars['data']->value['isoform']['predpeps'])>0){?>
                <li><a href="#predpep">Predicted Peptides</a></li>
            <?php }?>
        </ul>
    </div>
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

    </div>
</div>

<?php if (isset($_smarty_tpl->tpl_vars['data']->value['isoform']['blast2go'])&&count($_smarty_tpl->tpl_vars['data']->value['isoform']['blast2go'])>0){?>
    <div class="row" id="blast2go">
        <div class="large-12 columns">
            <h2>Blast2Go Annotations:</h2>

            <div class="row">
                <div class="large-12 columns panel">

                    <h4>
                        <?php  $_smarty_tpl->tpl_vars['blast2go'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['blast2go']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['isoform']['blast2go']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['blast2go']->key => $_smarty_tpl->tpl_vars['blast2go']->value){
$_smarty_tpl->tpl_vars['blast2go']->_loop = true;
?>
                            <?php echo $_smarty_tpl->tpl_vars['blast2go']->value['value'];?>

                        <?php } ?>
                </h4>

                <?php if ((isset($_smarty_tpl->tpl_vars['data']->value['isoform']['dbxref'])&&count($_smarty_tpl->tpl_vars['data']->value['isoform']['dbxref'])>0)){?>
                    <table style="width:100%">
                        <tbody>
                            <?php  $_smarty_tpl->tpl_vars['dbxref'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['dbxref']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['isoform']['dbxref']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['dbxref']->key => $_smarty_tpl->tpl_vars['dbxref']->value){
$_smarty_tpl->tpl_vars['dbxref']->_loop = true;
?>
                                <tr><td><?php echo smarty_function_dbxreflink(array('dbxref'=>$_smarty_tpl->tpl_vars['dbxref']->value),$_smarty_tpl);?>
<br/></td></tr>
                                    <?php } ?>
                        </tbody>
                    </table>
                <?php }?>
            </div>
        </div>
    </div>
</div>

<div class="row large-12 columns"><a href="#top" class="button secondary right">back to top</a></div>
<?php }?>
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
                        <div class=" section-container tabs" data-section>

                            <?php  $_smarty_tpl->tpl_vars['predpep'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['predpep']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['isoform']['predpeps']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['predpep']->key => $_smarty_tpl->tpl_vars['predpep']->value){
$_smarty_tpl->tpl_vars['predpep']->_loop = true;
?>
                                <section class="section">
                                    <p class="title"><a href="#"><?php echo $_smarty_tpl->tpl_vars['predpep']->value['uniquename'];?>
</a></p>
                                    <div class="content">

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
                                                                    <td><?php echo smarty_function_dbxreflink(array('dbxref'=>array('dbname'=>$_smarty_tpl->tpl_vars['interpro']->value['program'],'accession'=>$_smarty_tpl->tpl_vars['interpro']->value['analysis_match_id'],'description'=>$_smarty_tpl->tpl_vars['interpro']->value['analysis_match_description'],'dbversion'=>$_smarty_tpl->tpl_vars['interpro']->value['programversion'])),$_smarty_tpl);?>
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
                                    <div class="row">&nbsp;</div>
                                </section>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row large-12 columns"><a href="#top" class="button secondary right">back to top</a></div>
    <?php }?>
    
            </div>
            <div class="large-3 columns" >
                <div class="row large-3 columns" style="position:fixed;top:45px;bottom:0;overflow-x:hidden;overflow-y:auto;">

                    <div class=" panel large-12 columns">
                        <h4>Cart</h4>
                        <div id="cart-group-all" class='ui_accordion ui_collapsible'>
                            <div class="large-12 columns"><div class="left">all</div><div class="right"><img src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/23.png"/></div></div>
                            <ul class="large-12 columns">
                            </ul>
                        </div>
                        <div>
                            <a id="cart-add-group" class="button secondary right">add new cart</a>
                            <div style="clear:both">&nbsp;</div>
                        </div>
                        <div id="cart-groups">

                        </div>
                    </div>
                    <div style="display: none">
                        <div id="cart-group-dummy"> 
                            <div class='cart-group' data-group="#groupname#">
                                <div class="large-12 columns">
                                    <div class="groupname left">#groupname#</div>
                                    <div class="right">
                                        <img class="cart-button-rename" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/39.png"/>
                                        <img class="cart-button-delete" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/51.png"/>
                                        <img class="cart-button-execute" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/23.png"/>
                                    </div>
                                </div>
                                <ul class="cart-target large-12 columns">
                                    <li class="placeholder">drag your items here</li>
                                </ul>
                            </div>
                        </div>

                        <ul id="cart-item-dummy"> 
                            <li data-uniquename="#uniquename#" style="clear:both" class="large-12 cart-item">
                                <div class="left">#uniquename#</div>
                                <div class="right">
                                    <img class="cart-button-delete" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/51.png"/>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div>&nbsp;</div>
            </div>
        </div>
    </body>
</html>

<?php }} ?>