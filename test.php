<?php
/**
 * Created by JetBrains PhpStorm.
 * User: pomaxa
 * Date: 7/31/12
 * Time: 11:08 AM
 * To change this template use File | Settings | File Templates.
 */

require 'GuessNext.php';


if( FALSE == Cache::get(123455) ) {
    $g = new Game();
}
else {
    $g = new Game(123455);
}




$deck = $g->settings['deck'];

if( $deck instanceof Deck)
    echo "Current deck size: ". $deck->size() . "\n\n";
else
    echo "New game";


echo "Current Card is: ".$g->settings['lastCard']."\n\n";



echo "Next card g:" . $g->isLess() ."\n\n";
