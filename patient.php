<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Clinic Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background-color: #00abf0;
            color: #ecf0f1;
            padding-top: 20px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar a {
            display: block;
            padding: 15px 20px;
            color: #ecf0f1;
            text-decoration: none;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background-color: #0056b3;
        }

        .sidebar a.active {
            background-color: #007bff;
            color: white;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            position: relative;
        }

        .search-container {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 50px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            padding: 10px 20px;
        }

        .search-input {
            padding: 15px 20px;
            font-size: 18px;
            border: none;
            border-radius: 50px;
            width: 350px;
            outline: none;
            background-color: #e7f1ff;
            color: #333;
            transition: background-color 0.3s ease;
        }

        .search-input:focus {
            background-color: #d0e4ff;
        }

        .search-button {
            padding: 15px 25px;
            font-size: 18px;
            border: none;
            border-radius: 50px;
            background-color: #007BFF;
            color: white;
            cursor: pointer;
            margin-left: 10px;
            transition: background-color 0.3s ease }

        .search-button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 80px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #00abf0;
            color: white;
        }

        .appointment-row:hover {
            background-color: #f5f5f5;
        }

        .highlight {
            background-color: yellow; /* Highlight color */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                margin-left: 200px;
            }

            .search-container {
                flex-direction: column;
                align-items: stretch;
            }

            .search-input {
                width: 100%;
                margin-bottom: 10px;
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
            }

            .main-content {
                margin-left: 0;
                padding: 10px;
            }
        }
    </style>
    <script>
        function searchPatients() {
            const input = document.querySelector('.search-input').value.toLowerCase();
            const rows = document.querySelectorAll('#appointment-rows tr');
            const [field, ...valueArray] = input.split(' ');
            const value = valueArray.join(' '); // Join the remaining parts to handle multi-word values

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let match = false;

                cells.forEach(cell => {
                    const cellText = cell.textContent.toLowerCase();
                    if (cellText.includes(value) && cell.dataset.field === field) {
                        match = true;
                        // Highlight the searched value
                        const highlightedText = cellText.replace(new RegExp(value, 'gi'), (match) => `<span class="highlight">${match}</span>`);
                        cell.innerHTML = highlightedText; // Use innerHTML to insert highlighted text
                    } else {
                        // Reset cell content if it doesn't match
                        cell.innerHTML = cellText;
                    }
                });

                row.style.display = match ? '' : 'none';
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const searchButton = document.querySelector('.search-button');
            searchButton.addEventListener('click', searchPatients);
            const searchInput = document.querySelector('.search-input');
            searchInput.addEventListener('keyup', (event) => {
                if (event.key === 'Enter') {
                    searchPatients();
                }
            });
        });
    </script>
</head>
<body>
<div class="sidebar">
    <h2>Dental Admin</h2>
    <a href="dash.php" class="active"><i class="fas fa-home"></i> Dashboard</a>
    <a href="appointment.php"><i class="fas fa-calendar-check"></i> Appointments</a>
    <a href="patient.php"><i class="fas fa-users"></i> Patients</a>
    <a href="billing.php"><i class="fas fa-file-invoice"></i> Billing</a>
    <a href="service.php"><i class="fas fa-tooth"></i> Services </a>
    <a href="report.php"><i class="fas fa-chart-bar"></i> Reports</a>
    <a href="setting.php"><i class="fas fa-cog"></i> Settings</a>
    <a href="admin_login.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="main-content">
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Search (e.g., first_name John)" aria-label="Search">
        <button class="search-button" type="button">Search</button>
    </div>

    <h2>Patient Records</h2>
    <table id="appointments-table">
        <thead>
            <tr>
                <th>Patient_ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Birthdate</th>
                <th>Gender</th>
                <th>Contact No.</th>
                <th>City/Province</th>
                <th>Municipality</th>
                <th>Barangay</th>
                <th>Street</th>
                <th>House Number</th>
            </tr>
        </thead>
        <tbody id="appointment-rows">
            <?php
            // Database connection
            $conn = new mysqli('localhost', 'root', '', 'finaldb');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            // SQL query to fetch patient records
            $sql = "SELECT patient_id, first_name, last_name, date_of_birth, gender, contact_number, city_province, municipality, barangay, street, house_no FROM patient"; 
            $result = $conn->query($sql);

            // Check if there are results and output data
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr class='appointment-row'>
                            <td data-field='p'>" . $row["patient_id"] . "</td>
                            <td data-field='fn'>" . $row["first_name"] . "</td>
                            <td data-field='ln'>" . $row["last_name"] . "</td>
                            <td data-field='dob'>" . $row["date_of_birth"] . "</td>
                            <td data-field='g'>" . $row["gender"] . "</td>
                            <td data-field='cn'>" . $row["contact_number"] . "</td>
                            <td data-field='cp'>" . $row["city_province"] . "</td>
                            <td data-field='m'>" . $row["municipality"] . "</td>
                            <td data-field='b'>" . $row["barangay"] . "</td>
                            <td data-field='s'>" . $row["street"] . "</td>
                            <td data-field='hn'>" . $row["house_no"] . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='11'>No records found</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</div>
</body>
</html>