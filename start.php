<?php

require 'vendor/autoload.php';

// Where the fight takes place.
$battleStage = new \Emagia\BattleStage();

// Adding Orderus to the stage
$Orderus = \Emagia\Entities\Orderus::create();
$battleStage->addCreature($Orderus);

// Adding WildBeast to the stage
$WildBeast = \Emagia\Entities\WildBeast::create();
$battleStage->addCreature($WildBeast);

/* There can be more than just one creature on the battlestage at a time */
// $Tortoise = \Emagia\Entities\Tortoise::create();
// $battleStage->addCreature($Tortoise);


$battleStage->init();