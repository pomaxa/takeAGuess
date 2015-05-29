<?php

namespace Pmx\Game;


use Pmx\Exception\Bug;
use Pmx\Exception\GameOver;

class MoreOrLess extends BaseGame
{
    /**
     * Take a guess that next card is $moreOrLess
     * @param string $moreOrLess
     * @return bool
     * @throws Bug
     * @throws GameOver
     */
    public function takeAGuess($moreOrLess = '>')
    {
        $lastCard = $this->lastCard();
        $currentCard = $this->pickACard();
        if ($moreOrLess == '>') {
            $score = 3;
            $return = (int)$lastCard > $currentCard;
        } elseif ($moreOrLess == '<') {
            $score = 3;
            $return = (int)$lastCard < $currentCard;
        } elseif ($moreOrLess == '>=') {
            $score = 2;
            $return = (int)$lastCard >= $currentCard;
        } elseif ($moreOrLess == '<=') {
            $score = 2;
            $return = (int)$lastCard <= $currentCard;
        } elseif ($moreOrLess == '=') {
            $score = 4;
            $return = (int)$lastCard == $currentCard;
        } else {
            throw new Bug('Ebatj kolotitj');
        }
        if (!$return) {
            $score = -4;
        }
        if( $this->gameOver ) {
            throw new GameOver();
        }
        $this->incScoreBy($score);
        return $return;
    }
    /**
     * @return bool
     */
    public function isLess()
    {
        return $this->takeAGuess('>');
    }
    /**
     * @return bool
     */
    public function equal()
    {
        return $this->takeAGuess('=');
    }
    /**
     * @return bool
     */
    public function isLessOrEq()
    {
        return $this->takeAGuess('>=');
    }
    /**
     * @return bool
     */
    public function isLarger()
    {
        return $this->takeAGuess('<');
    }
    /**
     * @return bool
     */
    public function isLargerOrEq()
    {
        return $this->takeAGuess('<=');
    }
    public function lastCard()
    {
        return $this->playedCards[count($this->playedCards)-1];
    }
    public function pickACard()
    {
        $card = $this->deck->pick();
        $this->playedCards[] = $card;
        return $card;
    }
}