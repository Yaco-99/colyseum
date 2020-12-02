<?php
require_once 'connect.php';
session_start();
$dataArr = [];
if (isset($_POST['delete'])) {
    foreach ($_SESSION["tickets"] as $ticket) {
        $sql = $pdo->prepare('DELETE from tickets WHERE bookingsId=?');
        $sql->execute(array($ticket["id"]));
        $sql->closeCursor();
    }
    unset($_SESSION["tickets"]);
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
    $rows = $sql->fetch();
    $_SESSION["tickets"] ? $dataArr = $_SESSION["tickets"] : $dataArr;
    if ($rows) {
        array_push($dataArr, $rows);
        $_SESSION["tickets"] = $dataArr;
    }
    var_dump($_SESSION["tickets"]);
    foreach ($_SESSION["tickets"] as $row):
    ?>
					    <div class="border"></div>
						<form method="POST">
						<label for="id">Numéro de réservation</label>
						<input type="text" name="id" value="<?php echo $row['id'] ?>">
						<label for="clientId">Numéro client</label>
						<input type="text" name="clientId" value="<?php echo $row['clientId'] ?>">
						<?php
    $sql->closeCursor();
endforeach;
?>
<button type="submit" name="delete">Delete</button>
</form>
<?php endif;?>

</body>
</html>