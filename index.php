<?php if (isset($_GET['status'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            <?php if ($_GET['status'] == 'success'): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Your information has been successfully saved.',
                    confirmButtonText: 'OK'
                });
            <?php elseif ($_GET['status'] == 'error'): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong. Please try again.',
                    confirmButtonText: 'OK'
                });
            <?php elseif ($_GET['status'] == 'duplicate_both'): ?>
                Swal.fire({
                    icon: 'warning',
                    title: 'Duplicate Entry',
                    text: 'Both the email and phone number already exist. Please enter different ones.',
                    confirmButtonText: 'OK'
                });
            <?php elseif ($_GET['status'] == 'duplicate_phone'): ?>
                Swal.fire({
                    icon: 'warning',
                    title: 'Duplicate Phone Number',
                    text: 'The phone number already exists. Please enter a different one.',
                    confirmButtonText: 'OK'
                });
            <?php elseif ($_GET['status'] == 'duplicate_email'): ?>
                Swal.fire({
                    icon: 'warning',
                    title: 'Duplicate Email',
                    text: 'The email already exists. Please enter a different one.',
                    confirmButtonText: 'OK'
                });
                
                
                <?php elseif ($_GET['status'] == 'invalid_phone'): ?>
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Phone Number',
                    text: 'The phone number must be exactly 11 digits long. Please re-enter.',
                    confirmButtonText: 'OK'
                });
          
                
            <?php endif; ?>
        });
    </script>
<?php endif; ?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Level Chart - PALU</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/css.css">
    <!-- Add these in your <head> section -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     
      <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <span class="navbar-brand text-light font-weight-bold">Tipuluan River</span>
            <button class="navbar-toggler navbar-light" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-light">
                    <li class="nav-item">
                        <a class="nav-link text-light" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="../php/about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="../php/contacts.php">Contacts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="../php/services.php">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="../php/login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Image -->
    <div class="container-fluid mt-5 pt-5 img">
        <div class="overlay"></div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="row text-center">
            <div class="col-md-12">
                <h1 class="popo">Tipuluan River Flood Monitoring System</h1>
            </div>
        </div>
    </div>






    <!-- Chart Section -->
    <div class="container-fluid" style="width: 100%; height: 700px;">
        <canvas id="myChart"></canvas>
    </div>
    
    
        <!-- Form Section -->
    <div class="container homeform pt-5 mt-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="../php/config.php" method="post">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput1" placeholder="Cleo Angelo Pe" name="name" required>
                    <label for="floatingInput1">Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="tel" class="form-control" id="floatingInput2" placeholder="+63 955 703 8963" name="phone" required>
                    <label for="floatingInput2">Phone Number (e.g., 09XXXXXXXXX)</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput3" placeholder="cleoangelope@gmail.com" name="email">
                    <label for="floatingInput3">Email Address</label>
                </div>
                <button type="submit" class="btn btn-primary w-100" name="phonebtn">Save</button>
            </form>
        </div>
    </div>
</div>

    <!-- Evacuation Table -->
              <!-- Evacuation Table -->
            <div class="tabless">
                <div class="container text-center">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>District</th>
                                <th>Place of Evacuation Site</th>
                                <th>Initial Total of Evacuees</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Include database configuration file
                            include 'php/config.php';
            
                            // SQL query to fetch district, site, and the count of evacuees
                            $query = "
                            SELECT 
                                e.district, 
                                e.site, 
                                SUM(CASE WHEN p.Status = 'SAFE' THEN 1 ELSE 0 END) AS evacuees_count 
                            FROM 
                                evacuation e
                            LEFT JOIN 
                                phonenumbers p 
                            ON 
                                e.site = p.site
                            GROUP BY 
                                e.district
                            ORDER BY 
                                e.district ASC;
                            ";
            
                            // Execute the query
                            $result = mysqli_query($conn, $query);
            
                            // Check if the query executed successfully
                            if (!$result) {
                                echo "<tr><td colspan='3'>Query Error: " . mysqli_error($conn) . "</td></tr>";
                            } else {
                                // Check if any rows were returned
                                if (mysqli_num_rows($result) > 0) {
                                    // Fetch and display each row
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['district']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['site']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['evacuees_count']) . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    // Display a message if no data is found
                                    echo "<tr><td colspan='3' class='center-text'>No data found</td></tr>";
                                }
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

    <!-- Footer -->
    <p class="text-center pt-5 mt-5">&copy; All Rights Reserved || PALU.2024. &trade;</p>

    <!-- Scripts -->
    <script src="script/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
