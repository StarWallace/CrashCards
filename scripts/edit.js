var enableRemove = true;
var events = new Object();

events.remove = function(event) {
    event.stopPropagation();
    if (enableRemove) {
        enableRemove = false;
        $(this).parent().makeInactive();
        var $target = $(this).parent();
        $target.slideUp( function() {
            $target.remove();
            renumberList();
            if ($(".cardRow").size() > 1) {
                enableRemove = true;
                $(".cardRow").mousemove( function() {
                    $(this).find(".remove").show();
                    $(".cardRow").unbind("mousemove");
                });
            }
        });
    }
};

events.selectCard = function() {
    if (!$(this).hasClass("selected")) {
        makeAllInactive();
        $(this).makeActive();
    }
}

events.enterCard = function() {
    if (enableRemove) {
        
        $(this).find(".remove").show();
    }
}

events.leaveCard = function() {
    $(this).find(".remove").hide();
}

$.fn.makeActive = function() {
    $(this).addClass("selected");
    var $front = $(this).find(".cardSummary").first();
    var $back = $(this).find(".cardSummary").eq(1);
    var frontText = $front.html();
    var backText = $back.html();
    $front.html("<textarea>" + frontText + "</textarea>");
    $back.html("<textarea>" + backText + "</textarea>");
    return $(this);
}

$.fn.makeInactive = function() {
    $(this).removeClass("selected");
    $(this).find(".cardSummary").eq(0).html($(this).find(".cardSummary").eq(0).find("textarea").first().val());
    $(this).find(".cardSummary").eq(1).html($(this).find(".cardSummary").eq(1).find("textarea").first().val());
    return $(this);
}

$.fn.cardCreate = function() {
    $(this).appendTo($(".cardList").first()).hide();
    $(this).hover(events.enterCard, events.leaveCard);
    $(this).click(events.selectCard);
    $(this).find(".remove").click(events.remove);
    return $(this);
}

// Make cardList element sortable
$(function() {
    $("#sortable").sortable({
        axis: "y",
        cursor: "move",
        placeholder: "placeholder",
        scroll: true,
        scrollSensitivity: 100,
        tolerance: 200,
        opacity: 0.7,
        stop: function() {
            renumberList();
        }
    });
});

// Other initialization
$(function() {
    // If there are less than 2 cards, don't allow user to remove remaining card
    if ($("#sortable").children().size() < 2) {
        enableRemove = false;
        $(".remove").hide();
    }
    
    // Make the first card active
    $(".cardRow").first().makeActive();
});

$(".cardRow").hover(events.enterCard, events.leaveCard);
$(".cardRow").click(events.selectCard);
$(".remove").click(events.remove);

$("#newCard").click( function() {
    addNewCard();
});

$(".saveDeck").click( function() {
    saveDeck();
});

$(".publishDeck").click( function() {
    publishDeck();
});

function renumberList() {
    $("#sortable").children().each( function() {
        $(this).find(".number").html($(this).index() + 1);
    });
    if ($("#sortable").children().size() > 1) {
        enableRemove = true;
    } else {
        enableRemove = false;
    }
}

function makeAllInactive() {
    $(".selected").makeInactive();
}

function addNewCard() {
    $(  '<div class="cardRow">' +
            '<div class="number">4</div>' +
            '<div class="minDisplay">' +
                '<div>' +
                    '<div class="bold">Front</div><br/>' +
                    '<div class="cardSummary"></div>' +
                '</div>' +
                '<div>' +
                    '<div class="bold">Back</div><br/>' +
                    '<div class="cardSummary"></div>' +
                '</div>' +
            '</div>' +
            '<div class="remove"></div>' +
        '</div>'
    ).cardCreate().slideDown( function() {
        makeAllInactive();
        $(this).makeActive();
    });
    renumberList();
}

function saveDeck() {
    makeAllInactive();
    var selector = ".cardSummary";
    $xml = $("<xml></xml>");
    $deck = $("<deck></deck>");
    
    $(".cardRow").each( function() {
        $front = $("<front>" + $(this).find(selector).eq(0).html() + "</front>");
        $back = $("<back>" + $(this).find(selector).eq(1).html() + "</back>");
        $card = $("<card></card>");
        $card.append($front).append($back);
        $deck.append($card);
    });
    
    $xml.append($deck);
    
    var request = $.ajax({
        type: "POST",
        url: "scripts/AJAXDeckSave.php",
        data: {
            // deckid
            title: $("#deckTitle").val(),
            coursecode: $("#deckCourseCode").val(),
            subject: $("#deckSubject").val(),
            cardcount: $(".cardRow").last().find(".number").html(),
            xml: $xml.html()
        }
    });
    
    request.done( function(msg) {
        $("#message").html(msg);
    });
    
    request.fail( function(msg) {
        $("#message").html(msg);
    });
}

function publishDeck() {
    // Save Deck
    saveDeck();
    
    // Publish Deck
    var request = $.ajax({
        type: "POST",
        url: "scripts/AJAXDeckPublish.php",
        data: {
            // deckid
        }
    });
    
    // Redirect to Manage screen
    window.location.href = "manage.php";
}