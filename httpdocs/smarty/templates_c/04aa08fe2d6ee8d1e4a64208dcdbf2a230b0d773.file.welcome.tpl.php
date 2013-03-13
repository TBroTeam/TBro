<?php /* Smarty version Smarty-3.1.13, created on 2013-03-13 16:55:12
         compiled from "/home/s202139/git/httpdocs/smarty/templates/welcome.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17300283651409c3b02f598-98116107%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '04aa08fe2d6ee8d1e4a64208dcdbf2a230b0d773' => 
    array (
      0 => '/home/s202139/git/httpdocs/smarty/templates/welcome.tpl',
      1 => 1363188794,
      2 => 'file',
    ),
    '1bfb3dec557c7a9258f8cf6f645e611f160e265d' => 
    array (
      0 => '/home/s202139/git/httpdocs/smarty/templates/layout.tpl',
      1 => 1363190111,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17300283651409c3b02f598-98116107',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51409c3b0f28f8_15762558',
  'variables' => 
  array (
    'AppPath' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51409c3b0f28f8_15762558')) {function content_51409c3b0f28f8_15762558($_smarty_tpl) {?>
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
                console.log('initializing foundation');
                //$(document).foundation();
                console.log('initialized foundation');
                console.log($("#search_unigene"));
                $( "#search_unigene" ).autocomplete({
                    position: {
                        my: "right top", at: "right bottom"
                    },
                    source: function( request, response ) {
                        $.ajax({
                            url: "../service/list/unigenes",
                            dataType: "json",
                            data: {
                                query: request.term
                            },
                            success: function( data ) {
                                response( data.results );
                            }
                        });
                    },
                    minLength: 2,
                    select: function( event, ui ) {
                        window.location.href = 'unigene-details/'+ui.item.value;
                    }
                });
                
                console.log($("#search_unigene"));
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
                <!-- Left Nav Section -->
                <ul class="right">
                    <li class="divider"></li>
                    <li><a>search for unigene:</a></li>
                    <li><input type="text" id="search_unigene" data-tooltip class="has-tip" title="try for 1.01_comp231081_c0 or 1.01_comp214244_c0"/></li>
                    <li>&nbsp;</li> 
                    <li class="divider"></li>
                </ul>
            </section>
        </nav>

        
<div class="row">
    <div class="large-12 columns">
        <h2>Welcome to Foundation</h2>
        <p>This is version 4.0.5.</p>
        <hr />
    </div>
</div>

<div class="row">
    <div class="large-8 columns">
        <h3>The Grid</h3>

        <!-- Grid Example -->
        <div class="row">
            <div class="large-12 columns">
                <div class="panel">
                    <p>This is a twelve column section in a row. Each of these includes a div.panel element so you can see where the columns are - it's not required at all for the grid.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="large-6 columns">
                <div class="panel">
                    <p>Six columns</p>
                </div>
            </div>
            <div class="large-6 columns">
                <div class="panel">
                    <p>Six columns</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="large-4 columns">
                <div class="panel">
                    <p>Four columns</p>
                </div>
            </div>
            <div class="large-4 columns">
                <div class="panel">
                    <p>Four columns</p>
                </div>
            </div>
            <div class="large-4 columns">
                <div class="panel">
                    <p>Four columns</p>
                </div>
            </div>
        </div>

        <h3>Buttons</h3>

        <div class="row">
            <div class="large-6 columns">
                <p><a href="#" class="small button">Small Button</a></p>
                <p><a href="#" class="button">Medium Button</a></p>
                <p><a href="#" class="large button">Large Button</a></p>
            </div>
            <div class="large-6 columns">
                <p><a href="#" class="small alert button">Small Alert Button</a></p>
                <p><a href="#" class="success button">Medium Success Button</a></p>
                <p><a href="#" class="large secondary button">Large Secondary Button</a></p>
            </div>
        </div>
    </div>

    <div class="large-4 columns">
        <h4>Getting Started</h4>
        <p>We're stoked you want to try Foundation! To get going, this file (index.html) includes some basic styles you can modify, play around with, or totally destroy to get going.</p>

        <h4>Other Resources</h4>
        <p>Once you've exhausted the fun in this document, you should check out:</p>
        <ul class="disc">
            <li><a href="http://foundation.zurb.com/docs">Foundation Documentation</a><br />Everything you need to know about using the framework.</li>
            <li><a href="http://github.com/zurb/foundation">Foundation on Github</a><br />Latest code, issue reports, feature requests and more.</li>
            <li><a href="http://twitter.com/foundationzurb">@foundationzurb</a><br />Ping us on Twitter if you have questions. If you build something with this we'd love to see it (and send you a totally boss sticker).</li>
        </ul>
    </div>
</div>

    </body>
</html><?php }} ?>