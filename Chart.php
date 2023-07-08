<?php

session_start();

if (isset($_SESSION["user"]) == false) {
    header('Location:login.php');
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dairy";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM cattle";
$result = mysqli_query($conn, $query);
$qty = 0;
while ($num = mysqli_fetch_assoc($result))
    $qty += $num['milkProduction'];

$cow = mysqli_num_rows($result);

$dataPoints = array(
    array("x" => $cow, "y" => $qty)
);

?>

<!DOCTYPE HTML>
<html>

<head>
    <title>My Dairy Farm | Charts</title>
    <link rel="icon" type="image/x-icon" href="pinkcow.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        nav {
            display: flex;
            align-items: center;
            background-image: linear-gradient(225deg, #E3FDF5 50%, #FFE6FA 50%);
            height: 3rem;
        }

        ul {
            display: flex;
        }

        li {
            list-style: none;
        }

        a {
            padding: 0.5rem;
            text-decoration: none;
            font-size: 18.5px;
            font-weight: bold;
        }

        a:hover {
            color: blueviolet;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .section {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>

    <script>
        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                exportEnabled: true,
                theme: "light1", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: "Cow Milk Chart For Daily Milk in Kg's"
                },
                axisY: {
                    includeZero: true
                },
                data: [{
                    type: "column", //change type to bar, line, area, pie, etc
                    //indexLabel: "{y}", //Shows y value on all Data Points
                    indexLabelFontColor: "#5A5757",
                    indexLabelPlacement: "outside",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();
        }
    </script>
</head>

<body>
    <div class="container">
        <div class="section">
            <nav class="card">
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="cattlemanagement.php">Cattle Management</a></li>
                    <li><a href="Chart.php">Charts & Reports</a></li>
                    <li><a href="medicineplan.php">Medicine Plan</a></li>
                    <li><a href="logout.php">Log out</a></li>
                </ul>
            </nav>
        </div>
    </div>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>

</html>