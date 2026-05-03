<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: lightblue;
            display: flex; /* Use flexbox for centering */
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            height: 100vh; /* Full viewport height */
        }

        .receipt-container {
            width: 600px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            color: #007bff;
        }

        .header p {
            margin: 5px 0;
            font-size: 14px;
        }

        .customer-details, .items, .total {
            margin-bottom: 20px;
        }

        .customer-details h2, .items h2, .total h2 {
            font-size: 18px;
            color: #333;
        }

        .items table {
            width: 100%;
            border-collapse: collapse;
        }

        .items th, .items td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        .items th {
            background-color: #f1f1f1;
        }

        .total {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 20px;
        }

        .back-button {
            display: block;
            width: 150px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="receipt-container">
        <div class="header">
            <h1>Payment Receipt</h1>
            <p>Santiago-Amancio Dental Clinic</p>
            <p>0447 Santiago Road St. Lambakin, Marilao Bulacan</p>
            <p>Date: <?php echo date('l, F j, Y'); ?></p>
        </div>

        <div class="customer-details">
            <h2>Customer Details</h2>
            <p>Name: John Doe</p>
            <p>Email: johndoe@example.com</p>
            <p>Phone: (123) 456-7890</p>
        </div>

        <div class="items">
            <h2>Items Purchased</h2>
            <table>
                <tr>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
                <tr>
                    <td>Dental Checkup</td>
                    <td>1</td>
                    <td>$50.00</td>
                </tr>
                <tr>
                    <td>Teeth Cleaning</td>
                    <td>1</td>
                    <td>$30.00</td>
                </tr>
                <tr>
                    <td>Fluoride Treatment</td>
                    <td>1</td>
                    <td>$20.00</td>
                </tr>
            </table>
        </div>

        <div class="total">
            <h2>Total Amount: $100.00</h2>
        </div>

        <div class="footer">
            <p>Thank you for your payment!</p>
            <p>For any inquiries, please contact us at (123) 456-7890</p>
        </div>

        <!-- Back to Home Button -->
        <a href="index.php" class="back-button">Back to Home</a>
    </div>

</body>
</html>