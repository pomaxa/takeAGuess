<?php
require_once 'GuessNext.php';

/**
 * Game class to be called to serve users
 * @author pomaxa none <pomaxa@gmail.com>
 */
class Game extends GuessNextSmallerBigger
{
    /**
     * Save scores from current game into DB;
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
}
