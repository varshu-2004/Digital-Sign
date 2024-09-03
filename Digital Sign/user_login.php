<?php
require 'config.php';

if(isset($_SESSION["login"])){
  header("Location: User_homePage.php");
}

if(isset($_POST["submit"])){
  $username = $_POST["username"];   
  $password = $_POST["password"];
  $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
  $row = mysqli_fetch_assoc($result);
  if(mysqli_num_rows($result) > 0){
    if($password == $row['password']){
      $_SESSION["login"] = true;
      $_SESSION["id"] = $row["id"];
      $_SESSION["username"] = $row["username"];
      $_SESSION["fname"] = $row["fname"];
      $_SESSION["lname"] = $row["lname"];
      $_SESSION["dob"] = $row["dob"];
      $_SESSION["email"] = $row["email"];
      header("Location: User_homePage.php");
    }
    else{
      echo "<script> alert('Wrong Password'); </script>";
    }
  }
  else{
    echo "<script> alert('User Not Registered'); </script>";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <style>
        /* Basic styling for the body */
        body {
            font-family: Arial, sans-serif;
            display: block;
            background-color: #f2f2f2; /* Background color for the entire page */
             /* Center the content horizontally */
            align-items: center; /* Center the content vertically */
            height: 100vh; /* Ensure the container takes the full height of the viewport */
            margin: 0;
        }

                /*----------------- Header---------*/
                header{
                    height: 80px;
                    background: black;
                    width: 100%;
                    position: relative;
                    z-index: 15;
                    height: 130px;
                }
                nav{
                    display: flex;
                    width: 100%;
                    padding: 5px 0;
                    align-items: center;
                    flex-wrap: wrap;
                    font-weight: bold;
                }
                .logo{
                    width: 155px;
                    cursor: pointer;
                    margin-left: 20px;
                    margin-top: 10px;
                }
                nav ul{
                    flex: 1;
                    text-align: right;
                    padding-right: 30px;
                }
                nav ul li{
                    list-style: none;
                    display: inline-block;
                    margin: 10px 30px;
                }
                nav ul li a{
                    color: #fff;
                    text-decoration: none;
                    position: relative;
                }
                nav ul li a::after{
                    content: '';
                    width: 0;
                    height: 3px;
                    position: absolute;
                    bottom: -5px;
                    left: 50%;
                    background: red;
                    transform: translateX(-50%);
                    transition: width 0.3s;
                }
                nav ul li a:hover::after{
                    width: 50%;
                }

        /*-------User Login headline---------- */
        h2{
            text-align: center;
        }

        /* Styling for the form container */
        .form-container {
            background-color: #fff; /* Background color for the form container */
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px;
            text-align: center;
            margin: auto;
            margin-top: 150px;
        }

        /*  form styling */
        form {
            margin: 0 auto; /* Center the form horizontally within the container */
        }
        
        /* Styles for input fields, button, and error messages */
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        .divbutton{
            text-align: center;
        }
            /*Anchor tag Style*/
        a{
            text-decoration: none;
            color: black;
            font-size: 12px;
        }
        /*------Button style------*/
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <!-------------------Header------------------>
    <section class="container">
            <header>
            <nav>
               <a href="Home.html"><img src="epost_logo.png"  class="logo"></a>
                  <ul>
                     <li><a href="index.html">Home</a></li>
                     <li><a href="user_login.php">Login</a></li>
                     <li><a href="admin_login.php">Admin Login</a></li>
                  </ul>
            </nav>
            </header>           
         </section>
        
    <!-------------------Login Form------------------>     
    <div class="form-container">
        <form method="POST" action="user_login.php"> 
            <h2>User Login</h2> 
            <input type="text" name="username" id ="username" placeholder="Username" required>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <div class="divbutton"><button type="submit" name="submit">Login</button></div>
        </form>
        <br>
        <a href="user_reg.php">New User Register here ?</a><br>
        <a href="admin_login.php">Admin Login here</a>
    </div>


</body>
</html>
