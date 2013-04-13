{#extends file='layout.tpl'#}
{#block name='head'#}
{#call_webservice path="cart/getitems" data=["query1"=>$cartname] assign='cartitems'#}
<!--[if lt IE 9]><script type="text/javascript" src="http://canvasxpress.org/js/flashcanvas.js"></script><![endif]-->
<script type="text/javascript" src="http://canvasxpress.org/js/canvasXpress.min.js"></script>
<!-- use chrome frame if installed and user is using IE -->
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<script type="text/javascript">
    var filterdata;

    
    function arr_intersect(a1,a2){
        var ret = [];
        $.each(a1, function(){
            var a = this;
            $.each(a2, function(){
                if (_.isEqual(this, a)){
                    ret.push(this);
                    return false; //jquery break;
                }
            });
        });
        return ret;
    }
    
    $(document).ready(function(){
        $('#filters').tooltip({
            items: "option",
            open: function(event, ui) {
                ui.tooltip.offset({top: event.pageY, left: event.pageX});
                ui.tooltip.css("max-width", "600px");
            },
            content: function() {
                var element = $(this);
                var tooltip = $("<table />");
                $.each(element.data('metadata'),function(key, val){
                    $("<tr><td>"+key+"</td><td>"+(val!==null?val:'')+"</td></tr>").appendTo(tooltip);
                });
                tooltip.foundation();
                return tooltip;
            }
        });
        
        var uniquenames = [];
        
        var select_element = $('#select-elements');
        var select_assay = $('#select-assay');
        var select_analysis = $('#select-analysis');
        var select_tissues = $('#select-tissues');
        
        
        var cartitems = {#$cartitems|json_encode#};
        
        $.each(cartitems, function(){
            var item = this;
            uniquenames.push(item.uniquename);
            var displayname = (item.alias != undefined) ? item.alias : item.uniquename;
            $('<option />').
                text(displayname).
                val(item.uniquename).
                data('metadata', item).
                attr('selected','selected').
                appendTo(select_element);
        });
        
        $.ajax('{#$ServicePath#}/listing/filters/', {
            method: 'post',
            data: {uniquenames: uniquenames},
            success: function(data) {
                filterdata = data;
                select_element.click();
            }
        });
        
        function getSelectedArr(){
            var selected = select_element.find(':selected');
            var ret = [];
            selected.each(function(){
                ret.push(this.val);
            });
            return ret;
        }
        
        select_element.click(function() {
            var selected = select_element.find(':selected');
            
            var currently_selected = {
                elements: getSelectedArr()
            };
            
            var last_selected = $(this).data('last-selected');
            if (_.isEqual(currently_selected, last_selected))
                return;
            
            var intersection = [];
            selected.each(function(){
                var this_assays = filterdata.assay[$(this).data('metadata').uniquename];
                if (intersection.length===0){
                    intersection = this_assays;
                } else {
                    intersection = arr_intersect(intersection, this_assays);
                }
            });
        
            select_assay.empty();
            $.each(intersection, function() {
                var opt = $("<option/>").val(this.name).text(this.name).data('metadata', this);
                opt.appendTo(select_assay);
            });
            
            $(this).data('last-selected', currently_selected);
            
            select_assay.find('option').first().attr('selected','selected');
            select_assay.click();
        });
        
        select_assay.click(function() {
            var assay = $(this).val();
            var selected = select_element.find(':selected');
            var currently_selected = {
                assay: assay, 
                elements: getSelectedArr()
            };
            
            var last_selected = $(this).data('last-selected');
            if (_.isEqual(currently_selected, last_selected))
                return;
                
            var intersection = [];
            selected.each(function(){
                var this_analysises = filterdata.analysis[$(this).data('metadata').uniquename][assay];
                if (intersection.length===0){
                    intersection = this_analysises;
                } else {
                    intersection = arr_intersect(intersection, this_analysises);
                }
            });
                
            select_analysis.empty();

            $.each(intersection, function() {
                var opt = $("<option/>").val(this.id).text(this.name).data('metadata', this);
                opt.appendTo(select_analysis);
            });

            $(this).data('last-selected', currently_selected);
            
            select_analysis.find('option').first().attr('selected','selected');
            select_analysis.click();
        });

        select_analysis.click(function() {
            var analysis = $(this).val();
            var selected = select_element.find(':selected');
            var assay = select_assay.val();
            var currently_selected = {
                assay: assay, 
                analysis: analysis, 
                elements: getSelectedArr()
            };
            
            var last_selected = $(this).data('last-selected');
            if (_.isEqual(currently_selected, last_selected))
                return;
            
               
            var intersection = [];
            selected.each(function(){
                var this_tissues = filterdata.biomaterial[$(this).data('metadata').uniquename][analysis][assay];
                if (intersection.length===0){
                    intersection = this_tissues;
                } else {
                    intersection = arr_intersect(intersection, this_tissues);
                }
            });
                
            select_tissues.empty();

            $.each(intersection, function() {
                var opt = $("<option/>").val(this.name).text(this.name).data('metadata', this).attr('selected','selected');
                opt.appendTo(select_tissues);
            });

            $(this).data('last-selected', currently_selected);
        });
        
        
        function getFilterData(){
            var data = {parents:[], analysis:[], assay:[], biomaterial:[]};
            select_element.find(':selected').each(function(){
                data.parents.push($(this).val());
            });
            data.analysis.push(select_analysis.find(':selected').val());
            data.assay.push(select_assay.find(':selected').val());
            select_tissues.find(':selected').each(function(){
                data.biomaterial.push($(this).val());
            });
            return data;
        }
        
        $('#button-barplot').click(function(){
            
            $.ajax('{#$ServicePath#}/graphs/barplot/quantifications', {
                data: getFilterData(),
                success: function(val) {
                    $('#isoform-barplot-panel').show(0);
                    var parent = $("#isoform-barplot-canvas-parent");
                   
                    //if we already have an old canvas, we have to clean that up first
                    var canvas = $('#isoform-barplot-canvas');
                    var cx=canvas.data('canvasxpress');
                    if (cx != null){
                        cx.destroy();
                        parent.empty();
                    }
                    
                    canvas = $('<canvas id="isoform-barplot-canvas"></canvas>');
                    parent.append(canvas);
                    canvas.attr('width', parent.width() - 8);
                    canvas.attr('height', 500);
                    
                    window.location.hash="isoform-barplot-panel";
                    

                    cx = new CanvasXpress(
                    "isoform-barplot-canvas", 
                    {
                        "x": val.x,
                        "y": val.y
                    },
                    {
                        "graphType": "Bar",
                        "showDataValues": true,
                        "graphOrientation": "vertical"
                    });
                    
                    canvas.data('canvasxpress', cx);
                }
            });
            return false;
        });
        
        $('#button-heatmap').click(function(){
            $.ajax('{#$ServicePath#}/graphs/barplot/quantifications', {
                data: getFilterData(),
                success: function(val) {
                    $('#isoform-barplot-panel').show(0);
                    var parent = $("#isoform-barplot-canvas-parent");
                   
                    //if we already have an old canvas, we have to clean that up first
                    var canvas = $('#isoform-barplot-canvas');
                    var cx=canvas.data('canvasxpress');
                    if (cx != null){
                        cx.destroy();
                        parent.empty();
                    }
                    
                    canvas = $('<canvas id="isoform-barplot-canvas"></canvas>');
                    parent.append(canvas);
                    canvas.attr('width', parent.width() - 8);
                    canvas.attr('height', 500);
                    
                    window.location.hash="isoform-barplot-panel";
                    

                    cx = new CanvasXpress(
                    "isoform-barplot-canvas", 
                    {
                        "x": val.x,
                        "y": val.y
                    },
                    {
                        "graphType": "Heatmap",
                        "showDataValues": true,
                        "graphOrientation": "vertical"
                    });
                    
                    canvas.data('canvasxpress', cx);
                }
            });
            return false;
        });

        $('#isoform-barplot-groupByTissues').click(function(){
            var checkbox = $(this);
            var cx=$('#isoform-barplot-canvas').data('canvasxpress');
            if (checkbox.is(':checked')){
                cx.groupSamples(["Tissue_Group"]);
            } else {
                cx.groupSamples([]);
            }
        });

        
    });
</script>
{#/block#}
{#block name='body'#}

<div class="row">
    <div class="large-12 columns">
        <h2>Graph View</h2>
    </div>
</div>

<div class="row">
    <div class="large-3 columns">
        <h4>Elements</h4>
    </div>
    <div class="large-3 columns">
        <h4>Assay</h4>
    </div>
    <div class="large-3 columns">
        <h4>Analysis</h4>
    </div>
    <div class="large-3 columns">
        <h4>Tissues</h4>
    </div>
</div>

<form id="filters">
    <div class="row">
        <div class="large-3 columns panel">
            <select id="select-elements" size="12" multiple="multiple"></select>
        </div>
        <div class="large-3 columns panel">
            <select id="select-assay" size="12"></select>
        </div>
        <div class="large-3 columns panel">
            <select id="select-analysis" size="12"></select>
        </div>
        <div class="large-3 columns panel">
            <select id="select-tissues" size="12" multiple="multiple"></select>
        </div>
    </div>
    <div class="row large-12 columns panel">
        <button type="button" id="button-barplot" value="barplot">Barplot</button>
        <button type="button" id="button-heatmap" value="heatmap">Heatmap</button>
    </div>
</form>
<div class="row" id="isoform-barplot-panel" name="isoform-barplot-panel" style="display:none">
    <div class="large-12 columns panel">
        <div class="row">
            <div class="large-12 columns">
                <div style="width:100%" id="isoform-barplot-canvas-parent">
                </div>
                <input type="checkbox" id="isoform-barplot-groupByTissues"/><label style="display:inline-block" for="isoform-barplot-groupByTissues"> &nbsp;Pool by Tissue Group</label>

            </div>
        </div>
    </div>
</div-->

{#/block#}