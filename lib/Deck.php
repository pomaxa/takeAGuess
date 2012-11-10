<?php
/**
 * Deck manipulation class
 * @author pomaxa none <pomaxa@gmail.com>
 */
class Deck
{
    /** @var array */
    public $deck;

    /**
     * @param array $deck
     */
    public function __construct(array $deck = array())
    {
        if (empty($deck)) {
            $this->generateDeck();
        }
        return $this;
    }

    /**
     * @return int
     */
    public function size()
    {
        return count($this->deck);
    }

    /**
     * @return int
     */
    public function cardsLeft()
    {
        return $this->size();
    }

    /**
     * Create Standard 52 cards Deck.
     * @return array
     */
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
        $this->deck = $deck;
        return $this;
    }

    /**
     * Get card(key) from deck
     * @return string
     */
    public function pick()
    {
        return array_shift($this->deck);
    }

    /**
     * Shuffle deck
     * @return bool
     */
    public function shuffle()
    {
        return shuffle($this->deck);
    }

    /**
     * @param string $cardKey | must be one char
     * @param string $lang | two letters code
     * @return string
     * @throws Exception
     */
    public function translateCard($cardKey, $lang = 'en'){
        if($lang != 'en') {
            throw new Exception('Ahtung, for now we have translation only for "EN" lang');
        }

        $translations = array(
            'en' => array(
                'k' => 'Clubs',
                'p' => 'Spades',
                'c' => 'Hearts',
                'b' => 'Diamonds'
            )
        );
        if(isset($translations[$lang][$cardKey])){
            return $translations[$lang][$cardKey];
        }else {
            throw new Exception('There is no such color in deck... ');
        }
    }

    public function getDeck()
    {
        return $this->deck;
    }
}