<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Registration</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<?php
    require('db.php');
    // When form submitted, insert values into the database.
    if (isset($_REQUEST['username'])) {
        // removes backslashes
        $username = stripslashes($_REQUEST['username']);
        //escapes special characters in a string
        $username = mysqli_real_escape_string($con, $username);
        $email    = stripslashes($_REQUEST['email']);
        $email    = mysqli_real_escape_string($con, $email);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $create_datetime = date("Y-m-d H:i:s");
        // $fn = $_FILES['file']['name'];
        // $tm = $_FILES['file']['tmp_name'];
        // move_uploaded_file($tm, "assets/uploaded files/".$fn);
        $allow = array('pdf');
        $temp = explode(".", $_FILES['file']['name']);
        $extension = end($temp);
        $upload_file = $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], "assets/uploaded files/".$_FILES['file']['name']);

        $query    = "INSERT into `customer` (username, password, email, create_datetime, c_file)
                     VALUES ('$username', '" . md5($password) . "', '$email', '$create_datetime', '" . $upload_file . "')";
        $result   = mysqli_query($con, $query);
        if ($result) {
            echo "<div class='form'>
                  <h3>You are registered successfully.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a></p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>Required fields are missing.</h3><br/>
                  <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                  </div>";
        }
    } else {
?>
    <form class="form" action="" method="post" enctype="multipart/form-data">
        <h1 class="login-title">Customer Registration</h1>
        <input type="text" class="login-input" name="username" placeholder="Username" required />
        <input type="text" class="login-input" name="email" placeholder="Email Adress" required="">
        <input type="password" class="login-input" name="password" placeholder="Password" required="">
        <input type="file" class="login-input" name="file" accept="application/pdf"><br><br>
        <input type="submit" name="submit" value="Register" class="login-button">
        <p class="link"><a href="login.php">Click to Login</a></p>
    </form>
<?php
    }
?>
</body>
</html>