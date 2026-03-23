<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Please log in first');window.location='login.php'</script>";
    exit();
}

// Retrieve the user's name
$name = $_SESSION['name'];
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tipulua.site</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/sidebar.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <div class="wrapper">
       <aside id="sidebar">
    <div class="d-flex">
        <button class="toggle-btn" type="button">
            <i class="lni lni-grid-alt"></i>
        </button>
        <div class="sidebar-logo">
            <a href="#">Tipuluan River</a>
        </div>
    </div>
    <ul class="sidebar-nav">
        <li class="sidebar-item">
            <a href="Adash.php" class="sidebar-link">
                <i class="lni lni-grid-alt"></i>
                <span>Overview</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="profile.php" class="sidebar-link">
                <i class="lni lni-user"></i>
                <span>Distance Record</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="Evacuation.php" class="sidebar-link">
                <i class="lni lni-agenda"></i>
                <span>Evacuation</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                <i class="lni lni-protection"></i>
                <span>Account</span>
            </a>
            <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">Login</a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">Register</a>
                </li>
            </ul>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                data-bs-target="#sms" aria-expanded="false" aria-controls="sms">
                <i class="lni lni-layout"></i>
                <span>Messages</span>
            </a>
            <ul id="sms" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="sms_message_fetch.php" class="sidebar-link">View SMS</a>
                </li>
                <li class="sidebar-item">
                    <a href="email_message_fetch.php" class="sidebar-link">View Email</a>
                </li>
            </ul>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                data-bs-target="#settings" aria-expanded="false" aria-controls="settings">
                <i class="lni lni-cog"></i>
                <span>Setting</span>
            </a>
            <ul id="settings" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="logout.php" class="sidebar-link">
                        <i class="lni lni-exit"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>

        
        <div class="main">
        <div class="fixed-header">
                <div class="col">
                    <div class="row">
                        <div class="col-6 ms-3">
                        <h1 class='mt-3'>Hello, <?php echo htmlspecialchars($name); ?></h1><br>
                        </div>
                        <div class="col"></div>
                        <div class="col-3">
                        <img class='mt-2 pl-5' src="../images/profile.png" alt="Profile Image" style="width: 60px; height: auto;" >
                        </div>
                    </div>
                </div>
            </div>
            <div class="scrollable-content">
            <h3>Email Message</h3>
                <!-- Content Goes Here -->




                                <?php
                include 'config.php';

                // Check if 'column' is set in the query string
                if (isset($_GET['column'])) {
                    $column = $_GET['column'];
                    
                    // Fetch current value for the selected column
                    $sql = "SELECT $column FROM message LIMIT 1";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $currentValue = $row[$column];
                    } else {
                        echo 'No records found';
                        exit;
                    }
                }

          // Update data when form is submitted
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updatesms']) && isset($_POST['color'])) {
                        $newValue = mysqli_real_escape_string($conn, $_POST['color']);
                        
                        // Update the selected column in the database
                        $updateSql = "UPDATE message SET $column = '$newValue' WHERE id = 1"; // Assuming id = 1 for simplicity
                        if ($conn->query($updateSql) === TRUE) {
                            echo "
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Data Updated Successfully',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    window.location='sms_message_fetch.php';
                                });
                            </script>";
                            exit;
                        } else {
                            echo "
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error Updating Data',
                                    text: '" . $conn->error . "'
                                });
                            </script>";
                        }
                    }
                ?>

<div class="container mt-4 pt-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h3>Want to update level <?php echo ucfirst($column); ?> alert message?</h3>
            <form action="" method="post">
                <div class="mb-4">
                    <!-- Make the input field larger and longer -->
                    <textarea class="form-control" name="color" placeholder="Enter text here" rows="6" style="width: 100%;" aria-label="Input text"><?php echo htmlspecialchars($currentValue); ?></textarea>
                </div>
                <!-- Centering the buttons using flexbox -->
                <div class="d-flex justify-content-center">
                    <button class="btn btn-primary" type="submit" name="updatesms">Submit</button>
                    <!-- Cancel Button with space between using margin class -->
                    <button type="button" class="btn btn-secondary ms-3" onclick="window.history.back();">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


                
                


              

          



              <!-- Content ends Here -->
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="../script/sidebar.js"></script>
</body>

</html>
