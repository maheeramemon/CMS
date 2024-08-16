<?php
session_start();
$servername = "localhost";
$username = "root";
$password = '';
$dbname = "clubDB";

$user_id = $_SESSION['utd_id'];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//$user_id = 2021519409;

$sql = "
    SELECT Club.Club_ID, Club.Club_Name, Club.ClubDescription, Club.ClubType, Board_Of.Club_Position
    FROM Club
    JOIN Member_Of ON Club.Club_ID = Member_Of.Club_ID
    LEFT JOIN Board_Of ON Member_Of.Member_ID = Board_Of.Member_ID
    WHERE Member_Of.MemberUTD_ID = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Clubs</title>
    <style>
        body {
            font-family: Georgia, sans-serif;
        }
        .header {
            padding: 60px;
            text-align: center;
            background: darkorange;
            color: white;
            font-size: 18px;
        }
        .club-list {
            width: 80%;
            margin: auto;
            padding: 30px;
            border: 10px solid #ccc;
            border-radius: 50px;
        }
        .club-list h3 {
            text-align: center;
            text-decoration: underline;
        }
        .club {
            border: 2px solid #ccc;
            border-radius: 10px;
            padding: 15px;
            margin: 15px 0;
        }
        .club label {
            display: block;
            font-weight: bold;
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
    <div class="header">
        <h1>The University of Texas at Dallas</h1>
        <h3>UTDCMS - My Clubs</h3>
    </div>
    <br><br>
    <div class="club-list">
        <h3>Current Clubs</h3>';

    while ($row = $result->fetch_assoc()) {
        echo '<div class="club">
            <label>Club ID:</label>
            <span>' . $row["Club_ID"] . '</span>
            <label>Club Name:</label>
            <span>' . $row["Club_Name"] . '</span>
            <label>Club Description:</label>
            <span>' . $row["ClubDescription"] . '</span>
            <label>Club Type:</label>
            <span>' . $row["ClubType"] . '</span>
            <label>Membership / Officer Title:</label>
            <span>' . ($row["Club_Position"] ?? 'Member') . '</span>
        </div>';
    }

    echo '</div>

</body>
</html>';

} else {
    echo "No clubs found for the given user.";
}

$conn->close();
?>

<button onclick= "document.location.href = 'StudentLandingPage.php';" id="button" >Go back</button>

