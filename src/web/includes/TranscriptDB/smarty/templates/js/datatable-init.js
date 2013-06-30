jQuery.extend(jQuery.fn.dataTableExt.oSort, {
    "natural-asc": function(a, b) {
        return alphanum(a, b);
    },
    "natural-desc": function(a, b) {
        return alphanum(a, b) * -1;
    },
    "scientific-pre": function(a) {
        if (a == 'Inf')
            return Infinity;
        if (a == '-Inf' || a == "")
            return -Infinity;
        return parseFloat(a);
    },
    "scientific-asc": function(a, b) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },
    "scientific-desc": function(a, b) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
});

jQuery.extend(jQuery.fn.dataTable.defaults, {
    bJQueryUI: true,
    bAutoWidth: false
});

jQuery.fn.dataTableExt.aTypes.unshift(
        function(sData)
        {
            var scientificRegex = /^[0-9]*\.?[0-9]+(?:[eE]\-?[0-9]+)?$/;
            if (scientificRegex.test(sData) || sData == "" || sData == "-Infinity" || sData == "-Inf" || sData == "Infinity" || sData == "Inf")
                return ('scientific');

            return 'natural';
        }
);

jQuery.fn.dataTableExt.oApi.fnReloadAjax = function(oSettings, sNewSource, fnCallback, bStandingRedraw)
{
    if (sNewSource !== undefined && sNewSource !== null) {
        oSettings.sAjaxSource = sNewSource;
    }

    // Server-side processing should just call fnDraw
    if (oSettings.oFeatures.bServerSide) {
        this.fnDraw();
        return;
    }

    this.oApi._fnProcessingDisplay(oSettings, true);
    var that = this;
    var iStart = oSettings._iDisplayStart;
    var aData = [];

    this.oApi._fnServerParams(oSettings, aData);

    oSettings.fnServerData.call(oSettings.oInstance, oSettings.sAjaxSource, aData, function(json) {
        /* Clear the old information from the table */
        that.oApi._fnClearTable(oSettings);

        /* Got the data - add it to the table */
        var aData = (oSettings.sAjaxDataProp !== "") ?
                that.oApi._fnGetObjectDataFn(oSettings.sAjaxDataProp)(json) : json;

        for (var i = 0; i < aData.length; i++)
        {
            that.oApi._fnAddData(oSettings, aData[i]);
        }

        oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();

        that.fnDraw();

        if (bStandingRedraw === true)
        {
            oSettings._iDisplayStart = iStart;
            that.oApi._fnCalculateEnd(oSettings);
            that.fnDraw(false);
        }

        that.oApi._fnProcessingDisplay(oSettings, false);

        /* Callback user function - for event handlers etc */
        if (typeof fnCallback == 'function' && fnCallback !== null)
        {
            fnCallback(oSettings);
        }
    }, oSettings);
};

TableTools.prototype.fnGetVisibleSelectedData = function() {
    var a = [], b = this.s.dt.aoData, c, d;
    c = 0;
    for (d = b.length; c < d; c++) {
        b[c]._DTTT_selected && $(b[c].nTr).is(':visible') && a.push(this.s.dt.oInstance.fnGetData(c));
    }
    return a;
};

function metadata_tooltip_options(options) {
    return jQuery.extend({
        open: function(event, ui) {
            ui.tooltip.offset({
                top: event.pageY,
                left: event.pageX
            });
            ui.tooltip.css("max-width", "600px");
        },
        content: function() {
            var element = $(this);
            var tooltip = $("<table />");
            var metadata = element.data('metadata');
            if (metadata == null)
                return;
            $.each(metadata, function(key, val) {
                $("<tr><td>" + key + "</td><td>" + (val !== null ? val : '') + "</td></tr>").appendTo(tooltip);
            });
            tooltip.foundation();
            return tooltip;
        }
    }, options);
}
;