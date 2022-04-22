<?php
class Dice{
    #サイコロを振る
    public $dice;

    public function __construct(){
    }

    public function rollDice(){
        return rand(1,6);
    }
}
?>