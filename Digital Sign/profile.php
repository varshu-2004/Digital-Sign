<?php
require_once "config.php";
if (!isset($_SESSION["login"])) {
    header("Location: user_login.php");
    exit();
}

$userId = $_SESSION["id"];
$query = "SELECT * FROM users WHERE id = '$userId'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>

    <title>User Profile</title>
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
    <h1>User Profile</h1>
    <form id="profileForm" method="POST" action="update_profile.php">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $row["username"]; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="fname">First Name:</label>
            <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $row["fname"]; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="lname">Last Name:</label>
            <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $row["lname"]; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="dob">Date of Birth:</label>
            <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $row["dob"]; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $row["email"]; ?>" readonly>
        </div>
        <button type="button" class="btn btn-primary btn-edit">Edit</button>
        <button type="button" class="btn btn-success btn-save">Save</button>
        <button type="button" class="btn btn-danger btn-discard">Discard</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.btn-edit').click(function() {
                $(this).hide();
                $('.btn-save, .btn-discard').show();
                $('#fname, #lname, #dob, #email').prop('readonly', false);
            });

            $('.btn-discard').click(function() {
                $('.btn-save, .btn-discard').hide();
                $('.btn-edit').show();
                $('#fname, #lname, #dob, #email').prop('readonly', true);
            });

            $('.btn-save').click(function() {
                var formData = $('#profileForm').serialize();
                $.post('update_profile.php', formData, function(response) {
                    alert(response);
                    location.reload(); // Reload the page to reflect the changes
                });
            });
        });
    </script>
</body>
</html>
