<?php
session_start();

if (isset($_SESSION["user"]) == false) {
    header('Location:login.php');
}
?>

<html>

<head>
    <title>My Dairy Farm | Medicine Plan</title>
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
            height: 5rem;
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

        h1,
        h2 {
            text-align: center;
            padding: 20px 0;
            color: #333;
        }

        .cattle-info {
            margin: 20px auto;
            background-color: #fff;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .cattle-info th,
        .cattle-info td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .cattle-info th {
            background-color: #f5f5f5;
        }

        .cattle-info tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .cattle-info tr:hover {
            background-color: #f2f2f2;
        }

        .suggested-medicine {
            color: #e91e63;
            font-weight: bold;
        }

        .medicine-table {
            margin: 20px auto;
            background-color: #fff;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .medicine-table th,
        .medicine-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .medicine-table th {
            background-color: #f5f5f5;
        }

        .medicine-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .medicine-table tr:hover {
            background-color: #f2f2f2;
        }

        .medicine-table .suggested-medicine {
            color: #e91e63;
            font-weight: bold;
        }

        footer {
            text-align: center;
            padding-bottom: 20px;
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="cattlemanagement.php">Cattle Management</a></li>
                <li><a href="Chart.php">Charts & Reports</a></li>
                <li><a href="medicineplan.php">Medicine Plan</a></li>
                <li><a href="logout.php">Log out</a></li>
            </ul>
        </nav>
    </header>

    <h1>Medicine Plan for ill Cows</h1>

    <table class="cattle-info">
        <thead>
            <tr>
                <th>Cow Name</th>
                <th>Temperature (°C)</th>
                <th>Suggested Medicine</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require('conn.php');

            $sql = "SELECT name, temperature FROM cattle";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $temperature = $row['temperature'];
                    $cowName = $row['name'];

                    $minTemp = 37.5;
                    $maxTemp = 39.5;

                    if ($temperature > $maxTemp) {
                        $suggestedMedicine = "Fever medication: Nonsteroidal Anti-Inflammatory Drugs";
                    } elseif ($temperature < $minTemp) {
                        $suggestedMedicine = "Increase Ambient Temperature";
                    } else {
                        $suggestedMedicine = "No medicine suggestion at this time";
                    }
                    ?>
                    <tr>
                        <td>
                            <?php echo $cowName; ?>
                        </td>
                        <td>
                            <?php echo $temperature; ?>°C
                        </td>
                        <td class="suggested-medicine">
                            <?php echo $suggestedMedicine; ?>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='3'>No cattle data found!</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <h2>Suggested Medicines for Ill Cows</h2>

    <table class="medicine-table">
        <thead>
            <tr>
                <th>Medicine Name</th>
                <th>Dosage</th>
                <th>Suggested for</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Pain Relief</td>
                <td>10 ml per 100 kg of body weight</td>
                <td>Cows with pain or discomfort</td>
            </tr>
            <tr>
                <td>Antibiotic A</td>
                <td>5 ml per 100 kg of body weight, twice a day</td>
                <td>Bacterial infections</td>
            </tr>
            <tr>
                <td>Fever Medication</td>
                <td>15 ml per 100 kg of body weight</td>
                <td>Cows with high temperature</td>
            </tr>
        </tbody>
    </table>
    <div>
        <center><span>More medication suggestions are coming soon... | So stay tuned! &#128515;</span></center>
    </div><br><br>

    <footer>
        &copy; Copyrights 2023. All rights reserved | <a href="login.php">MyDairyFarm</a>
    </footer>
</body>

</html>