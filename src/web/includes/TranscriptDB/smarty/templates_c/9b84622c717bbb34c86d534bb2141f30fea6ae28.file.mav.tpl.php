<?php /* Smarty version Smarty-3.1.13, created on 2013-06-23 20:34:45
         compiled from "C:\Users\mail_000\Dropbox\uni\bio\s202139\web\smarty\templates\mav.tpl" */ ?>
<?php /*%%SmartyHeaderCode:890451c4de15b22593-43334669%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9b84622c717bbb34c86d534bb2141f30fea6ae28' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\mav.tpl',
      1 => 1372011677,
      2 => 'file',
    ),
    'c44393500e69763bf56453147eb3e23dada271cd' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\layout-with-cart.tpl',
      1 => 1372012386,
      2 => 'file',
    ),
    'c9e223e75317f40ea70fe3d34aff134ea2c81027' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\layout.tpl',
      1 => 1370963911,
      2 => 'file',
    ),
    'e195c048be3819a2567f8dd4f9a2eaa73337edc8' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\js\\mav-graphs.js',
      1 => 1372011537,
      2 => 'file',
    ),
    '2d16128ae5bb9f6acf538f3168e85fbb1fd60d2b' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\js\\diffexpr.js',
      1 => 1372011620,
      2 => 'file',
    ),
    '75625bc38f30f4e78eacff1eef4cdb5a4d516225' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\display-components\\diffexpr.tpl',
      1 => 1370435050,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '890451c4de15b22593-43334669',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51c4de15d83670_64671148',
  'variables' => 
  array (
    'AppPath' => 0,
    'organism' => 0,
    'release' => 0,
    'default_organism' => 0,
    'default_release' => 0,
    'ServicePath' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51c4de15d83670_64671148')) {function content_51c4de15d83670_64671148($_smarty_tpl) {?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <!--meta name="viewport" content="width=device-width" /-->
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
/js/underscore-min.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/TableTools.min.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/alphanum.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/feature/datatable-init.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/sprintf.min.js"></script>
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/css/jquery.dataTables_themeroller.css" />
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/css/TableTools.css" />

        <script type="text/javascript">
            var organism;
            var release;
            $(document).ready(function() {
                $(document).foundation();

                organism = $('#select_organism');
                release = $('#select_release');
                
            <?php if (isset($_smarty_tpl->tpl_vars['organism']->value)){?>
                    selected_organism_id = '<?php echo $_smarty_tpl->tpl_vars['organism']->value;?>
';    
                    selected_release = '<?php echo $_smarty_tpl->tpl_vars['release']->value;?>
';
            <?php }else{ ?>
                    selected_organism_id = $.webStorage.session().getItem('selected_organism_id');
                    if (selected_organism_id == null){
                        selected_organism_id = '<?php echo $_smarty_tpl->tpl_vars['default_organism']->value;?>
';
                    }
                    selected_release = $.webStorage.session().getItem('selected_release');
                    if (selected_release == null){
                        selected_release = '<?php echo $_smarty_tpl->tpl_vars['default_release']->value;?>
';
                    }
            <?php }?>
                
                
                    var rel_release = null;

                    $.ajax({
                        url: "<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/listing/organism_release",
                        dataType: "json",
                        success: function(data) {
                            organism.empty();
                            $.each(data.results.organism, function() {
                                var option = $('<option/>').val(this.organism_id).text(this.organism_name);
                                if (this.organism_id == selected_organism_id){
                                    option.attr('selected','selected');
                                }
                                option.appendTo(organism);
                            });
                            rel_release = data.results.release;
                            organism.change();
                        }
                    });

                    organism.change(function() {
                        $.webStorage.session().setItem('selected_organism_id', organism.val());
                    
                        release.empty();
                        release.removeAttr('disabled');
                        if (rel_release[organism.val()] == undefined) {
                            release.attr('disabled', 'disabled');
                            $('<option/>').val('').text('/').appendTo(release);
                        } else {
                            $.each(rel_release[organism.val()], function() {
                                var option = $('<option/>').val(this.release).text(this.release);
                                if (this.release == selected_release){
                                    option.attr('selected','selected');
                                }
                                option.appendTo(release);
                            });
                        }
                        release.change();
                    });
                
                    release.change(function(){
                        $.webStorage.session().setItem('selected_release', release.val());    
                    });

                    $("#search_unigene").autocomplete({
                        position: {
                            my: "right top", at: "right bottom"
                        },
                        source: function(request, response) {
                            $.ajax({
                                url: "<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/listing/searchbox/",
                                data: {species: organism.val(), release: release.val(), term: request.term},
                                dataType: "json",
                                success: function(data) {
                                    response(data.results);
                                }
                            });
                        },
                        minLength: 2,
                        select: function(event, ui) {
                            location.href = "<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/details/byId/" + ui.item.id;
                        }
                    });
                    $("#search_unigene").data("ui-autocomplete")._renderItem = function(ul, item) {
                        var li = $("<li>")
                        .append("<a href='<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/details/byId/" + item.id + "'><span style='display:inline-block; width:100px'>" + item.type + "</span>" + item.name + "</a>")
                        .appendTo(ul);
                        return li;
                    };
                });
        </script>
        <script type="text/javascript">
            function jumptoanchor(name){
                $(document.body).scrollTop($('#'+name).offset().top-45);
        
            }
    
            function addNavAnchor(name, linktext){
                if ($('#quicknav-pageheader').length==0){
                    $('#quicknav').append('<li class="divider" id="quicknav-pageheader"></li><li><a>on this page</a></li><li class="divider"></li>');
                }
                $('#quicknav').append('<li><a href="javascript:jumptoanchor(\'anchor-'+name+'\');">'+linktext+'</a></li>');
                document.write('<div id="anchor-'+name+'"> </div>');
            }
        </script>
        <style>
            .ui-tooltip-content table{
                margin-bottom: 0px;
            }
            textarea {
                resize:vertical;
            }
            .top-bar-section .right li div{
                padding: 0 5px;
                line-height: 45px;
                background: #111111; 
                display:block;
            }

            .top-bar-section .right li {
                height:45px;
            }

            .top-bar-section .right a {
                text-decoration: underline;
            }

            .top-bar-section .right label {
                color: #fff;
            }
        </style>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.position').each(function(){
                    var that = $(this);
                    var my = that.attr('data-my');
                    var at = that.attr('data-at');
                    var of = that.attr('data-of');
                    of = of=='PREV'?that.prev():of;
                    console.log(of);
                    that.position({my: my, at: at, of: of});
                });
            });
        </script>

        
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/feature/cart.js"></script>
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
        .beingDragged img {
            display:none;
        }

        fieldset *:last-child{
            margin-bottom: 0px;
        }

        form {
            margin: 0px;
        }
    </style>
    
    <!--[if lt IE 9]><script type="text/javascript" src="http://canvasxpress.org/js/flashcanvas.js"></script><![endif]-->
    <script type="text/javascript" src="http://canvasxpress.org/js/canvasXpress.min.js"></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/feature/filteredSelect.js"></script>
    <!-- use chrome frame if installed and user is using IE -->
    <meta http-equiv="X-UA-Compatible" content="chrome=1">

    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/feature/filteredSelect.js"></script>
    <style type="text/css">
        #filters tr td, #filters tr th {
            padding: 1px !important;
        }
        #filters input {
            margin: 0px !important;
        }
    </style>
    <script type="text/javascript">
        (function($) {
            
        <?php /*  Call merged included template "js/mav-graphs.js" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("js/mav-graphs.js", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '890451c4de15b22593-43334669');
content_51c73fc5ba27d9_74602534($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "js/mav-graphs.js" */?>
            (function() {
        <?php /*  Call merged included template "js/diffexpr.js" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("js/diffexpr.js", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('cart_ids'=>true), 0, '890451c4de15b22593-43334669');
content_51c73fc5bca813_52357419($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "js/diffexpr.js" */?>
            })();
            $(document).ready(function() {
                $("#tabs").tabs();

                $('select').tooltip(metadata_tooltip_options({items: "option"}));
            });
        })(jQuery);
    </script>

    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/feature/cart-init.js"></script>


    </head>
    <body>
        <div class="fixed">
            <nav class="top-bar" id="top">
                <ul class="title-area">
                    <li class="name">
                        <h1><a href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/">Transcript Browser</a></h1>
                    </li>
                </ul>
                <section class="top-bar-section">
                    <ul class="left">
                        <li class="has-dropdown"  id="quicknav-parent"><a href="#">QuickNav</a>
                            <ul class="dropdown" id="quicknav">
                                <li><a href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/diffexpr">Differential Expressions</a></li>
                                <li><a href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/blast">Blast</a></li>
                            </ul>
                        </li>
                        </ul>
                    <ul class="right">
                        <li><div><label for="select_organism">organism:</label></div></li>
                        <li><div><select id="select_organism" style="display:inline"></select></div></li>
                        <li><div><label for="select_release">release:</label></div></li>
                        <li><div><select id="select_release"></select></div></li>
                        <li class="divider"></li>
                        <li><a href='<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/multisearch'>adv. search</a></li>
                        <li class="divider"></li>
                        <li><div><label for="search">quick search:</label></div></li>
                        <li class="has-form"><input type="search" id="search_unigene"/></li>
                    </ul>
                </section>
            </nav>
        </div>
        <div class="row large-12 columns" style="padding: 0px;">
            
    <div class="row">
        <div class="large-9 columns">
            

    <div class="row">
        <div class="large-12 columns">
            <h2>Multi-Feature Actions on Cart <?php echo $_smarty_tpl->tpl_vars['cartname']->value;?>
