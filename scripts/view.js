
// Global variables
var deck;
var properties;

// Execute when page is ready
$(document).ready( function() {
    createDeck();
    initializeFields();
});

// Initialize some fields and set variables
function initializeFields() {
    $(".question").html(deck.cards[deck.currentIndex].question);
    $("#deckSize").html(deck.size);
    properties = new Object();
    properties.oldShadow = $(".card").first().css("boxShadow");
}

// Create deck object
function createDeck() {

    // Will need a JavaScript function to AJAX some XML file to load as new deck
    
    // These are all standard values (unless we want to load user's last/best score from database)
    deck = new Object();
    deck.currentIndex = 0;
    deck.relativeIndex = 0;
    deck.numberCorrect = 0;
    deck.lastScore = 0;
    deck.bestScore = -1;
    
    // These will depend on deck passed from AJAX
    deck.cards = new Array();
    deck.size = 4;

    // This is just for testing/example purposes
    for (var i = 0; i < deck.size; i++) {
        deck.cards[i] = new Object();
        deck.cards[i].question = "Question " + (i + 1);
        deck.cards[i].answer = "Answer " + (i + 1);
        deck.cards[i].done = false;
    }
    deck.notDoneCount = deck.size;
    deck.unshown = deck.cards;
}

// Flip card from question to answer
function flip() {
    $(".card").flippy({
        content: $(".card").html(),
        duration: 500,
        depth: 0.08,
        light: 50,
        onStart: function() {
            hideCardShadow();
            showCheckX();
        },
        onFinish: function() {
            showCardShadow();
            showAnswer();
        }
    });
}

// Slide out current card and slide in next
function next() {
    showFlipButton();
    
    $(".card").animate(
        { left: "-100%" },
        250,
        function() {
            $(".card").css('left', '150%');
            doUpdate();
        }
    );
    $(".card").animate(
        { left: '0%' },
        250
    );
}

// Check for right or wrong
// Increment deck index
// Handle end of deck
function doUpdate() {
    if ($("#checkMark").hasClass("selected")) {
        updateCorrect();
    } else {
        updateIncorrect();
    }
    updateScore();
    
    deck.relativeIndex++;
    do {
        deck.currentIndex++;
    } while (deck.currentIndex < deck.notDoneCount && deck.cards[deck.currentIndex].done)
    
    // End of deck?
    if (deck.relativeIndex >= deck.notDoneCount) {
        updateHistory();
        
        if (document.getElementById("repeatUntilPerfect").checked) {
            if (deck.numberCorrect == deck.notDoneCount) {
                alert("YOU GOT THEM ALL RIGHT!");
                cleanUp();
            } else {
                resetDeck();
                showNextQuestion();
            }
        } else {
            alert("You're done. Final score: " + $("#score").html());
            cleanUp();
        }
    } else {        
        showNextQuestion();
    }
}

// Increase number correct
// Remove current card from next round (if enabled)
function updateCorrect() {
    deck.numberCorrect++;
    if (!document.getElementById("repeatCorrect").checked) {
        deck.cards[deck.currentIndex].done = true;
    }
}

function updateIncorrect() {

}

// Prepare the deck for a new run-through
function cleanUp() {
    initializeDeck();
    updateScore();
    showNextQuestion();
}

// Update score
function updateScore() {
    $("#score").html(percentFormat(deck.numberCorrect / (deck.relativeIndex + 1)));
}

// Set last and best scores
function updateHistory() {
    deck.lastScore = deck.numberCorrect / (deck.relativeIndex);
    $("#bestScoreLabel, #lastScoreLabel").show();
    $("#lastScore").html($("#score").html());
    if (deck.lastScore > deck.bestScore) {
        $("#bestScore").html($("#score").html());
        deck.bestScore = deck.lastScore;
    }
}

// Start again from the beginning, take out any cards I don't need anymore
function resetDeck() {
    resetVars();
    while (deck.cards[deck.currentIndex].done) {
        deck.currentIndex++;
    }
    var count = 0;
    for (var i = 0; i < deck.size; i++) {
        if (!deck.cards[i].done) {
            count++;
        }
    }
    deck.notDoneCount = count;
    $("#deckSize").html(deck.notDoneCount);
}

// Competely done; set up the deck as though I am reloading the page
function initializeDeck() {
    resetVars();
    for (var i = 0; i < deck.size; i++) {
        deck.cards[i].done = false;
    }
    deck.notDoneCount = deck.size;
    $("#deckSize").html(deck.size);
}

// Reset some deck variables
function resetVars() {
    deck.relativeIndex = 0;
    deck.currentIndex = 0;
    deck.numberCorrect = 0;
    $("#score").html("0%");
}

// Hide the flip button and show the check and X
function showCheckX() {
    $("#flip").hide("slide", { direction: "left" }, 200,
        function() {
            $("#xMark, #checkMark").removeClass("selected");
            $("#xMark").show("slide", { direction: "right" }, 200);
            $("#checkMark").show("slide", { direction: "right" }, 400);
        }
    );
}

// Hide the check and X and show the flip button
function showFlipButton() {
    $("#checkMark").hide("slide", { direction: "left" }, 200,
        function() {
            $("#flip").show("slide", { direction: "right" }, 400);
        });
    $("#xMark").hide("slide", { direction: "left" }, 200);
}

// Remove the card's shadow at start of flip
function hideCardShadow() {
    $(".card").animate({
        boxShadow: '0 0 0px #aaaaaa'
    }, 50);    
}

// Restore the card's shadow at end of flip
function showCardShadow() {
    $(".card").animate({
        boxShadow: properties.oldShadow
    }, 100);
}

// Display answer on card
function showAnswer() {
    $(".question").hide();
    $(".answer").html(deck.cards[deck.currentIndex].answer);
    $(".answer").show();
}

// Display next question on card
function showNextQuestion() {
    $(".answer").hide();
    $(".question").html(deck.cards[deck.currentIndex].question);
    $(".question").show();
    $("#currentIndex").html(deck.relativeIndex + 1);
}

// Check/X toggle handler
$(".viewDeck").find(".controlBar").find(".control:not(#flip)").click( function() {
    $(this).toggleClass("selected");
    next();
});

// Flip button click handler
$("#flip").click(flip);

// Random Order checkbox change handler
$("#randomOrder").change( function() {
    if (document.getElementById("randomOrder").checked) {
        // Randomize order of unshown cards
        
    }
});

// Repeat Until Perfect checkbox change handler
$("#repeatUntilPerfect").change( function() {
    if (document.getElementById("repeatUntilPerfect").checked) {
        $("#repeatCorrectDiv").show();
    } else {
        document.getElementById("repeatCorrect").checked = false;
        $("#repeatCorrectDiv").hide();
    }
});

// Convert a decimal number into whole number percentage format
function percentFormat(n) {
    return (Math.round(100*n)/100) * 100 + "%";
}