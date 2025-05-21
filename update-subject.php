<?php
require_once "config.php";
include("session-checker.php");

if (isset($_POST['btnsubmit'])) {
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
        $sql = "UPDATE tblsubject SET description = ?, unit = ?, course = ?, prerequisite1 = ?, prerequisite2 = ?, prerequisite3 = ? WHERE subjectCode = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssssss", $_POST['txtdescription'], $_POST['cmbunit'], $_POST['cmbcourse'], $_POST['cmbprerequisite1'], $_POST['cmbprerequisite2'], $_POST['cmbprerequisite3'], $_GET['username']);
            if (mysqli_stmt_execute($stmt)) {
                $date = date("m/d/Y");
                $time = date("h:i:sa");
                $action = "Update";
                $module = "Subjects Management";

                $sql_insert_log = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
                if ($stmt_log = mysqli_prepare($link, $sql_insert_log)) {
                    mysqli_stmt_bind_param($stmt_log, "ssssss", $date, $time, $action, $module, $_GET['username'], $_SESSION['username']);
                    if (mysqli_stmt_execute($stmt_log)) {
                        // Redirect before any content output
                         header("location: subjects-management.php?update_success=1");
                                        exit();
                    } 
                    else 
                    {
                        echo "<font color='red'>Error on insert log statement</font>";
                    }
                }
            } 
            else {
                echo "Error updating account";
            }
        }
    } else {
        echo "<font color='red'>Error fetching username</font>";
    }
}
else { //loading the date to the form
	if(isset($_GET['username']) && !empty(trim($_GET['username']))) {
		$sql = "SELECT * FROM tblsubject WHERE subjectCode = ?";
		if ($stmt = mysqli_prepare($link, $sql)) {
			mysqli_stmt_bind_param($stmt, "s", $_GET['username']);
			if(mysqli_stmt_execute($stmt)) {
				$result = mysqli_stmt_get_result($stmt);
				$account = mysqli_fetch_array($result, MYSQLI_ASSOC);
			}
			else {
				echo "<font color = 'red'>Error on loading account data.</font>";
			}
		}
	}
}

?>
<html>
<title>Update Account - AU Subject Advising System - AUSMS</title>
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
        	margin-top: 5px;
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
            margin-top: 10px;
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
        margin-top: 50px;
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
            placeholder: "--CHANGE COURSE--",
            allowClear: true // Add an option to clear the selection
        });
    });
</script>

<body>
	<div class="header">
            <ul>
                
                <li><a style="background: none; border: none;" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
	<div id="top">
        <div id="logo-container">
            <img src="LOGO.png" alt="Logo" style="height: 60px; margin-top: 10px;">
            <h1 style="margin-top: 10px; color: #294D86 ;">Arellano University</h1>
        </div>
    </div>
    <div class="container">
	<form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method = "POST">
		Subject Code: <?php echo $account['subjectCode']; ?> <br>
		Description: <input type = "text" name="txtdescription" value = "<?php echo $account['description']; ?>"><br>
        Current Unit: <?php echo $account['unit']; ?> <br>
        <select name="cmbunit" class="cmbunit" required>
            <option value="">CHANGE UNIT</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="5">5</option>
        </select><br>
		
		Current Course: <?php echo $account['course']; ?> <br>
		<select name="cmbcourse" id ="cmbcourse" required>
			<option value="">Change Course</option>
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
        <p id="label">Current Prerequisite 1:</p>
            <input type="text" name="txtprerequisite1" value="<?php echo $account['prerequisite1']; ?>" disabled>
            <p id="label">Change Prerequisite 1:</p>
            <select name="cmbprerequisite1" id="cmbprerequisite1" placeholder="Prerequisite 1">
                <option value="">NONE</option>
            </select><br>
            <p id="label">Current Prerequisite2:</p>
            <input type="text" name="txtprerequisite2" value="<?php echo $account['prerequisite2']; ?>" disabled>
            <p id="label">Change Prerequisite 2:</p>
            <select name="cmbprerequisite2" id="cmbprerequisite2" placeholder="Prerequisite 2">
                <option value="">NONE</option>
            </select><br>
            <p id="label">Current Prerequisite3:</p>
            <input type="text" name="txtprerequisite3" value="<?php echo $account['prerequisite3']; ?>" disabled>
            <p id="label">Change Prerequisite 3:</p>
            <select name="cmbprerequisite3" id="cmbprerequisite3" placeholder="Prerequisite 3">
                <option value="">NONE</option>
            </select><br>

		<input type="submit" name="btnsubmit" value="Update"><br>
		<a style="margin-bottom: 20px;" href="subjects-management.php">Cancel</a>
	</form>
</div>
<footer >
            <p>Arellano Subject Advising System.</p>
    </footer>

    <script>
        // JavaScript to populate prerequisite comboboxes
        function populatePrerequisites() {
            var cmbcourse = document.getElementById("cmbcourse");
            var cmbprerequisite1 = document.getElementById("cmbprerequisite1");
            var cmbprerequisite2 = document.getElementById("cmbprerequisite2");
            var cmbprerequisite3 = document.getElementById("cmbprerequisite3");
            var selectedCourse = cmbcourse.value;

            // Clear previous options
            cmbprerequisite1.innerHTML = "";
            cmbprerequisite2.innerHTML = "";
            cmbprerequisite3.innerHTML = "";

            // Add "None" option
            var noneOption = document.createElement("option");
            noneOption.value = "";
            noneOption.text = "NONE";
            cmbprerequisite1.add(noneOption.cloneNode(true));
            cmbprerequisite2.add(noneOption.cloneNode(true));
            cmbprerequisite3.add(noneOption.cloneNode(true));

            // Fetch subject codes based on selected course
            if (selectedCourse !== "") {
                // Send AJAX request to fetch subject codes
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            var subjectCodes = JSON.parse(xhr.responseText);
                            // Populate comboboxes with subject codes
                            subjectCodes.forEach(function(subjectCode) {
                                var option1 = document.createElement("option");
                                option1.text = subjectCode;
                                cmbprerequisite1.add(option1);

                                var option2 = document.createElement("option");
                                option2.text = subjectCode;
                                cmbprerequisite2.add(option2);

                                var option3 = document.createElement("option");
                                option3.text = subjectCode;
                                cmbprerequisite3.add(option3);
                            });
                        } else {
                            console.error("Error fetching subject codes");
                        }
                    }
                };
                xhr.open("GET", "get-subject-codes.php?course=" + selectedCourse, true);
                xhr.send();
            }
        }

        // Call populatePrerequisites() when the page loads
        window.addEventListener("load", populatePrerequisites);

        // Call populatePrerequisites() when the course selection changes
        document.getElementById("cmbcourse").addEventListener("change", populatePrerequisites);
    </script>
</body>
</html>