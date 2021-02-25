<?php
declare(strict_types=1);
require "code/Deck.php";

class Player
{
private array $cards =[];
private bool $lost = false;
private const SCORE_LIMIT =21;

    public function hit($deck){


        $this ->cards[]=$deck->drawCard();

        if($this->getScore()>self::SCORE_LIMIT) { $this->lost=true; }

    }
    public function getPlayerCards(){
       return $this->cards;
    }


    public function surrender(){
        $this->lost=true;
    }
    public function getScore(){

          for($i=0;$i<count($this->cards);$i++){
           $numbers [] = $this->cards[$i]->getValue();
          }
          $sum = array_sum($numbers);
            return($sum);
    }

    public function hasLost(){
        return $this -> lost;
    }




 public function __construct($deck)
{
$this -> cards[]=$deck->drawCard();
$this -> cards[]=$deck->drawCard();


}


}

class Dealer extends Player {

    public function __construct($deck)
    {
        parent::__construct($deck);


          while($this->getScore()<15){
             parent::hit($deck);
          }




    }


}

