<?php
/**
 * Main game class to manage game types;
 * @author pomaxa none <pomaxa@gmail.com>
 */
class GameManager
{

    public $uid = false;
    public $level = 1;
    /**
     * @var GuessNextColor|GuessNextLear|GuessNextSmallerBigger
     */
    public $game;

    public function __construct($level = 1, $uid = false)
    {
        $this->setUid($uid);
        $this->game = $this->loadLevel($level);
        $this->uid = $this->game->gameId();
    }


    /**
     * @param string|int $level type of game to use
     * @return GuessNextColor|GuessNextLear|GuessNextSmallerBigger
     * @throws Exception
     */
    public function loadLevel($level)
    {
        $this->setLevel($level);
        switch($this->getLevel())
        {
            case 1:
            case 'smallerbigger':
                $class = new GuessNextSmallerBigger($this->uid);
            break;

            case 2:
            case 'lear':
                $class = new GuessNextLear($this->uid);
            break;

            case 3:
            case 'color':
                $class = new GuessNextColor($this->uid);
            break;

            default:
                throw new Exception('some shit happend in level loader');
        }

        return $class;
    }


    /**
     * @param $level
     */
    public function setLevel($level)
    {
        $this->level = strtolower($level);//just in case
    }

    /**
     * @return int|str
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return bool
     */
    public function getUid()
    {
        return $this->uid;
    }

}
