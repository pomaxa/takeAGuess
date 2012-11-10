<?php
/**
 * TODO: create normal unit test file.
 */

require_once '../lib/GameType.php';
require_once '../lib/Deck.php';
require_once '../lib/BaseGame.php';
require_once '../lib/GuessNextLear.php';


$game = new GuessNextLear();

echo "Start test\n\n";

echo "Cards in deck = " . $game->deck->size() . "\n\n";

while ($game->deck->size() > 0) {

    $scoreBeforeMove = $game->getScore();

    $guess = mt_rand(1, 4);

    switch($guess) {
        case 1:
            $res = $game->nextLearClubs();
            $guess = 'Clubs';
            break;
        case 2:
            $res = $game->nextLearDiamonds();
            $guess = 'Diamonds';
            break;
        case 3:
            $res = $game->nextLearHearts();
            $guess = 'Hearts';
            break;
        case 4:
            $res = $game->nextLearSpades();
            $guess = 'Spades';
            break;
    }

    if ($res) {
        $text = 'OK';
        if ($scoreBeforeMove > $game->getScore()) {
            echo "Error in scores calculations\n";
            echo "Was $scoreBeforeMove, and now: ". $game->getScore()."\n";
        }
    } else {
        $text = 'WRONG';
        if ($scoreBeforeMove < $game->getScore()) {
            echo "Error in scores calculations";
            echo "Was $scoreBeforeMove, and now: ". $game->getScore()."\n";
        }
    }

    $listOfPlayedCards = $game->getListOfPlayerCards();

    echo " - Answer: $guess | $text | " . $listOfPlayedCards[count($listOfPlayedCards) - 1] . "\n";

}
echo "-------------------------------------\n";
echo "Total score: ".$game->getScore();
