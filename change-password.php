<?php
require_once "config.php";
include("session-checker.php");

if(isset($_POST['btnsubmit'])) {
    $password = $_POST['txtpassword'];
    $confirmPassword = $_POST['txtconfirm'];

     if ($password !== $confirmPassword) {
                    header("location: change-password.php?unsuccess=1");
        
    }

    else{

    $username = $_SESSION['username'];

    $sql = "UPDATE tblaccount SET password = ? WHERE username = ?";

    if($stmt = mysqli_prepare($link, $sql)) {

        mysqli_stmt_bind_param($stmt, "ss", $password, $username);
        
        if(mysqli_stmt_execute($stmt)) {
            
            $date = date("Y-m-d");
            $time = date("H:i:s");
            $action = "Update";
            $module = "Accounts Management";
            $performedby = $_SESSION['username'];

            $log_sql = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
            if($log_stmt = mysqli_prepare($link, $log_sql)) {
                mysqli_stmt_bind_param($log_stmt, "ssssss", $date, $time, $action, $module, $username, $performedby);
                mysqli_stmt_execute($log_stmt);
            }

                    header("location: index-student.php?update_success=1");
        } else {
            echo "<script>alert('ERROR Failed to update password'); window.location='index-student.php';</script>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('ERROR preparing SQL statement');</script>";
    }
}
}

$sql_fetch_account = "SELECT * FROM tblaccount WHERE username = ?";
if ($stmt_fetch_account = mysqli_prepare($link, $sql_fetch_account)) {
    mysqli_stmt_bind_param($stmt_fetch_account, "s", $_SESSION['username']);
    if(mysqli_stmt_execute($stmt_fetch_account)) {
        $result_fetch_account = mysqli_stmt_get_result($stmt_fetch_account);
        if($account = mysqli_fetch_assoc($result_fetch_account)) {
        } else {
            echo "<script>alert('User account not found');</script>";
        }
    } else {
        echo "<script>alert('ERROR executing SQL statement for fetching account');</script>";
    }
    mysqli_stmt_close($stmt_fetch_account);
} else {
    echo "<script>alert('ERROR preparing SQL statement for fetching account');</script>";
}
?>

<html>
<head>

    <title>Update Account - Arellano University Subject Advising System - AUSMS</title>
    <link href="https://rsms.me/inter/inter-ui.css" rel="stylesheet">

    <!--vendors styles-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">

    <!-- Bootstrap CSS / Color Scheme -->
    <link rel="stylesheet" href="css/default.css" id="theme-color">
    <style>
         @import url('https://fonts.googleapis.com/css?family=Poppins:wght@400;500&display=swap');

              .bg-blue {
  background-color: #294D86; }

  h1
  {
    margin-top: 150px;
    margin-left:   100px;
        color: #333;

  }

#tick
{
    margin-left:    800px;
}
  #check
  {
    margin-left:   10px;
    color:  #333;
    font-weight:    500;
  }

  #passwordinput
  {
     
           margin-left:   100px;
            display:flex;
            align-items: center;
            justify-content: center;
            width: 850px;
            font-size: 16px;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
            border: solid 2px gray;
            padding: 5px 10px;
            background-color: #dfdfdf;
}
  body {
  margin: 0;
  font-family: "Inter UI", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #CFD8DC;
  text-align: left;
  background-color: #dfdfdf; }

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
    width: 100px;
    height: 28px;
    text-align: center;
}

#change
{
            padding: 10px;
            width:  200px;
            text-align: center;
            background-color: #294D86;
            color: white;
            border: 1px solid black;
            border-radius: 20px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
            font-size: 14px; /* Set the font size */
            margin-top:     20px;
            margin-left:    40px;
        }

        #change:hover
        {
            background-color: #333;
        }

        .cancel
        {
       
            padding: 10px;
            text-align: center;
            background-color: #294D86;
            color: #294D86;
            border: 1px solid black;
            border-radius: 20px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
            font-size: 14px; /* Set the font size */
            width:  200px;

        .cancel:hover
        {
            background-color: #555;
        }

        #error {
    margin-bottom: 0;
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
        function validatePasswords() {
    var password = document.getElementById("passwordinput").value;
    var confirmPassword = document.getElementById("confirmpasswordinput").value;

    if (password !== confirmPassword) {
        alert("Passwords do not match");
        return false;
    }
    return true;
}
    </script>


</head>
<body>
    <section style=" background: #dfdfdf; position: relative;          
    left: 0;
    width: 100%;
    background-color: #dfdfdf;
    color: #333;
    padding: 0px 0px;
    box-shadow: 0 4px 5px rgba(0, 0, 0, 0.1);
    z-index: 1000;" class="smart-scroll">
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
                        <a style="    color: #333; font-family: Poppins;/* light grey */
" class="nav-link page-scroll" href="view-grade.php">View Grade</a>
                    
                    <li class="nav-item">
                        <a style="    color: #333; font-family: Poppins;/* light grey */
" class="nav-link page-scroll" href="subjects.php">Subejcts to be Taken</a>

        <li class="nav-item">
                                <a style="    color: #333; font-family: Poppins;/* light grey */
        " class="nav-link page-scroll" name= "btnsubmit" href="change-password.php">Change Password</a>
                    
                    <li class="nav-item">
                        <a style="    color: #333; font-family: Poppins;/* light grey */
" class="nav-link page-scroll" href="logout.php">Logout</a>
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

    <div class="container">
          <?php
    // Check if there's an error notification
    if(isset($_GET['unsuccess']) && $_GET['unsuccess'] == 1) {
        // Display the error message with zero margin bottom
        echo "<p id='error' style='color: red; text-align: center; margin-bottom: 0;'>Passwords do not match.</p>";
    }
    ?>
        <h1>Change Password</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="txtpassword" style="color: #333; margin-left:   100px; font-weight: 500; margin-top: 15px;">New Password:</label>
            <input type="password" name="txtpassword" id = "passwordinput" value="<?php echo $account['password']; ?>" required><br>
            <input type="checkbox" id= "tick" onclick="showPassword()"><font id= "check" >Show Password</font><br><br>
            <label for="txtconfirm" style="color: #333; margin-left: 100px; font-weight: 500; margin-top: 15px;">Confirm Password:</label>
            <input type="password" name="txtconfirm" id = "passwordinput" required><br>
            <a style="  color: #294D86;  margin-left: 660px; font-weight: 500;" name= "cancel"href="index-student.php">Cancel</a>
            <input type="submit" name="btnsubmit" id = "change"value="Update"><br>
            
        </form>
    </div>

    <script>
        function showPassword() {
            var x = document.getElementById("passwordinput");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>
</html>