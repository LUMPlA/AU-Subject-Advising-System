<?php
require_once "config.php";
include ("session-checker.php");
if(isset($_POST['btnsubmit'])) { //update account
	$sql = "UPDATE tblaccount SET password = ?, usertype = ?, status = ? WHERE username = ?";
	if($stmt = mysqli_prepare($link, $sql)) {
		mysqli_stmt_bind_param($stmt, "ssss", $_POST['txtpassword'], $_POST['cmbtype'], $_POST['rbstatus'], $_GET['username']);
		if(mysqli_stmt_execute($stmt)) {
			$sql = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
			if ($stmt = mysqli_prepare($link, $sql)) {
				$date = date("m/d/Y");
				$time = date("h:i:sa");
				$action = "Update";
				$module = "Accounts Management";
				mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, $_GET['username'], $_SESSION['username']);
				if(mysqli_stmt_execute($stmt)) {
					echo "User account updated!";
					header("location: accounts-management.php?update_success=1");

					exit();
				}
				else {
					echo "<font color = 'red'>Error on insert log statement</font>";
				}
			}
		}
		else {
			echo "<font color = 'red'>Error on update statement. </font>";
		}
	}
}
else { //loading the data to the form
	if(isset($_GET['username']) && !empty(trim($_GET['username']))) {
		$sql = "SELECT * FROM tblaccount WHERE username = ?";
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<head>

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
            margin-top: 4px;
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

         input[type="radio"] {
        margin-right: 250px; /* Add some margin to separate radio buttons */
        vertical-align: middle; /* Align radio buttons vertically */
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

         .radio-container {
        display: inline-flex; /* Display containers as inline flex */
        align-items: center; /* Align items vertically */
        margin-right: 20px; /* Adjust margin between radio buttons and labels */
    }

    .radio-container input[type="radio"] {
        margin-right: 5px; /* Adjust margin between radio buttons */
    }

     
        
    </style>
<script>
    function togglePasswordVisibility() {
            const passwordInput = document.getElementById('txtpassword');
            const showPasswordCheckbox = document.getElementById('showPassword');

            if (showPasswordCheckbox.checked) {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }
</script>

</head>
<body>
	<div class="header">
            <ul>
                
                <li><a style="background: none; border: none;" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    <div id="top">
        <div id="logo-container">
            <img src="LOGO.png" alt="Logo" style="height: 60px; margin-top: 10px;">
            <h1 style="margin-top: 5px; color: #294D86 ;">Arellano University</h1>
        </div>
    </div>
	<div class="container">
	<form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method = "POST">
		Username: <?php echo $account['username']; ?> <br><br>
        <label for="txtpassword">Password</label><br>
		<input type="password" name="txtpassword" id="txtpassword" value="<?php echo $account['password']; ?>" required>
      <label style="font-size: 12px; display: flex; align-items: center; justify-content: flex-end; color: #294D86;">
    <input type="checkbox" id="showPassword" onclick="togglePasswordVisibility()" style="margin-right: 5px;">
    <span>Show Old Password</span>
</label><br>




		Current User type: <?php echo $account['usertype']; ?> <br><br>
        <?php if($account['usertype'] !== 'Student'): ?>
		<select name="cmbtype" class="cmbtype" required>
			<option value="">--CHANGE USER TYPE--</option>
			<option value="Administrator">Administrator</option>
			<option value="Registrar">Registrar</option>
			<option value="Staff">Staff</option>
		</select><br>
        <?php else: ?>
            <input type="hidden" name="cmbtype" value="<?php echo $account['usertype']; ?>">
            <?php endif; ?>
		<?php
			$status = $account['status'];
			if($status == 'Active') {
				?>
                <label for="radio-container">Change Status</label><br>
                <div class="radio-container">
                    <input type="radio" name="rbstatus" value="Active" id="active" checked>
                    <label for="active">Active</label>
                </div>                    
                <div class="radio-container"><input type="radio" name="rbstatus" value="Inactive" id="inactive">
                    <label for="inactive">Inactive</label><br>
                </div>
					
                <?php
			}
			else {
			?> <input type="radio" name="rbstatus" value="Active" checked>Active<br>
				<input type="radio" name="rbstatus" value="Inactive">Inactive<br> <?php
			}
		?><br>
		<input type="submit" name="btnsubmit" value="Update"><br>
		<a href="accounts-management.php">Cancel</a>
	</form>
	</div>

 <footer >
            <p>Arellano Technical Ticket Management System.</p>
    </footer>

     
</body>
</html>