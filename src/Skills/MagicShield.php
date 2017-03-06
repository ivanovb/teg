<?php

namespace Emagia\Skills;


use Emagia\Contract\ASkill;
use Emagia\Utils\Dice;
use Emagia\Utils\SkillTypes;
use Emagia\Utils\UI;

/**
 * Class MagicShield
 *
 * The basic defense skill.
 * @package Emagia\Skills
 */
class MagicShield extends ASkill
{

    private $chanceToExecute = 20;

    function getType()
    {
        return SkillTypes::DEFENSE;
    }

    /**
     * Takes only half of the damage to be dealt by the attacker (in the $modifier)
     * @param null|int $modifier
     * @return float|int
     */
    function execute($modifier = null)
    {
        $halfDamage = $modifier / 2;
        UI::actionMessage("{$this->getOwner()->getName()} used magic shield on {$this->getTarget()->getName()} , halfing the damage to: {$halfDamage}");
        return $halfDamage;
    }

    function shouldExecute()
    {
        return Dice::roll(100, $this->chanceToExecute);
    }
}