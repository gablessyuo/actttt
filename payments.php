<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include "db.php";


$booking_id = 2;

$sql = "SELECT * FROM bookings WHERE id=$booking_id";

$result = $conn->query($sql);

$booking = $result->fetch_assoc();


if (isset($_POST['save_payment'])) {

    $amount = $_POST['amount'];
    $method = $_POST['method'];

    if ($amount > 0) {

        $sql = "INSERT INTO payments
                (booking_id, amount, method, payment_date)
                VALUES
                ($booking_id, $amount, '$method', CURDATE())";

        $conn->query($sql);


        $new_paid = $booking['total_paid'] + $amount;

        $sql = "UPDATE bookings
                SET total_paid=$new_paid
                WHERE id=$booking_id";

        $conn->query($sql);


        header("Location: payments.php");

        exit();

    }
}


$sql = "SELECT SUM(amount) AS total
        FROM payments
        WHERE booking_id=$booking_id";

$result = $conn->query($sql);

$payment = $result->fetch_assoc();

$payment_total = $payment['total'];


$total_paid = $booking['total_paid'];

$balance = $booking['total_cost'] - $total_paid;

?>

<!DOCTYPE html>
<html>

<head>

    <title>Process Payment</title>

</head>

<body>

<h1>Process Payment (Booking #<?php echo $booking_id; ?>)</h1>

<p>
    Total Cost: ₱<?php echo number_format($booking['total_cost'], 2); ?>
</p>

<p>
    Total Paid: ₱<?php echo number_format($total_paid, 2); ?>
</p>

<p>
    <b>
        Balance: ₱<?php echo number_format($balance, 2); ?>
    </b>
</p>

<form method="POST">

    <label>Amount Paid</label>

    <br>

    <input
        type="number"
        name="amount"
        min="1"
        step="0.01"
        required
    >

    <br><br>


    <label>Method</label>

    <br>

    <select name="method">

        <option value="CASH">CASH</option>

        <option value="GCASH">GCASH</option>

        <option value="BANK">BANK</option>

    </select>

    <br><br>

    <button type="submit" name="save_payment">
        Save Payment
    </button>

</form>

</body>

</html>