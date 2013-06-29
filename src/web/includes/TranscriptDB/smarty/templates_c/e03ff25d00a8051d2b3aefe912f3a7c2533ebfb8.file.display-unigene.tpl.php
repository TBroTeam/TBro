<?php /* Smarty version Smarty-3.1.13, created on 2013-06-22 15:06:21
         compiled from "C:\Users\mail_000\Dropbox\uni\bio\s202139\web\smarty\templates\display-unigene.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21990518cb287048398-63454995%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e03ff25d00a8051d2b3aefe912f3a7c2533ebfb8' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\display-unigene.tpl',
      1 => 1371856242,
      2 => 'file',
    ),
    'c44393500e69763bf56453147eb3e23dada271cd' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\layout-with-cart.tpl',
      1 => 1371854827,
      2 => 'file',
    ),
    'c9e223e75317f40ea70fe3d34aff134ea2c81027' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\layout.tpl',
      1 => 1370963911,
      2 => 'file',
    ),
    'fae09a2983d0a7c93617c5e0affd815cad3aaaee' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\display-components\\feature_table.tpl',
      1 => 1371857131,
      2 => 'file',
    ),
    '265e789a216d3b9e6b7e70f1e5ae7a1bf94d6d44' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\display-components\\barplot.tpl',
      1 => 1370435037,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21990518cb287048398-63454995',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_518cb2871bea23_26921211',
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
<?php if ($_valid && !is_callable('content_518cb2871bea23_26921211')) {function content_518cb2871bea23_26921211($_smarty_tpl) {?><?php if (!is_callable('smarty_function_call_webservice')) include 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\/plugins\\function.call_webservice.php';
?>
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
    
<?php echo smarty_function_call_webservice(array('path'=>"details/unigene",'data'=>array("query1"=>$_smarty_tpl->tpl_vars['unigene_feature_id']->value),'assign'=>'data'),$_smarty_tpl);?>

<!--[if lt IE 9]><script type="text/javascript" src="http://canvasxpress.org/js/flashcanvas.js"></script><![endif]-->
<script type="text/javascript" src="http://canvasxpress.org/js/canvasXpress.min.js"></script>
<!-- use chrome frame if installed and user is using IE -->
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<script type="text/javascript">
    var feature_id = '<?php echo $_smarty_tpl->tpl_vars['data']->value['unigene']['feature_id'];?>
';
</script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/feature/barplot.js"></script>


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
    <div class="large-12 columns panel">
        <div class="row">
            <div class="large-12 columns">
                <h1 class="left">Unigene <?php echo $_smarty_tpl->tpl_vars['data']->value['unigene']['name'];?>
</h1>
                <div class="right"><span class="button" onclick="javascript:cart.addItem(<?php echo $_smarty_tpl->tpl_vars['data']->value['unigene']['feature_id'];?>
);"> add to cart -> </span></div>
            </div>
        </div>
        <h5>last modified: <?php echo $_smarty_tpl->tpl_vars['data']->value['unigene']['timelastmodified'];?>
</h5>
    </div>
</div>

<?php if ((isset($_smarty_tpl->tpl_vars['data']->value['unigene']['isoforms'])&&count($_smarty_tpl->tpl_vars['data']->value['unigene']['isoforms'])>0)){?>
    <script type="text/javascript">
        $(document).ready(function(){
            displayFeatureTable(<?php echo json_encode($_smarty_tpl->tpl_vars['data']->value['unigene']['isoforms']);?>
, {
                bFilter: false, 
                sDom: 't',
                aoColumns: [
                    {},
                    {bVisible: false},
                    {},
                    {bVisible: false},
                    {}
                ]
            });
        });
    </script>
    <div class="row">
        <div class="large-12 columns">
            <h4>Known Isoforms:</h4>
        </div>
    </div>
    <div class="row">        
        <div class="large-12 columns panel">
            <?php /*  Call merged included template "display-components/feature_table.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("display-components/feature_table.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '21990518cb287048398-63454995');
content_51c5a14e1a0085_02944543($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "display-components/feature_table.tpl" */?>
        </div>
    </div>
<?php }?>
<?php /*  Call merged included template "display-components/barplot.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("display-components/barplot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '21990518cb287048398-63454995');
content_51c5a14e22e4d2_77458031($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "display-components/barplot.tpl" */?>

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

                    <div>
                        <a id="cart-add-group" class="button secondary right">add new cart</a>
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

<?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2013-06-22 15:06:22
         compiled from "C:\Users\mail_000\Dropbox\uni\bio\s202139\web\smarty\templates\display-components\feature_table.tpl" */ ?>
