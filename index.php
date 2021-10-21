<?php 
include ("db.php");
include ("applications_de.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo __CHARSET__ ?>
<title><?php echo __TITLE__ ?></title>
<link rel="stylesheet" href="styles.css" type="text/css" />
<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/libs.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>

<?php
$queryTodo = "SELECT * FROM todo_list";
$todo = mysqli_query($dbLink, $queryTodo); 
?>

<table cellpadding="10" cellspacing="0" border="1">
	<tr>
		<th>#</th>
		<th>Titel</th>
		<th>Beschreibung</th>
		<th>Processing</th>
		<th>Erstellt</th>
		<th>Zuletzt bearbeitet</th>
	</tr>
	<?php while ($resultTodo = mysqli_fetch_array($todo)) {?>
		<tr>
			<td>
				<?= $resultTodo['ID']; ?>
			</td>
			<td>
				<?= $resultTodo['name']; ?>
			</td>
			<td>
				<?= $resultTodo['description']; ?>
			</td>
			<td>
				<?= $resultTodo['processing_date']; ?>
			</td>
			<td>
				<?= $resultTodo['created_at']; ?>
			</td>
			<td>
				<?= $resultTodo['updated_at']; ?>
			</td>
		</tr>
	<?php } ?>
</table>

</body>
</html>
