<?php
require 'config.php';
if (!isset($_SESSION["login"])) {
    header("Location: user_login.php");
    exit();
}

$userId = $_SESSION["id"];
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$dob = $_POST["dob"];
$email = $_POST["email"];

$query = "UPDATE users SET fname='$fname', lname='$lname', dob='$dob', email='$email' WHERE id='$userId'";
if (mysqli_query($conn, $query)) {
    echo "Profile updated successfully";
} else {
    echo "Error updating profile: " . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Profile</title>
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
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        label {
            font-weight: bold;
        }
        .form-control {
            width: 300px;
        }
        .btn-save, .btn-discard {
            display: none;
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
        <h2>Update Profile</h2>
        <form method="POST">
            <div class="form-group">
                <label for="fname">First Name:</label>
                <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $_SESSION["fname"]; ?>" required>
            </div>
            <div class="form-group">
                <label for="lname">Last Name:</label>
                <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $_SESSION["lname"]; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $_SESSION["email"]; ?>" required>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $_SESSION["dob"]; ?>" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</body>
</html>