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
            <h3>Dashboard</h3>
                
                <!-- Box Section -->


                <?php
                include 'config.php';

                // Query to count all rows in phonenumbers table
                $sql = "SELECT COUNT(*) as total FROM phonenumbers";
                $result = $conn->query($sql);

                $total = 0;
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $total = $row['total'];
                }

                // Query to count all rows in evacuation table
                $sql = "SELECT COUNT(*) as total FROM evacuation";
                $result = $conn->query($sql);

                $total_eva = 0;
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $total_eva = $row['total'];  // Corrected here
                }

                $conn->close();
                ?>


                <div class="container boxwrap">
    <div class="container text-center pt-5">
        <!-- Apply d-flex, justify-content-center, and align-items-center to center both horizontally and vertically -->
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-4 boxes"> 
                <div class="col-md-12 d-flex align-items-center">
                    <i class="bi bi-person-lines-fill icon"></i>
                    <div>
                        <h5 class='dashdef'>Total Number of Recipients</h5>
                        <h4 class='num'><?php echo $total; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4 boxes"> 
                <div class="col-md-12 d-flex align-items-center">
                    <i class="bi bi-water icon"></i>
                    <div>
                        <h5 class='dashdef'>Water Height in (Meter)</h5>
                        <h4 class='num'>12</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4 boxes"> 
                <div class="col-md-12 d-flex align-items-center">
                    <i class="bi bi-shop icon"></i>
                    <div>
                        <h5 class='dashdef'>Total of Place Evacuation</h5>
                        <h4 class='num'><?php echo $total_eva; ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- end of box-->



<?php
// Include your database connection
include 'config.php';

// Query to get the average water level per month
$query = "
    SELECT 
        MONTH(data_time) AS month,
        AVG(distance) AS avg_distance
    FROM 
        distance_data
    GROUP BY 
        MONTH(data_time)
    ORDER BY 
        MONTH(data_time);
";

$result = mysqli_query($conn, $query);

// Arrays to store months and average water levels
$months = [];
$average_levels = [];

while ($row = mysqli_fetch_assoc($result)) {
    // Convert month number to month name
    $months[] = date('F', mktime(0, 0, 0, $row['month'], 10));
    $average_levels[] = $row['avg_distance'];
}

mysqli_close($conn);  // Close the database connection
?>

<!-- Charts Section -->
<div class="chartsjs">
    <div class="container text-center mt-5">
        <div class="row">
            <!-- Line Chart -->
            <div class="col-12 col-md-6" style="margin-bottom: 20px;">
                <canvas id="myChart" width="400" height="400"></canvas>
            </div>
            <!-- Bar Chart -->
            <div class="col-12 col-md-6" style="margin-bottom: 20px;">
                <canvas id="barChart" width="400" height="400"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
// Pass the PHP arrays to JavaScript
const lineLabels = <?php echo json_encode($months); ?>;  // Pass months from PHP
const lineData = {
    labels: lineLabels,
    datasets: [{
        label: 'Water Levels',
        data: <?php echo json_encode($average_levels); ?>,  // Pass average levels from PHP
        fill: false,
        borderColor: 'rgb(75, 192, 192)',
        tension: 0.1
    }]
};
const lineConfig = {
    type: 'line',
    data: lineData,
};
const ctxLine = document.getElementById('myChart').getContext('2d');
const myLineChart = new Chart(ctxLine, lineConfig);

