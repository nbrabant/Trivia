<?php

include __DIR__ . '/bootstrap/autoload.php';

$notAWinner = true;

$aGame = new Game(
    new QuestionDeck(50),
    new PlayerList(["Chet", "Pat", "Sue"])
);

do {
    $aGame->roll(rand(0, 5) + 1);

    if (rand(0, 9) == 7) {
        $notAWinner = $aGame->wrongAnswer();
    } else {
        $notAWinner = $aGame->wasCorrectlyAnswered();
    }
} while ($notAWinner);
  
