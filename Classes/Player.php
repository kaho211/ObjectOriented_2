<?php

class Player{

    public $name; #プレイヤーの名前
    public $position; #現在地（はじめは0）

    #__constructに名前入れる
    public function __construct ($name){
        $this->name = $name;
        $this->position = 0;
    }

    #サイコロの出た目の分だけ前に進む（現在地＝現在地＋サイコロの出た目）
    public function goForward($num){
        $this->position += $num;
    }

    #サイコロの出た目の分だけ後ろに進む
    public function goBack($num){
        $this->position -= $num;
    }  
}
?>