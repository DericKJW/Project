<?php
	session_start();
	$UID = $_SESSION['UID'];	//retrieve UID
	$UNAME = $_SESSION['UNAME'];	//retrieve USERNAME
	$PID = $_SESSION['PID'];
	$PNAME = $_SESSION['PNAME'];
	$OWNPROJECT = $_SESSION['OWNPROJECT'];

  	// Connect to the database. 
    include 'db.php';
	$db = init_db();	

	//Display selected project based on $PID and $PNAME
	$result = pg_query($db, "SELECT * FROM projectsOwnership WHERE ownername = '$PNAME' AND projectid = '$PID'");
	$rows = pg_fetch_assoc($result);

	if (!$result) {
		echo "error getting proj from db";
	}
	/* debugging
	echo "<br><br><br>HELLO"; //testing
	echo "<br>";
	echo "$PID";
	echo "<br>";
	echo "$PNAME";
	echo "<br>debugging----ignore above this line";

	echo "<br>";
	*/
	$arr = pg_fetch_all($result);

	foreach ($arr as $value){
		$arr2 = array_values($value);
		$projname = $arr2[0];
		$projdesc = $arr2[1];
		$projSDate = $arr2[2];
		$projEDate = $arr2[3];
		$projOName = $arr2[5];
		$projamount = $arr2[6];
		$projprogress = $arr2[7];
		$projcat = $arr2[8];
	}

	//contribute to project
	if(isset($_POST['pay'])){
		header("Location: pay.php");
	}
	
	//logging out
	if(isset($_GET['logout'])){
		$link=$_GET['logout'];
		if ($link == 'true'){
			header("Location: logout.php");
			exit;
		}
	}

echo "<br><br><br>HELLO"; //testing
	echo "<br>";
	echo "$PID";
	echo "<br>";
	echo "$UNAME";

//Note to Shi Rong: Anyway to refresh the page on clicking submit? Because old records do not update automatically until I refresh the browser.

	if (isset($_POST['submit'])) {	

		if ($_POST[editProjName] <> NULL) {
		$sqlEditProjName = "UPDATE projectsownership SET projectname = '$_POST[editProjName]' WHERE ownername = '$UNAME' AND projectid = '$PID'";
		$editProjNameResult = pg_query($db, $sqlEditProjName);
		echo "$editProjNameResult";
		}

		if ($_POST[editProjDesc] <> NULL) {
		$sqlEditProjDesc = "UPDATE projectsownership SET projectdescription = '$_POST[editProjDesc]' WHERE ownername = '$UNAME' AND projectid = '$PID'";
		$editProjNameResult = pg_query($db, $sqlEditProjDesc);
		}

		if ($_POST[editEndDate] <> NULL) {
		$sqlEditEndDate = "UPDATE projectsownership SET enddate = '$_POST[editEndDate]' WHERE ownername = '$UNAME' AND projectid = '$PID'";
		$editProjNameResult = pg_query($db, $sqlEditEndDate);
		}

		if ($_POST[editTargetAmt] <> NULL) {
		$sqlEditTargetAmt = "UPDATE projectsownership SET targetamount = '$_POST[editTargetAmt]' WHERE ownername = '$UNAME' AND projectid = '$PID'";
		$editProjNameResult = pg_query($db, $sqlEditTargetAmt);
		}

		if ($_POST[editCat] <> NULL) {
		$sqlEditCat = "UPDATE projectsownership SET category = '$_POST[editCat]' WHERE ownername = '$UNAME' AND projectid = '$PID'";
		$editProjNameResult = pg_query($db, $sqlEditCat);
		}
}
		
		
	
?> 

<!DOCTYPE html>  
<html>
<head>
  <title>UPDATE PostgreSQL data with PHP</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <!-- Import CSS Files -->
  <link rel="stylesheet" href="css/w3.css">
  
</head>

<body>
<!-- Nagivation Bar -->
<?php
if($UNAME == NULL){
	$menu = file_get_contents('menu.html');
	echo $menu;
}
else{
	$menu = file_get_contents('menu-loggedin.html');
	echo $menu;
}
?>

<!-- Slide Show
<div class="w3-content w3-section" style="max-height:500px">
  <img class="mySlides" src="img/water.jpg" style="width:100%">
  <img class="mySlides" src="img/castle.jpg" style="width:100%">
  <img class="mySlides" src="img/road.jpg" style="width:100%">
</div>
-->

<!-- Main Body -->
<?php
if(!is_null($OWNPROJECT)){
	echo "
	<form class='w3-container' method='POST'>
    <p>      
    <label class='w3-text-brown'><b>Project Name</b></label></p>
	<p>

    <label class='w3-text-black w3-border w3-sand'>$projname</label></p>	

<p>      
    <label class='w3-text-brown'><b>Enter New Project Name</b></label></p>

    <p>
<input class='w3-input w3-border w3-sand' name='editProjName' type='text'></p>

    <p>      
    <label class='w3-text-brown'><b>Project Description</b></label></p>
	<p>
    <label class='w3-text-black w3-border w3-sand'>$projdesc</label></p>

    <p>      
    <label class='w3-text-brown'><b>Enter New Project Description</b></label></p>
    <p>
<input class='w3-input w3-border w3-sand' name='editProjDesc' type='text'></p>

	<p>      
    <label class='w3-text-brown'><b>Start Date (Cannot be changed)</b></label></p>
	<p>
    <label class='w3-text-black w3-border w3-sand'>$projSDate</label></p>

	<p>      
    <label class='w3-text-brown'><b>End Date</b></label></p>
	<p>
    <label class='w3-text-black w3-border w3-sand'>$projEDate</label></p>

<p>      
    <label class='w3-text-brown'><b>Enter New End Date (YYYY-MM-DD)</b></label></p>

    <p>
<input class='w3-input w3-border w3-sand' name='editEndDate' type='text'></p>


	<p>      
    <label class='w3-text-brown'><b>Target Amount</b></label></p>
	<p>
    <label class='w3-text-black w3-border w3-sand'>$projamount</label></p>

<p>      
    <label class='w3-text-brown'><b>Enter New Target Amount</b></label></p>

    <p>
<input class='w3-input w3-border w3-sand' name='editTargetAmt' type='text'></p>


	<p>      
    <label class='w3-text-brown'><b>Progress (Cannot be changed)</b></label></p>
	<p>
    <label class='w3-text-black w3-border w3-sand'>$projprogress</label></p>

	<p>      
    <label class='w3-text-brown'><b>Category</b></label></p>
	<p>
    <label class='w3-text-black w3-border w3-sand'>$projcat</label></p>

<p>      
    <label class='w3-text-brown'><b>Enter New Category</b></label></p>

    <p>
<input class='w3-input w3-border w3-sand' name='editCat' type='text'></p>
	
    <input class='w3-btn w3-brown' type='submit' name='submit' value='Edit Project Information'></button></p>
	</form>";
}
?>

<!-- Import Javascript Files -->
<script src="js/scripts.js"></script>
</body>
</html>