<?php session_start();?>

<html>
<title>Student Accounts Management - Arellano Technical Ticket Management System - AUTMS</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<link rel="stylesheet" type= "text/css" href="css/student-management.css">
<style>

    @import url('https://fonts.googleapis.com/css?family=Poppins:wght@400;500&display=swap');

    .table-container 
    {
        margin-left: 25px;
        margin-right: 25px;
    }


    #login-form
    {
        margin-left: 30px;
    }

.modal {
    display: none;
    position: fixed;
    z-index: 1; /* Set a higher z-index value */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4); /* Semi-transparent background */
    padding-top: 60px;
    text-align: center;
}

.modal-content {
    background-color: #ddd; /* Light Yellow */
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

.close {
    color: #877866; /* Olive Green */
    float: right;
    font-size: 28px;
    font-weight: bold;
}


.close:hover,
.close:focus {
    color: #d32f2f; /* Tan */
    cursor: pointer;
}

.modal-content a {
    display: inline-block;
    padding: 8px 12px;
    margin: 4px;
    border: 1px solid transparent;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.3s, color 0.3s, border-color 0.3s;
}

.modal-content a.delete {
    background-color: #333; /* dark Brown */
    border-color: #333; /* dark Brown */
    color: white; 
}

.modal-content a.update {
    background-color: #294D86; /* Yellow */
    border-color: #294D86; /* yellow */
    color: white;
}

.modal-content a.delete:hover {
    background-color: grey; 
    color: #333; 
    
}
.modal-content a.update:hover {
    background-color: grey; 
    color: white; 
}

.navbar-nav li:hover {
    background-color: #294D86; /* Change this to the desired background color */
}

.navbar-nav li:hover a {
    color: white !important; /* Change this to the desired text color */
}

.type
{
    color: white !important; 
    background-color: #294D86; 
    width: 120px;
    height: 28px;
    text-align: center;
}

.create-new-account{
    color: #333;
}

.create-new-account:hover{
    text-decoration: underline;
    color: #333;
}

::-webkit-scrollbar {
            width: 5px;
}

        
::-webkit-scrollbar-track {
            background: transparent;
}

        
::-webkit-scrollbar-thumb {
            background: #333333;
}



</style>

<script>
    // Function to hide the notification after 3 seconds
    setTimeout(function() {
        document.getElementById('notification').style.visibility = 'hidden';
    }, 3000); // 3000 milliseconds = 3 seconds
</script>
<script>
     function confirmDelete(username) {
    document.getElementById('deleteModal').style.display = 'block';
    document.getElementById('deleteUsername').innerHTML = username;

    document.getElementById('btnYes').onclick = function () {
        // Handle the deletion using AJAX
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete-account.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
        console.log(xhr.responseText); // Log the response text
        if (xhr.status == 200) {
            var result = xhr.responseText.trim();
            if (result === "success") {
                // Your success logic
            } else {
                alert("Error: Unable to delete the account. Server response: " + result);
            }
        } else {
            alert("Error: Unable to delete the account. Server returned status code " + xhr.status);
        }
    }
};}

</script>

<body style="background-color: #dfdfdf;">
      <section style="background: #dfdfdf; position: relative; left: 0; width: 100%; background-color: #dfdfdf; color: #333; padding: 0px 0px; box-shadow: 0 4px 5px rgba(0, 0, 0, 0.1); z-index: 1000;" class="header">
            <div class="container-fluid">
                <link rel="stylesheet" href="css/default.css" id="theme-color">
                <nav class="navbar navbar-expand-md navbar-dark">
                    <a style="color: #294D86; font-weight:bold" class="navbar-brand heading-black">AUSAS - Accounts Management</a>
                    <!-- Toggle Button -->
                    <button class="navbar-toggler navbar-toggler-right border-0" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                        <span data-feather="grid"></span>
                    </button>
                    <!-- Navbar Links -->
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a style="color: #333; font-family: Poppins;" class="nav-link page-scroll" href="accounts-management.php"><i class="fas fa-users"></i>Accounts</a>
                            </li>
                            <li class="nav-item">
                                <a style="color: #333; font-family: Poppins;" class="nav-link page-scroll" href="subjects-management.php"><i class="fas fa-book-medical"></i>Subjects</a>
                            </li>
                            <li class="nav-item">
                                <a style="color: #333; font-family: Poppins;" class="nav-link page-scroll" href="student-management.php"><i class="fas fa-graduation-cap"></i>Students</a>
                            </li>
                            <li class="nav-item">
                                <a style="color: #333; font-family: Poppins;" class="nav-link page-scroll" href="grades-management.php"><i class="fas fa-graduation-cap"></i>Grades</a>
                            </li>
                            <li class="nav-item">
                                <a style="color: #333; font-family: Poppins;" class="nav-link page-scroll" href="subject-advising.php"><i class="fas fa-graduation-cap"></i>Advising</a>
                            </li>
                            <li class="nav-item">
                                <a style="color: #333; font-family: Poppins;" class="nav-link page-scroll" href="<?php echo ($_SESSION['usertype'] === 'Administrator') ? 'index.php' : ($_SESSION['usertype'] === 'Staff' ? 'index-staff.php' : 'index-registrar.php'); ?>"><i class="fas fa-sign-out-alt"></i>Home</a>
                            </li>
                            <li class="nav-item">
                                <a style="color: #333; font-family: Poppins;" class="nav-link page-scroll" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                            </li>
                            <li style="color: #294D86;" class="nav-item">
                                <a style="color: #294D86;" class="nav-link page-scroll d-flex flex-row align-items-center text-primary" href="#">
                                    <em style="font-family: Poppins; color: #294D86;" data-feather="layout" width="18" height="18" class="mr-2"></em>
                                    <?php echo '<font style="color: #294D86;" class = "type">'. $_SESSION['usertype'] . '</font>'; ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </section>
    <div id="top">
        <div id="logo-container">
            <img src="LOGO.png" alt="Logo" style="height: 60px; margin-top: 10px;">
            <h1 style="margin-top: 10px; color: #294D86 ;">Arellano University</h1>
        </div>
    </div>
    <?php

        //check if there is a session recorder
        if(isset($_SESSION['username'])){
            echo "<div class='login'>
            <h1 style='font-size: 32px; color:#333;' class='welcome-message'>Welcome, " . $_SESSION['username'] . "</h1>
            </div>";

            echo "<h4 style='font-size: 16px; font-weight: 400; color: #294D86;' class='welcome-message'>Account type: " . $_SESSION['usertype'] . "</h4>";
        }
        else
        {
            //redirect the user to the login page
            header("location: login.php");
        }

        if(isset($_GET['success']) && $_GET['success'] == 1) {
            echo "<div id='notification' style='visibility: visible;'><p class='notif' style='color: white; text-align: center; font-weight: 600; position: fixed;
    left: 36%;
    background-color: #50C878;
    width: 400px;
    height: 30px;
    align-items: center;
    color: white;'>Account created!</p></div>
";
        }

        if(isset($_GET['delete_success']) && $_GET['delete_success'] == 1) {
     echo "<div id='notification' style='visibility: visible;'><p class='notif' style='color: white; text-align: center; font-weight: 600; position: fixed;
    left: 36%;
    background-color: #50C878;
    width: 400px;
    height: 30px;
    align-items: center;
    color: white;'>Account deleted!</p></div>
";
        }

    if(isset($_GET['update_success']) && $_GET['update_success'] == 1) {
    echo "<div id='notification' style='visibility: visible;'><p class='notif' style='color: white; text-align: center; font-weight: 600; position: fixed;
    left: 36%;
    background-color: #50C878;
    width: 400px;
    height: 30px;
    align-items: center;
    color: white;'>Account updated!</p></div>
";
        }
    ?>
    <form id="login-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
        <input type = "text" name = "txtsearch">
        <input type = "submit" name = "btnsearch" value = "Search">

        
            <li style="text-align: right; margin-right: 45px; color: #333;"><a class="create-new-account" href="create-account.php"><i style="margin-right: 10px; color: #333;" class="fas fa-user-plus"></i>Create New Account</a></li>
        
    </form>



