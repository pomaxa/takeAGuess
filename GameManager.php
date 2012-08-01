<?php
/**
 * Created by JetBrains PhpStorm.
 * User: pomaxa
 * Date: 8/1/12
 * Time: 11:08 AM
 * To change this template use File | Settings | File Templates.
 */
class GameManager
{

    public $uid = false;
    public $level = 1;

    public function __construct($level = 1, $uid = false)
    {
        $this->setLevel($level);
        $this->setUid($uid);

    }



    public function loadLevel($level)
    {
        switch($level)
        {
            case 1:
                return ;
            break;

        }
    }

    //hardcoded level

    public function level1()
    {
        return new GuessNextSmallerBigger($this->uid);
    }

    public function level2()
    {
        return new GuessNextColor($this->uid);
    }

    public function level3()
    {
        return new GuessNextLear($this->uid);
    }


    //getter/setter

    public function setLevel($level)
    {
        $this->level = $level;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    public function getUid()
    {
        return $this->uid;
    }

}
