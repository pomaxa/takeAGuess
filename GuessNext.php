<?php
/**
 * Created by JetBrains PhpStorm.
 * User: pomaxa
 * Date: 7/31/12
 * Time: 10:56 AM
 */

require 'Cache.php';
require 'Deck.php';
Cache::initialize(array('host' => '127.0.0.1:11211', 'prefix' => 'GN_'));

abstract class GuessNext
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
        }elseif( $moreOrLess == '>=' ) {
            $return = (int)$this->settings['lastCard'] >= $newCard;
        }elseif( $moreOrLess == '<=') {
            $return = (int)$this->settings['lastCard'] <= $newCard;
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
        throw new Exception('Not implemented yet');
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


