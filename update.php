<?php
$connection = new mysqli("localhost", "root", "", "miniproject");

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$message = "";
$ticket  = null;

// Handle update submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id          = intval($_POST["id"]);
    $name        = $connection->real_escape_string($_POST["name"]);
    $email       = $connection->real_escape_string($_POST["email"]);
    $issue       = $connection->real_escape_string($_POST["issue"]);
    $dept        = $connection->real_escape_string($_POST["dept"]);
    $phone       = $connection->real_escape_string($_POST["phone_no"]);
    $priority    = $connection->real_escape_string($_POST["priority"]);
    $description = $connection->real_escape_string($_POST["description"]);

    $sql = "UPDATE tickets SET
                name='$name', email='$email', issue='$issue',
                dept='$dept', phone_no='$phone', priority='$priority',
                description='$description'
            WHERE id=$id";

    if ($connection->query($sql)) {
        $message = "success";
    } else {
        $message = "error";
    }
}

// Load ticket for editing
if (isset($_GET["id"]) && $_GET["id"] !== "") {
    $id     = intval($_GET["id"]);
    $result = $connection->query("SELECT * FROM tickets WHERE id = $id");
    if ($result && $result->num_rows > 0) {
        $ticket = $result->fetch_assoc();
    }
}

$connection->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MISO HELPPAGE | Update Ticket</title>
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
            <h2>&#9998; Update a Ticket</h2>
        </div>
        <div class="page-card-body">

        <?php if ($message === "success"): ?>
            <div class="alert-success">&#10003; Ticket updated successfully!</div>
            <a href="index.html" class="btn btn-primary" style="width:100%;">Back to Home</a>

        <?php elseif ($message === "error"): ?>
            <div class="alert-error">&#10007; Update failed. Please try again.</div>

        <?php elseif ($ticket): ?>
            <!-- Edit Form -->
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $ticket['id']; ?>">

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($ticket['name']); ?>" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($ticket['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Contact Number</label>
                        <input type="text" name="phone_no" value="<?php echo htmlspecialchars($ticket['phone_no']); ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Issue</label>
                    <input type="text" name="issue" value="<?php echo htmlspecialchars($ticket['issue']); ?>" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Department</label>
                        <input type="text" name="dept" value="<?php echo htmlspecialchars($ticket['dept']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Priority</label>
                        <select name="priority">
                            <option value="Normal"  <?php if ($ticket['priority'] == 'Normal')  echo 'selected'; ?>>Normal</option>
                            <option value="High"    <?php if ($ticket['priority'] == 'High')    echo 'selected'; ?>>High</option>
                            <option value="Urgent"  <?php if ($ticket['priority'] == 'Urgent')  echo 'selected'; ?>>Urgent</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" required><?php echo htmlspecialchars($ticket['description']); ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%;">&#10003; Save Changes</button>
            </form>

        <?php else: ?>
            <!-- Search Form -->
            <form method="GET">
                <div class="form-group">
                    <label for="id">Ticket ID</label>
                    <input type="number" id="id" name="id" placeholder="Enter ticket ID to edit" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;">Find Ticket</button>
            </form>

            <?php if (isset($_GET["id"]) && $_GET["id"] !== ""): ?>
                <div class="alert-error" style="margin-top:20px;">No ticket found with that ID.</div>
            <?php endif; ?>
        <?php endif; ?>

        </div>
    </div>

</body>
</html>