</h2>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns" id="tabs">

            <ul>
                <li><a href="#tabs-graphs">Graphs</a></li>
                <li><a href="#tabs-diffexp">differential Expressions</a></li>
            </ul>
            <div id="tabs-graphs">
                <div class="row">
                    <div class="large-3 columns">
                        <h4>Assay</h4>
                    </div>
                    <div class="large-3 columns">
                        <h4>Analysis</h4>
                    </div>
                    <div class="large-3 columns">
                        <h4>Features</h4>
                    </div>
                    <div class="large-3 columns">
                        <h4>Samples</h4>
                    </div>
                </div>

                <form id="filters">
                    <div class="row">
                        <div class="large-3 columns panel">
                            <select id="select-assay" size="12"></select>
                        </div>
                        <div class="large-3 columns panel">
                            <select id="select-analysis" size="12"></select>
                        </div>
                        <div class="large-3 columns panel">
                            <select id="select-elements" size="12" multiple="multiple"></select>
                        </div>
                        <div class="large-3 columns panel">
                            <select id="select-sample" size="12" multiple="multiple"></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-12 columns panel">
                            <div class="large-8 columns">
                                <input type="checkbox" id="isoform-barplot-groupByTissues"/><label style="display:inline-block" for="isoform-barplot-groupByTissues"> &nbsp;Pool by Tissue Group</label>
                            </div>
                            <div class="large-4 columns">
                                <button type="button" id="button-barplot" value="barplot">Barplot</button>
                                <button type="button" id="button-heatmap" value="heatmap">Heatmap</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row" id="isoform-barplot-panel" name="isoform-barplot-panel" style="display:none">
                    <div class="large-12 columns panel">
                        <div class="row">
                            <div class="large-12 columns">
                                <div style="width:100%" id="isoform-barplot-canvas-parent">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tabs-diffexp">
                <?php /*  Call merged included template "display-components/diffexpr.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("display-components/diffexpr.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('cart_ids'=>true), 0, '890451c4de15b22593-43334669');
content_51c73fc5c36a73_23829213($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "display-components/diffexpr.tpl" */?>
            </div>
        </div>
    </div>




        </div>
        <div class="large-3 columns" >
            <div class="row large-3 columns" style="position:fixed;top:45px;bottom:0;overflow-x:hidden;overflow-y:auto;">
                <div style="display: none">

                    <div id="dialog-rename-cart-group" title="rename cart">
                        <form>
                            <fieldset>
                                <label for="cartname">cart name</label>
                                <input type="text" name="name" id="cartname" class="text ui-widget-content ui-corner-all" />
                            </fieldset>
                        </form>
                    </div>

                    <div id="dialog-delete-all" title="Delete all items and groups?">
                        <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>This will remove all your cart items and groups. Are you sure?</p>
                    </div>

                    <div id="dialog-edit-cart-item" title="edit item">
                        <form>
                            <fieldset>
                                <label for="item-feature_id">feature_id</label>
                                <input type="text" name="feature_id" id="item-feature_id" disabled="disabled" class="text ui-widget-content ui-corner-all" />
                            </fieldset>
                            <fieldset>
                                <label for="item-alias">display alias</label>
                                <input type="text" name="alias" id="item-alias" class="text ui-widget-content ui-corner-all" />
                                <label for="item-annotations">annotations</label>
                                <textarea name="annotations" id="item-annotations" class="text ui-widget-content ui-corner-all"></textarea>
                            </fieldset>
                        </form>
                    </div>
                </div>

                <div class="panel large-12 columns">
                    <?php if ((isset($_SESSION['OpenID']))){?>
                        <form action="?logout" method="post">
                            <button>Logout</button>
                        </form>
                    <?php }else{ ?>
                        <form action="?login" method="post">
                            <button>Login with Google</button>
                        </form>
                    <?php }?>
                </div>

                <div class="panel large-12 columns" id="cart">
                    <div>
                        <h4 class="left">Cart</h4>                        
                        <a class="button secondary right" href="javascript:cart.addGroup();">add new group</a>
                        <div style="clear:both">&nbsp;</div>
                    </div>
                    <div id="Cart">

                    </div>
                </div>

                <script type="text/template" id="template_cart_all_group"> 
                    <div class="cartGroup" data-name="all">
                    <div class="large-12 columns"><div class="left">all</div>
                    <div class="right">
                    <a href="javascript:$('#dialog-delete-all').dialog('open');"><img src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/51.png"/></a>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/graphs/all"><img  src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/23.png"/></a>
                    </div>
                    </div>
                    <ul class="large-12 columns elements">
                    </ul>
                    </div>
                </script>

                <script type="text/template" id="template_cart_new_group"> 
                    <div class='cartGroup' data-name="<<?php ?>%= groupname %<?php ?>>">
                    <div class="large-12 columns">
                    <div class="left"><<?php ?>%= groupname %<?php ?>>
                    </div>
                    <div class="right">
                    <a class="cart-button-rename" href="#"><img  src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/39.png"/></a>
                    <a href="javascript:cart.removeGroup('<<?php ?>%= groupname %<?php ?>>');"><img src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/51.png"/></a>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/graphs/<<?php ?>%= groupname %<?php ?>>"><img src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/23.png"/></a>
                    </div>
                    </div>
                    <ul class="large-12 columns elements">
                    <li class="placeholder">
                    drag your items here
                    </li>
                    </ul>
                    </div>
                </script>

                <script type="text/template"  id="template_cart_new_item"> 
                    <li style="clear:both" class="large-12 cartItem" data-id="<<?php ?>%=item.feature_id%<?php ?>>">
                    <div class="left"><a href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/details/byId/<<?php ?>%= item.feature_id %<?php ?>>"><img src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/47.png"/></a> 
                    <span class="displayname">
                    <<?php ?>%= item.metadata.alias || item.name || item.feature_id %<?php ?>>
                    </span>
                    </div>
                    <div class="right">
                    <a class="cart-button-rename" href="#"><img class="cart-button-edit" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/39.png"/></a>
                    <a class="cart-button-delete" href="#"><img src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/51.png"/></a>
                    </div>
                    </li>
                </script>
            </div>
            <div>&nbsp;</div>
        </div>
    </div>

        </div>

    </body>
