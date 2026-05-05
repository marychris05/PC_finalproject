<?php
$connection = new mysqli("localhost", "root", "", "finalproject");

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$problem        = $connection->real_escape_string($_POST['a']);
$troubleshooting = $connection->real_escape_string($_POST['b']);

$sql = "INSERT INTO diy (problem, troubleshooting) VALUES ('$problem', '$troubleshooting')";
$success = $connection->query($sql);
$connection->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MISO HELPPAGE | Guide Submitted</title>
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

    <!-- Result Card -->
    <div class="page-card">
        <div class="page-card-header">
            <h2>&#9998; Self-Help Troubleshooting Guides</h2>
        </div>
        <div class="page-card-body" style="text-align:center;">

        <?php if ($success): ?>
            <div class="alert-success" style="text-align:left;">
                &#10003; Guide successfully added to the database!
            </div>
        <?php else: ?>
            <div class="alert-error" style="text-align:left;">
                &#10007; Something went wrong. Please try again.
            </div>
        <?php endif; ?>

        <div class="progress-wrap">
            <p class="progress-label-top" style="text-align:left;">Saving&hellip;</p>
            <div class="progress-track">
                <div class="progress-bar" id="myBar">
                    <span id="label">10%</span>
                </div>
            </div>
        </div>

        <a href="index.html" class="btn btn-primary" style="margin-top:24px; width:100%;">
            &#8592; Back to Home
        </a>

        </div>
    </div>

    <script>
        var bar   = document.getElementById("myBar");
        var lbl   = document.getElementById("label");
        var width = 10;
        var id    = setInterval(frame, 12);

        function frame() {
            if (width >= 100) {
                clearInterval(id);
                lbl.textContent = "Done!";
            } else {
                width++;
                bar.style.width = width + "%";
                lbl.textContent = width + "%";
            }
        }
    </script>

</body>
</html>
