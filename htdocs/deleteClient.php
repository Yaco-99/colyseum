<?php
require_once 'connect.php';
session_start();
$dataArr = [];
if (isset($_POST['delete'])) {

    foreach ($_SESSION["clients"] as $client) {
        $sql = $pdo->prepare('DELETE from clients WHERE id=?');
        $sql->execute(array($client["id"]));
        $sql->closeCursor();
    }
    unset($_SESSION["clients"]);
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
<input type="submit" name="who">
</form>

<?php if (isset($_POST['who'])):
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

    $sql = $pdo->query('SELECT * FROM clients WHERE lastName="' . $arr['lastName'] . '" AND firstName="' . $arr['firstName'] . '" AND birthDate="' . $arr['birth'] . '"');
    $rows = $sql->fetch();
    $_SESSION["clients"] ? $dataArr = $_SESSION["clients"] : $dataArr;
    if ($rows) {
        array_push($dataArr, $rows);
        $_SESSION["clients"] = $dataArr;
    }
    foreach ($_SESSION["clients"] as $row):
    ?>
	<div class="border"></div>
	<form method="POST">
	<label for="id">Numéro client</label>
	<input type="text" name="id" value="<?php echo $row['id'] ?>">
	<label for="firstName">Nom</label>
	<input type="text" name="firstName" value="<?php echo $row['firstName'] ?>">
	<label for="lastName">Prénom</label>
	<input type="text" name="lastName" value="<?php echo $row['lastName'] ?>">
	<label for="birth">Date de naissance</label>
	<input type="date" name="birth" value="<?php echo $row['birthDate'] ?>">
	<label for="card">Carte de fidélité</label>
	<label for="no">non :</label><input type="radio" value="0" name="card" id="no">
	<label for="yes">oui :</label><input type="radio" value="1" name="card" id="yes">
	<label for="cardNumber">Numéro de carte de fidélité</label>
	<input type="number" name="cardNumber" value="<?php echo $row['cardNumber'] ?>">
	<?php
    $sql->closeCursor();
endforeach;
?>
<button type="submit" name="delete">Delete</button>
</form>
<?php endif;?>

</body>
</html>
