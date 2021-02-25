<?php
declare(strict_types=1);
require "code/Player.php";
require "code/Blackjack.php";
require "code/Card.php";
require "code/Suit.php";

session_start();
$blackjack = new Blackjack();
if (!isset($_SESSION['Blackjack'])) {
    $_SESSION['Blackjack'] = $blackjack;
}
const MAX_VALUE = 21;



function hit()
{
    $_SESSION['Blackjack']->getPlayer()->hit($_SESSION['Blackjack']->getDeck());
    header("Location:http://blackjack.local/");
    exit;
}

function stand()
{
    $_SESSION["Blackjack"]->getDealer()->hit($_SESSION['Blackjack']->getDeck());

    if($_SESSION['Blackjack']->getDealer()->hasLost() == true){
        header("Location:http://blackjack.local/");
        exit;
    }

    if ($_SESSION['Blackjack']->getDealer()->hasLost() == false) {
       if ($_SESSION["Blackjack"]->getPlayer()->getScore() > $_SESSION["Blackjack"]->getDealer()->getScore()) {
           $_GET['test']=true;

         global $playerwin;  $playerwin=true;
       } else {
          global $dealerwin;   $dealerwin=true;

        }
    }
}


function surrender()
{
    header("Location:http://blackjack.local/");
    $_GET['test']=true;
    $_SESSION["Blackjack"]->getPlayer()->surrender();
    exit;
}

if ($_SESSION['Blackjack']->getPlayer()->hasLost() == true) {
    $dealerwin=true;
    $_GET['test']=true;
    session_destroy();
}

if ($_SESSION['Blackjack']->getDealer()->hasLost() == true) {
    $playerwin=true;
    $_GET['test']=true;
    session_destroy();
}

if($_SESSION['Blackjack']->getPlayer()->getScore()==MAX_VALUE){
    $_GET['test']=true;
    $playerwin=true;
    session_destroy();
}
if($_SESSION['Blackjack']->getDealer()->getScore()==MAX_VALUE){
    $_GET['test']=true;
    $dealerwin=true;
    session_destroy();
}


if (isset($_POST["hit"])) {
    hit();
}
if (isset($_POST["stand"])) {
    stand();
}
if (isset($_POST["surrender"])) {
    surrender();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>blackjack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous"
</head>
<body>

<div class="mh-100"  >

    <div class="d-flex justify-content-center  align-self-center " style="font-size: 200px;">
        <?php
        foreach($_SESSION['Blackjack']->getDealer()->getPlayerCards() AS $card) {
            echo $card->getUnicodeCharacter(true);

        }
        echo $_SESSION["Blackjack"]->getDealer()->getScore();



        ?>

    </div>


    <div class="d-flex justify-content-center  " style="font-size: 200px">
        <?php
        foreach($_SESSION['Blackjack']->getPlayer()->getPlayerCards() AS $card) {
            echo $card->getUnicodeCharacter(true);
        }
        echo $_SESSION["Blackjack"]->getPlayer()->getScore();
        ?>
    </div>
    <div class="d-flex justify-content-center  " style="font-size: 30px">  </div>



<div class="d-flex justify-content-center  ">
    <p><?php if($playerwin==true){ echo "player has won";} if($dealerwin==true){echo "dealer has won";}   ?></p>
</div>
<div class="d-flex justify-content-center  ">
<form id="fml" method="post" action="" class=" d-inline-bock"></form>

 <?php
 if(!isset($_GET["test"])){
 echo '
<button type="submit" name="hit" class="btn btn-success btn-lg" form="fml" formmethod="post">hit </button>
<button type="submit" name="stand" class="btn btn-primary" form="fml" formmethod="post">stand </button>
<button type="submit" name="surrender" class="btn btn-danger" form="fml" formmethod="post">surrender </button>
';
 }
 else{
     echo '<button type="submit" name="confirm" class="btn btn-primary btn-lg" form="fml" formmethod="post">Ok! </button>';
 }
?>
</div>

</body>
</html>

