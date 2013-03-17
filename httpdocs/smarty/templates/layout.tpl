
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width" />
        <title>Transcript Browser - dionaea muscipula</title>

        <link rel="stylesheet" href="{#$AppPath#}/css/normalize.css" />
        <link rel="stylesheet" href="{#$AppPath#}/css/foundation.css" />
        <link type="text/css" href="http://code.jquery.com/ui/1.10.1/themes/base/minified/jquery-ui.min.css" rel="Stylesheet" />    

        <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
        <script type="text/javascript" src="{#$AppPath#}/js/vendor/custom.modernizr.js"></script>
        <script type="text/javascript" src="{#$AppPath#}/js/foundation.min.js"></script>        


        <script type="text/javascript">
            $(document).ready(function() {
                $(document).foundation();
                $("#search_unigene").autocomplete({
                    position: {
                        my: "right top", at: "right bottom"
                    },
                    source: function(request, response) {
                        $.ajax({
                            url: "{#$ServicePath#}/listing/unigenes/" + request.term,
                            dataType: "json",
                            success: function(data) {
                                response(data.results);
                            }
                        });
                    },
                    minLength: 2,
                    select: function(event, ui) {
                        window.location.href = '{#$AppPath#}/unigene-details/' + ui.item.value;
                    }
                });
                $('#search_unigene').keydown(function(event) {
                    //Enter
                    if (event.which == 13) {
                        event.preventDefault();
                        $.ajax({
                            url: "{#$ServicePath#}/listing/unigenes/" + $(this).val(),
                            dataType: "json",
                            success: function(data) {
                                if (data.results.length == 1) {
                                    window.location.href = '{#$AppPath#}/unigene-details/' + data.results[0];
                                }
                            }
                        });
                    }
                });
                $("#cart-group-all").accordion({
                    collapsible: true,
                    heightStyle: "content"
                });
            });</script>
        <style>
            .ui-accordion .ui-accordion-header {
                margin-bottom:0px;
            }
        </style>

        {#block name='head'#}{#/block#}

    </head>
    <body>
        <div class="fixed">
            <nav class="top-bar" id="top">
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
        </div>
        <div class="row">
            <div class="large-9 columns">
                {#block name='body'#}{#/block#}
            </div>
            <div class="large-3 columns" >
                <div class="row large-3 columns" style="position:fixed;top:45px;bottom:0;overflow-x:hidden;overflow-y:auto;">
                    <script type="text/javascript">
                        var lastGroupNumber = 0;
                        var cart_groups = null;
                        var cart_group_all = null;
                        $(document).ready(function() {
                            cart_groups = $('#cart-groups');
                            cart_group_all = $('#cart-group-all');
                        });

                        function addGroup() {
                            groupname = "group " + (++lastGroupNumber);
                            // DOM manupulation
                            newElStr = $('#cart-group-dummy').html();
                            newElStr = newElStr.replace(/#groupname#/g, groupname);
                            cart_groups.append(newElStr);
                            newEl = cart_groups.find("[data-group='" + groupname + "']");
                            newEl.find('.cart-target').sortable({
                                items: "li:not(.placeholder)",
                                accept: ":not(.ui-sortable-helper)",
                                receive: function(event, ui) {
                                    //remove placeholder
                                    $(this).find(".placeholder").remove();
                                    //do not allow duplicate items
                                    copies = $(this).find("[data-uniquename='" + ui.item.data('uniquename') + "']");
                                    if (copies.length > 1)
                                        copies[1].remove();
                                }
                            });
                            newEl.accordion({
                                collapsible: true,
                                heightStyle: "content"
                            });
                            return groupname;
                        }
                        function renameGroup(oldname, newname) {
                        }
                        function addObjectToAll(object) {

                            // DOM manupulation
                            newElStr = $('#cart-item-dummy').html();
                            newElStr = newElStr.replace(/#uniquename#/g, object.uniquename);
                            newElStr = newElStr.replace(/#id#/g, object.id);
                            console.log(cart_group_all);
                            cart_group_all.find('ul').append(newElStr);
                            refresh_cart_group_all();
                        }
                        
                        function addObjectToGroup(object, groupname) {
                        }
                        
                        function removeObjectFromAll(object) {
                        }
                        
                        function removeObjectFromGroup(object, groupname) {
                        }
                        
                        function getObjectByName(objectname) {
                        }
                        
                        function refresh_cart_group_all(){
                            cart_group_all.find('li').draggable({
                                appendTo: "body",
                                helper: function() {
                                    return $(this).clone().addClass('beingDragged');
                                },
                                connectToSortable: ".cart-target"
                            });
                        }

                        $(document).ready(function() {
                            refresh_cart_group_all();
                            $('#cart-add-group').click(addGroup);
                            addObjectToAll({uniquename: '1.01_comp231081_c0_seq1', id: 123});
                        });
                    </script>
                    <div id="cart-group-dummy" style="display: none"> 
                        <div class='cart-group' data-group="#groupname#">
                            <div>#groupname#</div>
                            <ul class="cart-target">
                                <li class="placeholder">drag your items here</li>
                            </ul>
                        </div>
                    </div>
                    <div style="display: none">
                        <ul id="cart-item-dummy" style="display: none"> 
                            <li data-uniquename="#uniquename#" data-id="#id#">#uniquename#</li>
                        </ul>
                    </div>
                    <div class=" panel large-12 columns">
                        <h4>Cart</h4>
                        <div id="cart-group-all" class='ui_accordion ui_collapsible'>
                            <div>all<div class="right"><img src="{#$AppPath#}/img/mimiGlyphs/23.png"/></div></div>
                            <ul>
                            </ul>
                        </div>
                        <div>
                            <a id="cart-add-group" class="button secondary right">add new cart</a>
                            <div style="clear:both">&nbsp;</div>
                        </div>
                        <div id="cart-groups">

                        </div>
                    </div>

                </div>
                <div>&nbsp;</div>
            </div>
        </div>
    </body>
</html>

