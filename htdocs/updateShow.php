<?php
require_once 'connect.php';
if (isset($_POST['submit'])) {
    $filter = array(
        "title" => array(
            "filter" => FILTER_SANITIZE_STRING,
        ),
        "performer" => array(
            "filter" => FILTER_SANITIZE_STRING,
        ),
        "date" => array(
            "filter" => FILTER_SANITIZE_STRING,
        ),
        "showType" => array(
            "filter" => array(FILTER_VALIDATE_INT,
                FILTER_SANITIZE_INT),
        ),
        "firstGenre" => array(
            "filter" => FILTER_SANITIZE_STRING,
        ),
        "secondGenre" => array(
            "filter" => FILTER_SANITIZE_STRING,
        ),
        "duration" => array(
            "filter" => FILTER_SANITIZE_STRING,
        ),
        "startTime" => array(
            "filter" => FILTER_SANITIZE_STRING,
        ),
    );
    $arr = filter_input_array(INPUT_POST, $filter);
    $sql = $pdo->prepare('SELECT id FROM genres WHERE genre = ?');
    $firstGenre = $sql->execute(array($arr['firstGenre']));
    $firstGenre = $sql->fetch();
    $secondGenre = $sql->execute(array($arr['secondGenre']));
    $secondGenre = $sql->fetch();
    $firstGenre ? $firstGenre = $firstGenre['id'] : $firstGenre = 29;
    $secondGenre ? $secondGenre = $secondGenre['id'] : $secondGenre = 29;
    /*$sql = $pdo->prepare('INSERT INTO shows (performer, date, showTypesId, firstGenresId, secondGenreId, duration, startTime) VALUES (?,?,?,?,?,?,?,?)');
    $sql->execute(array($arr['performer'], $arr['date'], $arr['showType'], $firstGenre, $secondGenre, $arr['duration'], $arr['startTime'])); */
    $sql = $pdo->prepare('UPDATE shows set performer=?, date=?, showTypeId=? firstGenreId=?, secondGenreId=?, duration=?, startTime=? WHERE title=?');
    $sql->execute(array($arr['performer'], $arr['date'], $arr['showType'], $firstGenre, $secondGenre, $arr['duration'], $arr['startTime'], $arr['title']));
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
<label for="title">Titre</label>
<input type="text" name="title">
<input type="submit" name="who">
</form>

<?php if (isset($_POST['who'])):
    $sql = $pdo->query('SELECT * FROM shows WHERE title="' . $_POST['title'] . '"');
    $rows = $sql->fetch()?>
		<form method="POST">
		<label for="performer">artiste</label>
		<input type="text" name="performer" value="<?php echo $rows['performer'] ?>">
		<label for="date">Date</label>
		<input type="date" name="date" value="<?php echo $rows['date'] ?>">
		<label for="showType">Carte de fidélité</label>
		<select name="showType">
		 <option value="1">Concert</option>
		 <option value="2">Théatre</option>
		 <option value="3">Humour</option>
		 <option value="4">Danse</option>
		</select>
		<label for="firstGenre">Genre 1</label>
		<input type="text" name="firstGenre" value="<?php echo $arr['firstGenre'] ?>">
		<label for="secondGenre">Genre 2</label>
		<input type="text" name="secondGenre" value="<?php echo $arr['secondGenre'] ?>">

		<label for="duration">Durée</label>
		<input type="time" name="duration" value="<?php echo $rows['duration'] ?>">
		<label for="startTime">Début</label>
		<input type="time" name="startTime" value="<?php echo $rows['startTime'] ?>">
		<input type="submit" name="submit">
		</form>

		<?php endif;?>
</body>
</html>
