<?php
  session_start();
  if(isset($_SESSION['status'])){
            echo "<script>alert('" . $_SESSION['status'] . "')</script>";
            unset($_SESSION['status']);
        }

        $student_number = "";

        // Check if the search button was clicked or if a student number is present in the URL
        if(isset($_POST['btnsearch'])) {
            // If the search button was clicked, get the student number from the form input
            $student_number = $_POST['txtsearch'];
        } elseif(isset($_GET['txtsearch'])) {
            // If a student number is present in the URL, get it from the URL
            $student_number = $_GET['txtsearch'];
        }


?>

<html>
<title>Student Accounts Management - Arellano Technical Ticket Management System - AUTMS</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
 <link href="https://rsms.me/inter/inter-ui.css" rel="stylesheet">

    <!--vendors styles-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fontawesome.com/v4/examples/">

    <!-- Bootstrap CSS / Color Scheme -->
    <link rel="stylesheet" href="css/default.css" id="theme-color">
<link rel="stylesheet" type= "text/css" href="css/student-management.css">
<style>
    .search {
            width: 65%;
            margin: 80px auto 35px;
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
            width: 80px;
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


    @import url('https://fonts.googleapis.com/css?family=Poppins:wght@400;500&display=swap');

    .table-container 
    {
        margin-left: 25px;
        margin-right: 25px;

    }

    .table-data {
    color: #333; 
    font-family: Poppins;
}


    #login-form
    {
        margin-left: 30px;
    }

.modal {
    display: none;
    position: fixed;
    z-index: 1000; /* Set a higher z-index value */
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



<body>
     <section style=" background: #dfdfdf; position: relative;          
    left: 0;
    width: 100%;
    background-color: #dfdfdf;
    color: #333;
    padding: 0px 0px;
    box-shadow: 0 4px 5px rgba(0, 0, 0, 0.1);
    z-index: 1000;
" class="smart-scroll">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-md navbar-dark">
            <a style="  color: #294D86;" class="navbar-brand heading-black" href="index.html">
                AUSAS
            </a>
            <button class="navbar-toggler navbar-toggler-right border-0" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span data-feather="grid"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ml-auto">
                     <li class="nav-item">
                        <a style="  color: #333; font-family: Poppins;
" class="nav-link page-scroll" href="accounts-management.php"><i class="fas fa-users"></i>Accounts</a>
                    </li>
                    <li class="nav-item">
                        <a style="  color: #333; font-family: Poppins;
" class="nav-link page-scroll" href="subjects-management.php"><i class="fas fa-book-medical"></i>Subjects</a>
                    </li>
                    <li class="nav-item">
                        <a style="  color: #333; font-family: Poppins;
" class="nav-link page-scroll" href="student-management.php"><i class="fas fa-graduation-cap"></i>Students</a>
                    </li>
                    <li class="nav-item">
                        <a style="  color: #333; font-family: Poppins;
" class="nav-link page-scroll" href="grades-management.php"><i class="fas fa-graduation-cap"></i>Grades</a>
                    </li>
                    <li class="nav-item">
                        <a style="  color: white; background-color: #294D86; font-family: Poppins;
" class="nav-link page-scroll" href="subject-advising.php"><i class="fas fa-graduation-cap"></i>Advising</a>
                    </li>
                   <li class="nav-item">
    <a style="color: #333; font-family: Poppins;" class="nav-link page-scroll" href="<?php echo ($_SESSION['usertype'] === 'Administrator') ? 'index.php' : ($_SESSION['usertype'] === 'Staff' ? 'index-staff.php' : 'index-registrar.php'); ?>" name="home">
        <i class="fas fa-sign-out-alt"></i> Home
    </a>
</li>

                    <li class="nav-item">
                        <a style="    color: #333; font-family: Poppins;/* light grey */
" class="nav-link page-scroll" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
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


    <?php
      

        //check if there is a session recorder
        if(isset($_SESSION['username'])){
           echo "<h1 style='margin-top: 50px; font-size: 32px; color: #333; font-family: Poppins' class='welcome-message'>Welcome, " . $_SESSION['username'] . "</h1>";

            echo "<h4 style='font-size: 16px; font-weight: 400; color: #294D86; font-family: Poppins' class='welcome-message'>Account type: " . $_SESSION['usertype'] . "</h4>";
        }
        else
        {
            //redirect the user to the login page
            header("location: login.php");
        }

       
    ?>
   <div class="search">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <input id="text" type="text" name="txtsearch" placeholder="Search (Student Number)" >
        <input id="submit" type="submit" name="btnsearch" alt="image" value="Search">
    </form>
</div>



<div class="table-container">
    <?php
        if (!empty($student_number)) {
            // Perform search by student number
            require_once "config.php";
            $sql_student = "SELECT * FROM stdaccounts WHERE studentNumber = ?";
            if ($stmt = mysqli_prepare($link, $sql_student)) {
                mysqli_stmt_bind_param($stmt, "s", $student_number);
                if (mysqli_stmt_execute($stmt)) {
                    $result_student = mysqli_stmt_get_result($stmt);
                    if (mysqli_num_rows($result_student) > 0) {
                        $row_student = mysqli_fetch_assoc($result_student);
                        echo "<div class='studentinfo'>";
                        echo "<table>";
                        echo "<tr>";
                        echo "<td id='left'>Student Number</td>";
                        echo "<td id='right'>" . $row_student['studentNumber'] . "</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td id='left'>Name</td>";
                        echo "<td id='right'>" . $row_student['lastName'] . ", " . $row_student['firstName'] . " " . $row_student['middleName'] . "</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td id='left'>Course</td>";
                        echo "<td id='right'>" . $row_student['course'] . "</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td id='left'>Year Level</td>";
                        echo "<td id='right'>" . $row_student['yearLevel'] . "</td>";
                        echo "</tr>";
                        echo "</table>";
                        echo "</div>";

                        // Display table of subjects
                        $sql_subjects = "SELECT * FROM tblsubject WHERE course = ?";
                        if ($stmt_subjects = mysqli_prepare($link, $sql_subjects)) {
                            mysqli_stmt_bind_param($stmt_subjects, "s", $row_student['course']);
                            if (mysqli_stmt_execute($stmt_subjects)) {
                                $result_subjects = mysqli_stmt_get_result($stmt_subjects);
                                if (mysqli_num_rows($result_subjects) > 0) {

                                    echo "<table id='main'>";
                                    echo "<tr>";
                                    echo "<th>Subject Code</th><th>Description</th><th>Prerequisite</th><th>Unit</th>";
                                    echo "</tr>";

                                    while ($row_subject = mysqli_fetch_assoc($result_subjects)) {
                                        $subjectcode = $row_subject['subjectCode'];
                                        $prerequisite1 = $row_subject['prerequisite1'];
                                        $prerequisite2 = $row_subject['prerequisite2'];
                                        $prerequisite3 = $row_subject['prerequisite3'];
                                        $prerequisite_number = "";

                                        

                                            echo "<tr>";
                                            echo "<td>" . $row_subject['subjectCode'] . "</td>";
                                            echo "<td>" . $row_subject['description'] . "</td>";
                                            echo "<td>" . $prerequisite_number . "</td>"; // Display the prerequisite number
                                            echo "<td>" . $row_subject['unit'] . "</td>";
                                            echo "</tr>";
                                        }
                                    }

                                    echo "</table>";
                                } else {
                                    echo "<p style='text-align: center; color: #333;'>No subjects found.</p>";
                                }
                            }
                        }
                                    } else {
                        echo "<p style='text-align: center; color: #333;'>No student found with the provided student number.</p>";
                    }
                }
            }
        

        function checkPrerequisite($link, $student_number, $prerequisite)
        {
            $sql_check_prerequisite = "SELECT * FROM tblgrades WHERE studentNumber = ? AND subjectCode = ?";
            $stmt_check_prerequisite = mysqli_prepare($link, $sql_check_prerequisite);
            mysqli_stmt_bind_param($stmt_check_prerequisite, "ss", $student_number, $prerequisite);
            mysqli_stmt_execute($stmt_check_prerequisite);
            mysqli_stmt_store_result($stmt_check_prerequisite);
            $num_rows = mysqli_stmt_num_rows($stmt_check_prerequisite);
            mysqli_stmt_close($stmt_check_prerequisite);
            return $num_rows > 0;
        }
        ?>
              
</div>

<footer >
    <p>Arellano Subject Advising System.</p>
</footer>





</body>
</html>