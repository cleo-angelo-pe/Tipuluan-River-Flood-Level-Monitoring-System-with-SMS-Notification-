<?php
//Database Configuration


$servername="localhost";
$username="root";
$password="";
$database="tipuluan";


$conn =new mysqli($servername,$username,$password,$database);

//check the connection
if ($conn-> connect_error){
	die("connection failed". $conn-> connect_error);
}


if(isset($_POST['phonebtn'])) {
    // Set parameters to be executed
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // Prepare the statement to check for duplicates
    $checkStmt = $conn->prepare("SELECT * FROM phonenumbers WHERE phonenum = ? OR email = ?");
    $checkStmt->bind_param("ss", $phone, $email);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        // If there are any results, the phone or email already exists
        echo "<script>alert('Error: Phone number or email already exists.');window.location='index.php'</script>";
    } else {
        // Prepare the insert statement since no duplicates were found
        $stmt = $conn->prepare("INSERT INTO phonenumbers (name, phonenum, email) VALUES (?, ?, ?)");
        
        if($stmt) {
            // Bind the parameters to the statement
            $stmt->bind_param("sss", $name, $phone, $email);
            
            // Execute the statement
            if($stmt->execute()) {
                echo "<script>alert('Data inserted successfully');window.location='index.php'</script>";
            } else {
                echo "Error executing statement: " . $stmt->error;
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close the check statement
    $checkStmt->close();
}

//sign up-----------------------------------------------------------

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

    $emailchecker="SELECT * FROM admin WHERE username=?";
    $stmt=$conn->prepare($emailchecker);
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $result=$stmt->get_result();

    if($result->num_rows > 0){
    	echo "<script>alert('Error: Email already exists.');window.location='login.php'</script>";
        exit();
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL statement to avoid SQL Injection
    $stmt = $conn->prepare("INSERT INTO admin (name, username, password) VALUES (?, ?, ?)");

    // Bind parameters to the statement
    $stmt->bind_param("sss", $name,$username, $hashed_password);

    // Execute the operation
    if ($stmt->execute()) {
        echo "<script>alert('Error: Data successfuly Inserted.');window.location='login.php'</script>";
    } else {
        echo "<script>alert('Something went wrong.');window.location='login.php'</script>";
    }}




    //login-------------------------------------------


if (isset($_POST['loginbtn'])) {
    // Retrieve form data
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query="Select * from admin where username=?";
    $stmt=$conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result=$stmt->get_result();


    //fetch assoc purpose is to fetch all data from all tuple under that email

    if ($result->num_rows > 0) {
    	$row=$result->fetch_assoc();
    	$db_username=$row['username'];
    	$db_password=$row['password'];


    	if (password_verify($password, $db_password)){
    		$_SESSION['username']=$username;
            echo "<script>alert('login successfully');window.location='Adash.php'</script>";
            exit();
    	}else {
            echo "<script>alert('INVALID USERNAME AND PASSWORD');window.location='login.php'</script>";
        exit();
    }}
    // Close statement
    $stmt->close();
}









?>