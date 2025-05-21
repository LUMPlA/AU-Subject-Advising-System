<?php
// fetch_subject_codes.php

// Assuming you have established a connection to your database already
require_once "config.php";

if(isset($_GET['course'])) {
    $course = $_GET['course'];

    // Fetch subject codes from tblsubjects based on the selected course
    $sql = "SELECT subjectCode FROM tblsubject WHERE course = ?";
    if($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $course);
        if(mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $subjectCodes = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $subjectCodes[] = $row['subjectCode'];
            }
            echo json_encode($subjectCodes);
        } else {
            echo "Error executing statement";
        }
    } else {
        echo "Error preparing statement";
    }
} else {
    echo "Invalid request";
}
?>
