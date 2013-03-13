{#extends file='layout.tpl'#}
{#block name='head'#}
<!--[if lt IE 9]><script type="text/javascript" src="http://canvasxpress.org/js/flashcanvas.js"></script><![endif]-->
<script type="text/javascript" src="http://canvasxpress.org/js/canvasXpress.min.js"></script>
<?php /* use chrome frame if installed and user is using IE */ ?>
<meta http-equiv="X-UA-Compatible" content="chrome=1">
{#/block#}
{#block name='body'#}
<div class="row">
    <div class="large-12 columns">
        <h1 class="docs header"><a href="http://foundation.zurb.com/docs/">Foundation 4 Documentation</a></h1>
        <h6 class="docs subheader"><a href="http://foundation.zurb.com/old-docs/f3">Want F3 Docs?</a></h6>
        <hr>
    </div>
</div>

<div class="row">
    <div class="large-12 columns">
        <div class="section-container tabs" data-section>
            <section class="section">
                <p class="title"><a href="#">Section 1</a></p>
                <div class="content">
                    <p>Content of section 1.</p>
                </div>
            </section>
            <section class="section">
                <p class="title"><a href="#">Section 2</a></p>
                <div class="content">
                    <p>Content of section 2.</p>
                </div>
            </section>
        </div>

        &nbsp;asd
    </div>
</div>
{#/block#}