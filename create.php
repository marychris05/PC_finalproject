<?php
$connection = new mysqli("localhost", "root", "", "miniproject");

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$ticket_id = null;
$error     = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $connection->real_escape_string($_POST["fname"] . " " . $_POST["lname"]);
    $email    = $connection->real_escape_string($_POST["email"]);
    $issue    = $connection->real_escape_string($_POST["issue"]);
    $dept     = $connection->real_escape_string($_POST["dept"]);
    $phone    = $connection->real_escape_string($_POST["phone_no"]);
    $priority = $connection->real_escape_string($_POST["priority"]);
    $desc     = $connection->real_escape_string($_POST["desc"]);

    $sql = "INSERT INTO tickets (name, email, issue, dept, phone_no, priority, description)
            VALUES ('$name', '$email', '$issue', '$dept', '$phone', '$priority', '$desc')";

    if ($connection->query($sql) === TRUE) {
        $ticket_id = $connection->insert_id;
    } else {
        $error = $connection->error;
    }
}

$connection->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MISO HELPPAGE | Ticket Created</title>
    <link rel="shortcut icon" href="../favicon.ico">
    <link rel="stylesheet" href="css/demo.css">
    <link rel="stylesheet" href="css/styleA.css">
</head>
<body>

    <!-- Header -->
    <div class="inner-header">
        <div class="logo-wrap">
            <img src="Images/logo.jpg" alt="MISO Help Page Logo">
        </div>
        <a class="btn-back" href="index.html">&#8592; Home</a>
    </div>

    <div class="page-card">
        <div class="page-card-header">
            <h2>&#128228; Ticket Submission</h2>
        </div>
        <div class="page-card-body" style="text-align:center;">

        <?php if ($ticket_id): ?>
            <div class="alert-success" style="text-align:left;">
                &#10003; Your ticket was submitted successfully!
            </div>
            <div class="result-box" style="text-align:left; margin-top:16px;">
                <p><strong>Ticket ID:</strong> <?php echo $ticket_id; ?></p>
                <p>Please save this ID — you'll need it to search, update, or delete your ticket.</p>
            </div>
            <a href="index.html" class="btn btn-primary" style="margin-top:20px; width:100%;">
                &#8592; Back to Home
            </a>
        <?php else: ?>
            <div class="alert-error" style="text-align:left;">
                &#10007; Failed to create ticket<?php echo $error ? ": $error" : "."; ?>
            </div>
            <a href="send_ticket.html" class="btn btn-primary" style="margin-top:20px; width:100%;">
                &#8592; Try Again
            </a>
        <?php endif; ?>

        </div>
    </div>

</body>
</html>
