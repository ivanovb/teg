<?php

namespace Emagia\Skills;


use Emagia\Utils\Dice;
use Emagia\Utils\UI;

/**
 * Class RapidStrike
 *
 * A Special attack skill. Has a chance to reexecute the BaseAttack , but only once.
 * @package Emagia\Skills
 */
class RapidStrike extends BaseAttack
{
    private $chanceToExecute = 10;
    private $hasExecutedAlready = false;

    /**
     * If it passes the roll check, then it should repeat the base attack.
     *
     * use $this->hasExecutedAlready as a guard to not execute it twice when launched from a baseattack.
     *
     * @param null $modifier
     */
    function execute($modifier = null)
    {
        if($this->hasExecutedAlready) {
            $this->hasExecutedAlready = false;
            return;
        }

        if($this->shouldExecute()) {
            UI::actionMessage("{$this->getOwner()->getName()} rapid striked {$this->getTarget()->getName()}");
            $this->hasExecutedAlready = true;
            parent::execute($modifier);
            $this->hasExecutedAlready = false;
        }

    }

    function shouldExecute()
    {
        return Dice::roll(100, $this->chanceToExecute);
    }

}