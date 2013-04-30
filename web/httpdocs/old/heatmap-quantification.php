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
            $(document).ready(function() {
                $.ajax('/httpdocs/service/graphs/heatmap/quantifications', {
                    data: { parents: ['1.01_comp103625_c0', '1.01_comp100136_c0','1.01_comp10031_c0'] },
                    success: function(val){
                        new CanvasXpress(
                        "canvas1", 
                        {
                            "y": val.y,
                            "t": val.t
                        },
                        {
                            "graphType": "Heatmap",
                            "showDataValues": true,
                            "varDendrogramPosition": "bottom",
                            "indicatorCenter": "rainbow",
                            "heatmapType": "green-red",
                            "showVarDendrogram": true,
                            "showSmpDendrogram": true
                        }
                    );
                    }
                });
            
            });
            
            
            
        </script>
    </head>
    <body>
        <canvas id="canvas1"  width="613" height="500"></canvas>
    </body>
</html>
