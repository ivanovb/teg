<?php

namespace Emagia\Skills;

use Emagia\Contract\ASkill;
use Emagia\Utils\Dice;
use Emagia\Utils\SkillTypes;
use Emagia\Utils\UI;

/**
 * Class BaseAttack
 *
 * The BaseAttack of any creature. Actually the base move.
 * A Creature must have this skill attached to have any chance on the battlestage.
 *
 * @package Emagia\Skills
 */
class BaseAttack extends ASkill
{

    function getType()
    {
        return SkillTypes::ATTACK;
    }

    /**
     * compute the normal damage to be dealt
     * if the damage < 0 then damage = 0
     * execute any defending skills over the damage to be dealt and modify it accordingly
     * the target can also get lucky, and in that case the attack misses
     *
     * @param null|int $modifier
     */
    function execute($modifier = null)
    {
        $owner = $this->getOwner();
        $target = $this->getTarget();

        $originalDamageToDeal = $owner->getStrength() - $target->getDefence();

        if($originalDamageToDeal < 0 ) {
            $originalDamageToDeal = 0;
        }

        $damageToDeal = $originalDamageToDeal;

        $defenseSkills = $target->getDefenceSkills();

        foreach ($defenseSkills as $defenseSkill) {
            if(get_class($defenseSkill) != get_class($this)) {
                $defenseSkill->setOwner($target);
                $defenseSkill->setTarget($owner);
                $damageToDeal = $defenseSkill->execute($damageToDeal);
            }
        }

        if($target->isLucky()) {
            UI::actionMessage(" {$this->getTarget()->getName()} got lucky. {$this->getOwner()->getName()} missed ");
            $damageToDeal = 0;
        } else {
            UI::actionMessage(" {$this->getOwner()->getName()} hit {$this->getTarget()->getName()} for {$damageToDeal} damage");
        }

        $targetOriginalHealth = $target->getHealth();
        $targetNewHealth = $targetOriginalHealth - $damageToDeal;



        $target->setHealth($targetNewHealth);

    }

    function shouldExecute()
    {
        /**
         * the base attack should always execute.
         * here could be a simple return true,
         * but I think it's better for the future to encode now a bit of the logic that gave result true
         */
        return Dice::roll(100, 100);
    }
}