// Bar chart setup
const barLabels = <?php echo json_encode($months); ?>;
const barData = {
    labels: barLabels,
    datasets: [{
        label: 'Water Average Level',
        data: <?php echo json_encode($average_levels); ?>,
        backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(255, 205, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(201, 203, 207, 0.2)'
        ],
        borderColor: [
            'rgb(255, 99, 132)',
            'rgb(255, 159, 64)',
            'rgb(255, 205, 86)',
            'rgb(75, 192, 192)',
            'rgb(54, 162, 235)',
            'rgb(153, 102, 255)',
            'rgb(201, 203, 207)'
        ],
        borderWidth: 1
    }]
};
const barConfig = {
    type: 'bar',
    data: barData,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    },
};
const ctxBar = document.getElementById('barChart').getContext('2d');
const myBarChart = new Chart(ctxBar, barConfig);
</script>



                <!-- Table Section -->
                <div class="tabless">
    <div class="container text-center">
        <div class="col">
            <!-- Responsive Table -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>District</th>
                            <th>Place of Evacuation Site</th>
                            <th>Initial total of Evacuees</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'config.php'; // Ensure successful database connection

                        // SQL query to fetch data
                        $query = "SELECT id, district, site, evacuees FROM evacuation LIMIT 10"; // Added 'evacuees' column
                        $result = mysqli_query($conn, $query);

                        if (!$result) {
                            // Display error message if query fails
                            echo "<tr><td colspan='4'>Query Error: " . mysqli_error($conn) . "</td></tr>";
                        } else {
                            // Check if any rows are returned
                            if (mysqli_num_rows($result) > 0) {
                                // Display data if rows are found
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['district']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['site']) . "</td>";
                                    // Ensure 'evacuees' column is handled properly
                                    echo "<td>" . (isset($row['evacuees']) ? htmlspecialchars($row['evacuees']) : '-') . "</td>";
                                    // Action buttons
                                    echo "<td>
                                            <a href='evacuation_mod.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Edit</a>
                                        </td>";
                                    echo "</tr>";
                                }
                            } else {
                                // Display "No data found" if table is empty
                                echo "<tr><td colspan='4' class='center-text'>No data found</td></tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

                                                    
                                                         <!-- Table Section -->
                    <?php
                    include 'config.php'; 
                    
                    // Handle the form submission
                    $from_date = '';
                    $to_date = '';
                    
                    // Check if the form is submitted and the from_date is provided
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['from_date'])) {
                        $from_date = $_POST['from_date'];
                        $to_date = isset($_POST['to_date']) ? $_POST['to_date'] : ''; // To date is optional
                    
                        // Modify query based on whether a "to_date" is provided
                        if (!empty($to_date)) {
                            $sql = "SELECT * FROM `distance_data` WHERE `data_time` BETWEEN '$from_date' AND '$to_date' LIMIT 20";
                        } else {
                            $sql = "SELECT * FROM `distance_data` WHERE `data_time` >= '$from_date' LIMIT 10"; // Only from date
                        }
                    } else {
                        // Default fetch all records if no filter is applied
                        $sql = "SELECT * FROM `distance_data` LIMIT 10";
                    }
                    
                    $result = $conn->query($sql);
                    
                    // Function to determine the level based on distance
                    function getLevel($distance) {
                        if ($distance >= 0.0 && $distance <= 53.0) {
                            return "LOW";
                        } elseif ($distance >= 54.0 && $distance <= 76.0) {
                            return "LOW-MID";
                        } elseif ($distance >= 76.20 && $distance <= 99.0) {
                            return "MIDDLE";
                        } elseif ($distance >= 99.06 && $distance <= 121.0) {
                            return "MID-HIGH";
                        } elseif ($distance >= 121.92 && $distance <= 135.00) {
                            return "HIGH";
                        }
                        return "Unknown";  // In case distance doesn't fall within known ranges
                    }
                    ?>


           

                <div class="tabless">
                    <div class="container text-center">
                        <div class="col">
                            <table class="table table-striped table-hover" id="printTable">
                                <thead>
                                    <tr>
                                        <th>Distance</th>
                                        <th>Level</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <?php
                                        if ($result->num_rows > 0) {
                                            // Output data for each row
                                            while($row = $result->fetch_assoc()) {
                                                $distance = $row['distance'];
                                                $level = getLevel($distance);
                                                echo "<tr>
                                                        <td>" . $distance . "</td>
                                                        <td>" . $level . "</td>
                                                        <td>" . $row['data_time'] . "</td>
                                                      </tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='3'>No records found</td></tr>";
                                        }
                                        ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                                                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="../script/sidebar.js"></script>
</body>

</html>
