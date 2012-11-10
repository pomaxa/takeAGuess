<?php
/**
 * @author: pomaxa none <pomaxa@gmail.com>
 */
class BaseGame
{
    /** @var bigint uid */
    public $uniqueGameId;

    /** @var string  */
    public $gameType = GameType::GUESS_COLOR;
    /** @var Deck */
    public $deck;

    protected $score;

    /** @var bool */
    public $gameOver = false;


    /** debug */
    public $debug = 4;
    public $playedCards = array();

    public function __construct($uniqueGameId = null)
    {
            $this->init($uniqueGameId);
    }

    public function init($uniqueId)
    {
        if(!empty($uniqueGameId)){
            //todo: connect to the data storage
            // and get all the params by uniqueGameId

            $this->deck = array();
            $this->score = 100;
            $this->playedCards = array();

        }else {
            $this->deck = new Deck();
            $this->score =0;
            $this->uniqueGameId = uniqid();
        }

    }


    /** base rules */

    public function takeAGuess()
    {

    }

    protected function updateScore($score)
    {
        $this->score = $score;
    }

    public function incScoreBy($x = 1)
    {
        $this->score = $this->score + $x;
    }

    /** end of base rules */



    /** overall functions */

    public function getScore()
    {
        return $this->score;
    }


    /** debug functions */
    public function getListOfPlayerCards() {
        return $this->playedCards;
    }

    public function getDeck() {
        return $this->deck;
    }

    /**
     *
     */
    public function __destruct()
    {
        if($this->gameOver) {
            //todo: clear all
        }else {
            //todo: persist state.
        }
    }
}
