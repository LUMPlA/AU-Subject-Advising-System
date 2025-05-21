<?php
  session_start();
  if(isset($_SESSION['status'])){
            echo "<script>alert('" . $_SESSION['status'] . "')</script>";
            unset($_SESSION['status']);
        }
?>
<html>
<title>Grades Management - Arellano Subject Advising System - AUSAS</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<link rel="stylesheet" type= "text/css" href="css/student-management.css">
<style>

    .search {
            width: 65%;
            margin: 130px auto 35px;
            display:flex;
            align-items: center;
            justify-content: center;
        }

        .search a:hover {
            text-decoration: underline;
        }

        .search form {
            display: flex;
            border-radius: 10px;
        }

      .search form #text {
            width: 500px;
            font-size: 16px;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
            border: solid 2px gray;
            padding: 5px 10px;
            background-color: #dfdfdf;
        }

       .search form #submit {
            width: 70px;
            padding: 0 10px;
            background-color: #333;
            color: #dfdfdf;
            border-style: none;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            cursor: pointer;
        }


 .studentinfo {
            margin: auto;
            width: 80%;
            cursor: default;
            margin-bottom: 30px;
        }

       .studeninfo p {
            font-size: 18px;
        }

        .studentinfo table {
            margin: auto;
            width: 100%;
            background: #232023;
            border: solid 2px gray;
            padding: 15px;
            border-radius: 10px;
        }

      .studentinfo table td {
            background: #dfdfdf;
            padding: 8px;
            text-align: left;
            border: solid 1px gray;
            width: 50%;
        }

      .studentinfo table td#left{
            padding-left: 50px;
        }

       .studentinfo table td#right{
            padding: 5px 10px 5px;
        }

       .studentinfo table td a {
            padding: 5px;
            border-radius: 10px;
        }

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


.add-grade a.delete    
{
    background-color: #333; /* Light Brown */
    border-color: #333; /* Light Brown */
    color: white; /* Red */
    margin-left: 0px;
    display: inline-block;
    padding: 6px 15px;
    border: none;
    border-radius: 20px;
    cursor: pointer;
    transition: background-color 0.3s;
    font-size: 12px;
}

.modal {
   display: none;
    position: fixed;
    z-index: 1000; 
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.8); 
    padding-top: 50px;
    text-align: center;
}



.modal-content {
    background-color: #ddd; 
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    display: inline-block; 
    margin-top: 15%; 
    max-width: 60%;
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
        xhr.open("POST", "delete-grade.php", true);
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

<body>
      <div class="header">
            <ul>
                <a href="<?php echo ($_SESSION['usertype'] === 'Student') ? 'index-student.php' : 'index-registrar.php'; ?>" name="home">
        <i class="fas fa-sign-out-alt"></i> Home
    </a>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
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
            <h1 style='font-size: 32px;' class='welcome-message'>Welcome, " . $_SESSION['username'] . "</h1>
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
    left: 39%;
    background-color: #50C878;
    width: 400px;
    height: 30px;
    align-items: center;
    color: white;'>Grade Successfully Added!</p></div>
";
        }

        if(isset($_GET['delete_success']) && $_GET['delete_success'] == 1) {
     echo "<div id='notification' style='visibility: visible;'><p class='notif' style='color: white; text-align: center; font-weight: 600; position: fixed;
    left: 39%;
    background-color: #50C878;
    width: 400px;
    height: 30px;
    align-items: center;
    color: white;'>Grade Successfully Deleted!</p></div>
";
        }

    if(isset($_GET['update_success']) && $_GET['update_success'] == 1) {
    echo "<div id='notification' style='visibility: visible;'><p class='notif' style='color: white; text-align: center; font-weight: 600; position: fixed;
    left: 39%;
    background-color: #50C878;
    width: 400px;
    height: 30px;
    align-items: center;
    color: white;'>Grade Successfully Updated!</p></div>
";
        }
    ?>
   
