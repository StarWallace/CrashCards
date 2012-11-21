<?php

    // Purely for the example

    class Browse {
    
        public function getDecks() {
            $decks = array();
            for ($i = 0; $i < 10; $i++) {
                $deck = 
                $decks[$i] = new Deck();
                $deck->creator = new User();
                $deck->creator->name = "user $i";
                $deck->creator->rating = 450 - ($i * 49);
                $deck->creator->link = "#" . $deck->creator->name;
                $deck->title = "Example Deck #$i";
                $deck->campus = "University of Saskatchewan";
                $deck->subject = "Computer Science";
                $deck->course = "CMPT 412";
                $deck->term = "Fall";
                $deck->year = 2012;
                $deck->up = 300 - ($i * 23);
                $deck->down = $i * 9;
                $deck->tags = array("social communities", "reputation mechanisms", "recommender systems", "ongoing engagement problem");
                $deck->link = "#$deck->title";
            }
            return $decks;
        }
    }
?>