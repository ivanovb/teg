Running the simulator
=====================

Required PHP v7.0+

From the command line, use start.php to see a simulation

    $ php start.php

Defining a new Skill
=====================

You can extend an existing concrete Skill or the abstract class in `Emagia\Contract\ASkill` .

A Skill
 * must have a type: defense or attack [ `Emagia\Utils\SkillTypes` ] 
 * must implement `shouldExecute` abstract method . This method should implement the chance of firing the skill. A 'chance engine' is implemented in `Emagia\Utils\Dice::roll`
 * must implement the `execute($modifier)` function. The `$modifier` represents the damage projected untill now by the attacker.
 * has always access to owner `getOwner(): ACreature`  instance and to the current enemy `getTarget(): ACreature` instance
 

Defining a new Creature
=======================

To define a new creature you should use the `Emagia\Entities` namespace and extend the `Emagia\Contract\ACreature` abstract class. 

After extending the base class I recommend using a factory method to create different varieties of that type of Creature. 

In the create factory method, use the `addSkill` to add a new instance of a skill to that creature. If you want to creature to deal any kind of damage, you must at least add the `Emagia\Skills\BaseAttack` skill.


Adding Creatures to the BattleStage
===================================

In the `start.php` file in the root directory, you can add as many creatures as you want, before `init`ing the `BattleStage` . See the `tortoise` example.


The BattleStage Phases
======================

The BattleStage runs in a few stages, in the following order:

 * it sorts descending in place the turn order of the creatures, first by speed, then by luck, and then random.
 * a game loop starts checking to see if only one last creature is standing (health > 0), and removes any other players with health <= 0
 * the first item in the list of the sorted players list becomes the first attacker
 * to select the defender from the list of players, the selectTargetFor function is used. At the moment a crude strategy is implemented, where the most probable target will become the one with the biggest speed and health and strength
 * the attackers attack skills and the defenders defence skills run accordingly to their chance of execution
 * the attacker goes to the end of the list
 
 
 Ideas & to dos
 ===============
 1. setup the UI through a notify / observer pattern and use dependency injection (through setters) to decouple the UI from the code
 2. add experience gaining to creatures
 3. allow creatures to be controlled from the keyboard [ skill selection ]
 4. add more unit tests