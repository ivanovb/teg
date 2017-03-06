<?php

namespace Emagia;


use Emagia\Contract\ACreature;
use Emagia\Contract\ASkill;
use Emagia\Utils\UI;

/**
 * Class BattleStage
 *
 * The BattleStage is where the fight happens.
 * The BattleStage setups the order of the first turn, and takes care of managing the order in a queue.
 *
 * @package Emagia
 */
class BattleStage
{

    const MUST_HAVE_AT_LEAST_2_PLAYERS = '2_players_at_least';
    const MUST_HAVE_AT_LEAST_1_ATTACK_SKILL = '1_attack_skill_at_least';

    /** @var ACreature[]  */
    private $players = [];

    private $turn = 1;
    private $sleep = 1;

    /** @var ACreature[]  */
    private $losers = [];

    public function __construct($sleep = 1)
    {
        $this->sleep = $sleep;
    }

    public function addCreature(ACreature $creature) {
        $this->players[] = $creature;

    }

    /**
     * sorts the battlestage players first order of actions
     */
    private function setOrderOfPlayersInFirstRun() {

        // sort the array of players by speed, from the biggest to the smallest
        usort($this->players, [$this, 'sortBySpeedMaxToMin']);

        $originalPlayers = array_slice($this->players, 2);

        /**
         * get the first two players and order them if there is a tie between their speed.
         * if it's a tie between their speed and luck, than shuffle them.
         */
        $this->players = array_slice($this->players, 0, 2);

        $firstPlayer = $this->players[0];
        $secondPlayer = $this->players[1];

        if($firstPlayer->getSpeed() == $secondPlayer->getSpeed() ) {
            if( $firstPlayer->getLuck() != $secondPlayer->getLuck()) {
                usort($this->players, [$this, 'sortByLuckMaxToMin']);
            } else {
                shuffle($this->players);
            }
        }

        /**
         * add back the players at the tail of the list
         */
        $this->players = array_merge($this->players, $originalPlayers);
    }

    /**
     * sort Creatures by speed, descending
     *
     * @param $a
     * @param $b
     * @return int
     */
    private function sortBySpeedMaxToMin($a, $b) {
        if($a == $b) {
            return 0;
        }

        return ($a->getSpeed() < $b->getSpeed()) ? 1 : -1;
    }

    /**
     *
     * sort Creatures by luck, descending
     *
     * @param $a
     * @param $b
     * @return int
     */
    private function sortByLuckMaxToMin($a, $b) {
        if($a == $b) {
            return 0;
        }

        return ($a->getLuck() < $b->getLuck()) ? 1 : -1;
    }

    /**
     * sort Creatures by menance, descending
     *
     * @param $a
     * @param $b
     * @return int
     */
    private function sortByMenanceMaxToMin($a, $b) {
        $aMenance = $this->playerMenance($a);
        $bMenance = $this->playerMenance($b);

        if($aMenance == $bMenance) {
            return 0;
        }

        return ($aMenance < $bMenance) ? 1 : -1;
    }

    /**
     * As long as there are more than 1 player alive, it should return false.
     * Otherwise return the alive player as a winner.
     *
     * Also, it manages the losers list.
     *
     * @return bool|ACreature
     */
    private function lastOneStanding() {

        $alive = [];
        foreach ($this->players as &$player) {
            if($player->getHealth() > 0) {
                $alive[] = $player;
            } else {
                if(!in_array($player, $this->losers, true))
                {
                    $this->losers[] = $player;
                }

            }

        }

        if(count($alive) == 1) {
            return array_pop($alive);
        }

        $this->players = $alive;

        return false;
    }

    /**
     * Computes a players menance to the current creature
     * @todo find a more sophisticated formula to represent this idea. Maybe should take in account the current attacker stats.
     *
     * Menance formula: speed * health * strength
     *
     * @param ACreature $creature
     * @return int
     */
    private function playerMenance(ACreature $creature) {
        return $creature->getHealth() * $creature->getSpeed() * $creature->getStrength();
    }

    /**
     * From the pool of current players, with health bigger than 0, select the most menacing:
     * @see BattleStage::playerMenance
     *
     * @param ACreature $attacker
     */
    private function selectTargetFor(ACreature $attacker) {
        $sortedPlayersByMenance = array_diff($this->players, [$attacker]);
        usort($sortedPlayersByMenance, [$this, 'sortByMenanceMaxToMin']);
        return $sortedPlayersByMenance[0];
    }

    /**
     * The main function of the BattleStage
     *
     * @return bool|ACreature|void'
     */
    public function init()
    {

        /**
         * We need at least 2 players
         */
        if(count($this->players) < 2) {
            echo "\n\t We need at least two players \t\n";

            return BattleStage::MUST_HAVE_AT_LEAST_2_PLAYERS ;
        }

        /**
         * We need at least one creature that does damage.
         */
        $totalAttackSkills = 0;
        foreach($this->players as $player) {
            $totalAttackSkills += count($player->getAttackSkills());
        }

        if($totalAttackSkills == 0) {
            return BattleStage::MUST_HAVE_AT_LEAST_1_ATTACK_SKILL;
        }


        $this->setOrderOfPlayersInFirstRun();

        /**
         * The Main game/simulator loop .
         *
         * The attacker is the head of the player lists
         * The defender is selected based on menance property. If there are only two players, the other one becomes the defender.
         * Attack skills are executed
         * The attacker goes to the end of the players queue
         * We increase the turn number and sleep for $this->sleep seconds, by default 1 .
         *
         */
        while ( ! $this->lastOneStanding())
        {

            Utils\UI::actionMessage("Starting TURN : " . $this->turn);

            $attacker = array_shift($this->players);

            $defender = $this->selectTargetFor($attacker);

            UI::creatureStatistics($attacker);
            UI::creatureStatistics($defender);

            /** @var ASkill[] $attackSkills */
            $attackSkills = $attacker->getAttackSkills();

            foreach ($attackSkills as $attackSkill) {
                $attackSkill->setOwner($attacker);
                $attackSkill->setTarget($defender);
                if($attackSkill->shouldExecute()) {
                    $attackSkill->execute();
                }
            }

            array_push($this->players, $attacker);

            $status = [];
            foreach ($this->players as $player)
            {
                $status[] ="{$player->getName()}: {$player->getHealth()} HP" ;
            }

            UI::actionMessage(implode(" | ", $status));

            $this->turn++;

            sleep($this->sleep);

        }

        /**
         * After exiting the game loop, we have a winner.
         * Display its current stats.
         * Display a summary of the losers.
         */
        $winner = $this->lastOneStanding();

        UI::actionMessage("WINNER: " . $winner->getName());
        UI::creatureStatistics($winner);

        foreach ($this->losers as $index => $loser) {
            UI::actionMessage("LOSSER {$index}: {$loser->getName()} [{$loser->getHealth()}  HP]");
        }

        return $winner;
    }

}