<?php
/**
 * Guessing bigger/smaller will be next card
 *
 * @author pomaxa none pomaxa@gmail.com
 */
class GuessNextSmallerBigger extends GuessNext
{

    public function takeAGuess($moreOrLess = '>')
    {
        $newCard = $this->pickCard();

        if ($this->debug) {
            echo $this->lastCard() + " " . $moreOrLess . " " . $newCard . "\n";
        }

        // todo: implement score counting
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
        }

        $this->incScore($score);

        $this->saveGameSettings();

        return $return;
    }

    public function isLess()
    {
        return $this->takeAGuess('>');
    }

    public function equal()
    {
        return $this->takeAGuess('=');
    }

    public function isLessOrEq()
    {
        return $this->takeAGuess('>=');

    }

    public function isLarger()
    {
        return $this->takeAGuess('<');
    }

    public function isLargerOrEq()
    {
        return $this->takeAGuess('<=');
    }

}
