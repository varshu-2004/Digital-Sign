<?php
    // Include the database connection
    require_once "config.php";
    
    // Check if the table exists
    $table_name = "users";
    $check_query = "SHOW TABLES LIKE '$table_name'";
    $result = mysqli_query($conn, $check_query);
    if (mysqli_num_rows($result) == 0) {
        // Table does not exist, create it
        $create_query = "CREATE TABLE $table_name (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL
        )";
        if (!mysqli_query($conn, $create_query)) {
            echo "Error creating table: " . mysqli_error($conn);
            exit;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
    
        // Additional server-side validation can be added here
    
        // Prepare the query using a prepared statement
        $query = "INSERT INTO $table_name (username, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
    
        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password);
    
        // Execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            echo "Registration successful!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    }
?>