</html>

<?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2013-06-23 20:34:45
         compiled from "C:\Users\mail_000\Dropbox\uni\bio\s202139\web\smarty\templates\js\mav-graphs.js" */ ?>
<?php if ($_valid && !is_callable('content_51c73fc5ba27d9_74602534')) {function content_51c73fc5ba27d9_74602534($_smarty_tpl) {?>$(document).ready(function() {

    var select_element = $('#select-elements');
    var select_assay = $('#select-assay');
    var select_analysis = $('#select-analysis');
    var select_tissues = $('#select-sample');


    new filteredSelect(select_analysis, 'analysis', {
        precedessorNode: select_assay
    });
    new filteredSelect(select_element, 'feature', {
        precedessorNode: select_analysis
    });
    new filteredSelect(select_tissues, 'sample', {
        precedessorNode: select_element
    });


    var lastItemEvent = 0;
    $(document).on('cartEvent', function(event) {
        if (!(event.eventData.action || '').match(/(add|remove)Item/) || event.eventData.groupname !== '<?php echo $_smarty_tpl->tpl_vars['cartname']->value;?>
')
            return;

        var myItemEvent = new Date().getTime();
        lastItemEvent = myItemEvent;

        setTimeout(function() {
            //if another itemEvent has happened in the last 100ms, skip.
            if (lastItemEvent !== myItemEvent)
                return;

            var cartitems = cart._getCartForContext()['<?php echo $_smarty_tpl->tpl_vars['cartname']->value;?>
'] || [];

            $.ajax('<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/listing/filters/', {
                method: 'post',
                data: {
                    ids: cartitems
                },
                success: function(data) {
                    var filterdata = data;
                    $.each(cartitems, function() {
                        filterdata.data.feature[this] = cart.cartitems[this];
                    });
                    new filteredSelect(select_assay, 'assay', {
                        data: filterdata
                    }).refill();

                }
            });
        }, 100);

    });



    function getFilterData() {
        var data = {
            parents: [],
            analysis: [],
            assay: [],
            biomaterial: []
        };
        select_element.find(':selected').each(function() {
            data.parents.push($(this).val());
        });
        data.analysis.push(select_analysis.find(':selected').val());
        data.assay.push(select_assay.find(':selected').val());
        select_tissues.find(':selected').each(function() {
            data.biomaterial.push($(this).val());
        });
        return data;
    }

    $('#button-barplot').click(function() {

        $.ajax('<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/graphs/barplot/quantifications', {
            data: getFilterData(),
            success: function(val) {
                $('#isoform-barplot-panel').show(0);
                var parent = $("#isoform-barplot-canvas-parent");

                //if we already have an old canvas, we have to clean that up first
                var canvas = $('#isoform-barplot-canvas');
                var cx = canvas.data('canvasxpress');
                if (cx != null) {
                    cx.destroy();
                    parent.empty();
                }

                canvas = $('<canvas id="isoform-barplot-canvas"></canvas>');
                parent.append(canvas);
                canvas.attr('width', parent.width() - 8);
                canvas.attr('height', 500);

                window.location.hash = "isoform-barplot-panel";


                cx = new CanvasXpress(
                        "isoform-barplot-canvas",
                        {
                            "x": val.x,
                            "y": val.y
                        },
                {
                    graphType: "Bar",
                    showDataValues: true,
                    graphOrientation: "vertical"
                });

                canvas.data('canvasxpress', cx);

                groupByTissues();


            }
        });
        return false;
    });

    $('#button-heatmap').click(function() {
        $.ajax('<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/graphs/barplot/quantifications', {
            data: getFilterData(),
            success: function(val) {
                $('#isoform-barplot-panel').show(0);
                var parent = $("#isoform-barplot-canvas-parent");

                //if we already have an old canvas, we have to clean that up first
                var canvas = $('#isoform-barplot-canvas');
                var cx = canvas.data('canvasxpress');
                if (cx != null) {
                    cx.destroy();
                    parent.empty();
                }

                canvas = $('<canvas id="isoform-barplot-canvas"></canvas>');
                parent.append(canvas);
                canvas.attr('width', parent.width() - 8);
                canvas.attr('height', 500);

                window.location.hash = "isoform-barplot-panel";


                cx = new CanvasXpress(
                        "isoform-barplot-canvas",
                        {
                            "x": val.x,
                            "y": val.y
                        },
                {
                    graphType: "Heatmap",
                    showDataValues: true,
                    graphOrientation: "vertical",
                    zoomSamplesDisable: true,
                    zoomVariablesDisable: true
                });

                canvas.data('canvasxpress', cx);
                groupByTissues();


            }
        });
        return false;
    });

    function groupByTissues() {
        var checkbox = $('#isoform-barplot-groupByTissues');
        var cx = $('#isoform-barplot-canvas').data('canvasxpress');
        if (checkbox.is(':checked')) {
            cx.groupSamples(["Tissue_Group"]);
        } else {
            cx.groupSamples([]);
        }
    }

    $('#isoform-barplot-groupByTissues').click(groupByTissues);

});

<?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2013-06-23 20:34:45
         compiled from "C:\Users\mail_000\Dropbox\uni\bio\s202139\web\smarty\templates\js\diffexpr.js" */ ?>
<?php if ($_valid && !is_callable('content_51c73fc5bca813_52357419')) {function content_51c73fc5bca813_52357419($_smarty_tpl) {?>$(document).ready(function() {
    var select_analysis = $('#select-gdfx-analysis');
    var select_conditionA = $('#select-gdfx-conditionA');
    var select_conditionB = $('#select-gdfx-conditionB');


    new filteredSelect(select_conditionB, 'bb', {
        precedessorNode: select_conditionA
    });

    var finalSelect = new filteredSelect(select_analysis, 'analysis', {
        precedessorNode: select_conditionB
    });

    release.change(function() {
        $.ajax('<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/listing/filters_diffexp/fullRelease', {
            method: 'post',
            data: {
                organism: organism.val(),
                release: release.val()
            },
            success: function(data) {
                new filteredSelect(select_conditionA, 'ba', {
                    data: data
                }).refill();
            }
        });
    });

    var selectedItem;
    var dataTable;
    $('#button-gdfx-table').click(function() {
        var selected = finalSelect.filteredData();
        selectedItem = {
            conditionA: selected.values[0].dir == 'ltr' ? selected.values[0].ba : selected.values[0].bb,
            conditionB: selected.values[0].dir == 'ltr' ? selected.values[0].bb : selected.values[0].ba,
            analysis: selected.values[0].analysis

        };
        $('#div-gdfxtable').show();


        if (typeof dataTable == "undefined") {
            var serverParams = function(aoData) {
                aoData.push({
                    name: "organism",
                    value: organism.val()
                });
                aoData.push({
                    name: "release",
                    value: release.val()
                });
                aoData.push({
                    name: "analysis",
                    value: selectedItem.analysis
                });
                aoData.push({
                    name: "conditionA",
                    value: selectedItem.conditionA
                });
                aoData.push({
                    name: "conditionB",
                    value: selectedItem.conditionB
                });
                $.each($('#diffexp_filters').serializeArray(), function() {
                    aoData.push(this);
                });
                /*<?php if ($_smarty_tpl->tpl_vars['cart_ids']->value){?>*/
                $.each(cart._getCartForContext()['<?php echo $_smarty_tpl->tpl_vars['cartname']->value;?>
'] || [], function() {
                    aoData.push({
                        name: 'ids[]',
                        value: this
                    });
                });
                /*<?php }?>*/
            };
            var lastQueryData;
            dataTable = $('#diffexp_results').dataTable({
                bFilter: false,
                bProcessing: true,
                bServerSide: true,
                fnServerData: function(sSource, aoData, fnCallback, oSettings) {
                    lastQueryData = aoData;
                    oSettings.jqXHR = $.ajax({
                        "dataType": 'json',
                        "type": oSettings.sServerMethod,
                        "url": sSource,
                        "data": aoData,
                        "success": function(data) {
                            update_query_details(data);
                            fnCallback(data);
                        }
                    });
                },
                fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $('td:first', nRow).html(sprintf('<a href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/details/byId/%s" target=”_blank”>%s</a>', aData.feature_id, aData.feature_name))
                },
                sServerMethod: "POST",
                sAjaxSource: "<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/listing/differential_expressions/fullRelease",
                fnServerParams: serverParams,
                aaSorting: [[5, "asc"]],
                aoColumns: [
                    {
                        sType: "natural",
                        mData: 'feature_name'
                    },
                    {
                        sType: "scientific",
                        mData: 'baseMean'
                    },
                    {
                        sType: "scientific",
                        mData: 'baseMeanA'
                    },
                    {
                        sType: "scientific",
                        mData: 'baseMeanB'
                    },
                    {
                        sType: "scientific",
                        mData: 'foldChange'
                    },
                    {
                        sType: "scientific",
                        mData: 'log2foldChange'
                    },
                    {
                        sType: "scientific",
                        mData: 'pval'
                    },
                    {
                        sType: "scientific",
                        mData: 'pvaladj'
                    },
                ],
                sDom: 'T<"clear">lfrtip',
                oTableTools: {
                    sSwfPath: "<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/swf/copy_csv_xls_pdf.swf",
                    aButtons: [
                        "select_all",
                        "select_none",
                        {
                            "sExtends": "ajax",
                            "sButtonText": "CSV Export All",
                            "fnClick": function(nButton, oConfig) {
                                var iframe = document.createElement('iframe');
                                iframe.style.height = "0px";
                                iframe.style.width = "0px";
                                iframe.src = "<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/listing/differential_expressions/releaseCsv" + "?" + $.param(lastQueryData);
                                document.body.appendChild(iframe);
                            }
                        },
                    ],
                    sRowSelect: "multi"
                }
            });
        } else {
            //table already exists, refresh table. if "selectedItem" has changed, this will load new data.
            dataTable.fnReloadAjax();
        }

    });

    $(document).on('cart.addGroup', function(e) {
        $('#select-gdfx-cart').append($('<option/>').text(e.eventData.name).attr('value', e.eventData.name));
    });

    $('#button-gdfx-addToCart').click(function() {
        var selectedItems = TableTools.fnGetInstance(dataTable[0]).fnGetSelectedData();
        var group = $('#select-gdfx-cart').val();
        if (group === '#new#')
            group = cart.addGroup();


        $.each(selectedItems, function() {
            cart.addItem(this.feature_id, {groupname: group});
        });

    });

    function update_query_details(data) {
        var query_details = data.query_details;
        var domQd = $('#query_details');
        domQd.find('.conditionA').text(query_details.conditionA.name).data('metadata', query_details.conditionA);
        domQd.find('.conditionB').text(query_details.conditionB.name).data('metadata', query_details.conditionB);
        domQd.find('.analysis').text(query_details.analysis.name).data('metadata', query_details.analysis);
        domQd.find('.organism').text(query_details.organism.name);
        domQd.find('.release').text(query_details.release);
        domQd.find('.hits').text(data.iTotalRecords);
        $('.query_details').fadeIn(500);
    }

    $('#diffexpr select').tooltip(metadata_tooltip_options({
        items: "option"
    }));
    $('#query_details').tooltip(metadata_tooltip_options({
        items: ".has-tooltip"
    }));


});<?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2013-06-23 20:34:45
         compiled from "C:\Users\mail_000\Dropbox\uni\bio\s202139\web\smarty\templates\display-components\diffexpr.tpl" */ ?>
<?php if ($_valid && !is_callable('content_51c73fc5c36a73_23829213')) {function content_51c73fc5c36a73_23829213($_smarty_tpl) {?><div id="diffexpr">
    <div class="row">
        <div class="large-4 columns">
            <h4>Condition A</h4>
        </div>
        <div class="large-4 columns">
            <h4>Condition B</h4>
        </div>

        <div class="large-4 columns">
            <h4>Analysis</h4>
        </div>
    </div>
    <form id="diffexp_filters">
        <div class="row">
            <div class="large-4 columns panel">
                <select id="select-gdfx-conditionA" size="12"></select>
            </div>
            <div class="large-4 columns panel">
                <select id="select-gdfx-conditionB" size="12"></select>
            </div>
            <div class="large-4 columns panel">
                <select id="select-gdfx-analysis" size="12"></select>
            </div>
        </div>
        <div class="row">
            <div class="large-5 columns">
                <h4>Filters</h4>
            </div>
            <div class="large-2 columns">
                &nbsp;
            </div>
            <div class="large-5 columns query_details" style="display:none">
                <h4>Results overview</h4>
            </div>
        </div>
        <div class="row">
            <div class="large-5 columns panel">

                <table id="filters" style="width:100%">
                    <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable(1, null, 0);?>
                    <?php  $_smarty_tpl->tpl_vars['filter_key'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['filter_key']->_loop = false;
 $_from = array('baseMean','baseMeanA','baseMeanB','foldChange','log2foldChange','pval','pvaladj'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['filter_key']->key => $_smarty_tpl->tpl_vars['filter_key']->value){
$_smarty_tpl->tpl_vars['filter_key']->_loop = true;
?>
                        <tr>
                            <th><?php echo $_smarty_tpl->tpl_vars['filter_key']->value;?>
</th>
                            <td>
                                <select name="filter_column[<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
][type]">
                                    <option value="lt">&lt;</option>
                                    <option value="gt">&gt;</option>
                                    <option value="leq">&lt;=</option>
                                    <option value="geq">&gt;=</option>
                                    <option value="eq">=</option>
                                </select>
                            </td>
                            <td>
                                <input name="filter_column[<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
][value]" type="text" />
                            </td>
                        </tr>
                        <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_smarty_tpl->tpl_vars['i']->value+1, null, 0);?>
                    <?php } ?>
                </table>
            </div>

            <div class="large-2 columns position" data-my="left center" data-at="right center" data-of="PREV">
                <button type="button" id="button-gdfx-table" value="table">display Table</button>
            </div>

            <div class="large-5 columns  panel query_details" style="display:none" id="query_details">
                <table style="width:100%" >
                    <tr>
                        <td>Condition 1</td>
                        <td class='conditionA has-tooltip'></td>
                    </tr>
                    <tr>
                        <td>Condition 2</td>
                        <td class='conditionB has-tooltip'></td>
                    </tr>
                    <tr>
                        <td>Analysis</td>
                        <td class='analysis has-tooltip'></td>
                    </tr>
                    <tr>
                        <td>Organism</td>
                        <td class='organism'></td>
                    </tr>
                    <tr>
                        <td>Release</td>
                        <td class='release'></td>
                    </tr>
                    <tr>
                        <td>Hits</td>
                        <td class='hits'></td>
                    </tr>
                </table>
            </div>
        </div>
    </form>
    <div class="row" id="div-gdfxtable" style="display:none">
        <div class="large-12 column">
            <h4>Detailed Results</h4>
        </div>
        <div class="large-12 column panel">
            <div class="large-12 column">
                <table id="diffexp_results">
                    <thead>  
                        <tr>
                            <th>feature</th>
                            <th>baseMean</th>
                            <th>baseMean1</th>
                            <th>baseMean2</th>
                            <th>foldChange</th>
                            <th>log2foldChange</th>
                            <th>pval</th>
                            <th>pvaladj</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="large-12 column">
                <span>
                    click a row to select
                </span>
                <span class=" right">
                    <button class="small button" type="button" id="button-gdfx-addToCart" value="table">add selected to cart: </button>
                    <select style="width:auto" id="select-gdfx-cart"><option value='#new#'>new</option><option value='all'>all</option></select>
                </span>
            </div>
        </div>
    </div>
</div><?php }} ?>