<?php if ($_valid && !is_callable('content_51c5a14e1a0085_02944543')) {function content_51c5a14e1a0085_02944543($_smarty_tpl) {?><script type="text/javascript">
    var datatable = null;
    
    function displayFeatureTable(data, opts){
        var options = $.extend(true, {
            aoColumns: [
                {bSortable: false},
                {},
                {},
                {},
                {bSortable: false}
            ]
        }, opts);
        var res = $('#results tbody');
        res.empty();
        var cnt=0;
        var template = _.template($('#result-template').html());
        $.each(data, function(){
            res.append(template(this));
            cnt++;
        });
        if (cnt>0){
            $('.results').show(500);
            if (datatable === null)
                datatable = $('#results').dataTable(options);
        }
    }
    
    (function($){
        $(document).ready(function(){
            $('#add_selected').click(function(){
                $('#results tbody').find('input:checked').each(function(){
                    cart.addItem($(this).val());
                });
            });
            
            $('#compare_selected').click(function(){
                var cartname = cart.addGroup();
                var checkboxes = $('#results tbody').find('input:checked');
                if (checkboxes.length===0) return;
                var count_finished = 0;
                checkboxes.each(function(){
                    cart.addItem($(this).val(), {
                        groupname: cartname,
                        afterDOMinsert: function(){
                            cart.options.callbacks.afterDOMinsert_item.apply(this, arguments);

                            //all ajax calls & callbacks have finished, we can continue to the graph page
                            if (++count_finished == checkboxes.length){
                                window.location = '<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/graphs/'+cartname;
                            }
                        }
                    });
                });
            });
            $('#check_all').prop('checked',false);
            $('#check_all').click(function(){
                $('#results tbody').find('input[type="checkbox"]').prop('checked',$(this).prop('checked')); 
            });
            
            
            $('#results').tooltip({
                items: ".has-tooltip",
                open: function(event, ui) {
                    ui.tooltip.css("max-width", "600px");
                },
                content: function() {
                    var that = this;
                    var tooltip = $("<table/>");
                    $.ajax({url:'<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/details/cartitem/'+$(that).attr('data-id'), success: function(data){
                            $.each(data, function(name, value){
                                $("<tr><td>" + name + "</td><td>" + value + "</td></tr>").appendTo(tooltip);
                            });
                        }});
                
                    tooltip.foundation();
                    return tooltip;
                }
            });
        });
        
        
    })(jQuery);

</script>


<script type="text/template" id="result-template">
    <tr>
        <td>
            <input type="checkbox" value="<<?php ?>%= feature_id %<?php ?>>"/>
        </td>
        <td>
            <span><<?php ?>%= type %<?php ?>></span>
        </td>
        <td data-id="<<?php ?>%= feature_id %<?php ?>>">
            <a class="has-tooltip" data-id="<<?php ?>%= feature_id %<?php ?>>" href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/details/byId/<<?php ?>%= feature_id %<?php ?>>"><<?php ?>%= name %<?php ?>></a>
        </td>
        <td data-id="<<?php ?>%= feature_id %<?php ?>>">
            <span><<?php ?>% if (typeof alias != "undefined" ) print(alias) %<?php ?>></span>
        </td>
        <td>
            <span style="margin-bottom:0px" class="small button right"  onclick="$.ajax({url:'<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/details/cartitem/<<?php ?>%= feature_id %<?php ?>>', success: cart.addItemToAll});"> add to cart -> </span>
        </td>
    </tr>
</script>
<div class="row">
    <div class="large-12 column">
        <table style="width:100%" id="results">
            <thead>
                <tr>
                    <td></td>
                    <td>Type</td>
                    <td>Name</td>
                    <td>Alias</td>
                    <td></td>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td><input type="checkbox" id="check_all"/></td>
                    <td colspan="4">
                        <span style="margin-bottom:0px" class="small button right" id="compare_selected">compare selected</span>
                        <span style="margin-bottom:0px" class="small button right" id="add_selected"> add selected to cart -> </span>
                    </td>
                </tr>
            </tfoot>
            <tbody>
            </tbody>
        </table>
    </div>
</div><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2013-06-22 15:06:22
         compiled from "C:\Users\mail_000\Dropbox\uni\bio\s202139\web\smarty\templates\display-components\barplot.tpl" */ ?>
<?php if ($_valid && !is_callable('content_51c5a14e22e4d2_77458031')) {function content_51c5a14e22e4d2_77458031($_smarty_tpl) {?><div class="row">
    <div class="large-12 columns">
        <h4>Barplot</h4>
    </div>
</div>

<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/feature/filteredSelect.js"></script>

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
                <h5>Samples</h5>
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
<div class="row" id="isoform-barplot-panel" style="display:none">
    <div class="large-12 columns panel">
        <div class="row">
            <div class="large-12 columns">
                <div style="width:100%" id="isoform-barplot-canvas-parent">
                </div>
                <input type="checkbox" id="isoform-barplot-groupByTissues"/><label style="display:inline-block" for="isoform-barplot-groupByTissues"> &nbsp;Pool by Tissue Group</label>

            </div>
        </div>
    </div>
</div><?php }} ?>