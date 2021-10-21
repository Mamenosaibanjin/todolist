<?php 
include ("db.php");
include ("applications_de.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo __CHARSET__ ?>
<title><?php echo __TITLE__ ?></title>
<link rel="stylesheet" href="css/styles.css" type="text/css" />
<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/libs.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>

<?php 

function deleteTODO($todo_id, $dbLink) {
   $queryDeleteTodo = "DELETE FROM todo_list WHERE ID = '" . $_GET['ID'] . "'";
   $delete = mysqli_query($dbLink, $queryDeleteTodo);

   if (mysqli_affected_rows($dbLink) == 0) {
   		echo "keine ToDos zum L&ouml;schen gefunden<br><br>";
   } else {
		echo "ToDo " . $todo_id . " erfolgreich gel&ouml;scht<br><br>";
   }
}

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

} else if (isset($_GET['action']) && ($_GET['action'] == 'delete')) {
	deleteTODO($_GET['ID'], $dbLink);
}

?>


<?php
$queryTodo = "SELECT * FROM todo_list";
$todo = mysqli_query($dbLink, $queryTodo); 
?>

<form action="todolist.php" METHOD="GET">

	<div class="limiter">
		<div class="container-table100">
			<div class="wrap-table100">

				<div class="table">
					<div class="row header">
						<div class="cell">#</div>
						<div class="cell">Titel</div>
						<div class="cell">Beschreibung</div>
						<div class="cell">Bearbeitungs- datum</div>
						<div class="cell">Erstellt</div>
						<div class="cell">Zuletzt bearbeitet</div>
						<div class="cell">Aktion</div>
					</div>
					<?php while ($resultTodo = mysqli_fetch_array($todo)) {
						if (isset($_GET['action']) && $_GET['action'] == 'edit') { ?>
								<input type="hidden" name="action" value="editsave">
								<div class="row">
									<div class="cell">
										<?php if ($_GET['ID'] == $resultTodo['ID']) { ?>
											<input type="hidden" name="ID" value="<?= $resultTodo['ID']; ?>">
										<?php } 
										echo $resultTodo['ID']; ?>
									</div>
									<div class="cell">
										<?php if ($_GET['ID'] == $resultTodo['ID']) { ?>
											<input type="text" name="form_todo_name" value="<?= $resultTodo['name']; ?>">
										<?php } else { 
											echo $resultTodo['name'];
										} ?>
									</div>
									<div class="cell">
										<?php if ($_GET['ID'] == $resultTodo['ID']) { ?>
											<textarea rows="3" cols="20" name="form_todo_description">
												<?= $resultTodo['description']; ?>
											</textarea>
										<?php } else { 
											echo $resultTodo['description']; 
										} ?>
									</div>
									<div class="cell">
										<?php if ($_GET['ID'] == $resultTodo['ID']) { ?>
											<input type="date" name="form_todo_processing" value="<?= $resultTodo['processing_date']; ?>">
										<?php } else { 
											echo $resultTodo['processing_date']; 
										} ?>
									</div>
									<div class="cell">
										<?= substr($resultTodo['created_at'],0,10); ?>
									</div>
									<td>
										<?= substr($resultTodo['updated_at'],0,10); ?>
									</td>
									<div class="cell">
										<?php if ($_GET['ID'] == $resultTodo['ID']) { 
											echo "<input type='image' src='img/save.png'>"; 
										} else {
											echo "<a href='todolist.php?action=edit&ID=" . $resultTodo['ID'] . "'><img src='img/edit.png' border=0></a>
												  <a href='todolist.php?action=delete&ID=" . $resultTodo['ID'] . "'><img src='img/delete.png' border=0></a>"; 
										} ?>
									</div>
								</div>
						<?php } else { ?>
							<div class="row">
								<div class="cell">
									<?= $resultTodo['ID']; ?>
								</div>
								<div class="cell">
									<?= $resultTodo['name']; ?>
								</div>
								<div class="cell">
									<?= $resultTodo['description']; ?>
								</div>
								<div class="cell">
									<?= $resultTodo['processing_date']; ?>
								</div>
								<div class="cell">
									<?= substr($resultTodo['created_at'],0,10); ?>
								</div>
								<div class="cell">
									<?= substr($resultTodo['updated_at'],0,10); ?>
								</div>
								<div class="cell">
									<?= "<a href='todolist.php?action=edit&ID=" . $resultTodo['ID'] . "'><img src='img/edit.png' border=0></a>
									     <a href='todolist.php?action=delete&ID=" . $resultTodo['ID'] . "'><img src='img/delete.png' border=0></a>"; ?>
								</div>
							</div>
						<?php }	
					} ?>
				<?php if(!isset($_GET['action']) || $_GET['action'] != 'edit') {?>

							<div class="row">
								<div class="cell">
									<b>NEU</b>
								</div>
								<div class="cell">
									<input type="text" size="50" maxlength="255" name="form_todo_name" style="background-color: silver; width: 150px;">
								</div>
								<div class="cell">
									<textarea rows="3" cols="20" name="form_todo_description"></textarea>
								</div>
								<div class="cell">
									<input type="date" name="form_todo_processing">
								</div>
								<div class="cell">&nbsp;</div>
								<div class="cell">&nbsp;</div>
								<div class="cell">
									<input type='image' src='img/save.png' name="form_todo_submit" value="Formular absenden">
								</div>
							</div>
				<?php } ?>
				</div>
			</div>
		</div>
	</div>

</form>	

</body>
</html>
