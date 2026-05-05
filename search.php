<?php
$connection = new mysqli("localhost", "root", "", "miniproject");

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$ticket = null;
$notFound = false;

if (isset($_GET["id"]) && $_GET["id"] !== "") {
    $id     = intval($_GET["id"]);
    $result = $connection->query("SELECT * FROM tickets WHERE id = $id");

    if ($result && $result->num_rows > 0) {
        $ticket = $result->fetch_assoc();
    } else {
        $notFound = true;
    }
}

$connection->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MISO HELPPAGE | Search Ticket</title>
    <link rel="shortcut icon" href="../favicon.ico">
    <link rel="stylesheet" href="css/demo.css">
    <link rel="stylesheet" href="css/styleA.css">
</head>
<body>

    <div class="inner-header">
        <div class="logo-wrap">
            <img src="Images/logo.jpg" alt="MISO Help Page Logo">
        </div>
        <a class="btn-back" href="index.html">&#8592; Back</a>
    </div>

    <div class="page-card">
        <div class="page-card-header">
            <h2>&#128269; Search a Ticket</h2>
        </div>
        <div class="page-card-body">
            <form method="GET">
                <div class="form-group">
                    <label for="id">Ticket ID</label>
                    <input type="number" id="id" name="id" placeholder="Enter your ticket ID"
                           value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;">Search</button>
            </form>

            <?php if ($ticket): ?>
                <div class="result-box" style="margin-top:28px;">
                    <p><strong>Ticket ID:</strong> <?php echo htmlspecialchars($ticket['id']); ?></p>
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($ticket['name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($ticket['email']); ?></p>
                    <p><strong>Issue:</strong> <?php echo htmlspecialchars($ticket['issue']); ?></p>
                    <p><strong>Department:</strong> <?php echo htmlspecialchars($ticket['dept']); ?></p>
                    <p><strong>Contact:</strong> <?php echo htmlspecialchars($ticket['phone_no']); ?></p>
                    <p><strong>Priority:</strong> <?php echo htmlspecialchars($ticket['priority']); ?></p>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($ticket['description']); ?></p>
                </div>
            <?php elseif ($notFound): ?>
                <div class="alert-error" style="margin-top:24px;">
                    No ticket found with that ID.
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
