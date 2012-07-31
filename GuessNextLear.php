<?php
/**
 * Game class for game type
 *  guessing Lear
 * @author pomaxa none pomaxa@gmail.com
 */
class GuessNextLear extends GuessNext
{
    public function nextLear( $lear = 'k' )
    {
        $newCard = $this->pickCard();
        $mastj = substr($newCard, 0,-1);
        return ($lear == $mastj);
    }

    public function nextLearHearts(){
        $this->nextLear('c');
    }

    public function nextLearSpades(){
        $this->nextLear('p');
    }
    public function nextLearClubs(){
        $this->nextLear('k');
    }
    public function nextLearDiamonds(){
        $this->nextLear('b');
    }
}
