<?php /* Smarty version Smarty-3.1.13, created on 2013-03-13 16:28:32
         compiled from "/home/s202139/git/httpdocs/smarty/templates/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:542614101514091bea8ee60-73512730%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '70ad1bbc77cbcbc40c07dec1a483d4ef07ddb398' => 
    array (
      0 => '/home/s202139/git/httpdocs/smarty/templates/index.tpl',
      1 => 1363188487,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '542614101514091bea8ee60-73512730',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_514091beaf4784_30735248',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_514091beaf4784_30735248')) {function content_514091beaf4784_30735248($_smarty_tpl) {?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width" />
        <title>Transcript Browser - dionaea muscipula</title>
        <link rel="stylesheet" href="css/normalize.css" />
        <link rel="stylesheet" href="css/foundation.css" />
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
        <link type="text/css" href="http://code.jquery.com/ui/1.10.1/themes/base/minified/jquery-ui.min.css" rel="Stylesheet" />    
        <script type="text/javascript" src="js/vendor/custom.modernizr.js"></script>
        <script type="text/javascript" src="js/foundation.min.js"></script>

        

        <script type="text/javascript">
             
            $(document).ready(function() {
                console.log('initializing foundation');
                //$(document).foundation();
                console.log('initialized foundation');
                console.log($("#search_unigene"));
                $( "#search_unigene" ).autocomplete({
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
                    <li><input type="text" id="search_unigene" /></li>
                    <li class="divider"></li>
                </ul>
            </section>
        </nav>

        <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['page']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>



    </body>
</html>
<?php }} ?>