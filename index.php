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

if (isset($_GET['form_todo_submit'])) {

	$todoName = $_GET['form_todo_name']; 
	$todoDescription = $_GET['form_todo_description']; 
	$todoProcessing = $_GET['form_todo_processing']; 
	$todoCreated = date("Y-m-d H:i:s"); 
	$todoUpdated = date("Y-m-d H:i:s");

	$queryNewTodo = "INSERT INTO todo_list 
						(name, description, processing_date, created_at, updated_at) VALUES 
						('" . $todoName . "', '" . $todoDescription . "', '" . $todoProcessing . "', '" . $todoCreated . "', '" . $todoUpdated . "')";

	$todo = mysqli_query($dbLink, $queryNewTodo); 

	echo "ToDo erfolgreich gespeichert!<br><br>";
} else if (isset($_GET['action']) && ($_GET['action'] == 'editsave')) {

	$todoName = $_GET['form_todo_name']; 
	$todoDescription = trim(str_replace("%09", "", $_GET['form_todo_description'])); 
	$todoProcessing = $_GET['form_todo_processing']; 
	$todoUpdated = date("Y-m-d H:i:s");

	$queryEditTodo = "UPDATE todo_list SET
						name = '" . $todoName . "',
						description = '" . $todoDescription . "', 
						processing_date = '" . $todoProcessing . "',
						updated_at = '" . $todoUpdated . "' 
					  WHERE ID = '" . $_GET['ID'] . "'";
	
	$todo = mysqli_query($dbLink, $queryEditTodo); 

	echo "ToDo erfolgreich ge&auml;ndert!<br><br>";
}

?>


<?php
$queryTodo = "SELECT * FROM todo_list";
$todo = mysqli_query($dbLink, $queryTodo); 
?>

<table cellpadding="10" cellspacing="0" border="1">
	<tr>
		<th>#</th>
		<th>Titel</th>
		<th>Beschreibung</th>
		<th>Bearbeitungsdatum</th>
		<th>Erstellt</th>
		<th>Zuletzt bearbeitet</th>
		<th>Bearbeiten</th>
	</tr>
	<?php while ($resultTodo = mysqli_fetch_array($todo)) {
		if ($_GET['action'] == 'edit') { ?>
			<form action="todolist.php" METHOD="GET">
				<input type="hidden" name="action" value="editsave">
				<tr>
					<td>
						<?php if ($_GET['ID'] == $resultTodo['ID']) { ?>
							<input type="hidden" name="ID" value="<?= $resultTodo['ID']; ?>">
						<?php } 
						echo $resultTodo['ID']; ?>
					</td>
					<td>
						<?php if ($_GET['ID'] == $resultTodo['ID']) { ?>
							<input type="text" name="form_todo_name" value="<?= $resultTodo['name']; ?>">
						<?php } else { 
							echo $resultTodo['name'];
						} ?>
					</td>
					<td>
						<?php if ($_GET['ID'] == $resultTodo['ID']) { ?>
							<textarea rows="3" cols="20" name="form_todo_description">
								<?= $resultTodo['description']; ?>
							</textarea>
						<?php } else { 
							echo $resultTodo['description']; 
						} ?>
					</td>
					<td>
						<?php if ($_GET['ID'] == $resultTodo['ID']) { ?>
							<input type="date" name="form_todo_processing" value="<?= $resultTodo['processing_date']; ?>">
						<?php } else { 
							echo $resultTodo['processing_date']; 
						} ?>
					</td>
					<td>
						<?= $resultTodo['created_at']; ?>
					</td>
					<td>
						<?= $resultTodo['updated_at']; ?>
					</td>
					<td>
						<?php if ($_GET['ID'] == $resultTodo['ID']) { 
							echo "<input type='image' src='img/save.png'"; 
						} else {
							echo "<a href='todolist.php?action=edit&ID=" . $resultTodo['ID'] . "'><img src='img/edit.png' border=0></a>"; ?>
						<?php } ?>
					</td>
				</tr>
			</form>
		<?php } else { ?>
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
				<td>
					<?= "<a href='todolist.php?action=edit&ID=" . $resultTodo['ID'] . "'><img src='img/edit.png' border=0></a>"; ?>
				</td>
			</tr>
		<?php }	
	} ?>
</table>

<br><br>

<?php if($_GET['action'] != 'edit') {?>

	<form ACTION="todolist.php" METHOD="GET">
		<table cellpadding="5" cellspacing="0" border="0">
			<tr>
				<th>
					Name der ToDo
				</th>
				<td>
					<input type="text" size="50" maxlength="255" name="form_todo_name">
				</td>
			</tr>

			<tr>
				<th>
					Beschreibung
				</th>
				<td>
					<textarea rows="3" cols="20" name="form_todo_description"></textarea>
				</td>
			</tr>

			<tr>
				<th>
					Bearbeitungsdatum
				</th>
				<td>
					<input type="date" name="form_todo_processing">
				</td>
			</tr>

			<tr>
				<th>
					&nbsp;
				</th>
				<td>
					<input type="submit" name="form_todo_submit" value="Formular absenden">
				</td>
			</tr>
		</table>
	</form>
<?php } ?>

</body>
</html>
