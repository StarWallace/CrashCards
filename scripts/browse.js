var browseIndex = 10;
    
function loadBrowseList(more, subject, coursecode, year, sort, index) {
    if (subject == null) {
        subject = $("#subject option:selected").val();
    }
    if (coursecode == null) {
        coursecode = $("#courseCode option:selected").val();
    }
    if (year == null) {
        year = $("#year option:selected").val();
    }
    if (sort == null) {
        sort = $("#sortOrder option:selected").val();
    }
    if (index == null) {
        index = browseIndex;
    }
    var request = $.ajax({
        url: "scripts/AJAXBrowse.php",
        data: {
            subject: subject != "" ? subject : null,
            coursecode: coursecode != "" ? coursecode : null,
            year: year != "" ? year : null,
            sort: sort,
            index: index
        }
    });
    
    request.done( function(result) {
        if (result == "") {
            $("#moreResults").html("No More Results");
        } else {
            if (more) {
                $("#deckList").append(result);
            } else {
                $("#deckList").html(result);
            }
            
            // From vote.js
            attachVoteHover();
            attachVoteClick();
            
            // From clip.js
            attachClipClick();
            
            browseIndex += 10;
        }
    });
}

$("#browseNav select").change( function() {
    $("#moreResults").html("More Results");
    browseIndex = 0;
    loadBrowseList();
});

$("#moreResults").click( function() {
    loadBrowseList(true);
});