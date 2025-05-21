<?php
require_once "config.php";
include("session-checker.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnsubmit'])) {
    // Check if username is set
    if (isset($_POST['txtsubject'])) {
        $username = $_POST['txtsubject'];

        // Fetch username from tblaccount using $_SESSION['username']
        $fetchedUsername = '';
        $sql_username = "SELECT username FROM tblaccount WHERE username = ?";
        if ($stmt_username = mysqli_prepare($link, $sql_username)) {
            mysqli_stmt_bind_param($stmt_username, "s", $_SESSION['username']);
            mysqli_stmt_execute($stmt_username);
            mysqli_stmt_bind_result($stmt_username, $fetchedUsername);
            mysqli_stmt_fetch($stmt_username);
            mysqli_stmt_close($stmt_username);
        }

        // Proceed if username is fetched
        if (!empty($fetchedUsername)) {
            $sql_delete = "DELETE FROM tblsubject WHERE subjectCode = ?";
            if ($stmt_delete = mysqli_prepare($link, $sql_delete)) {
                // Assuming subject code is the same as the username
                mysqli_stmt_bind_param($stmt_delete, "s", $username);
                if (mysqli_stmt_execute($stmt_delete)) {
                    $date = date("m/d/Y");
                    $time = date("h:i:sa");
                    $action = "Delete";
                    $module = "Subjects Management";

                    $sql_insert_log = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
                    if ($stmt_log = mysqli_prepare($link, $sql_insert_log)) {
                        mysqli_stmt_bind_param($stmt_log, "ssssss", $date, $time, $action, $module, $username, $_SESSION['username']);
                        if (mysqli_stmt_execute($stmt_log)) {
                            // Redirect before any content output
                            header("location: subjects-management.php?delete_success=1");
                            exit();
                        } else {
                            echo "<font color='red'>Error on insert log statement</font>";
                        }
                    }
                } else {
                    echo "Error deleting subject";
                }
            }
        } else {
            echo "<font color='red'>Error fetching username</font>";
        }
    } else {
        echo "<font color='red'>Username not set</font>";
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
		<input type="hidden" name="txtsubject" value="<?php echo trim($_GET['username']); ?>">
		<p>Are you sure you want to delete this account?</p><br>
		<input type="submit" name="btnsubmit" value="Yes">
		<a href="subjects-management.php">No</a>
	</form>

    

</body>
</html>