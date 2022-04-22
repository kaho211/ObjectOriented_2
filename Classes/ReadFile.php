<?php

abstract class ReadFile{
    static function getArrayFromCsv($filepath){
        $array_from_csv = [];

        $array_from_csv [] = 0; #スタート地点を作る
        #読み込みたいscvファイルを開く
        $f = fopen($filepath, "r");

        #scvファイルを1行ずつ読み込む
        while ($line = fgetcsv($f)){
            for($i = 0; $i < count($line); $i++){
                $array_from_csv [] = $line[$i];
            }
        }

        #csvファイルを閉じる
        fclose($f);

        return $array_from_csv;
    }
}
?>