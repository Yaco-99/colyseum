<?php
require_once 'connect.php';
session_start();
$dataArr = [];
if (isset($_POST['delete'])) {
    foreach ($_SESSION["reservations"] as $reservation) {
        $sql = $pdo->prepare('DELETE from tickets WHERE bookingsId=?');
        $sql->execute(array($reservation["bookingsId"]));
        $sql->closeCursor();
    }
    unset($_SESSION["reservations"]);
}
if (isset($_POST['cancel'])) {
    unset($_SESSION["reservations"]);
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

<form method="post">
<label for="id">Id</label>
<input type="number" name="id">
<input type="submit" name="who">
</form>

<?php if (isset($_POST['who'])):
    $id = intval($_POST['id']);
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

    $sql = $pdo->query('SELECT * FROM tickets WHERE bookingsId="' . $id . '"');
    $_SESSION["reservations"] ? $dataArr = $_SESSION["reservations"] : $dataArr;
    while ($rows = $sql->fetch()) {
        array_push($dataArr, $rows);
    }
    $_SESSION["reservations"] = $dataArr;

    var_dump($_SESSION["reservations"]);
    foreach ($_SESSION["reservations"] as $row):
    ?>
	<div class="border"></div>
	<form method="POST">
	<label for="id">Numéro billets</label>
	<input type="text" name="id" value="<?php echo $row['id'] ?>">
	<label for="price">Prix</label>
	<input type="text" name="price" value="<?php echo $row['price'] ?>">
	<label for="bookingsId">Numéro de réservation</label>
	<input type="text" name="bookingsId" value="<?php echo $row['bookingsId'] ?>">
	<?php
    $sql->closeCursor();
endforeach;
?>
<button type="submit" name="delete">Delete</button>
<button type="submit" name="cancel">Cancel</button>
</form>
<?php endif;?>

</body>
</html>