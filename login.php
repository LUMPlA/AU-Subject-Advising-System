
<?php
    $message = ""; // Initialize the message variable
    $background_color="#dfdfdf"; // Default background color

    if(isset($_POST['btnlogin'])) 
    { 
        require_once "config.php";

        $sql = "SELECT * FROM tblaccount WHERE username = ? AND password = ? AND status = 'ACTIVE'";
    
        if($stmt = mysqli_prepare($link, $sql)) 
        {
        // Bind the data from the login form to the SQL statement
        mysqli_stmt_bind_param($stmt, "ss", $_POST['txtusername'], $_POST['txtpassword']);
        
        // Check if the statement will execute
            if(mysqli_stmt_execute($stmt)) 
            {
            // Get the result of executing the statement 
                $result = mysqli_stmt_get_result($stmt);

            // Check if there is/are row/rows on the result
                if(mysqli_num_rows($result) > 0) 
                {
                    //fetch the result into an array
                    $account = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    //create session
                    session_start();
                    //record session
                    $_SESSION['username'] = $_POST['txtusername'];
                    $_SESSION['usertype'] = $account['usertype'];
                    //redirect to the accounts page

                    if ($account['usertype'] === 'Administrator') 
                    {
                        header("location: index.php");
                    } 
                    elseif ($account['usertype'] === 'Registrar') 
                    {
                        header("location: index-registrar.php");
                    } 
                    elseif ($account['usertype'] === 'Staff') 
                    {
                        header("location: index-staff.php");
                    } 
                    elseif ($account['usertype'] === 'Student') 
                    {
                        header("location: index-student.php");
                    }
                    else    
                    {
                        header("location: login.php");
                    }
                } 

                else 
                {
                    $message = "Incorrect login details or account is disabled."; 
                    $background_color="#dfdfdf"; 
                }
            }
            
            else 
            {
                $message = "Error on the login statement.";
                $background_color = "#dfdfdf"; 
            }
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page Arellano University Subject Advising System- AU</title>
    <link rel="stylesheet" type= "text/css" href="css/login.css"> 
<style>
    .submit-btn
{
    width: 100%;
    height: 60px;
    background: #294D86;
    color: white;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    transition: .3s;
}
</style>
</head>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
    <div class="login-box">
        <div class="login-header">
           <header style="font-size: 42px;">Subject Advising System</header>
    </div>

    <div class="input-box">
        <input type="text" class="input-field" name="txtusername" placeholder="username" autocomplete="off" required> </div>
    <div class="input-box">
        <input type="password" class="input-field" name="txtpassword" placeholder="Password" autocomplete="off" required> </div>

    <div class="forgot">
        <section>
            <input type="checkbox" id="check">
            <label for="check">Remember me</label>
        </section>
        <section>
            <a href="#">Forgot password</a> 
        </section>
    </div>

    <div class="input-submit">
        <input type="submit" class="submit-btn" id="submit" name="btnlogin"> <label for="submit"></label>
    </div>

<!-- Display the login result message -->
    <div class="result">
        <?php echo $message; ?>
    </div>
</div>
</form>
<footer >
        <p>You are not logged in.</p>
</footer>


</body>

</html>



