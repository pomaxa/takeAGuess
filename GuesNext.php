<?php
/**
 * Created by JetBrains PhpStorm.
 * User: pomaxa
 * Date: 7/31/12
 * Time: 10:56 AM
 */

require 'Cache.php';
Cache::initialize(array('host' => '127.0.0.1:11211', 'prefix' => 'GN_'));

class GuesNext
{
    public $debug = false;
    public $isGameOver = false;
    public $settings =array();

    public function  __construct($uid = false)
    {
        if($uid) {
            $this->settings = $this->loadGameSettings($uid);
        } else {
            $this->settings = $this->newGameSettings();
        }
    }

    public function isLess()
    {
        return $this->takeAGuess('>');

    }

    public function isLarger()
    {
        return $this->takeAGuess('<');
    }

    public function takeAGuess($moreOrLess = '>')
    {
        $deck = $this->settings['deck'];

        if($deck->size() < 1) {
            echo "GAME OVER";
            Cache::delete($this->settings['uid']);
            throw new Exception('No more cards');
            exit;

        }

        /** @var $deck Deck */
        $newCard = $deck->pick();

        if($this->debug)
        {
            echo $this->settings['lastCard'] + " " . $moreOrLess . " " . $newCard . "\n";
        }

        // todo: implement score counting
        if ( $moreOrLess == '>') {
            $return = (int)$this->settings['lastCard'] > $newCard;
        } elseif ( $moreOrLess == '<' ) {
            $return = (int)$this->settings['lastCard'] < $newCard;
        } else {
            throw new Exception('Ebatj kolotitj');
        }

        $this->settings['lastCard'] = $newCard;

        if(!$return) {
            $this->isGameOver = true;
            $this->dropGameSettings($this->settings['uid']);
        }else {
            $this->saveGameSettings();
        }

        return $return;
    }

    public function getScores()
    {

    }

    private function createUid()
    {
        return rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
    }

    private function loadGameSettings($uid)
    {
        return unserialize(Cache::get($uid));
    }

    private function dropGameSettings($uid)
    {
        Cache::delete($uid);
    }

    private function saveGameSettings()
    {
        Cache::set($this->settings['uid'], serialize($this->settings));
    }


    private function newGameSettings()
    {
        $newDeck = new Deck(true);
        $firstCard = $newDeck->pick();

        return array(
            'uid' => 123455,
            'deck' => $newDeck,
            'step' => 1,
            'score' => 0,
            'lastCard' => $firstCard
        );
    }

}


class Deck
{
    private $deck;

    public function __construct($createNew = false, array $deck = array())
    {
        if($createNew) {
            $deck = $this->generateDeck();
        } else {
            //
            shuffle($deck);
        }

        $this->deck = $deck;

        return $deck;
    }

    public function size() {
        return count($this->deck);
    }

    public function generateDeck()
    {
        $deck = array(
            '2k','2p','2c', '2b',
            '3k','3p','3c', '3b',
            '4k','4p','4c', '4b',
            '5k','5p','5c', '5b',
            '6k','6p','6c', '6b',
            '7k','7p','7c', '7b',
            '8k','8p','8c', '8b',
            '9k','9p','9c', '9b',
            '10k','10p','10c', '10b',
            '11k','11p','11c', '11b', // J
            '12k','12p','12c', '12b', // Q
            '13k','13p','13c', '13b', // K
            '14k','14p','14c', '14b', // A
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

}