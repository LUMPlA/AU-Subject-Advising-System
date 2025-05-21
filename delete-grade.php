<?php
session_start();
require_once "config.php";

if(isset($_POST['confirm']) && $_POST['confirm'] == 'yes') {
    $studentnumber = $_POST['studentnumber']; // Retrieve student number from POST request

    // Verify that the subject code belongs to the specific student by checking it in tblgrades
    $sql_verify = "SELECT * FROM tblgrades WHERE subjectCode = ? AND studentNumber = ?";
    if($stmt_verify = mysqli_prepare($link, $sql_verify)) {
        mysqli_stmt_bind_param($stmt_verify, "ss", $subjectcode, $studentnumber);
        if(mysqli_stmt_execute($stmt_verify)) {
            $result_verify = mysqli_stmt_get_result($stmt_verify);
            if(mysqli_num_rows($result_verify) > 0) {
                // Delete the subject code from tblgrades
                $sql_delete = "DELETE FROM tblgrades WHERE subjectCode = ? AND studentNumber = ?";
                if($stmt_delete = mysqli_prepare($link, $sql_delete)) {
                    mysqli_stmt_bind_param($stmt_delete, "ss", $subjectcode, $studentnumber);
                    if(mysqli_stmt_execute($stmt_delete)) {
                        // Log the deletion action
                        $sql_log = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
                        if($stmt_log = mysqli_prepare($link, $sql_log)){
                            $date = date("m/d/Y");
                            $time = date("h:i:s");
                            $action = "Delete";
                            $module = "Grades Management";
                            $performedby = $_SESSION['username'];
                            mysqli_stmt_bind_param($stmt_log, "ssssss", $date, $time, $action, $module, $studentnumber, $performedby);
                            if(mysqli_stmt_execute($stmt_log)){
                            header("Location: grades-management.php?delete_success=1&txtsearch=" . urlencode($studentnumber));                          
                          
                            exit();
                            } else {
                                echo "Error logging the action"; // Notify AJAX request of logging error
                            }
                        } else {
                            echo "Error preparing log statement"; // Notify AJAX request of log statement preparation error
                        }
                    } else {
                    }
                } else {
                    echo "Error preparing delete statement"; // Notify AJAX request of delete statement preparation error
                }
            } else {
                echo "Subject code does not belong to the specified student"; // Notify AJAX request if subject code doesn't match student number
            }
        } else {
            echo "Error executing verification query"; // Notify AJAX request of verification query execution error
        }
    } else {
        echo "Error preparing verification statement"; // Notify AJAX request of verification statement preparation error
    }
}
?>