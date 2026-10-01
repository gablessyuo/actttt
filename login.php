<?php

session_start();
include "db.php";

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users
            WHERE username='$username'
            AND password='$password'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

        $_SESSION['username'] = $username;

        header("Location: dashboard.php");
        exit();

    } else {

        echo "Wrong username or password";

    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Form</title>
</head>

<body>

<h1>Login Form</h1>

<form method="POST">

    Username:<br>
    <input type="text" name="username">

    <br><br>

    Password:<br>
    <input type="password" name="password">

    <br><br>

    <button type="submit" name="login">Login</button>

</form>

</body>

</html>