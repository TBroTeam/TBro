<?php
$isoform = preg_match('/^[a-z0-9._]+$/i', $_REQUEST['isoform']) ? $_REQUEST['isoform'] : '1.01_comp231081_c0_seq1';
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
            var isoform='<?php echo $isoform ?>';
            
            $(document).ready(function() {
                $.ajax('../../service/graphs/genome/isoform/'+isoform, {
                    success: function(val){
                            new CanvasXpress(
                        "canvas1", 
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
            
            });
            
            
            
        </script>
    </head>
    <body>
        <div>
            <canvas id="canvas1"  width="1200" height="500" style="display:block;clear:both"></canvas>
        </div>
        <div style="clear:both">&nbsp;</div>
    </body>
</html>
