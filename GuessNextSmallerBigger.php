<?php
/**
 * Guessing bigger/smaller will be next card
 *
 * @author pomaxa none pomaxa@gmail.com
 */
class GuessNextSmallerBigger extends GuessNext
{
    /**
     * Take a guess that next card is $moreOrLess
     * @param string $moreOrLess
     * @return bool
     * @throws Exception
     */
    public function takeAGuess($moreOrLess = '>')
    {
        $newCard = $this->pickCard();

        if ($moreOrLess == '>') {
            $score = 3;
            $return = (int)$this->lastCard() > $newCard;
        } elseif ($moreOrLess == '<') {
            $score = 3;
            $return = (int)$this->lastCard() < $newCard;
        } elseif ($moreOrLess == '>=') {
            $score = 2;
            $return = (int)$this->lastCard() >= $newCard;
        } elseif ($moreOrLess == '<=') {
            $score = 2;
            $return = (int)$this->lastCard() <= $newCard;
        } elseif ($moreOrLess == '=') {
            $score = 4;
            $return = (int)$this->lastCard() == $newCard;
        } else {
            throw new Exception('Ebatj kolotitj');
        }

        $this->setLastCard($newCard);
        if (!$return) {
            $score = -4;
            $this->addMistake();
        }

        if( $this->isGameOver() ) {
            //todo: implement game-over behavior
        }

        $this->incScore($score);
        $this->saveGameSettings();

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

}
