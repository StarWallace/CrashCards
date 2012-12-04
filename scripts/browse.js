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

$(".up.control, .down.control").click( function() {
    $el = $(this);
    if ($(this).hasClass("up")) {
        var upv = 1;
    } else if ($(this).hasClass("down")) {
        var upv = 0;
    }
    var deckid = $(this).parent().parent().parent().attr("deckid");
    var request = $.ajax({
        type: "POST",
        url: "scripts/AJAXSendVote.php",
        data: {
            deckid: $(this).parent().parent().parent().attr("deckid"),
            isupv: upv
        }
    });
    
    request.done( function(result) {
        var success = JSON.parse(result).success;
        if (success == "1") {
            $scores = $el.parent().parent().find(".scores")
            $scores.find(".up").html(JSON.parse(result).up);
            $scores.find(".down").html(JSON.parse(result).down);
        } else {
            $("#message").html(JSON.parse(result).message);
            $("#message").addClass("err");
        }
    });
    
    request.fail( function(result) {
        $("#message").html(JSON.parse(result).message);
        $("#message").addClass("err");
    });    
});

$(".clip").click( function() {
    $el = $(this);
    var request = $.ajax({
        type: "POST",
        url: "scripts/AJAXClipDeck.php",
        data: {
            deckid: $(this).attr("deckid")
        }
    });
    
    request.done( function(result) {
        var success = JSON.parse(result).success;
        if (success == "1") {
            $el.addClass("clipped");
        } else if (success == "2") {
            $el.removeClass("clipped");
        } else {
            $("#message").html(JSON.parse(result).message);
            $("#message").addClass("err");
        }
    });
    
    request.fail( function(result) {
        $("#message").html(JSON.parse(result).message);
        $("#message").addClass("err");
    });
});