<?php
$connection = new mysqli("localhost", "root", "", "miniproject");

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$guide    = null;
$notFound = false;

if (isset($_GET["id"]) && $_GET["id"] !== "") {
    $id     = intval($_GET["id"]);
    $result = $connection->query("SELECT * FROM diy WHERE id = $id");

    if ($result && $result->num_rows > 0) {
        $guide = $result->fetch_assoc();
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
    <title>MISO HELPPAGE | Troubleshooting Guides</title>
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
            <h2>&#128196; Troubleshooting Guide Repository</h2>
        </div>
        <div class="page-card-body">

        <form method="GET">
            <div class="form-group">
                <label for="id">Guide ID</label>
                <input type="number" id="id" name="id" placeholder="Enter guide ID"
                       value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;">&#128269; View Guide</button>
        </form>

        <?php if ($guide): ?>
            <div class="result-box" style="margin-top:28px;">
                <p><strong>Guide ID:</strong> <?php echo htmlspecialchars($guide['id']); ?></p>
                <p><strong>Problem:</strong> <?php echo htmlspecialchars($guide['problem']); ?></p>
                <p><strong>Troubleshooting Steps:</strong></p>
                <p style="white-space:pre-wrap; margin-top:8px; color:#334;"><?php echo htmlspecialchars($guide['troubleshooting']); ?></p>
            </div>
        <?php elseif ($notFound): ?>
            <div class="alert-error" style="margin-top:24px;">
                No guide found with that ID.
            </div>
        <?php endif; ?>

        </div>
    </div>

</body>
</html>
