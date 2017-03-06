<?php

namespace Emagia\Entities;

use Emagia\Contract\ACreature;
use Emagia\Skills\BaseAttack;
use Emagia\Skills\MagicShield;
use Emagia\Skills\RapidStrike;

class Orderus extends  ACreature
{

    /**
     * Create Orderus with stats between certain ranges
     *
     * @return Orderus
     */
    static function create() {

        $healthRange = [
            'min' => 60,
            'max' => 100
        ];

        $strengthRange = [
            'min' => 70,
            'max' => 80
        ];

        $defenceRange = [
            'min' => 45,
            'max' => 55
        ];

        $speedRange = [
            'min' => 40,
            'max' => 50
        ];

        $luckRange = [
            'min' => 10,
            'max' => 30
        ];

        $hero = new Orderus();
        $hero->setHealth(rand($healthRange['min'], $healthRange['max']));
        $hero->setStrength(rand($strengthRange['min'], $strengthRange['max']));
        $hero->setDefence(rand($defenceRange['min'], $defenceRange['max']));
        $hero->setSpeed(rand($speedRange['min'], $speedRange['max']));
        $hero->setLuck(rand($luckRange['min'], $luckRange['max']));
        $hero->setName('Orderus');

        $hero->addSkill(new BaseAttack());
        $hero->addSkill(new RapidStrike());
        $hero->addSkill(new MagicShield());

        return $hero;
    }
}