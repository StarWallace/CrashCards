$(".vote").hover(
    function() {
        var index = $(".vote").index($(this));
        $(".voteControls").eq(index).show();
        $(".scores").eq(index).hide();
    },
    
    function() {
        var index = $(".vote").index($(this));
        $(".scores").eq(index).show();
        $(".voteControls").eq(index).hide();
    }
);