<?php

namespace Pmx\Game;


class GuessColor extends BaseGame
{
    /**
     * Take a guess that next card color will be $color
     * @param string $color
     * @return bool
     */
    public function takeAGuess($color = 'black')
    {
        $currentCard = $this->deck->pick();
        if ($this->debug) {
            $this->playedCards[] = $currentCard;
        }
        $suit = substr($currentCard, -1);
        if ($suit == 'k' || $suit == 'p') {
            $currentColor = 'black';
        } else {
            $currentColor = 'red';
        }
        $amIRight = ($currentColor == $color);
        if ($amIRight) {
            $this->incScoreBy(1);
        } else {
            $this->incScoreBy(-2);
        }

        return $amIRight;
    }

    /**
     * Take a guess that next card color will be Black
     */
    public function nextColorBlack()
    {
        $this->takeAGuess('black');
    }

    /**
     * Take a guess that next card color will be Red
     */
    public function nextColorRed()
    {
        $this->takeAGuess('red');
    }

}