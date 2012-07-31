<?php
/**
 * Game class for game type
 *  guessing Lear
 * @author pomaxa none pomaxa@gmail.com
 */
class GuessNextLear extends GuessNext
{
    /**
     * @param string $lear
     * @return bool
     */
    public function nextLear( $lear = 'k' )
    {
        $newCard = $this->pickCard();
        $mastj = substr($newCard, 0,-1);
        return ($lear == $mastj);
    }

    /**
     * @return bool
     */
    public function nextLearHearts(){
        return $this->nextLear('c');
    }

    /**
     * @return bool
     */
    public function nextLearSpades(){
        return $this->nextLear('p');
    }

    /**
     * @return bool
     */
    public function nextLearClubs(){
        return $this->nextLear('k');
    }

    /**
     * @return bool
     */
    public function nextLearDiamonds(){
        return $this->nextLear('b');
    }
}
