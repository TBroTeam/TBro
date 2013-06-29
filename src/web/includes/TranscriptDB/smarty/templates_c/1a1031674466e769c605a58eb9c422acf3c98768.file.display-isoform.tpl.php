<?php /* Smarty version Smarty-3.1.13, created on 2013-06-27 17:43:02
         compiled from "C:\Users\mail_000\Dropbox\uni\bio\s202139\web\smarty\templates\display-isoform.tpl" */ ?>
<?php /*%%SmartyHeaderCode:29061518caf30c21556-90132770%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1a1031674466e769c605a58eb9c422acf3c98768' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\display-isoform.tpl',
      1 => 1372331522,
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
    '5f609c1e68865d703c8107f0154afa183c2ddefc' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\display-components\\synonym.tpl',
      1 => 1370435037,
      2 => 'file',
    ),
    '01de67594409d1ea0faa592e48c189c55dcb0d40' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\display-components\\dbxref.tpl',
      1 => 1370963911,
      2 => 'file',
    ),
    'c32573f1c3164306cd22dca717bea6cbe9a325fd' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\display-components\\mapman.tpl',
      1 => 1372331522,
      2 => 'file',
    ),
    'aeafe4ab72a224e4122ece580a29e6ddcb4c87e6' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\display-components\\publication.tpl',
      1 => 1370435037,
      2 => 'file',
    ),
    'bd687f4e7ae59f6108a6fb2052f3a23d35a86413' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\display-components\\repeatmasker.tpl',
      1 => 1370435050,
      2 => 'file',
    ),
    'e3160ccbd697ce87030b82e17374f010d89f4de6' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\display-components\\predpeps.tpl',
      1 => 1372331522,
      2 => 'file',
    ),
    '265e789a216d3b9e6b7e70f1e5ae7a1bf94d6d44' => 
    array (
      0 => 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\templates\\display-components\\barplot.tpl',
      1 => 1370435037,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '29061518caf30c21556-90132770',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_518caf3114ab85_44212686',
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
<?php if ($_valid && !is_callable('content_518caf3114ab85_44212686')) {function content_518caf3114ab85_44212686($_smarty_tpl) {?><?php if (!is_callable('smarty_function_call_webservice')) include 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\/plugins\\function.call_webservice.php';
if (!is_callable('smarty_modifier_clean_id')) include 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\/plugins\\modifier.clean_id.php';
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
    
<?php echo smarty_function_call_webservice(array('path'=>"details/isoform",'data'=>array("query1"=>$_smarty_tpl->tpl_vars['isoform_feature_id']->value),'assign'=>'data'),$_smarty_tpl);?>


<!--[if lt IE 9]><script type="text/javascript" src="http://canvasxpress.org/js/flashcanvas.js"></script><![endif]-->
<script type="text/javascript" src="http://canvasxpress.org/js/canvasXpress.min.js"></script>
<!-- use chrome frame if installed and user is using IE -->
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<script type="text/javascript">
    var feature_id = '<?php echo $_smarty_tpl->tpl_vars['data']->value['isoform']['feature_id'];?>
';

    $(document).ready(function() {
        $('.tabs').tabs();

        $.ajax('<?php echo $_smarty_tpl->tpl_vars['ServicePath']->value;?>
/graphs/genome/isoform/' + feature_id, {
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
        
        $('.contains-tooltip').tooltip({
            items: ".has-tooltip",
            open: function(event, ui) {
                /*ui.tooltip.offset({
                top: event.pageY, 
                left: event.pageX
            });*/
                ui.tooltip.css("max-width", "600px");
            },
            content: function() {
                var element = $(this);
                var tooltip = $("<table/>");
                console.log(this.attributes);
                
                $.each(this.attributes, function(key,attr) {
                    if (attr.name.substr(0,5)=='data-'){
                        var splitAt = attr.nodeValue.indexOf('|');
                        var name = attr.nodeValue.substr(0,splitAt);
                        var value = attr.nodeValue.substr(splitAt+1);
                        $("<tr><td>" + name + "</td><td>" + value + "</td></tr>").appendTo(tooltip);
                    }
                });
                tooltip.foundation();
                return tooltip;
            }
        });
    });

    


    
