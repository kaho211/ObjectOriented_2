<?php
require_once "ReadFile.php";

class Board{
    public $board;
    public $goal_point;

    function __construct($path){
        $this->board = ReadFile::getArrayFromCsv($path); #読み込んだcsvファイルがすごろくのボードになる
        $this->goal_point = count($this->board) -1; #ボードの数（csvファイルの配列の数）がすごろくのゴール
    }

    function getBoard(){
        return $this->board;
    }
}
?>