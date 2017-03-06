<?php

namespace Emagia\Contract;


use Emagia\Utils\Dice;
use Emagia\Utils\SkillTypes;

/**
 * Class ACreature
 *
 * The template for ACreature. Made abstract by design so that users should be forced to implement new kind of creatures
 *
 * @package Emagia\Contract
 */
abstract class ACreature
{

    /** @var ASkill[]  */
    private $attackSkills = [];

    /** @var ASkill[]  */
    private $defenseSkills = [];

    private $health = 1;
    private $strength = 1;
    private $defence = 1;
    private $speed = 1;
    private $luck = 1;
    private $name = '';

    function addSkill(ASkill $skill) {
        $skillType = $skill->getType();
        $skillName = get_class($skill);
        switch ($skillType) {
            case SkillTypes::ATTACK:
                $this->attackSkills[ $skillName ] = $skill;
                break;
            case SkillTypes::DEFENSE:
                $this->defenseSkills[ $skillName ] = $skill;
                break;
        }
    }

    function getSkills() {
        return array_merge($this->attackSkills, $this->defenseSkills);
    }

    function getDefenceSkills() {
        return $this->defenseSkills;
    }

    function getAttackSkills() {
        return $this->attackSkills;
    }


    /**
     * @return int
     */
    public function getHealth(): int
    {
        return $this->health;
    }

    /**
     * @param int $health
     */
    public function setHealth(int $health)
    {
        $this->health = $health;
    }

    /**
     * @return int
     */
    public function getStrength(): int
    {
        return $this->strength;
    }

    /**
     * @param int $strength
     */
    public function setStrength(int $strength)
    {
        $this->strength = $strength;
    }

    /**
     * @return int
     */
    public function getDefence(): int
    {
        return $this->defence;
    }

    /**
     * @param int $defence
     */
    public function setDefence(int $defence)
    {
        $this->defence = $defence;
    }

    /**
     * @return int
     */
    public function getSpeed(): int
    {
        return $this->speed;
    }

    /**
     * @param int $speed
     */
    public function setSpeed(int $speed)
    {
        $this->speed = $speed;
    }

    /**
     * @return int
     */
    public function getLuck(): int
    {
        return $this->luck;
    }

    /**
     * @param int $luck
     */
    public function setLuck(int $luck)
    {
        $this->luck = $luck;
    }

    public function isLucky(): bool {
        return Dice::roll(100, $this->getLuck());
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function __toString()
    {
        return 'creature::#'.spl_object_hash($this);
    }


}