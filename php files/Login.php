<?php

session_start();
$servername = "localhost";
$username = "root"; 
$password = ''; 
$dbname = "clubdb";
$utd_id = '';
$u_password = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $utd_id = $_POST['utd_id'];
    $u_password = $_POST['password'];
}


$connection = mysqli_connect($servername, $username, $password , $dbname);
if(!$connection)
    die("could not connect".mysqli_connect_error());
else
    $sql = "SELECT * FROM Person WHERE UTD_ID = ? ";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $utd_id);
    $stmt->execute();
    $result = $stmt->get_result();
    //$result = $connection->query($sql);
   
    
        $row = $result ->fetch_assoc();
        if ($row != null) {
        if ($u_password === $row['Password']) {

            $_SESSION['utd_id'] = $row['UTD_ID'];

            header('Location: StudentLandingPage.php');

            
            exit();
        } else {
            $error = "Invalid password. Please try again.";
            echo 'Invalid password. Please try again.'; 
        }
    }
    
    
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Georgia, sans-serif;
            background-color: white;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .User-Login {
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
            margin:auto;
            display: flex;
        }

        .User-Login h3 {
            text-align: center;
            text-decoration: underline;
        }
        .User-Login label {
            display: block;
            margin-top: 10px;
        }
        .User-Login input[type="text"], .User-Login input[type="password"] {
            width: 98%;
            padding: 8px;
            margin-top: 7px;
            border: 2px solid #ccc;
            border-radius: 10px;
        }
        .User-Login input[type="submit"] {
            width: 100%;
            padding: 5px;
            margin-top: 20px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: auto;
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
    <span>UTDCMS </span>
</div>
<div class="User-Login">
    <h3>User Login</h3>
    <form action="" method="post">
        <label for="utd_id">UTD ID</label>
        <input type="text" id="utd_id" name="utd_id" placeholder="Enter your UTD ID">

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password">

        <input type="submit" value="Log In">
    </form>

    <button onclick= "document.location.href = 'LandingPage.php';" id="button" >Go back</button>
    <button onclick= "document.location.href = 'Register.php';" id="button" >New? Register</button>
</div>
</body>
</html>