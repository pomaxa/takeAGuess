<?php
/**
 * Guessing only color; Black/Red.
 *
 * @author pomaxa none pomaxa@gmail.com
 */
class GuessNextColor extends BaseGame
{
    /**
     * Take a guess that next card color will be $color
     * @param string $color
     * @return bool
     */
    public function takeAGuess($color = 'black')
    {
        $currentCard = $this->deck->pick();
        if($this->debug) {
            $this->playedCards[] = $currentCard;
        }
        $mastj = substr($currentCard, -1);
        if($mastj == 'k' || $mastj == 'p') {
            $currentColor = 'black';
        }else {
            $currentColor = 'red';
        }



        $amIRight =  ($currentColor == $color);
        if($amIRight) { $this->incScoreBy(1);}
        else { $this->incScoreBy(-2); }
        return $amIRight;
    }

    /**
     * Take a guess that next card color will be Black
     */
    public function nextColorBlack(){
        $this->takeAGuess('black');
    }

    /**
     * Take a guess that next card color will be Red
     */
    public function nextColorRed(){
        $this->takeAGuess('red');
    }

}
