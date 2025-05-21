<?php
require_once "config.php";
include("session-checker.php");
if (isset($_POST['btnsubmit'])) {
	$sql ="DELETE FROM tblaccounts WHERE username = ?";
	if ($stmt = mysqli_prepare($link, $sql)) {
		mysqli_stmt_bind_param($stmt, "s", trim($_POST['txtusername']));
		if(mysqli_stmt_execute($stmt)){
			$sql = "INSERT INTO tblogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
			if ($stmt = mysqli_prepare($link, $sql)) {
				$date = date("m/d/Y");
				$time = date("h:i:sa");
				$action = "Delete";
				$module = "Accounts Management";
				mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, trim($_POST['txtusername']), $_SESSION['username']);
				if(mysqli_stmt_execute($stmt)) {
					echo "User account deleted";
					header("location: accounts-management.php");
					exit();
				}
				else {
					echo "<font color = 'red'>Error on insert log statement</font>";
				}
			}
		}
		else{
			echo "Error delete account";
		}
	}
}
?>
