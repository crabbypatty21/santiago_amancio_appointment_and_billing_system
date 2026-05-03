<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Payment Container</title>
    <style>
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
            width: 650px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            background-color: #ffffff;
        }

        .header {
            background-color: #00abf0;
            padding: 15px;
            display: flex;
            align-items: center;
        }

        .header img {
            width: 60px;
            height: auto;
            margin-right: 15px;
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

        .total-amount {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
            padding: 0 20px;
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
            padding-right: 20px;
            padding-bottom: 20px;
        }

        .submit-button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            height: 40px;
            width: 150px;
            margin-left: 10px;
            background-color:  #007bff;
            color: white;
            transition: background-color 0.3s, transform 0.2s;
        }

        .submit-button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        /* QR Code Style */
        .qr-code {
            margin: 20px 0;
            text-align: center;
        }

        /* Attachment Section */
        .attachment-section {
            margin: 20px;
            text-align: center;
        }

        .attachment-section p {
            font-size: 16px;
            margin-bottom: 10px;
            color: #333;
        }

        .attachment-section input {
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 90%;
            transition: border-color 0.3s;
        }

        .attachment-section input:hover {
            border-color: #007bff;
        }

        .attachment-section input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .confirmation-message {
            display: none; /* Initially hidden */
            text-align: center;
            font-size: 18px;
            color: #333;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="payment-container">
        <div class="header">
            <img src="pictures/log.png" alt="Clinic Logo">
            <div>
                <div class="header-title">Santiago-Amancio Dental Clinic</div>
                <div class="address">0447 Santiago Road St. Lambakin, Marilao Bulacan</div>
            </div>
        </div>
        
        <!-- QR Code Section -->
        <div class="qr-code">
            <img src="pictures/qr.png" alt="QR Code" style="max-width: 100%; height: auto;">
            <p>Scan this QR code to complete your payment.</p>
        </div>

        <!-- Attachment Section -->
        <div class="attachment-section">
            <p>Pleaseattach your file:</p>
            <input type="file" id="file-input">
        </div>

        <!-- Confirmation Message -->
        <div class="confirmation-message" id="confirmation-message">
            Waiting for Admin Confirmation...
        </div>

        <!-- Button Container -->
        <div class="button-container">
            <button class="submit-button" id="pay-button">Next</button>
        </div>
    </div>

    <script>
        document.getElementById('pay-button').addEventListener('click', function() {
            document.getElementById('confirmation-message').style.display = 'block';
        });
    </script>
</body>
</html>