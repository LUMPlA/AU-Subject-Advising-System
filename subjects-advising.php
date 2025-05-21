	<html>
	<title>Advising of Subjects - Arellano University Subject Advising System - AUSAS</title>
	<link href='https://fonts.googleapis.com/css?family=Chivo' rel='stylesheet'>
	<?php
		session_start();
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
	<body>
		<header>
			<div class = "left">
			<div class="logo"><img src='logo.png' width="65" height="65"></div><div class = "title">AUSAS - Advising of Subjects</div>
			</div>
			<div class = "right">
				<div class = "user">
					<?php
					//check if there is a session
					if(isset($_SESSION['username'])){
						echo "<h2>" . $_SESSION['username'] . "</h2>";
						echo $_SESSION['usertype'];
					}else{
						//redirect to the login page
						header("location: login.php");
					}
					?>
				</div>
				<nav class = "dropdown">
					<li>▼
					<ul id = "submenu" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "POST">
						<a href = "index.php"><li>Index</li></a>
						<a href = "accounts-management.php"><li>Accounts</li></a>
						<a href = "students-management.php"><li>Students</li></a>
						<a href = "subjects-management.php"><li>Subjects</li></a>
						<a href = "grades-management.php"><li>Grades</li></a>
						<a href = "subjects-advising.php"><li>Advising</li></a>
						<a href = "logout.php"><li>Logout</li></a>
					</ul>
					</li>
				</nav>
			</div>
	    </header>
	    <div class = "body">
			<div class = "search">
			<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?txtsearch=<?php echo isset($_POST['txtsearch']) ? urlencode($_POST['txtsearch']) : ''; ?>">
			    <input id="text" type="text" name="txtsearch" placeholder="Search (Student Number)">
			    <input id="submit" type="submit" name="btnsearch" alt="image" value="Search">
			</form>
			</div>
			<div class = "table-con">
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

			                                        // Determine the prerequisite number for the current subject
			                                        $prerequisite_number = "";
			                                        if ($prerequisite1 === $subjectcode) {
			                                            $prerequisite_number = "1";
			                                        } elseif ($prerequisite2 === $subjectcode) {
			                                            $prerequisite_number = "2";
			                                        } elseif ($prerequisite3 === $subjectcode) {
			                                            $prerequisite_number = "3";
			                                        }

			                                        // Check if the subject is not already graded
			                                        $sql_check_grade = "SELECT * FROM tblgrades WHERE studentNumber = ? AND subjectCode = ?";
			                                        $stmt_check_grade = mysqli_prepare($link, $sql_check_grade);
			                                        mysqli_stmt_bind_param($stmt_check_grade, "ss", $student_number, $subjectcode);
			                                        mysqli_stmt_execute($stmt_check_grade);
			                                        mysqli_stmt_store_result($stmt_check_grade);
			                                        $num_rows = mysqli_stmt_num_rows($stmt_check_grade);
			                                        mysqli_stmt_close($stmt_check_grade);

			                                        // Check if all prerequisites are in tblgrades
			                                        if ($num_rows == 0 &&
			                                            (!$prerequisite1 || checkPrerequisite($link, $student_number, $prerequisite1)) &&
			                                            (!$prerequisite2 || checkPrerequisite($link, $student_number, $prerequisite2)) &&
			                                            (!$prerequisite3 || checkPrerequisite($link, $student_number, $prerequisite3))) {

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
			                                    echo "<p style='text-align: center;'>No subjects found.</p>";
			                                }
			                            }
			                        }
			                    } else {
			                        echo "<p style='text-align: center;'>No student found with the provided student number.</p>";
			                    }
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
		</div>
		<footer>
			<div class = "text">
				Advising of Subjects - AUSAS
			</div>
			<div class="contact-con"><span id="contact">Arellano University</span>
	            <br>1002 Jacinto St, Quezon, Mabini, Plaridel
	            <br>+63 912 345 6789
	            <br>email.address.123@gmail.com
	        </div>
		</footer>
	</body>
	</html>
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
		    justify-content: space-between;
		    background: #232023;
		    z-index: 1000;
		    cursor: default;
		}

		header .left{
			display: flex;
			align-items: center;
		}

		header .right {
			display: flex;
			align-items: center;
		}

		header .right .user {
			text-align: center;
			cursor: default;
			font-size: 18px;
			margin-right: 15px;
		}

		header .right .dropdown {
			padding: 7px 5px 5px;
			border-radius: 10px;
			border: solid 2px gray;
		}

		header .right .dropdown li{
			position: relative;
			display: block;
			margin: auto;
			cursor: pointer;
		}

		header .right .dropdown ul#submenu {
			opacity: 0;
			position: absolute;
			visibility: hidden;
			z-index: 1;
			width: 100px;
			text-align: center;
			right: 0;
			padding-top: 10px;
		}

		header .right .dropdown ul#submenu li{
			padding: 5px;
			margin: 10px 0 10px;	
			border-radius: 10px;
			background: #232023;
			border: 2px solid gray;	
		}

		header .right .dropdown li:hover ul#submenu {
			opacity: 1;
			visibility: visible;
		}

		header .right .dropdown ul#submenu li:hover {
			background: gray;
		}

		header .logo{
			margin-right: 20px;
		}

		header .title {
			font-size: 25px;
		}

		.body {
			margin: 90px auto 0;
			padding: 0 10% 0;
			height: 100%;
		}

		.body .search {
		    width: 65%;
		    margin: 130px auto 35px;
		    display:flex;
		    align-items: center;
		    justify-content: center;
		}

		.body .search a:hover {
			text-decoration: underline;
		}

		.body .search form {
		    display: flex;
		    border-radius: 10px;
		}

		.body .search form #text {
		  	width: 400px;
		    font-size: 16px;
		    border-top-left-radius: 10px;
		    border-bottom-left-radius: 10px;
		    border: solid 2px gray;
		    padding: 5px 10px;
		    background-color: #28282B;
		}

		.body .search form #submit {
		    width: 70px;
		    padding: 0 10px;
		    background-color: gray;
		    border-style: none;
		    border-top-right-radius: 10px;
		    border-bottom-right-radius: 10px;
		    cursor: pointer;
		}

		.body .right a {
			padding: 5px;
			margin-left: 5px;
		}

		.body .right #create:hover {
			color: blue;
		}

		.body .right #logout:hover {
			color: #BF0000;
		}

		.body .table-con {
			margin: auto;
			width: 80%;
			max-height: 80%;
			overflow-x: hidden;
			overflow-y: auto;
			display: block;
			justify-content: center;

			&::-webkit-scrollbar {
	  			width: 5px;
			}
		 
			&::-webkit-scrollbar-thumb {
			  background: gray; 
			  border-radius: 10px;
			}

		}

		.body .alert {
			align-items: center;
		}
		

		.body table#main {
			margin: auto;
			cursor: default;
			background: gray;
		}

		th {
			background: #232023;
		}


		th, td {
			padding: 10px 15px 10px;
			text-align: center;
		}

		td {
			background: #28282B;
		}

		td a, button{
			margin: 3px;
			cursor: pointer;
		}

		button {
			border: none;
			outline: none;
			background: #28282B;
			font-size: 16px;
		}

		td a:hover, button:hover {
			text-decoration: underline;
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

		input:focus {
			outline: none;
		}

		::placeholder {
	  		color: white;
	  		font-size: 14px;
		}

		footer .contact-con #contact {
			font-size: 16px;
		}

		.body .studentinfo {
			margin: auto;
			width: 50%;
			cursor: default;
			margin-bottom: 30px;
		}

		.body .studeninfo p {
			font-size: 18px;
		}

		.body .studentinfo table {
			margin: auto;
			width: 100%;
			background: #232023;
			border: solid 2px gray;
			padding: 15px;
			border-radius: 10px;
		}

		.body .studentinfo table td {
			background: #232023;
			padding: 2px;
			text-align: left;
			width: 50%;
		}

		.body .studentinfo table td#left{
			padding-left: 0px;
		}

		.body .studentinfo table td#right{
			padding: 5px 10px 5px;
		}

		.body .studentinfo table td a {
			padding: 5px;
			border-radius: 10px;
		}
	</style>