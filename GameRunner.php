<?php

include __DIR__.'/Game.php';

$winTheGame;

  $aGame = new Game();
  
  $aGame->add("Chet");
  $aGame->add("Pat");
  $aGame->add("Sue");
  
  
  do {
    
    $aGame->roll(rand(0,5) + 1);
    
    if (rand(0,9) == 7) {
      $winTheGame = $aGame->wrongAnswer();
    } else {
      $winTheGame = $aGame->wasCorrectlyAnswered();
    }
    
    
    
  } while (!$winTheGame);
  
