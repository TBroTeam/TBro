<?php /* Smarty version Smarty-3.1.13, created on 2013-03-14 15:02:02
         compiled from "/home/s202139/git/httpdocs/smarty/templates/display-isoform.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5782586735141cf1549bd41-83030641%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f67825a83c78cb5f537a9898dfeae2186b19e5fc' => 
    array (
      0 => '/home/s202139/git/httpdocs/smarty/templates/display-isoform.tpl',
      1 => 1363269721,
      2 => 'file',
    ),
    '1bfb3dec557c7a9258f8cf6f645e611f160e265d' => 
    array (
      0 => '/home/s202139/git/httpdocs/smarty/templates/layout.tpl',
      1 => 1363268670,
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
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
        <link type="text/css" href="http://code.jquery.com/ui/1.10.1/themes/base/minified/jquery-ui.min.css" rel="Stylesheet" />    
        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/vendor/custom.modernizr.js"></script>
        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/foundation.min.js"></script>


        <script type="text/javascript">
            $(document).ready(function() {
                $(document).foundation();
                $( "#search_unigene" ).autocomplete({
                    position: {
                        my: "right top", at: "right bottom"
                    },
                    source: function( request, response ) {
                        $.ajax({
                            url: "<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/listing/unigenes",
                            dataType: "json",
                            data: {
                                query1: request.term
                            },
                            success: function( data ) {
                                response( data.results );
                            }
                        });
                    },
                    minLength: 2,
                    select: function( event, ui ) {
                        window.location.href = '<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/unigene-details/'+ui.item.value;
                    }
                });
            });
        </script>

        
<?php echo smarty_function_call_webservice(array('path'=>"details/isoform",'data'=>array("query1"=>$_smarty_tpl->tpl_vars['isoform_uniquename']->value),'assign'=>'data'),$_smarty_tpl);?>


<!--[if lt IE 9]><script type="text/javascript" src="http://canvasxpress.org/js/flashcanvas.js"></script><![endif]-->
<script type="text/javascript" src="http://canvasxpress.org/js/canvasXpress.min.js"></script>
<!-- use chrome frame if installed and user is using IE -->
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<script type="text/javascript">
    var isoform='<?php echo $_smarty_tpl->tpl_vars['data']->value['isoform']['uniquename'];?>
';
            
    $(document).ready(function() {
        $.ajax('<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/graphs/genome/isoform/'+isoform, {
            success: function(val){
                console.log(val);
                console.log(val.tracks);
                new CanvasXpress(
                "canvas-<?php echo $_smarty_tpl->tpl_vars['data']->value['isoform']['uniquename'];?>
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
            
    });
            
            
            
</script>


    </head>
    <body>

        <nav class="top-bar">
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

        
<div class="row">
    <div class="large-12 columns">
        <div class="panel">
            <h1><?php echo $_smarty_tpl->tpl_vars['data']->value['isoform']['uniquename'];?>
</h1>
            <h5>last modified: <?php echo $_smarty_tpl->tpl_vars['data']->value['isoform']['timelastmodified'];?>
</h5>
            <h5>corresponding unigene: <?php echo $_smarty_tpl->tpl_vars['data']->value['isoform']['unigene']['uniquename'];?>
</h5>
        </div>
    </div>
</div>
<div class="row">        
    <div class="large-12 columns">
        <div class="panel">
        <canvas id="canvas-<?php echo $_smarty_tpl->tpl_vars['data']->value['isoform']['uniquename'];?>
" width="910"></canvas>
           <div style="clear:both; height:1px; overflow:hidden">&nbsp;</div>
        </div>
    </div>
</div>
<div class="row">        
    <div class="large-12 columns">
        <div class="panel" style="word-wrap: break-word;">
            <h2>Sequence</h2>
            <p>
                <?php echo $_smarty_tpl->tpl_vars['data']->value['isoform']['residues'];?>

            </p>
        </div>
    </div>
</div>

<?php echo var_dump($_smarty_tpl->tpl_vars['data']->value);?>


    </body>
</html><?php }} ?>