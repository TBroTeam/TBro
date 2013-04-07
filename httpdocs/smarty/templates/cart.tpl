{#call_webservice path="cart/sync" data=[] assign='kickoff_cart'#}

<script type="text/javascript">
    function buildTestCart() {
        cart.resetCart({sync: true});
        cart.addGroup();
        cart.addItemToAll({uniquename: '1.01_comp231081_c0_seq1'});
        cart.addItemToAll({uniquename: '1.01_comp231081_c0_seq1'});
        cart.addItemToAll({uniquename: '1.01_comp231123_c0_seq1'});
        cart.addItemToAll({uniquename: '1.01_comp2381_c0_seq1'});
        cart.addGroup();
        cart.renameGroup('group 1', 'myGroup!');
        cart.addItemToGroup({uniquename: '1.01_comp2381_c0_seq1'}, 'myGroup!');
        cart.addItemToGroup({uniquename: '1.01_comp231123_c0_seq1'}, 'myGroup!');
        cart.removeItemFromAll({uniquename: '1.01_comp2381_c0_seq1'});
    }

    $(document).ready(function() {

        $("#dialog-rename-cart-group").dialog({
            autoOpen: false,
            height: 300,
            width: 350,
            modal: true,
            buttons: {
                "rename cart": function() {
                    var oldname = $(this).data('oldname');
                    var newname = $('#cartname').val();
                    var retval = cart.renameGroup(oldname, newname);
                    if (retval != null)
                        alert(retval);
                    $(this).dialog("close");
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            },
            open: function() {
                var oldname = $(this).data('oldname');
                $('#cartname').val(oldname);
            }
        });


        $("#dialog-edit-cart-item").dialog({
            autoOpen: false,
            height: 500,
            width: 500,
            modal: true,
            buttons: {
                "save changes": function() {
                    var oldname = $(this).data('oldname');
                    var newname = $('#cartname').val();
                    var retval = cart.renameGroup(oldname, newname);
                    if (retval != null)
                        alert(retval);
                    $(this).dialog("close");
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            },
            open: function() {
                var uniquename = $(this).data('uniquename');
                var alias = $(this).data('alias');
                var annotations = $(this).data('annotations');
                $('#item-uniquename').val(uniquename);
                $('#item-alias').val(alias);
                $('#item-annotations').val(annotations);
            }
        });

        $("#cart-group-all").accordion({
            collapsible: true,
            heightStyle: "content"
        }).find('.cart-button-execute').click(function(event) {
            event.stopPropagation();
            alert('not implemented yet.');
        });

        cart.rebuildDOM({#$kickoff_cart['cart']|json_encode#}, true);
                setInterval(cart.checkRegularly, 5000); //sync over tabs if neccessary

        //buildTestCart();

    });
</script>
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
<div style="display: none">
    <div id="dialog-rename-cart-group" title="rename cart">
        <form>
            <fieldset>
                <label for="cartname">cart name</label>
                <input type="text" name="name" id="cartname" class="text ui-widget-content ui-corner-all" />
            </fieldset>
        </form>
    </div>

    <div id="dialog-edit-cart-item" title="edit item">
        <form>
            <fieldset>
                <label for="item-uniquename">uniquename</label>
                <input type="text" name="uniquename" id="item-uniquename" disabled="disabled" class="text ui-widget-content ui-corner-all" />
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

<div class="panel large-12 columns">
    <h4>Cart</h4>
    <div id="cart-group-all" class='ui_accordion ui_collapsible'>
        <div class="large-12 columns"><div class="left">all</div><div class="right"><img class="cart-button-execute"  src="{#$AppPath#}/img/mimiGlyphs/23.png"/></div></div>
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

<div style="display: none">
    <div id="cart-group-dummy"> 
        <div class='cart-group' data-group="#groupname#">
            <div class="large-12 columns">
                <div class="groupname left">#groupname#</div>
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
    </div>

    <ul id="cart-item-dummy"> 
        <li style="clear:both" class="large-12 cart-item">
            <div class="left"><img class="cart-button-goto" src="{#$AppPath#}/img/mimiGlyphs/47.png"/> <span class="displayname"></span></div>
            <div class="right">
                <img class="cart-button-edit" src="{#$AppPath#}/img/mimiGlyphs/39.png"/>
                <img class="cart-button-delete" src="{#$AppPath#}/img/mimiGlyphs/51.png"/>
            </div>
        </li>
    </ul>
</div>

