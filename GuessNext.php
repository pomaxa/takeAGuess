<?php
/**
 * Main game class
 * * * * * * * * * * * * *
 * Include basic settings management
 * Deck manipulation
 * game status saver
 *
 * @author pomaxa none pomaxa@gmail.com
 */
require 'Cache.php';
require 'Deck.php';
Cache::initialize(array('host' => '127.0.0.1:11211', 'prefix' => 'GN_'));

abstract class GuessNext
{
    public $debug = false;
    public $gameOver = false;
    public $settings =array();
    /** @var Deck */
    protected $deck;

    public function  __construct($uid = false)
    {
        if($uid) {
            $this->settings = $this->loadGameSettings($uid);
        } else {
            $this->settings = $this->newGameSettings();
            $this->saveGameSettings();
        }
    }

    protected function pickCard()
    {
        $deck = $this->settings['deck'];
        if($deck->size() < 1) {
            $this->gameOver = true;
        }
        /** @var $deck Deck */
        return $deck->pick();
    }

    public function takeAGuess($moreOrLess = '>')
    {
        $newCard = $this->pickCard();

        if($this->debug)
        {
            echo $this->lastCard() + " " . $moreOrLess . " " . $newCard . "\n";
        }

        // todo: implement score counting
        if ( $moreOrLess == '>') {
            $score = 3;
            $return = (int)$this->lastCard() > $newCard;
        } elseif ( $moreOrLess == '<' ) {
            $score = 3;
            $return = (int)$this->lastCard() < $newCard;
        }elseif( $moreOrLess == '>=' ) {
            $score = 2;
            $return = (int)$this->lastCard() >= $newCard;
        }elseif( $moreOrLess == '<=') {
            $score = 2;
            $return = (int)$this->lastCard() <= $newCard;
        }elseif( $moreOrLess == '=') {
            $score = 4;
            $return = (int)$this->lastCard() == $newCard;
        } else {
            throw new Exception('Ebatj kolotitj');
        }

        $this->setLastCard($newCard);

        if(!$return) {
            $score = -4;
        }

        $this->incScore($score);

        $this->saveGameSettings();

        return $return;
    }

    public function incScore($by =1 )
    {
        return $this->settings['score'] = $this->settings['score'] + $by;
    }

    public function getScores()
    {
        return $this->settings['score'];
    }

    protected function createUid()
    {
        return rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
    }

    protected function loadGameSettings($uid)
    {
        return unserialize(Cache::get($uid));
    }

    protected function dropGameSettings($uid)
    {
        Cache::delete($uid);
    }

    protected function saveGameSettings()
    {
        Cache::set($this->settings['uid'], serialize($this->settings));
    }


    private function newGameSettings()
    {
        $newDeck = new Deck(true);
        $firstCard = $newDeck->pick();

        return array(
            'uid' => $this->createUid(),
            'deck' => $newDeck,
            'step' => 1,
            'score' => 0,
            'lastCard' => $firstCard,
        );
    }

    protected function setLastCard($card) {
        return $this->settings['lastCard'] = $card;
    }
    public function lastCard()
    {
        return $this->settings['lastCard'];
    }

    public function cardsLeft()
    {
        if($this->settings['deck'] instanceof Deck)
            return $this->settings['deck']->size();
        else
            return 0;
    }

    public function gameId()
    {
        return $this->settings['uid'];
    }
    public function isGameOver()
    {
        return $this->gameOver;
    }
}


