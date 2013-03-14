<?php /* Smarty version Smarty-3.1.13, created on 2013-03-14 15:03:46
         compiled from "/home/s202139/git/httpdocs/smarty/templates/welcome.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17300283651409c3b02f598-98116107%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '04aa08fe2d6ee8d1e4a64208dcdbf2a230b0d773' => 
    array (
      0 => '/home/s202139/git/httpdocs/smarty/templates/welcome.tpl',
      1 => 1363269822,
      2 => 'file',
    ),
    '1bfb3dec557c7a9258f8cf6f645e611f160e265d' => 
    array (
      0 => '/home/s202139/git/httpdocs/smarty/templates/layout.tpl',
      1 => 1363268670,
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
    'ServicePath' => 0,
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
            <h2>Welcome to the dionaea muscipula transcript browser</h2>
        </div>
    </div>
</div>
<div class="row">
    <div class="large-12 columns">
        <div class="panel">
            <p>Try searching for 1.01_comp231081_c0 or 1.01_comp214244_c0.</p>
        </div>
    </div>
</div>

    </body>
</html><?php }} ?>