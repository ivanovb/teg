<?php

namespace Emagia\Utils;


class Dice
{

    /**
     *
     * Simulates percent chance, when $sides = 100 .
     *
     * @param $sides
     * @param $atLeast
     * @return bool
     */
    static public function roll($sides, $atLeast) {
        $roll = rand(1, $sides);

        if($roll <= $atLeast) {
            return true;
        }

        return false;
    }
}