<?php
class Game{

    public $square; #マスの数
    public $board;
    public $players = [];
    public $dice;
    public $result_list = [];

    
    public function __construct(){
    }

    public function setBoard($board){
        $this->board = $board;
    }

    public function addPlayer($player){
        $this->players []  = $player;
    }

    public function setDice($dice){
        $this->dice = $dice;
    }


    public function start(){

        #ゲーム開始
        echo "皆様お待たせいたしました。\n";
        sleep(1);
        echo "ただいまより「第37回全日本すごろく選手権大会」開幕いたします。\n\n";
        sleep(1);
        echo "今大会の解説は、初代チャンピオン岡本さんと最年少チャンピオン記録保持者の矢野さんです。\n";
        sleep(1);
        echo "よろしくお願いいたします。\n\n\n";
        sleep(2);
        echo "[スタジアム]\n";
        sleep(1);
        echo "今大会のゴールまでの距離は" . $this->board->goal_point . "マスです\n\n";
        sleep(1);
        echo "それでは、試合開始！\n\n";
        sleep(1);
        echo "----------------------------------------------------\n\n";
        sleep(3);

        #$this->playersに人がいる限り処理を続ける
        while ($this->players){
            foreach ($this->players as $player){
                    echo "[" . $player->name . "のターン]\n";
                    sleep(1);
                    echo "～Enterを押してサイコロを振ってください～\n";
                    fgets(STDIN);
                    $dice_num = $this->dice->rollDice();
                    echo "♪テッテレーン！\n";
                    sleep(1);
                    echo $player->name . "選手は" . $dice_num . "を出した！\n";
                    sleep(1);
                    echo $dice_num . "進む\n";
                    sleep(1);
                    $player->goForward($dice_num);

                    #ゴール超えた時の処理 #サイコロのマス分引く、元の場所に戻る
                    if ($player->position == $this->board->goal_point){ #$playersからゴールした人を消す
                        $index = array_search($player,$this->players);
                        array_splice($this->players, $index,1);
                        echo "\n♪デレデレデレデレ、、デーーーーンッ!!\n";
                        sleep(2);
                        echo $player->name . "選手はゴールしました\n";
                        echo str_repeat("■", $player->position) . "\n\n";
                        $this->result_list [] = ["player" => $player->name]; #ゴールした順（コースの全長を超えた順）に$result_listに入れていく
                        continue;
                    }elseif ($player->position > $this->board->goal_point){ #もし、サイコロの目＋現在地　> マスの数 だったら、超えた分戻る（ゴール地点を超えてしまう場合）
                        sleep(1);
                        echo "\nおっと、ゴールを超えてしまった!!\n";
                        sleep(1);
                        echo "痛恨のミス、、\n";
                        sleep(1);
                        echo "やり直しです\n";
                        sleep(1);
                        echo "現在地：" . ($player->position -= $dice_num) . "マス\n";
                        sleep(1);
                        echo "ゴールまであと" . ($this->board->goal_point - $player->position) . "マス\n";
                        echo str_repeat("■", $player->position);
                        echo str_repeat("□", $this->board->goal_point - $player->position) . "\n\n";
                        sleep(1);
                     continue;}

                    #マス目によって異なる処理する
                    $square_effect = $this->board->board[$player->position];
                    if ($square_effect > 0 ){ #正の数だったらその分進む
                        echo "!!!!!!\n";
                        sleep(1);
                        echo "「" . $square_effect . "」のマスに止まった\n";
                        sleep(1);
                        echo "さらに" . $square_effect . "マス進む\n";
                        $player->position += $square_effect;
                    } elseif ($square_effect < 0){  #負の数だったらその分戻る
                        echo "!!!!!!\n";
                        sleep(1);
                        echo "「" . $square_effect . "」のマスに止まった\n";
                        sleep(1);
                        $player->position += ($square_effect);
                        if ($player->position <= 0){ #スタート地点より前に戻らないようにする処理
                            $player->position = 0;
                            echo "スタート地点に戻る\n\n";
                            continue;
                        }
                        echo -($square_effect) . "マス戻る\n";
                    }

                        #もし、サイコロの目＋現在地　= マスの数 だったら、ゴール(ゴール地点にピッタリゴールした場合)
                        if ($player->position == $this->board->goal_point){ #$playersからゴールした人を消す
                            $index = array_search($player,$this->players);
                            array_splice($this->players, $index,1);
                            echo "\n♪デレデレデレデレ、、デーーーーンッ!!\n";
                            sleep(2);
                            echo $player->name . "選手はゴールしました\n";
                            echo str_repeat("■", $player->position) . "\n\n";
                            $this->result_list [] = ["player" => $player->name]; #ゴールした順（コースの全長を超えた順）に$result_listに入れていく
                        } elseif($player->position > $this->board->goal_point){ #もし、サイコロの目＋現在地　> マスの数 だったら、超えた分戻る（ゴール地点を超えてしまう場合）
                            sleep(2);
                            echo "\nおっと、ゴールを超えてしまった!!\n";
                            sleep(1);
                            echo "痛恨のミス、、\n";
                            sleep(1);
                            echo "やり直しです\n";
                            sleep(1);
                            $player->position -= $dice_num;
                            $player->position -= ($square_effect);
                            echo "現在地：" . ($player->position) . "マス\n";
                            sleep(1);
                            echo "ゴールまであと" . ($this->board->goal_point - $player->position) . "マス\n"; #
                            echo str_repeat("■", $player->position);
                            echo str_repeat("□", $this->board->goal_point - $player->position) . "\n\n"; #
                            sleep(1);   
                        } else{
                            sleep(1);
                            echo "現在地：" . $player->position . "\n";
                            sleep(1);
                            echo "ゴールまであと" . ($this->board->goal_point - $player->position) . "マス\n"; #
                            echo str_repeat("■", $player->position);
                            echo str_repeat("□", $this->board->goal_point - $player->position) . "\n\n"; #
                            sleep(1);
                        }

                if(count($this->players) == 0){
                    sleep(1);
                    echo "～全員がゴールしました～\n";
                    sleep(1);
                    echo "試合終了\n\n";
                    sleep(2);
                    break;
                }
            }       
        }
        #結果の出力
        $this->printResult();
    }

    public function printResult(){
        echo "----------------------------------------------------\n\n";
        sleep(1);
        echo "～表彰式～\n";
        sleep(1);
        for ($j = 0; $j < count($this->result_list); $j ++){
            echo "第" . ($j + 1) . "位：" . $this->result_list[$j]["player"] . "選手\n";
            sleep(1);
        } 
        echo "優勝した" .  $this->result_list[0]["player"] . "選手には、黄金のサイコロを授与いたします\n";
        sleep(1);
        echo "おめでとうございます～（拍手）\n\n";
        sleep(2);
        echo "[解説ブース]\n";
        sleep(1);
        echo "お疲れ様でした。\n";
        sleep(1);
        echo "いや～、非常に良い試合でしたね。\n";
        sleep(1);
        echo "優勝者には来月ブラジルで行われる世界選手権にも期待したいです。\n";
        sleep(1);
        echo "それでは皆さん、ごきげんよう～"; 
    }
}
?>