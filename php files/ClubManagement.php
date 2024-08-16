<?php
session_start();

$servername = "localhost";
$username = "root";
$password = '';
$dbname = "clubdb";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$user_id = $_SESSION['utd_id'];

$sqlc = "SELECT club_position
        FROM board_of b
        JOIN member_of m ON m.member_id = b.member_id
        WHERE m.memberutd_id = ?";
$stmtc = $conn->prepare($sqlc);
$stmtc->bind_param("i", $user_id);
$stmtc->execute();
$resultc = $stmtc->get_result();

$is_president = false;
while ($rowc = $resultc->fetch_assoc()) {
    if ($rowc['club_position'] == 'President') {
        $is_president = true;
        break;
    }
}
$stmtc->close();

if (!$is_president) {
    die("Access Denied. Only the President can manage members.");
}


$members = [];
$club_id = 0;


$sql2 = "SELECT club_id FROM member_of WHERE memberutd_id = ?";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param('i', $user_id);

if ($stmt2->execute()) {
    $result2 = $stmt2->get_result();
    $row2 = $result2->fetch_assoc();
    $club_id = $row2['club_id'];

    if ($club_id === null) {
        die("Error: Club_ID not found.");
    }
} else {
    die("Error fetching club ID.");
}

$stmt2->close();


$sql = "SELECT DISTINCT p.utd_id, p.name 
        FROM Person p
        JOIN member_of m ON p.utd_id = m.memberutd_id
        WHERE m.club_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $club_id);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $members[] = $row;
    }
} else {
    die("Error fetching members.");
}
$stmt->close();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_member_id'])) {
    $new_member_id = $_POST['new_member_id'];

    $add_member_query = "INSERT INTO member_of (memberutd_id, club_id) VALUES (?, ?)";
    $add_member_stmt = $conn->prepare($add_member_query);
    $add_member_stmt->bind_param("ii", $new_member_id, $club_id);

    if ($add_member_stmt->execute()) {
        echo "Member added successfully.";
    } else {
        echo "Error adding member: " . $add_member_stmt->error;
    }
    $add_member_stmt->close();

    header("Location: ClubManagement.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_member_id'])) {
    $remove_member_id = $_POST['remove_member_id'];
    $remove_member_query = "DELETE FROM member_of WHERE memberutd_id = ? AND club_id = ?";
    $remove_member_stmt = $conn->prepare($remove_member_query);
    $remove_member_stmt->bind_param("ii", $remove_member_id, $club_id);

    if ($remove_member_stmt->execute()) {
        echo "Member removed successfully.";
    } else {
        echo "Error removing member: " . $remove_member_stmt->error;
    }
    $remove_member_stmt->close();

    header("Location: ClubManagement.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Management</title>
    <style>
        body {
            font-family: Georgia, sans-serif;
            background-color: white;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        table, td, tr {
            border: 2px solid grey;
            padding: 5px;
            margin: auto;
        }

        .Club-Manage {
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

        .Club-Manage h3 {
            text-align: center;
            text-decoration: underline;
        }

        .Club-Manage label {
            display: block;
            margin-top: 10px;
        }

        .Club-Manage input[type="text"], .Club-Manage input[type="password"] {
            width: 98%;
            padding: 8px;
            margin-top: 7px;
            border: 2px solid #ccc;
            border-radius: 10px;
        }

        .Club-Manage input[type="submit"] {
            width: 100%;
            padding: 5px;
            margin-top: 20px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: auto;
        }

        .Club-Manage input[type="submit"]:hover {
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

    <div class="Club-Manage">
        <h3>Club Management</h3>

        <table style="width:100%">
            <tr>
                <th>UTD_ID</th>
                <th>Name</th>
            </tr>
            <?php foreach ($members as $member): ?>
            <tr>
                <td><?php echo htmlspecialchars($member['utd_id']); ?></td>
                <td><?php echo htmlspecialchars($member['name']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <form action="ClubManagement.php" method="post">
            <label for="new_member">Add new member</label>
            <input type="text" id="new_member" name="new_member_id" placeholder="Add new member">
            <input type="submit" value="Add member">
        </form>

        <form action="ClubManagement.php" method="post">
            <label for="remove_member">Remove member</label>
            <input type="text" id="remove_member" name="remove_member_id" placeholder="Remove member">
            <input type="submit" value="Remove member">
        </form>

        <button onclick= "document.location.href = 'StudentLandingPage.php';" id="button" >Go back</button>
    </div>
</body>
</html>
