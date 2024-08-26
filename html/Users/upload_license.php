<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['license_picture']) && $_FILES['license_picture']['error'] === UPLOAD_ERR_OK) {
        if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
            $userId = $_POST['user_id'];

            // Temporary file path
            $tmpName = $_FILES['license_picture']['tmp_name'];

            // Directory to save the uploaded file
            $uploadDir = __DIR__ . 'license';
            
            // Ensure directory exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Define the destination path
            $uploadFile = $uploadDir . basename($_FILES['license_picture']['name']);

            // Move the file from temporary location to the destination
            if (move_uploaded_file($tmpName, $uploadFile)) {
                echo "License picture uploaded successfully.";

                // Connect to the database
 
	$hostName = "localhost:3307";
	$dbuser = "root";
	$dbpassword = "";
	$dbname = "registerdb";

	$conn = mysqli_connect($hostName, $dbuser, $dbpassword, $dbname);

	if (!$conn) {
		die("Something went wrong");
	}

                // Example: $conn = new mysqli($servername, $username, $password, $dbname);

                // Update the database
                $sql = "UPDATE users SET license_picture = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('si', $uploadFile, $userId);

                if ($stmt->execute()) {
                    echo "Database updated successfully.";
                } else {
                    echo "Error updating database: " . $stmt->error;
                }

                $stmt->close();
                $conn->close();
            } else {
                echo "Failed to move uploaded file.";
            }
        } else {
            echo "User ID is missing.";
        }
    } else {
        echo "No file uploaded or there was an upload error.";
    }
} else {
    echo "Invalid request method.";
}
?>
