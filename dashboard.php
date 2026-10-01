<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
</head>

<body>

<nav>

<a href="dashboard.php">Dashboard</a>
&nbsp;

<a href="#">Clients</a>
&nbsp;

<a href="#">Services</a>
&nbsp;

<a href="#">Bookings</a>
&nbsp;

<a href="tools.php">Tools</a>
&nbsp;

<a href="payments.php">Payments</a>
&nbsp;

<a href="logout.php">Logout</a>

</nav>

<hr>

<h1>Dashboard</h1>

<h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>

<p>Welcome to the Booking Management System.</p>

</body>

</html>