<?php
/**
 * Created by PhpStorm.
 * User: rsvecs
 * Date: 5/29/15
 * Time: 9:40 PM
 */

namespace Pmx\Card;


class DeckTest extends \PHPUnit_Framework_TestCase
{

    public function testCardsCount()
    {
        $deck = new Deck();
        self::assertTrue($deck instanceof Deck);
        self::assertTrue($deck->size() == 52);
        $pickedCard = $deck->pick();
        self::assertTrue($deck->size() == 51);
        self::assertEquals($deck->cardsLeft(), $deck->size());

        $deck->shuffle();
        self::assertTrue($deck->size() == 51);
        while($card = $deck->pick()) {
            self::assertFalse($pickedCard == $card);
        }
        self::assertTrue($deck->size() === 0);
    }
}