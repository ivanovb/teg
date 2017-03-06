<?php

namespace Emagia\Entities;

use Emagia\Contract\ACreature;
use Emagia\Skills\BaseAttack;
use Emagia\Skills\MagicShield;

class Tortoise extends ACreature
{

    /**
     * Create a Tortoise. It has a magic shield, it's healthy but not very strong, nor speedy
     *
     * @return Tortoise
     */
    static function create() {

        $healthRange = [
            'min' => 80,
            'max' => 100
        ];

        $strengthRange = [
            'min' => 5,
            'max' => 10
        ];

        $defenceRange = [
            'min' => 55,
            'max' => 60
        ];

        $speedRange = [
            'min' => 10,
            'max' => 20
        ];

        $luckRange = [
            'min' => 10,
            'max' => 30
        ];

        $tortoise = new Tortoise();
        $tortoise->setHealth(rand($healthRange['min'], $healthRange['max']));
        $tortoise->setStrength(rand($strengthRange['min'], $strengthRange['max']));
        $tortoise->setDefence(rand($defenceRange['min'], $defenceRange['max']));
        $tortoise->setSpeed(rand($speedRange['min'], $speedRange['max']));
        $tortoise->setLuck(rand($luckRange['min'], $luckRange['max']));
        $tortoise->setName('Tortoise');

         $tortoise->addSkill(new MagicShield());
         $tortoise->addSkill(new BaseAttack());

        return $tortoise;
    }
}