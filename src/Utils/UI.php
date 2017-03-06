<?php

namespace Emagia\Utils;

use Emagia\Contract\ACreature;

class UI
{
    const border = "*";

    static public function actionMessage($message)
    {
        echo  "\n" . str_pad(" $message ", 80, UI::border, STR_PAD_BOTH) . "\n" . "\n";
    }

    static public function creatureStatistics(ACreature $owner)
    {

        echo "\n";
        echo  str_repeat(UI::border, 80) . "\n";
        echo  str_pad(" {$owner->getName()} ", 80, UI::border, STR_PAD_BOTH) . "\n";
        echo  str_pad(" Health: ". $owner->getHealth() . " | Defence: ". $owner->getDefence() . " ", 80, UI::border, STR_PAD_BOTH) . "\n";
        echo  str_pad(" Strength: ". $owner->getStrength() . " | Speed: ". $owner->getSpeed() . " | Luck: ". $owner->getLuck(). " ", 80, UI::border, STR_PAD_BOTH) . "\n";
        echo  str_repeat(UI::border, 80) . "\n";
        echo "\n";

    }


}