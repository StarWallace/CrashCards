<link rel="stylesheet" type="text/css" href="wrapper/css/edit.css"/>

<div class="cardControls">
    <div class="button publishDeck">Publish</div>
    <div class="button saveDeck">Save</div>
</div>

<div class="deckInfo white">
    <div class="fields">
        <div class="column">
            <div class="row">
                <div class="label"><label for="deckTitle">Title</label></div>
                <input id="deckTitle" maxlength="25"
                       value="<?php echo isset($deck) ? $deck->title : ""; ?>"
                />
                <div class="info-tooltip" id="titleInfo"
                     help="What topic(s) will be covered in this deck? What title do you want displayed when your deck is listed in search results?"
                ></div>
            </div>
            <div class="row">
                <div class="label"><label for="deckSubject">Subject</label></div>
                <input id="deckSubject" class="hasSuggestions" maxlength="25"
                       value="<?php echo isset($deck) ? $deck->subject : ""; ?>"
                />
                <div class="info-tooltip" id="subjectInfo"
                     help="What subject does this deck best fit into?"
                ></div>
            </div>
            <div class="row">
                <div class="label"><label for="deckCourseCode">Course Code</label></div>
                <input id="deckCourseCode" class="hasSuggestions" maxlength="7"
                       value="<?php echo isset($deck) ? $deck->coursecode : ""; ?>"
                />
                <div class="info-tooltip" id="courseCodeInfo"
                     help="Which course is this deck being made for?"
                ></div>
            </div>
        </div>
        <div class="column" id="autocomplete"></div>
        <div class="column" id="message"></div>
    </div>
</div>

<br/>

<div class="cardList white" id="sortable">
    <?php
        if (isset($_GET['deckid'])) {
            $deckCards = $deck->GetDeckArray();        
            $index = 0;
            foreach ($deckCards as $card) {
                $index++;
    ?>
    
    <div class="cardRow">
        <div class="number"><?php echo $index; ?></div>
        <div class="minDisplay">
            <div>
                <div class="bold">Front</div><br/>
                <div class="cardSummary"><?php echo $card['front']; ?></div>
            </div>
            <div>
                <div class="bold">Back</div><br/>
                <div class="cardSummary"><?php echo $card['back']; ?></div>
            </div>
        </div>
        <div class="remove"></div>
    </div>
    
    <?php
            }
        } else {
    ?>
    
    <div class="cardRow">
        <div class="number">1</div>
        <div class="minDisplay">
            <div>
                <div class="bold">Front</div><br/>
                <div class="cardSummary"></div>
            </div>
            <div>
                <div class="bold">Back</div><br/>
                <div class="cardSummary"></div>
            </div>
        </div>
        <div class="remove"></div>
    </div>
    
    <?php
        }
    ?>
</div>

<div class="cardControls">
    <div class="button publishDeck">Publish</div>
    <div class="button saveDeck">Save</div>
    <div class="button" id="newCard">New Card</div>
</div>

<div id="suggestions" class="shadow"></div>


<script type="text/javascript" src="scripts/edit.js"></script>
<script type="text/javascript" src="scripts/tooltip.js"></script>
<script type="text/javascript">
    <?php
        if (isset($_GET['deckid'])) {
            echo "var deckid = " . $deck->deckid . ";";
        } else {
            echo "var deckid = 0";
        }
    ?>
</script>