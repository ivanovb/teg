<?php

namespace Emagia\Entities;


use Emagia\Contract\ACreature;
use Emagia\Skills\BaseAttack;

class WildBeast extends ACreature
{

    /**
     * Create a WildBeast with stats between certain ranges
     *
     * @return WildBeast
     */
    static function create() {

        $healthRange = [
            'min' => 60,
            'max' => 90
        ];

        $strengthRange = [
            'min' => 60,
            'max' => 90
        ];

        $defenceRange = [
            'min' => 40,
            'max' => 60
        ];

        $speedRange = [
            'min' => 40,
            'max' => 60
        ];

        $luckRange = [
            'min' => 25,
            'max' => 40
        ];

        $wildBeast = new WildBeast();
        $wildBeast->setHealth(rand($healthRange['min'], $healthRange['max']));
        $wildBeast->setStrength(rand($strengthRange['min'], $strengthRange['max']));
        $wildBeast->setDefence(rand($defenceRange['min'], $defenceRange['max']));
        $wildBeast->setSpeed(rand($speedRange['min'], $speedRange['max']));
        $wildBeast->setLuck(rand($luckRange['min'], $luckRange['max']));
        $wildBeast->setName('Wild Beast');

        $wildBeast->addSkill(new BaseAttack());


        return $wildBeast;
    }
}