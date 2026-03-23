<?php
// Database connection
//config.php

$host = "localhost";  // Change if needed
$user = "u534123466_sensors";
$password = "dfsfdcsd5erefdf@cfdfT";
$database = "u534123466_sensors_db";

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert distance data if set in POST request
if (isset($_POST['distance'])) {
    // Fetch the distance value from the POST request and validate it
    $distance = $_POST['distance'];

    // Validate that distance is a numeric value
    if (!is_numeric($distance)) {
        die("Invalid distance value.");
    }

    // Convert distance to integer (optional, but good practice)
    $distance = (int)$distance;

    // Prepare and bind the statement
    $stmt = $conn->prepare("INSERT INTO distance_data (distance) VALUES (?)");
    
    // Check if the preparation was successful
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind the parameter; 'i' indicates the type is integer
    $stmt->bind_param("i", $distance);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "New distance record created successfully"."\n";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}


// Insert phone numbers data
if (isset($_POST['phonebtn'])) {
    // Set parameters to be executed
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    
    // Validate the phone number length
    if (strlen($phone) !== 11 || !ctype_digit($phone)) {
        // Redirect with invalid phone number status
        header("Location:../index.php?status=invalid_phone");
        exit;
    }

    // Prepare the statement to check for duplicate phone number
    $checkPhoneStmt = $conn->prepare("SELECT * FROM phonenumbers WHERE phonenum = ?");
    $checkPhoneStmt->bind_param("s", $phone);
    $checkPhoneStmt->execute();
    $phoneResult = $checkPhoneStmt->get_result();

    // Check for duplicate email only if the email field is not blank
    $isDuplicateEmail = false;
    if (!empty($email)) {
        $checkEmailStmt = $conn->prepare("SELECT * FROM phonenumbers WHERE email = ?");
        $checkEmailStmt->bind_param("s", $email);
        $checkEmailStmt->execute();
        $emailResult = $checkEmailStmt->get_result();
        $isDuplicateEmail = $emailResult->num_rows > 0;
        $checkEmailStmt->close(); // Close the statement
    }

    if ($phoneResult->num_rows > 0 && $isDuplicateEmail) {
        // Both email and phone already exist
        header("Location:../index.php?status=duplicate_both");
    } elseif ($phoneResult->num_rows > 0) {
        // Only phone number exists
        header("Location:../index.php?status=duplicate_phone");
    } elseif ($isDuplicateEmail) {
        // Only email exists
        header("Location:../index.php?status=duplicate_email");
    } else {
        // Prepare the insert statement since no duplicates were found
        $stmt = $conn->prepare("INSERT INTO phonenumbers (name, phonenum, email) VALUES (?, ?, ?)");

        if ($stmt) {
            // Bind the parameters to the statement
            $stmt->bind_param("sss", $name, $phone, $email);

            // Execute the statement
            if ($stmt->execute()) {
                // Redirect with success status
                header("Location:../index.php?status=success");
            } else {
                // Redirect with error status if execution fails
                header("Location: ../index.php?status=error");
            }

            // Close statement
            $stmt->close();
        } else {
            // Redirect with error status if statement preparation fails
            header("Location:../index.php?status=error");
        }
    }

    // Close the phone check statement
    $checkPhoneStmt->close();
}


// Signup
if (isset($_POST['signupbtn'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate password confirmation
    if ($password !== $confirm_password) {
        echo "<script>alert('Error: Password doesn't match.');window.location='login.php'</script>";
        exit();
    }

    $emailChecker = "SELECT * FROM admin WHERE username=?";
    $stmt = $conn->prepare($emailChecker);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Error: Email already exists.');window.location='login.php'</script>";
        exit();
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL statement to avoid SQL Injection
    $stmt = $conn->prepare("INSERT INTO admin (name, username, password) VALUES (?, ?, ?)");

    // Bind parameters to the statement
    $stmt->bind_param("sss", $name, $username, $hashed_password);

    // Execute the operation
    if ($stmt->execute()) {
        echo "<script>alert('Data successfully inserted.');window.location='login.php'</script>";
    } else {
        echo "<script>alert('Something went wrong.');window.location='login.php'</script>";
    }

    // Close statement
    $stmt->close();
}



if (isset($_POST['loginbtn'])) {
    
    // Login
if (session_status() === PHP_SESSION_NONE) {
    session_start();
};
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admin WHERE username=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $db_password = $row['password'];

        if (password_verify($password, $db_password)) {
            session_regenerate_id(true); // Prevent session fixation attacks
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $row['name']; // Assuming 'name' is a column in your 'admin' table
            echo "<script>alert('Login successfully');window.location='Adash.php'</script>";
            exit();
        }
         else {
            echo "<script>alert('Invalid username or password');window.location='login.php'</script>";
            exit();
        }
    } else {
        echo "<script>alert('Invalid username or password');window.location='login.php'</script>";
        exit();
    }

    // Close statement
    $stmt->close();
}

?>