<div class="table-container">
    <?php
function buildtable($result){
    if(mysqli_num_rows($result) > 0){
        //create the table using html

        echo "<table>";
        //create the header
        echo "<tr>";
        echo "<th>Username</th><th>Usertype</th><th>Status</th><th>Created by</th><th>Date Created</th><th>Action</th>";
        echo "</tr>";
        echo "<br>";
        //display the data of the table
        while ($row = mysqli_fetch_array($result)){
             echo "<tr data-username='" . $row['username'] . "'>";
    echo "<td>" . $row['username'] . "</td>";
    echo "<td>" . $row['usertype'] . "</td>";
    echo "<td>" . $row['status'] . "</td>";
    echo "<td>" . $row['createdby'] . "</td>";
    echo "<td>" . $row['datecreated'] . "</td>";
    echo "<td class='action-buttons'>";
    echo "<a class='update' href='update-account.php?username={$row['username']}'>Update</a>";
    echo "<a style='color: #fff;'class='delete' onclick='confirmDelete(\"{$row['username']}\")'>Delete</a>";
    echo "</td>";
    echo "</tr>";
        }
        echo "</table>";
    }
    else{
        echo "No record/s found.";
    }
}


//display table
require_once "config.php";

//search
if(isset($_POST['btnsearch'])){
    $sql = "SELECT * FROM tblaccount WHERE username LIKE ? OR usertype LIKE ? ORDER BY username";
    if($stmt = mysqli_prepare($link, $sql)){
        $searchvalue = '%' . $_POST['txtsearch'] . '%';
        mysqli_stmt_bind_param($stmt, "ss", $searchvalue, $searchvalue);
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            buildtable($result);
        }
    }
    else{
        echo "Error on search";
    }
}
else {
    // Load the data from the accounts table
    $sql = "SELECT * FROM tblaccount ORDER BY username";
    if ($stmt = mysqli_prepare($link, $sql)) {
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            buildtable($result);
        }
    } else {
        echo "Error on accounts load";
    }
}
?>
</div>

<footer >
    <p>Arellano Subject Advising System.</p>
</footer>

 <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p style="color: #333;">Are you sure you want to delete the account with username <span id="deleteUsername"></span>?</p>
            <a style="background-color: #333; border-color: #333; color: white;" id="btnYes" class="delete" href="#">Yes</a>
            <a class="update" onclick="closeModal()">No</a>
        </div>
    </div>

        <script>
            function confirmDelete(username) {
                document.getElementById('deleteModal').style.display = 'block';
                document.getElementById('deleteUsername').innerHTML = username;

                document.getElementById('btnYes').onclick = function () {
                    // Handle the deletion using AJAX
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "delete-grade.php", true);
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            var result = xhr.responseText.trim();
                            if (result === "success") {
                                location.reload(); // Refresh the page after successful deletion
                            } else {
                                window.location.href = 'accounts-management.php?delete_success=1';  
                            }
                        }
                    };
                    xhr.send("username=" + username);

                    closeModal();
                };
            }

            function closeModal() {
                document.getElementById('deleteModal').style.display = 'none';
            }
        </script>





</body>
</html>