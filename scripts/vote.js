var browseIndex = 10;

$(document).ready( function() {
    attachVoteClick();
});

function attachVoteClick() {
    $(".up.control, .down.control").click( function() {
        voteClick($(this));
    });
}

function voteClick($el) {
    if ($el.hasClass("up")) {
        var upv = 1;
    } else if ($el.hasClass("down")) {
        var upv = 0;
    }
    var deckid = $el.parent().parent().attr("deckid");
    var request = $.ajax({
        type: "POST",
        url: "scripts/AJAXSendVote.php",
        data: {
            deckid: $el.parent().parent().attr("deckid"),
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
}