$(".dismiss.close").click( function() {
    $("#tutorial").slideUp(1000, "easeInOutBack");
    if (document.getElementById("dismissManageTutorial").checked) {
        // Remember not to show tutorial to this user again
        // AJAX
    }
});