</script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/js/feature/barplot.js"></script>



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
    <script type="text/javascript">addNavAnchor('isoform-overview','Isoform Overwiev');</script>
    <div class="large-12 columns panel" id="description">
        <div class="row">
            <div class="large-12 columns">
                <h1 class="left"><?php echo $_smarty_tpl->tpl_vars['data']->value['isoform']['name'];?>
</h1>
                <div class="right"><span class="button" onclick="javascript:cart.addItem(<?php echo $_smarty_tpl->tpl_vars['data']->value['isoform']['feature_id'];?>
);"> add to cart -> </span></div>
            </div>
        </div>
        <table style="width:100%">
            <tbody>
                <tr><td>Last modified</td><td><?php echo $_smarty_tpl->tpl_vars['data']->value['isoform']['timelastmodified'];?>
</td></tr>
                <tr><td>Corresponding unigene</td><td><a href="<?php echo $_smarty_tpl->tpl_vars['AppPath']->value;?>
/details/byId/<?php echo $_smarty_tpl->tpl_vars['data']->value['isoform']['unigene']['feature_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['data']->value['isoform']['unigene']['uniquename'];?>
</a></td></tr>
                <tr><td>Release</td><td><?php echo $_smarty_tpl->tpl_vars['data']->value['isoform']['import'];?>
</td></tr>
                <tr><td>Organism</td><td><?php echo $_smarty_tpl->tpl_vars['data']->value['isoform']['organism_name'];?>
</td></tr>
            </tbody>
        </table>
    </div>
</div>
<?php /*  Call merged included template "display-components/synonym.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("display-components/synonym.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('feature'=>$_smarty_tpl->tpl_vars['data']->value['isoform']), 0, '29061518caf30c21556-90132770');
content_51cc5d8642be30_27842588($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "display-components/synonym.tpl" */?>
<script type="text/javascript">addNavAnchor('sequence-annotation','Sequence Annotation');</script>
<div class="row">
    <div class="large-12 columns">
        <h4>Sequence Annotation</h4>
    </div>
    <div class="large-12 columns panel">
        <canvas id="canvas_<?php echo smarty_modifier_clean_id($_smarty_tpl->tpl_vars['data']->value['isoform']['uniquename']);?>
" width="600"></canvas>
        <div style="clear:both; height:1px; overflow:hidden">&nbsp;</div>
    </div>
</div>
<div class="row">
    <div class="large-12 columns">
        <div class="row">
            <div class="large-6 columns">
                <h4>Sequence</h4>
            </div>
        </div>
    </div>
    <div class="large-12 columns panel">
        <textarea style="height:100px;" id="sequence-<?php echo smarty_modifier_clean_id($_smarty_tpl->tpl_vars['data']->value['isoform']['uniquename']);?>
"><?php echo $_smarty_tpl->tpl_vars['data']->value['isoform']['residues'];?>
</textarea>
    </div>
</div>

<?php if (isset($_smarty_tpl->tpl_vars['data']->value['isoform']['description'])){?>
    <div class="row">
        <div class="large-12 columns panel">
            <h4>Blast2go derived:</h4>
            <?php  $_smarty_tpl->tpl_vars['description'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['description']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['isoform']['description']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['description']->key => $_smarty_tpl->tpl_vars['description']->value){
$_smarty_tpl->tpl_vars['description']->_loop = true;
?>
                <h5> <?php echo $_smarty_tpl->tpl_vars['description']->value['value'];?>
</h5>
            <?php } ?>

        </div>
    </div>
<?php }?>

<?php /*  Call merged included template "display-components/dbxref.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("display-components/dbxref.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('feature'=>$_smarty_tpl->tpl_vars['data']->value['isoform']), 0, '29061518caf30c21556-90132770');
content_51cc5d86501ff3_37017466($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "display-components/dbxref.tpl" */?>

<?php /*  Call merged included template "display-components/mapman.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("display-components/mapman.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('feature'=>$_smarty_tpl->tpl_vars['data']->value['isoform']), 0, '29061518caf30c21556-90132770');
content_51cc5d865d1771_42969350($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "display-components/mapman.tpl" */?>

<?php /*  Call merged included template "display-components/publication.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("display-components/publication.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('feature'=>$_smarty_tpl->tpl_vars['data']->value['isoform']), 0, '29061518caf30c21556-90132770');
content_51cc5d8664dda1_14311993($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "display-components/publication.tpl" */?>


<?php /*  Call merged included template "display-components/repeatmasker.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("display-components/repeatmasker.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('feature'=>$_smarty_tpl->tpl_vars['data']->value['isoform']), 0, '29061518caf30c21556-90132770');
content_51cc5d8669d0b8_16459371($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "display-components/repeatmasker.tpl" */?>


<?php /*  Call merged included template "display-components/predpeps.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("display-components/predpeps.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('feature'=>$_smarty_tpl->tpl_vars['data']->value['isoform']), 0, '29061518caf30c21556-90132770');
content_51cc5d8673c381_27032310($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "display-components/predpeps.tpl" */?>

<script type="text/javascript">addNavAnchor('plot','Plot Expression Data');</script>
<?php /*  Call merged included template "display-components/barplot.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("display-components/barplot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '29061518caf30c21556-90132770');
content_51cc5d8687a885_42276325($_smarty_tpl);
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

<?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2013-06-27 17:43:02
         compiled from "C:\Users\mail_000\Dropbox\uni\bio\s202139\web\smarty\templates\display-components\synonym.tpl" */ ?>
<?php if ($_valid && !is_callable('content_51cc5d8642be30_27842588')) {function content_51cc5d8642be30_27842588($_smarty_tpl) {?><?php if (!is_callable('smarty_function_call_webservice')) include 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\/plugins\\function.call_webservice.php';
if (!is_callable('smarty_function_publink')) include 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\/plugins\\function.publink.php';
?><?php echo smarty_function_call_webservice(array('path'=>"details/annotations/feature/synonym",'data'=>array("query1"=>$_smarty_tpl->tpl_vars['feature']->value['feature_id']),'assign'=>'synonyms'),$_smarty_tpl);?>

<?php if (count($_smarty_tpl->tpl_vars['synonyms']->value)>0){?>
    <div id="synonyms"> </div>
    <div class="row">
        <div class="large-12 columns panel">
            <h4>Synonyms</h4>                        
            <table style="width:100%">
                <tbody class="contains-tooltip">
                    <?php  $_smarty_tpl->tpl_vars['synonym'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['synonym']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['synonyms']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['synonym']->key => $_smarty_tpl->tpl_vars['synonym']->value){
$_smarty_tpl->tpl_vars['synonym']->_loop = true;
?>
                        <tr><th><?php echo $_smarty_tpl->tpl_vars['synonym']->value['synonym_name'];?>
</th><td><?php echo $_smarty_tpl->tpl_vars['synonym']->value['synonym_type'];?>
</td></tr>
                        <?php echo smarty_function_publink(array('pub'=>$_smarty_tpl->tpl_vars['synonym']->value),$_smarty_tpl);?>

                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php }?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2013-06-27 17:43:02
         compiled from "C:\Users\mail_000\Dropbox\uni\bio\s202139\web\smarty\templates\display-components\dbxref.tpl" */ ?>
<?php if ($_valid && !is_callable('content_51cc5d86501ff3_37017466')) {function content_51cc5d86501ff3_37017466($_smarty_tpl) {?><?php if (!is_callable('smarty_function_call_webservice')) include 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\/plugins\\function.call_webservice.php';
if (!is_callable('smarty_function_dbxreflink')) include 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\/plugins\\function.dbxreflink.php';
?><?php echo smarty_function_call_webservice(array('path'=>"details/annotations/feature/dbxref",'data'=>array("query1"=>$_smarty_tpl->tpl_vars['feature']->value['feature_id']),'assign'=>'dbxref'),$_smarty_tpl);?>


<?php if ((isset($_smarty_tpl->tpl_vars['dbxref']->value['GO']))){?>
    <div class="row contains-tooltip">
        <div class="large-12 columns panel">                    
            <h4>Gene Ontology</h4>
            <?php  $_smarty_tpl->tpl_vars['dbxarr'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['dbxarr']->_loop = false;
 $_smarty_tpl->tpl_vars['namespace'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['dbxref']->value['GO']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['dbxarr']->key => $_smarty_tpl->tpl_vars['dbxarr']->value){
$_smarty_tpl->tpl_vars['dbxarr']->_loop = true;
 $_smarty_tpl->tpl_vars['namespace']->value = $_smarty_tpl->tpl_vars['dbxarr']->key;
?>
                <h5><?php echo $_smarty_tpl->tpl_vars['namespace']->value;?>
</h5>
                <table style="width:100%">
                    <tbody>
                        <?php  $_smarty_tpl->tpl_vars['ref'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ref']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['dbxarr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['ref']->key => $_smarty_tpl->tpl_vars['ref']->value){
$_smarty_tpl->tpl_vars['ref']->_loop = true;
?>
                            <tr><td><?php echo smarty_function_dbxreflink(array('dbxref'=>$_smarty_tpl->tpl_vars['ref']->value),$_smarty_tpl);?>
</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
    </div>
<?php }?>

<?php if ((isset($_smarty_tpl->tpl_vars['dbxref']->value['EC']))){?>
    <div class="row contains-tooltip">
        <div class="large-12 columns panel">
            <h4>Enzyme classifications</h4>
            <?php  $_smarty_tpl->tpl_vars['dbxarr'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['dbxarr']->_loop = false;
 $_smarty_tpl->tpl_vars['namespace'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['dbxref']->value['EC']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['dbxarr']->key => $_smarty_tpl->tpl_vars['dbxarr']->value){
$_smarty_tpl->tpl_vars['dbxarr']->_loop = true;
 $_smarty_tpl->tpl_vars['namespace']->value = $_smarty_tpl->tpl_vars['dbxarr']->key;
?>
                <table style="width:100%">
                    <tbody>
                        <?php  $_smarty_tpl->tpl_vars['dbxref'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['dbxref']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['dbxarr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['dbxref']->key => $_smarty_tpl->tpl_vars['dbxref']->value){
$_smarty_tpl->tpl_vars['dbxref']->_loop = true;
?>
                            <tr><td><?php echo smarty_function_dbxreflink(array('dbxref'=>$_smarty_tpl->tpl_vars['dbxref']->value),$_smarty_tpl);?>
</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
    </div>
<?php }?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2013-06-27 17:43:02
         compiled from "C:\Users\mail_000\Dropbox\uni\bio\s202139\web\smarty\templates\display-components\mapman.tpl" */ ?>
<?php if ($_valid && !is_callable('content_51cc5d865d1771_42969350')) {function content_51cc5d865d1771_42969350($_smarty_tpl) {?><?php if (!is_callable('smarty_function_call_webservice')) include 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\/plugins\\function.call_webservice.php';
?><?php echo smarty_function_call_webservice(array('path'=>"details/annotations/feature/mapman",'data'=>array("query1"=>$_smarty_tpl->tpl_vars['feature']->value['feature_id']),'assign'=>'mapman'),$_smarty_tpl);?>


<?php if ((count($_smarty_tpl->tpl_vars['mapman']->value)>0)){?>
    <div class="row contains-tooltip">
        <div class="large-12 columns panel">                    
            <h4>MapMan Annotations</h4>
            <table style="width:100%">
                <tbody>
                    <?php  $_smarty_tpl->tpl_vars['hit'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['hit']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['mapman']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['hit']->key => $_smarty_tpl->tpl_vars['hit']->value){
$_smarty_tpl->tpl_vars['hit']->_loop = true;
?>
                        <tr>
                            <td>
                                <table style="width:100%">
                                    <tr><th>Annotation:</th><td><?php echo $_smarty_tpl->tpl_vars['hit']->value['annotation'];?>
</td></tr>
                                    <tr><th>Bincode:</th><td><?php echo $_smarty_tpl->tpl_vars['hit']->value['bin_accession'];?>
: <?php echo $_smarty_tpl->tpl_vars['hit']->value['bin_definition'];?>
</td></tr>
                                    <?php if (isset($_smarty_tpl->tpl_vars['hit']->value['bin_annotations'])&&count($_smarty_tpl->tpl_vars['hit']->value['bin_annotations'])>0){?>
                                        <tr><th>Bincode Annotations:</th><td>
                                                <table style="width:100%">
                                                    <?php  $_smarty_tpl->tpl_vars['bin_annot'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['bin_annot']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['hit']->value['bin_annotations']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['bin_annot']->key => $_smarty_tpl->tpl_vars['bin_annot']->value){
$_smarty_tpl->tpl_vars['bin_annot']->_loop = true;
?>
                                                        <tr><td></td><td><?php echo $_smarty_tpl->tpl_vars['bin_annot']->value['bin_annot_chem'];?>
</td><td><?php echo $_smarty_tpl->tpl_vars['bin_annot']->value['bin_annot_definition'];?>
</td></tr>
                                                    <?php } ?>
                                                </table>
                                            </td>
                                        </tr>
                                    <?php }?>
                                </table>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php }?>
<?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2013-06-27 17:43:02
         compiled from "C:\Users\mail_000\Dropbox\uni\bio\s202139\web\smarty\templates\display-components\publication.tpl" */ ?>
<?php if ($_valid && !is_callable('content_51cc5d8664dda1_14311993')) {function content_51cc5d8664dda1_14311993($_smarty_tpl) {?><?php if (!is_callable('smarty_function_call_webservice')) include 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\/plugins\\function.call_webservice.php';
if (!is_callable('smarty_function_publink')) include 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\/plugins\\function.publink.php';
?><?php echo smarty_function_call_webservice(array('path'=>"details/annotations/feature/pub",'data'=>array("query1"=>$_smarty_tpl->tpl_vars['feature']->value['feature_id']),'assign'=>'publications'),$_smarty_tpl);?>

<?php if (count($_smarty_tpl->tpl_vars['publications']->value)>0){?>
    <div id="publications"> </div>
    <div class="row">
        <div class="large-12 columns panel">
            <h4>Publications</h4>                        
            <table style="width:100%">
                <tbody class="contains-tooltip">
                    <?php  $_smarty_tpl->tpl_vars['pub'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pub']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['publications']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pub']->key => $_smarty_tpl->tpl_vars['pub']->value){
$_smarty_tpl->tpl_vars['pub']->_loop = true;
?>
                        <?php echo smarty_function_publink(array('pub'=>$_smarty_tpl->tpl_vars['pub']->value),$_smarty_tpl);?>

                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php }?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2013-06-27 17:43:02
         compiled from "C:\Users\mail_000\Dropbox\uni\bio\s202139\web\smarty\templates\display-components\repeatmasker.tpl" */ ?>
<?php if ($_valid && !is_callable('content_51cc5d8669d0b8_16459371')) {function content_51cc5d8669d0b8_16459371($_smarty_tpl) {?><?php if (!is_callable('smarty_function_call_webservice')) include 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\/plugins\\function.call_webservice.php';
?><?php echo smarty_function_call_webservice(array('path'=>"details/annotations/feature/repeatmasker",'data'=>array("query1"=>$_smarty_tpl->tpl_vars['feature']->value['feature_id']),'assign'=>'repeatmaskers'),$_smarty_tpl);?>

<?php if (count($_smarty_tpl->tpl_vars['repeatmaskers']->value)>0){?>
    <script type="text/javascript">addNavAnchor('repeatmasker-annotation','Repeatmasker Annotation');</script>
    <div class="row" id="repeatmasker" class="contains-tooltip">
        <div class="large-12 columns">
            <div id="repeatmasker-annotations"> </div>
            <h4>Repeatmasker Annotations:</h4>
            <div class="row">
                <div class="large-12 columns panel">
                    <table style="width:100%" id="repeatmasker-results">
                        <thead>
                            <tr><td>Name</td><td>Class</td><td>Family</td><td>Min</td><td>Max</td><td>Direction</td><td>Length</td></tr>
                        </thead>
                        <tbody>
                            <?php  $_smarty_tpl->tpl_vars['repeatmasker'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['repeatmasker']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['repeatmaskers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $('#repeatmasker-results').dataTable();
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
<?php }?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2013-06-27 17:43:02
         compiled from "C:\Users\mail_000\Dropbox\uni\bio\s202139\web\smarty\templates\display-components\predpeps.tpl" */ ?>
<?php if ($_valid && !is_callable('content_51cc5d8673c381_27032310')) {function content_51cc5d8673c381_27032310($_smarty_tpl) {?><?php if (!is_callable('smarty_function_call_webservice')) include 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\/plugins\\function.call_webservice.php';
if (!is_callable('smarty_modifier_clean_id')) include 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\/plugins\\modifier.clean_id.php';
if (!is_callable('smarty_function_interprolink')) include 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\/plugins\\function.interprolink.php';
if (!is_callable('smarty_function_dbxreflink')) include 'C:\\Users\\mail_000\\Dropbox\\uni\\bio\\s202139\\web\\smarty\\/plugins\\function.dbxreflink.php';
?><?php echo smarty_function_call_webservice(array('path'=>"details/annotations/feature/interpro_predpeps",'data'=>array("query1"=>$_smarty_tpl->tpl_vars['feature']->value['feature_id']),'assign'=>'predpeps'),$_smarty_tpl);?>

<?php if (count($_smarty_tpl->tpl_vars['predpeps']->value)>0){?>
    <script type="text/javascript">addNavAnchor('interpro-annotation','Interpro Annotation');</script>
    <div class="row" id="predpep">
        <div class="large-12 columns">
            <div id="predpeps"> </div>
            <h4>Predicted Peptides:</h4>
            <div class="row">
                <div class="large-12 columns panel">
                    <div class="tabs">
                        <ul>
                            <?php  $_smarty_tpl->tpl_vars['predpep'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['predpep']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['predpeps']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['predpep']->key => $_smarty_tpl->tpl_vars['predpep']->value){
$_smarty_tpl->tpl_vars['predpep']->_loop = true;
?>
                                <li><p><a href="#<?php echo smarty_modifier_clean_id($_smarty_tpl->tpl_vars['predpep']->value['name']);?>
"><?php echo $_smarty_tpl->tpl_vars['predpep']->value['name'];?>
</a></p></li>
                            <?php } ?>
                        </ul>

                        <?php  $_smarty_tpl->tpl_vars['predpep'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['predpep']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['predpeps']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['predpep']->key => $_smarty_tpl->tpl_vars['predpep']->value){
$_smarty_tpl->tpl_vars['predpep']->_loop = true;
?>
                            <div id="<?php echo smarty_modifier_clean_id($_smarty_tpl->tpl_vars['predpep']->value['name']);?>
">
                                <div class="row">
                                    <div class="large-12 columns">
                                        <table style="width:100%">
                                            <thead>
                                                <tr>
                                                    <td>Name</td>
                                                    <td>Start</td>
                                                    <td>End</td>
                                                    <td>Direction</td>
                                                    <td>Length</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?php echo $_smarty_tpl->tpl_vars['predpep']->value['name'];?>
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
                                </div>

                                <?php if (isset($_smarty_tpl->tpl_vars['predpep']->value['interpro'])&&count($_smarty_tpl->tpl_vars['predpep']->value['interpro'])>0){?>
                                    <div class="row">
                                        <div class="large-12 columns">
                                            <h4>Interpro Annotations:</h4>

                                            <table style="width:100%" class="contains-tooltip dataTable">
                                                <thead>
                                                    <tr><td>Interpro ID</td><td>Start</td><td>End</td><td>eValue</td><td>Match Description</td><td>GO</td></tr>
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
                                                            <td>
                                                                <span class="has-tooltip" data-version="Interpro-Version|<?php echo $_smarty_tpl->tpl_vars['interpro']->value['programversion'];?>
" data-src="Source|<?php echo $_smarty_tpl->tpl_vars['interpro']->value['sourcename'];?>
" data-id="ID|<?php echo $_smarty_tpl->tpl_vars['interpro']->value['analysis_match_id'];?>
" data-desc="Description|<?php echo $_smarty_tpl->tpl_vars['interpro']->value['analysis_match_description'];?>
">
                                                            <?php if ($_smarty_tpl->tpl_vars['interpro']->value['analysis_match_description']!='no description'){?><?php echo $_smarty_tpl->tpl_vars['interpro']->value['analysis_match_description'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['interpro']->value['sourcename'];?>
:<?php echo $_smarty_tpl->tpl_vars['interpro']->value['analysis_match_id'];?>
<?php }?>
                                                        </span>
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
                                    <script type="text/javascript">
                                        $(document).ready(function(){
                                            $('#<?php echo smarty_modifier_clean_id($_smarty_tpl->tpl_vars['predpep']->value['uniquename']);?>
 table.dataTable').dataTable();
                                        });
                                        
                                    </script>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
</div>
<?php }?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2013-06-27 17:43:02
         compiled from "C:\Users\mail_000\Dropbox\uni\bio\s202139\web\smarty\templates\display-components\barplot.tpl" */ ?>
<?php if ($_valid && !is_callable('content_51cc5d8687a885_42276325')) {function content_51cc5d8687a885_42276325($_smarty_tpl) {?><div class="row">
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