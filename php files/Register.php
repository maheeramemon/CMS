<?php
$servername = "localhost";
$username = "root";
$password = '';
$dbname = "clubdb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $utd_id = $conn->real_escape_string($_POST['utd_id']);
    $net_id = $conn->real_escape_string($_POST['net_id']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $major = $conn->real_escape_string($_POST['major']);
    $year = $conn->real_escape_string($_POST['year']);
    $password = $conn->real_escape_string($_POST['password']);
    $c_password = $conn->real_escape_string($_POST['c_password']);

    // Check if passwords match
    if ($password != $c_password) {
        die("Passwords do not match.");
    }

    // Hash the password
    //$hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $utd_id = intval($utd_id);
    $year = intval($year);

    // Insert data into the Person table
    $sql_person = "INSERT INTO Person (utd_id, net_id, name, email, major, password) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_person = $conn->prepare($sql_person);
    $stmt_person->bind_param("isssss", $utd_id, $net_id, $name, $email, $major, $password);

    if ($stmt_person->execute()) {
        // Insert data into the Student table
        $sql_student = "INSERT INTO Student (utd_id, year) VALUES (?, ?)";
        $stmt_student = $conn->prepare($sql_student);
        $stmt_student->bind_param("ii", $utd_id, $year);

        if ($stmt_student->execute()) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $sql_student . "<br>" . $conn->error;
        }
        $stmt_student->close();
    } else {
        echo "Error: " . $sql_person . "<br>" . $conn->error;
    }

    $stmt_person->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <style>
        body {
            font-family: Georgia, sans-serif;
            background-color: white;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .User-Register {
            width: 1000px;
            margin: auto;
            margin-top: 40px;
            padding: 30px;
            border: 10px solid #ccc;
            border-radius: 60px;
        }

        .UTD_Header {
            width: 960px;
            height: 1vh;
            background-color: #df5d00;
            justify-content: space-between;
            color: white;
            padding: 40px;
            font-size: 18px;
            font-weight: bold;
            text-align: left;
            margin: auto;
            display: flex;
        }

        .User-Register h3 {
            text-align: center;
            text-decoration: underline;
        }

        .User-Register label {
            display: block;
            margin-top: 10px;
        }

        .User-Register input[type="text"],
        .User-Register input[type="password"] {
            width: 98%;
            padding: 8px;
            margin-top: 7px;
            border: 2px solid #ccc;
            border-radius: 10px;
        }

        .User-Register input[type="submit"] {
            width: 100%;
            padding: 5px;
            margin-top: 20px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }

        .User-Register input[type="submit"]:hover {
            background-color: darkgreen;
        }

        button {
            width: 100%;
            padding: 5px;
            margin-top: 20px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: auto;}
    </style>
</head>
<body>
    <div class="UTD_Header">
        <span>THE UNIVERSITY OF TEXAS AT DALLAS</span>
        <span>UTDCMS</span>
    </div>

    <div class="User-Register">
        <h3>Register</h3>
        <form action="register.php" method="post">
            <label for="utd_id">UTD ID</label>
            <input type="text" id="utd_id" name="utd_id" placeholder="Enter your UTD ID" required>

            <label for="net_id">Net ID</label>
            <input type="text" id="net_id" name="net_id" placeholder="Enter your Net ID" required>

            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your Name" required>

            <label for="email">Email</label>
            <input type="text" id="email" name="email" placeholder="Enter your Email" required>

            <label for="major">Major</label>
            <input type="text" id="major" name="major" placeholder="Enter your Major" required>

            <label for="year">Year</label>
            <input type="text" id="year" name="year" placeholder="Enter your year" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <label for="c_password">Confirm your password</label>
            <input type="password" id="c_password" name="c_password" placeholder="Confirm your password" required>

            <input type="submit" value="Register">
        </form>

        <button onclick= "document.location.href = 'LandingPage.php';" id="button" >Go back</button>
        <button onclick= "document.location.href = 'Login.php';" id="button" >Already have an account?</button>
    </div>
</body>
</html>
