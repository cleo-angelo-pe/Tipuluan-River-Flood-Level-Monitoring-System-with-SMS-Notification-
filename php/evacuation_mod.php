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
                 <h3>Evacuation</h3>
                <!-- Box Section -->
            
                <!-- Table Section -->
           <?php
// Include database configuration
include 'config.php'; 

// Initialize variables
$id = null;
$row = null;

// Fetch data for the selected row if an ID is passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM evacuation WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
}

// Handle form submission for update
if (isset($_POST['update_eva'])) {
    $id = $_POST['id']; // Get the id of the record to update
    $district = mysqli_real_escape_string($conn, $_POST['district']);
    $site = mysqli_real_escape_string($conn, $_POST['site']);

    // Update query
    $sql_update = "UPDATE evacuation SET district = '$district', site = '$site' WHERE id = $id";
    if (mysqli_query($conn, $sql_update)) {
        // Success message with SweetAlert
        echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Data Updated Successfully',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location='Evacuation.php';
            });
        </script>";
        exit();
    } else {
        // Error message
        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error updating record',
                text: '" . mysqli_error($conn) . "'
            });
        </script>";
    }
}

// Handle form submission for delete
if (isset($_POST['delete_eva'])) {
    $id = $_POST['id']; // Get the id of the record to delete

    // Delete query
    $sql_delete = "DELETE FROM evacuation WHERE id = $id";
    if (mysqli_query($conn, $sql_delete)) {
        // Success message with SweetAlert
        echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Data Deleted Successfully',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location='Evacuation.php';
            });
        </script>";
        exit();
    } else {
        // Error message
        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error deleting record',
                text: '" . mysqli_error($conn) . "'
            });
        </script>";
    }
}
?>


<!-- HTML form for updating or deleting evacuation record -->
<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-5 mt-5 pt-5">
            <form action="evacuation_mod.php" method="POST">
                <!-- Hidden input for ID -->
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                <!-- District Input -->
                <div class="mb-3">
                    <label for="district" class="form-label">District</label>
                    <input type="text" class="form-control" name="district" id="district" value="<?php echo htmlspecialchars($row['district']); ?>">
                </div>

                <!-- Site Input -->
                <div class="mb-3">
                    <label for="site" class="form-label">Place of Evacuation</label>
                    <input type="text" class="form-control" name="site" id="site" value="<?php echo htmlspecialchars($row['site']); ?>">
                </div>

                <!-- Button Row -->
                <div class="row pt-5">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="row">
                            <!-- Back Button -->
                            <div class="col-md-4">
                            <button type="button" class="btn btn-secondary w-100" onclick="window.history.back();">Back</button>
                            </div>
                            <!-- Delete Button -->
                            <div class="col-md-4">
                                <button type="submit" name="delete_eva" class="btn btn-danger w-100">Delete</button>
                            </div>
                            <!-- Update Button -->
                            <div class="col-md-4">
                                <button type="submit" name="update_eva" class="btn btn-primary w-100">Update</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>


    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="../script/sidebar.js"></script>
</body>

</html>
