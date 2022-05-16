<?php
include "config.php";

if (isset($_POST['but_submit'])) {
    $result = $db_con->prepare('SELECT * FROM users WHERE username = :username AND password = :password');
    $result->bindValue(':username', $_POST['uname']);
    $result->bindValue(':password', $_POST['psw']);
    $result->execute();

    if ($result) {
        $row = $result->fetch();
        if ($row) {
            $tmp = base64_encode(serialize(new User($row['username'], $row['name'], $row['email'])));
            $_SESSION['logged_in'] = true;
            setcookie("user", $tmp);
            header('location: profile.php');
            exit;
        } else {
            $failed = 'Login failed! Invalid credentials!';
        }
    }
}
?>

<html>
    <title>Profile Mgmt</title>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<style>
body {font-family: Arial, Helvetica, sans-serif;}
form {border: 3px solid #f1f1f1;}

input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

button {
  background-color: #04AA6D;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

button:hover {
  opacity: 0.8;
}

.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

.container {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
}
</style>
</head>
<body>

<div class="w3-display-middle">
<form action="/login.php" method="post">

  <div class="container">
    <p style="color: red;"><?php if ($failed) { echo $failed;} ?></p>
    <br>
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>
        
  </div>
  <div class="container" style="background-color:#f1f1f1">
    <button type="submit" name="but_submit">Login</button>
    <span class="psw">Forgot <a href="#">password?</a></span>
  </div>
</form>
</div>
</body>
</html>

