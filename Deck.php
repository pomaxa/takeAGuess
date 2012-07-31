<?php

class Deck
{
    /**
     * @var array
     */
    private $deck;

    public function __construct($createNew = false, array $deck = array())
    {
        if ($createNew) {
            $deck = $this->generateDeck();
        } else {
            shuffle($deck);
        }

        $this->deck = $deck;

        return $deck;
    }

    public function size()
    {
        return count($this->deck);
    }

    public function generateDeck()
    {
        $deck = array(
            '2k', '2p', '2c', '2b',
            '3k', '3p', '3c', '3b',
            '4k', '4p', '4c', '4b',
            '5k', '5p', '5c', '5b',
            '6k', '6p', '6c', '6b',
            '7k', '7p', '7c', '7b',
            '8k', '8p', '8c', '8b',
            '9k', '9p', '9c', '9b',
            '10k', '10p', '10c', '10b',
            '11k', '11p', '11c', '11b', // J
            '12k', '12p', '12c', '12b', // Q
            '13k', '13p', '13c', '13b', // K
            '14k', '14p', '14c', '14b', // A
        );

        shuffle($deck);

        return $deck;
    }

    public function pick()
    {
//        return $this->deck[rand(0, count($this->deck)-1)];
        return array_shift($this->deck);
    }

    public function shuffle()
    {
        return shuffle($this->deck);
    }

    /**
     * Translate card id into image;
     * @param $card
     * @return string
     */
    public function getImage($card)
    {
        return 'http://domain.com/image-'.$card.'.png';
    }

}