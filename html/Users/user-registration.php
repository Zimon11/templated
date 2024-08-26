<?php
session_start();

if (isset($_POST["submit"])) {
    $fullname = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeat_pass = $_POST['repeat_password'];
    $contact = ""; // Placeholder for contact number
    $status = "Available"; // Default status
    $assigned_bus = ""; // Initially, no bus is assigned

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $errors = array();

    if (empty($fullname) || empty($email) || empty($password) || empty($repeat_pass)) {
        array_push($errors, "All fields are required to be filled");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email is not valid!!");
    }

    if (strlen($password) < 8) {
        array_push($errors, "Password must be at least 8 characters long");
    }

    if ($password !== $repeat_pass) {
        array_push($errors, "Password does not match");
    }

    require_once("user-database.php");
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $rowCount = mysqli_num_rows($result);
    if ($rowCount > 0) {
        array_push($errors, "Email already exists!!!");
    }

    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    } else {
        $sql = "INSERT INTO users (Full_name, Email, Password, Contact, Status, Assigned_bus) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        $preparestmt = mysqli_stmt_prepare($stmt, $sql);
        if ($preparestmt) {
            mysqli_stmt_bind_param($stmt, "ssssss", $fullname, $email, $hash, $contact, $status, $assigned_bus);
            mysqli_stmt_execute($stmt);
            echo "<div class='alert alert-success'> You are registered.</div>";
        } else {
            die("Something went wrong.");
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <title>Registration</title>
    <link rel="stylesheet" type="text/css" href="style1.css">
</head>
<body>
    <div class="container">
        <form action="user-registration.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="full_name" placeholder="Full name:">
            </div>

            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email:">
            </div>

            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password:">
            </div>

            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password:">
            </div>

            <div class="form-btn">
                <input type="submit" class="btn btn-secondary" name="submit" value="Register">
            </div>
        </form>
        <div><p>Already registered? <a href="user-login.php">Login here</a></p></div>
    </div>
</body>
</html>
