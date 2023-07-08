<?php
require('conn.php');

// Handle AJAX requests
if (isset($_GET["action"]) && !empty($_GET["action"])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'getCattleProfiles':
            getCattleProfiles();
            break;
        // case 'getChartsReports':
        //     $chartsReports = generateChartsReports();
        //     echo json_encode($chartsReports);
        //     break;
        case 'addCattle':
            $result = addCattle();
            echo json_encode($result);
            break;
        case 'updateCattle':
            $result = updateCattle();
            echo json_encode($result);
            break;
        case 'deleteCattle':
            $result = deleteCattle();
            echo json_encode($result);
            break;
    }
}

function getCattleProfiles()
{
    global $conn;

    $sql = "SELECT * FROM cattle";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $cattleProfiles = array();
        while ($row = $result->fetch_assoc()) {
            $cattleProfiles[] = $row;
        }
        echo json_encode(array('status' => 'success', 'data' => $cattleProfiles));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'No cattle profiles found!'));
    }
}

function addCattle()
{
    global $conn;

    $name = $_GET['name'];
    $gender = $_GET['gender'];
    $breed = $_GET['breed'];
    $group = $_GET['group'];
    $weight = $_GET['weight'];
    $milkProduction = $_GET['milkProduction'];
    $diet = $_GET['diet'];
    $temperature = $_GET['temperature'];
    $medicalHistory = $_GET['medicalHistory'];
    $price = $_GET['price'];

    $sql = "INSERT INTO `cattle` (`name`, `gender`, `breed`, `group`, `weight`, `milkProduction`, `diet`, `temperature`, `medicalHistory`, `price`) VALUES ('$name', '$gender', '$breed', '$group', '$weight', '$milkProduction', '$diet', '$temperature', '$medicalHistory', '$price')";

    if ($conn->query($sql) === TRUE) {
        return array('status' => 'success', 'message' => 'Cattle record added successfully!');
    } else {
        return array('status' => 'error', 'message' => 'Error adding cattle record: ' . $conn->error);
    }
    $conn->close();
}

function updateCattle()
{
    global $conn;

    $cattleId = $_GET['cattleID'];
    $name = $_GET['name'];
    $gender = $_GET['gender'];
    $breed = $_GET['breed'];
    $group = $_GET['group'];
    $weight = $_GET['weight'];
    $milkProduction = $_GET['milkProduction'];
    $diet = $_GET['diet'];
    $temperature = $_GET['temperature'];
    $medicalHistory = $_GET['medicalHistory'];
    $price = $_GET['price'];

    $sql = "UPDATE `cattle` SET `name`='$name',`gender`='$gender',`breed`='$breed',`group`='$group',`weight`='$weight',`milkProduction`='$milkProduction',`diet`='$diet',`temperature`='$temperature',`medicalHistory`='$medicalHistory',`price`='$price' WHERE `id` = $cattleId";

    if ($conn->query($sql) === TRUE) {
        return array('status' => 'success', 'message' => 'Cattle record updated successfully!');
    } else {
        return array('status' => 'error', 'message' => 'Error updating cattle record: ' . $conn->error);
    }

    $conn->close();
}

function deleteCattle()
{
    global $conn;
    // $cattleId = $_GET['cattleId'];

    $sql = "DELETE FROM cattle WHERE id ='" . $_GET["cattleId"] . "'";

    if ($conn->query($sql) === TRUE) {
        return array('status' => 'success', 'message' => 'Cattle record deleted successfully!');
    } else {
        return array('status' => 'error', 'message' => 'Error deleting cattle record: ' . $conn->error);
    }

    $conn->close();
}

?>