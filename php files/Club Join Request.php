<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Club Join Request</title>
    <style>
        body {
            font-family: Georgia, sans-serif;
            background-color: white;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .Club_Request {
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

        .Club_Request h3 {
            text-align: center;
            text-decoration: underline;
        }
        .Club_Request label {
            display: block;
            margin-top: 10px;
        }
        .Club_Request input[type="text"] {
            width: 98%;
            padding: 8px;
            margin-top: 7px;
            border: 2px solid #ccc;
            border-radius: 10px;
        }
        .Club_Request input[type="submit"] {
            width: 100%;
            padding: 5px;
            margin-top: 20px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: auto;
        }
        .Club_Request input[type="submit"]:hover {
            background-color: green;
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
<div class="Club_Request">
    <h3>Request to Join a Club Form</h3>
    <form action="" method="post">
        <label for="utdid">UTD ID:</label>
        <input type="text" id="utdid" name="utdid" placeholder="Enter UTD ID"><br>
        <label for="clubs">Club ID:</label>
        <input type="text" id="clubs" name="clubid" placeholder="Enter Club ID"><br>
        <input type="submit" value="Submit">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $utdid = $_POST['utdid'];
        $clubid = $_POST['clubid'];

        $connection = mysqli_connect("localhost", "root", '', "clubdb");
        

        if (!$connection) {
            die("Could not connect: " . mysqli_connect_error());
        }

     
        $sql = "INSERT INTO member_of (MemberUTD_ID, Club_ID) VALUES (? , ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param ("ii", $utdid, $clubid);

        if ($stmt->execute())
        {
         $result = $stmt->get_result();
            echo "Joined";
        }
        else
        {
            echo "Error";
        }

        $stmt -> close();
        mysqli_close($connection);
       
    }
    ?>

    <button onclick= "document.location.href = 'StudentLandingPage.php';" id="button" >Go back</button>
</div>
</body>
</html>