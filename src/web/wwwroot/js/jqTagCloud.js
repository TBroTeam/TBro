jQuery.fn.jqTagCloud = function(options) {
    options = options || {};

    this.each(function () {
        var input = this;
        new jQuery.jqTagCloud(input, options);
    });

    return this;
}

jQuery.jqTagCloud = function (input, options) {
    var tagCount = [];
    var maxValue, minValue = 0;

    if (!options.maxSize) 
        options.maxSize = 30; //default

    if (!options.minSize) 
        options.minSize = 12; //default

    var tagElements = $(input).find('a');
  
    $(tagElements).each(function () {
        var count = $(this).attr('count');

        if (count && !isNaN(count))
            tagCount.push(parseInt(count));      
    });
   
    if (tagCount.length > 0) {

        tagCount.sort(numOrdDescending);  //sort

        maxValue = tagCount[0];
        minValue = tagCount[tagCount.length - 1];

        $(tagElements).each(function () {
            var count = $(this).attr('count');

            if (count && !isNaN(count)) {
                if (count == minValue) {
                    $(this).css('font-size', options.minSize + "px");
                }
                else {
                    var percent = ((count - minValue) / (maxValue - minValue)) * 100;
                    var fontSize = parseInt((options.maxSize * percent) / 100);

                    if (fontSize < options.minSize)
                        fontSize = options.minSize;

                    $(this).css('font-size', fontSize + "px");
                }
            }
        });
    }

    function numOrdDescending(a, b) {
        return (b - a);
    } 
}