<?php
$hostName = "localhost:3307";
$dbuser = "root";
$dbpassword = "";
$dbname = "registerdb";

$conn = mysqli_connect($hostName, $dbuser, $dbpassword, $dbname);

if (!$conn) {
    die("Something went wrong");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user ID from the form submission
    $user_id = $_POST['user_id'];

    // Update the verification status to 'verified'
    $sql = "UPDATE users SET verification_status = 'verified' WHERE id = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $user_id);
        if (mysqli_stmt_execute($stmt)) {
            echo "User verified successfully!";
        } else {
            echo "Error verifying user.";
        }
    }
}
?>
