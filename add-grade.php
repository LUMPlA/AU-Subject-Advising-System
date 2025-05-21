<?php
// Start session and include necessary files
require_once "config.php";
include("session-checker.php");

// Initialize error message variable
$errorMsg = "";

// Check if form is submitted
if(isset($_POST['btnsubmit'])){
    // Validate and sanitize input data
    $studentNumber = $_GET['studentnumber'];
    $subjectCode = $_POST['cmbSubjectCode'];
    $grade = $_POST['cmbGrade'];

    // Check if student already has a grade for the subject code
    $sql_check_grade = "SELECT * FROM tblgrades WHERE studentNumber = ? AND subjectCode = ?";
    if($stmt_check_grade = mysqli_prepare($link, $sql_check_grade)){
        mysqli_stmt_bind_param($stmt_check_grade, "ss", $studentNumber, $subjectCode);
        if(mysqli_stmt_execute($stmt_check_grade)){
            mysqli_stmt_store_result($stmt_check_grade);
            if(mysqli_stmt_num_rows($stmt_check_grade) > 0){
                $errorMsg = "Student already has a grade for this subject code";
            }
        } else {
            $errorMsg = "Error checking for existing grade";
        }
    }

    // If no error, continue with inserting the grade
    if(empty($errorMsg)) {
        // Continue with inserting the grade if no existing grade found

        // Check if all required fields are filled
        if(empty($subjectCode) || empty($grade)){
            $errorMsg = "Subject Code and Grade are required.";
        } else {
            // Insert grade into tblgrades with encoded by and date encoded
            $encodedBy = $_SESSION['username'];
            $dateEncoded = date("m/d/Y");
            $sql = "INSERT INTO tblgrades (studentNumber, subjectCode, grade, encodedBy, dateCreated) VALUES (?, ?, ?, ?, ?)";
            if($stmt = mysqli_prepare($link, $sql)){
                mysqli_stmt_bind_param($stmt, "sssss", $studentNumber, $subjectCode, $grade, $encodedBy, $dateEncoded);
                if(mysqli_stmt_execute($stmt)){
                    // Insert log into tbllogs
                    $date = date("m/d/Y");
                    $time = date("h:i:s");
                    $action = "Add Grade";
                    $module = "Grades Management";
                    $performedby = $_SESSION['username'];
                    $sql_log = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
                    if($stmt_log = mysqli_prepare($link, $sql_log)){
                        mysqli_stmt_bind_param($stmt_log, "ssssss", $date, $time, $action, $module, $subjectCode, $performedby);
                        if(mysqli_stmt_execute($stmt_log)){
                            $_SESSION['status'] = "Grade Added Successfully!";
							header("location: grades-management.php?txtsearch=" . urlencode($studentNumber));
                            exit();
                        } else {
                            $errorMsg = "Error adding log record.";
                        }
                    }
                } else {
                    $errorMsg = "Error adding grade record.";
                }
            }
        }
    }
}

// Fetch student information from URL parameters
$studentNumber = $_GET['studentnumber'];
$course = $_GET['course'];
$year = $_GET['year'];
$name = $_GET['name'];

