<?php
require_once "config.php";
include("session-checker.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])) {
    $username = trim($_POST['username']);

    // Delete account from tblaccount table
    $sql_delete_account = "DELETE FROM tblaccount WHERE username = ?";
    if ($stmt_delete_account = mysqli_prepare($link, $sql_delete_account)) {
        mysqli_stmt_bind_param($stmt_delete_account, "s", $username);
        if (mysqli_stmt_execute($stmt_delete_account)) {

            // Delete corresponding record from stdaccounts table
            $sql_delete_stdaccount = "DELETE FROM stdaccounts WHERE studentNumber = ?";
            if ($stmt_delete_stdaccount = mysqli_prepare($link, $sql_delete_stdaccount)) {
                mysqli_stmt_bind_param($stmt_delete_stdaccount, "s", $username);
                if (mysqli_stmt_execute($stmt_delete_stdaccount)) {
                    // Insert deletion log
                    $date = date("m/d/Y");
                    $time = date("h:i:sa");
                    $action = "Delete";
                    $module = "Accounts Management";

                    $sql_insert_log = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
                    if ($stmt_insert_log = mysqli_prepare($link, $sql_insert_log)) {
                        mysqli_stmt_bind_param($stmt_insert_log, "ssssss", $date, $time, $action, $module, $username, $_SESSION['username']);
                        if (mysqli_stmt_execute($stmt_insert_log)) {
                            echo "User account deleted";
                            http_response_code(200);
                            exit();
                        } else {
                            echo "<font color='red'>Error on inserting log statement: " . mysqli_error($link) . "</font>";
                        }
                    } else {
                        echo "<font color='red'>Error preparing log statement: " . mysqli_error($link) . "</font>";
                    }
                } else {
                    echo "Error deleting from stdaccounts table: " . mysqli_error($link);
                }
            } else {
                echo "<font color='red'>Error preparing delete statement for stdaccounts table: " . mysqli_error($link) . "</font>";
            }
        } else {
            echo "Error deleting from tblaccount table: " . mysqli_error($link);
        }
    } else {
        echo "<font color='red'>Error preparing delete statement for tblaccount table: " . mysqli_error($link) . "</font>";
    }
}
?>

<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Delete Account - Arellano University Subject Advising System</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "POST">
        <input type="hidden" name="txtusername" value="<?php echo trim($_GET['username']); ?>">
        <p>Are you sure you want to delete this account?</p><br>
        <input type="submit" name="btnsubmit" value="Yes">
        <a href="accounts-management.php">No</a>
    </form>

</body>
</html>