<div class="table-container">
    <?php
                        require_once "config.php";
                        $student_number = $_SESSION['username'];
                        $sql_student = "SELECT * FROM stdaccounts WHERE studentNumber = ?";
                        if($stmt = mysqli_prepare($link, $sql_student)){
                            mysqli_stmt_bind_param($stmt, "s", $student_number);
                            if(mysqli_stmt_execute($stmt)){
                                $result_student = mysqli_stmt_get_result($stmt);
                                if(mysqli_num_rows($result_student) > 0){
                                    $row_student = mysqli_fetch_assoc($result_student);

                                    echo "<div class = 'studentinfo'>";
                                    echo "<br><table>";
                                    echo "<tr>";
                                    echo "<td id='left'>Student Number</td>";
                                    
                                    echo "<td id='right'>" . $row_student['studentNumber'] ."</td>";
                                    echo "</tr>";
                                    echo "<tr>";
                                    echo "<td id='left'>Name</td>";
                                    
                                    echo "<td id='right'>" . $row_student['lastName'] . ", " . $row_student['firstName'] . " " . $row_student['middleName'] ."</td>";
                                    echo "</tr>";
                                    echo "<tr>";
                                    echo "<td id='left'>Course</td>";
                                    
                                    echo "<td id='right'>" . $row_student['course'] ."</td>";
                                    echo "</tr>";
                                    echo "<tr>";
                                    echo "<td id='left'>Year Level</td>";
                                    
                                    echo "<td id='right'>" . $row_student['yearLevel'] ."</td>";
                                    echo "</tr>";
                                    echo "<tr>";
                                    
                                   
                                    echo "</tr>";
                                    echo "</table>";
                                    echo "</div>";

                                    // Display table of subjects
                                    $sql_grades = "SELECT * FROM tblgrades WHERE studentNumber = ?";
                                    if($stmt_grades = mysqli_prepare($link, $sql_grades)){
                                        mysqli_stmt_bind_param($stmt_grades, "s", $student_number);
                                        if(mysqli_stmt_execute($stmt_grades)){
                                            $result_grades = mysqli_stmt_get_result($stmt_grades);
                                            if(mysqli_num_rows($result_grades) > 0){

                                                echo "<table id = 'main'>";
                                                echo "<tr>";
                                                echo "<th>Subject Code</th><th>Description</th><th>Unit</th><th>Grade</th><th>Encoded By</th><th>Date Encoded</th>";
                                                echo "</tr>";
                                                while ($row_grade = mysqli_fetch_assoc($result_grades)){
                                                    $subject_code = $row_grade['subjectCode'];
                                                    // Fetch subject information from tblsubjects
                                                    $sql_subject = "SELECT description, unit FROM tblsubject WHERE subjectCode = ?";
                                                    if($stmt_subject = mysqli_prepare($link, $sql_subject)){
                                                        mysqli_stmt_bind_param($stmt_subject, "s", $subject_code);
                                                        if(mysqli_stmt_execute($stmt_subject)){
                                                            $result_subject = mysqli_stmt_get_result($stmt_subject);
                                                            if(mysqli_num_rows($result_subject) > 0){
                                                                $row_subject = mysqli_fetch_assoc($result_subject);
                                                                echo "<tr>";
                                                                echo "<td>" . $subject_code . "</td>";
                                                                echo "<td>" . $row_subject['description'] . "</td>";
                                                                echo "<td>" . $row_subject['unit'] . "</td>";
                                                                echo "<td>" . $row_grade['grade'] . "</td>";
                                                                echo "<td>" . $row_grade['encodedBy'] . "</td>";
                                                                echo "<td>" . $row_grade['dateCreated'] . "</td>";
                                                                
                                                               echo "</td>";
                                                                echo "</tr>";
                                                               
                                                            }
                                                        }
                                                    }
                                                }
                                                echo "</table>";
                                            } else {
                                                echo "<p style='text-align: center;'>No subjects found.</p>";
                                            }
                                        }
                                    }
                                } else {
                                    echo "<p style='text-align: center;'>No student found with the provided student number.</p>";
                                }
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
        <p id="deleteConfirmation"></p>
        <a id="btnYes" class="delete" href="#">Yes</a>
        <a class="update" onclick="closeModal()">No</a>
    </div>
</div>

<script>
    function confirmDelete(subjectcode, studentnumber) {
        var deleteConfirmation = "Are you sure you want to delete the grade in subject code '" + subjectcode + "' of student number '" + studentnumber + "'?";
        document.getElementById('deleteConfirmation').innerText = deleteConfirmation;

        document.getElementById('deleteModal').style.display = 'block';

        document.getElementById('btnYes').onclick = function() {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete-grade.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    if (xhr.responseText === "Success") {
                        location.reload(); // Reload the page after successful deletion
                    } else {
                        window.location.href = 'grades-management.php?delete_success=1'; // Redirect to grades-management.php with a delete_success parameter
                    }
                }
            };
            xhr.send("confirm=yes&txtsubjectcode=" + subjectcode + "&studentnumber=" + studentnumber); // Pass student number as a parameter
            closeModal();
        };
    }

    function closeModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }
</script>



 



</body>
</html>