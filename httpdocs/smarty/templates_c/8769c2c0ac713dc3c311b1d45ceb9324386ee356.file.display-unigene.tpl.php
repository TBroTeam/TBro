<?php /* Smarty version Smarty-3.1.13, created on 2013-03-14 11:21:41
         compiled from "/home/s202139/git/httpdocs/smarty/templates/display-unigene.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3222948515140a1c3e86c70-52544708%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8769c2c0ac713dc3c311b1d45ceb9324386ee356' => 
    array (
      0 => '/home/s202139/git/httpdocs/smarty/templates/display-unigene.tpl',
      1 => 1363194122,
      2 => 'file',
    ),
    '1bfb3dec557c7a9258f8cf6f645e611f160e265d' => 
    array (
      0 => '/home/s202139/git/httpdocs/smarty/templates/layout.tpl',
      1 => 1363255887,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3222948515140a1c3e86c70-52544708',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5140a1c4030793_66894477',
  'variables' => 
  array (
    'AppPath' => 0,
    'ServicePath' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5140a1c4030793_66894477')) {function content_5140a1c4030793_66894477($_smarty_tpl) {?>
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
        
<!--[if lt IE 9]><script type="text/javascript" src="http://canvasxpress.org/js/flashcanvas.js"></script><![endif]-->
<script type="text/javascript" src="http://canvasxpress.org/js/canvasXpress.min.js"></script>
<<?php ?>?php /* use chrome frame if installed and user is using IE */ ?<?php ?>>
<meta http-equiv="X-UA-Compatible" content="chrome=1">


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
/list/unigenes",
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
        <h1 class="docs header"><a href="http://foundation.zurb.com/docs/">Foundation 4 Documentation</a></h1>
        <h6 class="docs subheader"><a href="http://foundation.zurb.com/old-docs/f3">Want F3 Docs?</a></h6>
        <hr>
    </div>
</div>

<div class="row">
    <div class="large-12 columns">
        <div class="section-container tabs" data-section>
            <section class="section">
                <p class="title"><a href="#">Section 1</a></p>
                <div class="content">
                    <p>Content of section 1.</p>
                </div>
            </section>
            <section class="section">
                <p class="title"><a href="#">Section 2</a></p>
                <div class="content">
                    <p>Content of section 2.</p>
                </div>
            </section>
        </div>

        &nbsp;asd
    </div>
</div>

    </body>
</html><?php }} ?>