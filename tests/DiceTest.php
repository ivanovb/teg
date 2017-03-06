<?php


class DiceTest extends \PHPUnit\Framework\TestCase
{

    public function testDice100Percent()
    {
        $diceSides = 100;
        $targetCeil = 100;

        $this->assertTrue(\Emagia\Utils\Dice::roll($diceSides, $targetCeil));
    }

}