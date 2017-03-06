<?php


class BattleStageTest extends \PHPUnit\Framework\TestCase
{

    /**
     * A Strong in all stats Creature will always win against a weak in all stats Creature
     */
    public function testLuckyOrderusAlwaysWins()
    {
        $orderus = new \Emagia\Entities\Orderus();
        $orderus->setHealth(100);
        $orderus->setName('Lucky Orderus');
        $orderus->setDefence(100);
        $orderus->setLuck(100);
        $orderus->setSpeed(100);
        $orderus->setStrength(100);
        $orderus->addSkill(new \Emagia\Skills\BaseAttack());

        $tortoise = new \Emagia\Entities\Tortoise();
        $tortoise->setHealth(1);
        $tortoise->setName('Glass Tortoise');
        $tortoise->setDefence(1);
        $tortoise->setLuck(1);
        $tortoise->setSpeed(1);
        $tortoise->setStrength(1);

        $battleStage = new \Emagia\BattleStage(0);

        $battleStage->addCreature($orderus);
        $battleStage->addCreature($tortoise);

        $winner = $battleStage->init();

        $this->assertSame($orderus, $winner);
    }

    /**
     * We must have at least two players, otherwise one should beat itself up.
     */
    public function testMustHaveAtLeastTwoPlayers() {
        $orderus = new \Emagia\Entities\Orderus();
        $orderus->setHealth(100);
        $orderus->setName('Lucky Orderus');
        $orderus->setDefence(100);
        $orderus->setLuck(100);
        $orderus->setSpeed(100);
        $orderus->setStrength(100);
        $orderus->addSkill(new \Emagia\Skills\BaseAttack());

        $battleStage = new \Emagia\BattleStage(0);

        $battleStage->addCreature($orderus);

        $result = $battleStage->init();

        $this->assertSame($result, \Emagia\BattleStage::MUST_HAVE_AT_LEAST_2_PLAYERS);
    }

    /**
     * We must have at least one attack skill on the stage, otherwise the creatures will just dance around without killing anything
     */
    public function testMustExistAtLeastOneAttackSkillOnTheStage() {
        $orderus = new \Emagia\Entities\Orderus();
        $orderus->setHealth(100);
        $orderus->setName('Lucky Orderus');
        $orderus->setDefence(100);
        $orderus->setLuck(100);
        $orderus->setSpeed(100);
        $orderus->setStrength(100);

        $tortoise = new \Emagia\Entities\Tortoise();
        $tortoise->setHealth(1);
        $tortoise->setName('Glass Tortoise');
        $tortoise->setDefence(1);
        $tortoise->setLuck(1);
        $tortoise->setSpeed(1);
        $tortoise->setStrength(1);

        $battleStage = new \Emagia\BattleStage(0);

        $battleStage->addCreature($orderus);
        $battleStage->addCreature($tortoise);

        $result = $battleStage->init();

        $this->assertSame($result, \Emagia\BattleStage::MUST_HAVE_AT_LEAST_1_ATTACK_SKILL);
    }

    public function testAnyNumberOfOrderusesOnTheStage() {

        $players = [];

        $numberOfPlayers = rand(2, 100);

        for($i = 0; $i < $numberOfPlayers; $i++) {
            $player = \Emagia\Entities\Orderus::create();
            $players[] = $player;
        }

        $battleStage = new \Emagia\BattleStage(0);

        foreach ($players as $player) {
            $battleStage->addCreature($player);
        }

        $winner = $battleStage->init();

        $this->assertInstanceOf(\Emagia\Entities\Orderus::class, $winner);

    }

}