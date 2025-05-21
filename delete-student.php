<?php
require_once "config.php";
include("session-checker.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])) {
    $studentNumber = trim($_POST['username']);

    // Fetch username from tblaccount using $_SESSION['username']
    $username = '';
    $sql_username = "SELECT username FROM tblaccount WHERE username = ?";
    if ($stmt_username = mysqli_prepare($link, $sql_username)) {
        mysqli_stmt_bind_param($stmt_username, "s", $_SESSION['username']);
        mysqli_stmt_execute($stmt_username);
        mysqli_stmt_bind_result($stmt_username, $username);
        mysqli_stmt_fetch($stmt_username);
        mysqli_stmt_close($stmt_username);
    }

    // Proceed if username is fetched
    if (!empty($username)) {
        // Delete student record from stdaccounts
        $sql_delete_student = "DELETE FROM stdaccounts WHERE studentNumber = ?";
        if ($stmt_delete_student = mysqli_prepare($link, $sql_delete_student)) {
            mysqli_stmt_bind_param($stmt_delete_student, "s", $studentNumber);
            if (mysqli_stmt_execute($stmt_delete_student)) {
                // Delete account from tblaccount
                $sql_delete_account = "DELETE FROM tblaccount WHERE username = ?";
                if ($stmt_delete_account = mysqli_prepare($link, $sql_delete_account)) {
                    mysqli_stmt_bind_param($stmt_delete_account, "s", $studentNumber);
                    if (mysqli_stmt_execute($stmt_delete_account)) {
                        // Insert deletion log
                        $date = date("m/d/Y");
                        $time = date("h:i:sa");
                        $action = "Delete";
                        $module = "Students Management";

                        $sql_insert_log = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
                        if ($stmt_log = mysqli_prepare($link, $sql_insert_log)) {
                            mysqli_stmt_bind_param($stmt_log, "ssssss", $date, $time, $action, $module, $studentNumber, $_SESSION['username']);
                            if (mysqli_stmt_execute($stmt_log)) {
                                // Redirect before any content output
                                header("location: student-management.php?delete_success=1");
                                exit();
                            } else {
                                echo "<font color='red'>Error on insert log statement</font>";
                            }
                        }
                    } else {
                        echo "<font color='red'>Error deleting account</font>";
                    }
                }
            } else {
                echo "<font color='red'>Error deleting student record</font>";
            }
        }
    } else {
        echo "<font color='red'>Error fetching username</font>";
    }
}

// No need to output anything before this point
?>

<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Delete Account - Arellano University Subject Advising System</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "POST">
		<input type="hidden" name="txtstdnum" value="<?php echo trim($_GET['username']); ?>">
		<p>Are you sure you want to delete this account?</p><br>
		<input type="submit" name="btnsubmit" value="Yes">
		<a href="accounts-management.php">No</a>
	</form>

    

</body>
</html>