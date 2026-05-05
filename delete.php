<?php
$connection = new mysqli("localhost", "root", "", "miniproject");

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id  = intval($_POST["id"]);
    $sql = "DELETE FROM tickets WHERE id = $id";

    if ($connection->query($sql)) {
        $message = $connection->affected_rows > 0 ? "success" : "notfound";
    } else {
        $message = "error";
    }
}

$connection->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MISO HELPPAGE | Delete Ticket</title>
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
        <a class="btn-back" href="index.html">&#8592; Back</a>
    </div>

    <div class="page-card">
        <div class="page-card-header">
            <h2>&#128465; Delete a Ticket</h2>
        </div>
        <div class="page-card-body">

        <?php if ($message === "success"): ?>
            <div class="alert-success">&#10003; Ticket deleted successfully.</div>
            <a href="index.html" class="btn btn-primary" style="width:100%; margin-top:4px;">Back to Home</a>

        <?php elseif ($message === "notfound"): ?>
            <div class="alert-error">No ticket found with that ID.</div>

        <?php elseif ($message === "error"): ?>
            <div class="alert-error">&#10007; Something went wrong. Please try again.</div>

        <?php endif; ?>

        <?php if ($message === "" || $message === "notfound" || $message === "error"): ?>
            <form method="POST" style="margin-top: <?php echo $message ? '20px' : '0'; ?>;">
                <div class="form-group">
                    <label for="id">Ticket ID</label>
                    <input type="number" id="id" name="id" placeholder="Enter the ticket ID to delete" required>
                </div>
                <button type="submit" class="btn btn-danger" style="width:100%;">
                    &#128465; Delete Ticket
                </button>
            </form>
        <?php endif; ?>

        </div>
    </div>

</body>
</html>
