<?php
/**
 * TODO: create normal unit test file.
 */

require_once '../lib/GameType.php';
require_once '../lib/Deck.php';
require_once '../lib/BaseGame.php';
require_once '../lib/GuessNextSmallerBigger.php';


$game = new GuessNextSmallerBigger();

echo "Start test\n\n";

echo "Cards in deck = " . $game->deck->size() . "\n\n";

$card = $game->pickACard();

echo "Init card: $card\n";

while ($game->deck->size() > 0) {

    $scoreBeforeMove = $game->getScore();

    $guess = mt_rand(1, 3);

    switch($guess) {
        case 1:
            $res = $game->isLargerOrEq();
            $guess = 'isLargerOrEqual';
            break;
        case 2:
            $res = $game->equal();
            $guess = 'isEqual';
            break;
        case 3:
            $res = $game->isLessOrEq();
            $guess = 'isLessOrEq';
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

    echo " - Answer:".$listOfPlayedCards[count($listOfPlayedCards) - 1]." $guess " . $listOfPlayedCards[count($listOfPlayedCards) - 2] ." =  $text  \n";

}
echo "-------------------------------------\n";
echo "Total score: ".$game->getScore();
