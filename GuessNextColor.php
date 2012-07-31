<?php
/**
 * Guessing only color; Black/Red.
 *
 * @author pomaxa none pomaxa@gmail.com
 */
class GuessNextColor extends GuessNext
{
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

    public function nextColorBlack(){
        $this->nextColor('black');
    }

    public function nextColorRed(){
        $this->nextColor('red');
    }

}
