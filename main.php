<?php
require_once 'Classes/Dice.php';
require_once 'Classes/Player.php';
require_once 'Classes/Game.php';
require_once 'Classes/Board.php';

$game = new Game();
$game->setBoard(new Board("Data/board.csv"));
$game->addPlayer(new Player ("Taro"));
$game->addPlayer(new Player ("Jiro"));
$game->setDice(new Dice());
$game->start();
?>