<?php
session_start();
include("../dbp.php");

// Check if the user is logged in
if (!isset($_SESSION['profile1'])) {
    header("Location: ../error.php");
    exit();
}

// Check if a mission ID is received via POST
if (isset($_POST['selected_mission'])) {
    $selected_mission = $_POST['selected_mission'];
    $_SESSION['selected_mission'] = $selected_mission;
} else {
    header("Location: driver.php");
    exit();
}

// Get user information
$id = $_SESSION['user_id'];
$sql = $link->prepare("SELECT * FROM driver WHERE id = ?");
$sql->bind_param("i", $id);
$sql->execute();
$result = $sql->get_result();
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Incidentals</title>
    <link rel="stylesheet" href="incidentals.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="sidebar close">
    <div class="logo-details">
        <i class="#"></i>
        <span class="logo_name">VROOMCAR</span>
    </div>
    <ul class="nav-links">
        <li>
            <a href="driver.php">
                <i class='bx bx-grid-alt' ></i>
                <span class="link_name">Dashboard</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="driver.php">Dashboard</a></li>
            </ul>
        </li>
        <li>
            <div class="iocn-link">
                <a href="mission.php">
                    <i class='bx bx-collection' ></i>
                    <span class="link_name">Mission</span>
                </a>
                <i class='bx bxs-chevron-down arrow' ></i>
            </div>
            <ul class="sub-menu">
                <li><a href="mission.php">View Mission</a></li>
                <li><a href="incidentals.php">Add Incidentals</a></li>
            </ul>
        </li>
        <li>
            <a href="account.php">
                <i class="fa-solid fa-user"></i>
                <span class="link_name">Account</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="account.php">Account</a></li>
            </ul>
        </li>
        <li>
            <div class="profile-details">
                <div class="profile-content">
                    <img src="../../html/img/driver.PNG" alt="profileImg">
                </div>
                <div class="name-job">
                    <h3 id="name"></h3>
                    <div class="profile_name"><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></div>
                    <div class="job">Driver</div>
                </div>
                <a href="../disconnect.php" class="logout-link">
                    <i class='bx bx-log-out'></i>
                </a>
            </div>
        </li>
    </ul>
</div>
<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu' ></i>
        <span class="text"></span>
    </div>
    <!-- Mission Dashboard -->
    <?php
    $mission_sql = $link->prepare("SELECT * FROM mission WHERE id_mission = ?");
    $mission_sql->bind_param("i", $selected_mission);
    $mission_sql->execute();
    $mission_result = $mission_sql->get_result();
    $mission_row = $mission_result->fetch_assoc();
    ?>
    <div class="mission-dashboard">
        <h1>Mission Dashboard:</h1>
        <table border="1">
            <tr>
                <th>Departure City</th>
                <th>Arrival City</th>
                <th>Departure Date</th>
                <th>Arrival Date</th>
                <th>Cost</th>
                <th>Type</th>
                <th>Vehicle</th>
                <th>Finish</th>
            </tr>
            <tr>
                <td><?php echo $mission_row['departure_city']; ?></td>
                <td><?php echo $mission_row['arrival_city']; ?></td>
                <td><?php echo $mission_row['departure_date']; ?></td>
                <td><?php echo $mission_row['arrival_date']; ?></td>
                <td><?php echo $mission_row['cost']; ?></td>
                <td><?php echo $mission_row['type']; ?></td>
                <td><?php
                    $vehicle_sql = $link->prepare("SELECT * FROM vehicle WHERE id_vehicle = ?");
                    $vehicle_sql->bind_param("i", $mission_row['id_vehicle']);
                    $vehicle_sql->execute();
                    $vehicle_result = $vehicle_sql->get_result();
                    $vehicle_row = $vehicle_result->fetch_assoc();
                    echo ($vehicle_result->num_rows > 0) ? $vehicle_row['immatriculation'] : 'N/A';
                    ?></td>
                <td><?php echo $mission_row['finish']; ?></td>
            </tr>
        </table>
        <!-- Vehicle Details -->
        <div class="vehicle-details">
        <h1>Vehicle Details:</h1>
        <table border="1">
            <tr>
                <th>Vehicle ID</th>
                <th>Immatriculation</th>
                <th>Type</th>
                <th>License Type</th>
                <th>Brand</th>
                <th>State</th>
            </tr>
            <?php
            $vehicle_id = $mission_row['id_vehicle'];
            $vehicle_details_sql = $link->prepare("SELECT * FROM vehicle WHERE id_vehicle = ?");
            $vehicle_details_sql->bind_param("i", $vehicle_id);
            $vehicle_details_sql->execute();
            $vehicle_details_result = $vehicle_details_sql->get_result();

            if ($vehicle_details_result->num_rows > 0) {
                while ($vehicle_details_row = $vehicle_details_result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $vehicle_details_row['id_vehicle']; ?></td>
                        <td><?php echo $vehicle_details_row['immatriculation']; ?></td>
                        <td><?php echo $vehicle_details_row['type']; ?></td>
                        <td><?php echo $vehicle_details_row['license_type']; ?></td>
                        <td><?php echo $vehicle_details_row['brand']; ?></td>
                        <td><?php echo $vehicle_details_row['state']; ?></td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="6">No vehicle details found</td>
                </tr>
                <?php
            }
            ?>
        </table>
        </div>
        <form action="process_finish.php" method="post">
            <input type="hidden" name="mission_id" value="<?php echo $selected_mission; ?>">
            <input type="submit" class="finish-button" name="finish-button" value="Finish Mission">
        </form>
        <div id="frais-imprevus">
            <form action="process_incidentals.php" method="post">
                <h1>Incidentals:</h1>
                <input type="text" name="incidentals" placeholder="Enter incidentals..." required><br>
                <input type="number" name="amount" placeholder="Enter amount..." required><br>
                <input type="submit" name="submit" value="Send">&nbsp;
                <input type="reset" value="Cancel">
            </form>
        </div>
    </div>
    
        
</section>
<script>
    let arrow = document.querySelectorAll(".arrow");
    for (var i = 0; i < arrow.length; i++) {
        arrow[i].addEventListener("click", (e)=>{
            let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
            arrowParent.classList.toggle("showMenu");
        });
    }
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".bx-menu");
    console.log(sidebarBtn);
    sidebarBtn.addEventListener("click", ()=>{
        sidebar.classList.toggle("close");
    });
</script>
</body>
</html>
