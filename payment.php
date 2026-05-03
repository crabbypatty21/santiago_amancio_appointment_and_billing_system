<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'finaldb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Fetch the stored data from session
$service_cost = $_SESSION['service_cost'] ?? 0;
$service_name = $_SESSION['service_name'] ?? '';
$appointment_day = $_SESSION['appointment_day'] ?? '';
$start_time = $_SESSION['start_time'] ?? '';
$end_time = $_SESSION['end_time'] ?? '';

// Calculate down payment (20% of service cost)
$down_payment = $service_cost * 0.20;

// Clear session variables after use
unset($_SESSION['service_cost'],$_SESSION['service_name'], $_SESSION['appointment_day'], $_SESSION['start_time'], $_SESSION['end_time']);

// Fetch user email and patient details
$stmt = $conn->prepare(
    "SELECT u.email, p.first_name, p.last_name,p.contact_number, 
            p.city_province, p.municipality, p.barangay, p.street, p.house_no
     FROM user u
     INNER JOIN patient p ON u.user_id = p.user_id
     WHERE u.user_id = ?"
);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($email, $first_name, $last_name,$contact_number, $city_province, $municipality, $barangay, $street, $house_no);
$stmt->fetch();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointment_id = $_POST['appointment_id'] ?? null;
    $total_amount = $_POST['service_cost'] ?? null;
    $downpayment = $_POST['downpayment'] ?? null;
    $payment_date = date('Y-m-d H:i:s'); // Current timestamp


    // Validate required fields
    if ($appointment_id && $service_cost && $down_payment && $payment_date) {
        // Insert the appointment into the database
        $stmt = $conn->prepare("
            INSERT INTO payment
            (appointment_id, total_amount, downpayment, payment_date)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param("isss", $appointment_id, $tot, $down_payment, $payment_date);


        if ($stmt->execute()) {
            $success_message = "payment successful!";
            header("Location: conpay.php");
        }
    }
}

// Close the statement and connection
$stmt->close();

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Payment Container</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

</head>
<body>

    <div class="payment-container">
        <div class="header">
            <img src="pictures/log.png" alt="Clinic Logo">
            <div>
 <div class="header-title">Santiago-Amancio Dental Clinic</div>
                <div class="address">0447 Santiago road St. Lambakin, Marilao Bulacan</div>
            </div>
        </div>
        
        <div class="content">
            <div>
                <span class="patient-name-label" disabled>First name: </span>
                <span id="display-patient-name" class="patient-info-value"><?php echo "$first_name"; ?></span>
            </div>
            <div>
                <span class="patient-name-label">Last Name:</span>
                <span id="display-patient-name" class="patient-info-value"><?php echo "$last_name"; ?></span>
            </div>

            <div>
                <span class="patient-name-label">Address:</span>
                <span id="display-patient-name" class="patient-info-value"><?php echo "$city_province, $municipality, $barangay, $street, $house_no"; ?></span>
            </div>

            <div>
                <span class="patient-info-label">Appointment Day:</span>
                <input type="text" class="form-control" id="appointment_day" name="appointment_day" value="<?= $appointment_day ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="start_time" class="form-label">Start Time</label>
                <input type="text" class="form-control" id="start_time" name="start_time" value="<?= $start_time ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="end_time" class="form-label">End Time</label>
                <input type="text" class="form-control" id="end_time" name="end_time" value="<?= $end_time ?>" readonly>
            </div>

            <div>
                <span class="patient-info-label">Requested Service:</span>
                <input id="service_name" class="form-control" value="₱<?= $service_name ?>" readonly>
            </div>
            <div class="total-amount">
            <span class="payment-label">Total Amount</span>
            <input type="text" class="form-control" id="service_cost" name="service_cost" value="₱<?= number_format($service_cost, 2) ?>" readonly>
            </div>
            <div class="total-amount">
            <span class="payment-label">Downpayment: <php value="₱<?= number_format($down_payment, 2) ?>" readonly ?></span>
            <input type="text" class="form-control" id="down_payment" name="down_payment" value="₱<?= number_format($down_payment, 2) ?>" readonly>
            </div>
            <span>Payment Date</span>
            <input type="text" id="dateField" name="payment_date" disabled>

            <div>
                <span class="payment-label">Payment Method:</span>
                <select id="payment-select">
                    <option value="gcash">GCash</option>
                </select>
            </div>
            
            
            <button class="submit-button" id="pay-button" onclick="redirectToPayment()">Pay</button>
            <button class="back-button" onclick="goBack()">Back</button>
            <div id="loading-message" class="loading">Processing your payment, please wait...</div>

            <script>
                function redirectToPayment() {
                    document.getElementById('loading-message').style.display = 'block'; // Show loading message
                    setTimeout(function() {
                        window.location.href = 'conpay.php'; // Redirects to confay.php after 3 seconds
                    }, 3000);
                }

                function goBack() {
                    window.location.href = 'form.php'; // Redirects to form.php
                }
        function displayCurrentDate() {
            const dateField = document.getElementById('dateField');
            const currentDate = new Date();
            const formattedDate = currentDate.toLocaleDateString(); // Format the date as needed
            dateField.value = formattedDate; // Set the value of the text field
        }

        window.onload = displayCurrentDate; // Call the function when the page loads
            </script>
        </div>
        </form>
    </div>

    <style>
         /* Include the updated CSS here */
         body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: lightblue;
        }

        .payment-container {
            width: 600px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin: 10px;
            display: flex;
            flex-direction: column;
            background: rgba(255, 255, 255, 0.9); /* Semi-transparent white background for the container */
        }

        .header {
            background-color: #00abf0;
            padding: 15px;
            display: flex;
            align-items: center;
        }

        .header img {
            width: 50px;
            height: auto;
            margin-right: 10px;
        }

        .header-title {
            font-family: 'Times New Roman', Times, serif;
            color: #0056b3;
            font-size: 24px;
            font-weight: bolder;
            margin: 0;
        }

        .address {
            font-size: 12px;
            color: #ffffff;
            margin-left: 10px;
        }

        .content {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .patient-name-label, .patient-info-label, .payment-label {
            font-weight: bold;
            font-size: 16px;
            color: #333;
            margin-top: 10px;
        }

        .patient-info-value {
            font-size: 16px;
            color: #0056b3;
            margin-left: 5px;
        }

        .total-amount {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .submit-button, .back-button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        .submit-button {
            background-color: #007bff;
            color: white;
        }

        .submit-button:hover {
            background-color: #0056b3;
        }

        .back-button {
            background-color: #6c757d;
            color: white;
        }

        .back-button:hover {
            background-color: #5a6268;
        }

        /* Loading message styles */
        .loading {
            display: none;
            text-align: center;
            font-size: 18px;
            color: #007bff;
            margin-top: 20px;
        }
    </style>
</body>
</html>