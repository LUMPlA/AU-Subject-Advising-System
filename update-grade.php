<?php
// Start session and include necessary files
require_once "config.php";
include("session-checker.php");

// Check if form is submitted
if(isset($_POST['btnsubmit'])){
    // Validate and sanitize input data
    $studentNumber = $_GET['studentnumber'];
    $subjectCode = $_GET['subjectcode'];
    $grade = $_POST['cmbChangeGrade'];

    // Update grade in tblgrades
    $sql_update_grade = "UPDATE tblgrades SET grade = ? WHERE studentNumber = ? AND subjectCode = ?";
    if($stmt_update_grade = mysqli_prepare($link, $sql_update_grade)){
        mysqli_stmt_bind_param($stmt_update_grade, "sss", $grade, $studentNumber, $subjectCode);
        if(mysqli_stmt_execute($stmt_update_grade)){
            // Insert log into tbllogs
            $date = date("m/d/Y");
            $time = date("h:i:s");
            $action = "Update";
            $module = "Grades Management";
            $performedby = $_SESSION['username'];
            $sql_log = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
            if($stmt_log = mysqli_prepare($link, $sql_log)){
                mysqli_stmt_bind_param($stmt_log, "ssssss", $date, $time, $action, $module, $studentNumber, $performedby);
                if(mysqli_stmt_execute($stmt_log)){
                            header("Location: grades-management.php?update_success=1&txtsearch=" . urlencode($studentNumber));                          
                            exit();
                } else {
                    $errorMsg = "Error adding log record.";
                }
            }
        } else {
            $errorMsg = "Error updating grade.";
        }
    }
}

// Fetch student information from URL parameters
$studentNumber = $_GET['studentnumber'];
$course = $_GET['course'];
$year = $_GET['year'];
$name = $_GET['name'];
$subjectCode = $_REQUEST['subjectCode']; // Replace this line
$description = $_GET['description'];
$grade = $_GET['grade'];

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create new account - Arellano University Subject Advising System - AUSMS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style> 
        @import url('https://fonts.googleapis.com/css?family=Poppins:wght@400;500&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        #error
        {
            margin-top: 30px;
        }

        body {
            position: relative;
            min-height: 100vh;
            background: #dfdfdf; /* light grey */
        }

        #notif
        {
            style='color: green; 
            text-align: center; 
            font-weight: 600;'
        }
         .header 
         {
            position: relative;        
            left: 0;
            width: 100%;
            background-color: #dfdfdf;
            color: #333;
            padding: 10px 10px;
            box-shadow: 0 4px 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            margin-bottom: 30px;
        }

        .header ul {
            list-style: none;
            margin: 0;
            padding: 0;
            text-align: right; 
            margin-right: 35px;
        }

        .header ul li {
            display: inline-block;
            margin-right: 10px;
            margin-left: 20px;
            font-size: 16px;
        }

        .header ul li:first-child {
            margin-right: 0; /* Remove margin for the first item */
        }

        .header ul li a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
        }

        .header ul li a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
        }

        .header ul li a:hover {
            color: #ccc;
        }

        .header ul li:nth-child(2) {
            margin-right: 40px; /* Adjust space between items */
        }

        #logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9AA5B1;
            letter-spacing: 5px;
            font-size: 24px;
        }

        #logo-container img {
            margin-right: 10px;
        }

        .container 
        {
            margin-top: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px 10px;
        }

        form {
        display: flex;
        flex-direction: column;
        width: 300px;
        background-color: #dfdfdf;
        padding: 20px;
        border-radius: 8px;
        
    }

        input[type="text"],
        input[type="password"],
        select {
            margin-bottom: 15px;
            padding: 8px;
            border: 1px solid black;
            border-radius: 5px;
            width: 100%;


        }

        select {
            width: 100%;
        }

        input[type="submit"],
        a {
            padding: 10px;
            text-align: center;
            background-color: #294D86;
            color: white;
            border: 1px solid black;
            border-radius: 20px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
            font-size: 14px; /* Set the font size */
        }

        input[type="submit"]:hover,
        a:hover {
            background-color: #555;
        }


        footer
        {
        position: fixed;
        background-color: #294D86;
        color: white;
        padding: 10px 0;
        text-align: center;
        z-index: 1000;
        bottom: 0;
        width: 100%;
        font-size: 12px;

        }
    </style>

    
    
</head>
<body>
    <div class="header">
            <ul>               
                <li><a style="background-color: #dfdfdf; border:none;" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    <div id="top">
        <div id="logo-container">
            <img src="LOGO.png" alt="Logo" style="height: 60px; margin-top: 10px;">
            <h1 style="margin-top: 10px; color: #294D86 ;">Arellano University</h1>
        </div>
    </div>
<div class="container">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?studentnumber=' . $studentNumber . '&name=' . urlencode($name) . '&year=' . $year . '&course=' . $course . '&subjectcode=' . urlencode($subjectCode) . '&description=' . urlencode($description)); ?>" method="POST">

                <p id="label">Student Number:</p>
                <input type="text" name="txtStudentNumber" value="<?php echo $studentNumber; ?>" disabled>
                <p id="label">Name:</p>
                <input type="text" name="txtName" value="<?php echo $name; ?>" disabled>
                <p id="label">Course:</p>
                <input type="text" name="txtCourse" value="<?php echo $course; ?>" disabled>
                <p id="label">Year:</p>
                <input type="text" name="txtYear" value="<?php echo $year; ?>" disabled>
                <input type="text" name="txtSubjectCode" value="<?php echo $subjectCode; ?>" disabled>
                <p id="label">Description:</p>
                <input type="text" name="txtDescription" value="<?php echo $description; ?>" disabled>
                <p id="label">Current Grade:</p>
                <input type="text" name="txtCurrentGrade" value="<?php echo $grade; ?>" disabled>
                <p id="label">Change Grade:</p>
                <select name="cmbChangeGrade" required>
                    <option value="">Select Grade</option>
                    <option value="1.0">1.0</option>
                    <option value="1.25">1.25</option>
                    <option value="1.5">1.5</option>
                    <option value="1.75">1.75</option>
                    <option value="2.0">2.0</option>
                    <option value="2.25">2.25</option>
                    <option value="2.5">2.5</option>
                    <option value="2.75">2.75</option>
                    <option value="3.0">3.0</option>
                    <option value="5.0">5.0</option>
                </select><br><br>
                <input type="submit" name="btnsubmit" value="Update" id="submit">
                <a href="grades-management.php">Cancel</a>
            </form>
</div>
 <footer >
            <p>Arellano Technical Ticket Management System.</p>
    </footer>

  
</body>
</html>
