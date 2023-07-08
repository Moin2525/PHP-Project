<?php
session_start();

if (isset($_SESSION["user"]) == false) {
    header('Location:login.php');
}
?>

<html>

<head>

    <?php
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

    ?>

    <script>
        function myfunc() {
            var milk = '<?php echo $qty; ?>';
            document.getElementById("daily").innerHTML = milk;
            document.getElementById("weekly").innerHTML = milk * 7;
            document.getElementById("monthly").innerHTML = milk * 30;
            document.getElementById("yearly").innerHTML = milk * 365;
        }
    </script>

    <title>My Dairy Farm | Dashboard</title>
    <link rel="icon" type="image/x-icon" href="pinkcow.png">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
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

        .section h2 {
            margin-top: 0;
        }

        .main {
            width: 100 %;
            padding-left: 35px;
            display: flex;
            gap: 180px;
            justify-content: center;
        }

        .card {

            background-color: #FFB6C1;
            padding: 15px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card h3 {
            margin-top: 0;
        }

        h2 {
            text-align: center;
            padding: 20px 0;
            color: #333;
        }

        .overview {
            text-align: center;
            margin: 40px 0;
        }

        .overview h3 {
            color: #6a1b9a;
            font-weight: bold;
            font-size: 26px;
            margin-bottom: 20px;
        }

        .overview .main {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
        }

        .overview .card {
            background-color: #e040fb;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            border-radius: 10px;
            transition: all 0.3s ease;
            color: #fff;
        }

        .overview .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .overview .card p {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .feeding-schedule {
            text-align: center;
            margin: 40px 0;
        }

        .feeding-schedule h3 {
            color: #6a1b9a;
            font-weight: bold;
            font-size: 26px;
            margin-bottom: 20px;
        }

        .feeding-schedule .main {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 30px;
        }

        .feeding-schedule .card {
            background-color: #9c27b0;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            border-radius: 10px;
            transition: all 0.3s ease;
            color: #fff;
        }

        .feeding-schedule .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .feeding-schedule .card h4,
        .feeding-schedule .card h5 {
            font-size: 24px;
            margin-bottom: 15px;
        }

        .feeding-schedule .card p {
            font-size: 18px;
            margin-bottom: 10px;
        }
    </style>

</head>

<body onload="myfunc()">
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
            <br>

            <h2>My Dairy Farm Dashboard</h2>

            <div class="overview">
                <h3>Milking Overview</h3>
                <div class="main">
                    <div class="card">
                        <p>Daily: <span id="daily"></span> kg</p>
                    </div>
                    <div class="card">
                        <p>Weekly: <span id="weekly"></span> kg</p>
                    </div>
                    <div class="card">
                        <p>Monthly: <span id="monthly"></span> kg</p>
                    </div>
                    <div class="card">
                        <p>Yearly: <span id="yearly"></span> kg</p>
                    </div>
                </div>
            </div>

            <div class="feeding-schedule">
                <h3>Feeding Schedule</h3>
                <div class="main">
                    <div class="card">
                        <h4>Morning Diet</h4>
                        <div>
                            <p>Green Grass: 10 kg per Cow</p>
                            <p>Chokar: 1 kg per Cow</p>
                            <p>Fresh Water: 2 kg per Cow</p>
                        </div>
                    </div>
                    <div class="card">
                        <h5>Evening Diet</h5>
                        <div>
                            <p>Green Grass: 12 kg per Cow</p>
                            <p>Chokar: 1 kg per Cow</p>
                            <p>Fresh Water: 2 kg per Cow</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <center>
                <h2>My Dairy Farm Dashboard</h2>
            </center>

            <div>
                <center>
                    <h3 style="color: purple; font_weight: bold; font-size: 26px">Milking Overview</h3>
                </center>
                <div class=" main">
                    <div class="card">
                        <p
                            style="font-size:16px; color: blue; font-weight:bold; border: 10px solid silver; padding: 10px; margin: 10px; width: 140px; background-color: silver">
                            Daily : <span id="daily"></span> kg
                        </p>
                    </div>
                    <div class="card">
                        <p
                            style="font-size:16px; color: blue; font-weight:bold; border: 10px solid silver; padding: 10px; margin: 10px; width: 140px; background-color: silver">
                            Weekly: <span id="weekly"></span> kg
                        </p>
                    </div>
                </div>

                <br><br><br><br>
                <div class="main">
                    <div class="card">
                        <p
                            style="font-size:16px; color: blue; font-weight:bold; border: 10px solid silver; padding: 10px; margin: 10px; width: 140px; background-color: silver">
                            Monthly: <span id="monthly"></span> kg
                        </p>
                    </div>
                    <div class="card">
                        <p
                            style="font-size:16px; color: blue; font-weight:bold; border: 10px solid silver; padding: 10px; margin: 10px; width: 140px; background-color: silver">
                            Yearly: <span id="yearly"></span> kg
                        </p>
                    </div>
                </div>

                <div>
                    <center>
                        <h3 style="color: purple; font_weight: bold; font-size: 26px">Feeding Schedule</h3>
                    </center>

                    <div class="main">
                        <div class="card">

                            <h4 style="font-size:22px; font-weight: bold; margin: 10px; color: purple"> Morning
                                Diet&nbsp;&nbsp; </h4>
                            <br>
                            <div>

                                <p
                                    style="background-color: white; color: blue; font-weight:bold; border: 10px solid silver; padding: 10px; margin: 10px; width: 220px; background-color: silver">
                                    Green Grass : 10 kg per Cow
                                </p>
                                <br><br>
                                <p
                                    style="background-color: white; color: blue ;font-weight:bold; border: 10px solid silver; padding: 10px; margin: 10px; width: 220px; background-color: silver">
                                    Chokar: 1 kg per cow
                                </p>
                                <br><br>
                                <p
                                    style="background-color: white; color: blue;font-weight:bold; border: 10px solid silver; padding: 10px; margin: 10px; width: 220px; background-color: silver">
                                    Fresh Water: 2 kg per Cow
                                </p>
                            </div>
                        </div>

                        <div class="card">
                            <h5 style="font-size:22px; font-weight: bold; margin: 10px; color: purple"> Evening Diet
                            </h5>
                            <br>
                            <div>
                                <p
                                    style="background-color: white; color: blue ;font-weight:bold; border: 10px solid silver; padding: 10px; margin: 10px; width: 220px; background-color: silver">
                                    Green Grass : 12 kg per Cow
                                </p>
                                <br><br>
                                <p
                                    style="background-color: white; color: blue;font-weight:bold; border: 10px solid silver; padding: 10px; margin: 10px; width: 220px; background-color: silver">
                                    Chokar: 1 kg per cow
                                </p>
                                <br><br>
                                <p
                                    style="background-color: white;color: blue; font-weight:bold; border: 10px solid silver; padding: 10px; margin: 10px; width: 220px; background-color: silver">
                                    Fresh Water: 2 kg per Cow
                                </p>
                            </div>
                        </div>
                    </div>
                </div> -->

</body>

</html>