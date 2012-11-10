<?php
/**
 * Game class for game type
 *  guessing Lear
 * @author pomaxa none pomaxa@gmail.com
 */
class GuessNextLear extends BaseGame
{
    /**
     * @param string $lear
     * @return bool
     */
    public function nextLear( $lear = 'k' )
    {
        $currentCard = $this->deck->pick();


        if($this->debug) {
            $this->playedCards[] = $currentCard;
        }

        $currentLear = substr($currentCard, -1);
        $amIRight = ($lear == $currentLear);

        if($amIRight) { $this->incScoreBy(1);}
        else { $this->incScoreBy(-2); }

        return $amIRight;
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
