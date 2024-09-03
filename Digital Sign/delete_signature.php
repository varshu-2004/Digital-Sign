<?php
require 'config.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM signatures WHERE id = '$id'";
    if(mysqli_query($conn, $sql)) {
        header("Location: my_signature.php");
        exit();
    } else {
        echo "Error deleting signature: " . mysqli_error($conn);
    }
} else {
    echo "Signature ID not specified.";
}
?>
