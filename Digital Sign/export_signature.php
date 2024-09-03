<?php
require 'config.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT signature FROM signatures WHERE id = '$id'");
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $signature = $row['signature'];
        $filename = "signature_$id.png"; // Or any other format you want to export
        header("Content-type: image/png"); // Set appropriate content type
        header("Content-Disposition: attachment; filename=$filename"); // Set the filename for download
        readfile($signature); // Output the signature file
        exit();
    } else {
        echo "Signature not found.";
    }
} else {
    echo "Signature ID not specified.";
}
?>