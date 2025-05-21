<?php
require_once "config.php";
include("session-checker.php");
if (isset($_POST['btnsubmit'])) {
    $sql = "SELECT * FROM tblaccount WHERE username = ?";
    if($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $_POST['txtusername']);
        if (mysqli_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) == 0) {
                //insert account
                $sql = "INSERT INTO tblaccount (username, password, usertype, status, createdby, datecreated) VALUES (?, ?, ?, ?, ?, ?)";
                if($stmt = mysqli_prepare($link, $sql)) {
                    $status = "Active";
                    $datecreated = date("m/d/Y"); // Changed date format to match MySQL date format
                    mysqli_stmt_bind_param($stmt, "ssssss", $_POST['txtusername'], $_POST['txtpassword'], $_POST['cmbtype'], $status, $_SESSION['username'], $datecreated);
                    if(mysqli_stmt_execute($stmt)) {
                        $sql = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
                        if ($stmt = mysqli_prepare($link, $sql)) {
                            $date = date("m/d/Y");
                            $time = date("h:i:sa");
                            $action = "Create";
                            $module = "Accounts Management";
                            mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, trim($_POST['txtusername']), $_SESSION['username']);
                            if(mysqli_stmt_execute($stmt)) {
                                echo "User account created!";
                                header("location: accounts-management.php?success=1");
                                exit();
                            }
                            else {
                                echo "<font color = 'red'>Error on insert log statement</font>";
                            }
                        }
                    }
                    else {
                        echo "Error on adding new account";
                    }
                }
            }           
            else {
                echo "<p id='error' style='color: red; text-align: center;'>Username already in use.</p>";
            }
        }
    }
    else {
        echo "Error on finding if user exists.";
    }
}
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create new account - Arellano University Subject Advising System - AUSMS</title>
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
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="txtusername">Username</label><br>
        <input type="text" placeholder="" name="txtusername" required>
        <label for="txtpassword">Password</label><br>
        <input type="password" name="txtpassword" required>
        <label for="cmbtype">Usertype</label><br>

        <select name="cmbtype" id="cmbtype" required>
            <option value="">--Select User type--</option>
            <option value="Administrator">Administrator</option>
            <option value="Registrar">Registrar</option>
            <option value="Staff">Staff</option>

            
        </select><br><br>
        <input type="submit" name="btnsubmit" value="Submit"><br>   
        <a href="accounts-management.php">Cancel</a>
    </form>    
</div>
 <footer >
            <p>Arellano Technical Ticket Management System.</p>
    </footer>
</body>
</html>
