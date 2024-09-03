

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
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
    </style>
</head>
<body>
    <div id="sidePanel">
        <a href="signature_pad.php">Signature Pad</a>
        <a href="my_signature.php">My Signature</a>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </div>
    <div id="content">
        <h1>Welcome</h1>
    </div>
</body>
</html>
