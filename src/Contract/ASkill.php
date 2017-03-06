<?php

namespace Emagia\Contract;

/**
 * Class ASkill
 *
 * The template for ASkill.
 *
 * By default, a Skill should have an owner and a target (when it is used)
 * A Skill should have a type, one of the constants in Emagia\Utils\SkillTypes
 *
 * The shouldExecute method should implement the chance for that skill to fire.
 * The execute method should implement the actual effect of the skill.
 *
 *
 * @package Emagia\Contract
 */
abstract class ASkill
{
    /** @var  ICreature */
    private $owner;

    /** @var  ICreature */
    private $target;

    abstract function getType();

    abstract function execute($modifier = null);

    abstract function shouldExecute();

    function setOwner(ACreature $creature) {
        $this->owner = $creature;
    }

    function setTarget(ACreature $creature) {
        $this->target = $creature;
    }

    function getOwner(): ACreature {
        return $this->owner;
    }

    function getTarget(): ACreature {
        return $this->target;
    }


}