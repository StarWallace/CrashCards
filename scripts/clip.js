$(document).ready( function() {
    attachClipClick();
});

function attachClipClick() {
    $(".clip").click( function() {
        clipClick($(this));
    });
}

function clipClick($el) {
    var request = $.ajax({
        type: "POST",
        url: "scripts/AJAXClipDeck.php",
        data: {
            deckid: $el.attr("deckid")
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
}