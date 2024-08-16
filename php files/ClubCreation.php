
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Creation</title>
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
        .Club-Create {
            width: 400px;
            margin: auto;
            padding: 30px;
            border: 10px solid #ccc;
            border-radius: 50px;
        }
        .Club-Create h3 {
            text-align: center;
            text-decoration: underline;
        }
        .Club-Create label {
            display: block;
            margin-top: 10px;
        }
        .Club-Create input[type="text"], .Club-Create input[type="Club_Name"] {
            width: 90%;
            padding: 8px;
            margin-top: 7px;
            border: 2px solid #ccc;
            border-radius: 10px;
        }
        .Club-Create input[type="submit"] {
            width: 95%;
            padding: 5px;
            margin-top: 20px;
            background-color: orange;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: auto;
        }
        .Club-Create input[type="submit"]:hover {
            background-color: #45a049;
        }
        .dropdown {
          position: relative;
          display: inline-block;
        }

        .dropdown-content {
          display: none;
          position: absolute;
          background-color: #f9f9f9;
          min-width: 160px;
          box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
          padding: 12px 16px;
          z-index: 1;
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
      <h3>UTDCMS</h3>
    </div>
    <br></br>
    <br></br>
    
<div class="Club-Create">

    <button onclick= "document.location.href = 'StudentLandingPage.php';" id="button" >Go back</button>
    <h3>Club Creation Form</h3>
    <form action="" method="post">
        <label for="club_name">Club Name</label>
        <input type="text" id="club_name" name="club_name" placeholder="Enter Club Name">

        <label for="club_id">Club ID</label>
        <input type="number" id="club_id" name="club_id" placeholder="Enter Club ID">

        <label for="club_num">Number of Members </label>
        <input type="number" id="club_num" name="club_num" placeholder="Enter Number of members">


        <label for="club_date">Date of Establishment (write it as MMDDYYYY)</label>
        <input type="number" id="club_date" name="club_date" placeholder="Enter date of Establishment">


        <label for="club_type">Club Type</label>
        <input type="text" id="club_type" name="club_type" placeholder="Enter Club Type">

        <label for="club_description">Club Description</label>
        <input type="text" id="club_description" name="club_description" placeholder="Enter Description">
      

        <label for="recruitment_status">Recruitment Status
           <label for="Active"><input type="radio" id="active" name="recruitment_status" value="1">
          Active</label>
             <label for="Closed"><input type="radio" id="closed" name="recruitment_status" value="0">
         Closed</label>
          
        
        <label for="advisor">Faculty Advisor UTD_ID</label>
        <input type="number" id="advisor" name="advisor" placeholder="Enter Advisor UTD_ID">
      

        <label for="department">Department ID</label>
        <input type="number" id="department" name="department" placeholder="Enter Department ID">

        

        <input type="submit" value="Create Club">
    </form>

   
</div>


</body>
</html>

<?php
session_start();

$servername = "localhost";
$username = "root";
$password = '';
$dbname = "clubDB";

$club_name = $_POST['club_name'];
$club_id = $_POST['club_id'];
$club_num = $_POST['club_num'];
$club_date = $_POST['club_date'];
$club_type = $_POST['club_type'];
$club_description = $_POST['club_description'];
$recruitment_status = $_POST['recruitment_status'];
$advisor = $_POST['advisor'];
$department = $_POST['department'];
$uid = $_SESSION['utd_id'];
$member_id = '';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "insert into club(Club_ID, Club_Name, No_Members, DateOfEstablishment, ClubDescription, ClubType, Recruitment_Status, Department_ID, Faculty_ID) 
values (?,?,?,?,?,?,?,?,?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isiissiii",$club_id, $club_name,$club_num,$club_date,$club_description,$club_type,$recruitment_status,$department, $advisor);
    if ($stmt->execute())
    {
        $result = $stmt->get_result();
        echo "New Club Created";
    }
    else
    {
        echo "Error";
    }
    $stmt -> close();
    $sql2 = "INSERT INTO member_of (MemberUTD_ID, Club_ID) VALUES (? , ?)";
    $stmt2 =  $conn->prepare($sql2);
    $stmt2->bind_param ("ii", $uid, $club_id);

        if ($stmt2->execute())
        {
         $result = $stmt2->get_result();
            echo "Joined";
        }
        else
        {
            echo "Error";
        }

        $stmt2 -> close();

        $conn -> close();

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    $sql3 = "SELECT Member_ID FROM member_of WHERE MemberUTD_ID = ? and Club_ID = ?";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->bind_param('ii', $uid, $club_id);
    
    if ($stmt3->execute()) {
        $result = $stmt3->get_result();
        $row = $result->fetch_assoc();
        $member_id = $row ? $row['Member_ID'] : null;
    
     
    
        if ($member_id === null) {
            die("Error: Member_ID not found.");
        }
        
    } else {
        echo "Error.";
    }
    
    $stmt3->close();

      

        $sql4 = "INSERT INTO board_of (Member_ID, Club_Position) VALUES (? , 'President')";
        $stmt4 =  $conn->prepare($sql4);
        $stmt4->bind_param ("i", $member_id);
    
            if ($stmt4->execute())
            {
             $result = $stmt4->get_result();
                echo "Joined";
            }
            else
            {
                echo "Error";
            }
    
         $stmt4 -> close();
        

    
    $conn -> close();

?>