<?php /* Smarty version Smarty-3.1.13, created on 2013-06-11 17:18:55
         compiled from "C:\Users\mail_000\Dropbox\uni\bio\s202139\web\smarty\templates\blast.tpl" */ ?>
<?php /*%%SmartyHeaderCode:884051af55b0395148-43870707%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd40040bedce7ebd1e1fc7aa6214385e342235c15' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\blast.tpl',
      1 => 1370963911,
      2 => 'file',
    ),
    'c44393500e69763bf56453147eb3e23dada271cd' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\layout-with-cart.tpl',
      1 => 1370435050,
      2 => 'file',
    ),
    'c9e223e75317f40ea70fe3d34aff134ea2c81027' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\layout.tpl',
      1 => 1370963911,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '884051af55b0395148-43870707',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51af55b04dfc45_77050919',
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
<?php if ($_valid && !is_callable('content_51af55b04dfc45_77050919')) {function content_51af55b04dfc45_77050919($_smarty_tpl) {?>
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
    *[class*='cart-button-']{
        cursor: pointer;
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
            $("#blast-tabs").tabs();
            $("#blast-tabs form").submit(function() {
                var data = {
                    organism: organism.val(),
                    release: release.val()
                };
                var that = this;
                $.each($(this).serializeArray(), function() {
                    var matches = this.name.match(/^(\w+)\[(\w+)\]$/);
                    if ($.isArray(matches)) {
                        if (typeof data[matches[1]] === 'undefined')
                            data[matches[1]] = {};
                        data[matches[1]][matches[2]] = this.value;
                    } else {
                        data[this.name] = this.value;
                    }
                });
                $(that).find('input[type="submit"]').prop('disabled', true);
                $.ajax('<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/blast/start_job', {
                    data: {blast_job: data},
                    complete: function() {
                        $(that).find('input[type="submit"]').prop('disabled', false);
                    },
                    success: function(ret) {
                        if (ret.job_id != -1) {
                            window.location = '<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/blast_results/' + ret.job_id;
                        }
                    }
                });
                return false;
            });
        });
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
            <h2>Blast against selected release</h2>
        </div>
        <div class="large-12 columns panel">
            <div id="blast-tabs">
                <?php $_smarty_tpl->tpl_vars['blasts'] = new Smarty_variable(array('blastn','blastp','blastx','tblastn','tblastx'), null, 0);?>
                <?php $_smarty_tpl->tpl_vars['matrix'] = new Smarty_variable(array('BLOSUM45','BLOSUM50','BLOSUM62','BLOSUM80','BLOSUM90','PAM30','PAM70','PAM250'), null, 0);?>
                <?php $_smarty_tpl->tpl_vars['matrix_default'] = new Smarty_variable('BLOSUM62', null, 0);?>
                <ul>
                    <?php  $_smarty_tpl->tpl_vars['blast'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['blast']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['blasts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['blast']->key => $_smarty_tpl->tpl_vars['blast']->value){
$_smarty_tpl->tpl_vars['blast']->_loop = true;
?>
                        <li><a href="#tabs-<?php echo $_smarty_tpl->tpl_vars['blast']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['blast']->value;?>
</a></li>
                        <?php } ?>
                </ul>
                <?php  $_smarty_tpl->tpl_vars['blast'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['blast']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['blasts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['blast']->key => $_smarty_tpl->tpl_vars['blast']->value){
$_smarty_tpl->tpl_vars['blast']->_loop = true;
?>
                    <div id="tabs-<?php echo $_smarty_tpl->tpl_vars['blast']->value;?>
">
                        <form id="blastform-<?php echo $_smarty_tpl->tpl_vars['blast']->value;?>
">
                            <div class="row">
                                <input type="hidden" name="type" value="<?php echo $_smarty_tpl->tpl_vars['blast']->value;?>
">
                                <div class="large-12 columns">
                                    <label for="blastform-<?php echo $_smarty_tpl->tpl_vars['blast']->value;?>
-query">FASTA sequence(s):</label>
                                    <textarea id="blastform-<?php echo $_smarty_tpl->tpl_vars['blast']->value;?>
-query" name="query" style="width:100%; height:200px; white-space: nowrap;">

                                    </textarea>
                                </div>
                            </div>
                            <ul class="large-block-grid-5">
                                <li>
                                    <label for="blastform-<?php echo $_smarty_tpl->tpl_vars['blast']->value;?>
-num_descriptions">Number of Descriptions:</label>
                                    <select id="blastform-<?php echo $_smarty_tpl->tpl_vars['blast']->value;?>
-num_descriptions" name="parameters[num_descriptions]" style="width:auto"><option>10</option><option>50</option><option>100</option><option>250</option><option>1000</option></select>
                                </li>
                                <li>
                                    <label for="blastform-<?php echo $_smarty_tpl->tpl_vars['blast']->value;?>
-num_alignments">Number of Alignments:</label>
                                    <select id="blastform-<?php echo $_smarty_tpl->tpl_vars['blast']->value;?>
-num_alignments" name="parameters[num_alignments]" style="width:auto"><option>10</option><option>50</option><option>100</option><option>250</option><option>1000</option></select>
                                </li>
                                <li>
                                    <label for="blastform-<?php echo $_smarty_tpl->tpl_vars['blast']->value;?>
-evalue">Maximum E-value:</label>
                                    <select id="blastform-<?php echo $_smarty_tpl->tpl_vars['blast']->value;?>
-evalue" name="parameters[evalue]" style="width:auto"><option>0.01</option><option selected="selected">0.1</option><option>1.0</option><option>10</option><option>100</option></select>
                                </li>
                                <?php if ($_smarty_tpl->tpl_vars['blast']->value=='blastn'){?>
                                    <li>
                                        <label for="blastform-<?php echo $_smarty_tpl->tpl_vars['blast']->value;?>
-task">Task:</label>
                                        <select id="blastform-<?php echo $_smarty_tpl->tpl_vars['blast']->value;?>
-task" name="parameters[task]" style="width:auto"><option>blastn</option><option>dc-megablast</option><option>megablast</option></select>
                                    </li>
                                <?php }?>
                                <?php if (in_array($_smarty_tpl->tpl_vars['blast']->value,array('blastp','blastx','tblastn','tblastx'))){?>
                                    <li>
                                        <label for="blastform-<?php echo $_smarty_tpl->tpl_vars['blast']->value;?>
-matrix">Matrix:</label>
                                        <select id="blastform-<?php echo $_smarty_tpl->tpl_vars['blast']->value;?>
-matrix" name="parameters[matrix]" style="width:auto">
                                            <?php  $_smarty_tpl->tpl_vars['matrix_option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['matrix_option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['matrix']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['matrix_option']->key => $_smarty_tpl->tpl_vars['matrix_option']->value){
$_smarty_tpl->tpl_vars['matrix_option']->_loop = true;
?>
                                                <option <?php if ($_smarty_tpl->tpl_vars['matrix_option']->value==$_smarty_tpl->tpl_vars['matrix_default']->value){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['matrix_option']->value;?>
</option>
                                            <?php } ?>
                                        </select>
                                    </li>
                                <?php }?>
                            </ul>
                            <div class="row">
                                <div class="large-2 large-offset-10 columns"><br/><input type="submit" class="button" value="start job"/></div>
                            </div>
                        </form>
                    </div>
                <?php } ?>

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
                <h4>Cart</h4>
                <div id="cart-group-all" class='ui_accordion ui_collapsible'>
                    <div class="large-12 columns"><div class="left">all</div><div class="right"><img class="cart-button-delete" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/51.png"/><img class="cart-button-execute"  src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
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

            <script type="text/template" id="cart-group-template"> 
                <div class='cart-group' data-group="<<?php ?>%= groupname %<?php ?>>">
                    <div class="large-12 columns">
                        <div class="groupname left"><<?php ?>%= groupname %<?php ?>></div>
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
                </script>

                <script type="text/template"  id="cart-item-template"> 
                    <li style="clear:both" class="large-12 cart-item">
                        <div class="left"><img class="cart-button-goto" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/47.png"/> <span class="displayname">
                                <<?php ?>%= (item.alias !== undefined && item.alias !== '') ? item.alias : ((item.name !== undefined && item.name !== '') ? item.name : item.feature_id) %<?php ?>>
                            </span>
                        </div>
                        <div class="right">
                            <img class="cart-button-edit" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/39.png"/>
                            <img class="cart-button-delete" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/img/mimiGlyphs/51.png"/>
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