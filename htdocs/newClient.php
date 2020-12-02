<?php
require_once 'connect.php';
if (isset($_POST['submit'])) {
    $filter = array(
        "firstName" => array(
            "filter" => FILTER_SANITIZE_STRING,
        ),
        "lastName" => array(
            "filter" => FILTER_SANITIZE_STRING,
        ),
        "birth" => array(
            "filter" => FILTER_SANITIZE_STRING,
        ),
        "card" => array(
            "filter" => array(FILTER_VALIDATE_INT,
                FILTER_SANITIZE_INT),
        ),
        "cardNumber" => array(
            "filter" => array(FILTER_VALIDATE_INT,
                FILTER_SANITIZE_INT)),
        "newCardNumber" => array(
            "filter" => array(FILTER_VALIDATE_INT,
                FILTER_SANITIZE_INT)),
        "cardType" => array(
            "filter" => array(FILTER_VALIDATE_INT,
                FILTER_SANITIZE_INT)),
    );
    $arr = filter_input_array(INPUT_POST, $filter);
    $arr['cardNumber'] ? "ok" : $arr['cardNumber'] = null;

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    if ($arr['newCardNumber']) {
        $sql = $pdo->prepare('INSERT INTO cards (cardNumber, cardTypesId) VALUES (?,?)');
        $sql->execute(array($arr['newCardNumber'], $arr['cardType']));
        $arr['cardNumber'] = $arr['newCardNumber'];
        $arr['card'] = 1;
    }

    $sql = $pdo->prepare('INSERT INTO clients (lastName, firstName, birthDate, card, cardNumber) VALUES (?,?,?,?,?)');
    $sql->execute(array($arr['lastName'], $arr['firstName'], $arr['birth'], $arr['card'], $arr['cardNumber']));

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/style.css"/>
</head>
<body>
<a href="index.php">index</a>
<form method="POST">
<label for="firstName">Nom</label>
<input type="text" name="firstName">
<label for="lastName">Prénom</label>
<input type="text" name="lastName">
<label for="birth">Date de naissance</label>
<input type="date" name="birth">
<label for="card">Carte de fidélité</label>
<label for="no">non :</label><input type="radio" value="0" name="card" id="no">
<label for="yes">oui :</label><input type="radio" value="1" name="card" id="yes">
<label for="cardNumber">Numéro de carte de fidélité (si existante)</label>
<input type="number" name="cardNumber">
<h2>Add card</h2>
<label for="newCardNumber">Numéro de carte de fidélité</label>
<input type="number" name="newCardNumber">
<label for="cardType">Type de carte</label>
<input type="number" name="cardType">
<input type="submit" name="submit">
</form>
</body>
</html>
