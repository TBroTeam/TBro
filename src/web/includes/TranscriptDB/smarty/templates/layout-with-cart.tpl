{#extends file='layout.tpl'#}
{#block name='head'#}
    <script type="text/javascript" src="{#$AppPath#}/js/cart.js"></script>
    <script type="text/javascript">
        //will be used by cart-init.js
        var cartoptions = {
            serviceNodes: {
                itemDetails: '{#$ServicePath#}/details/features',
                sync: '{#$ServicePath#}/cart/sync'
            }
        };
    </script>
    <script type="text/javascript" src="{#$AppPath#}/js/cart-init.js"></script>

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
        .cartMenuContent{
            display:none;
        }
        .cartMenuButton{
            margin-bottom: 0px;
        }
    </style>
    {#$smarty.block.child#}
{#/block#}
{#block name='body'#}
    <div class="row">
        <div class="large-9 columns">
            {#$smarty.block.child#}
        </div>
        <div class="large-3 columns" >
            <div class="row large-3 columns" style="position:fixed;top:45px;bottom:0;overflow-x:hidden;overflow-y:auto;">
                <div style="display: none">

                    <div id="dialog-rename-cart-group" title="Rename Cart">
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

                    <div id="dialog-edit-cart-item" title="Edit Item">
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

                    <div id="dialog-paste-cart-group" title="Import Group">
                        <form>
                            <fieldset>
                                <label for="paste-json">Data as created using the "Export Group" feature:</label>
                                <textarea id="paste-json" class="text ui-widget-content ui-corner-all" style="height: 350px"></textarea>
                                <label for="paste-conflict">Existing annotations should be:</label>
                                <select id="paste-conflict"><option value="keep">kept</option><option value="merge">merged</option><option value="overwrite">overwritten</option></select>
                            </fieldset>
                        </form>
                    </div>

                    <div id="dialog-copy-cart-group" title="Export Group">
                        <form>
                            <fieldset>
                                <label for="copy-json">You can copy the data below. It may be re-imported by anyone using the "Import Group" feature.</label>
                                <textarea id="copy-json" class="text ui-widget-content ui-corner-all" style="height: 375px"></textarea>
                            </fieldset>
                        </form>
                    </div>
                </div>

                <div class="panel large-12 columns" style="text-align: center">
                    {#if (isset($smarty.session['OpenID'])) #}
                        <form action="?logout" method="post">
                            <button class="button large">Logout</button>
                        </form>
                    {#else#}
                        <form action="?login" method="post">
                            <button class="button large">Login with Google</button>
                        </form>
                    {#/if#}
                </div>

                <div class="panel large-12 columns" id="cart">
                    <div>
                        <h4 class="left">Cart</h4>                        
                        <a class="button secondary right" href="#" onclick="cart.addGroup();">Add New Group</a>
                        <div style="clear:both">&nbsp;</div>
                    </div>
                    <div id="Cart">

                    </div>
                </div>

                <script type="text/template" id="template_cart_all_group"> 
                <div class="cartGroup" data-name="all">
                    <div class="large-12 columns"><div class="left" style="position:absolute; top:50%; margin-top:-10px;">all</div>
                        <div class="right" >
                            <button class="cartMenuButton tiny" data-cartMenu="cart-dropdown-groupall">Actions</button>
                            <ul id="cart-dropdown-groupall"  class="f-dropdown cartMenuContent">
                                <li><a href="#" onclick="$('#dialog-paste-cart-group').dialog('open');"><img alt="Import Group" src="{#$AppPath#}/img/mimiGlyphs/5.png"/>&nbsp;Paste Group</a></li>
                                <li><a href="#" onclick="$('#dialog-delete-all').dialog('open');"><img src="{#$AppPath#}/img/mimiGlyphs/51.png"/>&nbsp;Delete All</a></li>
                                <li><a href="{#$AppPath#}/graphs/all"><img  src="{#$AppPath#}/img/mimiGlyphs/23.png"/>&nbsp;Execute</a></li>
                                <li><a href='#' data-ServicePath="{#$ServicePath#}/export/fasta" class="exportBtn"><img  src="{#$AppPath#}/img/mimiGlyphs/31.png"/>&nbsp;Export fasta</a></li>
                            </ul>
                        </div>
                    </div>
                    <ul class="large-12 columns elements"> 
                    </ul> 
                </div> 
                </script>

                <script type="text/template" id="template_cart_new_group"> 
                <div class='cartGroup' data-name="<%= groupname %>">
                    <div class="large-12 columns">
                        <div class="left" style="position:absolute; top:50%; margin-top:-10px;"><%= groupname %>
                        </div>
                        <div class="right">
                            <button class="cartMenuButton tiny" data-cartMenu="cart-dropdown-group-<%= groupname %>">Actions</button>
                            <ul id="cart-dropdown-group-<%= groupname %>"  class="f-dropdown cartMenuContent">
                                <li><a class="cart-button-rename" href="#"><img alt="Rename Group" src="{#$AppPath#}/img/mimiGlyphs/39.png"/>&nbsp;Rename Group</a></li>
                                <li><a class="cart-button-copy" href="#"><img alt="Export Group"  src="{#$AppPath#}/img/mimiGlyphs/9.png"/>&nbsp;Copy Group</a></li>
                                <li><a href="#" onclick="cart.removeGroup('<%= groupname %>');"><img alt="Remove Group" src="{#$AppPath#}/img/mimiGlyphs/51.png"/>&nbsp;Remove Group</a></li>
                                <li><a href="{#$AppPath#}/graphs/<%= groupname %>"><img alt="Execute Group Actions" src="{#$AppPath#}/img/mimiGlyphs/23.png"/>&nbsp;Execute</a></li>
                                <li><a href='#' data-ServicePath="{#$ServicePath#}/export/fasta" class="exportBtn"><img  src="{#$AppPath#}/img/mimiGlyphs/31.png"/>&nbsp;Export fasta</a></li>
                            </ul>
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
                    <li style="clear:both" class="large-12 cartItem" data-id="<%=item.feature_id%>">
                    <div class="left"><a href="{#$AppPath#}/details/byId/<%= item.feature_id %>"><img src="{#$AppPath#}/img/mimiGlyphs/47.png"/></a> 
                    <span class="displayname">
                    <%= item.metadata.alias || item.name || item.feature_id %>
                    </span>
                    </div>
                    <div class="right">
                    <a class="cart-button-rename" href="#"><img class="cart-button-edit" src="{#$AppPath#}/img/mimiGlyphs/39.png"/></a>
                    <a class="cart-button-delete" href="#"><img src="{#$AppPath#}/img/mimiGlyphs/51.png"/></a>
                    </div>
                    </li>
                </script>
            </div>
            <div>&nbsp;</div>
        </div>
    </div>
{#/block#}