<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection using Environment Variables with local XAMPP fallbacks
    $host = getenv('DB_HOST') ?: 'localhost';
    $user = getenv('DB_USER') ?: 'root';
    $pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';
    $db   = getenv('DB_NAME') ?: 'finaldb';

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Collect form data
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $contact_number = $_POST['contact_number'];
    $city_province = $_POST['city_province'];
    $municipality = $_POST['municipality'];
    $barangay = $_POST['barangay'];
    $street = $_POST['street'];
    $house_no = $_POST['house_no'];

    // Insert into user table
    $stmt = $conn->prepare("INSERT INTO user (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $password);

    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;
        
        // Insert into patient table
        $stmt = $conn->prepare(
            "INSERT INTO patient (user_id, first_name, last_name, date_of_birth, gender, contact_number, city_province, municipality, barangay, street, house_no) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "issssssssss",
            $user_id, $first_name, $last_name, $date_of_birth, $gender, $contact_number, 
            $city_province, $municipality, $barangay, $street, $house_no
        );

        if ($stmt->execute()) {
            echo "Sign-up successful!";
            header("Location: login.php");
            exit; // Added exit to ensure the script stops executing after redirect
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Santiago-Amancio Dental Clinic - Sign Up</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
</head>
<body>
    <div class="header">
        <div class="header-title">
            <div class="title-line1">SANTIAGO-AMANCIO</div>
            <div class="title-line2">DENTAL CLINIC</div>
        </div>
        <div class="nav-links">
            <a href="login.php">LOG IN</a>
        </div>
    </div>

    <div class="signup-container">

    
        <br><br><br><br><br><br>
        <h3>
            <img src="pictures/tooth.png" alt="Tooth Icon" class="tooth-icon">
            SIGN UP  
        </h3>
        <form autocomplete="off" action="signup.php" method="POST">

     <div class="container">
         <!-- Email -->
    <div class="form-group mb-3">
        <input type="email" class="form-control" name="email" placeholder="Email">
    </div>

    <!-- Password and Confirm Password -->
    <div class="row mb-3">
        <div class="col-md-6">
            <input type="password" class="form-control" name="password" placeholder="Password">
        </div>
    </div>

    <!-- Name Fields -->
    <div class="row mb-3">
        <div class="col-md-6">
            <input type="text" class="form-control" name="first_name" placeholder="First Name">
        </div>
        <div class="col-md-6">
            <input type="text" class="form-control" name="last_name" placeholder="Last Name">
        </div>
    </div>

 <!-- Birthdate -->
<div class="form-group mb-3">
    <div class="form-floating">
        <!-- Using text input here for the floating label effect -->
        <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" placeholder="DD/MM/YY" onfocus="(this.type='date')" onblur="(this.type='text')" />
        <label for="date_of_birth">Birthdate</label>
    </div>
</div>



    <!-- Gender -->
    <div class="form-group mb-3">
        <select id="gender" name="gender" class="form-select" required>
            <option value="" selected disabled>Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
    </div>

    <!-- Contact Number -->
    <div class="form-group mb-3">
        <input type="text" class="form-control" name="contact_number" placeholder="Contact Number">
    </div>

    <!-- Address Dropdowns -->
<div class="form-group mb-3">
    <div class="form-floating">
        <select id="city_province" name="city_province" class="form-select" required>
            <option value="" selected disabled>Select Province</option>
            <option value="Bulacan">Bulacan</option> <!-- Only Bulacan -->
        </select>
        <label for="city_province">Address</label>
    </div>
</div>


    <!-- Municipality and Barangay Dropdowns -->
    <div class="row mb-3">
        <div class="col-md-6">
            <select id="municipality" name="municipality" class="form-select">
                <option value="" selected disabled>Select Municipality</option>
            </select>
        </div>
        <div class="col-md-6">
            <select id="barangay" name="barangay" class="form-select">
                <option value="" selected disabled>Select Barangay</option>
            </select>
        </div>
    </div>

    <!-- Street and House Number -->
    <div class="row mb-3">
        <div class="col-md-6">
            <input type="text" class="form-control" name="street" placeholder="Street">
        </div>
        <div class="col-md-6">
            <input type="text" class="form-control" name="house_no" placeholder="House Number">
        </div>
    </div>

    </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>
    </div>

    <script>
    // Define the data for municipalities and barangays under Bulacan
    const data = {
        "Bulacan": {
            "Angat": ["Banaban", "Baybay", "Binagbag", "Donacion", "Encanto", "Laog", "Marungko", "Niugan", "Paltok", "Pulong Yantok", "San Roque", "Santa Cruz", "Sulucan"],
            "Balagtas": ["Borol 1st", "Borol 2nd", "Dalig", "Longos", "Panginay", "Pulong Gubat", "San Juan", "Santol", "Wawa"],
            "Baliuag": ["Bagong Nayon", "Barangca", "Calantipay", "Catulinan", "Concepcion", "Hinukay", "Makinabang", "Matangtubig", "Pagala", "Paitan", "Poblacion", "Sabang", "San Jose", "Santa Barbara", "Santa Lucia", "Santo Cristo", "Santo Niño", "Subic", "Sulivan", "Tangos", "Tiaong", "Tilapayong", "Virgen Delas Flores"],
            "Bocaue": ["Antipona", "Bagumbayan", "Bambang", "Biñang 1st", "Biñang 2nd", "Bunlo", "Caingin", "Duhat", "Igulot", "Lolomboy", "Poblacion", "Sulucan", "Turo", "Wakas"],
            "Bulakan": ["Bagumbayan", "Balubad", "Matungao", "Maysantol", "Perez", "San Francisco", "San Jose", "San Nicolas", "Santa Ana", "Taliptip"],
            "Bustos": ["Bonga Menor", "Bonga Mayor", "Cambaog", "Catacte", "Liciada", "Mabini", "Malamig", "Malawa", "Poblacion", "San Pedro", "Talon", "Tanawan"],
            "Calumpit": ["Balungao", "Buguion", "Calizon", "Corazon", "Gugo", "Iba O'Este", "Iba O'Este II", "Longos", "Meyto", "Palimbang", "Pio Cruzcosa", "Poblacion", "San Jose", "Santa Lucia", "Sapang Bayan", "Santo Niño", "Santo Rosario", "Sucol"],
            "Doña Remedios Trinidad": ["Bakal", "Bayabas", "Camachin", "Camachile", "Kalawakan", "Kabayunan", "Pulong Sampaloc", "Talbak"],
            "Guiguinto": ["Barangay Cutcut", "Daungan", "Ilang-Ilang", "Malis", "Panducot", "Panginay", "Poblacion", "Pritil", "Santa Cruz", "Santa Rita", "Tabang", "Tiaong", "Tuktukan"],
            "Hagonoy": ["Abulalas", "Iba", "Ilang-Ilang", "Masantol", "Palapat", "Pugad", "San Agustin", "San Isidro", "San Jose", "San Juan", "San Miguel", "San Nicolas", "San Pablo", "San Pedro", "San Roque", "Santa Cruz", "Santa Elena", "Santa Monica", "Santo Niño", "Sapang Bayan", "Sapang Palay", "Tampok"],
            "Marilao": ["Abangan Norte", "Abangan Sur", "Ibayo", "Lambakin", "Lias", "Nagbalon", "Patubig", "Poblacion I", "Poblacion II", "Prenza I", "Prenza II", "Santa Rosa I", "Santa Rosa II", "Saog", "Tabing Ilog"],
            "Tuguegarao City": ["Barangay 1", "Barangay 2", "Barangay 3"],
            "Norzagaray": ["Bangkal", "Baraka", "Bigte", "Bitungol", "Matictic", "Minuyan", "Partida", "Pinagtulayan", "Poblacion", "San Lorenzo", "San Mateo", "Tigbe"],
            "Obando": ["Binuangan", "Hulo", "Lawa", "Pag-asa", "Paliwas", "Poblacion", "Salambao", "Tawiran"],
            "Pandi": ["Bagbaguin", "Bunsuran", "Cacarong Matanda", "Cacarong Bata", "Cupang", "Malibay", "Manatal", "Mapulang Lupa", "Masuso", "Poblacion", "San Roque", "Santa Ana", "Santa Rita"],
            "Paombong": ["Binakod", "Kapitangan", "Malumot", "Masukol", "Pinalagdan", "Poblacion", "San Isidro I", "San Isidro II", "San Jose", "San Roque", "Santa Cruz", "Santo Niño"],
            "Plaridel": ["Aglibut", "Bagong Silang", "Banga", "Bintog", "Bulihan", "Caniogan", "Lumang Bayan", "Parulan", "Poblacion", "Santo Niño", "Santo Rosario", "Sipat", "Tabang"],
            "Pulilan": ["Balatong A", "Balatong B", "Dampol", "Inaon", "Lumbac", "Longos", "Paltao", "Penabatan", "Poblacion", "Santa Peregrina", "Sto. Cristo", "Tabon", "Taal", "Tibag"],
            "San Ildefonso": ["Alagao", "Bancal", "Basuit", "Bubulong Malaki", "Bubulong Munti", "Cabo", "Calasag", "Maasim", "Makapilapil", "Palapala", "Poblacion", "Pulong Tamo", "Sapang Dayap", "Sapang Putik", "Santa Catalina", "Sumandig", "Upig"],
            "San Miguel": ["Bardagol", "Baritan", "Bilog", "Buliran", "Calumpang", "Cambasi", "Ilog Bulo", "Lambakin", "Mahalong", "Manggahan", "Matimbubong", "Pacalag", "Paliwasan", "Pinambaran", "Poblacion", "Salacot", "San Agustin", "San Juan", "San Vicente", "Santa Ines", "Sapang Bayan", "Sapang Palay", "Sibul"],
            "San Rafael": ["Banca-Banca", "Caingin", "Capihan", "Coral na Bato", "Cruz na Daan", "Dagat-Dagatan", "Diliman I", "Diliman II", "Libis", "Maguinao", "Maronguillo", "Pasong Bangkal", "Pasong Callos", "Poblacion", "Pulong Bayabas", "Sampaloc", "San Agustin", "San Roque", "Sapang Putol", "Talacsan", "Tukod"],
            "Santa Maria": ["Bagbaguin", "Balasing", "Buenavista", "Bulac", "Camangyanan", "Catmon", "Cay Pombo", "Caysio", "Guyong", "Lalakhan", "Mag-asawang Sapa", "Mahabang Parang", "Manggahan", "Parada", "Poblacion", "Pulong Buhangin", "San Gabriel", "San Jose Patag", "Santa Clara", "Santa Cruz", "Silangan", "Tabing Bakod", "Tumana"]
        }
    };

    // Get the dropdown elements
    const provinceDropdown = document.getElementById("city_province");
    const municipalityDropdown = document.getElementById("municipality");
    const barangayDropdown = document.getElementById("barangay");

    // Function to populate the municipality dropdown
    function populateMunicipality() {
        const province = provinceDropdown.value;
        if (province && data[province]) {
            const municipalities = Object.keys(data[province]);
            municipalityDropdown.innerHTML = '<option value="" selected disabled>Select Municipality</option>'; // Reset municipality dropdown
            municipalities.forEach(municipality => {
                municipalityDropdown.innerHTML += `<option value="${municipality}">${municipality}</option>`;
            });
        }
    }

    // Function to populate the barangay dropdown
    function populateBarangay() {
        const province = provinceDropdown.value;
        const municipality = municipalityDropdown.value;
        if (province && municipality && data[province][municipality]) {
            const barangays = data[province][municipality];
            barangayDropdown.innerHTML = '<option value="" selected disabled>Select Barangay</option>'; // Reset barangay dropdown
            barangays.forEach(barangay => {
                barangayDropdown.innerHTML += `<option value="${barangay}">${barangay}</option>`;
            });
        }
    }

    // Event listeners to update options when the user selects a province or municipality
    provinceDropdown.addEventListener("change", () => {
        populateMunicipality();
        barangayDropdown.innerHTML = '<option value="" selected disabled>Select Barangay</option>'; // Reset barangay
    });

    municipalityDropdown.addEventListener("change", populateBarangay);
</script>

<style>
    /* Reset styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Times New Roman', Times, serif;
        background-color: #ffffff;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    /* Header styles */
    .header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        padding: 15px 5%;
        background: #00abf0;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        z-index: 100;
    }

    .header-title {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .header-title .title-line1 {
        font-size: 24px;
        font-weight: 700;
        color: blue;
        text-shadow: 2px 2px 4px white;
    }

    .header-title .title-line2 {
        font-size: 32px;
        font-weight: 700;
        color: white;
        text-shadow: 2px 2px 4px black;
    }

    /* Navigation links styling */
    .nav-links {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .nav-links a {
        font-size: 16px;
        color: #ededed;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .nav-links a:hover,
    .nav-links a.active {
        color: blue;
    }

    .signup-container {
        width: 100%;
        max-width: 480px;
        margin: auto;
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .signup-container input,
    .signup-container select {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 14px;
        background-color: #f9f9f9;
    }

    .signup-container button {
        width: 100%;
        padding: 14px;
        margin-top: 15px;
        font-size: 16px;
        color: white;
        background-color: #00bfff;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .signup-container button:hover {
        background-color: #009ad6;
    }

    .signup-container h3 {
        font-size: 20px;
        font-weight: 600;
        color: #00abf0;
        margin-bottom: 15px;
    }

    .name-container {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .form-group {
        margin-bottom: 10px;
    }

    .form-wide {
        width: 100%;
    }
    .nav-links a::after {
            content: '';
            display: block;
            width: 0;
            height: 2px;
            background: blue;
            transition: width .3s;
            position: absolute;
            left: 0;


            bottom: -5px;
        }

        .nav-links a:hover::after {
            width: 100%;
        }
.tooth-icon {
            width: 60px;
            height: 60px;
            margin-right: 10px;
        }

        .signup-container a {
            color: #2660b7;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 10px;
        }

        .label {
            font-weight: bold;
            margin-bottom: 5px; /* Add spacing between label and input */
            display: block; /* Ensure label takes full width */
        }
.name-input {
            width: 48%; /* Set width to 48% to allow space between fields */
        }

        .name-input input {
            width: 100%; /* Make the input fill the container */
        }

    /* Responsive design */
    @media (max-width: 768px) {
        .header {
            padding: 10px 5%;
            flex-direction: column;
            align-items: center;
        }

        .header-title {
            text-align: center;
        }

        .header-title .title-line1 {
            font-size: 20px;
        }

        .header-title .title-line2 {
            font-size: 28px;
        }

        .nav-links {
            justify-content: center;
        }

        .nav-links a {
            font-size: 14px;
        }

        .signup-container {
            padding: 15px;
        }

        .signup-container h3 {
            font-size: 18px;
        }
    }

    @media (max-width: 480px) {
        .header-title .title-line1 {
            font-size: 16px;
        }

        .header-title .title-line2 {
            font-size: 24px;
        }

        .nav-links a {
            font-size: 12px;
        }

        .signup-container {
            padding: 10px;
        }

        .signup-container input,
        .signup-container select,
        .signup-container button {
            font-size: 12px;
            padding: 10px;
        }

        .signup-container h3 {
            font-size: 16px;
        }

        .name-container {
            gap: 8px;
        }
    }
</style>

</body>
</html>
