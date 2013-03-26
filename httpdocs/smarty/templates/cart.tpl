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
        $("#cart-group-all").accordion({
            collapsible: true,
            heightStyle: "content"
        });

        cart.rebuildDOM({#$kickoff_cart['cart']|json_encode#});
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
</style>

<div class=" panel large-12 columns">
    <h4>Cart</h4>
    <div id="cart-group-all" class='ui_accordion ui_collapsible'>
        <div class="large-12 columns"><div class="left">all</div><div class="right"><img src="{#$AppPath#}/img/mimiGlyphs/23.png"/></div></div>
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
        <li data-uniquename="#uniquename#" style="clear:both" class="large-12 cart-item">
            <div class="left">#uniquename#</div>
            <div class="right">
                <img class="cart-button-delete" src="{#$AppPath#}/img/mimiGlyphs/51.png"/>
            </div>
        </li>
    </ul>
</div>