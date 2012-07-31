<?php

session_start();
//unset($_SESSION['gameId']);
require_once 'Game.php';

if (!empty($_POST['newGame'])) {
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
    $res = $game->takeAGuess($_POST['guess']);
}



?>
<html>
<head>
    <title>game</title>
</head>
<body>
<form action="" method="post">
    <input type="hidden" name="newGame" value="1">
    <input type="submit" value="New game">
</form>
<h2>Game Data</h2>

<p>
    Game id: <?=$game->gameId()?><br/>
    Cards in deck: <?=$game->cardsLeft()?>
</p>
<hr>
Current card: <?=$game->lastCard()?>

<?php
if ($game->isGameOver()) {
    echo "<h4>GAME OVER</h4>";
} else {
    ?>
<form action="" method="post">
    <select name="guess">
        <option value=">">More</option>
        <option value="<">Less</option>
        <option value=">=">More or Equal</option>
        <option value="<=">Less or Equal</option>
    </select>
    <input type="submit" value="check">
</form>
    <? } ?>
</body>
</html>