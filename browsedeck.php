<div class="browseItem" deckid="<?php echo $deck['deckid']; ?>">
    <div class="vote">
        <div class="scores">
            <div class="up score">
                <?php echo $deck['upv']; ?>
            </div>
            <div class="down score">
                <?php echo $deck['dnv']; ?>
            </div>
        </div>
        <div class="voteControls">
            <div class="up control"></div>
            <div class="down control"></div>
        </div>
    </div>
    <div class="deckTag">
        <a href="<?php echo "view.php?deckid=" . $deck['deckid']; ?>">
            <div class="halfRow link">
                <div class="title corner-spaced">
                    <?php echo $deck['title']; ?>
                </div>
            </div>
        </a>
        <div class="halfRow">
            <div class="info">
                <br/>
                <?php echo $deck['subject'] . " - " . $deck['coursecode'] . " - " . substr($deck['tstamp'], 0, 4); ?>
            </div>
        </div>
    </div>
    <div class="userTag">
        <a href="<?php echo "#"; ?>">
            <div id="userName" class="halfRow link corner-spaced">
                <div class="bold">
                    <?php echo $user->GetDisplayName(); ?>
                </div>
            </div>
        </a>
    </div>
    <div class="clip<?php echo $deck['clipped'] == "1" ? " clipped" : "";?>" deckid="<?php echo $deck['deckid']; ?>"></div>
</div>