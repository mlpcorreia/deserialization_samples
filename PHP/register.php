<?php
include "config.php";

if (isset($_POST['but_submit'])) {
    $result = $db_con->prepare('INSERT INTO users (username, password, name, email) VALUES (:username, :password, :name, :email)');
    $result->bindValue(':username', $_POST['uname']);
    $result->bindValue(':password', $_POST['psw']);
    $result->bindValue(':name', $_POST['name']);
    $result->bindValue(':email', $_POST['email']);
    if ($result->execute()) {
        header('location: login.php');
        exit();
    } else {
        $error = $result->errorInfo()[2];
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
<form action="/register.php" method="post">

  <div class="container">
    <p style="color: red;"><?php if ($error) { echo $error;} ?></p>
    <br>
    <label for="name"><b>Name</b></label>
    <input type="text" placeholder="Enter your Name" name="name" required>
    
    <label for="email"><b>E-mail</b></label>
    <input type="text" placeholder="Enter your E-mail" name="email" required>

    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>
        
  </div>
  <div class="container" style="background-color:#f1f1f1">
    <button type="submit" name="but_submit">Register</button>
  </div>
</form>
</div>
</body>
</html>
