<?php
/**
 * TODO: create normal unit test file.
 */

require_once '../lib/GameType.php';
require_once '../lib/Deck.php';
require_once '../lib/BaseGame.php';
require_once '../lib/GuessNextColor.php';


$game = new GuessNextColor();

echo "Start test\n\n";

echo "Cards in deck = " . $game->deck->size() . "\n\n";

while ($game->deck->size() > 0) {

    $scoreBeforeMove = $game->getScore();
    $guess = rand(0, 1) ? 'black' : 'red';
    $res = $game->takeAGuess($guess);
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
