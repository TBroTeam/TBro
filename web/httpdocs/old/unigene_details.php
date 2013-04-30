<?php
$unigene = preg_match('/^[a-z0-9._]+$/i', $_REQUEST['unigene']) ? $_REQUEST['unigene'] : '1.01_comp231081_c0';
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />

        <title></title>
        <!--[if lt IE 9]><script type="text/javascript" src="http://canvasxpress.org/js/flashcanvas.js"></script><![endif]-->
        <script type="text/javascript" src="http://canvasxpress.org/js/canvasXpress.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <?php /* use chrome frame if installed and user is using IE */ ?>
        <meta http-equiv="X-UA-Compatible" content="chrome=1">
        <script type="text/javascript">
            function load_isoforms(unigene, tabs){
                var tabTemplate = "<li><a href='isoform_details.php?isoform={isoform}'>{isoform}</a></li>";
                $('#tabs > ul > li').remove();
                $('#tabs > div').remove();
                i=0;
                $.ajax({url: "../service/list/isoforms",
                    dataType: "json",
                    data: {
                        query: unigene
                    },
                    success: function(data){
                        $(data.results).each(function(index, isoform){
                            li = tabTemplate.replace( /\{isoform\}/g, isoform );
                            tabs.find( ".ui-tabs-nav" ).append( $(li) );                            
                        });
                        tabs.tabs( "refresh" );
                        tabs.tabs({ active: 0 });
                        tabs.show();
                    }
                });
            }
            
            
            $(document).ready(function() {
                unigene = '<?php echo $unigene ?>';
                console.log(unigene);
                console.log($( "#tabs" ));
                tabs = $( "#tabs" ).tabs({heightStyle: "content" });
                console.log($( "#tabs" ));
                tabs.hide();
                load_isoforms(unigene, tabs);
            
            });
            
            
            
        </script>
    </head>
    <body>
        <div id="unigene">
            <div id="tabs">
                <ul></ul>
            </div>
        </div>
    </body>
</html>
