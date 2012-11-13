$(".info-tooltip").hover(
    function() {
        $("div.tooltip").remove();
        $('<div class="tooltip"></div>').appendTo("body");
        $("div.tooltip").html($(this).attr("help"));
        $("div.tooltip").css("left", $(this).offset().left + 15);
        $("div.tooltip").css("top", $(this).offset().top);
    }, 
    function() {
        $("div.tooltip").remove();
    }
);