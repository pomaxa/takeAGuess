<?php
/**
 * Guessing only color; Black/Red.
 *
 * @author pomaxa none pomaxa@gmail.com
 */
class GuessNextColor extends GuessNext
{
    /**
     * Take a guess that next card color will be $color
     * @param string $color
     * @return bool
     */
    public function nextColor( $color = 'black')
    {
        $newCard = $this->pickCard();
        $mastj = substr($newCard, 0,-1);
        if($mastj == 'k' || $mastj == 'p') {
            $currColor = 'black';
        }else {
            $currColor = 'red';
        }

        return ($currColor == $color);
    }

    /**
     * Take a guess that next card color will be Black
     */
    public function nextColorBlack(){
        $this->nextColor('black');
    }

    /**
     * Take a guess that next card color will be Red
     */
    public function nextColorRed(){
        $this->nextColor('red');
    }

}
