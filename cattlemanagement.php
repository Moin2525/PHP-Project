<?php
	session_start();

	if(isset($_SESSION["user"])==false)
	{
		header('Location:login.php');
	}
?>

<html>

<head>
    <title>My Dairy Farm | Cattle</title>
    <link rel="icon" type="image/x-icon" href="pinkcow.png">
    <style>
        * {
            font-family: Arial, sans-serif;
        }

        #cattleTable {
            width: 100%;
            border-collapse: collapse;
        }

        #cattleTable th,
        #cattleTable td {
            padding: 8px;
            text-align: left;
            border-bottom: 2px solid #787878;
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

        button {
            height: 2.5rem;
            width: 6rem;
            font-weight: bold;
            background-image: linear-gradient(225deg, #E3FDF5 50%, #FFE6FA 50%);
            border-radius: 1rem;
            font-size: large;
        }

        button:hover {
            transform: translatey(3px);
            box-shadow: none;
        }

        button:hover {
            animation: ani9 0.4s ease-in-out infinite alternate;
        }

        @keyframes ani9 {
            0% {
                transform: translateY(3px);
            }

            100% {
                transform: translateY(4px);
            }
        }

        form {
            display: flex;
            justify-content: center;
            padding: 1rem;
            font-size: large;
            background-color: #E3FDF5;
        }

        form div {
            margin: 1rem;
            text-align: right;
        }

        select {
            margin-right: 16rem;
            padding: 0.5rem;
        }

        input {
            border: 2px solid black;
            border-radius: 5px;
            margin: 0.9rem;
            width: 320px;
            height: 25px;
        }

        footer {
            text-align: center;
            padding-bottom: 20px;
        }
    </style>
    <script src="jquery.js"></script>
    <script>
        $(document).ready(function () {
            $('#addCattleForm').submit(function (event) {
                event.preventDefault();
                var formMode = $('#formMode').val();
                var formData = {
                    cattleID: $('#cattleId').val(),
                    name: $('#name').val(),
                    gender: $('#gender').val(),
                    breed: $('#breed').val(),
                    group: $('#group').val(),
                    weight: $('#weight').val(),
                    milkProduction: $('#milkProduction').val(),
                    diet: $('#diet').val(),
                    temperature: $('#temperature').val(),
                    medicalHistory: $('#medicalHistory').val(),
                    price: $('#price').val()
                };

                if (formMode === 'add') {
                    addCattle(formData);
                } else if (formMode === 'edit') {
                    updateCattle(formData);
                }

                resetForm();
            });

            function addCattle(formData) {
                console.log(formData);
                $.ajax({
                    method: 'GET',
                    url: 'backend.php',
                    data: {
                        action: 'addCattle',
                        name: formData.name,
                        gender: formData.gender,
                        breed: formData.breed,
                        group: formData.group,
                        weight: formData.weight,
                        milkProduction: formData.milkProduction,
                        diet: formData.diet,
                        temperature: formData.temperature,
                        medicalHistory: formData.medicalHistory,
                        price: formData.price
                    },
                    dataType: 'json',
                    success: function (response) {
                        loadCattleTable('getCattleProfiles');
                        alert('Record added successfully!');
                    },
                    error: function (response) {
                        alert('Error while adding!');
                        console.log(response);
                    }
                });
            }

            function updateCattle(formData) {
                console.log(formData.cattleID);
                $.ajax({
                    type: 'GET',
                    url: 'backend.php',
                    data: {
                        action: 'updateCattle',
                        cattleID: formData.cattleID,
                        name: formData.name,
                        gender: formData.gender,
                        breed: formData.breed,
                        group: formData.group,
                        weight: formData.weight,
                        milkProduction: formData.milkProduction,
                        diet: formData.diet,
                        temperature: formData.temperature,
                        medicalHistory: formData.medicalHistory,
                        price: formData.price
                    },
                    dataType: 'json',
                    success: function (response) {
                        loadCattleTable('getCattleProfiles');
                        alert('Record updated successfully!');
                    },
                    error: function (response) {
                        alert('Error while updating!');
                        console.log(response);
                    }
                });
            }

            function deleteCattle(cattleId) {
                $.ajax({
                    type: 'GET',
                    url: 'backend.php',
                    data: {
                        action: 'deleteCattle',
                        cattleId: cattleId
                    },
                    dataType: 'json',
                    success: function (response) {
                        loadCattleTable('getCattleProfiles');
                    },
                    error: function (response) {
                        alert('Error while deleting!');
                        // error_log();
                        console.log(response);
                    }
                });
            }

            function loadCattleTable(action) {
                $.ajax({
                    method: 'GET',
                    url: 'backend.php',
                    data: {
                        action: action
                    },
                    success: function (response) {
                        var cattleRecords = JSON.parse(response);
                        console.log(cattleRecords);
                        var tableBody = $('#cattleTableBody');
                        tableBody.empty();

                        $.each(cattleRecords.data, function (index, record) {
                            var row = $('<tr>');
                            row.append($('<td>').text(record.id));
                            row.append($('<td>').text(record.name));
                            row.append($('<td>').text(record.gender));
                            row.append($('<td>').text(record.breed));
                            row.append($('<td>').text(record.group));
                            row.append($('<td>').text(record.weight));
                            row.append($('<td>').text(record.milkProduction));
                            row.append($('<td>').text(record.diet));
                            row.append($('<td>').text(record.temperature));
                            row.append($('<td>').text(record.medicalHistory));
                            row.append($('<td>').text(record.price));

                            // Add edit and delete buttons to each row
                            var actions = $('<td>');
                            var editButton = $('<button>').text('Edit');
                            editButton.click(function () {
                                editCattle(record);
                            });
                            var deleteButton = $('<button>').text('Delete');
                            deleteButton.click(function () {
                                deleteCattle(record.id);
                            });
                            actions.append(editButton);
                            actions.append(deleteButton);
                            row.append(actions);

                            tableBody.append(row);
                        });
                    },
                    error: function () {
                        alert('Error loading cattle records!');
                    }
                });
            }

            function editCattle(record) {
                console.log(record.id);
                $('#formMode').val('edit');
                $('#cattleId').val(record.id);
                $('#name').val(record.name);
                $('#gender').val(record.gender);
                $('#breed').val(record.breed);
                $('#group').val(record.group);
                $('#weight').val(record.weight);
                $('#milkProduction').val(record.milkProduction);
                $('#diet').val(record.diet);
                $('#temperature').val(record.temperature);
                $('#medicalHistory').val(record.medicalHistory);
                $('#price').val(record.price);
            }

            function resetForm() {
                $('#formMode').val('add');
                $('#cattleId').val('');
                $('#addCattleForm')[0].reset();
            }

            // Load the cattle table on page load
            loadCattleTable('getCattleProfiles');
        });
    </script>
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

    <div>
        <div id="content">
            <!-- Content will be dynamically loaded here -->

            <form id="addCattleForm">
                <div>
                    <input type="hidden" id="formMode" value="add">
                    <input type="hidden" id="cattleId">

                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required><br>

                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select><br>

                    <label for="breed">Breed:</label>
                    <input type="text" id="breed" name="breed" required><br>

                    <label for="group">Group:</label>
                    <input type="text" id="group" name="group" required><br>

                    <label for="weight">Weight:</label>
                    <input type="number" id="weight" name="weight" required><br>
                </div>

                <div>
                    <label for="milkProduction">Milk Production:</label>
                    <input type="number" id="milkProduction" name="milkProduction" required><br>

                    <label for="diet">Diet:</label>
                    <input type="text" id="diet" name="diet" required><br>

                    <label for="temperature">Temperature(°C):</label>
                    <input type="number" id="temperature" name="temperature" required><br>

                    <label for="medicalHistory">Medical History:</label>
                    <input type="text" id="medicalHistory" name="medicalHistory" required><br>

                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price" required><br>

                    <button type="submit">Add</button>
                </div>
            </form>
            <br>
            <center>
                <h2>Added Cows Record</h2>
            </center>
            <hr>
            <table id="cattleTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Breed</th>
                        <th>Group</th>
                        <th>Weight</th>
                        <th>Milk Production</th>
                        <th>Diet</th>
                        <th>Temperature</th>
                        <th>Medical History</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="cattleTableBody">
                    <!-- Cattle records will be dynamically added here -->
                </tbody>
            </table>
        </div>
    </div><br><br>

    <footer>
        &copy; Copyrights 2023. All rights reserved | <a href="login.php">MyDairyFarm</a>
    </footer>

</body>

</html>