<?php

session_start();
//unset($_SESSION['gameId']);
require_once 'Game.php';

if (!empty($_POST['newGame'])) {
    session_destroy();
    session_start();
    $game = new Game();
    $_SESSION['gameId'] = $game->gameId();
}



if (isset($_SESSION['gameId'])) {
    $game = new Game($_SESSION['gameId']);
} else {
    $game = new Game();
    $_SESSION['gameId'] = $game->gameId();
}


if (!empty($_POST['guess'])) {
    $_SESSION['lastCard'] = $game->lastCard();
    $res = $game->takeAGuess($_POST['guess']);
}



?>
<html>
<head>
    <title>game</title>
    <link rel="stylesheet" href="resource/style.css">
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <style type="text/css">
        button {
            width: 120px;
        }
    </style>
</head>
<body>
<form action="" method="post">
    <input type="hidden" name="newGame" value="1">
    <input type="submit" value="New game">
</form>
<h2>Game Data</h2>



<p>
    <h5>debug:</h5>
    Game id: <?=$game->gameId()?>
</p>
<hr>
<p>
Score: <?=$game->getScores()?><br/>
Cards in deck: <?=$game->cardsLeft()?>
</p>
<!--Prev Card:<div class="card card--><?//=$_SESSION['lastCard']?><!-- front"></div>-->
<?php
if ($game->isGameOver()) {
    echo "<h4>GAME OVER</h4>";
    echo "You've got <strong>". $game->getScores() ."</strong> points";
} else {
    ?>
<form action="" method="post" id="answ">
    <input type="hidden" id="guess" name="guess" value="">

    <table>

        <tr>
            <td>&nbsp;</td>
            <td>
                <button type="button" onclick="$('#guess').val('='); $('#answ').submit();" value="=">Equal</button>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <button type="button" onclick="$('#guess').val('>'); $('#answ').submit();" value=">">Smaller</button><br>
                <button type="button" onclick="$('#guess').val('>='); $('#answ').submit();" value=">=">Smaller Or Equal</button><br>
            </td>
            <td align="center">
                <div class="card card<?=$game->lastCard()?> front"></div>
            </td>
            <td>
                <button type="button" onclick="$('#guess').val('<'); $('#answ').submit();" value="<">Greater</button><br>
                <button type="button" onclick="$('#guess').val('<='); $('#answ').submit();" value="<=">Greater Or Equal</button><br>
            </td>
        </tr>

    </table>


</form>
    <? } ?>



<blockquote>
    <h4>Rules</h4>
    <p>
        You need to guess next card. Will it be bigger or smaller then the previous one<br>
        For selecting "Greater" or "Smaller" - you'll get 3 points<br>
        For selecting "Greater Or Equal" or "Smaller Or Equal" - you'll get 2 points<br>
        For selecting "Equal" - you'll get 4 point.<br>

        <br>
        For each mistake you'll be fined by 4 points.
    </p>
</blockquote>

</body>
</html>