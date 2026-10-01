<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include "db.php";


if (isset($_POST['assign'])) {

    $booking_id = $_POST['booking_id'];
    $tool_id = $_POST['tool_id'];
    $quantity = $_POST['quantity'];

    $sql = "SELECT * FROM tools WHERE id=$tool_id";

    $result = $conn->query($sql);

    $tool = $result->fetch_assoc();

    if ($quantity <= $tool['available']) {

        $sql = "INSERT INTO tool_assignments
                (booking_id, tool_id, quantity)
                VALUES
                ($booking_id, $tool_id, $quantity)";

        $conn->query($sql);


        $new_available = $tool['available'] - $quantity;

        $sql = "UPDATE tools
                SET available=$new_available
                WHERE id=$tool_id";

        $conn->query($sql);

        echo "<p>Tool assigned successfully.</p>";

    } else {

        echo "<p>Not enough tools available.</p>";

    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Tools / Inventory</title>

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

<h1>Tools / Inventory</h1>

<h2>Available Tools</h2>

<table border="1">

<tr>
    <th>Name</th>
    <th>Total</th>
    <th>Available</th>
</tr>

<?php

$sql = "SELECT * FROM tools";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {

?>

<tr>

<td><?php echo $row['name']; ?></td>

<td><?php echo $row['total']; ?></td>

<td><?php echo $row['available']; ?></td>

</tr>

<?php

}

?>

</table>

<hr>

<h2>Assign Tool to Booking</h2>

<form method="POST">

<label>Booking ID</label>

<br>

<select name="booking_id">

<?php

$sql = "SELECT * FROM bookings";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {

?>

<option value="<?php echo $row['id']; ?>">

#<?php echo $row['id']; ?>

</option>

<?php

}

?>

</select>

<br><br>


<label>Tool</label>

<br>

<select name="tool_id">

<?php

$sql = "SELECT * FROM tools";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {

?>

<option value="<?php echo $row['id']; ?>">

<?php echo $row['name']; ?>

(Avail: <?php echo $row['available']; ?>)

</option>

<?php

}

?>

</select>

<br><br>


<label>Qty Used</label>

<br>

<input type="number" name="quantity" value="1" min="1">

<br><br>

<button type="submit" name="assign">Assign</button>

</form>

</body>

</html>