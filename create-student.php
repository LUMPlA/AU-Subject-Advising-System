<?php
require_once "config.php";
include("session-checker.php");

if (isset($_POST['btnsubmit'])) {
    // Check if the student number already exists
    $sql = "SELECT * FROM stdaccounts WHERE studentNumber = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $_POST['txtstdnum']);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) == 0) {
                // If the student number does not exist, proceed with insertion
                $sql = "INSERT INTO stdaccounts (studentNumber, lastName, firstName, middleName, course, yearLevel, createdBy, dateCreated) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                if ($stmt = mysqli_prepare($link, $sql)) {
                    // Fetch username from tblaccount
                    $sql_username = "SELECT username FROM tblaccount WHERE username = ?";
                    if ($stmt_username = mysqli_prepare($link, $sql_username)) {
                        mysqli_stmt_bind_param($stmt_username, "s", $_POST['txtstdnum']);
                        if (mysqli_stmt_execute($stmt_username)) {
                            mysqli_stmt_store_result($stmt_username);
                            if (mysqli_stmt_num_rows($stmt_username) == 0) {
                                // Insert into tblaccount
                                $username = $_POST['txtstdnum'];
                                $password = "Arellano123";
                                $usertype = "Student";
                                $status = "Active";
                                $createdby = $_SESSION['username'];
                                $datecreated = date("m/d/Y");  // MySQL datetime format

                                $sql_insert_account = "INSERT INTO tblaccount (username, password, usertype, status, createdby, datecreated) VALUES (?, ?, ?, ?, ?, ?)";
                                if ($stmt_insert_account = mysqli_prepare($link, $sql_insert_account)) {
                                    mysqli_stmt_bind_param($stmt_insert_account, "ssssss", $username, $password, $usertype, $status, $createdby, $datecreated);
                                    if (mysqli_stmt_execute($stmt_insert_account)) {
                                        // Insert account successful
                                        // Proceed with student record insertion
                                        $course = $_POST['cmbcourse'];
                                        $yearLevel = $_POST['cmblevel'];
                                        $datecreated = date("m/d/Y"); // Changed date format to match MySQL date format
                                        mysqli_stmt_bind_param($stmt, "ssssssss", $_POST['txtstdnum'], $_POST['txtlastname'], $_POST['txtfirstname'], $_POST['txtmiddlename'], $course, $yearLevel, $createdby, $datecreated);

                                        if (mysqli_stmt_execute($stmt)) {
                                            // Insertion successful, proceed with logging
                                            $sql_log = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
                                            if ($stmt_log = mysqli_prepare($link, $sql_log)) {
                                                $date = date("m/d/Y");
                                                $time = date("h:i:sa");
                                                $action = "Create";
                                                $module = "Students Management";
                                                mysqli_stmt_bind_param($stmt_log, "ssssss", $date, $time, $action, $module, trim($_POST['txtstdnum']), $createdby);

                                                if (mysqli_stmt_execute($stmt_log)) {
                                                    header("location: student-management.php?success=1");
                                                    exit();
                                                } else {
                                                    echo "<font color='red'>Error on insert log statement</font>";
                                                }
                                            } else {
                                                echo "<font color='red'>Error preparing log statement</font>";
                                            }
                                        } else {
                                            echo "<font color='red'>Error adding new account</font>";
                                        }
                                    } else {
                                        echo "<font color='red'>Error adding new account</font>";
                                    }
                                } else {
                                    echo "<font color='red'>Error preparing insertion query</font>";
                                }
                            } else {
                                echo "<p id='error' style='color: red; text-align: center;'>Username already in use.</p>";
                            }
                        } else {
                            echo "<font color='red'>Error executing username query</font>";
                        }
                    } else {
                        echo "<font color='red'>Error preparing username query</font>";
                    }
                } else {
                    echo "<font color='red'>Error preparing insertion query</font>";
                }
            } else {
                echo "<p id='error' style='color: red; text-align: center;'>Student Number already in use.</p>";
            }
        } else {
            echo "<font color='red'>Error executing query to find if user exists.</font>";
        }
    } else {
        echo "<font color='red'>Error preparing query to find if user exists.</font>";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Create New Account | Arellano University Subject Advising System</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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
        margin-top: 50px;
        position: relative;
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
    $(document).ready(function() {
        $('.cmbcourse').select2({
            placeholder: "--SELECT COURSE--",
            allowClear: true // Add an option to clear the selection
        });
    });
</script>


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
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <label for="txtstdnum">Student Number</label>
		<input type="text" name="txtstdnum" required><br>
        <label for="txtlastname">Last Name</label>  
		<input type="text" name="txtlastname" required><br>
        <label for="txtfirstname">First Name</label>
		<input type="text" name="txtfirstname" required><br>
        <label for="txtmiddlename">Middle Name</label>
		<input type="text" name="txtmiddlename">
		Course: <select name="cmbcourse" class="cmbcourse" required>
			<option value="">SELECT COURSE</option>
            <option value="BA in English">BA in English</option>
            <option value="BA in History">BA in History</option>
            <option value="BA in Political Science">BA in Political Science</option>
            <option value="BA in Psychology">BA in Psychology</option>
            <option value="Bachelor in Elementary Education">Bachelor in Elementary Education</option>
            <option value="Library & Information System">Library & Information System</option>
            <option value="Bachelor of Performing Arts">Bachelor of Performing Arts</option>
            <option value="Bachelor of Physical Education">Bachelor of Physical Education</option>
            <option value="Bachelor of Secondary Education">Bachelor of Secondary Education</option>
            <option value="BS in Accountancy">BS in Accountancy</option>
            <option value="Accounting Information Systems">Accounting Information Systems</option>
            <option value="BS Business Administration">BS Business Administration</option>
            <option value="BS in Computer Science">BS in Computer Science</option>    
            <option value="BS in Criminology">BS in Criminology</option>
            <option value="BS in Hospitality Management">BS in Hospitality Management</option>
            <option value="BS in Information Technology">BS in Information Technology</option>
            <option value="BS in Medical Technology">BS in Medical Technology</option>
            <option value="BS in Midwifery">BS in Midwifery</option>
            <option value="BS in Nursing">BS in Nursing</option>
            <option value="BS in Pharmacy">BS in Pharmacy</option>
            <option value="BS in Physical Therapy">BS in Physical Therapy</option>
            <option value="BS in Radiologic Technology">BS in Radiologic Technology</option>
            <option value="BS in Tourism Management">BS in Tourism Management</option>     
        </select><br>
		Year Level: <select name="cmblevel" class="cmblevel" required>
			<option value="">--SELECT YEAR LEVEL--</option>
			<option value="FIRST">FIRST</option>
			<option value="SECOND">SECOND</option>
			<option value="THIRD">THIRD</option>
			<option value="FOURTH">FOURTH</option>
		</select><br>
		<input type="submit" name="btnsubmit" value="Submit"><br>
		<a href="student-management.php">Cancel</a>
	</form>
</div>
 <footer >
            <p>Arellano Technical Ticket Management System.</p>
    </footer>
</body>
</html>