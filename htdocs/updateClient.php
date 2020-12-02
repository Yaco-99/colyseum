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
                FILTER_SANITIZE_NUMBER_INT),
        ),
        "cardNumber" => array(
            "filter" => array(FILTER_VALIDATE_INT,
                FILTER_SANITIZE_NUMBER_INT)),
    );
    $arr = filter_input_array(INPUT_POST, $filter);
    $arr['cardNumber'] ? "ok" : $arr['cardNumber'] = null;

    $sql = $pdo->prepare('UPDATE clients set birthDate=?, card=?, cardNumber=? WHERE lastName=? AND firstName=?');
    $sql->execute(array($arr['birth'], $arr['card'], $arr['cardNumber'], $_POST['lastName'], $_POST['firstName']));

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
<h2>Recherche du client</h2>
<form method="post">
<label for="firstName">Nom</label>
<input type="text" name="firstName">
<label for="lastName">Prénom</label>
<input type="text" name="lastName">
<input type="submit" name="who">
</form>

<?php if (isset($_POST['who'])):
    $sql = $pdo->query('SELECT * FROM clients WHERE lastName="' . $_POST['lastName'] . '" AND firstName="' . $_POST['firstName'] . '"');
    $rows = $sql->fetch()?>
		<form method="POST">
		<label for="firstName">Nom</label>
		<input type="text" name="firstName" value="<?php echo $rows['firstName'] ?>">
		<label for="lastName">Prénom</label>
		<input type="text" name="lastName" value="<?php echo $rows['lastName'] ?>">
		<label for="birth">Date de naissance</label>
		<input type="date" name="birth" value="<?php echo $rows['birthDate'] ?>">
		<label for="card">Carte de fidélité</label>
		<label for="no">non :</label><input type="radio" value="0" name="card" id="no">
		<label for="yes">oui :</label><input type="radio" value="1" name="card" id="yes">
		<label for="cardNumber">Numéro de carte de fidélité (si existante)</label>
		<input type="number" name="cardNumber" value="<?php echo $rows['cardNumber'] ?>">
		<input type="submit" name="submit">
		</form>
		<?php
    $sql->closeCursor();
endif;
?>
</body>
</html>
