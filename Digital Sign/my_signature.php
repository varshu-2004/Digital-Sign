<?php
require 'config.php';

if(!isset($_SESSION["login"])){
  header("Location: user_login.php");
  exit();
}

$userId = $_SESSION["id"];
$result = mysqli_query($conn, "SELECT id, signature FROM signatures WHERE user_id = '$userId'");
$signatures = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Signature</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <style>
       body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        h1{
            text-align: center;
        }
        #sidePanel {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            background-color: #333;
            padding: 20px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }
        #sidePanel a {
            color: white;
            text-decoration: none;
            padding: 10px;
            margin-bottom: 10px;
            font-size: 18px;
        }
        #sidePanel a:hover {
            background-color: #555;
        }
        #content {
            margin-left: 200px; /* Width of the side panel */
            padding: 20px;
        }
        #signatureContainer {
            margin-top: 20px;
            text-align: center;
        }
        #signatureImage {
            max-width: 400px;
            border: 1px solid #ccc;
            padding: 10px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div id="sidePanel">
        <a href="signature_pad.php">Signature Pad</a>
        <a href="my_signature.php">My Signature</a>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="container">
        <h1>My Signatures</h1>
        <div class="row">
            <?php foreach($signatures as $signature): ?>
            <div class="col-md-6 col-md-offset-3">
                <div class="thumbnail">
                    <img src="<?php echo $signature['signature']; ?>" alt="Signature" style="max-width: 400px;">
                    <div class="caption">
                        <p>
                            <a href="delete_signature.php?id=<?php echo $signature['id']; ?>" class="btn btn-danger" role="button">Delete</a>
                            <a href="export_signature.php?id=<?php echo $signature['id']; ?>" class="btn btn-success" role="button">Export</a>
                        </p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>