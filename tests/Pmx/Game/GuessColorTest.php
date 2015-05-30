<?php

namespace Pmx\Game;


class GuessColorTest extends \PHPUnit_Framework_TestCase
{
    public function testScoreCalculation()
    {

        $game = new GuessColor();

        $deck = clone $game->getDeck();
        $c = $deck->pick();
        $color = in_array(substr($c, -1), array('k', 'p')) ? 'black' : 'red';

        $result = $game->takeAGuess($color);
        self::assertTrue($result);
    }

}