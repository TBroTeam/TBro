<?php /* Smarty version Smarty-3.1.13, created on 2013-06-27 17:42:57
         compiled from "C:\Users\mail_000\Dropbox\uni\bio\s202139\web\smarty\templates\welcome.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12826518caed369d715-28315181%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b8b17712d791c98b0319ab7af8a0964c353ee197' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\welcome.tpl',
      1 => 1371851196,
      2 => 'file',
    ),
    'c44393500e69763bf56453147eb3e23dada271cd' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\layout-with-cart.tpl',
      1 => 1372331522,
      2 => 'file',
    ),
    'c9e223e75317f40ea70fe3d34aff134ea2c81027' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\layout.tpl',
      1 => 1372331522,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12826518caed369d715-28315181',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_518caed39fa790_25372926',
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
<?php if ($_valid && !is_callable('content_518caed39fa790_25372926')) {function content_518caed39fa790_25372926($_smarty_tpl) {?>
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
            
            .top-bar-section .right .has-dropdown li {
                height:auto;
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
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/feature/cart-init.js"></script>
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
    
<script type="text/javascript">
    $(document).ready(function() {
        release.change(function() {
            $.ajax({
                url: "<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/details/statistical_information/"+organism.find(':selected').text()+"/"+release.val(),
                dataType: "json",
                success: function(data) {
                    $.each(data.results, function(key, val) {
                        $('#stat_'+key).html(val);
                    });
                }
            });
        });
        //http://bio.localhost/ajax/details/statistical_information/dmuscipula/test
    });
</script>



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
                        <li class="has-dropdown"  id="searchnav-parent"><a href="#">adv. search</a>
                            <ul class="dropdown" id="searchnav">
                                <li><a href='<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/multisearch'>search for multiple features</a></li>
                                <li><a href='<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/annotationsearch'>search for annotations</a></li>
                            </ul>
                        </li>
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
    <div class="large-12 columns panel">
        <h2>welcome to the transcriptome browser</h2>
    </div>
</div>
<div class="row">
    <div class="large-12 columns">
        <h4>some statistics for your amusement</h4>
    </div>
    <div class="large-12 columns panel">
        <table>
            <tr><th>Species in this database: </th><td id='stat_organisms'></td></tr>
            <tr><th>Releases in this database: </th><td id='stat_releases'></td></tr>
            <tr><th>Unigenes in this database: </th><td id='stat_total_unigenes'></td></tr>
            <tr><th>Isoforms in this database: </th><td id='stat_total_isoforms'></td></tr>
            <tr><td></td></tr>
            <tr><th>Unigenes in the selected release: </th><td id='stat_count_unigenes'></td></tr>
            <tr><th>Isoforms in the selected release: </th><td id='stat_count_isoforms'></td></tr>
        </table>
    </div>
</div>

<div class="row">
    <div class="large-12 columns panel">
        <p>Try searching for comp231081_c0_seq1, comp234627_c0_seq7 or comp214244_c0_seq2 .</p>
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

<?php }} ?>