// Fetch subject codes for the selected course from tblsubjects
$sql_subjects = "SELECT subjectCode, description FROM tblsubject WHERE course = ?";
if($stmt_subjects = mysqli_prepare($link, $sql_subjects)){
    mysqli_stmt_bind_param($stmt_subjects, "s", $course);
    if(mysqli_stmt_execute($stmt_subjects)){
        $result_subjects = mysqli_stmt_get_result($stmt_subjects);
    } else {
        $errorMsg = "Error fetching subjects.";
    }
}
?>
<html>
<title>Update account - AU Student Advising System - AUSAS</title>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Chivo' rel='stylesheet'>
<style>
	* {
	    margin: 0;
	    padding: 0;
	    box-sizing: border-box;
	    color: white;
	    text-decoration: none;
	    list-style: none;
	    font-family: 'Chivo';
	}

	body{
		background: #28282B;
	}

	header{
	    position: fixed;
	    top: 0;
	    width: 100%;
	    height: 90px;
	    padding: 0 10% 0;
	    box-shadow: 0 3px 5px #040200;
	    display: flex;
	    align-items: center;
	    background: #232023;
	    z-index: 1000;
	    cursor: default;
	}

	header .logo{
		margin-right: 20px;
	}

	header .title {
		font-size: 25px;
	}

	.body {
		margin: 100px auto 300px;
		height: 70%;
	}

	form {
		max-width: 25%;
		border: 1px solid black;
		padding: 35px 50px 35px;
		border: solid 1px;
		border-radius: 10px;
		background: #202023;
	}

	input {
		background-color: gray;
		border-style: none;
		border: solid 1px;
		border-radius: 10px;
		padding: 10px;
		font-size: 14px;
		width: 100%;
	}

	input:focus {
		outline: none;
	}

	#submit {
		width: 40%;
		padding: 10px 20px 10px;
		cursor: pointer;
		background: white;
		color: #28282B;
		margin-right: 20px;
	}

	::placeholder {
  		color: white;
	}

	select {
		background: gray;
		border: 1px solid white;
		border-radius: 10px;
		cursor: pointer;
		padding: 9px;
		font-size: 14px;
		width: 100%;
	}

	footer {
	    width: 100%;
	    height: 15%;
	    padding: 10px 10%;
	    display: flex;
	    align-items: center;
	    justify-content: space-between;
	    box-shadow: 0px -3px 5px #040200;
	    background: #232023;
	    margin-top: 20px;
	    cursor: default;
	}

	footer .text {
		font-size: 30px;
	}

	footer .contact-con {
	    text-align: right;
	    color: dimgray;
	    font-size: 14px;
	    float: right;
	}

	footer .contact-con #contact {
		font-size: 16px;
	}

	#label {
		text-align: left;
		margin-bottom: 3px;
		cursor: default;
	}

	.error-message {
        color: red;
        font-size: 16px;
        margin-bottom: 10px;
    }
</style>
</head>
<body>
	<header>
		<div class="logo"><img src='logo.png' width="65" height="65"></div><div class = "title">AUSAS - Update Account</div>
	</header>
	<div class="body">
        <center>
            <!-- Display error message if exists -->
            
            <h3><p>Fill up this form and submit in order to add a new grade</p></h3><br>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?studentnumber=' . $studentNumber . '&name=' . $name . '&year=' . $year . '&course=' . $course ); ?>" method="POST">
            	<?php if (!empty($errorMsg)): ?>
                <div class="error-message"><?php echo $errorMsg; ?></div>
            	<?php endif; ?>
                <p id="label">Student Number:</p>
                <input type="text" name="txtStudentNumber" value="<?php echo $studentNumber; ?>" disabled><br><br>
                <p id="label">Name:</p>
                <input type="text" name="txtName" value="<?php echo $name; ?>" disabled><br><br>
                <p id="label">Course:</p>
                <input type="text" name="txtCourse" value="<?php echo $course; ?>" disabled><br><br>
                <p id="label">Year:</p>
                <input type="text" name="txtYear" value="<?php echo $year; ?>" disabled><br><br>
                <p id="label">Subject Code:</p>
                <select name="cmbSubjectCode" required>
                    <option value="">Select Subject Code</option>
                    <?php while($row_subject = mysqli_fetch_assoc($result_subjects)): ?>
                        <option value="<?php echo $row_subject['subjectCode']; ?>"><?php echo $row_subject['subjectCode']; ?></option>
                    <?php endwhile; ?>
                </select><br><br>
                <p id="label">Description:</p>
                <input type="text" name="txtDescription" id="txtDescription" disabled><br><br>
                <p id="label">Grade:</p>
                <select name="cmbGrade" required>
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
                <input type="submit" name="btnsubmit" value="Submit" id="submit">
                <a href="grade-management.php">Cancel</a>
            </form>
        </center>
    </div>
	<footer>
		<div class = "text">
			Update Account Page - AUSAS
		</div>
		<div class="contact-con"><span id="contact">Arellano University</span>
	        <br>1002 Jacinto St, Quezon, Mabini, Plaridel
	        <br>+63 912 345 6789
	        <br>email.address.123@gmail.com
	    </div>
	</footer>
	<script>
        $(document).ready(function(){
            // Add event listener for select element
            $('select[name="cmbSubjectCode"]').change(function(){
                var subjectCode = $(this).val(); // Get selected subject code
                // Send AJAX request to fetch description
                $.ajax({
                    url: 'get-description.php', // Replace 'get-description.php' with the actual path to your PHP script
                    method: 'POST',
                    data: {subjectCode: subjectCode},
                    success: function(response){
                        // Update description input field with fetched description
                        $('#txtDescription').val(response);
                    },
                    error: function(xhr, status, error){
                        console.error(error);
                    }
                });
            });
        });
    </script>
</body>
</html>