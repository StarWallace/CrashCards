$(".dismiss.close").click( function() {
    $("#tutorial").slideUp(1000, "easeInOutBack");
    if (document.getElementById("dismissManageTutorial").checked) {
        // Remember not to show tutorial to this user again
        // AJAX
    }
});

$(".publish").click( function() {
    modifyDeck("AJAXDeckPublish.php", $(this).attr("deckid"));
});

$(".removeCard.createdDeck").click( function() {
    modifyDeck("AJAXDeckDelete.php", $(this).attr("deckid"));
});

$(".removeCard.clippedDeck").click( function() {
    modifyDeck("AJAXDeckUnclip.php", $(this).attr("deckid"));
});

function modifyDeck(resource, deckid) {
    var request = $.ajax({
        type: "POST",
        url: "scripts/" + resource,
        data: {
            deckid: deckid
        }
    });
    
    request.done( function(result) {
        if (JSON.parse(result).success == "1") {
            // Redirect to Manage screen
            window.location.href = "manage.php";
        } else {
            $("#message").html(JSON.parse(result).message);
        }
    });
}
