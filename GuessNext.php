<?php

require 'Cache.php';
require 'Deck.php';
Cache::initialize(array('host' => '127.0.0.1:11211', 'prefix' => 'GN_'));

/**
 * Main game class
 * * * * * * * * * * * * *
 * Include basic settings management
 * Deck manipulation
 * game status saver
 *
 * @author pomaxa none pomaxa@gmail.com
 */
abstract class GuessNext
{
    public $debug = false;
    public $gameOver = false;
    public $settings =array();
    /** @var Deck */
    protected $deck;

    /**
     * @param bool $uid
     */
    public function  __construct($uid = false)
    {
        if($uid) {
            $this->settings = $this->loadGameSettings($uid);
        } else {
            $this->settings = $this->newGameSettings();
            $this->saveGameSettings();
        }
    }

    /**
     * Get card from deck;
     * @return string card key;
     */
    protected function pickCard()
    {
        $deck = $this->settings['deck'];
        if($deck->size() < 1) {
            $this->gameOver = true;
        }
        /** @var $deck Deck */
        return $deck->pick();
    }

    public function incScore($by =1 )
    {
        return $this->settings['score'] = $this->settings['score'] + $by;
    }

    public function getScores()
    {
        return $this->settings['score'];
    }

    /**
     * Generate unique game ID;
     * @return string
     */
    protected function createUid()
    {
        //TODO:: change to better uid generation
        return rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
    }

    /**
     * Load game settings by uid;
     * @param $uid
     * @return mixed
     */
    protected function loadGameSettings($uid)
    {
        return unserialize(Cache::get($uid));
    }

    /**
     * Drop all game data for $uid
     * @param $uid
     */
    protected function dropGameSettings($uid)
    {
        Cache::delete($uid);
    }

    /**
     * Save game settings by uid in $this->settings
     */
    protected function saveGameSettings()
    {
        Cache::set($this->settings['uid'], serialize($this->settings));
    }

    /**
     * New game data preparation;
     * @return array
     */
    private function newGameSettings($maxMistakesCount = 51)
    {
        $newDeck = new Deck(true);
        $firstCard = $newDeck->pick();

        return array(
            'uid' => $this->createUid(),
            'deck' => $newDeck,
            'step' => 1,
            'score' => 0,
            'lastCard' => $firstCard,
            'mistakes' => 0,

            //not used yet.

            //rules of game
            'maxMistakesCount'=>$maxMistakesCount, //before game over; TODO: implement
            'gameType' => 'SmallerBigger', //todo: list possible values, and factory
            'player_id' => 'anonymous', // todo: implement per player stats
            'deckStyle' => 'default', //todo: define css used to show cards.

        );
    }

    /**
     * Last card setter
     * @param string $card
     * @return string
     */
    protected function setLastCard($card) {
        return $this->settings['lastCard'] = $card;
    }

    /**
     * Last card getter
     * @return string
     */
    public function lastCard()
    {
        return $this->settings['lastCard'];
    }

    /**
     * Card in deck (for current moment)
     * @return int
     */
    public function cardsLeft()
    {
        if($this->settings['deck'] instanceof Deck) {
            return $this->settings['deck']->size();
        } else {
            //TODO: throw error at this point?
            return 0;
        }
    }

    /**
     * Game ID getter
     * @return mixed
     */
    public function gameId()
    {
        return $this->settings['uid'];
    }

    /**
     * Check if game is over
     * @return bool
     */
    public function isGameOver()
    {
        return $this->gameOver;
    }

    /**
     * Save game scores;
     * @param string $name
     * @return bool
     */
    public function saveScores($name = 'Anonymous')
    {
        //todo: save data into db;

        $top = Cache::get('top');
        if($top !== FALSE) {
            $top = unserialize($top);
        }else {
            $top = array();
        }
        $top[$this->getScores()] = $name;
        return Cache::set('top', serialize($top), 3600*24*120);
    }

    /**
     * Get top from DB
     * @return array|bool|mixed
     */
    public function loadScores()
    {
        $top = Cache::get('top');
        if($top !== FALSE) {
            $top = unserialize($top);
        }else {
            $top = array();
        }

        return $top;
    }

    /**
     * Inc mistakes counter and return it value
     * @return int
     */
    public function addMistake()
    {
        $this->settings['mistakes']++;

        if($this->getMistakesCount() >= $this->getMaxMistakes()){
            $this->gameOver = true;
        }

        return $this->settings['mistakes'];
    }

    public function getMistakesCount()
    {
        return $this->settings['mistakes'];
    }

    public function getMaxMistakes()
    {
        return $this->settings['maxMistakesCount'];
    }

}


