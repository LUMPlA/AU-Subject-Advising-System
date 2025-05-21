<?php
session_start();
require_once "config.php";
?>

<html>
<title>Student Accounts Management - Arellano Technical Ticket Management System - AUTMS</title>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Knight - Free Bootstrap 4 Product Landing Page Template</title>
    <meta name="description"
          content="Knight is a beautiful Bootstrap 4 template for product landing pages."/>

    <!--Inter UI font-->
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
</head>
<body>

<!--navigation-->
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
" class="nav-link page-scroll" href="view-subject.php">Subejcts to be Taken</a>

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

<?php 
 if(isset($_GET['update_success']) && $_GET['update_success'] == 1) {
    echo "<div id='notification' style='visibility: visible;'><p class='notif' style='color: white; text-align: center; font-weight: 600; position: fixed;
    left: 39%;
    background-color: #50C878;
    width: 400px;
    height: 30px;
    align-items: center;
    color: white;'>Password Successfully Updated!</p></div>
";}
?>

<section style="    background: #dfdfdf; /* light grey */
"  id="home">
    <div class="container">
        <div class="row vh-md-100">
            <div class="col-md-8 col-sm-10 col-12 mx-auto my-auto text-center">
                 <img src="LOGO.png" alt="Logo" style="height: 200px; margin-top: 10px;">
                <h1 style="font-family: Poppins; letter-spacing: 5px; color: #294D86;
" class="heading-black text-capitalize">Arellano University</h1>
                <p style="  color: #294D86; " class="lead py-3">Subject Advising System.</p>
                
                <button style="background: #294D86; color: white; width: 300px; height: 45px; font-family: Poppins; border: none; border-radius: 80px;">
    <?php
   
    // Check if there is a session recorder
    if(isset($_SESSION['username'])){
        echo "Welcome, " . $_SESSION['username'];
    } else {
        echo "Welcome, admin"; // Default message if no session is recorded
    }


    ?>
</button>

                 
            </div>
        </div>
    </div>
</section>

<footer style=" background: #333;" class="py-6">
    <div class="container">
        <div class="row">
            <div class="col-sm-5 mr-auto">
                <h5>Arellano University</h5>
                <p class="text-muted">2600 Legarda St., Sampaloc, Manila<br>1008 Metro Manila, Philippines<br>8-734-7371 to 79</p>
                <ul class="list-inline social social-sm">
                    <li class="list-inline-item">
                        <a href="https://www.facebook.com/ArellanoUniversityOfficial/"><i class="fa fa-facebook"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="https://twitter.com/arellano_u"><i class="fa fa-twitter"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="https://www.youtube.com/@ArellanoUniversityOfficial"><i class="fa fa-youtube"></i></a>
                    </li>
                    
                </ul>
            </div>
            <div class="col-sm-2">
                <h5>Legal</h5>
                <ul class="list-unstyled">
                    <li><a href="https://www.arellano.edu.ph/arellano-university-website-privacy-notice/">Data Privacy</a></li>
                    <li><a href="https://www.arellano.edu.ph/trade-mark-policy/">Trademark Policy</a></li>
                </ul>
            </div>
            <div class="col-sm-2">
                <h5>About</h5>
                <ul class="list-unstyled">
                    <li><a href="https://www.arellano.edu.ph/about/arellano-university-logo/">About</a></li>
                    <li><a href="https://www.arellano.edu.ph/community-development/about/">Community Development</a></li>
                </ul>
            </div>
            <div class="col-sm-2">
            
                <ul class="list-unstyled">
                    <h5></h5>

                    <li><a href="https://www.arellano.edu.ph/administration/about-ceo/">Administration</a></li>
                    <li><a href="login.php">Switch Account</a></li>
                </ul>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12 text-muted text-center small-xl">
                &copy; 2024 Arellano University - All Rights Reserved
            </div>
        </div>
    </div>
</footer>
</body>

</html>