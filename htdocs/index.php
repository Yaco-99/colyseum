<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<a href="newClient.php">Ajouter client</a>
<table>
    <tr>
        <th>id</th>
        <th>lastName</th>
        <th>firstName</th>
        <th>birthDate</th>
        <th>card</th>
        <th>cardNumber</th>
    </tr>
    <?php
require 'connect.php';
$sql = $pdo->query('SELECT * FROM clients WHERE card=1 LIMIT 0,20');
while ($rows = $sql->fetch()) {
    echo '<tr><td>' . $rows['id'] . '</td><td>' . $rows['lastName'] . '</td><td>' . $rows['firstName'] . '</td><td>' . $rows['birthDate'] . '</td><td>' . $rows['card'] . '</td><td>' . $rows['cardNumber'] . '</td></tr>';
}
$sql->closeCursor();
?>
    </table>
    <table>
    <tr>
    <th>id</th>
    <th>type</th>
    </tr>
<?php
$sql = $pdo->query('SELECT * FROM showTypes');
while ($rows = $sql->fetch()) {
    echo '<tr><td>' . $rows['id'] . '</td><td>' . $rows['type'] . '</td></tr>';
}
$sql->closeCursor();
?>
    </table>
    <table>
    <tr>
        <th>id</th>
        <th>lastName</th>
        <th>firstName</th>
        <th>birthDate</th>
        <th>card</th>
        <th>cardNumber</th>
    </tr>
    <?php
$sql = $pdo->query('SELECT * FROM clients WHERE card=1 LIMIT 0,20');
while ($rows = $sql->fetch()) {
    echo '<tr><td>' . $rows['id'] . '</td><td>' . $rows['lastName'] . '</td><td>' . $rows['firstName'] . '</td><td>' . $rows['birthDate'] . '</td><td>' . $rows['card'] . '</td><td>' . $rows['cardNumber'] . '</td></tr>';
}
$sql->closeCursor();
?>
    </table>
<?php
$sql = $pdo->query('SELECT * FROM clients WHERE lastName LIKE "M%" ORDER BY lastName ASC');
while ($rows = $sql->fetch()) {
    echo '<p> Nom : ' . $rows['lastName'] . '</p><p>Prénom : ' . $rows['firstName'] . '</p>';
}
$sql->closeCursor();

$sql = $pdo->query('SELECT title, performer, date, startTime FROM shows ORDER BY title ASC');
while ($rows = $sql->fetch()) {
    echo '<p>' . $rows['title'] . ' Spectacle par ' . $rows['performer'] . ', le ' . $rows['date'] . ' à ' . $rows['startTime'] . ' heure</p>';
}
$sql->closeCursor();

$sql = $pdo->query('SELECT * FROM clients');
while ($rows = $sql->fetch()): ?>
    <p> Nom : <?php echo $rows['lastName'] ?></p>
    <p>Prénom : <?php echo $rows['firstName'] ?></p>
    <p> Date de naissance : <?php echo $rows['birthDate'] ?></p>
    <p> Carte de fidélité : <?php echo $rows['card'] == 1 ? 'Oui' : 'Non' ?></p>
    <p> numéro de carte : <?php echo $rows['card'] == 1 ? $rows['cardNumber'] : 'Pas de carte' ?></p>;
<?php endwhile;
$sql->closeCursor();
?>


</body>
</html>