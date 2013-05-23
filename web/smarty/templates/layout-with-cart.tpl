{#extends file='layout.tpl'#}
{#block name='head'#}
<script type="text/javascript" src="{#$AppPath#}/js/feature/cart.js"></script>
<script type="text/javascript" src="{#$AppPath#}/js/feature/cart-init.js"></script>
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
                {#if (isset($smarty.session['OpenID'])) #}
                    <form action="?logout" method="post">
                        <button>Logout</button>
                    </form>
                {#else#}
                    <form action="?login" method="post">
                        <button>Login with Google</button>
                    </form>
                {#/if#}
            </div>

            <div class="panel large-12 columns" id="cart">
                <h4>Cart</h4>
                <div id="cart-group-all" class='ui_accordion ui_collapsible'>
                    <div class="large-12 columns"><div class="left">all</div><div class="right"><img class="cart-button-delete" src="{#$AppPath#}/img/mimiGlyphs/51.png"/><img class="cart-button-execute"  src="{#$AppPath#}/img/mimiGlyphs/23.png"/></div></div>
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
                <div class='cart-group' data-group="<%= groupname %>">
                    <div class="large-12 columns">
                        <div class="groupname left"><%= groupname %></div>
                        <div class="right">
                            <img class="cart-button-rename" src="{#$AppPath#}/img/mimiGlyphs/39.png"/>
                            <img class="cart-button-delete" src="{#$AppPath#}/img/mimiGlyphs/51.png"/>
                            <img class="cart-button-execute" src="{#$AppPath#}/img/mimiGlyphs/23.png"/>
                        </div>
                    </div>
                    <ul class="cart-target large-12 columns">
                        <li class="placeholder">drag your items here</li>
                    </ul>
                </div>
                </script>

                <script type="text/template"  id="cart-item-template"> 
                    <li style="clear:both" class="large-12 cart-item">
                        <div class="left"><img class="cart-button-goto" src="{#$AppPath#}/img/mimiGlyphs/47.png"/> <span class="displayname">
                                <%= (item.alias !== undefined && item.alias !== '') ? item.alias : ((item.name !== undefined && item.name !== '') ? item.name : item.feature_id) %>
                            </span>
                        </div>
                        <div class="right">
                            <img class="cart-button-edit" src="{#$AppPath#}/img/mimiGlyphs/39.png"/>
                            <img class="cart-button-delete" src="{#$AppPath#}/img/mimiGlyphs/51.png"/>
                        </div>
                    </li>
                    </script>
                </div>
                <div>&nbsp;</div>
            </div>
        </div>
        {#/block#}